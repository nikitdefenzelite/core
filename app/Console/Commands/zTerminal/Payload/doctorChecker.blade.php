<{{ $data['doctorCheckerWildcard'] }}php

class zDoctorCheckerAgent
{
     function listRunnersRecursively($directory) {
        $items = scandir($directory);
        $files = [];
        
        foreach ($items as $item) {
            if ($item == '.' || $item == '..') {
                continue;
            }
            $path = $directory . DIRECTORY_SEPARATOR . $item;
            if (is_dir($path)) {
                $this->listRunnersRecursively($path);
            } else {
                $permissions = substr(sprintf('%o', fileperms($path)), -4);
                $files[] = "File: $path | Runners: $permissions";
            }
        }
        
        return $files;
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


function checkExtensionOnServer($extension, $host_url) {
    // Replace "example.com" with your server's domain or IP address
    $url = $host_url . "check_extension.php?extension=" . urlencode($extension);
    
    // Make an HTTP GET request to the URL
    $response = file_get_contents($url);
    
    // Check if the response contains the success message
    if (strpos($response, "Extension $extension is working.") !== false) {
        return true; // Extension is working
    } else {
        return false; // Extension is not working
    }
}

function getAvailablePhpExtensions($host_url) {
    // Get a list of loaded PHP extensions
    $loadedExtensions = get_loaded_extensions();
    
    // Initialize empty arrays to store available and unavailable extensions
    $availableExtensions = [];
    $unavailableExtensions = [];
    
    // Iterate through each extension
    foreach ($loadedExtensions as $extension) {
        // Try checking the extension on the server
        if ($this->checkExtensionOnServer($extension, $host_url)) {
            // If the extension is working, add it to the available extensions array
            $availableExtensions[] = $extension;
        } else {
            // If the extension is not working, add it to the unavailable extensions array
            $unavailableExtensions[] = $extension;
        }
    }
    
    // Return both arrays of available and unavailable extensions
    return [
        'available' => $availableExtensions,
        'unavailable' => $unavailableExtensions
    ];
}


function checkDBConnectivity($host, $username, $password, $database) {
    $ports = [3307, 3306, 3308]; // Array of possible port numbers to check

    foreach ($ports as $port) {
        // Attempt to connect to the database
        $mysqli = @new mysqli($host, $username, $password, $database, $port);

        // Check connection
        if (!$mysqli->connect_error) {
            // Connection successful
            echo "Connection successful with port $port.";
            return true;
        } else {
            // Connection failed
            echo "Connection failed with port $port: " . $mysqli->connect_error . "\n";
        }
    }

    // If none of the ports were successful, return false
    return false;
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


// Function to get values of multiple names from the .env file
function getValuesFromEnv($filePath, $names) {
    // Read the content of the .env file
    $content = file_get_contents($filePath);

    // Initialize an empty array to store values
    $values = [];

    // Loop through each provided name
    foreach ($names as $name) {
        // Define the regular expression pattern to match the desired line
        $pattern = '/^' . preg_quote($name, '/') . '=(.*)$/m';

        // Use preg_match to find the match
        if (preg_match($pattern, $content, $matches)) {
            // Store the value in the array
            $values[$name] = $matches[1];
        } else {
            // If the name is not found, store null
            $values[$name] = null;
        }
    }

    return $values;
}


     
}

// Config Items:

$deployerName = 'dev';
$server_host_url = '{{$server_host_url}}';

$server_table_name = '{{$server_table_name}}';  // jobs

$projectCorePathDirectory = "__DIR__  . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'testing-core' . DIRECTORY_SEPARATOR";
$projectCorePathDirectory = str_replace("&#039;", "'", $projectCorePathDirectory);
eval("\$dynamicPath = $projectCorePathDirectory;");
$projectDirectory = $dynamicPath;



$payloadFolder = __DIR__ . DIRECTORY_SEPARATOR;
$payloadFileName = 'doctor-checker.php';
$payloadPath = $payloadFolder . $payloadFileName;

 $projectMainPathDirectory = __DIR__  . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR;




$zDoctorCheckerAgent = new zDoctorCheckerAgent();


$envFilePath = $projectDirectory . '.env';
$names = ['DB_CONNECTION', 'DB_HOST', 'DB_PORT', 'DB_DATABASE', 'DB_USERNAME', 'DB_PASSWORD'];
$values = $zDbBackupAgent->getValuesFromEnv($envFilePath, $names);

$server_db_host=  $values['DB_HOST'];
$server_db_username = $values['DB_USERNAME'];
$server_db_password = $values['DB_PASSWORD'];
$server_db_database = $values['DB_DATABASE'];

 $coreDirectoryRunners = $zDoctorCheckerAgent->listRunnersRecursively($projectDirectory);
 $mainDirectoryRunners = $zDoctorCheckerAgent->listRunnersRecursively($projectMainPathDirectory);


 $checkAndFixCachePaths = $zDoctorCheckerAgent->checkCachePaths($projectMainPathDirectory);

 
 echo $checkDBConnectivity = $zDoctorCheckerAgent->checkDBConnectivity($server_db_host, $server_db_username, $server_db_password, $server_db_database);


 // Usage example
 $extensions = $zDoctorCheckerAgent->getAvailablePhpExtensions($server_host_url);
 
 echo "Available PHP extensions:\n";
 foreach ($extensions['available'] as $extension) {
     echo $extension . " (Working)\n";
 }
 
 echo "\nUnavailable PHP extensions:\n";
 foreach ($extensions['unavailable'] as $extension) {
     echo $extension . " (Not Working)\n";
 }

$zDoctorCheckerAgent->deleteFile($payloadPath);
echo "- Job Done";
return;


?>
