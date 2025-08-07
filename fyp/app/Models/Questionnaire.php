<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;

class Questionnaire extends Model
{
    protected $table = "questionnaire";
    protected $guarded = [ "id", "created_at", "updated_at" ];

    protected function answers(): Attribute {
        return Attribute::make(
            set: fn($value) => json_encode($value),
            get: fn($value) => json_decode($value)
        );
    }
}
