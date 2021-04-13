<?php


namespace App\Services;


use App\Contracts\FileContract;

class FileService implements FileContract
{
    public function read(string $fileName): string
    {
        $file = @fopen($fileName, 'r');
        $dataFile = fread($file, filesize($fileName));
        fclose($file);
        return $dataFile;
    }

    public function write(string $fileName)
    {
        $file = @fopen($fileName, 'w');
        return $file;
        fclose($file);
    }
}
