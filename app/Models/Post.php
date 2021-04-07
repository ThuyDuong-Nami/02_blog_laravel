<?php

namespace App\Models;

use App\Transformers\PostTransformer;
use Flugg\Responder\Contracts\Transformable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use League\Flysystem\Config;

class Post extends Model implements Transformable
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

    public function transformer()
    {
        return PostTransformer::class;
    }
}
