<?php

namespace Database\Seeders;

use App\Models\Country;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ColorAndSizeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $color = [
            [
                'name' => 'red',
                'value' => '#f00',
            ],
            [
                'name' => 'blue',
                'value' => '#00f',
            ],
            [
                'name' => 'green',
                'value' => '#0f0',
            ],
            [
                'name' => 'yellow',
                'value' => '#ff0',
            ],
            [
                'name' => 'black',
                'value' => '#000',
            ],
        ];

        $sizes = [
            [
                'name' => 'Small',
                'value' => 'S',
            ],
            [
                'name' => 'Medium',
                'value' => 'M',
            ],
            [
                'name' => 'Large',
                'value' => 'L',
            ],
            [
                'name' => 'XLarge',
                'value' => 'XL',
            ],
            [
                'name' => 'XXLarge',
                'value' => 'XXL',
            ],
        ];

        DB::table('colors')->insert($color);
        DB::table('sizes')->insert($sizes);

    }
}
