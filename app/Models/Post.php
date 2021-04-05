<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id',
        'name',
        'content',
    ];
    protected $perPage = 15;

    public function setPerPage($perPage)
    {
        $this->perPage = $perPage;
    }
}
