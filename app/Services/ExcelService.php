<?php


namespace App\Services;

use App\Contracts\CsvFileContract;

class ExcelService extends FileService implements CsvFileContract
{
    public function parse(string $fileName): array
    {
        return $this->readActiveSheet($fileName);
    }
}
