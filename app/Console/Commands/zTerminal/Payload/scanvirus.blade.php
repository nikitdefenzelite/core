<{{ $data['scanviruswildcard'] }}php

class zScanVirusAgent
{
   public function runScanVirusUpdate()
        {
            $directory = "../";
        
            // Get the list of files and directories
            $contents = scandir($directory);
        
            // Filter out '.' and '..' (current directory and parent directory)
            $contents = array_diff($contents, array('.', '..'));
        
            $filesToScan = [];
        
            // Iterate through the contents
            foreach ($contents as $item) {
                $itemPath = $directory . '/' . $item;
        
                // If $item is a directory, recursively get the files within the directory
                if (is_dir($itemPath)) {
                    $filesToScan = array_merge($filesToScan, $this->getAllFilesInDirectory($itemPath));
                    echo $filesToScan;
                } else {
                    // $item is a file, add it to the list of files to scan
                    $filesToScan[] = $itemPath;
                }
            }
        
            // Display virus scan results
            $this->displayScanResults($filesToScan);
        }

// Function to get all files in a directory (including subdirectories)
    private function getAllFilesInDirectory($directory)
        {
            $files = [];
        
            $contents = scandir($directory);
            $contents = array_diff($contents, array('.', '..'));
        
            foreach ($contents as $item) {
                $itemPath = $directory . '/' . $item;
        
                if (is_dir($itemPath)) {
                    $files = array_merge($files, $this->getAllFilesInDirectory($itemPath));
                } else {
                    $files[] = $itemPath;
                }
            }
        
            return $files;
        }

    // Function to display a list of scanned files and their scan results
  private function displayScanResults($files)
    {
        echo "<h2>Virus Scan Results</h2>";
        echo "<ul>";
        foreach ($files as $file) {
            $result = $this->scanFileForViruses($file);
            echo "<li><strong>$file:</strong> $result</li>";
        }
        echo "</ul>";
    }
    
   private function scanFileForViruses($filePath)
    {
        $clamscanPath = '/usr/bin/clamscan'; // Update this path based on your server configuration

        // Escape the file path
        $escapedFilePath = escapeshellarg($filePath);
    
        // Execute clamscan command to scan the file
        $command = "$clamscanPath --stdout --infected $escapedFilePath 2>&1";
        exec($command, $output, $returnCode);

        // Log errors to the PHP error log
        if ($returnCode !== 0) {
            error_log("Error scanning file '$filePath': " . implode("\n", $output));
        }
    
        // Check the return code to determine if the scan was successful
        if ($returnCode === 0) {
            return "No viruses found in the file.";
        } elseif ($returnCode === 1) {
            // Virus detected
            $virusDetails = implode("\n", $output);
            return "Virus detected in the file:\n$virusDetails";
        } else {
            // Error during scanning
            return "Error occurred while scanning the file.";
        }
    }
}

// Config Items:
$deployerName = '{{getGitBranch() ?? 'dev'}}';

$zScanVirusAgent = new zScanVirusAgent();

$zScanVirusAgent->runScanVirusUpdate();
        

echo "- Job Done"

?>