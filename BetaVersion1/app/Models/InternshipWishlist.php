<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InternshipWishlist extends Model
{
    use HasFactory;

    protected $table = 'tbl_internship_wishlist';

    protected $fillable = [
        'user_id',
        'internship_id',
    ];

    // Relationship with User
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    // Relationship with Internship
    public function internship()
    {
        return $this->belongsTo(Internship::class, 'internship_id');
    }
}
