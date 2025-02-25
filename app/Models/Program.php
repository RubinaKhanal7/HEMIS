<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Program extends Model
{
    use HasFactory;
    
    protected $fillable = ['class_id', 'section_id', 'title', 'is_active'];

    public function class()
    {
        return $this->belongsTo(Classg::class, 'class_id');
    }

    public function section()
    {
        return $this->belongsTo(Section::class, 'section_id');
    }

    public function students()
    {
        return $this->hasMany(Student::class, 'program_id');
    }
}
