<?php

namespace Database\Factories;

use App\Models\surat;
use Illuminate\Database\Eloquent\Factories\Factory;
use Faker\Factory as faker;
use Illuminate\Support\Arr;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\surat>
 */
class SuratFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {

        $faker = faker::create('id_ID');
        return [
            'nomor_surat' => $faker->numberBetween(100, 999) . '/' . $faker->numberBetween(10, 99) . '/' . $faker->numberBetween(1000, 9999),
            'asal_surat' => $faker->name(),
            'nama_peminjam' => $faker->name(),
            'mulai_dipinjam' => $faker->date(),
            'selesai_dipinjam' => $faker->date(),
            'jml_ruang' => $faker->randomNumber(2),
            'jml_pc' => $faker->randomNumber(2),
            'file_surat' => $faker->fileExtension(),
        ];
    }
}
