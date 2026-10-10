<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ReportResponses extends Model
{
    use HasFactory, HasUuids;

    protected $table = "reports_responses";

    protected $fillable = [
        "report_id",
        "user_id",
        "response",
        "status_tracking",
    ];

    public function report()
    {
        return $this->belongsTo(Reports::class, "report_id");
    }

    public function user()
    {
        return $this->belongsTo(User::class, "user_id");
    }
}
