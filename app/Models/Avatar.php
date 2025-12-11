<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Avatar extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'avatars';

    /**
     * The primary key associated with the table.
     *
     * @var string
     */
    protected $primaryKey = 'avatar_id';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'file_path',
    ];

    /**
     * Get the users that have this avatar.
     */
    public function users()
    {
        return $this->hasMany(User::class, 'avatar_id', 'avatar_id');
    }
}
