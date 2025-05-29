<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Grade extends Model  {

    public function user() {
        return $this->belongsTo(User::class);
    }

    public function course() {
        return $this->belongsTo(Course::class);
    }

    protected $fillable = [
        'course_id',
        'user_id',
        'degree',
    ];
}