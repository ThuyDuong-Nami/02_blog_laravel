<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Imports\UsersImport;

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
}
