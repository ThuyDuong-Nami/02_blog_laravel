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
        return @fopen('php://output', 'w');
    }

    public function mappingHeader(array $array, array $mappingKeys): array
    {
        $keyArr = $array[0];
        $keyArr = $this->mappingColumn($keyArr, $mappingKeys);
        unset($array[0]);
        for ($i = 1 ; $i <= count($array); $i++){
            $array[$i] = array_combine($keyArr, $array[$i]);
        }
        return array_values($array);
    }

    public function mappingColumn(array $keyArr, array $mappingKeys): array
    {
        for ($i = 0; $i < count($keyArr); $i++){
            if (in_array($keyArr[$i], array_keys($mappingKeys))){
                $keyArr[$i] = $mappingKeys[$keyArr[$i]];
            }
        }
        return $keyArr;
    }
}
