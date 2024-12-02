<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SettingsDetail extends Model
{
    use HasFactory;

    protected $fillable = ["title", "phones", "email", "site", "description", "ur_name", "ur_pre",
        "ur_title", "tin", "numKpp", "bic", "requisites", "kc", "okpo", "okato", "ogrn", "logo", "print",
        "signature", "fact_address_id", "ur_address_id"];

    protected $casts = [
        "phones" => "array",
        "fact_address_id" => "integer",
        "ur_address_id" => "integer"
    ];
}
