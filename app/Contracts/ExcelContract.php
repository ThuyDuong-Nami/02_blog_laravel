<?php


namespace App\Contracts;


interface ExcelContract
{
    public function readActiveSheet(string $fileName): array;
    public function parse(string $fileName): array;
}
