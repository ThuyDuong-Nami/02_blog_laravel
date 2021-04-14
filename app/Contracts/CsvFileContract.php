<?php


namespace App\Contracts;


interface CsvFileContract
{
    public function parse(string $fileName): array;
    public function mappingColumn(array $mappingKeys): array;
    public function mappingHeader(string $fileName, array $mappingKeys): array;
}
