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

    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);
        $this->perPage = config('blog.perPage');
    }

    public function setPerPage($perPage)
    {
        $this->perPage = $perPage;
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
