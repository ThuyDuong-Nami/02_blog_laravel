<?php


namespace App\Services;


use App\Contracts\DBContract;
use App\Models\User;

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
        // TODO: Implement exportData() method.
    }
}
