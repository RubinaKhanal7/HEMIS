<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MembershipHead extends Model
{
    use HasFactory;

    protected $table = 'membershiphead';

    protected $fillable = [
        'title',
        'is_active',
    ];
}
