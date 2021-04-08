<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class FileController extends Controller
{
    public function readFile()
    {
        $filepath = 'storage/demo.txt';
        if (file_exists($filepath)){
            $file = @fopen($filepath, 'r');
            $dataFile = fread($file, filesize($filepath));
            return response()->json($dataFile, 200);
            fclose($file);
        }else{
            return response()->json([
                'message' => 'File không tồn tại'
            ], 422);
        }
    }

    public function readCSV()
    {
        $filepath = 'storage/test.csv';
        if (file_exists($filepath)){
            $file = @fopen($filepath, 'r');
            while (($dataFile = fgetcsv($file)) !== false){
                $csv[] = $dataFile;
            }
            return response()->json($csv, 200);
            fclose($file);
        }else{
            return response()->json([
                'message' => 'File không tồn tại'
            ], 422);
        }
    }

    public function mappingColumn($csv)
    {
        $format = [
            'username',
            'email',
            'password',
        ];
        for ($i = 0; $i < count($csv); $i++){
            for ($j = 0; $j < count($format); $j++){
                if ($i == $j){
                    $csv[$i] = $format[$j];
                }

            }
        }
        return $csv;
    }

    public function formCSV()
    {
        $filepath = 'storage/test.csv';
        if (file_exists($filepath)){
            $file = @fopen($filepath, 'r');
            while (($dataFile = fgetcsv($file)) !== false){
                $csv[] = $dataFile;
            }
            $csv[0] = $this->mappingColumn($csv[0]);
            return response()->json($csv, 200);
            fclose($file);
        }else{
            return response()->json([
                'message' => 'File không tồn tại'
            ], 422);
        }
    }
}
