<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\QuizAttempt;

class Quiz extends Model
{
    use HasFactory;

    protected $fillable = [
        'category_id',
        'created_by',
        'title',
        'description',
        'is_published',
        'total_questions',
        'duration',   // ⏱️
        'token',      // 🔑
    ];

    protected $casts = [
        'is_published' => 'boolean',
    ];

    /* ================= RELATIONS ================= */

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function questions()
    {
        return $this->hasMany(Question::class);
    }
    public function attempts()
    {
        return $this->hasMany(\App\Models\QuizAttempt::class);
    }

}
