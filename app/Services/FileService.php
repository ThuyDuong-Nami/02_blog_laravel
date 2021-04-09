<?php


namespace App\Services;


use App\Contracts\FileContract;

class FileService implements FileContract
{

    public function read(string $fileName): string
    {
        $file = @fopen($fileName, 'r');
        $dataFile = fread($file, filesize($fileName));
        return $dataFile;
        fclose($file);
    }
}
