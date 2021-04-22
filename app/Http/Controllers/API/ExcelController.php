<?php

namespace App\Http\Controllers\API;

use App\Exports\UsersExport;
use App\Http\Controllers\Controller;
use App\Imports\UsersImport;
use App\Services\DBExcelService;
use App\Services\ExcelService;

class ExcelController extends Controller
{
    public function import()
    {
        $file = request()->file('filePath');
        (new UsersImport())->import($file);
        return response()->json([
            'message' => 'Import or Update Excel file success',
        ], 200);
    }

    public function export()
    {
        $file = request()->input('fileName');
        return (new UsersExport)->download($file);
    }

    public function readExcel()
    {
        $fileName = request()->file('fileName');
        $file = new ExcelService();
        $data = $file->parse($fileName);
        return response()->json($data, 200);
    }

    public function mapping()
    {
        $fileName = request()->file('fileName');
        $file = new ExcelService();
        $col = [
            'UserName' => 'username',
            'Email' => 'email',
            'Password' => 'password',
        ];
        $data = $file->mappingHeader($fileName, $col);
        return response()->json($data, 200);
    }

    public function importExcel()
    {
        $fileName = request()->file('fileName');
        $file = new DBExcelService();
        $data = $file->importData($fileName);
        return response()->json([
           'message' => 'Import and Update excel file success!',
           'records' => $data,
        ], 200);
    }
}
