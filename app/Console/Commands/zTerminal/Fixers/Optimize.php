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

class Optimize extends Command
{


    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'call:cleaner {action}';
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

        echo "\n";
        echo "Optimizing...";
        echo "\n";

        // echo "Establishing FTP connection... \n";
        $connection = new FtpSSLConnection($this->ftp_host, $this->ftp_user, $this->ftp_password);
        $connection->open();

        $config = new FtpConfig($connection);
        $config->setPassive(true);

        $client = new FtpClient($connection);

        if ($connection) {
            // echo "Local folders ready.\n";

            $this->info("Server Connected. Running...");

            sleep(5);
            // $this->info("ZIP Created");
           
            $this->info('Checking Configuration');

            $terminalCheckProjectId = terminalCheckProjectId($local_project_directory);
            if($terminalCheckProjectId == 0){
                echo "There is no project with this name in this system. Choose a new project and run the command!\n";
                return;
            }


            switch ($this->argument('action')) {
                case 'local':
                    $commands = 'php artisan optimize:clear && php artisan cache:clear && php artisan config:clear && php artisan view:clear';
                    $command_line = "cd ".$local_project_directory ." && ". $commands;
                    $output = shell_exec($command_line);
                    echo "Done";
                    break;
                case 'server':
                    if (!$client->isDir('zterminal')) {
                        $client->createDir('zterminal');
                        $client->changeDir('zterminal/');
                    } else {
                        $client->changeDir('zterminal/');
                    }
        
                    $remote_payload_name = 'optimize.php';
                    $payload_path = base_path() . '/storage/app/zterminal/payloads/' . $remote_payload_name;
                    if (!$client->isExists('optimize.php')) {
                        echo $ftp_core_folder;
                        // echo "Uploading Payload\n";
                        $this->payloadOptimizeBuilder($connection, $remote_payload_name, $ftp_core_folder, $project_directory);
                        $client->upload($payload_path, $remote_payload_name);
                        echo "Finish Payload Upload\n";
                    } else {
                        // echo "Payload Found in Server\n";
                    }
        
                    $connection->close();
                    $response = Http::withOptions([
                        'verify' => false,
                    ])->get($this->host_url . '/zterminal/optimize.php');
        
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
    
         
    private function payloadOptimizeBuilder($connection, $remote_payload_name, $ftp_core_folder, $project_directory)
    {
        $data['optimizeWildcard'] = '?';
        $destinationPath = base_path() . '/storage/app/zterminal/payloads/';

        if (!is_dir($destinationPath)) {
            mkdir($destinationPath, 0777, true);
        }

        $serverZipData = View::make('system.zterminal.runner', compact('data', 'remote_payload_name', 'ftp_core_folder', 'project_directory'))->render();

        File::put($destinationPath . $remote_payload_name, $serverZipData);
        return $destinationPath;
    }
}
