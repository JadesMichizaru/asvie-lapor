<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ReportResponses extends Model
{
    use HasUuids, HasFactory;

    public $timestamps = false;

    protected $fillable = [
        'report_id',
        'user_id',
        'reports_response',
        'created_at'
    ];

    protected $casts = [
        'created_at' => 'datetime'
    ];

    public function report() {
        return $this->belongsTo(Reports::class, 'report_id');
    }

    public function officer() {
        return $this->belongsTo(User::class, 'user_id');
    }

}
