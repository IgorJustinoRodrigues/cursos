<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Certificado
 * 
 * @property int $id
 * @property string $arquivo
 * @property string $validacao
 * @property string $status
 * @property int $curso_id
 * @property int $matricula_id
 * @property int $aluno_id
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * 
 * @property Aluno $aluno
 * @property Curso $curso
 * @property Matricula $matricula
 *
 * @package App\Models
 */
class Certificado extends Model
{
	protected $table = 'certificados';

	protected $casts = [
		'curso_id' => 'int',
		'matricula_id' => 'int',
		'aluno_id' => 'int'
	];

	protected $fillable = [
		'arquivo',
		'validacao',
		'status',
		'curso_id',
		'matricula_id',
		'aluno_id'
	];

	public function aluno()
	{
		return $this->belongsTo(Aluno::class);
	}

	public function curso()
	{
		return $this->belongsTo(Curso::class);
	}

	public function matricula()
	{
		return $this->belongsTo(Matricula::class);
	}
}
