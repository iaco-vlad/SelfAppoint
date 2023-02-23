<?php

namespace Database\Seeders;

use App\Models\Service;
use Illuminate\Database\Seeder;

class CreateServiceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $service = new Service();
        $service->id = 999;
        $service->name = 'Window';
        $service->timespan = 25;
        $service->is_active = true;
        $service->save();
    }
}
