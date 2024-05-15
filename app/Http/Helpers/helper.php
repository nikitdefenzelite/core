<?php
/**
 *
 * @category ZStarter
 *
 * @ref     Defenzelite product
 * @author  <Defenzelite hq@defenzelite.com>
 * @license <https://www.defenzelite.com Defenzelite Private Limited>
 * @version <zStarter: 202309-V1.3>
 * @link    <https://www.defenzelite.com>
 */

use Faker\Factory as Faker;

function removeFolder($folderPath)
{
    if (is_dir($folderPath)) {
        $files = scandir($folderPath);

        foreach ($files as $file) {
            if ($file != '.' && $file != '..') {
                $filePath = $folderPath . '/' . $file;

                if (is_file($filePath)) {
                    unlink($filePath);
                } elseif (is_dir($filePath)) {
                    removeFolder($filePath);
                }
            }
        }

        rmdir($folderPath);
        //     echo "Folder '$folderPath' has been removed.";
    } else {
        //     echo "Folder '$folderPath' not found.";
    }
}

function processFilesAndCopy($rootPath, $arr, $local_directory)
{
    // Step 1: Check if ".z" folder exists, if not, create it
    $zFolderPath = $rootPath . '/.z';
    if (!file_exists($zFolderPath)) {
        mkdir($zFolderPath);
    }

    // Step 2: Create $arr = [config] directories tree
   // $arr = ['lang','app','resources','routes','config'];

    foreach ($arr as $directory) {
        $directoryPath = $local_directory . '/' . $directory;
        copyDirectory($directoryPath, $zFolderPath . '/' . $directory, $arr);
    }

    // Step 4: Return true once it's done
    return true;
}

function copyDirectory($source, $destination, $arr)
{
    if (!file_exists($destination)) {
        mkdir($destination, 0777, true);
    }

    $iterator = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($source, RecursiveDirectoryIterator::SKIP_DOTS), RecursiveIteratorIterator::SELF_FIRST);

    foreach ($iterator as $item) {
        $subDirectory = $destination . DIRECTORY_SEPARATOR . $iterator->getSubPathName();

        if ($item->isDir() && in_array($item->getBasename(), $arr)) {
            if (!file_exists($subDirectory)) {
                mkdir($subDirectory, 0777, true); // Ensure proper permissions
            }
        } elseif ($item->isFile()) {
            $filePath = $item->getPathName();
            $destinationPath = $destination . DIRECTORY_SEPARATOR . $iterator->getSubPathName();

            // Check if the file's last modified time is greater than the current local time
            $fileDateTime = filemtime($filePath);
            $currentDateTime = 1705994062; // Use current time

            var_dump($fileDateTime);
            var_dump($currentDateTime);

            if ($fileDateTime > $currentDateTime) {
                try {
                     // Check if the destination directory exists, create if not
                     if (!file_exists(dirname($destinationPath))) {
                        mkdir(dirname($destinationPath), 0777, true);
                    }

                    // Copy the file
                    if (file_exists($filePath) && file_exists(dirname($destinationPath))) {
                        copy($filePath, $destinationPath);
                    } else {
                        echo "Source file or destination directory doesn't exist for: $filePath\n";
                    }
                } catch (Exception $e) {
                    echo "Error copying file: $filePath. Error message: " . $e->getMessage() . "\n";
                }
            }
        }
    }
}
if (!function_exists('getGreetingBasedOnTime')) {
    function getGreetingBasedOnTime()
    {
        $utc_time = auth()->user()->timezone;
        $timezone = $utc_time != null ? $utc_time : 'UTC';
        $dat = new DateTime('now', new DateTimeZone($timezone));
        $hour = $dat->format('H');
        if ($hour >= 20) {
            $greetings = "Good Night";
        } elseif ($hour > 17) {
            $greetings = "Good Evening";
        } elseif ($hour > 11) {
            $greetings = "Good Afternoon";
        } elseif ($hour < 12) {
            $greetings = "Good Morning";
        }
        return $greetings;
    }
}

