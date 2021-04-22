<?php


namespace App\Contracts;


interface DBContract
{
    public function importData(string $fileName): array;
    public function exportData(string $fileName, int $limit);
}
