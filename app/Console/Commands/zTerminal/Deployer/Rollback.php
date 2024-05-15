<?php

namespace App\Console\Commands\zTerminal;

use Illuminate\Console\Command;
use ZipArchive;
use Illuminate\Support\Facades\Http;
use File;
use Lazzard\FtpClient\Connection\FtpSSLConnection;
use Lazzard\FtpClient\Config\FtpConfig;
use Lazzard\FtpClient\FtpClient;
use Lazzard\FtpClient\FtpClientException;
use Illuminate\Support\Facades\View;

class Rollback extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'deploy:rollback {action} {file_name?}';
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

        $action = $this->argument('action');
        $file_name = $this->argument('file_name') ?? null;

        // echo "Establishing FTP connection... \n";
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
            // echo "Local folders ready.\n";

            $backup_folder = 'zdeployer/zips/';

            if (!$client->isDir('zterminal')) {
                $client->createDir('zterminal');
                $client->changeDir('zterminal/');

                if (!$client->isDir('zbackups')) {
                    $client->createDir('zbackups');
                }
                if (!$client->isDir('zcontainers')) {
                    $client->createDir('zcontainers');
                }
            }

            $restore_point = $this->argument('action');
            $directory = 'zterminal/zbackups';

            switch ($this->argument('action')) {
                case 'list':
                    // Get list of available backup names

                    echo "Server Connected. Retrieving... \n";
                    $files = $client->listDir($directory);

                    
                    if(empty($files)){
                        echo "No backup files available \n\n";
                    }

                    foreach ($files as $key => $file) {
                        echo ++$key.". ".$file."\n";
                    }
                    break;
                case 'start':

                    $files = $client->listDir($directory);
                    
                    $fileExists = false;
                    foreach ($files as $file) {
                        if ($file == $file_name) {
                            $fileExists = true;
                            break; // Exit the loop once the file is found
                        }
                    }
                    
                    if ($fileExists) {
                        echo "The file '$file_name' exists in the directory.\n";
                    } else {
                        echo "The file '$file_name' does not exist in the directory.\n";
                    }

                    if ($file_name == null) {
                        echo 'ERROR: Please provide backup file name.';
                    } else {
                        $client->back();
                        $remote_terminal_name = 'rollback.php';
                        $terminal_path = base_path() . '/storage/app/zterminal/payloads/' . $remote_terminal_name;

                        $client->changeDir('zterminal/');
                        if (!$client->isExists('rollback.php')) {
                            // echo "Uploading terminal\n";
                            $this->terminalBuilder($connection, $remote_terminal_name, $ftp_core_folder, $file_name, $project_directory);
                            if (!$client->isFile($remote_terminal_name)) {
                                $client->removeFile($remote_terminal_name);
                            } else {
                                $client->upload($terminal_path, $remote_terminal_name);
                            }
                            echo "Finish terminal Upload\n";
                        } else {
                            echo "Backup Found!\n";
                        }

                        $connection->close();

                        $response = Http::withOptions([
                            'verify' => false,
                        ])->get($this->host_url . '/zterminal/rollback.php');

                        echo "\n $response \n";
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


    private function terminalBuilder($connection, $remote_terminal_name, $ftp_core_folder, $file_name, $project_directory)
    {
        $data['rollbackwildcard'] = '?';
        $destinationPath = base_path('storage/app/zterminal/payloads');

        // Ensure the directory exists before trying to create the file
        if (!File::isDirectory($destinationPath)) {
            File::makeDirectory($destinationPath, 0777, true, true);
        }

        // Using the view() function instead of the view() helper
        $serverZipData = View::make('system.zterminal.runner', compact('data', 'remote_terminal_name', 'ftp_core_folder', 'file_name', 'project_directory'))->render();

        // Use File::put instead of File::put for consistency
        File::put($destinationPath . '/' . $remote_terminal_name, $serverZipData);

        return $destinationPath;
    }
}
