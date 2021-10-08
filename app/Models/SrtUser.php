<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SrtUser extends Model
{
    use HasFactory;

    protected $table = 'srt_users';

    protected $guarded = ['id'];

    public $incrementing = true;

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array
     */
    protected $hidden = [
        'created_at',
        'updated_at',
    ];
 
    public function books()
    {
        return $this->belongsToMany(SrtBook::class,'srt_rents','user_id','book_id');
    }
}
