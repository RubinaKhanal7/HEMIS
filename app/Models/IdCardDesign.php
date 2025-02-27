<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class IdCardDesign extends Model
{
    use HasFactory;

    protected $fillable = [
        'school_id',
        'student_id',
        'college_name',
        'sign',
        'background_img',
        'content_footer',
    ];

    public function school()
    {
        return $this->belongsTo(School::class);
    }

    public function student()
    {
        return $this->belongsTo(Student::class);
    }
}