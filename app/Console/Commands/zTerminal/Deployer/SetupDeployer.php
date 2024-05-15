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

class SDeployer extends Command  ///Setup Project Deployer 
{
    /**
     * The name and signature of the console command.
     * 
     * @var string
     */
    protected $signature = 'setup:deployer {action}';
    public $host_url, $ftp_host, $ftp_user, $ftp_password, $ftp_port, $ftp_folder, $host;
    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'It deploy code in the specified server and make backup files available';

    public function handle()
    {
        

        $this->host_url = "####URL####";
        $this->ftp_host = "####HOST####";
        $this->ftp_user = "####USERNAME####";
        $this->ftp_password = "####PASSWORD####";
        $this->ftp_port = "####PORT####";
        $this->ftp_folder = 'files';

        $ftp_core_folder = "####CORE_FOLDERS####";
        $server_project_directory = "####PROJECT_DIRECTORY_PATH####";
        $local_project_directory = "####LOCAL_PROJECT_DIRECTORY_PATH####";   

       
        switch ($this->argument('action')) {
            case 'server':
                $tar_name = 'deploy_container';
                $remote_directory = $tar_name . ".tar.gz";
                
                $connection = new FtpSSLConnection($this->ftp_host, $this->ftp_user, $this->ftp_password);
                $connection->open();
        
                $config = new FtpConfig($connection);
                $config->setPassive(true);
        
                $client = new FtpClient($connection);
        
                if ($connection) {
                    $backup_folder = 'zterminal/zips/';
        
                  echo  "Server Connected. Running...";

                  $terminalCheckProjectId = terminalCheckProjectId($local_project_directory);
                  if($terminalCheckProjectId == 0){
                      echo "There is no project with this name in this system. Choose a new project and run the command!\n";
                      return;
                  }
        
                     // Optimize local project
                     $commands = 'php artisan optimize:clear && php artisan cache:clear && php artisan config:clear && php artisan view:clear';
                     $command_line = "cd ".$local_project_directory ." && ". $commands;
                     $output = shell_exec($command_line);
 
                     /// Create tar base_path()
                     $zip_path = $this->makeStandardTar($tar_name, $local_project_directory);
                    // $zip_path = "D:\wamp64\www\system\zTerminal-Client\storage\app/zterminal/tars/deploy_container.tar.gz";

        
                    sleep(5);
                    $local_file_size = filesize($zip_path);
        
        
                    try {
                        // Check if the "zterminal" directory exists
                        if (!$client->isDir('zterminal')) {
                            // If not, create the "zterminal" directory
                            $client->createDir('zterminal');
                        }
                        
                        // Change directory to "zterminal"
                        $client->changeDir('zterminal');
                        
                        // Check if the "zbackups" directory exists
                        if (!$client->isDir('zbackups')) {
                            // If not, create the "zbackups" directory
                            $client->createDir('zbackups');
                        }
                        
                        // Check if the "zcontainers" directory exists
                        if (!$client->isDir('zcontainers')) {
                            // If not, create the "zcontainers" directory
                            $client->createDir('zcontainers');
                        }
                        
                        // Change directory to "zcontainers" inside "zterminal"
                        $client->changeDir('zcontainers/');
                    } catch (\Exception  $e) {
                        // Handle exception
                        echo 'FTP Error: ' . $e->getMessage();
                        return;
                    }
                    /// Regular file upload
        
                    echo 'INFO: Size ' . round($local_file_size / 1024 / 1024, 2) . "MB. \n";
                    $remote_zip_path = basename($zip_path);
                    
                    $max_attempts = 10;
                    $attempts = 0;
                    
                    echo "Starting Code Upload \n";
                    $this->ftpUpload($client, $zip_path, $remote_zip_path);
                    echo "Finish Code Upload\n";
         
                    $client->back();
                    $remote_payload_name = 'setupRunner.php';
        
                    $payload_path = base_path() . '/storage/app/zterminal/payloads/' . $remote_payload_name;
                    if (!$client->isExists('setupRunner.php')) {
                        echo "Uploading Payload\n";
                        $this->payloadBuilder($connection, $remote_payload_name, $ftp_core_folder, $tar_name . ".tar.gz", $server_project_directory);
        
                        sleep(3);
                        $client->upload($payload_path, $remote_payload_name);
                        echo "Finish Payload Upload\n";
                    } else {
                       
                            echo "Payload Found in Server\n";
                  
                    }
        
                    $connection->close();
                       echo "Closed FTP Connection \n";
        
                    echo $this->host_url . '/zterminal/setupRunner.php';
                    $response = Http::withOptions([
                        'verify' => false,
                    ])->get($this->host_url . '/zterminal/setupRunner.php');
        
                    echo "\n $response \n";
        
                    echo "Removing unnecessary files. \n";
                    if (file_exists($payload_path)) {
                        unlink($payload_path);
                    }
        
                    if (file_exists($zip_path)) {
                        unlink($zip_path);
                    }

                    $symbolic = Http::withOptions([
                        'verify' => false,
                    ])->get($this->host_url . '/symbolic.php');
        
                    return Command::SUCCESS;
                }
                    break;
            default:
                break;
        }
    }



    private function payloadBuilder($connection,  $remote_payload_name, $ftp_core_folder, $zip_name, $server_project_directory)
    {
         $data['setupRunnerWildcard'] = '?';
         $destinationPath = base_path() . '/storage/app/zterminal/payloads/';

        $serverZipData = view('system.zterminal.runner', compact('data', 'remote_payload_name', 'ftp_core_folder', 'zip_name', 'server_project_directory'));
        if (!is_dir($destinationPath)) {
            mkdir($destinationPath, 0777, true);
        }

        File::put($destinationPath . $remote_payload_name, $serverZipData);
        return $destinationPath;
    }


    private function makeStandardTar($tarZipName, $basePath)
    {
         // Define the directory to store the tar file
    $tarDirectory = storage_path('app/zterminal/tars/');

    // Create the directory if it doesn't exist
    if (!is_dir($tarDirectory)) {
        mkdir($tarDirectory, 0755, true);
    }

    // Define the path for the tar file
    $tarZipPath = $tarDirectory . $tarZipName . '.tar.gz';

    // Build the exclude argument for tar command
    $excludeArgs = '';
    $excludeFolders = ['.git', '.phpunit.cache'];
    foreach ($excludeFolders as $excludeFolder) {
        $excludeArgs .= " --exclude=" . escapeshellarg($excludeFolder);
    }

    // Build the tar command
    $tarCommand = "tar -czvf " . escapeshellarg($tarZipPath) . " -C " . escapeshellarg($basePath) . $excludeArgs . " .";

    // Execute the tar command
    $output = shell_exec($tarCommand);

    // Check if the command executed successfully
    if ($output === null) {
        echo "Tar command executed successfully!\n";
    } else {
        // Throw an exception if there's an error
        throw new \Exception("Error executing tar command. Output: $output");
    }

    return $tarZipPath;
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
    


}
