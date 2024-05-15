<?php

namespace App\Console\Commands\zTerminal;

use Illuminate\Console\Command;
use ZipArchive;
use Illuminate\Support\Facades\Http;
use File;
use Lazzard\FtpClient\Connection\FtpSSLConnection;
use Lazzard\FtpClient\Config\FtpConfig;
use Lazzard\FtpClient\FtpClient;
use Carbon\Carbon;
use RecursiveIteratorIterator;
use RecursiveDirectoryIterator;

class PDeployer extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'deploy:public {action?} {file_name?}';
    public $host_url, $ftp_host, $ftp_user, $ftp_password, $ftp_port, $ftp_folder, $host;
    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'It deploy code in the specified server and make backup files available';

    public function handle()
    {

        $compression_type = "tar";
        
        $retry = 0;
        /// try {
        $this->host_url = "####URL####";
        $this->ftp_host = "####HOST####";
        $this->ftp_user = "####USERNAME####";
        $this->ftp_password = "####PASSWORD####";
        $this->ftp_port = "####PORT####";
        $this->ftp_folder = 'files';

        $ftp_core_folder = "####CORE_FOLDERS####";
        $local_project_directory = "####LOCAL_PROJECT_DIRECTORY_PATH####";
        $server_project_directory = "__DIR__  . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR";
        $publicPath = $local_project_directory . '/public';
        
    
        $action = $this->argument('action');
        $file_names = $this->argument('file_name') ?? null;
        
        $rootPath = base_path(); 


        if (is_dir($rootPath."/.z")) {
            $this->removeFolder($rootPath."/.z");
        } 
        
       
       $ftp_debug = true;
       
    //    $local_folders = [####LOCAL_PUBLIC_FOLDERS####];
       
       if($file_names) {
        $local_folders =  explode(',', $file_names);
       }

       /// Check latest File Changes 
        if($action != "full"){
            $this->processFilesAndCopy($rootPath, $local_folders, $publicPath, $local_project_directory);
        }

       
        if (!extension_loaded('ftp')) {
            throw new \RuntimeException("FTP extension not loaded.");
        }

        ini_set('maximum_execution_time', 2500);
        if ($ftp_debug) {
            echo "Starting... \n";
        }

        ///     echo "
        ///         _____             _
        ///        |  __ \           | |
        ///     ___| |  | | ___ _ __ | | ___  _   _  ___ _ __
        ///    |_  / |  | |/ _ \ '_ \| |/ _ \| | | |/ _ \ '__|
        ///     / /| |__| |  __/ |_) | | (_) | |_| |  __/ |
        ///    /___|_____/ \___| .__/|_|\___/ \__, |\___|_|   v1.0.0 beta
        ///                    | |             __/ |
        ///                    |_|            |___/
        ///  ";

        if ($ftp_debug) {
            echo "\n";
        }
        if ($ftp_debug) {
            echo "\n";
        }


        if ($ftp_debug) {
            echo "Establishing Connection... \n";
        }
        $connection = new FtpSSLConnection($this->ftp_host, $this->ftp_user, $this->ftp_password);
        $connection->open();

        $config = new FtpConfig($connection);
        $config->setPassive(true);

        $client = new FtpClient($connection);


        $terminalCheckProjectId = terminalCheckProjectId($local_project_directory);
        if($terminalCheckProjectId == 0){
            echo "There is no project with this name in this system. Choose a new project and run the command!\n";
            return;
        }

        if ($connection) {
            if ($ftp_debug) {
                echo "Local folders ready.\n";
            }
 
            $backup_folder = 'zterminal/zips/';

            $this->info("Server Connected. Running...");

            $zip_name = 'deploy_container.zip';
            $tar_name = 'deploy_container';

            if ($compression_type == "tar") {
                if($action != "full"){
                    /// Smart Version
                    $zip_path = $this->makeSmartTar($local_folders, $tar_name, $rootPath."/.z", $ftp_debug);
                }else{
                    /// Standard Version
                    $zip_path = $this->makeStandardTar($local_folders, $tar_name, $publicPath, $ftp_debug);
                }
            } else {
                if($action != "full"){
                    $zip_path = $this->makeZip($local_folders, $backup_folder, $zip_name,$rootPath."/.z");
                }else {
                    $zip_path = $this->makeZip($local_folders, $backup_folder, $zip_name,$publicPath);
                }
            }


            sleep(5);
            $local_file_size = filesize($zip_path);


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

            echo 'INFO: Size ' . round($local_file_size / 1024 / 1024, 2) . "MB. Starting Code Upload\n";
            
            $remote_zip_path = basename($zip_path);
            $max_attempts = 10;
            $attempts = 0;
            
            /// Checking whether the remote directory exists and removing it if necessary
            if ($compression_type == "tar") {
                $remote_directory = $tar_name . ".tar.gz";
            } else {
                $remote_directory = $zip_name;
            }

            
            sleep(3);
          
            $this->ftpUpload($client, $zip_path, $remote_zip_path);
            echo "Finish Code Upload\n";

            $client->back();
            $remote_payload_name = 'deploy.php';

            $payload_path = base_path() . '/storage/app/zterminal/payloads/' . $remote_payload_name;
             // if (!$client->isExists('deploy.php')) {
                if ($ftp_debug) {
                    echo "Uploading Payload\n";
                }

                if ($compression_type == "tar") {
                    $this->payloadBuilder($connection, $local_folders, $remote_payload_name, $ftp_core_folder, $tar_name . ".tar.gz", $server_project_directory);
                } else {
                    $this->payloadBuilder($connection, $local_folders, $remote_payload_name, $ftp_core_folder, $zip_name, $server_project_directory);
                }

                // if (!$client->isFile($remote_payload_name)) {
                //     $client->removeFile($remote_payload_name);
                // } 
                sleep(3);
                $client->upload($payload_path, $remote_payload_name);
                echo "Finish Payload Upload\n";
            // } else {
            //     if ($ftp_debug) {
            //         echo "Payload Found in Server\n";
            //     }
            // }
            $connection->close();
            if ($ftp_debug) {
                echo "Closed FTP Connection\n";
            }


            echo $this->host_url . '/zterminal/deploy.php';
            $response = Http::withOptions([
                'verify' => false,
            ])->get($this->host_url . '/zterminal/deploy.php');

            echo "\n $response \n";

            echo 'Removing unnecessary files.';
            if (file_exists($payload_path)) {
                unlink($payload_path);
            }

            if (file_exists($zip_path)) {
                unlink($zip_path);
            }

            $currentTimestamp = \Carbon\Carbon::now();
            $dateString = $currentTimestamp->toDateTimeString();
            $timestamp = strtotime($dateString);

            $this->updateTerminalFile('TIMESTAMPS_PUBLIC', $timestamp, $local_project_directory);

            return Command::SUCCESS;
        } else {
            $this->error('Failed to connect to FTP server.');
        }
    }




   


    public function updateTerminalFile($key, $value, $local_project_directory){
        $terminal = $local_project_directory . '/terminal.z.txt';
        $php_array = include $terminal;
        $php_array[$key] = $value; 
        $php_code = "<?php\nreturn " . var_export($php_array, true) . ";\n";
        file_put_contents($terminal, $php_code);
        return $php_array[$key];
    }

    public function getTerminalFile($key, $local_project_directory){
        $terminal = $local_project_directory . '/terminal.z.txt';
        $file_code = file_get_contents($terminal);
        $php_array = include $terminal;
        $timestamps_core = $php_array[$key];
        return $timestamps_core;
    }

    public function single_config_key_update_name($key, $value)
    {
        $configFilePath = base_path() . '/config/lastDeployment.php'; // Adjust the path based on your project structure

        try {
            // Check if the file exists
            if (!file_exists($configFilePath)) {
                throw new Exception("Configuration file not found at: $configFilePath");
            }

            // Include the configuration file
            $config = include $configFilePath;

            // Check if the key exists before updating
            if (array_key_exists($key, $config)) {
                // Set the new value for the key
                $config[$key] = $value;

                // Save the changes to the configuration file
                $configContent = "<?php\nreturn " . var_export($config, true) . ";\n";
                file_put_contents($configFilePath, $configContent);

                // Optionally, you can return a success message or boolean
                return true; // or return 'Key updated successfully';
            } else {
                // Optionally, you can throw an exception or return an error message
                throw new Exception("Key '$key' not found in configuration");
                // or return "Key '$key' not found in configuration";
            }
        } catch (Exception $e) {
            // Handle exceptions if necessary
            return false; // or handle the exception based on your requirements
        }
    }

    private function payloadBuilder($connection, $local_folders, $remote_payload_name, $ftp_core_folder, $zip_name, $server_project_directory)
    {
         $data['deployWildcard'] = '?';
        $destinationPath = base_path() . '/storage/app/zterminal/payloads/';

        $serverZipData = view('system.zterminal.runner', compact('local_folders', 'data', 'remote_payload_name', 'ftp_core_folder', 'zip_name', 'server_project_directory'));
        if (!is_dir($destinationPath)) {
            mkdir($destinationPath, 0777, true);
        }

        File::put($destinationPath . $remote_payload_name, $serverZipData);
        return $destinationPath;
    }
 


    private function makeZip($local_folders, $backup_folder, $zip_name,$local_project_directory)
    {
        /// Ensure ZipArchive is available
        if (!class_exists('ZipArchive')) {
            throw new Exception('ZipArchive class does not exist.');
        }

        $zip = new ZipArchive();
        $backup_path = \Storage::path($backup_folder);

        if (!is_dir($backup_path)) {
            mkdir($backup_path, 0755, true); // Consider more secure permissions
        }

        $zip_path = \Storage::path('zterminal/zips/' . $zip_name);

        if ($zip->open($zip_path, ZipArchive::CREATE | ZipArchive::OVERWRITE) === true) {
            foreach ($local_folders as $local_folder) {
                $this->addFolderToZip($zip, $local_folder, $local_project_directory);
            }

            $zip->close();
            return $zip_path;
        } else {
            throw new Exception("Could not open or create the zip file.");
        }
    }

    private function addFolderToZip($zip, $folder, $base_path, $relative_path = '')
    {
        $relative_path = $relative_path . DIRECTORY_SEPARATOR . $folder;

        $files = File::allFiles($base_path . DIRECTORY_SEPARATOR . $relative_path);

        foreach ($files as $file) {
            if ($file->getFilename() === '.' || $file->getFilename() === '..') {
                continue;
            }

            $relative_file_path = $relative_path . DIRECTORY_SEPARATOR . $file->getFilename();

            if (is_dir($file->getRealPath())) {
                $this->addFolderToZip($zip, $file->getFilename(), $base_path, $relative_file_path);
            } else {
                $zip->addFile($file->getRealPath(), $relative_file_path);
            }
        }
    }


    private function ftpUpload($client, $zip_path, $remote_zip_path)
    {
        try {
            $client->upload($zip_path, $remote_zip_path);
            return true;
        } catch (\Throwable $throwable) {
            return false;
        }
    }

    private function makeStandardTar($directoryNames, $tarZipName, $basePath, $ftp_debug)
    {
        /// Define the directory to store the tar file
        $tarDirectory = storage_path('app/zterminal/tars/');

        /// Create the directory if it doesn't exist
        if (!is_dir($tarDirectory)) {
            mkdir($tarDirectory, 0755, true);
        }

        // Define the path for the tar file
        $tarZipPath = $tarDirectory . $tarZipName . '.tar.gz';

        /// Build the tar command
        $tarCommand = "tar -czvf " . escapeshellarg($tarZipPath) . " -C " . escapeshellarg($basePath) . " " . implode(' ', array_map('escapeshellarg', $directoryNames));

        $output = shell_exec($tarCommand);
        
        /// Check if the command executed successfully
        if ($output === null) {
            if ($ftp_debug) {
                echo "Tar command executed successfully!\n";
            }
        } else {
            /// Throw an exception if there's an error
            throw new \Exception("Error executing tar command. Output: $output");
        }
        return $tarZipPath;
    }

    private function makeSmartTar($directoryNames, $tarZipName, $basePath, $ftp_debug)
    {
        /// Define the directory to store the tar file
        $tarDirectory = storage_path('app/zterminal/tars/');

        /// Create the directory if it doesn't exist
        if (!is_dir($tarDirectory)) {
            mkdir($tarDirectory, 0755, true);
        }

        /// Define the path for the tar file
        $tarZipPath = $tarDirectory . $tarZipName . '.tar.gz';

        /// Build the tar command
        $tarCommand = "tar -czvf " . escapeshellarg($tarZipPath) . " -C " . escapeshellarg($basePath) . " " . implode(' ', array_map('escapeshellarg', $directoryNames));

        $output = shell_exec($tarCommand);
        
        /// Check if the command executed successfully
        if ($output === null) {
            if ($ftp_debug) {
                echo "Tar command executed successfully!\n";
            }
        } else {
            /// Throw an exception if there's an error
            throw new \Exception("Error executing tar command. Output: $output");
        }
        return $tarZipPath;
    }
    
    
    function removeFolder($folderPath)
{
    if (is_dir($folderPath)) {
        $files = scandir($folderPath);

        foreach ($files as $file) {
            if ($file != '.' && $file != '..') {
                $filePath = $folderPath . '/' . $file;

                if (is_file($filePath)) {
                    unlink($filePath);
                } elseif (is_dir($filePath)) {
                    $this->removeFolder($filePath);
                }
            }
        }

        rmdir($folderPath);
        ///     echo "Folder '$folderPath' has been removed.";
    } else {
        ///     echo "Folder '$folderPath' not found.";
    }
}

