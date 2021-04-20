<?php


namespace App\Services;

use App\Contracts\CsvFileContract;

class ExcelService extends FileService implements CsvFileContract
{
    public function parse(string $fileName): array
    {
        return $this->readActiveSheet($fileName);
    }

    public function mappingHeader(string $fileName, array $mappingKeys): array
    {
        $array = $this->parse($fileName);
        $keyArr = $array[0];
        $keyArr = $this->mappingColumn($keyArr, $mappingKeys);
        unset($array[0]);
        for ($i = 1 ; $i <= count($array); $i++){
            $array[$i] = array_combine($keyArr, $array[$i]);
        }
        return array_values($array);
    }

    public function mappingColumn($keyArr, array $mappingKeys): array
    {
        for ($i = 0; $i < count($keyArr); $i++){
            if (in_array($keyArr[$i], array_keys($mappingKeys))){
                $keyArr[$i] = $mappingKeys[$keyArr[$i]];
            }
        }
        return $keyArr;
    }
}
