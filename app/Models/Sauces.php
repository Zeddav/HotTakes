<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sauces extends Model
{
    use HasFactory;

    protected $table = 'sauces';

    protected $primaryKey = 'sauceId';

    protected $fillable = [
        'userId',
        'name',
        'manufacturer',
        'description',
        'mainPepper',
        'imageUrl',
        'heat',
        'likes',
        'dislikes',
        'usersLiked',
        'usersDisliked',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'userId'); 
    }

    public function usersLiked()
    {
        return $this->belongsToMany(User::class, 'sauce_likes', 'sauceId', 'userId')
                    ->withTimestamps();
    }

    public function usersDisliked()
    {
        return $this->belongsToMany(User::class, 'sauce_dislikes', 'sauceId', 'userId')
                    ->withTimestamps();
    }
}




