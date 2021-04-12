<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Services\CsvFileService;
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

    public function import(Request $request)
    {
        $filePath = $request->file('filePath');
        $file = new CsvFileService();
        $data = $file->importData($filePath);
        return response()->json([
            'message' => 'Import Data Success!',
            'data' => $data,
        ], 200);
    }
}
