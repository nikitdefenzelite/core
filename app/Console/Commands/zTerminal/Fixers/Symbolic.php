<?php

namespace App\Console\Commands\zTerminal;

use Illuminate\Console\Command;
use ZipArchive;
use Illuminate\Support\Facades\Http;
use File;
use Lazzard\FtpClient\Connection\FtpSSLConnection;
use Lazzard\FtpClient\Config\FtpConfig;
use Lazzard\FtpClient\FtpClient;

class Symbolic extends Command
{


    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'fix:symbolic {action}';
    public $host_url, $ftp_host, $ftp_user, $ftp_password, $ftp_port, $ftp_folder, $host;
    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'It deploy code in the specified server and make backup files available';

    public function handle()
    {
        $retry = 0;
        // try {
            $this->host_url = "####URL####";
            $this->ftp_host = "####HOST####";
            $this->ftp_user = "####USERNAME####";
            $this->ftp_password = "####PASSWORD####";
            $this->ftp_port = "####PORT####";
            $this->ftp_folder = 'files';
    
            $ftp_core_folder = "####CORE_FOLDERS####";
            $project_directory = "####PROJECT_DIRECTORY_PATH####";
            $local_project_directory = "####LOCAL_PROJECT_DIRECTORY_PATH####";



            if (!extension_loaded('ftp')) {
                throw new \RuntimeException("FTP extension not loaded.");
            }
    
    
            ini_set('maximum_execution_time', 2500);
            // echo "Starting... \n";
    
            //     echo "
            // Runner.....
            //   ";
    
            echo "\n";
            echo "\n";
    
            // echo "Establishing FTP connection... \n";
            $connection = new FtpSSLConnection($this->ftp_host, $this->ftp_user, $this->ftp_password);
            $connection->open();
    
            $config = new FtpConfig($connection);
            $config->setPassive(true);
    
            $client = new FtpClient($connection);
    
            if ($connection) {
                // echo "Local folders ready.\n";
    
                $this->info("FTP Connected. Running...");
    
    
                $terminalCheckProjectId = terminalCheckProjectId($local_project_directory);
                if($terminalCheckProjectId == 0){
                    echo "There is no project with this name in this system. Choose a new project and run the command!\n";
                    return;
                }
             
    
                sleep(5);
                // $this->info("ZIP Created");
               
                $this->info('Checking Configuration');
    
                // Check is Core File
                // Goto Core
    
                switch ($this->argument('action')) {
                    case 'local':
                        $storageFolder = $local_project_directory . "/storage";
                        if (!is_dir($storageFolder)) {
                            // Create the 'storage' folder if it doesn't exist
                            if (!mkdir($storageFolder, 0777, true)) {
                                echo "Failed to create storage folder.\n";
                                exit; // Exit the script if folder creation fails
                            } else {
                                echo "Storage folder created successfully.\n";
                            }
                        }
    
                        // Rename the 'storage' folder to include the current date and time
                        $newFolderName = $storageFolder . "_" . date('Ymd_His');
                        if (rename($storageFolder, $newFolderName)) {
                            echo "Storage folder renamed successfully.\n";
    
                            // Clear the Laravel cache
                            $cacheClearOutput = shell_exec("cd " . escapeshellarg($local_project_directory) . " && php artisan cache:clear");
                            if ($cacheClearOutput === null) {
                                echo "Laravel cache cleared successfully.\n";
                            } else {
                                echo "Failed to clear Laravel cache.\n";
                                // Handle the failure as needed
                            }
    
                            // Link storage folder
                            $storageLinkPath = $local_project_directory . "/public/storage";
                            if (!is_link($storageLinkPath)) {
                                $storageLinkOutput = shell_exec("cd " . escapeshellarg($local_project_directory) . " && php artisan storage:link");
                                if ($storageLinkOutput === null) {
                                    echo "Storage folder linked successfully.\n";
                                } else {
                                    echo "Failed to link storage folder.\n";
                                    // Handle the failure as needed
                                }
                            } else {
                                echo "Runner link for storage folder already exists.\n";
                            }
                        } else {
                            echo "Failed to rename storage folder.\n";
                        }
                        break;
                    case 'server':
    
                        
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
            
                        $client->back();
                        $remote_payload_name = 'symbolic.php';
            
                        $payload_path = base_path() . '/storage/app/zterminal/payloads/' . $remote_payload_name;
                        if (!$client->isExists('symbolic.php')) {
                                echo "Uploading Payload\n";
                            $this->payloadBuilder($connection, $remote_payload_name, $project_directory);
            
                            sleep(3);
                            $client->upload($payload_path, $remote_payload_name);
                            echo "Finish Payload Upload\n";
                        } else {
                                echo "Payload Found in Server\n";
                        }
            
                        $connection->close();
                           echo "Closed FTP Connection\n";
                            
                             echo $this->host_url . '/symbolic.php';
                            $response = Http::withOptions([
                                'verify' => false,
                            ])->get($this->host_url . '/symbolic.php');
    
                            echo "\n $response \n";
                            
                          
                        break;
                   
                    default:
                        break;
                }
                return Command::SUCCESS;
            } else {
                $this->error('Failed to connect to FTP server.');
            }
        }
    
    
    
