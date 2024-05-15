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


namespace App\Services;

use Exception;

class FtpService
{
    private $connection;

    public function __construct($host, $username, $password, $port = 21)
    {
        $this->connection = ftp_connect($host, $port);
        if (!$this->connection) {
            throw new Exception("Could not connect to FTP server: $host");
        }

        $loginResult = ftp_login($this->connection, $username, $password);
        if (!$loginResult) {
            throw new Exception("Could not log in to FTP server: $username");
        }
    }

    public function connect()
    {
        ftp_pasv($this->connection, true); // Enable passive mode
    }

    public function uploadFile($localFilePath, $remoteFilePath)
    {
        if (!ftp_put($this->connection, $remoteFilePath, $localFilePath, FTP_BINARY)) {
            throw new Exception("Failed to upload file: $localFilePath");
        }
    }

    public function uploadFileWithProgress($localFilePath, $remoteDirPath)
    {
        $remoteFilePath = rtrim($remoteDirPath, '/') . '/' . basename($localFilePath);

        $fp = fopen($localFilePath, 'r');
        if (!$fp) {
            throw new Exception("Cannot open local file: $localFilePath");
        }

        $uploadResult = ftp_nb_fput($this->connection, $remoteFilePath, $fp, FTP_BINARY);
        if ($uploadResult == FTP_FAILED) {
            fclose($fp);
            throw new Exception("Failed to start upload: $localFilePath");
        }

        // Monitoring upload progress
        $localFileSize = filesize($localFilePath);
        while ($uploadResult == FTP_MOREDATA) {
            // Continue the upload
            $uploadResult = ftp_nb_continue($this->connection);

            // Progress monitoring logic here (similar to your existing code)
            // ...

            if (!isset($progress) || $progress >= 100) {
                break;
            }
        }

        if ($uploadResult != FTP_FINISHED) {
            fclose($fp);
            throw new Exception("Failed to complete upload: $localFilePath");
        }

        fclose($fp);
        return $remoteFilePath;
    }

    public function disconnect()
    {
        ftp_close($this->connection);
    }
}
