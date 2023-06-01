<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call([
            //CampaignsCategoriesTableSeeder::class,
            //PostbacksTableSeeder::class,
            CountrySeeder::class,
        ]);
    }
}
/*

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

class DatabaseSeeder extends Seeder
{

    public function run()
    {
        Model::unguard();

        $this->call(CampaignsCategoriesTableSeeder::class);
        $this->call(PostbacksTableSeeder::class);
        $this->call(CountrySeeder::class);

        Model::reguard();
    }
}
*/
