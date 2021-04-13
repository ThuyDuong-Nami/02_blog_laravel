<?php


namespace App\Contracts;


interface FileContract
{
    public function read(string $fileName): string;
    public function write(string $fileName);
}
