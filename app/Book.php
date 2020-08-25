<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    protected $fillable = [
        'user_id', 'author_id', 'pages', 'title', 'annotation', 'img'
    ];

    public function setImgAttribute($value)
    {

        if ($value && file($value)) {

            $mime = $value->extension();
            $img = base64_encode(file_get_contents($value));

            return $this->attributes['img'] = "data:image/$mime;base64,$img";
        }

        return !isset($this->attributes['img']) ? $this->attributes['img'] = null : $this->attributes['img'];

    }

    public function authors()
    {
        return $this->hasOne(Authors::class, 'id', 'author_id');
    }

    public function user()
    {
        return $this->hasOne(User::class, 'id', 'user_id');
    }

}

