<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    use HasFactory;

    protected $fillable = [
        'quiz_id',
        'category_id',
        'created_by',
        'question_text',
        'image', // ⬅️ INI YANG HILANG
    ];

    
    // PASTIKAN TIDAK ADA:
    // protected $hidden = ['image'];
    // accessor image aneh

    public function choices()
    {
        return $this->hasMany(Choice::class);
    }

    public function quiz()
    {
        return $this->belongsTo(Quiz::class);
    }
}
