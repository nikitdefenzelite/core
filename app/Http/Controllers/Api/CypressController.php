<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use App\Models\CyRunner;
use App\Models\Project;
use App\Models\Category;
use App\Models\CyRunnerLog;
use GuzzleHttp\Client;

class CypressController extends Controller
{
    public function init(Request $request)
    {



        $cyRunnerFiles = CyRunner::where('id', $request->cy_runner_id)->where('status', 'Active')->first();

        if (!$cyRunnerFiles) {
            return response()->json([
                'status' => 'error',
                'message' => 'CyRunner not found'
            ]);
        }

        $project = Project::where('id', $cyRunnerFiles->project_id)->first();
        if (!$project) {
            return response()->json([
                'status' => 'error',
                'message' => 'Project not found'
            ]);
        }

        $dynamicJson = [
            'd_email' => 'mayank@test.com',
            'd_password' => 'mayank1234',
            'd_firstname' => 'Mayank',
            'd_lastname' => 'Sarathe',
            'd_phoneNumber' => '1234567890',
            'd_gender' => 'Bangalore',
            'd_dob' => 'Karnataka',
        ];

        CyRunnerLog::create([
            'group_id' => $cyRunnerFiles->project_id,
            'cy_runner_id' => $cyRunnerFiles->id,
            'user_id' => $cyRunnerFiles->user_id,
            'payload' => " ",
            'status' => 'Running',
        ]);


        $replaceKeysWithValuePattern = $this->replaceKeysWithValuePattern($cyRunnerFiles->code, $dynamicJson);

        if ($replaceKeysWithValuePattern !== 0) {
            $modifiedContent = str_replace(array_keys($replaceKeysWithValuePattern), array_values($replaceKeysWithValuePattern), $cyRunnerFiles->code);
        } else {
            $modifiedContent = $cyRunnerFiles->code;
        }

        $new_path = base_path() . '/cypress/e2e/runner.cy.js';

        file_put_contents($new_path, $modifiedContent);


        $response = CyRunnerLog::whereId(208)->first();
        // $response = $this->run($cyRunnerFiles->project_id, $cyRunnerFiles->id, $cyRunnerFiles->user_id, $project);

         $cyRunnerResponse = CyRunner::where('id', $response->cy_runner_id)
            ->where('status', 'Active')
            ->first();

        if ($cyRunnerResponse) {
             $projectResponse = Project::where('id', $cyRunnerResponse->project_id)
                ->first();

            if ($projectResponse) {
                $group = Category::where('id', $cyRunnerResponse->group_id)
                    ->where('category_type_id', $cyRunnerResponse->project_id)
                    ->where('type_id', Category::STATUS_TYPE_CYPRESS)
                    ->first();

                if ($group) {
                    // All queries returned valid results, you can proceed with your logic here
                } else {
                    // Handle case where $group is null
                    echo "Group not found.";
                }
            } else {
                // Handle case where $projectResponse is null
                echo "Project not found.";
            }
        } else {
            // Handle case where $cyRunnerResponse is null
            echo "CyRunner not found or not active.";
        }


        return [
            'cy_runner' => $cyRunnerResponse,
            'project_response' => $projectResponse,
            'response' => $response ?? null,
            'group' => $group ?? null,
        ];
    }

    public function run($project_id, $id, $user_id, $project)
    {
        $specFilePath = 'cypress/e2e/runner.cy.js';

        // Define the path to the error log file
        $errorLogPath = base_path() . DIRECTORY_SEPARATOR . 'error.log';

        // Define the path to store screenshots and videos
        $mediaPath = base_path() . DIRECTORY_SEPARATOR . 'cypress-media';

        // Clear the content of the error log file before running the tests
        file_put_contents($errorLogPath, '');

        $command = "cd " . base_path() . " && npx cypress run --spec \"$specFilePath\" --env mediaFolder=\"$mediaPath\" 2>&1";

        // Open a pipe to the process
        $process = popen($command, 'r');

        // Initialize variables to store output
        $runningLog = ''; 
        $errorLogContent = '';

        // Read the output until the process finishes
        while (!feof($process)) {
            // Read the output from the process
            $output = fread($process, 4096);

            // Append the output to the running log
            $runningLog .= $output;

            // Check if the output contains error messages
            if (strpos($output, 'error') !== false || strpos($output, 'Error') !== false) {
                $errorLogContent .= $output;
            }
        }

        // Close the pipe
        pclose($process);

        // Concatenate the running log and error log content
        $logContent = $runningLog . $errorLogContent;

        // Write the log content to the error log file
        file_put_contents($errorLogPath, $logContent, FILE_APPEND); // Append mode to keep previous logs

        // Determine the status based on the presence of error log content
        $status = empty($errorLogContent) ? 'Completed' : 'Fail';
        $result = empty($errorLogContent) ? 'Pass' : 'Fail';

        // Get the list of screenshots and videos
        $mediaFiles = glob($mediaPath . '/*.{png,mp4}', GLOB_BRACE);

        // Create CyRunnerLog entry
        $response =  CyRunnerLog::create([
            'group_id' => $project_id,
            'cy_runner_id' => $id,
            'user_id' => $user_id,
            'payload' => $logContent,
            'status' => $status,
            'result' => $result,
        ]);

        $sourcePath = storage_path('/../cypress/videos/runner.cy.js.mp4');
        $destinationPath = storage_path('/app/public/videos' . "/" . $response->id);

        if (!file_exists($destinationPath)) {
            mkdir($destinationPath, 0755, true);
        }

        if (file_exists($sourcePath)) {
            $filename = pathinfo($sourcePath, PATHINFO_BASENAME);

            if (copy($sourcePath, $destinationPath . '/' . $filename)) {
                // echo "File copied successfully.";
            }
        }

        $request_link = "#";
        $logContent = 'Ref Screenshot Image Link: ' . $request_link . PHP_EOL;
        $logContent .= 'Ref Video Link: ' . asset("storage/videos/{$response->id}/runner.cy.js.mp4") . PHP_EOL;

        // Upload in task board
        // $this->errorTaskCreate($project->project_register_id, $output, $request_link);

        return $response;
    }

