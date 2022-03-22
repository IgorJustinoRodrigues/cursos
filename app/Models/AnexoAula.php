<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class AnexoAula
 * 
 * @property int $id
 * @property string $nome
 * @property string $arquivo
 * @property int $aula_id
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * 
 * @property Aula $aula
 *
 * @package App\Models
 */
class AnexoAula extends Model
{
	protected $table = 'anexo_aulas';

	protected $casts = [
		'aula_id' => 'int'
	];

	protected $fillable = [
		'nome',
		'arquivo',
		'aula_id'
	];

	public function aula()
	{
		return $this->belongsTo(Aula::class);
	}
}
