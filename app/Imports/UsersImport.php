<?php

namespace App\Imports;

use App\Models\User;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithUpserts;

class UsersImport implements ToModel, WithHeadingRow, WithUpserts
{
    use Importable;

    /**
     * @return string|array
     */
    public function uniqueBy()
    {
        return ['username', 'email'];
    }

    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        if ($user = User::where('username', $row['username'])
            ->orWhere('email', $row['email'])->first())
        {
            return $user->update($row) ?  $user : null;
        }else{
            return User::create($row);
        }
    }
}
