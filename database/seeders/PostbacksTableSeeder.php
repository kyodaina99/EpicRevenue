<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PostbacksTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $query = "INSERT INTO `postbacks` (`id`, `name`, `ips`, `ch_slot`, `reverse_var`, `reverse_key`, `veri_slot`, `created_at`, `updated_at`) VALUES
(1, 'Maxbounty', NULL, 's1', NULL, NULL, '1e4a3d92d8de85c89d378a0448e6115c', '2022-09-20 16:30:08', NULL),
(2, 'Adscend', NULL, 'sub1', 'sts', 2, 'fc016c5c4514594dd8ebaaae27476ed1', '2022-09-20 16:30:08', NULL),
(3, 'Adwork', NULL, 'sid', 'status', 2, 'bec04f3a1c2a1ab4eadf14115c8ff4d2', '2022-09-20 16:30:08', NULL);";
        DB::insert($query);
    }
}
