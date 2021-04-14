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

    public function mappingColumn(array $mappingKeys): array
    {
        $format = ['username', 'email', 'password'];
        return array_replace($mappingKeys, $format);
    }

    public function mappingHeader(string $fileName, array $mappingKeys): array
    {
        $array = $this->parse($fileName);
        $key = $this->mappingColumn($mappingKeys);
        unset($array[0]);
        for ($i = 1 ; $i <= count($array); $i++){
            $array[$i] = array_combine($key, $array[$i]);
        }
        return array_values($array);
    }
}
