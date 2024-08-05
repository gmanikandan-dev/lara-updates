<?php

namespace Database\Seeders;

use App\Models\Student;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class StudentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        echo "starting student seeding... \n";
        $batchSize = 10000;
        $totalstudents = 1000000;

        $i = 0;
        foreach ($this->studentGenerator($totalstudents, $batchSize) as $batch) {
            $i++;
            Student::insert($batch);
            echo "{$i} inserted batch of {$batchSize} students.\n";
        }

        echo "student seeding completed.";
    }

    private function studentGenerator(int $total, int $batchSize): \Generator
    {
        $count = 0;
        $batch = [];

        while ($count < $total) {
            $batch[] = [
                'name' => fake()->name(),
                'email' => fake()->unique()->safeEmail(),
                'status' => rand(0,1),
                'created_at' => now(),
                'updated_at' => now(),
            ];

            $count++;

            if (count($batch) == $batchSize) {
                yield $batch;
                $batch = [];
            }
        }

        if (!empty($batch)) {
            yield $batch;
        }
    }
}
