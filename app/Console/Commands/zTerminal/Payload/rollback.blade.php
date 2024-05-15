<{{ $data['rollbackwildcard'] }}php

class zRollbackAgent
{
    // Helpers
     function addFolderToZip($folder, &$zip, $zipFolderPath)
    {
        if (is_dir($folder)) {
            $dirHandle = opendir($folder);
            while (false !== ($file = readdir($dirHandle))) {
                if ($file != '.' && $file != '..') {
                    $filePath = $folder . DIRECTORY_SEPARATOR . $file;
                    $localPath = $zipFolderPath . DIRECTORY_SEPARATOR . $file;
                    if (is_file($filePath)) {
                       
                        $zip->addFile($filePath, $localPath);
                    } elseif (is_dir($filePath)) {
                        
                        $zip->addEmptyDir($localPath);
                        $this->addFolderToZip($filePath, $zip, $localPath);
                    }
                }
            }
            closedir($dirHandle);
        }
    }

   
    function deleteFolder($folder)
    {
        if (is_dir($folder)) {
            $dirHandle = opendir($folder);
            while (false !== ($file = readdir($dirHandle))) {
                if ($file != '.' && $file != '..') {
                    $filePath = $folder . DIRECTORY_SEPARATOR . $file;
                    if (is_file($filePath)) {
                        unlink($filePath);
                    } elseif (is_dir($filePath)) {
                        $this->deleteFolder($filePath);
                    }
                }
            }
            closedir($dirHandle);
            rmdir($folder);
        }
    }


   
    public function clean($projectDirectory, $relativePaths)
    {
        

        foreach ($relativePaths as $folder) {
            $this->deleteFolder($projectDirectory . $folder);
        }

        
        return true;
    }

   
    public function backup($projectDirectory, $relativePaths, $backupPath)
{
    try {
        
        // Create absolute paths by prefixing with the parent directory
        $foldersToZip = array_map(function ($relativePath) use ($projectDirectory) {
            return $projectDirectory . $relativePath;
        }, $relativePaths);


        $zip = new ZipArchive();
        if ($zip->open($backupPath, ZipArchive::CREATE) !== true) {
            throw new Exception("Cannot open <$backupPath>");
        }

        foreach ($foldersToZip as $folder) {
           return $this->addFolderToZip($folder, $zip, basename($folder));
        }

        $zip->close();

        if (file_exists($backupPath)) {
            // Success message or further processing
            // echo 'Backup created successfully! \n';
            return true;
        } else {
            throw new Exception('Failed to create backup.');
        }
    } catch (Exception $e) {
        // Handle the exception, log it, or return an error message
        echo 'Error: ' . $e->getMessage() . "\n";
        return false;
    }
}


     
public function extractZip($directory, $extractPath)
    {
      
        if (file_exists($directory)) {
            $zip = new ZipArchive();
            if ($zip->open($directory) === TRUE) {
                if ($zip->extractTo($extractPath) === TRUE) {
                    echo "Zip Extrated...";
                } else {
                    echo "Failed to extract the zip file.\n";
                }
                $zip->close();
            } else {
                echo "Failed to open the zip file.\n";
            }
        } else {
            echo "Zip file not found: $directory\n";
        }
    
        return $directory; 
    }

    
    public function checkCommonInternalFolders($folder1, $folder2)
        {
            $result = [];
        
            // Check if both folders exist
            if (is_dir($folder1) && is_dir($folder2)) {
                // Get the list of internal folders in the first folder
                $internalFolders1 = array_diff(scandir($folder1), ['.', '..']);
        
                // Get the list of internal folders in the second folder
                $internalFolders2 = array_diff(scandir($folder2), ['.', '..']);
        
                // Find common internal folders between the two folders
                $commonFolders = array_intersect($internalFolders1, $internalFolders2);
        
                if (empty($commonFolders)) {
                    $result['message'] = false;
                } else {
                    $result['commonFolders'] = $commonFolders;
                }
            } else {
                $result['error'] = 'One or both of the provided folders do not exist.';
            }
        
            return $result;
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

function deleteFile($filePath) {
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

}



// Config Items:
$deployerName = '{{getGitBranch() ?? 'dev'}}';
$projectPathDirectory = "{{$project_directory}}";
$projectPathDirectory = str_replace("&#039;", "'", $projectPathDirectory);
eval("\$dynamicPath = $projectPathDirectory;");
$projectDirectory = $dynamicPath;

$directory = __DIR__ . '/zbackups/{{$file_name}}';
$extractPath = __DIR__ . '/ztemp/';

$payloadFolder = __DIR__ . DIRECTORY_SEPARATOR;
$payloadFileName = 'rollback.php';
$payloadPath = $payloadFolder . $payloadFileName;


$zRollbackAgent = new zRollbackAgent();

// Working
$zRollbackAgent->extractZip($directory, $extractPath);

// Working
$commonFolders = $zRollbackAgent->checkCommonInternalFolders($projectDirectory, $extractPath);

// Display the result
if (isset($commonFolders['error'])) {
    echo 'Error: ' . $commonFolders['error'];
} elseif (isset($commonFolders['message'])) {
    {{-- echo $commonFolders['message']; --}}
   $zRollbackAgent->moveFolderAndDelete($extractPath, $projectDirectory);
} else {
    $relativePaths = implode(', ', $commonFolders['commonFolders']); 
    $zRollbackAgent->clean($projectDirectory, explode(',', $relativePaths));
    $zRollbackAgent->moveFolderAndDelete($extractPath, $projectDirectory);
}


$zRollbackAgent->deleteFile($payloadPath);
 
echo "- Job Done"

?>