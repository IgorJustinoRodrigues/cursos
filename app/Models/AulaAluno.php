<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class AulaAluno
 * 
 * @property int $id
 * @property string|null $nota
 * @property Carbon $abertura
 * @property Carbon|null $conclusao
 * @property string|null $avaliacao_aula
 * @property string|null $descricao
 * @property string|null $anotacao
 * @property int $aluno_id
 * @property int $aula_id
 * @property int $curso_id
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * 
 * @property Aluno $aluno
 * @property Aula $aula
 * @property Curso $curso
 *
 * @package App\Models
 */
class AulaAluno extends Model
{
	protected $table = 'aula_alunos';

	protected $casts = [
		'aluno_id' => 'int',
		'aula_id' => 'int',
		'curso_id' => 'int'
	];

	protected $dates = [
		'abertura',
		'conclusao'
	];

	protected $fillable = [
		'nota',
		'abertura',
		'conclusao',
		'avaliacao_aula',
		'descricao',
		'anotacao',
		'aluno_id',
		'aula_id',
		'curso_id'
	];

	public function aluno()
	{
		return $this->belongsTo(Aluno::class);
	}

	public function aula()
	{
		return $this->belongsTo(Aula::class);
	}

	public function curso()
	{
		return $this->belongsTo(Curso::class);
	}
}
