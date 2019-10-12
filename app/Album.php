<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Album extends Model
{
    # Verifica se o album está cadastrando o mesmo nome
    static function checkDuplicityUser($user_id, $name) {
        return Album::where('user_id', $user_id)->where('name', $name)->count();
    }
    # Retorna todos os albums
    static function getAlbums($number_per_page = null) {
        return ['data' => Album::paginate($number_per_page)];
    }

    # Retorna todas as fotos vinculados ao album
    static function getPhotoAlbum($album_id) {
        return Album::select('albums.*', 'photos.name','photos.name_original', 'users.name as name_user')
            ->join('photos', 'photos.album_id', '=', 'albums.id')
            ->join('users', 'users.id', '=', 'albums.user_id')
        ->where('albums.id', $album_id)->paginate(10);
    }
}
