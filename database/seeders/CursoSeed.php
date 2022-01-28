<?php

namespace Database\Seeders;

use App\Models\Curso;
use App\Models\Professor;
use App\Models\CategoriaCurso;

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class CursoSeed extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        $ids_professor = array();
        $ids_categoria = array();

        for ($i = 0; $i < 10; $i++) {
            
            $professor = Professor::create([
                'nome' => Str::random(10) . ' ' . Str::random(6),
                'avatar' => null,
                'email' => Str::random(10) . '@gmail.com',
                'facebook' => 'https://www.' . Str::random(30) . '.com.br',
                'instagram' => 'https://www.' . Str::random(30) . '.com.br',
                'linkedin' => 'https://www.' . Str::random(30) . '.com.br',
                'site' => 'https://www.' . Str::random(30) . '.com.br',
                'curriculo' => Str::random(10) . ' ' . Str::random(15) . ' ' . Str::random(10) . ' ' . Str::random(15) . ' ' . Str::random(10) . ' ' . Str::random(15),
                'status' => 1,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ]);

            $ids_professor[] = $professor->id;
        }

        for ($i = 0; $i < 20; $i++) {
            
            $categoria = CategoriaCurso::create([
                'nome' => Str::random(10) . ' ' . Str::random(15) . ' ' . Str::random(6),
                'imagem' => null,
                'status' => 1,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ]);

            $ids_categoria[] = $categoria->id;
        }

        for ($i = 0; $i < 50; $i++) {
            $id_professor = array_rand($ids_professor);
            $id_categoria = array_rand($ids_categoria);

            $curso = Curso::create([
                'nome' => Str::random(10) . ' ' . Str::random(15) . ' ' . Str::random(6),
                'imagem' => 'imagemCurso/padrao.png',
                'descricao' => Str::random(150),
                'status' => 1,
                'aula_travada' => rand(1, 2),
                'tipo' => rand(1, 3),
                'visibilidade' => 1,
                'porcentagem_solicitacao_certificado' => rand(0, 100),
                'cooprodutor' => Str::random(200),
                'categoria_id' => $ids_categoria[$id_categoria],
                'professor_id' => $ids_professor[$id_professor],
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ]);

        }
    }
}
