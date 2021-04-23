<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Services\CsvFileService;
use App\Services\DBExcelService;
use App\Services\DBService;
use Illuminate\Http\Request;

class FileController extends Controller
{
    public function readCSV(Request $request)
    {
        $filePath = $request->file('filePath');
        $file = new CsvFileService();
        $data = $file->parse($filePath);
        return response()->json($data, 200);
    }

    public function mapping(Request $request)
    {
        $filePath = $request->file('filePath');
        $file = new CsvFileService();
        $col = [
            'User Name' => 'username',
            'Email' => 'email',
            'Password' => 'password',
        ];
        $array = $file->parse($filePath);
        $data = $file->mappingHeader($array, $col);
        return response()->json($data, 200);
    }

    public function import(Request $request)
    {
        $filePath = $request->file('filePath');
        $option = $request->input('option');
        switch ($option){
            case 'csv' :
                $file = new DBService();
                $data = $file->importData($filePath);
                return response()->json([
                    'message' => 'Import or Update Data Success!',
                    'records' => $data,
                ], 200);
            case 'xlsx' :
                $file = new DBExcelService();
                $data = $file->importData($filePath);
                return response()->json([
                    'message' => 'Import or Update Data Success!',
                    'records' => $data,
                ], 200);
            default :
                return response()->json([
                    'error' => 'Please choose the correct format!',
                ], 422);
        }
    }

    public function export(Request $request)
    {
        $filePath = $request->input('filePath');
        $option = $request->input('option');
        $limit = $request->input('limit');
        if (!$limit){
            $limit = 0;
        }
        switch ($option){
            case 'csv' :
                $file = new DBService();
                $file->exportData($filePath,$limit);
            case 'xlsx' :
                $file = new DBExcelService();
                $file->exportData($filePath, $limit);
            default :
                return response()->json([
                    'error' => 'Please choose the correct format!',
                ], 422);
        }
    }
}
