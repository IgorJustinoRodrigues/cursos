<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class CategoriaAjuda
 * 
 * @property int $id
 * @property string $nome
 * @property string|null $icone
 * @property string $status
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * 
 * @property Collection|Ajuda[] $ajudas
 *
 * @package App\Models
 */
class CategoriaAjuda extends Model
{
	protected $table = 'categoria_ajudas';

	protected $fillable = [
		'nome',
		'icone',
		'status'
	];

	public function ajudas()
	{
		return $this->hasMany(Ajuda::class, 'categoria_id');
	}
}
