<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Pergunta
 * 
 * @property int $id
 * @property string $pergunta
 * @property int $aulas_id
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * 
 * @property Aula $aula
 * @property Collection|Resposta[] $respostas
 *
 * @package App\Models
 */
class Pergunta extends Model
{
	protected $table = 'perguntas';

	protected $casts = [
		'aulas_id' => 'int'
	];

	protected $fillable = [
		'pergunta',
		'aulas_id'
	];

	public function aula()
	{
		return $this->belongsTo(Aula::class, 'aulas_id');
	}

	public function respostas()
	{
		return $this->hasMany(Resposta::class);
	}
}
