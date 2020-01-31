<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Symfony\Component\Process\Process;
use Spatie\Dropbox\Client;

class UpdateLocalDatabaseController extends Controller
{
    protected $command;
    protected $userName;
    protected $passWord;
    protected $dbName;
    protected $path;
    protected $previousBackupCode;
    protected $deviceCode;

    
    public function __construct($deviceCode = null)
    {
        $this->setDeviceCode($deviceCode);
        $result = DatabaseHistoryController::getHistory($this->deviceCode);

        if ($result != false) {
            $this->setPreviousBackupCode($result->backUpCode);
        }else{
            $this->setPreviousBackupCode("");
        }
    }

    public function setDeviceCode($value = null)
    {
        if ($value == null) {
            $this->deviceCode = env('DEVICE_CODE');
        }else{
            $this->deviceCode = $value;
        }
    }

    public function setPreviousBackupCode($value)
    {
        $this->previousBackupCode = $value;
        return $this;
    }

    public function setCommand()
    {
        if ($this->path != false) {
            $this->command = env('LOAD_DUMP_PATH') . "/mysql" . " -u {$this->userName} {$this->dbName} < {$this->path}";
        }else{
            $this->command = false;
        }
        return $this;
    }

    public function setUserName($value)
    {
        $this->userName = $value;
        return $this;
    }

    public function setPassWord($value = '')
    {
        $this->passWord = $value;
        return $this;
    }

    public function setDbName($value)
    {
        $this->dbName = $value;
        return $this;
    }


    public function setPath($value)
    {
        if (file_exists($value)) {
            $this->path = $value;
        }else{
            $this->path = false;
        }
        
        return $this;
    }

    public function run()
    {
        if ($this->command != false) {
            $process = Process::fromShellCommandline($this->command);
            $process->run();

            $newBackUpCode  = DatabaseHistoryController::getHistory($this->deviceCode);

            if ($newBackUpCode != $this->previousBackupCode) {
                return true;
            }else{
                return false;
            }
        }else{
            return false;
        }
        
    }

    protected function downloadFromDropBox($path)
    {
        $client = new Client(env('DROPBOX_API_V2_ACCESS_TOKEN'));
        $return = $client->download($path);
        
        if ($return != null) {
            $file_result = file_put_contents(storage_path() . $path,$return);
            if ($file_result != false) {
                if ($file_result > 0 ) {
                    return true;
                }else{
                    return false;
                }
            }else{
                return false;
            }
        }else{
            return false;
        }
    }

    public static function updateLocal($deviceCode)
    {
        $device = $deviceCode;

        $updater = new UpdateLocalDatabaseController($device);

        $dbName = strtolower("RGMCS_" . $updater->deviceCode . "_DB");

        $file = $updater->downloadFromDropBox("/" . $dbName . ".sql");

        if ($file) {
            $result = $updater->setDbName($dbName)
            ->setUserName(env('DB_USERNAME'))
            ->setPassWord(env('DB_PASSWORD'))
            ->setPath(storage_path() . "/" . $dbName . ".sql")
            ->setCommand()
            ->run();

            if ($result) {
                return redirect('/dashboard');
            }else{
                return redirect('/dashboard')->withErrors(['msg'=>"Database loading failed."]);
            }
        }else{
            return redirect('/dashboard')->withErrors(['msg'=>"Database loading failed."]);
        }

        
    }


}
