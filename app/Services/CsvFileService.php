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

    public function mappingHeader(string $fileName, array $mappingKeys)
    {
        $array = $this->parse($fileName);
        $key_arr = $array[0];
        $key_arr = $this->mappingColumn($key_arr, $mappingKeys);
        unset($array[0]);
        for ($i = 1 ; $i <= count($array); $i++){
            $array[$i] = array_combine($key_arr, $array[$i]);
        }
        return array_values($array);
    }

    public function mappingColumn(array $key_arr, array $mappingKeys)
    {
        for ($i = 0; $i < count($key_arr); $i++){
            if (in_array($key_arr[$i], array_keys($mappingKeys))){
                $key_arr[$i] = $mappingKeys[$key_arr[$i]];
            }
        }
        return $key_arr;
    }
}
