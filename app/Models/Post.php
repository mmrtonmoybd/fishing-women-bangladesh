<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    protected $fillable = ['title', 'category_id', 'content', 'thumbnail', 'user_id', 'is_guest', 'guest_name', 'status', 'type', 'youtube_url'];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    protected static function getFileTypeFromPath($path)
    {
        $videoExtensions = ['mp4', 'mov', 'avi', 'mkv', 'webm', 'flv', 'wmv'];
        $imageExtensions = ['jpg', 'jpeg', 'png', 'gif', 'bmp', 'webp', 'svg'];
        $audioExtensions = [
            'mp3', 'wav', 'ogg', 'aac', 'm4a', 'flac', 'wma',
            'aiff', 'opus', 'amr', 'mid', 'midi', 'weba',
        ];

        $extension = strtolower(pathinfo($path, PATHINFO_EXTENSION));

        if (in_array($extension, $videoExtensions)) {
            return 'video';
        } elseif (in_array($extension, $imageExtensions)) {
            return 'image';
        } elseif (in_array($extension, $audioExtensions)) {
            return 'audio';
        } else {
            return 'youtube';
        }
    }

    protected static function booted()
    {
        static::saving(function (Post $post) {
            $post->type = self::getFileTypeFromPath($post->thumbnail);
        });
    }
}
