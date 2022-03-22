<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class CursoPacote
 * 
 * @property int $pacote_id
 * @property int $curso_id
 * 
 * @property Curso $curso
 * @property PacoteCurso $pacote_curso
 *
 * @package App\Models
 */
class CursoPacote extends Model
{
	protected $table = 'curso_pacotes';
	public $incrementing = false;
	public $timestamps = false;

	protected $casts = [
		'pacote_id' => 'int',
		'curso_id' => 'int'
	];

	public function curso()
	{
		return $this->belongsTo(Curso::class);
	}

	public function pacote_curso()
	{
		return $this->belongsTo(PacoteCurso::class, 'pacote_id');
	}
}
