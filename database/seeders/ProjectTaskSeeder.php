<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Project;
use App\Models\Task;
use Faker\Factory as Faker;

class ProjectTaskSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Inisialisasi Faker (Bawaan Laravel)
        $faker = Faker::create('id_ID'); // Menggunakan format bahasa Indonesia

        // Membuat 3 Proyek (Project) dummy
        for ($i = 1; $i <= 3; $i++) {
            $project = Project::create([
                'name' => 'Proyek Hackathon Bagian ' . $i,
            ]);

            // Untuk setiap Proyek, buat 4-6 Tugas (Task) dummy
            $taskCount = rand(4, 6);
            for ($j = 1; $j <= $taskCount; $j++) {
                Task::create([
                    'project_id' => $project->id, // Mengaitkan tugas dengan proyek di atas
                    'name' => $faker->sentence(rand(3, 6)), // Nama tugas acak (3-6 kata)
                    // Tanggal deadline antara hari ini sampai 14 hari ke depan
                    'deadline' => $faker->dateTimeBetween('now', '+14 days')->format('Y-m-d'), 
                    // Status is_done diacak (true atau false)
                    'is_done' => $faker->boolean(30), // 30% peluang tugas sudah selesai
                ]);
            }
        }
    }
}