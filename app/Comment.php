<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    protected $fillable = [
        'body', 'user_id', 'post_id'
    ];

    # Retorna todos os comentarios e seus respectivos usuario vinculado a um post
    static function getCommentsPost($post_id) {
        return Comment::select('comments.*', 'users.name')
            ->join('users', 'users.id', '=', 'comments.user_id')
        ->where('post_id', $post_id)->paginate(3);
    }
    # Verifica se o album está cadastrando o mesmo nome
    static function checkPostExist($post_id) {
        return Post::where('id', $post_id)->count();
    }
}
