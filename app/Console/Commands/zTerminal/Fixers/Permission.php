<?php

namespace App\Console\Commands\zTerminal;

use Illuminate\Console\Command;
use ZipArchive;
use Illuminate\Support\Facades\Http;
use File;
use Lazzard\FtpClient\Connection\FtpSSLConnection;
use Lazzard\FtpClient\Config\FtpConfig;
use Lazzard\FtpClient\FtpClient;
use Illuminate\Support\Facades\View;

class Permission extends Command
{


    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'permission {action} {file_name}';
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
        // Permission.....
        //   ";

        echo "\n";
        echo "Permission.....      ";
        echo "\n";

        $action = $this->argument('action');
        $file_name = $this->argument('file_name');

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

            if (!$client->isDir('zterminal')) {
                $client->createDir('zterminal');
                $client->changeDir('zterminal/');

                if (!$client->isDir('zbackups')) {
                    $client->createDir('zbackups');
                }
                if (!$client->isDir('zcontainers')) {
                    $client->createDir('zcontainers');
                }

                $client->changeDir('../');
            } else {
                $client->changeDir('../');
            }

            $directory = "../";
        

            switch ($this->argument('action')) {
                case 'l':
                        // Get list of available backup names
                        $files = $client->listDirDetails($directory);
                        
                    foreach ($files as $file) {
                        $permission =  $this->convertChmodToOctal($file['chmod']);
                    
                        // Extract filename
                        $filename = $file['path'];
                        // Extract filename
                        $fileType = $file['type'];

                        // Output filename and permissions
                        echo "File: $filename, Permissions: $permission, Type: $fileType\n";
                    }
                        echo 'Job Done!';
                    break;
                case 'f':
                    $client->back();
                    $client->changeDir('zterminal/');
                    $remote_payload_name = 'permission.php';
                    $payload_path = base_path() . '/storage/app/zterminal/payloads/' . $remote_payload_name;
                    if (!$client->isExists('permission.php')) {
                        // echo "Uploading Payload\n";
                        $this->payloadPermissionBuilder($connection, $remote_payload_name,$project_directory);
                        $client->upload($payload_path, $remote_payload_name);
                        echo "Finish Payload Upload\n";
                    } else {
                        // echo "Payload Found in Server\n";
                    }
            
                    $connection->close();
            
                    echo "Finish Code Upload\n";
            
                    $response = Http::withOptions([
                        'verify' => false,
                    ])->get($this->host_url . '/zterminal/permission.php');
            
                    echo "\n $response \n";
            
                    echo 'Removing unnecessary files.';
                    if (file_exists($payload_path)) {
                        unlink($payload_path);
                    }
                      
                    break;
               
                default:
                    break;
            }



            return Command::SUCCESS;
        } else {
            $this->error('Failed to connect to FTP server.');
        }
    }
    
         
    private function payloadPermissionBuilder($connection, $remote_payload_name,$project_directory)
    {
        $data['permissionwildcard'] = '?';
        $destinationPath = base_path() . '/storage/app/zterminal/payloads/';

        if (!is_dir($destinationPath)) {
            mkdir($destinationPath, 0777, true);
        }

        $serverZipData = View::make('system.zterminal.runner', compact('data', 'remote_payload_name','project_directory'))->render();

        File::put($destinationPath . $remote_payload_name, $serverZipData);
        return $destinationPath;
    }

    private function convertChmodToOctal($chmodString)
    {
        $perms = substr($chmodString, 1); // Exclude the first character ('d' for directory or '-' for file)
        $permsArray = str_split($perms);
    
        $result = 0;
        $multiplier = 256;
    
        foreach ($permsArray as $perm) {
            $result *= 2; // Shift left by one bit
    
            switch ($perm) {
                case 'r':
                case 'w':
                case 'x':
                    $result += 1;
                    break;
                case 's':
                    $result += 3; // Setuid (1) + Execute (2)
                    break;
                default:
                    // No permission
            }
        }
    
        return sprintf('%04o', $result);
    }
    

    private function convertOctalToChmod($octalPermission)
    {
        // Convert the octal string to an integer and pad with zeros to ensure it has at least three digits
        $octalValue = str_pad($octalPermission, 4, '0', STR_PAD_LEFT);
    
        // Split the octal digits into an array
        $permsArray = str_split($octalValue);
    
        $result = '';
        $multiplier = 4;
    
        foreach ($permsArray as $i => $perm) {
            if ($i === 0) {
                // The first character indicates the file type (e.g., '-' for a regular file)
                $result .= ($perm & 4) ? '-' : 'd';
            } else {
                $num = (int)$perm;
    
                $result .= ($num & 4) ? 'r' : '-';
                $result .= ($num & 2) ? 'w' : '-';
                $result .= ($num & 1) ? 'x' : '-';
    
                $multiplier /= 2;
            }
        }
    
        return $result;
    }
}
