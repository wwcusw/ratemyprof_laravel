<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Evaluation extends Model
{
    //  Allow mass assignment of form fields
    protected $fillable = [
        'user_id',
        'faculty_user_id',
        'semester',
        'q1', 'q2', 'q3', 'q4', 'q5',
        'q6', 'q7', 'q8', 'q9', 'q10',
        'comment',
    ];

    //  Student relationship
    public function student()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    // Professor relationship
    public function professor()
    {
        return $this->belongsTo(User::class, 'faculty_user_id', 'user_id');
    }
}
