<?php

namespace Database\Seeders;

use App\Models\Project;
use App\Models\Technology;
use App\Models\Type;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Faker\Generator as Faker;

class ProjectSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(Faker $faker): void
    {

        $projects = [
            [
                "name_project" => "html-css-spotifyweb",
                "date_creation" => "2023-09-19",
                "status" => "Completato",

            ],
            [
                "name_project" => "html-css-boolando",
                "date_creation" => "2023-09-06",
                "status" => "Completato",
            ],
            [
                "name_project" => "html-css-booleaner",
                "date_creation" => "2023-08-28",
                "status" => "Completato",
            ],
            [
                "name_project" => "html-css-bootstrap-dashboard",
                "date_creation" => "2023-09-27",
                "status" => "Completato",
            ],
            [
                "name_project" => "html-css-bootstrap-freelancer",
                "date_creation" => "2023-09-25",
                "status" => "Completato",
            ],
        ];

        $types = Type::all();
        $typeIds = $types->pluck('id');

        $technologies = Technology::all();
        $technologyIds = $technologies->pluck('id');

        foreach ($projects as $project) {
            $new_project = new Project();

            $new_project->name_project = $project['name_project'];
            $new_project->date_creation = $project['date_creation'];
            $new_project->status = $project['status'];
            $new_project->description = $faker->text(500);
            $new_project->type_id = $faker->optional()->randomElement($typeIds);

            $new_project->save();

            $new_project->technologies()->attach($faker->randomElements($technologyIds, null));
        }
    }
}
