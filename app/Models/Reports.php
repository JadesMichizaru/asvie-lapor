<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Reports extends Model
{
    use HasFactory, HasUuids;

    protected $fillable = [
        'user_id',
        'title',
        'description',
        'location',
        'category',
        'status',
        'is_anonymous',
        'evidence_image',
    ];

    protected $casts = [
        'is_anonymous' => 'boolean',
    ];

    public function user() {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function responses() {
        return $this->hasMany(ReportsLogs::class, 'report_id');
    }
}
