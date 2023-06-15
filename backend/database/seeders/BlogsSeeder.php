<?php
namespace Database\Seeders;
use App\Models\Blogs;
use Faker\Factory as Faker;
use Illuminate\Database\Seeder;

class BlogsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker::create();

        for ($i = 0; $i < 10; $i++) {
            $user_id = $faker->numberBetween(1, 10);
            $title = $faker->sentence;
            $description = $faker->paragraph;
            $image = $faker->imageUrl();
            $status = 'Active';

            Blogs::insert([
                'user_id' => $user_id,
                'title' => $title,
                'description' => $description,
                'image' => $image,
                'status' => $status,
            ]);
        }
    }
}
