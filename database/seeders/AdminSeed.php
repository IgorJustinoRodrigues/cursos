<?php

namespace Database\Seeders;

use App\Models\Admin;
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class AdminSeed extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for ($i = 0; $i < 500; $i++) {
            $admin = Admin::create([
                'nome' => Str::random(10),
                'email' => Str::random(10) . '@gmail.com',
                'senha' => '123456',
                'avatar' => 'avatarAdmin/padrao.png',
                'tipo' => '1',
                'anotacoes' => Str::random(200),
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ]);
        }
    }
}
