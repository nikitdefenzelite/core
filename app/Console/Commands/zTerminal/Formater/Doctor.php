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

class Doctor extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'call:doctor {action} {file_name?}';
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
   

        
        $file_name = $this->argument('file_name') ?? null;
        
        $server_table_name = $file_name;

        switch ($this->argument('action')) {
            case 'check':
                switch ($this->argument('file_name')) {
                    case 'local':
                        if (!is_dir($local_project_directory)) {
                            $this->error('Directory does not exist.');
                            return;
                        }
                        
                        $extensions =    $this->getAvailablePhpExtensions();
                        echo "Available PHP extensions:\n";
                        foreach ($extensions['available'] as $extension) {
                            echo $extension . " (Working)\n";
                        }

                        echo "\nUnavailable PHP extensions:\n";
                        foreach ($extensions['unavailable'] as $extension) {
                            echo $extension . " (Not Working)\n";
                        }
                       
                        /// Check Runners Local Files
                        $this->listRunnersRecursively($local_project_directory);
                        
                        
                        /// Folder check and create
                        $this->checkCachePaths($local_project_directory);
                        
                        /// DB_Port Number
                        $this->adjustDbPortInEnvFile("3307", $local_project_directory);

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
                            $remote_payload_name = 'doctor-clecker.php';
                
                            $payload_path = base_path() . '/storage/app/zterminal/payloads/' . $remote_payload_name;
                            if (!$client->isExists('doctor-clecker.php')) {
                                echo "Uploading Payload\n";
                                        
                                $this->payloadRunnerCheckerBuilder($connection, $remote_payload_name,  $server_table_name, $this->host_url);
                
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
                
                            echo $this->host_url . '/zterminal/doctor-clecker.php';
                            $response = Http::withOptions([
                                'verify' => false,
                            ])->get($this->host_url . '/zterminal/doctor-clecker.php');
                
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
                break;
            case 'fix':
                switch ($this->argument('file_name')) {
                    case 'local':

                         // Call the method to fix permissions recursively
                        $this->fixRunnersRecursively($local_project_directory);
                        $this->fixCachePaths($local_project_directory);
                        $result = $this->checkAndFixPhpExtensions();
                        // Output the results
                        echo "Available Extensions: " . implode(', ', $result['available']) . "\n";
                        echo "Unavailable Extensions: " . implode(', ', $result['unavailable']) . "\n";
                        
                        echo "Done";
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
                            $remote_payload_name = 'doctor-fixer.php';
                
                            $payload_path = base_path() . '/storage/app/zterminal/payloads/' . $remote_payload_name;
                            if (!$client->isExists('doctor-fixer.php')) {
                                echo "Uploading Payload\n";
                                        
                                $this->payloadRunnerFixerBuilder($connection, $remote_payload_name, $server_table_name);
                
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
                
                            echo $this->host_url . '/zterminal/doctor-fixer.php';
                            $response = Http::withOptions([
                                'verify' => false,
                            ])->get($this->host_url . '/zterminal/doctor-fixer.php');
                
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
                break;
            default:
                break;
        }
    }


    function checkAndFixPhpExtensions() {
        // Execute the command to list installed PHP modules
        exec('php -m', $output, $returnCode);
    
        // Initialize empty arrays to store available and unavailable extensions
        $availableExtensions = [];
        $unavailableExtensions = [];
    
        // Check if the return code is zero (success)
        if ($returnCode === 0) {
            // Iterate through each line of output
            foreach ($output as $extension) {
                // Trim whitespace from the extension name
                $extension = trim($extension);
                // Try loading the extension to check if it's working
                $extensionCheckCommand = "php -r \"if (!extension_loaded('$extension')) exit(1);\"";
                $extensionCheckOutput = shell_exec($extensionCheckCommand);
                // Check if the return code is zero, indicating the extension is working
                if (!$extensionCheckOutput) {
                    // If the extension is working, add it to the available extensions array
                    $availableExtensions[] = $extension;
                } else {
                    // If the extension is not working, add it to the unavailable extensions array
                    $unavailableExtensions[] = $extension;
                }
            }
        } else {
            // If return code is non-zero, PHP modules command failed, so all extensions are considered unavailable
            $unavailableExtensions[] = "Unable to retrieve PHP extensions";
        }
    
        // If there are unavailable extensions, attempt to fix them
        if (!empty($unavailableExtensions)) {
            // Initialize an array to store commands for fixing extensions
            $fixCommands = [];
    
            // Check if the system package manager is available
            $packageManager = shell_exec('command -v apt || command -v yum');
            if ($packageManager !== '') {
                // Iterate through each unavailable extension
                foreach ($unavailableExtensions as $extension) {
                    // Generate the command for installing the extension using the appropriate package manager
                    if (strpos($packageManager, '/apt') !== false) {
                        // For Debian-based systems
                        $fixCommands[] = "sudo apt-get install -y php$extension";
                    } elseif (strpos($packageManager, '/yum') !== false) {
                        // For Red Hat-based systems
                        $fixCommands[] = "sudo yum install -y php-$extension";
                    }
                }
    
                // Execute fix commands
                foreach ($fixCommands as $command) {
                    echo "Executing command: $command\n";
                    shell_exec($command);
                }
    
                // Re-check availability after attempting to fix
                return $this->checkAndFixPhpExtensions();
            } else {
                // If the package manager is not detected, provide a message for manual installation
                foreach ($unavailableExtensions as $extension) {
                    $unavailableExtensions[] = "Unable to determine the package manager. Please install $extension extension manually.";
                }
            }
        }
    
        // Return both arrays of available and unavailable extensions
        return [
            'available' => $availableExtensions,
            'unavailable' => $unavailableExtensions
        ];
    }
    



    function getAvailablePhpExtensions() {
        // Execute the command to list installed PHP modules
        exec('php -m', $output, $returnCode);
        
        // Initialize empty arrays to store available and unavailable extensions
        $availableExtensions = [];
        $unavailableExtensions = [];
        
        // Check if the return code is zero (success)
        if ($returnCode === 0) {
            // Iterate through each line of output
            foreach ($output as $extension) {
                // Trim whitespace from the extension name
                $extension = trim($extension);
                // Try loading the extension to check if it's working
                $extensionCheckCommand = "php -d extension=$extension -r \"echo 'Extension $extension is working.';\"";
                $extensionCheckOutput = shell_exec($extensionCheckCommand);
                // Check if the output contains the success message
                if (strpos($extensionCheckOutput, "Extension $extension is working.") !== false) {
                    // If the extension is working, add it to the available extensions array
                    $availableExtensions[] = $extension;
                } else {
                    // If the extension is not working, add it to the unavailable extensions array
                    $unavailableExtensions[] = $extension;
                }
            }
        } else {
            // If return code is non-zero, PHP modules command failed, so all extensions are considered unavailable
            $unavailableExtensions[] = "Unable to retrieve PHP extensions";
        }
        
        // Return both arrays of available and unavailable extensions
        return [
            'available' => $availableExtensions,
            'unavailable' => $unavailableExtensions
        ];
    }

 private function payloadRunnerCheckerBuilder($connection, $remote_payload_name, $server_table_name, $server_host_url)
    {
         $data['doctorCheckerWildcard'] = '?';
         $destinationPath = base_path() . '/storage/app/zterminal/payloads/';

        $serverZipData = view('system.zterminal.runner', compact('data', 'remote_payload_name', 'server_table_name', 'server_host_url'));
        if (!is_dir($destinationPath)) {
            mkdir($destinationPath, 0777, true);
        }

        File::put($destinationPath . $remote_payload_name, $serverZipData);
        return $destinationPath;
    }

    private function payloadRunnerFixerBuilder($connection, $remote_payload_name, $server_table_name)
    {
         $data['doctorFixerWildcard'] = '?';
         $destinationPath = base_path() . '/storage/app/zterminal/payloads/';

        $serverZipData = view('system.zterminal.runner', compact('data', 'remote_payload_name', 'server_table_name'));
        if (!is_dir($destinationPath)) {
            mkdir($destinationPath, 0777, true);
        }

        File::put($destinationPath . $remote_payload_name, $serverZipData);
        return $destinationPath;
    }


    function listRunnersRecursively($directory) {
        $items = scandir($directory);
        foreach ($items as $item) {
            if ($item == '.' || $item == '..') {
                continue;
            }
            $path = $directory . DIRECTORY_SEPARATOR . $item;
            if (is_dir($path)) {
                $this->listRunnersRecursively($path);
            } else {
                $permissions = substr(sprintf('%o', fileperms($path)), -4);
                echo "File: $path | Runners: $permissions \n";
            }
        }
    }


    
    function checkAndFixCachePaths($local_project_directory) {
        $folders = [
            'bootstrap/cache',
            'storage/logs',
            'storage/dotenv-eor/backup',
            'storage/debugbar',
            'storage/app/public',
            'storage/framework/sessions',
            'storage/framework/cache',
            'storage/framework/testing',
            'storage/framework/views',
        ];
        
        foreach ($folders as $folder) {
            $fullPath = $local_project_directory . '/' . $folder;
            if (!is_dir($fullPath)) {
                // Create the folder if it doesn't exist
                mkdir($fullPath, 0777, true);
                echo "Created folder: $fullPath\n";
            }
        }
    }

    function checkCachePaths($local_project_directory) {
        $folders = [
            'bootstrap/cache',
            'storage/logs',
            'storage/dotenv-eor/backup',
            'storage/debugbar',
            'storage/app/public',
            'storage/framework/sessions',
            'storage/framework/cache',
            'storage/framework/testing',
            'storage/framework/views',
        ];
        
        $existingFolders = [];
        $missingFolders = [];
        
        // Check existing folders
        foreach ($folders as $folder) {
            $fullPath = $local_project_directory . '/' . $folder;
            if (is_dir($fullPath)) {
                $existingFolders[] = $folder;
            } else {
                $missingFolders[] = $folder;
            }
        }
        
        // Output results
        echo "Existing folders:\n";
        foreach ($existingFolders as $folder) {
            echo "- $folder\n";
        }
        
        echo "Missing folders:\n";
        foreach ($missingFolders as $folder) {
            echo "- $folder\n";
        }
    }

    function fixCachePaths($local_project_directory) {
        $folders = [
            'bootstrap/cache',
            'storage/logs',
            'storage/dotenv-eor/backup',
            'storage/debugbar',
            'storage/app/public',
            'storage/framework/sessions',
            'storage/framework/cache',
            'storage/framework/testing',
            'storage/framework/views',
        ];
        
        $createdFolders = [];
        
        // Create missing folders
        foreach ($folders as $folder) {
            $fullPath = $local_project_directory . '/' . $folder;
            if (!is_dir($fullPath)) {
                // Folder doesn't exist, so create it
                mkdir($fullPath, 0777, true);
                echo "Created folder: $fullPath\n";
                $createdFolders[] = $folder;
            }
        }
    
        // Output results
        echo "Created folders:\n";
        foreach ($createdFolders as $folder) {
            echo "- $folder\n";
        }
    }
    
    

    function adjustDbPortInEnvFile($newPort, $local_project_directory) {
        // Define the filename of the environment file
        $filename = $local_project_directory . '/.env';
    
        // Check if the environment file exists
        if (!file_exists($filename)) {
            echo "Error: Environment file (.env) not found in the project directory.";
            return false;
        }
    
        // Read the content of the environment file
        $envContent = file_get_contents($filename);
    
        // Define the pattern to match the database port number
        $pattern = '/(?<=DB_PORT=)\d+/';
    
        // Replace the existing port number with the new port number
        $updatedEnvContent = preg_replace($pattern, $newPort, $envContent);
    
        // Write the updated content back to the environment file
        if ($updatedEnvContent !== null) {
            file_put_contents($filename, $updatedEnvContent);
            echo "Database port number adjusted to $newPort in the environment file.";
            return true;
        } else {
            echo "Error: Failed to adjust the database port number in the environment file.";
            return false;
        }
    }


    protected function fixRunnersRecursively($dir)
    {
        $contents = scandir($dir);
        foreach ($contents as $item) {
            if ($item != '.' && $item != '..') {
                $path = $dir . DIRECTORY_SEPARATOR . $item;
                if (is_dir($path)) {
                    $this->fixRunnersRecursively($path);
                }
                chmod($path, 0777);
            }
        }
    }
}
