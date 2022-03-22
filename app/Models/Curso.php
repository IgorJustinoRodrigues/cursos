<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Curso
 * 
 * @property int $id
 * @property string $nome
 * @property string|null $imagem
 * @property string|null $descricao
 * @property string $status
 * @property string $aula_travada
 * @property string $tipo
 * @property string $visibilidade
 * @property string $porcentagem_solicitacao_certificado
 * @property string|null $cooprodutor
 * @property int|null $aula_teste
 * @property int $categoria_id
 * @property int $professor_id
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * 
 * @property CategoriaCurso $categoria_curso
 * @property Professor $professor
 * @property Collection|AulaAluno[] $aula_alunos
 * @property Collection|Aula[] $aulas
 * @property Collection|Certificado[] $certificados
 * @property Collection|Cupom[] $cupoms
 * @property Collection|CursoPacote[] $curso_pacotes
 * @property Collection|Matricula[] $matriculas
 * @property Collection|Ticket[] $tickets
 *
 * @package App\Models
 */
class Curso extends Model
{
	protected $table = 'cursos';

	protected $casts = [
		'aula_teste' => 'int',
		'categoria_id' => 'int',
		'professor_id' => 'int'
	];

	protected $fillable = [
		'nome',
		'imagem',
		'descricao',
		'status',
		'aula_travada',
		'tipo',
		'visibilidade',
		'porcentagem_solicitacao_certificado',
		'cooprodutor',
		'aula_teste',
		'categoria_id',
		'professor_id'
	];

	public function categoria_curso()
	{
		return $this->belongsTo(CategoriaCurso::class, 'categoria_id');
	}

	public function professor()
	{
		return $this->belongsTo(Professor::class);
	}

	public function aula_alunos()
	{
		return $this->hasMany(AulaAluno::class);
	}

	public function aulas()
	{
		return $this->hasMany(Aula::class);
	}

	public function certificados()
	{
		return $this->hasMany(Certificado::class);
	}

	public function cupoms()
	{
		return $this->hasMany(Cupom::class);
	}

	public function curso_pacotes()
	{
		return $this->hasMany(CursoPacote::class);
	}

	public function matriculas()
	{
		return $this->hasMany(Matricula::class);
	}

	public function tickets()
	{
		return $this->hasMany(Ticket::class);
	}
}
