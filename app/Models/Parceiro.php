<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Parceiro
 * 
 * @property int $id
 * @property string $nome
 * @property string|null $logo
 * @property string|null $sobre
 * @property string $usuario
 * @property string $senha
 * @property string $status
 * @property string $visibilidade
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * 
 * @property Collection|Unidade[] $unidades
 *
 * @package App\Models
 */
class Parceiro extends Model
{
	protected $table = 'parceiros';

	protected $fillable = [
		'nome',
		'logo',
		'sobre',
		'usuario',
		'senha',
		'status',
		'visibilidade'
	];

	public function unidades()
	{
		return $this->hasMany(Unidade::class);
	}
}
