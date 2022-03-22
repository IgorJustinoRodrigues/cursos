<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Aula
 * 
 * @property int $id
 * @property int|null $ordem
 * @property string $tipo
 * @property string $nome
 * @property string|null $descricao
 * @property string|null $video
 * @property string|null $texto
 * @property string $duracao
 * @property string $avaliacao
 * @property string $status
 * @property int $curso_id
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * 
 * @property Curso $curso
 * @property Collection|AnexoAula[] $anexo_aulas
 * @property Collection|Aluno[] $alunos
 * @property Collection|Pergunta[] $perguntas
 * @property Collection|Ticket[] $tickets
 *
 * @package App\Models
 */
class Aula extends Model
{
	protected $table = 'aulas';

	protected $casts = [
		'ordem' => 'int',
		'curso_id' => 'int'
	];

	protected $fillable = [
		'ordem',
		'tipo',
		'nome',
		'descricao',
		'video',
		'texto',
		'duracao',
		'avaliacao',
		'status',
		'curso_id'
	];

	public function curso()
	{
		return $this->belongsTo(Curso::class);
	}

	public function anexo_aulas()
	{
		return $this->hasMany(AnexoAula::class);
	}

	public function alunos()
	{
		return $this->belongsToMany(Aluno::class, 'aula_alunos')
					->withPivot('id', 'nota', 'abertura', 'conclusao', 'avaliacao_aula', 'descricao', 'anotacao', 'curso_id')
					->withTimestamps();
	}

	public function perguntas()
	{
		return $this->hasMany(Pergunta::class, 'aulas_id');
	}

	public function tickets()
	{
		return $this->hasMany(Ticket::class);
	}
}
