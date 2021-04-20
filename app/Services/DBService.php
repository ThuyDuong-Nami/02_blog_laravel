<?php


namespace App\Services;

use App\Contracts\DBContract;
use App\Models\User;

class DBService extends CsvFileService implements DBContract
{
    public function importData(string $fileName)
    {
        $arr = $this->mappingHeader($fileName, [
            'User Name' => 'username',
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
        header('Content-Type: text/csv; charset=utf-8');
        header('Content-Disposition: attachment; filename=file.csv');
        $csv = $this->write($fileName);
        $col = [
            'id' => 'Id',
            'username' => 'User Name',
            'email' => 'Email',
        ];
        $key = ['id', 'username', 'email'];
        fputcsv($csv, $this->mappingColumn($key, $col));
        $userQuery = User::select($key);
        if (!empty($limit)) {
            $userQuery = $userQuery->limit($limit);
        }
        $user = $userQuery->get();
        foreach ($user as $item){
            fputcsv($csv, $item->toArray());
        }
    }
}