if (!function_exists('getSetting')) {
    function getSetting($key)
    {
        if (is_array($key)) {
            $records = App\Models\Setting::select('group', 'key', 'value')->whereIn('group', $key)->get();
            $settings = [];
            foreach ($records as $key => $record) {
                $settings[$record->key] = $record->value;
            }
        } else {
            $settings = App\Models\Setting::where('key', $key)->first()->value ?? '';
        }
        return $settings;
    }
}
if (!function_exists('UserRole')) {
    function UserRole($id)
    {
        return App\Models\User::find($id)->roles ? App\Models\User::find($id)->roles[0] : null;
    }
}
if (!function_exists('getAdminId')) {
    function getAdminId()
    {
        return App\Models\User::whereRoleIs(['Admin'])->value('id');
    }
}
if (!function_exists('fileExists')) {
    function fileExists($path)
    {
        return File::exists($path);
    }
}
function getKeysByValue($val, $array)
{
    $arr = [];
    foreach ($array as $k => $ar) {
        if (is_array($ar)) {
            getKeysByValue($val, $ar);
        } else {
            if ($val == $ar) {
                $arr[] = $k;
            }
        }
    }
    return $arr;
}
function str_after($str, $search)
{
    return $search === '' ? $str : array_reverse(explode($search, $str, 2))[0];
}
function getSelectValues($arr, $noKey = true, $char = ":")
{
    if ($noKey) {
        $temp = [];
        foreach ($arr as $key => $val) {
            $temp[] = str_after($val, ":");
        }
        return $temp;
    } else {
        $temp = [];
        foreach ($arr as $key => $val) {
            if (str_contains($val, $char)) {
                $temp[explode($char, $val)[0]] = explode($char, $val)[1];
            } else {
                $temp[$val] = $temp[$val];
            }
        }
        return $temp;
    }
}

// Cypress Helpers

// STATIC: s_email*
// ####s_email:luck.nema@gmail.com####
function cyStatic($key){
    return "luck.nema@gmail.com";
}

// DYNAMIC: d_email:json_name
// ####d_email:pr.json####
function cyDynamic($key, $json){
    // Check if the key exists in the JSON array
    if (array_key_exists($key, $json)) {
        // If the key exists, return its corresponding value
        return $json[$key];
    } else {
        // If the key does not exist, return null or handle the case as needed
        return $json[$key];
    }
}
if (!function_exists('activeClassIfRoutes')) {
    function activeClassIfRoutes($routes, $output = 'active', $fallback = '')
    {
        if (in_array(Route::currentRouteName(), $routes)) {
            return $output;
        } else {
            return $fallback;
        }
    }
}
if (!function_exists('activeClassIfRoute')) {
    function activeClassIfRoute($route, $output = 'active', $fallback = '')
    {
        if (Route::currentRouteName() == $route) {
            return $output;
        } else {
            return $fallback;
        }
    }
}

if (!function_exists('secureToken')) {
    function secureToken($id, $mode = 'encrypt')
    {
        if (env('SECURE_ENDPOINT') == 0) {
            return $id;
        }
        if ($mode == 'encrypt') {
            return encrypt($id);
        } else {
            return decrypt($id);
        }
    }
}
if (!function_exists('tableLimits')) {
    function tableLimits()
    {
        return [
            10, 50, 100, 500, 1000, 5000
        ];
    }

}
function commentOutStart()
{
    return "{{--";
}

function commentOutEnd()
{
    return "--}}";
}



// FAKER:                                           *
// ####f_email####
function cyFaker($key){
    $faker = Faker::create();
    if ($key === 'dob') {
        return $faker->dateTimeThisCentury->format('Y-m-d');
    }  elseif ($key === 'gender') {
        $gender = $faker->randomElement(['male', 'female']);
        return $gender;
    } else {
        return $faker->$key;
    }
}