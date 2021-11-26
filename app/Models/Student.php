<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    use HasFactory;

    
    protected $table = 'students';

    protected $primaryKey = 'user_id';

    public $incrementing = false;
    
    public $timestamps = true;
    

    protected $fillable = [
        'nisn',
        'nis',
        'room_id',
        'address',
        'phone',
    ];

    public function room()
    {
        return $this->belongsTo(Room::class, 'room_id');
    }
}
