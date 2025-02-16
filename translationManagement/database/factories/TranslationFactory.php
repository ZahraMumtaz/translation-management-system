<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Stichoza\GoogleTranslate\GoogleTranslate;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Translation>
 */
class TranslationFactory extends Factory
{
    protected $model = \App\Models\Translation::class;
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $locales = ['en', 'es', 'fr'];
        $context = ['web','andoid', 'desktop'];
        $englishString = ucfirst($this->faker->sentence(4, true));
        $locale = $this->faker->randomElement($locales);

        try{
            $translatedContent = (new GoogleTranslate())->setSource()->setTarget($locale)->translate($englishString);
        }catch(\Exception $e){
            $translatedContent = $englishString . " ({$locale})";
        }
        return [
            'key' => $englishString,
            'locale' => $locale,
            'content' => $translatedContent,
            'context' => $this->faker->randomElement($context)
        ];
    }
}
