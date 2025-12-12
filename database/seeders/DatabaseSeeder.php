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
            'name' => 'Miriam Moulin',
            'email' => 'miriam@gmail.com',
            'password' => bcrypt('#Charis2025'),
        ]);

        User::factory()->create([
            'name' => 'Ghabriel Souza',
            'email' => 'souzaghabriel195@gmail.com',
            'password' => bcrypt('#Charis2025'),
        ]);

        $this->call(EstadoSeeder::class);
        $this->call(AreaAtuacaoSeeder::class);
        $this->call(CidadeSeeder::class);
        $this->call(tipoDeAtendimento::class);
    }
}
