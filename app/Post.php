<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    protected $fillable = [
        'body', 'user_id'
    ];

    # Verifica se o usuario está postando a mesma mensagem
    static function checkDuplicityUser($user_id, $body) {
        return Post::where('user_id', $user_id)->where('body', $body)->count();
    }
    # Retorna todas as postagens
    static function getPostUser($number_per_page = null) {
        return ['data' => Post::paginate($number_per_page)];
    }
    # Retorna as postagens do usuario logado
    static function getAllPostUser($user_id, $number_per_page = null) {
        return ['data' => Post::where('user_id', $user_id)->paginate($number_per_page)];
    }
}
