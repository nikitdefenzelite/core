<{{ $data['dbBackupWildcard'] }}php

class zDbBackupAgent
{
    // Helpers

    public function createFolder($folder_path) 
    {
       
        if (!is_dir($folder_path)) {
            if (!mkdir($folder_path, 0777, true)) {
                return false;
            }
        }
    
        return $folder_path;
    }

/// Working method
function backupDatabase($host, $user, $password, $database, $backupDir) {
    // Get current date and time
    $currentDateTime = date('Y-m-d_H-i-s');

    // Construct the file name with current date and time
    $backupFileName = "backup_$currentDateTime.sql";

    // Construct the full path of the backup file
    $backupPath = $backupDir . '/' . $backupFileName;

    // Escape special characters in database credentials and paths
    $host = escapeshellarg($host);
    $user = escapeshellarg($user);
    $password = escapeshellarg($password);
    $database = escapeshellarg($database);
    $backupPath = escapeshellarg($backupPath);

    // Construct the command to execute mysqldump
    $command = "mysqldump --host=$host --user=$user --password=$password $database > $backupPath";

    // Print the command for debugging
    echo "Command: $command\n";

    // Execute the command and capture both STDOUT and STDERR
    exec($command . ' 2>&1', $output, $returnVar);

    // Check if the backup was successful
    if ($returnVar === 0) {
        echo "Database backup created successfully.\n";
    } else {
        echo "Error creating database backup. Error message: " . implode("\n", $output) . "\n";
    }
}


// function backupDatabase($host, $user, $password, $database, $backupDir) {
//     // Get current date and time
//     $currentDateTime = date('Y-m-d_H-i-s');

//     // Construct the file name with current date and time
//     $backupFileName = "backup_$currentDateTime.sql";

//     // Construct the full path of the backup file
//     $backupPath = $backupDir . '/' . $backupFileName;

//     // List of folders to ignore
//     $ignoreFolders = ['sessions', 'failed_jobs'];

//     // Construct the command to execute mysqldump
//     $command = "mysqldump --host='$host' --user='$user' --password='$password' $database";

//     // Add tables to exclude from backup
//     foreach ($ignoreFolders as $folder) {
//         $command .= " --ignore-table=$database.$folder";
//     }

//     $command .= " > $backupPath";
// echo $command;
//     // Execute the command and capture stderr for error messages
//     exec($command . ' 2>&1', $output, $returnVar);

//     // Check if the backup was successful
//     if ($returnVar === 0) {
//         echo "Database backup created successfully.";
//     } else {
//         echo "Error creating database backup. Error message: " . implode("\n", $output);
//     }
// }




   
    
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


public function extractPathFromURL($url)
{
    // Find the position of 'zterminal' in the URL
    $zterminalPos = strpos($url, 'zterminal');

    // If 'zterminal' is found, extract the substring from that position onwards
    if ($zterminalPos !== false) {
        // Remove 'zterminal' and everything before it
        $newPath = substr($url, $zterminalPos + strlen('zterminal'));
        return $newPath;
    } else {
        return false; // 'zterminal' not found in the URL
    }
}





function deleteOldFiles($folderPath, $fileFormat) {
    // Get current timestamp
    $currentTime = time();

    // Calculate timestamp for 7 days ago
    $sevenDaysAgo = strtotime('-7 days', $currentTime);

    $files = glob($folderPath . DIRECTORY_SEPARATOR . $fileFormat);

    if ($files === false) {
        echo "Error: Unable to read directory.";
        return;
    }

    foreach ($files as $file) {
        // Extract date from filename
        preg_match('/\d{4}-\d{2}-\d{2}/', $file, $matches);
        if (count($matches) > 0) {
            $fileDate = strtotime($matches[0]);
            // Check if file date is older than 7 days
            if ($fileDate < $sevenDaysAgo) {
                // Delete the file
                if (unlink($file)) {
                    echo "File $file deleted successfully.\n";
                } else {
                    echo "Error: Unable to delete file $file.\n";
                }
            } else {
                // echo "File $file is not old enough to be deleted.\n";
            }
        } else {
            // echo "Error: Unable to extract date from filename for file $file.\n";
        }
    }
}



function getValuesFromEnv($filePath, $names) {
    $content = file_get_contents($filePath);

    $values = [];

    foreach ($names as $name) {
        $pattern = '/^' . preg_quote($name, '/') . '=(.*)$/m';

        if (preg_match($pattern, $content, $matches)) {
            $values[$name] = $matches[1];
        } else {
            $values[$name] = null;
        }
    }

    return $values;
}


    
}

// Config Items:

$deployerName = 'dev';

$realPath = realpath(dirname(__FILE__) . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR);

$projectName = "{{$project_name}}";

$projectCorePathDirectory = "{{$server_project_directory}}";
$projectCorePathDirectory = str_replace("&#039;", "'", $projectCorePathDirectory);
eval("\$dynamicPath = $projectCorePathDirectory;");
$projectCoreDirectory = $dynamicPath;

$upZipTar = __DIR__ . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR;


$zDbBackupAgent = new zDbBackupAgent();

$envFilePath = $projectCoreDirectory . '.env';
$names = ['DB_CONNECTION', 'DB_HOST', 'DB_PORT', 'DB_DATABASE', 'DB_USERNAME', 'DB_PASSWORD'];
$values = $zDbBackupAgent->getValuesFromEnv($envFilePath, $names);

 $server_db_host=  "{$values['DB_HOST']}";
 $server_db_username = "{$values['DB_USERNAME']}";
 $server_db_password = "{$values['DB_PASSWORD']}";
 $server_db_database = "{$values['DB_DATABASE']}";


$path = $zDbBackupAgent->extractPathFromURL($projectCoreDirectory);

$createFolderPath = $zDbBackupAgent->createFolder($projectCoreDirectory . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'db-backup'); // Done
 
$createProjectFolderPath = $createFolderPath . DIRECTORY_SEPARATOR . $projectName;

$createFolder = $zDbBackupAgent->createFolder($createProjectFolderPath); // Done

$backup = $zDbBackupAgent->backupDatabase($server_db_host, $server_db_username, $server_db_password, $server_db_database, $createFolder . DIRECTORY_SEPARATOR); // Done
 
$fileFormat = 'backup_*.sql';  
 
$zDbBackupAgent->deleteOldFiles($createFolderPath, $fileFormat);     

echo "- Job Done";

?>
