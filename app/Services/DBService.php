<?php


namespace App\Services;

use App\Contracts\DBContract;
use App\Models\User;

class DBService extends CsvFileService implements DBContract
{
    public function importData(string $fileName)
    {
        $arr = $this->mappingHeader($fileName);
        $update = 0;
        $insert = 0;
        foreach ($arr as $item){
            if ($user = User::where('username', $item['username'])->first()){
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
        header('Content-Type: text/csv; charset=utf-8');
        header('Content-Disposition: attachment; filename=file.csv');
        $csv = $this->write($fileName);
        fputcsv($csv, array('id', 'username', 'email'));
        if ($limit == 0){
            $limit = count(User::all());
        }
        $user = User::select('id', 'username', 'email')->limit($limit)->get();
        foreach ($user as $item){
            fputcsv($csv, $item->toArray());
        }
    }
}
