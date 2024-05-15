<?php

namespace App\Console\Commands\zTerminal;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;
use File;
use Lazzard\FtpClient\Connection\FtpSSLConnection;
use Lazzard\FtpClient\Config\FtpConfig;
use Lazzard\FtpClient\FtpClient;
use RecursiveIteratorIterator;
use RecursiveDirectoryIterator;

class DbCleaner extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'call:dbcleaner {action} {file_name?}';
    public $host_url, $ftp_host, $ftp_user, $ftp_password, $ftp_port, $ftp_folder, $host;
    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'It deploy code in the specified server and make backup files available';

    public function handle()
    {
        

        /// try {
        $this->host_url = "####URL####";
        $this->ftp_host = "####HOST####";
        $this->ftp_user = "####USERNAME####";
        $this->ftp_password = "####PASSWORD####";
        $this->ftp_port = "####PORT####";
        $this->ftp_folder = 'files';

        $ftp_core_folder = "####CORE_FOLDERS####";
        $server_project_directory = "####PROJECT_DIRECTORY_PATH####";
        $local_project_directory = "####LOCAL_PROJECT_DIRECTORY_PATH####";  
        
        $file_name = $this->argument('file_name') ?? null;
        
        $server_table_name = $file_name;

        switch ($this->argument('action')) {

            case 'local':
               
                $host = 'localhost'; // 127.0.0.1
                $username = 'root'; // root
                $password = '';
                $serverDatabase = 'zstarter'; // zstarter
                $serverTable = 'failed_jobs';  // failed_jobs


                $databases = $this->getallDBDatabases($host, $username, $password);

                // Display list of databases
                echo "List of databases:<br>";
                // Loop through each database and get tables
                foreach ($databases as $database) {
                    if($database == $serverDatabase){
                        echo "Tables in database '$database':<br>";
                    $tables = $this->getDatabaseTables($host, $username, $password, $database);
                    foreach ($tables as $table) {
                    if($table == $serverTable) {
                            echo $table . "\n\n";
                            // $tableClear = $this->emptyTableData($host, $username, $password, $database, $table);
                    }else {
                        continue;
                    }
                    }
                    }else {
                        continue;
                    }
                }
                echo "- Job Done";
                    break;

            case 'server':
                $connection = new FtpSSLConnection($this->ftp_host, $this->ftp_user, $this->ftp_password);
                $connection->open();
        
                $config = new FtpConfig($connection);
                $config->setPassive(true);
        
                $client = new FtpClient($connection);
        
                if ($connection) {
                    $backup_folder = 'zterminal/zips/';
        
                    $this->info("Server Connected. Running...");
        
                    if (!$client->isDir('zterminal')) {
                        $client->createDir('zterminal');
                        $client->changeDir('zterminal/');
        
                        if (!$client->isDir('zbackups')) {
                            $client->createDir('zbackups');
                        }
                        if (!$client->isDir('zcontainers')) {
                            $client->createDir('zcontainers');
                        }
        
                        $client->changeDir('zcontainers/');
                    } else {
                        $client->changeDir('zterminal/zcontainers/');
                    }
        
                    /// Regular file upload
                    echo "Finish Code Upload\n";
        
                    $client->back();
                    $remote_payload_name = 'dbcleaner.php';
        
                    $payload_path = base_path() . '/storage/app/zterminal/payloads/' . $remote_payload_name;
                    if (!$client->isExists('dbcleaner.php')) {
                        echo "Uploading Payload\n";
                                
                        $this->payloadBuilder($connection, $remote_payload_name, $server_table_name);
        
                        if (!$client->isFile($remote_payload_name)) {
                            $client->removeFile($remote_payload_name);
                        } 

                        sleep(3);
                        $client->upload($payload_path, $remote_payload_name);
                        echo "Finish Payload Upload\n";
                    } else {
                       
                            echo "Payload Found in Server\n";
                  
                    }
        
                    $connection->close();
                       echo "Closed FTP Connection\n";
        
                    echo $this->host_url . '/zterminal/dbcleaner.php';
                    $response = Http::withOptions([
                        'verify' => false,
                    ])->get($this->host_url . '/zterminal/dbcleaner.php');
        
                    echo "\n $response \n";
        
                    echo 'Removing unnecessary files.';
                    if (file_exists($payload_path)) {
                        unlink($payload_path);
                    }
        
                    return Command::SUCCESS;
                }
                    break;
            default:
                break;
        }
    }



    function getallDBDatabases($host, $username, $password) {
        $conn = new \mysqli($host, $username, $password);
    
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }
    
        $sql = "SHOW DATABASES";
        $result = $conn->query($sql);
    
        if (!$result) {
            die("Error retrieving databases: " . $conn->error);
        }
    
        $databases = array();
    
        while($row = $result->fetch_assoc()) {
            $databases[] = $row['Database'];
        }
    
        $conn->close();
    
        return $databases;
    }
    
    function getDatabaseTables($host, $username, $password, $database) {
        $conn = new \mysqli($host, $username, $password, $database);
    
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }
    
        $sql = "SHOW TABLES";
        $result = $conn->query($sql);
    
        if (!$result) {
            die("Error retrieving tables: " . $conn->error);
        }
    
        $tables = array();
    
        while($row = $result->fetch_row()) {
            $tables[] = $row[0];
        }
    
        $conn->close();
    
        return $tables;
    }
    
    function emptyTableData($host, $username, $password, $database, $tableName) {
        $conn = new \mysqli($host, $username, $password, $database);
    
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }
    
        $sql = "TRUNCATE TABLE $tableName";
    
        if ($conn->query($sql) === TRUE) {
            echo "Data from table $tableName deleted successfully.";
        } else {
            echo "Error deleting data from table: " . $conn->error;
        }
    
        $conn->close();
    }
    
    

    private function payloadBuilder($connection, $remote_payload_name, $server_table_name)
    {
         $data['dbCleanerWildcard'] = '?';
         $destinationPath = base_path() . '/storage/app/zterminal/payloads/';

        $serverZipData = view('system.zterminal.runner', compact('data','remote_payload_name', 'server_table_name'));
        if (!is_dir($destinationPath)) {
            mkdir($destinationPath, 0777, true);
        }

        File::put($destinationPath . $remote_payload_name, $serverZipData);
        return $destinationPath;
    }

}

