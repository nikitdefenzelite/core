<{{ $data['dbCleanerWildcard'] }}php

class zDbCleanerAgent
{
    
    
    function getallDBDatabases($host, $username, $password) {
    // Establish database connection
    $conn = new mysqli($host, $username, $password);

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Query to retrieve databases
    $sql = "SHOW DATABASES";
    $result = $conn->query($sql);

    // Check if the query was successful
    if (!$result) {
        die("Error retrieving databases: " . $conn->error);
    }

    // Array to store database names
    $databases = array();

    // Fetch each row and store database names
    while($row = $result->fetch_assoc()) {
        $databases[] = $row['Database'];
    }

    // Close connection
    $conn->close();

    // Return the list of databases
    return $databases;
}




// Function to get tables of a database
function getDatabaseTables($host, $username, $password, $database) {
    // Establish database connection
    $conn = new mysqli($host, $username, $password, $database);

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Query to retrieve tables
    $sql = "SHOW TABLES";
    $result = $conn->query($sql);

    // Check if the query was successful
    if (!$result) {
        die("Error retrieving tables: " . $conn->error);
    }

    // Array to store table names
    $tables = array();

    // Fetch each row and store table names
    while($row = $result->fetch_row()) {
        $tables[] = $row[0];
    }

    // Close connection
    $conn->close();

    // Return the list of tables
    return $tables;
}

function emptyTableData($host, $username, $password, $database, $tableName) {
    // Establish database connection
    $conn = new mysqli($host, $username, $password, $database);

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Query to delete data from the table
    $sql = "TRUNCATE TABLE $tableName"; // This will delete all rows from the table

    // Execute the query
    if ($conn->query($sql) === TRUE) {
        echo "Data from table $tableName deleted successfully.";
    } else {
        echo "Error deleting data from table: " . $conn->error;
    }

    // Close connection
    $conn->close();
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



$envFilePath = $projectCoreDirectory . '.env';

$serverTable = '{{$server_table_name}}';  // jobs


$zDbCleanerAgent = new zDbCleanerAgent();

$names = ['DB_CONNECTION', 'DB_HOST', 'DB_PORT', 'DB_DATABASE', 'DB_USERNAME', 'DB_PASSWORD'];
$values = $zDbBackupAgent->getValuesFromEnv($envFilePath, $names);

$host=  $values['DB_HOST'];
$username = $values['DB_USERNAME'];
$password = $values['DB_PASSWORD'];
$serverDatabase = $values['DB_DATABASE'];


$databases = $zDbCleanerAgent->getallDBDatabases($host, $username, $password);

  // Display list of databases
echo "List of databases:<br>";
// Loop through each database and get tables
foreach ($databases as $database) {
    if($database == $serverDatabase){
        echo "Tables in database '$database':<br>";
    $tables = $zDbCleanerAgent->getDatabaseTables($host, $username, $password, $database);
    foreach ($tables as $table) {
      if($table == $serverTable) {
             echo $table . "\n\n";
             $tableClear = $zDbCleanerAgent->emptyTableData($host, $username, $password, $database, $table);
      }else {
           continue;
      }
    }
    }else {
        continue;
    }
}

echo "- Job Done";


?>