function processFilesAndCopy($rootPath, $arr, $local_directory, $local_project_directory)
{
    /// Step 1: Check if ".z" folder exists, if not, create it
    $zFolderPath = $rootPath . '/.z';
    if (!file_exists($zFolderPath)) {
        mkdir($zFolderPath);
    }

    foreach ($arr as $directory) {

        $directoryPath = $local_directory . DIRECTORY_SEPARATOR . $directory;

        $this->copyDirectory($directoryPath, $zFolderPath . '/' . $directory, $arr, $local_project_directory);
    }

    /// Step 4: Return true once it's done
    return true;
}

function copyDirectory($source, $destination, $arr, $local_project_directory)
{
    if (!file_exists($destination)) {
        mkdir($destination, 0777, true);
    }

    $iterator = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($source, RecursiveDirectoryIterator::SKIP_DOTS), RecursiveIteratorIterator::SELF_FIRST);

    foreach ($iterator as $item) {
        $subDirectory = $destination . DIRECTORY_SEPARATOR . $iterator->getSubPathName();

        if ($item->isDir() && in_array($item->getBasename(), $arr)) {
            if (!file_exists($subDirectory)) {
                mkdir($subDirectory, 0777, true); 
            }
        } elseif ($item->isFile()) {
            $filePath = $item->getPathName();
            $destinationPath = $destination . DIRECTORY_SEPARATOR . $iterator->getSubPathName();

            $fileDateTime = filemtime($filePath);
            $desiredTime = $this->getTerminalFile('TIMESTAMPS_PUBLIC', $local_project_directory);

            $currentDateTime = $desiredTime; // Use current time

            if ($fileDateTime > $currentDateTime) {
                try {
                     if (!file_exists(dirname($destinationPath))) {
                        mkdir(dirname($destinationPath), 0777, true);
                    }

                    if (file_exists($filePath) && file_exists(dirname($destinationPath))) {
                        copy($filePath, $destinationPath);
                    } else {
                        echo "Source file or destination directory doesn't exist for: $filePath\n";
                    }
                } catch (Exception $e) {
                    echo "Error copying file: $filePath. Error message: " . $e->getMessage() . "\n";
                }
            }
        }
    }
}



   
}
 