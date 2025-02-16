<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class TagTranslation extends Model
{
    use HasFactory;

    protected $fillable = ['tag_id', 'translation_id'];
}
