<?php


namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class UserAchievement extends Model
{
    protected $table = 'user_achievements';

    protected $fillable = [
        'user_id',
        'achievement_id',
        'unlocked_at',
    ];

    protected $appends = [
        'progress_total'
    ];

    public function getProgressTotalAttribute()
    {
        return $this->progress . '/' . $this->achievement->requirement;
    }
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function achievement()
    {
        return $this->belongsTo(Achievement::class, 'achievement_id', 'id');
    }
    public static function trackUserPost($userId)
    {
        $userPost = Post::where('user_id', $userId)->count('id');
        $postAchievement = Achievement::where('type', 'post')->get();

        foreach ($postAchievement as $achievement) {
            $userAchievement = self::where([
                ['user_id', '=', $userId],
                ['achievement_id', '=', $achievement->id],
            ])
                ->whereNull('unlocked_at')
                ->first();

            if($userAchievement){
                if ($userAchievement->progress < $userPost) {
                    $progress = $userPost > $achievement->requirement ? $achievement->requirement : $userPost;
                    self::updateProgress($userAchievement->id, $progress, $achievement);

                }
            }
        }

    }
    public static function updateProgress(int $id, int $progress, Achievement $achievement)
    {
        $UA = self::find($id);
        $UA->progress = $progress;
        $UA->save();


        if ($achievement->requirement == $UA->progress) {
            $UA->unlocked_at = Carbon::now();
            $UA->save();
        }
    }
}

