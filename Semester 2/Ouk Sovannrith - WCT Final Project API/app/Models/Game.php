<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory; // Add this line
use Illuminate\Database\Eloquent\Model;

class Game extends Model
{
    use HasFactory; // Add this line here

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'title',
        'genre',
        'rating',
        'class',
        'publisher_id', // Make sure this is fillable if you set it on create/update
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'rating' => 'integer', // Ensures rating is always cast to integer
    ];

    public function publisher()
    {
        return $this->belongsTo(Publisher::class);
    }

    public function developers()
    {
        return $this->belongsToMany(Developer::class);
    }
}
