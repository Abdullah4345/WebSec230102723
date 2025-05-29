<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Course extends Model  {

    public $timestamps = false;

	protected $fillable = [
        'code',
        'name',
        'max_degree',
        'description',
    ];
}