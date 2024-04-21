<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Device;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $device = new Device();
        $device->name = "ESP32";
        $device->MAC = "E4:65:B8:49:D4:00";
        $device->save();
    }
}
