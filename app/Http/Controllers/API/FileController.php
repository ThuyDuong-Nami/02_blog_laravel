<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Services\CsvFileService;
use App\Services\DBService;
use App\Transformers\UserTransformer;
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
        $data = $file->mappingHeader($filePath);
        return response()->json($data, 200);
    }

    public function import(Request $request)
    {
        $filePath = $request->file('filePath');
        $file = new DBService();
        $data = $file->importData($filePath);
        return response()->json([
            'message' => 'Import or Update Data Success!',
            'records' => $data,
        ], 200);
    }

    public function export(Request $request)
    {
        $filePath = $request->input('filePath');
        $limit = $request->input('limit');
        $file = new DBService();
        if (!$limit){
            $limit = 0;
        }
        $file->exportData($filePath,$limit);
        return response()->json([
            'message' => 'Export Data Success!'
        ], 200);
    }
}
