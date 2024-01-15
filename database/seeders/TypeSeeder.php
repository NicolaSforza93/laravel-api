<?php

namespace Database\Seeders;

use App\Models\Type;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $types = ['FrontEnd', 'BackEnd', 'FullStack', 'Design'];

        foreach ($types as $type_name) {
            $new_type = new Type();

            $new_type->name = $type_name;

            $new_type->save();
        }
    }
}
