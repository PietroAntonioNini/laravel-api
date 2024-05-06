<?php

namespace Database\Seeders;

use App\Models\Project;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

use Faker\Generator as Faker;

class ProjectSeeder extends Seeder
{
    public function run(Faker $faker): void
    {

        for ($i = 0; $i < 12; $i++) {
            $newProject = new Project();

            $newProject->name = $faker->word();
            $newProject->slug = Str::slug($newProject->name);
            $newProject->description = $faker->paragraph();
            $newProject->image = $faker->imageUrl(640, 480, 'animals', true);
            $newProject->link_GitHub = $faker->word();

            $newProject->save();
        }






    }
}
