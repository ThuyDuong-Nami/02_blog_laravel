<?php


namespace App\Services;

use App\Contracts\ExcelContract;
use PhpOffice\PhpSpreadsheet\IOFactory;

class ExcelService extends FileService implements ExcelContract
{
    public function readActiveSheet(string $fileName): array
    {
        $excel = IOFactory::load($fileName);
        return $excel->getActiveSheet()->toArray();
    }

    public function parse(string $fileName): array
    {
        return $this->readActiveSheet($fileName);
    }
}
