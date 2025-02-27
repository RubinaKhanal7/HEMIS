<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Membership extends Model
{
    use HasFactory;

    protected $table = 'members'; 

    protected $fillable = [
        'memberhead_id',
        'fullname',
        'membershipdate',
        'membershipnumber',
        'mobile_number',
        'email',
        'province',
        'district',
        'locallevel',
        'ward',
        'tole',
    ];

    public function membershiphead()
    {
        return $this->belongsTo(MembershipHead::class, 'memberhead_id');
    }
}