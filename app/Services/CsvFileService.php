<?php


namespace App\Services;


use App\Contracts\CsvFileContract;

class CsvFileService extends FileService implements CsvFileContract
{

    public function parse(string $fileName): array
    {
        $csv = $this->read($fileName);
        $lines = explode(PHP_EOL, $csv);
        $key = str_getcsv($this->mappingColumn($lines[0]));
        unset($lines[0]);
        $array = array();
        foreach ($lines as $line) {
            if ($line == ""){
                unset($line);
            }else{
                $array[] = str_getcsv($line);
            }
        }
        for ($i = 0 ; $i < count($array); $i++){
            $array[$i] = array_combine($key, $array[$i]);
        }
        return $array;
    }

    public function mappingColumn(string $csv): string
    {
        $csv = strtolower($csv);
        $csv = trim(str_replace(" ","", $csv));
        return $csv;
    }
}
