<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Resposta
 * 
 * @property int $id
 * @property string $resposta
 * @property string $correta
 * @property int $pergunta_id
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * 
 * @property Pergunta $pergunta
 *
 * @package App\Models
 */
class Resposta extends Model
{
	protected $table = 'respostas';

	protected $casts = [
		'pergunta_id' => 'int'
	];

	protected $fillable = [
		'resposta',
		'correta',
		'pergunta_id'
	];

	public function pergunta()
	{
		return $this->belongsTo(Pergunta::class);
	}
}
