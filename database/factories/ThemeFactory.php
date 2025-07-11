<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Category>
 */
class ThemeFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'title' => fake()->word(),
            'css_style'=> $this->generateFakeCssStyle(),
        ];
    }

    private function generateFakeCssStyle(): string
    {
        $properties = [
            'color' => ['red', 'blue', 'green', 'black', 'white'],
            'background-color' => ['yellow', 'cyan', 'magenta', 'gray'],
            'font-size' => ['12px', '16px', '20px', '24px'],
            'margin' => ['0', '5px', '10px', '15px'],
            'padding' => ['0', '5px', '10px', '20px'],
            'border' => ['1px solid black', '2px dashed blue', 'none'],
        ];

        $css = '';
        foreach (array_rand($properties, rand(3, 5)) as $property) {
            $css .= sprintf(
                "%s: %s;\n",
                $property,
                fake()->randomElement($properties[$property])
            );
        }

        return $css;
    }


}
