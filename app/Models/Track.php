<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Track extends Model
{
    protected $fillable = [
        "title",
        "artist",
        "genre",
        "file_path",
        "user_id",
        "is_public",
        "plays",
        "likes",
    ];

    public function playlists()
    {
        return $this->belongsToMany(Playlist::class)->withTimestamps();
    }

    public function likes()
    {
        return $this->hasMany(Like::class);
    }
}
