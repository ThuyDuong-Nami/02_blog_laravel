<?php

namespace App\Http\Controllers\API;

use App\Exports\UsersExport;
use App\Http\Controllers\Controller;
use App\Imports\UsersImport;
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
        $array = $file->parse($fileName);
        $data = $file->mappingHeader($array, $col);
        return response()->json($data, 200);
    }
}
