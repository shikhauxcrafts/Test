<?php

namespace App\Models;
use App\Models\Subtitle;

use Illuminate\Database\Eloquent\Model;

class Title extends Model
{
    protected $guarded = [];
    protected $table = 'titles';

    public function subtitles()
    {
        return $this->hasMany(Subtitle::class,);
    }
}
