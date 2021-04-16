<?php


namespace App\Contracts;


interface CsvFileContract
{
    public function parse(string $fileName): array;
    public function mappingHeader(string $fileName, array $mappingKeys): array;
    public function mappingColumn(array $keyArr, array $mappingKeys): array;
}
