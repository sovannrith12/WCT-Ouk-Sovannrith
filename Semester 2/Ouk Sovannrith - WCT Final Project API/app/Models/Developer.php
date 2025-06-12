<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Developer extends Model
{
    //
    public function games() {
    return $this->belongsToMany(Game::class);
}

}
