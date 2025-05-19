<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Playlist extends Model
{
    protected $fillable = [
        "name",
        "user_id",
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function tracks()
    {
        return $this->belongsToMany(Track::class);
    }

    public function likes()
    {
        return $this->morphMany(Like::class, 'likeable');
    }
}
