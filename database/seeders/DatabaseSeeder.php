<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
        ]);

        User::factory()->create([
            'name' => 'Miriam Moulin',
            'email' => 'miriam@gmail.com',
            'password' => bcrypt('#Charis2025'),
        ]);

        $this->call(EstadoSeeder::class);
        $this->call(AreaAtuacaoSeeder::class);
        $this->call(CidadeSeeder::class);
        $this->call(tipoDeAtendimento::class);
    }
}
