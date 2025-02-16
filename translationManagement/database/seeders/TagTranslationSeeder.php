<?php

namespace Database\Seeders;

use App\Models\Tag;
use App\Models\TagTranslation;
use App\Models\Translation;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TagTranslationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $translations = Translation::take(50)->pluck('id');
        $tag = Tag::pluck('id');
        $data = [];

        foreach ($translations as $translation) {
            $randomTag = $tag->random(2);
            foreach ($randomTag as $tagId) {
                $data[] = [
                    'translation_id' => $translation,
                    'tag_id' => $tagId,
                    'created_at' => now(),
                    'updated_at' => now()
                ];
            }
        }

        TagTranslation::insert($data);
    }
}
