<?php


namespace App;

use Illuminate\Database\Eloquent\Model;

class Achievement extends Model
{
    const types = [
        'post',
        'follower',
        'follow',
        #'comment',
        #'like',
    ];
    protected $fillable = [
        'name',
        'description',
        'icon',
        'type',
        'requirement',
    ];

    public function users()
    {
        return $this->belongsToMany(User::class, 'user_achievements')
                    ->withPivot('unlocked_at')
                    ->withTimestamps();
    }
}

