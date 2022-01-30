<?php

namespace Database\Seeders;

use App\Models\Aluno;
use App\Models\AnexoAula;
use App\Models\Aula;
use App\Models\AulaAluno;
use App\Models\Curso;
use App\Models\Professor;
use App\Models\CategoriaCurso;
use App\Models\Matricula;
use App\Models\Parceiro;
use App\Models\Perguntas;
use App\Models\Respostas;
use App\Models\Unidade;
use App\Models\Vendedor;
use Carbon\Carbon;
use Faker\Factory;
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

        $faker = Factory::create('pt_BR');

        function aula_texto($curso_id)
        {
            $faker = Factory::create('pt_BR');

            $aula = Aula::create([
                'nome' => $faker->name,
                'tipo' => 2,
                'descricao' => $faker->text,
                'texto' => $faker->randomHtml(5, 5),
                'duracao' => rand(5, 30),
                'status' => 1,
                'curso_id' => $curso_id,
                'created_at' => $faker->dateTime($max = 'now', $timezone = null),
                'updated_at' => $faker->dateTime($max = 'now', $timezone = null)
            ]);

            return $aula->id;
        }

        function aula_video($curso_id)
        {
            $faker = Factory::create('pt_BR');

            $aula = Aula::create([
                'nome' => $faker->name,
                'tipo' => 1,
                'video' => '<iframe src="https://player.vimeo.com/video/388311362?h=5d0e413e55" width="100%" height="340" frameborder="0" allow="autoplay; fullscreen; picture-in-picture" allowfullscreen></iframe> <p><a href="https://vimeo.com/388311362">Aula 3 - Corre&ccedil;&atilde;o Erro do Flash Player</a> from <a href="https://vimeo.com/user107640638">Igor Justino</a> on <a href="https://vimeo.com">Vimeo</a>.</p>',
                'descricao' => $faker->text,
                'texto' => $faker->randomHtml(3, 3),
                'duracao' => rand(5, 30),
                'status' => 1,
                'curso_id' => $curso_id,
                'created_at' => $faker->dateTime($max = 'now', $timezone = null),
                'updated_at' => $faker->dateTime($max = 'now', $timezone = null)
            ]);

            return $aula->id;
        }

        function aula_quiz($curso_id)
        {
            $faker = Factory::create('pt_BR');

            $aula = Aula::create([
                'nome' => $faker->name,
                'tipo' => 3,
                'descricao' => $faker->text,
                'duracao' => rand(5, 30),
                'avaliacao' => rand(0, 1),
                'status' => 1,
                'curso_id' => $curso_id,
                'created_at' => $faker->dateTime($max = 'now', $timezone = null),
                'updated_at' => $faker->dateTime($max = 'now', $timezone = null)
            ]);

            for ($i = 0; $i < 5; $i++) {
                $pergunta = Perguntas::create([
                    'pergunta' => $faker->text,
                    'aulas_id' => $aula->id,
                    'created_at' => $faker->dateTime($max = 'now', $timezone = null),
                    'updated_at' => $faker->dateTime($max = 'now', $timezone = null)
                ]);

                $resposta = Respostas::create([
                    'resposta' => 'Resposta Certa',
                    'correta' => '1',
                    'pergunta_id' => $pergunta->id,
                    'created_at' => $faker->dateTime($max = 'now', $timezone = null),
                    'updated_at' => $faker->dateTime($max = 'now', $timezone = null)
                ]);

                $resposta = Respostas::create([
                    'resposta' => 'Resposta Errada',
                    'correta' => '0',
                    'pergunta_id' => $pergunta->id,
                    'created_at' => $faker->dateTime($max = 'now', $timezone = null),
                    'updated_at' => $faker->dateTime($max = 'now', $timezone = null)
                ]);

                $resposta = Respostas::create([
                    'resposta' => 'Resposta Errada',
                    'correta' => '0',
                    'pergunta_id' => $pergunta->id,
                    'created_at' => $faker->dateTime($max = 'now', $timezone = null),
                    'updated_at' => $faker->dateTime($max = 'now', $timezone = null)
                ]);

                $resposta = Respostas::create([
                    'resposta' => 'Resposta Errada',
                    'correta' => '0',
                    'pergunta_id' => $pergunta->id,
                    'created_at' => $faker->dateTime($max = 'now', $timezone = null),
                    'updated_at' => $faker->dateTime($max = 'now', $timezone = null)
                ]);
            }

            return $aula->id;
        }

        function anexo($id_aula)
        {
            $faker = Factory::create('pt_BR');

            $anexo = AnexoAula::create([
                'nome' => $faker->name,
                'arquivo' => 'anexoAula/teste.zip',
                'aula_id' => $id_aula,
                'created_at' => $faker->dateTime($max = 'now', $timezone = null),
                'updated_at' => $faker->dateTime($max = 'now', $timezone = null)
            ]);
        }

        $ids_aluno = array();
        $ids_parceiro = array();
        $ids_professor = array();
        $ids_categoria = array();
        $ids_curso = array();

        for ($i = 0; $i < 20; $i++) {
            $parceiro = Parceiro::create([
                'nome' => $faker->name,
                'logo' => null,
                'sobre' => $faker->randomHtml(4, 6),
                'usuario' => Str::random(8),
                'senha' => md5(123456),
                'status' => 1,
                'visibilidade' => rand(0, 1),
                'created_at' => $faker->dateTime($max = 'now', $timezone = null),
                'updated_at' => $faker->dateTime($max = 'now', $timezone = null)
            ]);
            $ids_unidade = array();

            for ($j = 0; $j < 20; $j++) {

                $unidade = Unidade::create([
                    'nome' => $faker->name,
                    'logo' => null,
                    'usuario' => Str::random(8),
                    'senha' => md5(123456),
                    'email' => $faker->email,
                    'whatsapp' => $faker->cellphoneNumber,
                    'contato' => $faker->text,
                    'endereco' => $faker->text,
                    'cidade' => Str::random(10),
                    'estado' => Str::random(2),
                    'facebook' => $faker->url,
                    'instagram' => $faker->url,
                    'site' => $faker->url,
                    'status' => 1,
                    'parceiro_id' => $parceiro->id,
                    'created_at' => $faker->dateTime($max = 'now', $timezone = null),
                    'updated_at' => $faker->dateTime($max = 'now', $timezone = null)
                ]);
                $ids_vendedor = array();

                for ($t = 0; $t < 15; $t++) {

                    $vendedor = Vendedor::create([
                        'nome' => $faker->name,
                        'cpf' => $faker->cpf,
                        'avatar' => null,
                        'email' => $faker->email,
                        'whatsapp' => $faker->cellphoneNumber,
                        'usuario' => Str::random(8),
                        'senha' => md5(123456),
                        'status' => 1,
                        'unidade_id' => $unidade->id,
                        'created_at' => $faker->dateTime($max = 'now', $timezone = null),
                        'updated_at' => $faker->dateTime($max = 'now', $timezone = null)
                    ]);

                    $ids_vendedor[] = $vendedor;
                }

                $unidade->vendedores = $ids_vendedor;
                $ids_unidade[] = $unidade;
            }

            $parceiro->unidades = $ids_unidade;
            $ids_parceiro[] = $parceiro;
        }

        for ($i = 0; $i < 200; $i++) {
            $aluno = Aluno::create([
                'nome' => $faker->name,
                'nascimento' => $faker->date($format = 'Y-m-d', $max = 'now'),
                'sexo' => rand(0, 1),
                'avatar' => null,
                'email' => $faker->email,
                'whatsapp' => $faker->cellphoneNumber,
                'telefone' => $faker->cellphoneNumber,
                'contato' => $faker->text,
                'cidade' => $faker->name,
                'estado' => Str::random(2),
                'senha' => md5(123456),
                'pontuacao' => rand(0, 450),
                'status' => 1,
                'created_at' => $faker->dateTime($max = 'now', $timezone = null),
                'updated_at' => $faker->dateTime($max = 'now', $timezone = null)
            ]);

            $ids_aluno[] = $aluno->id;
        }

        for ($i = 0; $i < 10; $i++) {
            $professor = Professor::create([
                'nome' => $faker->name,
                'avatar' => null,
                'email' => $faker->email,
                'facebook' => $faker->url,
                'instagram' => $faker->url,
                'linkedin' => $faker->url,
                'site' => $faker->url,
                'curriculo' => $faker->text,
                'status' => 1,
                'created_at' => $faker->dateTime($max = 'now', $timezone = null),
                'updated_at' => $faker->dateTime($max = 'now', $timezone = null)
            ]);

            $ids_professor[] = $professor->id;
        }

        for ($i = 0; $i < 20; $i++) {

            $categoria = CategoriaCurso::create([
                'nome' => $faker->name,
                'imagem' => null,
                'status' => 1,
                'created_at' => $faker->dateTime($max = 'now', $timezone = null),
                'updated_at' => $faker->dateTime($max = 'now', $timezone = null)
            ]);

            $ids_categoria[] = $categoria->id;
        }

        for ($i = 0; $i < 50; $i++) {
            $id_professor = array_rand($ids_professor);
            $id_categoria = array_rand($ids_categoria);

            $curso = Curso::create([
                'nome' => $faker->name,
                'imagem' => 'imagemCurso/padrao.png',
                'descricao' => $faker->text,
                'status' => 1,
                'aula_travada' => rand(1, 2),
                'tipo' => rand(1, 3),
                'visibilidade' => 1,
                'porcentagem_solicitacao_certificado' => rand(0, 100),
                'cooprodutor' => $faker->name,
                'categoria_id' => $ids_categoria[$id_categoria],
                'professor_id' => $ids_professor[$id_professor],
                'created_at' => $faker->dateTime($max = 'now', $timezone = null),
                'updated_at' => $faker->dateTime($max = 'now', $timezone = null)
            ]);
            $ids_curso[] = $curso->id;

            for ($y = 0; $y < 3; $y++) {
                $id_aula = aula_video($curso->id);
                anexo($id_aula);
                anexo($id_aula);
                $id_aula = aula_texto($curso->id);
                anexo($id_aula);
                anexo($id_aula);
                $id_aula = aula_quiz($curso->id);
            }
        }

        for ($i = 0; $i < 50; $i++) {
            $info = [
                0 => [
                    'tipo' => 1,
                    'parcelas' => 1,
                    'mes' => $faker->month($max = 'now') . '/' . $faker->year($max = 'now')
                ],
                1 => [
                    'tipo' => 2,
                    'parcelas' => rand(2, 6),
                    'mes' => $faker->month($max = 'now') . '/' . $faker->year($max = 'now')
                ]
            ];

            $ativado = [
                0 => [
                    'data_ativacao' => null,
                    'status' => 2,
                    'aluno_id' => null,
                    'unidade_id' => rand(1, 400),
                    'curso_id' => null,
                    'vendedor_id' => null,
                ],
                1 => [
                    'data_ativacao' => $faker->dateTimeBetween($startDate = '-60 years', $endDate = 'now', $timezone = null),
                    'status' => 1,
                    'aluno_id' => array_rand($ids_aluno),
                    'unidade_id' => rand(1, 400),
                    'curso_id' => array_rand($ids_curso),
                    'vendedor_id' => null,
                ],
            ];

            $n = rand(0, 1);
            $m = rand(0, 1);

            $matricula = Matricula::create([
                'ativacao' => Str::random(15),
                'tipo_pagamento' => $info[$n]['tipo'],
                'quant_parcelas' => $info[$n]['parcelas'],
                'mes_inicio_pagamento' => $info[$n]['mes'],
                'valor_venda' => rand(45, 120) . '.00',
                'nivel_curso' => rand(1, 3),
                'data_ativacao' => $ativado[$m]['data_ativacao'],
                'status' => $ativado[$m]['status'],
                'aluno_id' => $ativado[$m]['aluno_id'],
                'unidade_id' => $ativado[$m]['unidade_id'],
                'curso_id' => $ativado[$m]['curso_id'],
                'vendedor_id' => $ativado[$m]['vendedor_id'],
                'created_at' => $faker->dateTime($max = 'now', $timezone = null),
                'updated_at' => $faker->dateTime($max = 'now', $timezone = null)
            ]);
        }
    }
}
