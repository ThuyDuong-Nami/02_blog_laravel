<?php


namespace App\Contracts;


interface DBContract
{
    public function importData(string $fileName);
    public function exportData(string $fileName, int $limit);
}