        private function payloadBuilder($connection, $remote_payload_name, $project_directory)
        {
             $data['symbolicWildcard'] = '?';
             $destinationPath = base_path() . '/storage/app/zterminal/payloads/';
    
            $serverZipData = view('system.zterminal.runner', compact('data', 'remote_payload_name', 'project_directory'));
            if (!is_dir($destinationPath)) {
                mkdir($destinationPath, 0777, true);
            }
    
            File::put($destinationPath . $remote_payload_name, $serverZipData);
            return $destinationPath;
        }
        
        
        public function extractPathFromURL($url) {
            // Find the position of 'zterminal' in the URL
            $zterminalPos = strpos($url, 'zTerminal\\');
        
            // If 'zterminal' is found, extract the substring from that position onwards
            if ($zterminalPos !== false) {
                // Remove 'zterminal' and everything before it
                $newPath = substr($url, $zterminalPos + strlen('zTerminal\\'));
                return $newPath;
            } else {
                return false; // 'zterminal' not found in the URL
            }
        }
     
        
        
        private function contentData($ftp_core_folder_path)
        {
            $filename = 'symbolic.php';  // Change the filename as needed
            $content = '<?php
            $targetFolder = __DIR__ . "' . $ftp_core_folder_path . 'storage/app/public/";
            $linkFolder = __DIR__ . \'/storage\';
    
            // Uncomment the following lines for debugging
            // echo $targetFolder . "\n";
            // echo $linkFolder;
            // return;
    
            // Check if the target folder exists
            if (!is_dir($targetFolder)) {
                echo \'Error: Target folder does not exist\';
                return;
            } 
    
            // Check if there is no existing symlink or file at the destination
            if (file_exists($linkFolder)) {
                echo \'Error: Symlink or file already exists at the destination\';
                return;
            }
    
            // Create symbolic link and store the result in $link
            $link = symlink($targetFolder, $linkFolder);
    
            // Check the result and provide feedback
            if ($link !== false) {
                echo \'Symlink process successfully completed\';
            } else {
                echo \'Symlink process failed\';
            }
            ?>';
    
            return ['filename'=> $filename, 'content' => $content];
        }
    
        private function createFileInLocalDirectory($filename, $content, $folderPath)
        {
                $filePath = $folderPath . '/' . $filename;
    
                // Check if the file already exists
            if (file_exists($filePath)) {
                echo "Error: File '$filename' already exists in the directory\n";
                return;
            }
    
                // Create the file and write content
                $result = file_put_contents($filePath, $content);
    
                // Check the result and provide feedback
            if ($result !== false) {
                echo "File '$filename' successfully created in the directory";
            } else {
                echo "Error: Failed to create file '$filename'";
            }
        }
    }
    