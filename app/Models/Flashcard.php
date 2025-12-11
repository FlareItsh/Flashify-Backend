<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Flashcard extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'flashcards';

    /**
     * The primary key associated with the table.
     *
     * @var string
     */
    protected $primaryKey = 'flashcard_id';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'collection_id',
        'front',
        'back',
        'hint',
        'explaination',
    ];

    /**
     * Get the collection that owns the flashcard.
     */
    public function collection()
    {
        return $this->belongsTo(Collection::class, 'collection_id', 'collection_id');
    }
}
