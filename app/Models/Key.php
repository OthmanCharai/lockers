<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Key extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'locker_id',
        'user_id',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'locker_id' => 'integer',
        'user_id' => 'integer',
    ];

    public function locker()
    {
        return $this->belongsTo(Locker::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function locker()
    {
        return $this->belongsTo(Locker::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
