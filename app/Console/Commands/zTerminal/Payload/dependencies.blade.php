<{{ $data['dependencywildcard'] }}php

class zDependenciesAgent
{  
    // Helpers
    public function runDependenciesUpdate($projectDirectory)
    { 
        // Execute the "Dependencies update" command
        $output = null;
        $returnVar = null;
    
        $output = shell_exec(cd ".$projectDirectory ." && ". ' composer update 2>&1');
        
        // Check the return value to determine if the command was successful
        if ($output === null) {
            echo "Error updating Dependencies dependencies. Please check the console output for more information.\n";
            exit(1); // Exit with an error code
        } else {
            echo $output;
            echo "Dependencies update successful.\n";
        } 
    }

    public function runDependenciesInstall($projectDirectory)
    {
        // Execute the "Dependencies install" command
        $output = null;
        $returnVar = null;

        $output = shell_exec("cd ".$projectDirectory ." && ". ' composer install 2>&1');
        
        // Check the return value to determine if the command was successful
        if ($output === null) {
            echo "Error installing Dependencies dependencies. Please check the console output for more information.\n";
            exit(1); // Exit with an error code
        } else {
            echo $output;
            echo "Dependencies install successful.\n";
        }
    }
}



// Config Items:
$deployerName = '{{getGitBranch() ?? 'dev'}}';
$composer_type = '{{$composer_type}}';
$projectPathDirectory = "{{$project_directory}}";
$projectPathDirectory = str_replace("&#039;", "'", $projectPathDirectory);
eval("\$dynamicPath = $projectPathDirectory;");
$projectDirectory = $dynamicPath;

$projectDirectory = __DIR__ . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR;


$zDependenciesAgent = new zDependenciesAgent();


if($composer_type == 'update') {
     echo 'update';
 $zDependenciesAgent->runDependenciesUpdate($projectDirectory);
}else if($composer_type == 'install'){
    echo 'install';
  $zDependenciesAgent->runDependenciesInstall($projectDirectory);  
}

echo "- Job Done"

?>