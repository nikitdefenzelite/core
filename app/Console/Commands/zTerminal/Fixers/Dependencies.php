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

class Dependencies extends Command
{
        

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'dependencies {action}';
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
        echo "Starting... \n";

        //     echo "
        // Htaccess.....
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
 
                $client->changeDir('zterminal/');
            } else {
                $client->changeDir('zterminal/');
            }
 
            switch ($this->argument('action')) {
                case 'i':
                    $composer_type = 'install';
                    $client->back();
                    $client->changeDir('zterminal/');
                    $remote_payload_name = 'dependency.php';
                    $run_code = 'composer';
                    $payload_path = base_path() . '/storage/app/zterminal/payloads/' . $remote_payload_name;
                    if (!$client->isExists('dependency.php')) {
                        // echo "Uploading Payload\n";
                        $this->payloadDependencyBuilder($connection, $composer_type, $remote_payload_name, $run_code, $ftp_core_folder, $project_directory);
                        if (!$client->isFile($remote_payload_name)) {
                            $client->removeFile($remote_payload_name);
                        } else {
                            $client->upload($payload_path, $remote_payload_name);
                        }
                        echo "Finish Payload Upload\n";
                    } else {
                        // echo "Payload Found in Server\n";
                    }
                    break;
                case 'u':
                    $composer_type = 'update';
                    $client->back();
                    $client->changeDir('zterminal/');
                    $remote_payload_name = 'dependency.php';
                    $run_code = 'composer';
                    $payload_path = base_path() . '/storage/app/zterminal/payloads/' . $remote_payload_name;
                    if (!$client->isExists('dependency.php')) {
                        // echo "Uploading Payload\n";
                        $this->payloadDependencyBuilder($connection, $composer_type, $remote_payload_name, $run_code, $ftp_core_folder, $project_directory);
                        if (!$client->isFile($remote_payload_name)) {
                            $client->removeFile($remote_payload_name);
                        } else {
                            $client->upload($payload_path, $remote_payload_name);
                        }
                        echo "Finish Payload Upload\n";
                    } else {
                        // echo "Payload Found in Server\n";
                    }

                    break;

                default:
                    break;
            }

           

            $connection->close();

            echo "Finish Code Upload\n";


            $response = Http::withOptions([
                'verify' => false,
            ])->get($this->host_url . '/zterminal/dependency.php');

            echo "\n $response \n";

            echo 'Removing unnecessary files.';
            if (file_exists($payload_path)) {
                unlink($payload_path);
            }

            return Command::SUCCESS;
        } else {
            $this->error('Failed to connect to FTP server.');
        }
    }

    private function payloadDependencyBuilder($connection, $composer_type, $remote_payload_name, $run_code, $ftp_core_folder, $project_directory)
    {
        $data['dependencywildcard'] = '?';
        $destinationPath = base_path() . '/storage/app/zterminal/payloads/';

        if (!is_dir($destinationPath)) {
            mkdir($destinationPath, 0777, true);
        }

        $serverZipData = View::make('system.zterminal.runner', compact('data', 'composer_type', 'remote_payload_name', 'run_code', 'ftp_core_folder', 'project_directory'))->render();

        File::put($destinationPath . $remote_payload_name, $serverZipData);
        return $destinationPath;
    }
}
