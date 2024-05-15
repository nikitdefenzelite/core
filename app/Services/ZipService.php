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

use ZipArchive;
use Exception;

class ZipService
{
    public function createZip(array $folders, $destinationPath)
    {
        $zip = new ZipArchive();
        $zipFilePath = $destinationPath . '/deployment_' . date('YmdHis') . '.zip';

        if ($zip->open($zipFilePath, ZipArchive::CREATE | ZipArchive::OVERWRITE) !== true) {
            throw new Exception("Cannot open <$zipFilePath>");
        }

        foreach ($folders as $folder) {
            $folderPath = base_path($folder);
            $this->addFolderToZip($zip, $folderPath, basename($folderPath));
        }

        $zip->close();

        return $zipFilePath;
    }

    private function addFolderToZip($zip, $folderPath, $relativePath = '')
    {
        if (!is_dir($folderPath)) {
            throw new Exception("Folder not found: $folderPath");
        }

        $files = scandir($folderPath);
        foreach ($files as $file) {
            if ($file != '.' && $file != '..') {
                $filePath = "$folderPath/$file";
                $inZipPath = $relativePath ? "$relativePath/$file" : $file;
                if (is_dir($filePath)) {
                    $this->addFolderToZip($zip, $filePath, $inZipPath);
                } else {
                    $zip->addFile($filePath, $inZipPath);
                }
            }
        }
    }
}
