<?php


namespace App\Services;

use App\Contracts\DBContract;
use App\Models\User;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Exception;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class DBExcelService extends ExcelService implements DBContract
{

    public function importData(string $fileName): array
    {
        $arr = $this->mappingHeader($fileName, [
            'UserName' => 'username',
            'Email' => 'email',
            'Password' => 'password'
        ]);
        $update = 0;
        $insert = 0;
        foreach ($arr as $item){
            if ($user = User::where('username', $item['username'])
                ->orWhere('email', $item['email'])->first())
            {
                $user->update($item);
                $update++;
            }else{
                $user[] = User::create($item);
                $insert++;
            }
        }
        return array(
            'Import Data' => $insert,
            'Update Data' => $update
        );
    }

    public function exportData(string $fileName, int $limit)
    {
        header('Content-Type: application/vnd-ms-excel; charset=utf-8');
        header('Content-Disposition: attachment;filename='.$fileName);
        $col = [
            'id' => 'Id',
            'username' => 'User Name',
            'email' => 'Email',
        ];

        $key = ['id', 'username', 'email'];
        $title = $this->mappingColumn($key, $col);

        $spreadSheet = new Spreadsheet();
        $sheet = $spreadSheet->getActiveSheet();

        $char = chr(65);
        $row = 1;
        for ($i = 1; $i <= count($title); $i++){
            $sheet->setCellValue($char.$row, $title[$i-1]);
            $char++;
        }

        $userQuery = User::select($key);
        if (!empty($limit)) {
            $userQuery = $userQuery->limit($limit);
        }
        $user = $userQuery->get();
        $row = 2;
        foreach ($user->toArray() as $item){
            $sheet->setCellValue('A'.$row, $item['id']);
            $sheet->setCellValue('B'.$row, $item['username']);
            $sheet->setCellValue('C'.$row, $item['email']);
            $row++;
        }

        $writer = IOFactory::createWriter($spreadSheet, 'Xlsx');
        $writer->save('php://output');
    }
}
