<{{ $data['setupRunnerWildcard'] }}php

class zSetupRunnerAgent
{
    // Helpers

    public function createCoreFolder($folder_path) 
    {
       
        if (!is_dir($folder_path)) {
            if (!mkdir($folder_path, 0777, true)) {
                return false;
            }
        }
    
        return $folder_path;
    }

   
    public function unzip($extractPath, $containerPath)
    {
        if (file_exists($containerPath)) {
            $fileInfo = pathinfo($containerPath);
            $extension = strtolower($fileInfo['extension']);
    
            switch ($extension) {
                case 'zip':
                    $zip = new ZipArchive();
                    if ($zip->open($containerPath) === TRUE) {
                        if ($zip->extractTo($extractPath) === TRUE) {
                            echo "File has been extracted to $extractPath.\n";
                        } else {
                            echo "Failed to extract the file.\n";
                        }
                        $zip->close();
                    } else {
                        echo "Failed to open the zip file.\n";
                    }
                    break;
                case 'gz':
                case 'tar':
                case 'tar.gz':
                    
                    
                    // Create the extract directory if it doesn't exist
                    if (!is_dir($extractPath)) {
                        mkdir($extractPath, 0755, true);
                    }
    
                    // Debugging: Print the file path before running the tar command
                    
                    
                    $tarCommand = "tar -xzvf \"$containerPath\" -C \"$extractPath\"";
                    $output = shell_exec($tarCommand);
    
                    // Check if the tar command was successful
                    if ($output !== null && stripos($output, "tar: Error") === false) {
                        
                    } else {
                        echo "Error executing tar command: $output\n";
                    }
                    break;
                default:
                    echo "Unsupported file format.\n";
            }
        } else {
            echo "File not found: $containerPath\n";
        }
        
        return $extractPath . DIRECTORY_SEPARATOR;
    }    
    
public function moveFolderAndDelete($source, $destination) {
    if (!file_exists($source) || !is_dir($source)) {
        return false; // Source directory doesn't exist
    }

    if (!file_exists($destination)) {
        mkdir($destination, 0755, true); // Create destination directory if not exists
    }

    $files = new RecursiveIteratorIterator(
        new RecursiveDirectoryIterator($source, RecursiveDirectoryIterator::SKIP_DOTS),
        RecursiveIteratorIterator::SELF_FIRST
    );

    foreach ($files as $file) {
        $target = $destination . DIRECTORY_SEPARATOR . $files->getSubPathName();

        if ($file->isDir()) {
            if (!file_exists($target)) {
                mkdir($target);
            }
        } else {
            rename($file, $target);
        }
    }

    // Remove the source folder and its contents
    if (is_dir($source)) {
        $iterator = new RecursiveIteratorIterator(
            new RecursiveDirectoryIterator($source),
            RecursiveIteratorIterator::CHILD_FIRST
        );

        foreach ($iterator as $file) {                       
            if ($file->isDir()) {
                rmdir($file->getPathname());
            } else {
                unlink($file->getPathname());
            }
        }

        rmdir($source);
    }

    return true;
}
   
  function deleteFolder($folderPath) {
    if (!is_dir($folderPath)) {
        return false; // Not a directory
    }

    $files = array_diff(scandir($folderPath), ['.', '..']);
    foreach ($files as $file) {
        $filePath = $folderPath . '/' . $file;
        if (is_dir($filePath)) {
            deleteFolder($filePath);
        } else {
            unlink($filePath);
        }
    }

    return rmdir($folderPath);
}



public function deleteFile($filePath) {
    // Check if the file exists
    if (file_exists($filePath)) {
        // Attempt to delete the file
        if (unlink($filePath)) {
            echo "File deleted successfully.";
        } else {
            echo "Unable to delete the file.";
        }
    } else {
        echo "File does not exist.";
    }
}

// Helper function to recursively remove a directory and its contents
private function recursiveRemoveDirectory($dir)
 {
    $files = array_diff(scandir($dir), ['.', '..','public']); 
    foreach ($files as $file) {
        $path = $dir . '/' . $file;
        if (is_dir($path)) {
            $this->recursiveRemoveDirectory($path);
        } else {
            if (!unlink($path)) {
                echo "Failed to delete file: $path\n";
                return false;
            }
        }
    }
    return rmdir($dir);
}

public function contentFilePut($filePath, $coreFolderPath, $contentToAdd) 
    {
        $fileHandle = fopen($filePath, 'w');
        
        if ($fileHandle === false) {
            return false; 
        }  
        
        $phpContent = "<?php\n\n{$contentToAdd}\n\n?>";

        $bytesWritten = fwrite($fileHandle, $phpContent);
        
        if ($bytesWritten === false) {
            fclose($fileHandle); 
            return false; 
        }
        
        fclose($fileHandle);
        
        return true; 
    }

    

    public function extractPathFromURL($url)
    {
        // Find the position of 'zterminal' in the URL
        $zterminalPos = strpos($url, 'zterminal');
    
        // If 'zterminal' is found, extract the substring from that position onwards
        if ($zterminalPos !== false) {
            // Remove 'zterminal' and everything before it
            $newPath = substr($url, $zterminalPos + strlen('zterminal'));
            
            // Find the last occurrence of '/'
            $lastSlashPos = strrpos($newPath, '/../');
    
            // If '/' is found, extract the substring from that position onwards
            if ($lastSlashPos !== false) {
                // Remove everything before the last '/'
                $newPath = substr($newPath, $lastSlashPos);
                return $newPath;
            } else {
                return false; // '/' not found in the URL
            }
        } else {
            return false; // 'zterminal' not found in the URL
        }
    }
    
    


