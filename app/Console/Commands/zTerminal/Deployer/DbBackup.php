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

class DbBackup extends Command  ///Setup Project Runner 
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'call:dbbackup';
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
        $project_name = "####PROJECT_NAME####";
        $ftp_core_folder = "####CORE_FOLDERS####";
        $server_project_directory = "####PROJECT_DIRECTORY_PATH####";
        $local_project_directory = "####LOCAL_PROJECT_DIRECTORY_PATH####";
   

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
            $remote_payload_name = 'dbbackup.php';

            $payload_path = base_path() . '/storage/app/zterminal/payloads/' . $remote_payload_name;
            if (!$client->isExists('dbbackup.php')) {
                echo "Uploading Payload\n";
                $this->payloadBuilder($connection, $remote_payload_name, $project_name, $server_project_directory);

                sleep(3);
                $client->upload($payload_path, $remote_payload_name);
                echo "Finish Payload Upload\n";
            } else {
               
                    echo "Payload Found in Server\n";
          
            }

            $connection->close();
               echo "Closed FTP Connection \n";

            echo $this->host_url . '/zterminal/dbbackup.php';
            $response = Http::withOptions([
                'verify' => false,
            ])->get($this->host_url . '/zterminal/dbbackup.php');

            echo "\n $response \n";

            echo "Removing unnecessary files. \n";
            if (file_exists($payload_path)) {
                unlink($payload_path);
            }


        return Command::SUCCESS;
       
    }
}



    private function payloadBuilder($connection,  $remote_payload_name, $project_name, $server_project_directory)
    {
         $data['dbBackupWildcard'] = '?';
         $destinationPath = base_path() . '/storage/app/zterminal/payloads/';

        $serverZipData = view('system.zterminal.runner', compact('data', 'remote_payload_name', 'project_name', 'server_project_directory'));
        if (!is_dir($destinationPath)) {
            mkdir($destinationPath, 0777, true);
        }

        File::put($destinationPath . $remote_payload_name, $serverZipData);
        return $destinationPath;
    }

}
