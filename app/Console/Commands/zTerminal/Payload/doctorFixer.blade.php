<{{ $data['doctorFixerWildcard'] }}php


class zDoctorFixerAgent
{
    public function fixPermissionsRecursively($directory)
    {
        if (!is_dir($directory)) {
            return; // Directory doesn't exist, so we cannot fix permissions
        }

        $items = scandir($directory);

        foreach ($items as $item) {
            if ($item == '.' || $item == '..') {
                continue;
            }

            $path = $directory . DIRECTORY_SEPARATOR . $item;

            if (is_dir($path)) {
                $this->fixPermissionsRecursively($path);
                chmod($path, 0755); // Set directory permissions
            } else {
                chmod($path, 0644); // Set file permissions
            }
        }
    }

    public function fixDBConnectivity($envFilePath, $host, $username, $password, $database, $ports)
    {
        foreach ($ports as $port) {
            // Update .env file with new port
            $this->updateEnvFile($envFilePath, [
                'DB_PORT' => $port
            ]);

            // Attempt to connect to the database
            $mysqli = @new mysqli($host, $username, $password, $database, $port);

            if (!$mysqli->connect_error) {
                // Connection successful, update Laravel config if necessary
                {{-- $this->updateDatabaseConfig($port); --}}
                return "Connection successful with port $port.";
            }
        }

        return "Connection failed with all ports. Manual intervention required.";
    }

    public function fixCachePaths($laravelProjectPath, $cacheFolders)
    {
        $createdFolders = [];

        foreach ($cacheFolders as $folder) {
            $fullPath = $laravelProjectPath . DIRECTORY_SEPARATOR . $folder;

            if (!is_dir($fullPath)) {
                if (mkdir($fullPath, 0755, true)) {
                    $createdFolders[] = $folder;
                }
            }
        }

        return $createdFolders;
    }

    private function updateEnvFile($envFilePath, $data)
    {
        if (file_exists($envFilePath)) {
            $envContent = file_get_contents($envFilePath);

            foreach ($data as $key => $value) {
                $envContent = preg_replace("/^$key=(.*)$/m", "$key=$value", $envContent);
            }

            file_put_contents($envFilePath, $envContent);
        } else {
            throw new Exception('.env file not found.');
        }
    }

    {{-- private function updateDatabaseConfig($port)
    {
        // Assuming Laravel's database config is stored in config/database.php
        $configPath = __DIR__ . '/../config/database.php';

        // Update the database configuration file
        $config = require $configPath;

        if (isset($config['connections']['mysql'])) {
            $config['connections']['mysql']['port'] = $port;
            $file_content = '';
            file_put_contents($configPath, $file_content);
        } else {
            throw new Exception('Database configuration not found.');
        }
    } --}}

    
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

// Usage:

$deployerName = 'dev';


$server_table_name = '{{$server_table_name}}'; 


$projectCorePathDirectory = "__DIR__  . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'testing-core' . DIRECTORY_SEPARATOR";
$projectCorePathDirectory = str_replace("&#039;", "'", $projectCorePathDirectory);
eval("\$dynamicPath = $projectCorePathDirectory;");
$projectDirectory = $dynamicPath;


$payloadFolder = __DIR__ . DIRECTORY_SEPARATOR;
$payloadFileName = 'doctor-fixer.php';
$payloadPath = $payloadFolder . $payloadFileName;


$projectMainPathDirectory = __DIR__  . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR;

$zDoctorFixerAgent = new zDoctorFixerAgent();

$envFilePath = $projectDirectory . '.env';
$names = ['DB_CONNECTION', 'DB_HOST', 'DB_PORT', 'DB_DATABASE', 'DB_USERNAME', 'DB_PASSWORD'];
$values = $zDbBackupAgent->getValuesFromEnv($envFilePath, $names);

$server_db_host=  $values['DB_HOST'];
$server_db_username = $values['DB_USERNAME'];
$server_db_password = $values['DB_PASSWORD'];
$server_db_database = $values['DB_DATABASE'];

// Fix file permissions
$zDoctorFixerAgent->fixPermissionsRecursively($projectDirectory);
$zDoctorFixerAgent->fixPermissionsRecursively($projectMainPathDirectory);

// Fix cache paths
$cacheFolders = [
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

$createdFolders = $zDoctorFixerAgent->fixCachePaths($projectDirectory, $cacheFolders);

if (!empty($createdFolders)) {
    echo "Created cache folders:\n";
    foreach ($createdFolders as $folder) {
        echo "- $folder\n";
    }
} else {
    echo "No cache folders needed to be created.\n";
}

// Fix database connectivity
$ports = [3307, 3306, 3308];
$result = $zDoctorFixerAgent->fixDBConnectivity($envFilePath, $server_db_host, $server_db_username, $server_db_password, $server_db_database, $ports);

$zDoctorFixerAgent->deleteFile($payloadPath);
echo "- Job Done";

?>  