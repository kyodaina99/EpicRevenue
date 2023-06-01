<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CampaignsCategoriesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $query = "INSERT INTO `campaigns_categories` (`id`, `name`, `created_at`, `updated_at`) VALUES
        (1, 'Adult', '2022-09-13 18:42:37', '2022-09-13 18:42:37'),
        (2, 'Android Apps', '2022-09-20 16:22:58', NULL),
        (3, 'Downloads', '2022-09-20 16:22:58', NULL),
        (4, 'Email Submits', '2022-09-20 16:22:58', NULL),
        (5, 'Fitness / Health', '2022-09-20 16:22:59', NULL),
        (6, 'iOS Apps', '2022-09-20 16:22:59', NULL),
        (7, 'Mobile Apps', '2022-09-20 16:22:59', NULL),
        (8, 'Products', '2022-09-20 16:22:59', NULL),
        (9, 'Registration', '2022-09-20 16:22:59', NULL),
        (10, 'Travel', '2022-09-20 16:22:59', NULL),
        (11, 'Trials', '2022-09-20 16:22:59', NULL),
        (12, 'Sweepstakes/Giveaways', '2022-09-20 16:23:00', NULL),
        (13, 'Dating', '2022-09-20 16:23:00', NULL);";
        DB::insert($query);
    }
}
