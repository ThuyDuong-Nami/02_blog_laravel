<?php

namespace App\Transformers;

use App\Models\Post;
use Flugg\Responder\Transformers\Transformer;

class PostTransformer extends Transformer
{
    /**
     * List of available relations.
     *
     * @var string[]
     */
    protected $relations = [
        'user' => UserTransformer::class,
    ];

    /**
     * List of autoloaded default relations.
     *
     * @var array
     */
    protected $load = [];

    /**
     * Transform the model.
     *
     * @param  \App\Models\Post $post
     * @return array
     */
    public function transform(Post $post)
    {
        return [
            'id' => (int) $post->id,
            'name' => (string) $post->name,
            'content' => (string) $post->content,
        ];
    }
}
