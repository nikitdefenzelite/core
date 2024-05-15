<?php

namespace App\Console\Commands\zTerminal;

use Illuminate\Console\Command;

class Format extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'call:prettier {action} {file_name?}';
    public $host_url, $ftp_host, $ftp_user, $ftp_password, $ftp_port, $ftp_folder, $host;
    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'It deploy code in the specified server and make backup files available';

    public function handle()
    {
        
            $local_project_directory = "####LOCAL_PROJECT_DIRECTORY_PATH####";

           $fileName =  $this->argument('file_name') ?? null; 

           $terminalCheckProjectId = terminalCheckProjectId($local_project_directory);
           if($terminalCheckProjectId == 0){
               echo "There is no project with this name in this system. Choose a new project and run the command!\n";
               return;
           }

        switch ($this->argument('action')) {
            case 'check':
                  $basePath = $local_project_directory;

                  $folders = ['app', 'database', 'config', 'lang', 'route'];

                  $phpcbfPath = $basePath . '/' . 'vendor/bin/phpcs';

                  $standard = '--standard=PSR2';

            
                foreach ($folders as $folder) {

                    $command = "$phpcbfPath $standard $folder";
                     
                    echo "Running command: $command\n";
                    $output = shell_exec($command);

                    echo "$output\n";
                }
                break;
            case 'fix':
                  $basePath = $local_project_directory;

                  $folders = ['app', 'database', 'config', 'lang', 'route'];

                  $phpcbfPath = $basePath . '/' . 'vendor/bin/phpcbf';

                  $standard = '--standard=PSR2';

            
                foreach ($folders as $folder) {

                    $command = "$phpcbfPath $standard $folder";
                     
                    echo "Running command: $command\n";
                    $output = shell_exec($command);

                    echo "$output\n";
                }
                break;
            default:
                break;
        }
    }
}
