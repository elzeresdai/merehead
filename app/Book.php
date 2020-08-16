<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    protected $fillable = [
        'user_id', 'author_id', 'pages', 'title', 'annotation', 'img'
    ];

   public function authors()
   {
       return $this->hasOne(Authors::class);
   }

}

