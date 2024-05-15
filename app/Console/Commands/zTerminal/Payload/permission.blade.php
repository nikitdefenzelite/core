<{{ $data['permissionwildcard'] }}php

class zPermissionAgent
{
    // Helpers
    public function runPermissionUpdate($projectDirectory)
    {
         // Mapping of file names to permission codes
        $permissionMapping = [
            '.env' => '0600',
            'artisan' => '+x',
            'composer.json' => '0644',
            'web.php' => '0644',
            'app.php' => '0644',
            'index.php' => '0644',
            '.gitignore' => '0644',
            'phpunit.xml' => '0644',
            'server.php' => '0644',
            'package.json' => '0644',
            'yarn.lock' => '0644',
            'webpack.mix.js' => '0644',
            'Dockerfile' => '0644',
            'docker-compose.yml' => '0644',
            'app' => '0755',
            'bootstrap' => '0755',
            'config' => '0755',
            'database' => '0755',
            'public' => '0755',
            'resources' => '0755',
            'routes' => '0755',
            'storage' => '0775',
            'tests' => '0755',
            'vendor' => '0755',
            'node_modules' => '0755',
            'zterminal' => '0755',
            'symbolic.php' => '0644',
            '.htaccess' => '0644',
            '.ftpquota' => '0600'
        ];
        
        $directory = "../"; 

        // Update permissions for the main directory
        if (!empty($directory) && is_dir($directory)) {
            $this->updatePermissions($directory, $permissionMapping);
        }

        // Update permissions for the project directory
        if (!empty($projectDirectory) && is_dir($projectDirectory)) {
            $this->updatePermissions($projectDirectory, $permissionMapping);
        }
    }

    private function updatePermissions($directory, $permissionMapping)
    {
        // Get the list of files and directories
        $contents = scandir($directory);

        // Filter out '.' and '..' (current directory and parent directory)
        $contents = array_diff($contents, array('.', '..'));

        foreach ($contents as $item) {
            $itemPath = $directory . '/' . $item;

            // Check if it's a directory
            if (is_dir($itemPath)) {
                $type = 'Directory';
            } else {
                $type = 'File';
            }

            // Get file name without path
            $fileName = pathinfo($itemPath, PATHINFO_BASENAME);

            // Check if there's a custom permission in the mapping
            $permissions = $permissionMapping[$fileName] ?? null;

            if ($permissions !== null) {
                // Apply permission changes
                chmod($itemPath, octdec($permissions));
            }
        }
    }
}

// Config Items:
$deployerName = '{{getGitBranch() ?? 'dev'}}';
$projectPathDirectory = "{{$project_directory}}";
$projectPathDirectory = str_replace("&#039;", "'", $projectPathDirectory);
eval("\$dynamicPath = $projectPathDirectory;");
$projectDirectory = $dynamicPath;

$zPermissionAgent = new zPermissionAgent();

$zPermissionAgent->runPermissionUpdate($projectDirectory);
 
echo "- Job Done"

?>