 public  function contentData()
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

public function createFileInLocalDirectory($filename, $content, $folderPath)
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

// Config Items:

$deployerName = 'dev';

$realPath = realpath(dirname(__FILE__) . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR);

$projectCorePathDirectory = "{{$server_project_directory}}";
$projectCorePathDirectory = str_replace("&#039;", "'", $projectCorePathDirectory);
eval("\$dynamicPath = $projectCorePathDirectory;");
$projectCoreDirectory = $dynamicPath;

///Upzip tar zip to new temp directory
$upZipTar = __DIR__ . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR;


//Index File Path
$indexFilePath = __DIR__ . DIRECTORY_SEPARATOR . ".." . DIRECTORY_SEPARATOR . 'index.php';

// Runner File Path
$symbolicFilePath = __DIR__ . DIRECTORY_SEPARATOR . ".." . DIRECTORY_SEPARATOR . 'symbolic.php';


$containerFolder = __DIR__ . DIRECTORY_SEPARATOR . 'zcontainers' . DIRECTORY_SEPARATOR;
$containerFileName = 'deploy_container.tar.gz';
$containerPath = $containerFolder . $containerFileName;

$payloadFolder = __DIR__ . DIRECTORY_SEPARATOR;
$payloadFileName = 'setupRunner.php';
$payloadPath = $payloadFolder . $payloadFileName;

$zSetupRunnerAgent = new zSetupRunnerAgent();

$path = $zSetupRunnerAgent->extractPathFromURL($projectCoreDirectory);


// Make Core
// Untar in "project_name-core"
 $coreFolderPath = $zSetupRunnerAgent->createCoreFolder($projectCoreDirectory); // Done
 
// Unzip
$upZipPath = $zSetupRunnerAgent->unzip($coreFolderPath, $containerPath); // Done

// Move public Folder folder and files
$zSetupRunnerAgent->moveFolderAndDelete($upZipPath . DIRECTORY_SEPARATOR . 'public' . DIRECTORY_SEPARATOR, $realPath . DIRECTORY_SEPARATOR); // Done



$contentIndex = "// ob_start();\n\nuse Illuminate\Contracts\Http\Kernel;\nuse Illuminate\Http\Request;\n\ndefine('LARAVEL_START', microtime(true));\n\n/*\n|--------------------------------------------------------------------------
| Check If The Application Is Under Maintenance
|--------------------------------------------------------------------------
|
| If the application is in maintenance / demo mode via the \"down\" command
| we will load this file so that any pre-rendered content can be shown
| instead of starting the framework, which could cause an exception.
|
*/\n\nif (file_exists(\$maintenance = __DIR__ . '$path' .'storage/framework/maintenance.php')) {\n    require \$maintenance;\n}\n\n/*\n|--------------------------------------------------------------------------
| Register The Auto Loader
|--------------------------------------------------------------------------
|
| Composer provides a convenient, automatically generated class loader for
| this application. We just need to utilize it! We'll simply require it
| into the script here so we don't need to manually load our classes.
|
*/\n\nrequire __DIR__ . '$path' . 'vendor/autoload.php';\n\n/*\n|--------------------------------------------------------------------------
| Run The Application
|--------------------------------------------------------------------------
|
| Once we have the application, we can handle the incoming request using
| the application's HTTP kernel. Then, we will send the response back
| to this client's browser, allowing them to enjoy our application.
|
*/\n\n\$app = require_once __DIR__ . '$path' . 'bootstrap/app.php';\n\n\$kernel = \$app->make(Kernel::class);\n\n\$response = \$kernel->handle(\n    \$request = Request::capture()\n)->send();\n\n\$kernel->terminate(\$request, \$response);";




    $contentRunner = '
        $targetFolder = __DIR__ . "' . $path . 'storage/app/public/";
        $linkFolder = __DIR__ . \'/storage\';

        // Uncomment the following lines for debugging
        // echo $targetFolder . "\n";
        // echo $linkFolder;
        // return;

        // Check if the target folder exists
        if (!is_dir($targetFolder)) {
            echo \'Error: Target folder does not exist\';
            return;
        } 

        // Check if there is no existing symlink or file at the destination
        if (file_exists($linkFolder)) {
            echo \'Error: Symlink or file already exists at the destination\';
            return;
        }

        // Create symbolic link and store the result in $link
        $link = symlink($targetFolder, $linkFolder);

        // Check the result and provide feedback
        if ($link !== false) {
            echo \'Symlink process successfully completed\';
        } else {
            echo \'Symlink process failed\';
        }
        ';


$zSetupRunnerAgent->contentFilePut($indexFilePath, $path, $contentIndex);

$zSetupRunnerAgent->contentFilePut($symbolicFilePath, $path, $contentRunner);


$contentD = $zSetupRunnerAgent->contentData();
$zSetupRunnerAgent->createFileInLocalDirectory($contentD['filename'], $contentD['content'], $realPath); 

$zSetupRunnerAgent->deleteFolder($upZipPath . DIRECTORY_SEPARATOR . 'public');
$zSetupRunnerAgent->deleteFile($containerPath);
$zSetupRunnerAgent->deleteFile($payloadPath);

echo "- Job Done";

?>
