<?php

namespace Database\Seeders;

use App\Models\Country;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CountrySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
            'image' => 'image',
            'ar' => [
                'title' => 'مصر',
            ],
            // 'en' => [
            //     'title' => 'Egypt',
            // ]
        ];
        $cityModel =  Country::whereTranslation('title', 'مصر')->first();
        // dd($cityModel);
        if(!$cityModel)
        Country::create($data);

    }
}
