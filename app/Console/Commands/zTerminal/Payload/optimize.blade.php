<{{ $data['optimizeWildcard'] }}php

class zOptimizeAgent
{
    // Helpers
    public function runOptimize($projectDirectory)
    {
        $output = null;
        $returnVar = null;

        $output = shell_exec("cd ".$projectDirectory ." && ". ' php artisan optimize:clear && php artisan cache:clear && php artisan config:clear && php artisan view:clear');
        return $output;
    }
}

// Config Items:
$deployerName = 'dev';
$projectPathDirectory = "{{$project_directory}}";
$projectPathDirectory = str_replace("&#039;", "'", $projectPathDirectory);
eval("\$dynamicPath = $projectPathDirectory;");
$projectDirectory = $dynamicPath;


$zOptimizeAgent = new zOptimizeAgent();

$response = $zOptimizeAgent->runOptimize($projectDirectory);

echo $response;

?>