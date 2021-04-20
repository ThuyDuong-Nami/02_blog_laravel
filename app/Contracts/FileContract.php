<?php


namespace App\Contracts;


interface FileContract
{
    public function read(string $fileName): string;
    public function write(string $fileName);

    public function readActiveSheet(string $fileName): array;
    public function writeExcel(string $fileName);
}
