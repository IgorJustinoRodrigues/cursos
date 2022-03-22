<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class PacoteCurso
 * 
 * @property int $id
 * @property string $nome
 * @property string|null $imagem
 * @property string|null $descricao
 * @property string $status
 * @property string $visibilidade
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * 
 * @property Collection|Cupom[] $cupoms
 * @property Collection|CursoPacote[] $curso_pacotes
 *
 * @package App\Models
 */
class PacoteCurso extends Model
{
	protected $table = 'pacote_cursos';

	protected $fillable = [
		'nome',
		'imagem',
		'descricao',
		'status',
		'visibilidade'
	];

	public function cupoms()
	{
		return $this->hasMany(Cupom::class, 'pacote_id');
	}

	public function curso_pacotes()
	{
		return $this->hasMany(CursoPacote::class, 'pacote_id');
	}
}
