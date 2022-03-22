<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class CategoriaCurso
 * 
 * @property int $id
 * @property string $nome
 * @property string|null $imagem
 * @property string $status
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * 
 * @property Collection|Curso[] $cursos
 *
 * @package App\Models
 */
class CategoriaCurso extends Model
{
	protected $table = 'categoria_cursos';

	protected $fillable = [
		'nome',
		'imagem',
		'status'
	];

	public function cursos()
	{
		return $this->hasMany(Curso::class, 'categoria_id');
	}
}
