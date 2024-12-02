<?php

namespace Database\Seeders;

use App\Models\Room;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RoomSeeder extends DatabaseSeeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //Room
            $rooms = [
                $this->data([
                    'type' => 'A',
                    'name' => '101',
                    'capacity' => 60, // supaya kaga ribet dengan kondisi ketka max_student course departmennt detail > dari capacity rooms, gua kasih 60
                    'department' => "Fisika"
                ]),
                $this->data([
                    'type' => 'C',
                    'name' => '202',
                    'capacity' => 60,
                    'department' => "Fisika" // supaya kaga ribet dengan kondisi ketka max_student course departmennt detail > dari capacity rooms, gua kasih 60
                ]),
                $this->data([
                    'type' => 'B',
                    'name' => '203',
                    'capacity' => 60,
                    'department' => "Kimia" // supaya kaga ribet dengan kondisi ketka max_student course departmennt detail > dari capacity rooms, gua kasih 60
                ]),
                $this->data([
                    'type' => 'E',
                    'name' => '101',
                    'capacity' => 60,
                    'department' => "Informatika" // supaya kaga ribet dengan kondisi ketka max_student course departmennt detail > dari capacity rooms, gua kasih 60
                ]),
                $this->data([
                    'type' => 'E',
                    'name' => '102',
                    'capacity' => 60,
                    'department' => "Informatika" // supaya kaga ribet dengan kondisi ketka max_student course departmennt detail > dari capacity rooms, gua kasih 60
                ]),
                $this->data([
                    'type' => 'E',
                    'name' => '103',
                    'capacity' => 60,
                    'department' => "Informatika" // supaya kaga ribet dengan kondisi ketka max_student course departmennt detail > dari capacity rooms, gua kasih 60
                ]),
                $this->data([
                    'type' => 'A',
                    'name' => '303',
                    'capacity' => 60,
                    'department' => "Informatika" // supaya kaga ribet dengan kondisi ketka max_student course departmennt detail > dari capacity rooms, gua kasih 60
                ]),
                $this->data([
                    'type' => 'A',
                    'name' => '204',
                    'capacity' => 60,
                    'department' => "Informatika" // supaya kaga ribet dengan kondisi ketka max_student course departmennt detail > dari capacity rooms, gua kasih 60
                ]),
            ];
        // Insert
        Room::insert($rooms);
    }
}
