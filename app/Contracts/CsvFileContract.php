<?php


namespace App\Contracts;


interface CsvFileContract
{
    public function parse(string $fileName): array;
    public function mappingColumn(string $csv): string;
}
