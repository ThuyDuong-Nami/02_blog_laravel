<?php


namespace App\Services;


use App\Contracts\FileContract;
use PhpOffice\PhpSpreadsheet\IOFactory;

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
    }

    public function readActiveSheet(string $fileName): array
    {
        $excel = IOFactory::load($fileName);
        return $excel->getActiveSheet()->toArray();
    }
}
