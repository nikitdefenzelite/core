<{{ $data['symbolicWildcard'] }}php
class zSymbolicAgent
{
   
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
    
 
function createStorageFolder($basePath) {
    // Check if the storage folder already exists
    $storagePath = $basePath . 'storage';
    if (file_exists($storagePath)) {
        // Generate current date/time string
        $currentDateTime = date('Y-m-d_H-i-s');
        
        // Rename existing storage folder
        $newStoragePath = $basePath . '/storage_' . $currentDateTime;
        if (!rename($storagePath, $newStoragePath)) {
            // If renaming fails, return false
            return false;
        }
    }
    
    // Create the new "storage" folder
    if (!mkdir($storagePath, 0777, true)) {
        // If folder creation fails, return false
        return false;
    }
    
    // Return the path of the newly created folder
    return $storagePath;
}


public function extractPathFromURL($url) {
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


    
}

// Config Items:

$deployerName = 'dev';

$projectCorePathDirectory = "{{$project_directory}}";
$projectCorePathDirectory = str_replace("&#039;", "'", $projectCorePathDirectory);
eval("\$dynamicPath = $projectCorePathDirectory;");
$projectCoreDirectory = $dynamicPath;

$payloadFolder = __DIR__ . DIRECTORY_SEPARATOR;
$payloadFileName = 'symbolic.php';
$payloadPath = $payloadFolder . $payloadFileName;

$zSymbolicAgent = new zSymbolicAgent();

// Deployer File Path
$symbolicFilePath = __DIR__ . DIRECTORY_SEPARATOR . ".." . DIRECTORY_SEPARATOR . 'symbolic.php';

$path = $zSymbolicAgent->extractPathFromURL($projectCoreDirectory);

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

 
$zSymbolicAgent->createStorageFolder($projectCoreDirectory);

$zSymbolicAgent->contentFilePut($symbolicFilePath, $path, $contentRunner);

$zSymbolicAgent->deleteFile($payloadPath);
?>
