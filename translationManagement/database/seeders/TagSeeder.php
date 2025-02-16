<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Support\Str;
use Illuminate\Database\Seeder;

class TagSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $tags = ['web', 'mobile', 'desktop', 'backend', 'frontend'];
        \App\Models\Tag::insert(array_map(fn($tag) => ['id' => (string) Str::uuid(),'name' => $tag, 'created_at' => now(), 'updated_at' => now()], $tags));
    }

}
