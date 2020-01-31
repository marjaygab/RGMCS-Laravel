<?php

namespace App\Http\Controllers;

use App\DatabaseHistory;
use Illuminate\Http\Request;
use Spatie\Dropbox\Client;
use Spatie\DbDumper\Databases\MySql;
use Symfony\Component\Process\Process;

class BackupDatabaseController extends Controller
{

    public function index(Request $request)
    {
        return view('backup');
    }

    public function backupDetails(Request $request)
    {
        return view('backupdetails');
    }

    public function backupDatabase(Request $request)
    {
        $deviceCode = env('DEVICE_CODE');
        if ($deviceCode == null) {
            return back()->withErrors(['msg'=>"Current device does not exists."]);
        }else{
            if ($deviceCode == "RENES_ADMIN") {
                $deviceCode = "REFERENCES";
            }else{
                $deviceCode = env('DEVICE_CODE');
            }

            if (env('DEVICE_CODE') == "RENES_ADMIN") {
                $dbName = strtolower("RGMCS_REFERENCES_DB.sql");
            }else{
                $dbName = strtolower("RGMCS_" . env('DEVICE_CODE') ."_DB.sql");
            }

            $result = DatabaseHistoryController::setHistory(env('DB_CONFIG_' . $deviceCode));                
                    
            if ($result > 0) {
                $contents = $this->dumpDB();
                if ($contents != null) {
                    $result = $this->uploadtoDropBox($contents,$dbName);
                    if ($result) {
                        return redirect('/backup/details');
                    }else{
                        return redirect('/dashboard')->withErrors(['msg'=>"Database backup failed."]);
                    }
                }else{
                    return redirect('/dashboard')->withErrors(['msg'=>"Failed to create backup file"]);
                }
            }else{
                return redirect('/dashboard')->withErrors(['msg'=>"Database backup failed."]);
            }

        }
    }

    protected function uploadtoDropBox($contents,$path)
    {
        $client = new Client(env('DROPBOX_API_V2_ACCESS_TOKEN'));
        $return = $client->upload('/' . $path,$contents,'overwrite');
        return $return != null;
    }



    protected function dumpDB()
    {
        if (env('DEVICE_CODE') == "RENES_ADMIN") {
            $dbName = strtolower("RGMCS_REFERENCES_DB");
        }else{
            $dbName = strtolower("RGMCS_" . env('DEVICE_CODE') ."_DB");
        }

        $handler = fopen(storage_path('credentials.txt'),"w+");

        $client = MySql::create()
        ->setDbName($dbName)
        ->setUserName(env('DB_USERNAME'))
        ->setPassword(env('DB_PASSWORD'))
        ->setDumpBinaryPath(env('LOAD_DUMP_PATH'));

        $credentials = $client->getContentsOfCredentialsFile();
        fwrite($handler,$credentials);
        $temporaryCredentialsFile = stream_get_meta_data($handler)['uri'];

        $command = $client->getDumpCommand(storage_path() . "/" .  $dbName . ".sql",$temporaryCredentialsFile);

        $process = Process::fromShellCommandline($command,null,null,null);
        $process->run();

        
        if (file_exists(storage_path() . "/" .  $dbName . ".sql")) {
            return file_get_contents(storage_path() . "/" .  $dbName . ".sql");
        }else{
            return null;
        }

    }
    
}
