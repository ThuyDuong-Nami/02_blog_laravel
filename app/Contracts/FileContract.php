<?php


namespace App\Contracts;


interface FileContract
{
    public function read(string $fileName): string;
}
