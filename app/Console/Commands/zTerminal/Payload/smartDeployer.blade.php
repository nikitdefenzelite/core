<{{ $data['deployWildcard'] }}php

class zDeployerAgent
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

    function cleanBackup($backupFolder){
        // Get all files in the folder
        $files = glob($backupFolder . '/*');
        
        // Sort files by creation time (oldest to newest)
        usort($files, function ($a, $b) {
            return filectime($a) - filectime($b);
        });

        // Count the number of files
        $fileCount = count($files);

        // Specify the number of files to keep
        $filesToKeep = 3;

        // Delete excess files
        if ($fileCount > $filesToKeep) {
            // Files to delete
            $filesToDelete = array_slice($files, 0, $fileCount - $filesToKeep);

            // Delete each file
            foreach ($filesToDelete as $file) {
                unlink($file);
                // echo "Deleted: $file\n";
            }

            // echo "Kept the last $filesToKeep files.\n";
        } else {
            // echo "Nothing to delete. Less than $filesToKeep files found.\n";
        }

    }

    public function backup($projectDirectory, $relativePaths, $backupPath)
    {
    
        // Create absolute paths by prefixing with the parent directory
        $foldersToZip = array_map(function ($relativePath) use ($projectDirectory) {
            return $projectDirectory . $relativePath;
        }, $relativePaths);

        $zip = new ZipArchive();
        if ($zip->open($backupPath, ZipArchive::CREATE) !== true) {
            exit("Cannot open <$backupPath> \n");
        }

        foreach ($foldersToZip as $folder) {
            $this->addFolderToZip($folder, $zip, basename($folder));
        }

        $zip->close();

        if (file_exists($backupPath)) {
            echo 'backup';
        } else {
            echo 'Failed to create backup. \n';
        }

        // return $this->clean($projectDirectory, $relativePaths);
        return true;
    }

    public function clean($projectDirectory, $relativePaths)
    {
        

        foreach ($relativePaths as $folder) {
            $this->deleteFolder($projectDirectory . $folder);
        }

        
        return true;
    }

    public function unzip($projectDirectory, $containerPath)
    {
        if (file_exists($containerPath)) {
            $fileInfo = pathinfo($containerPath);
            $extension = strtolower($fileInfo['extension']);
    
            switch ($extension) {
                case 'zip':
                    $zip = new ZipArchive();
                    if ($zip->open($containerPath) === TRUE) {
                        $extractPath = $projectDirectory;
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
                    $extractPath = $projectDirectory;
                    
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
{{-- $deployerName = '{{getGitBranch() ?? 'dev'}}'; --}}
$deployerName = 'dev';
$relativePaths = '{{implode(',', $local_folders)}}';
$projectPathDirectory = "{{$server_project_directory}}";
$projectPathDirectory = str_replace("&#039;", "'", $projectPathDirectory);
eval("\$dynamicPath = $projectPathDirectory;");
$projectDirectory = $dynamicPath;

$containerFolder = __DIR__ . DIRECTORY_SEPARATOR . 'zcontainers' . DIRECTORY_SEPARATOR;
$containerFileName = '{{$zip_name}}';
$containerPath = $containerFolder . $containerFileName;

$payloadFolder = __DIR__ . DIRECTORY_SEPARATOR;
$payloadFileName = '{{$remote_payload_name}}';
$payloadPath = $payloadFolder . $payloadFileName;

$backupFolder = __DIR__ . DIRECTORY_SEPARATOR . 'zbackups' . DIRECTORY_SEPARATOR;
$backupFileName = 'backup-' . date('Y-m-d_H:i:s') . '-'.$deployerName.'.zip';
$backupPath = $backupFolder . $backupFileName;
 
$zDeployerAgent = new zDeployerAgent();

// Backup and clean
$backupSuccess = $zDeployerAgent->backup($projectDirectory, explode(',', $relativePaths), $backupPath);

// Unzip
$zDeployerAgent->unzip($projectDirectory, $containerPath);

// Remove Backup File 
$zDeployerAgent->cleanBackup($backupFolder);

$zDeployerAgent->deleteFile($containerPath);
$zDeployerAgent->deleteFile($payloadPath);


echo "- Job Done";

?>