    function replaceKeysWithValuePattern($fileCode, $dynamicJson)
    {
        // Extract key-value pairs from the file code
        if (!preg_match_all('/####(.*?)####/', $fileCode, $matches)) {
            return 0; // If pattern not found, return false
        }

        // Initialize an empty associative array to store key-value pairs
        $pattern = [];
        $file_pattern = [];
        // Loop through the matches and extract keys and values
        foreach ($matches[1] as $match) {
            // Split the match into key and value using ':'
            $parts = explode(':', $match, 2);
            // If ':' is not present, use the entire match as the key
            $key = $parts[0];
            $value = isset($parts[1]) ? $parts[1] : $match;
            // Add the key-value pair to the data array
            $file_pattern['####' . $match . '####'] = $value;
            $pattern[$key] = $value;
        }

        $data = [];
        foreach ($pattern as $key => $value) {
            switch (true) {
                case strpos($key, 'f_') === 0:
                    $replaceKey = substr($key, 2);
                    $value = cyFaker($replaceKey);
                    break;
                case strpos($key, 'd_') === 0:
                    $value = cyDynamic($key, $dynamicJson);
                    break;

                default:
                    break;
            }

            $data['####' . $key . '####'] = $value;
        }

        return $data;
    }



    public function errorTaskCreate($project_register_id, $error_msg, $request_link)
    {
        $client = new Client();

        $headers = [
            'Accept' => 'application/json',
        ];

        $options = [
            'multipart' => [
                [
                    'name' => 'project_register_id',
                    'contents' => $project_register_id,
                ],
                [
                    'name' => 'error_msg',
                    'contents' => $error_msg,
                ],
                [
                    'name' => 'request_link',
                    'contents' => $request_link,
                ],
            ],
            'verify' => false, // Enable SSL certificate verification
        ];

        $response = $client->post('https://hq.defenzelite.com/api/v1/task/add-exception', [
            'headers' => $headers,
            'multipart' => $options['multipart'],
            'verify' => false,
        ]);

        // Check if the request was successful
        if ($response->getStatusCode() == 200) {
            // Request was successful
            return true;
        } else {
            // Request failed, handle the error
            return false;
        }
    }



    public function extractCypressError($rawContent)
    {
        $startPos = strpos($rawContent, "CypressError:");
        if ($startPos === false) {
            return null; // Return null if "CypressError:" not found
        }

        // Find the position of the next line break after "CypressError:"
        $endPos = strpos($rawContent, "\n", $startPos);
        if ($endPos === false) {
            $endPos = strlen($rawContent); // If no line break found, set end position to end of content
        }

        // Extract the content after "CypressError:" till the next line break
        $extractedContent = substr($rawContent, $startPos + strlen("CypressError:"), $endPos - $startPos - strlen("CypressError:"));

        // Trim leading and trailing whitespace
        $extractedContent = trim($extractedContent);

        return $extractedContent;
    }

    public function extractContent($rawContent, $keyword)
    {
        $startPos = strpos($rawContent, $keyword);
        if ($startPos === false) {
            return null; // Return null if keyword not found
        }

        // Find the position of the next line break after the keyword
        $endPos = strpos($rawContent, "\n", $startPos);
        if ($endPos === false) {
            $endPos = strlen($rawContent); // If no line break found, set end position to end of content
        }

        // Extract the content after the keyword till the next line break
        $extractedContent = substr($rawContent, $startPos + strlen($keyword), $endPos - $startPos - strlen($keyword));

        // Trim leading and trailing whitespace
        $extractedContent = trim($extractedContent);

        // Convert the keyword to lowercase for the array key
        $key = strtolower($keyword);

        return [$key => $extractedContent];
    }
}
