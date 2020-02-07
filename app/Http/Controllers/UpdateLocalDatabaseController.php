<?php

namespace App\Http\Controllers;

use App\Stock;
use Carbon\Carbon;
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


            if ($device == "REFERENCES") {
                self::updateDeviceStocks($device);
            }

            if ($result) {
                return redirect('/dashboard');
            }else{
                return redirect('/dashboard')->withErrors(['msg'=>"Database loading failed."]);
            }
        }else{
            return redirect('/dashboard')->withErrors(['msg'=>"Database loading failed."]);
        }

        
    }


    public static function updateDeviceStocks($device)
    {
        //do removung and adding here
        // check item catalog for new and removed items

        $itemCatalog = ItemCatalogController::getItems();
        $stocks = StockController::getStock(null,null,env("DB_CONFIG_" . env('DEVICE_CODE')));

        $addingResult = null;
        $deletingResult = null;
        $itemCatalogNumbers = array();
        $stockItemNumbers = array();

        foreach ($itemCatalog as $value) {
            $itemCatalogNumbers[] = $value->id;
        }

        foreach ($stocks as $value) {
            $stockItemNumbers[] = $value->itemno;
        }


        //if count(itemVRedor) is > 1, there are added items
        $itemVStocks = array_diff($itemCatalogNumbers,$stockItemNumbers);
        $added = array();
        foreach ($itemVStocks as $value) {
            $added[] = $value;
        }

        //if count(redorVItem) is > 1, there are deleted items
        $stocksVItem = array_diff($stockItemNumbers,$itemCatalogNumbers);

        $deleted = array();
        foreach ($stocksVItem as $value) {
            $deleted[] = $value;
        }

        $hasDeleted = count($stocksVItem) > 0;
        $hasAdded = count($itemVStocks) > 0;


        if (count($added) != 0) {
            $toAdd = array();

            foreach ($added as $value) {
                $toAdd[] = ['itemno'=>$value,'qty'=>0,'updated_at'=>Carbon::now()];
            }

            $addResult = RGMCSFactory::insertRows(new Stock(),env('DB_CONFIG_' . env('DEVICE_CODE')),$toAdd);
            if ($addResult > 0) {
                $addingResult = true;
            }
        }


        if (count($deleted) != 0) {
            $toDelete = array();
            foreach ($deleted as $value) {
                $toDelete[] = ['itemno'=>$value];
            }

            foreach ($toDelete as $value) {
                $deleteResult = RGMCSFactory::deleteRows(new Stock(),env('DB_CONFIG_' . env('DEVICE_CODE')),$value);
            }
        }
    }


}
