<?php

namespace Database\Seeders;

use App\Models\Aula;
use App\Models\AulaAluno;
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

        function aula_texto($curso_id){
            $aula = Aula::create([
                'nome' => Str::random(10) . ' ' . Str::random(6),
                'tipo' => 2,
                'descricao' => Str::random(10) . ' ' . Str::random(15) . ' ' . Str::random(10),
                'texto' => '<p>Texto de exemplo!</p><p><br></p><h2><strong>Tamanho diferente</strong></h2><p><br></p><p>LISTA</p><p><br></p><ol><li>1fd</li><li>sfs</li><li>adfa</li><li>sdfwe</li><li>fs</li><li>fas</li><li>df</li><li>efse</li><li>sd</li><li>sfsd</li></ol><p><br></p><p><br></p><h3><strong><em><u>Fim!</u></em></strong></h3>',
                'duracao' => '25',
                'status' => 1,
                'curso_id' => $curso_id,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ]);

            return $aula->id;
        }

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
                'cooprodutor' => Str::random(10) . ' ' . Str::random(15) . ' ' . Str::random(6),
                'categoria_id' => $ids_categoria[$id_categoria],
                'professor_id' => $ids_professor[$id_professor],
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ]);

            $id_aula = aula_texto($curso->id);

        }
    }
}
