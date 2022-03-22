<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Ajuda
 * 
 * @property int $id
 * @property string $nome
 * @property string $texto
 * @property string $local
 * @property string $status
 * @property int $categoria_id
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * 
 * @property CategoriaAjuda $categoria_ajuda
 *
 * @package App\Models
 */
class Ajuda extends Model
{
	protected $table = 'ajudas';

	protected $casts = [
		'categoria_id' => 'int'
	];

	protected $fillable = [
		'nome',
		'texto',
		'local',
		'status',
		'categoria_id'
	];

	public function categoria_ajuda()
	{
		return $this->belongsTo(CategoriaAjuda::class, 'categoria_id');
	}
}
