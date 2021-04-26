<?php


namespace App\Contracts;


interface FileContract
{
    public function read(string $fileName): string;
    public function write(string $fileName);

    public function mappingHeader(array $array, array $mappingKeys): array;
    public function mappingColumn(array $keyArr, array $mappingKeys): array;
}
