<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ChatbotResponses extends Model
{
    use HasFactory, HasUuids;

    protected $table = "chatbot_responses";

    protected $fillable = ["keyword", "response", "created_by"];

    public function creator()
    {
        return $this->belongsTo(User::class, "created_by");
    }
}
