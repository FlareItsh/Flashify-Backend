<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Collection extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'collections';

    /**
     * The primary key associated with the table.
     *
     * @var string
     */
    protected $primaryKey = 'collection_id';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_id',
        'name',
        'description',
        'tags',
        'priority_level',
        'last_studied_at',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'tags' => 'array',
        'last_studied_at' => 'datetime',
    ];

    /**
     * Get the user that owns the collection.
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'user_id');
    }

    /**
     * Get the flashcards for the collection.
     */
    public function flashcards()
    {
        return $this->hasMany(Flashcard::class, 'collection_id', 'collection_id');
    }
}
