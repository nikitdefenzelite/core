<?php

namespace App\Console\Commands\zTerminal;

use Illuminate\Console\Command;
use ZipArchive;
use Illuminate\Support\Facades\Http;
use File;
use Lazzard\FtpClient\Connection\FtpSSLConnection;
use Lazzard\FtpClient\Config\FtpConfig;
use Lazzard\FtpClient\FtpClient;

class Htaccess extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'fix:htaccess server';
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
            // Htaccess.....
            //   ";
    
            echo "\n";
            echo "\n";
            $local_file = base_path() . '\storage\app\zterminal\payloads';
                  
    
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
            
                $this->info('Checking Configuration');
    
                $action = $this->argument('action');
    
    
                switch ($this->argument('action')) {
                    case 'server':
                    
                         $contentData =   $this->contentData();
                         $this->createFileInLocalDirectory($contentData['filename'], $contentData['content'], $local_file); 
             
    
                         $local_file_path  = $local_file . '/' . $contentData['filename'];
             
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
             
                         $local_file_size = filesize($local_file_path);
             
                         $file_size_MB = round($local_file_size / 1024 / 1024, 2);
                         $file_size_formatted = ''; 
             
                         if ($file_size_MB >= 1) {
                             $file_size_formatted = $file_size_MB . "MB";
                         } elseif ($file_size_KB = round($local_file_size / 1024, 2)) {
                             $file_size_formatted = $file_size_KB . "KB";
                         } else {
                             $file_size_formatted = $local_file_size . "B";
                         }
             
                         echo 'INFO: Size ' . $file_size_formatted . '. Starting Code Upload' . PHP_EOL;
             
                         $remote_local_file_path = basename($local_file_path);
             
                         $client->upload($local_file_path, $remote_local_file_path);
             
                         echo 'Job Done!';
                         
                        break;
                    default:
                    break;
                        }  
                        return Command::SUCCESS;
            } else {
                $this->error('Failed to connect to FTP server.');
            }
        }
    
    
        private function contentData()
    {
        $filename = '.htaccess';  // Change the filename as needed
        $content = '<IfModule mod_rewrite.c>
        RewriteEngine On
    
        # Redirect to HTTPS
        RewriteCond %{HTTPS} off
        RewriteRule ^(.*)$ https://%{HTTP_HOST}%{REQUEST_URI} [L,R=301]
    
        # Handle Authorization Header
        RewriteCond %{HTTP:Authorization} .
        RewriteRule .* - [E=HTTP_AUTHORIZATION:%{HTTP:Authorization}]
    
        # Redirect Trailing Slashes If Not A Folder...
        RewriteCond %{REQUEST_FILENAME} !-d
        RewriteRule ^(.*)/$ /$1 [L,R=301]
    
        # Send Requests To Front Controller...
        RewriteCond %{REQUEST_FILENAME} !-d
        RewriteCond %{REQUEST_FILENAME} !-f
        RewriteRule ^ index.php [L]
    </IfModule>
    
    # Disable directory browsing
    Options -Indexes
    
    # Protect .env file
    <Files .env>
        Order allow,deny
        Deny from all
    </Files>
    
    # Prevent access to sensitive files
    <FilesMatch "(^\.|^composer\.lock|^composer\.json|^\.env.example|^\.gitignore|^\.git|^\.htaccess|^server\.php|^artisan|^web\.php)">
        Order allow,deny
        Deny from all
    </FilesMatch>
    ';
    
        return ['filename' => $filename, 'content' => $content];
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
    