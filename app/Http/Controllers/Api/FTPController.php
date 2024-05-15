<?php

namespace App\Http\Controllers\Api;
use App\Http\Controllers\Controller;
    use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use App\Models\DeployConfig;
use App\Models\UserConfig;

class FTPController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
   
   
   public function validateUser(Request $request)
    {
        // Validate the incoming request data
        $validatedData = $request->validate([
            'ftp_key' => 'required',
            'name' => 'required',
            'pin' => 'required',
        ]);

        $userConfig = UserConfig::where('hq_user_name', $validatedData['name'])
            ->where('pin', $validatedData['pin'])
            ->first();

        if (!$userConfig) {
            return response([
                'status' => 'error',
                'message' => 'The user did not register in this system. Please contact the admin!',
            ]);
        }
        
    return response([
                'status' => 'success',
                'message' => 'Success',
                'data' => $userConfig,
            ]);
    }
    public function list(Request $request)
    {
    
        $request->validate([
            'ftp_key' => 'required',
        ]);

        // Check FTP Key Conditions
        if($request->ftp_key != env('FTP_API_KEY')){
            return response([
                'status' => 'success',
                'message' => 'Error',
                'message' => 'Invalid FTP Key!',
            ]);
        }
        
        $deployeConfigs = DeployConfig::select('id','name','status')
        ->where('status',1)
        ->get();

        return response([
            'status' => 'success',
            'message' => 'Success',
            'data' => $deployeConfigs,
        ]);
    }
    
    
    
    public function users(Request $request)
    {
        
     $request->validate([
            'ftp_key' =>'required',
        ]);

        // Check FTP Key Conditions
        if ($request->ftp_key!= env('FTP_API_KEY')) {
            return response([
               'status' => 'error',
               'message' => 'Error',
               'message' => 'Invalid FTP Key!',
            ]);
        }
        $userConfigs = UserConfig::all();
        
         return response([
            'status' => 'success',
            'message' => 'Success',
            'data' => $userConfigs,
        ]);
        


    }
    
    
    
    
    
     public function show(Request $request)
    {
        
     $request->validate([
            'ftp_key' =>'required',
        ]);

        // Check FTP Key Conditions
        if ($request->ftp_key!= env('FTP_API_KEY')) {
            return response([
               'status' => 'error',
               'message' => 'Error',
               'message' => 'Invalid FTP Key!',
            ]);
        }
        
           $userConfig = UserConfig::where('hq_user_id', $request->user_id)->first();

           $deployConfig = DeployConfig::where('id', $request->project_id)->first();
        
            $data = [];
            $data['userConfig'] = $userConfig;
            $data['deployConfig'] = $deployConfig;
            return $data;
    }
    
    
    
    
    public function udpateUserConfig(Request $request, $user_id)
    {
        
     $request->validate([
            'ftp_key' =>'required',
            'file_path' => 'required'
        ]);

        // Check FTP Key Conditions
        if ($request->ftp_key!= env('FTP_API_KEY')) {
            return response([
               'status' => 'error',
               'message' => 'Error',
               'message' => 'Invalid FTP Key!',
            ]);
        }
        $userConfig = UserConfig::where('hq_user_id', $request->user_id)->first();

        // Check if the userConfig is found before updating
        if ($userConfig) {
            $userConfig->update([
                "deploy_config_id" => $request->project_id,
                'payload' => [
                    "local_directory_path" => $request->file_path,
                ],
            ]);
            
            
          $deployConfig = DeployConfig::where('id', $request->project_id)->first();
        
           $data = [];
           $data['userConfig'] = $userConfig;
           $data['deployConfig'] = $deployConfig;
           
        
            return $data;
        } else {
            // Handle the case when the userConfig is not found
            return response()->json(['message' => 'UserConfig not found'], 404);
        }


    }
    

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function createFile(Request $request,$id)
    {
        
         // return $request;
        $request->validate([
            'ftp_key' => 'required',
            'user_id' => 'required'
        ]);

        $hq_user_id = $request->user_id;

        // Check FTP Key Conditions
        if($request->ftp_key != env('FTP_API_KEY')){
            return response([
                'message' => 'Invalid FTP Key!',
                'status' => 'success',
                'message' => 'Error',
            ]);
        }
        
      
     
          $staticFolderName = base_path() . '/app/Console/Commands/zTerminal/';


        // Initialize the $local_files array
        $local_files = [];

        // Call the recursive function to find all files and add their names to $local_files
         $this->findFilesAndPopulateArray($staticFolderName, $local_files);


         $deploye_config = DeployConfig::where('id',$id)
        ->where('status',1)
        ->first();

        if(!$deploye_config){
            return response([
                'status' => 'error',
                'message' => 'This id is not exists!',
            ]);
        }
        $payload = $deploye_config->payload;

        if($payload == null){
            return response([
                'status' => 'success',
                'message' => 'Please Fill the Deploye Config payload info!',
            ]);
        }
        
         $user_config = UserConfig::where('id', $hq_user_id)
        ->where('status',1)
        ->first();

        if(!$user_config){
            return response([
                'status' => 'error',
                'message' => 'This User not exists!',
            ]);
        }
        
       $user_payload = $user_config->payload;
        

        if($user_payload == null){
            return response([
                'status' => 'success',
                'message' => 'Please Fill the Deploye Config payload info!',
            ]);
        }
        
       $normalizedPath = $this->normalizePath($payload['project_directory_path']);
       
        
        $replacements = [
            "####URL####" => $payload['url'],
            "####HOST####" => $payload['host'],
            "####USERNAME####" => $payload['username'],
            "####PASSWORD####" => $payload['password'],
            "####PORT####" => $payload['port'],
            "####CORE_STRUCTURE####" => $payload['code_structure'],
            "####LOCAL_FOLDERS####" => $payload['local_folders'],
            "####LOCAL_PUBLIC_FOLDERS####" => $payload['local_public_folders'],
            "####CORE_FOLDERS####" => $payload['core_folders'],
            "####PROJECT_DIRECTORY_PATH####" => $normalizedPath,
            "####LOCAL_PROJECT_DIRECTORY_PATH####" => $user_payload['local_directory_path'],
            "####LAST_DEPLOYMENT_AT####" => $request->has('last_deployment_at') ? $request->get('last_deployment_at') : strtotime(date('Y-m-d H:i:s')),
            "####PROJECT_NAME####" => $deploye_config->name,
        ];
        
        $allFiles = [];
        // Loop through each local folder
        foreach ($local_files as $file) {
           
            $file_path = $file;
            $str_replace_file =  str_replace('.php', '', basename($file_path));
            $replacements[$str_replace_file] = "Runner";
             
            // Read the content of the file
            $file_content = file_get_contents($file_path);
            
            // Replace each placeholder with its corresponding value
            $new_content = str_replace(array_keys($replacements), array_values($replacements), $file_content);
        
            // Specify the destination folder structure
            $destination_folder = base_path() . DIRECTORY_SEPARATOR . '..' .  DIRECTORY_SEPARATOR . 'zterminal.dze-labs.xyz' .  DIRECTORY_SEPARATOR ."storage" . DIRECTORY_SEPARATOR . "app" . DIRECTORY_SEPARATOR . "zterminal" . DIRECTORY_SEPARATOR . "temp" . DIRECTORY_SEPARATOR . $id . DIRECTORY_SEPARATOR . $hq_user_id;

            // Create the destination folder if it doesn't exist
            File::makeDirectory($destination_folder, 0777, true, true);

         
            $ftp_code = $this->GetFTPFileCode(basename($file));

            // Create a new file with the updated content
            $new_file_path = $destination_folder . DIRECTORY_SEPARATOR . $ftp_code . '.z';
            
            if (file_exists($new_file_path)) {
                unlink($new_file_path);
            }
             
           // return $new_content = $this->phpCodeEncrypter($new_content);
          file_put_contents($new_file_path, $new_content);

            
        }
        
        $user_config->deploy_config_id = $id; 
          $user_config->save();

        
        return response([
            'status' => 'success',
        ]);
    }
    
    
    
    
    
    
    
  private function normalizePath($path) {
    $parts = explode('/', $path); // Split the path by '/'
    $normalizedPath = '';

    foreach ($parts as $part) {
        if ($part === '..') {
            $normalizedPath .= " . DIRECTORY_SEPARATOR . '$part'";
        } elseif ($part !== '') {
            if ($normalizedPath !== '') {
                $normalizedPath .= " . DIRECTORY_SEPARATOR . ";
            }
            $normalizedPath .= "'$part'";
        }
    }

    return "__DIR__ $normalizedPath . DIRECTORY_SEPARATOR";
}


    private function findFilesAndPopulateArray($directory, &$local_files)
    {
        // Get all files and directories in the current directory
        $items = File::allFiles($directory);
         
        foreach ($items as $item) {
            if ($item->isFile()) {
                // If it's a file, add its name to $local_files
                $local_files[] = $item->getPathname();
            } elseif ($item->isDir()) {
                // If it's a directory, recursively call the function for that directory
                $this->findFilesAndPopulateArray($item->getPathname(), $local_files);
            }
        }
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function content(Request $request)
    {
        // return $request;
        $request->validate([
            'ftp_key' => 'required',
            'file_name' => 'required',
        ]);

        // Check FTP Key Conditions
        if($request->ftp_key != env('FTP_API_KEY')){
            return response([
                'message' => 'Invalid FTP Key!',
                'status' => 'success',
                'message' => 'Error',
            ]);
        }
        // Specify the root directory (public_html in this case)
        $rootDirectory = public_path().'/subdomains/hq/';

        // Specify the static folder name
        $staticFolderName = 'zterminal';
        if($request->file_name){
            $targetFileName = $request->file_name; 
    
            // Call the recursive function to find the target PHP file
            $targetFilePath = $this->findPhpFile($rootDirectory . DIRECTORY_SEPARATOR . $staticFolderName, $targetFileName);
    
            if ($targetFilePath) {
                if (pathinfo($targetFileName, PATHINFO_EXTENSION) === '') {
                    return response([
                        'status' => 'error',
                        'message' => 'Invalid file name. Please provide a file name with an extension.',
                    ]);
                } else {
                    $decodedContent = $this->getDecodedContent($targetFilePath);
                    
                    if ($decodedContent !== false) {
                        return response([
                            'status' => 'success',
                            'message' => 'Success',
                            'data' => $decodedContent . PHP_EOL,
                        ]);
                    } else {
                        return response([
                            'status' => 'error',
                            'message' => 'Unable to decode the content of the PHP file.',
                        ]);
                    }
                }
            } else {
                return response([
                    'status' => 'error',
                    'message' => 'PHP file not found',
                ]);
            }
        }else{
            return response([
                'status' => 'error',
                'message' => 'File Name is required!',
            ]);
        }
    }
    
    private function findPhpFile($directory, $targetFileName)
    {
        $files = File::allFiles($directory);

        foreach ($files as $file) {
            // Check if the file has the target PHP file name
            if ($file->getFilename() === $targetFileName) {
                return $file->getPathname();
            }
        }

        // Get all subdirectories in the current directory
        $subdirectories = File::directories($directory);

        foreach ($subdirectories as $subdirectory) {
            // Recursively call the function for each subdirectory
            $result = $this->findPhpFile($subdirectory, $targetFileName);
            
            if ($result) {
                return $result; 
            }
        }

        return null; 
    }

    private function getDecodedContent($filePath)
    {
        // Check if the file exists
        if (file_exists($filePath)) {
            // Read the content of the file and decode it
            $content = file_get_contents($filePath);

            // Return the decoded content
            return $content !== false ? $content : false;
        }

        return false;
    }
    
    
    private function GetFTPFileCode($name,$type = 'file'){
        $ftp_codes = [
            "Deployer.php" => "XYZ123QD123",
            "DeployerPublic.php" => "XYZ789DP789",
            "Rollback.php" => "XYZ234RB234",
            "Dependencies.php" => "XYZ345DD345",
            "Htaccess.php" => "XYZ456HT456",
            "Optimize.php" => "XYZ567OM567",
            "Permission.php" => "XYZ678PM234",
            "Symbolic.php" => "XYZ234SB234",
            "Format.php" => "XYZ234FM234",
            "SetupDeployer.php" => "XYZ987SD987",
            "DbCleaner.php" => "XYZ897DC897",
            "Doctor.php" => "XYZ896DF896",
            "DbBackup.php" => "XYZ888DBP888",
            "dbbackup.blade.php" => "BCD888DBP888",
            "doctorChecker.blade.php" => "BCD896DF896",
            "doctorFixer.blade.php" => "BCD895DF895",
            "dbcleaner.blade.php" => "BCD897DC897",
            "setupDeployer.blade.php" => "BCD987SD987",
            "deployer.blade.php" => "BCD123QD123",
            "rollback.blade.php" => "BCD234RB234",
            "permission.blade.php" => "BCD345PM345",
            "optimize.blade.php" => "BCD456OM456",
            "dependencies.blade.php" => "BCD567DD567",
            "scanvirus.blade.php" => "BCD789PL789",
            "smartDeployer.blade.php" => "BCD891SM891",
            "symbolic.blade.php" => "BCD234SB234",
        ];
    
        if($type == 'file'){
            if(array_key_exists($name, $ftp_codes)){
                $key_value = $ftp_codes[$name];
            } else {
                $key_value = 'UNKNOWN';
            }
        }else{
            $found_keys = array_keys($ftp_codes, $name);
            if (!empty($found_keys)) {
                $key_value = $found_keys[0];
            } else {
                $key_value = 'UNKNOWN';
            }
        }
    
        return $key_value;
    }

    private function phpCodeEncrypter($phpCode) {
        // Match all variable names using a regular expression
        preg_match_all('/\$[a-zA-Z_\x7f-\xff][a-zA-Z0-9_\x7f-\xff]*/', $phpCode, $matches);
    
        // Get unique variable names
         $uniqueVariables = array_unique($matches[0]);
        // Replace each variable with a unique random string of 25 characters
        $whitelisted_vars = ['$data','$signature','$dynamicPath','$host_url', '$ftp_host', '$ftp_user', '$ftp_password', '$ftp_port', '$ftp_folder','$host','$zip_name','$local_folders' ,'$server_project_directory','$description','$this','this'];
        foreach ($uniqueVariables as $variable) {
            $code_temp = $this->generateRandomString(25);
            // echo "@#$%^&*: ".in_array($variable, $whitelisted_vars)."VAR: ".$variable."<br>";
            if (!in_array($variable, $whitelisted_vars)) {
                $randomString = $code_temp;
                $phpCode = str_replace($variable, '$' . $randomString, $phpCode);
            }
        }
        
        // $minifiedCode = $this->minifyPhpCode($phpCode);
        $minifiedCode = $phpCode;
    
        return $minifiedCode;
    }
    
    private function generateRandomString($length) {
        $characters = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, strlen($characters) - 1)];
        }
        
        return $randomString;
    }

private function minifyPhpCode($inputCode)
{
    // Remove comments (single-line and multi-line)
    $minifiedCode = preg_replace('/\/\/[^\n\r]*|\/\*.*?\*\//s', '', $inputCode);

    // Remove spaces and tabs at the beginning and end of each line
    $minifiedCode = preg_replace('/^\s+|\s+$/m', '', $minifiedCode);

    // Remove extra spaces between tokens, excluding URLs
    $minifiedCode = preg_replace('/(?<!https:|http:|ftp:|\/\/)\s+/m', ' ', $minifiedCode);

    return $minifiedCode;
}

}
