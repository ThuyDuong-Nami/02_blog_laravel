<?php


namespace App\Services;


use App\Contracts\CsvFileContract;

class CsvFileService extends FileService implements CsvFileContract
{

    public function parse(string $fileName): array
    {
        // TODO: Implement parse() method.
    }

    public function parseFromContent(string $fileContent): array
    {
        // TODO: Implement parseFromContent() method.
    }
}
