<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Cupom
 * 
 * @property int $id
 * @property string $codigo
 * @property string $descricao
 * @property string $limite_maximo
 * @property Carbon $abertura
 * @property Carbon $encerramento
 * @property int|null $pacote_id
 * @property int|null $curso_id
 * @property int $unidade_id
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * 
 * @property Curso|null $curso
 * @property PacoteCurso|null $pacote_curso
 * @property Unidade $unidade
 * @property Collection|Matricula[] $matriculas
 *
 * @package App\Models
 */
class Cupom extends Model
{
	protected $table = 'cupoms';

	protected $casts = [
		'pacote_id' => 'int',
		'curso_id' => 'int',
		'unidade_id' => 'int'
	];

	protected $dates = [
		'abertura',
		'encerramento'
	];

	protected $fillable = [
		'codigo',
		'descricao',
		'limite_maximo',
		'abertura',
		'encerramento',
		'pacote_id',
		'curso_id',
		'unidade_id'
	];

	public function curso()
	{
		return $this->belongsTo(Curso::class);
	}

	public function pacote_curso()
	{
		return $this->belongsTo(PacoteCurso::class, 'pacote_id');
	}

	public function unidade()
	{
		return $this->belongsTo(Unidade::class);
	}

	public function matriculas()
	{
		return $this->hasMany(Matricula::class);
	}
}
