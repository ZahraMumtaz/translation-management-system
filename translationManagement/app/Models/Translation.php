<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Support\Str;

class Translation extends Model
{
    use HasFactory;

    protected $keyType = 'string';
    public $incrementing = false;
    protected $fillable = ['id', 'key', 'context', 'locale', 'content'];

    protected static function boot()
    {
        parent::boot();
        static::creating(function ($model) {
            $model->id = (string) Str::uuid();
        });
    }

    public function tags(): BelongsToMany
    {
        return $this->belongsToMany(Tag::class, 'tag_translations', 'translation_id', 'tag_id');
    }

    public static function getAndSearchAllTranslations($request)
    {
        $query = Translation::query()->with('tags');
        if ($request->has('key')) {
            $query->where('key', 'LIKE', '%' . $request->key . '%');
        }

        if ($request->has('context')) {
            $query->where('context', 'LIKE', '%' . $request->context . '%');
        }

        if ($request->has('locale')) {
            $query->where('locale', $request->locale);
        }

        if ($request->has('tag')) {
            $query->whereHas('tags', function ($q) use ($request) {
                $q->where('name', $request->tag);
            });
        }

        return  $query->select(['id', 'key', 'locale', 'content'])->orderby('created_at', 'desc')->paginate(10);
    }
}
