<?php


namespace App\Services;


use App\Contracts\CsvFileContract;
use App\Models\User;

class CsvFileService extends FileService implements CsvFileContract
{

    public function parse(string $fileName): array
    {
        $csv = $this->read($fileName);
        $lines = explode("\n", $csv);
        $array = array();
        foreach ($lines as $line) {
            if ($line == ""){
                unset($line);
            }else{
                $array[] = str_getcsv($line);
            }
        }
        return $array;
    }

    public function mappingHeader(string $fileName, array $mappingKeys): array
    {
        $array = $this->parse($fileName);
        unset($array[0]);
        for ($i = 1 ; $i <= count($array); $i++){
            $array[$i] = array_combine($mappingKeys, $array[$i]);
        }
        return array_values($array);
    }
}
