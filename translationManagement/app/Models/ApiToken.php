<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Sanctum\HasApiTokens;

class ApiToken extends Model
{
    use HasFactory;
    use HasApiTokens;

    protected $table = 'api_tokens';

    protected $fillable = ['name'];
}
