<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Ticket
 * 
 * @property int $id
 * @property string $titulo
 * @property string $descricao
 * @property string $status
 * @property int|null $aluno_id
 * @property int|null $vendedor_id
 * @property int|null $unidade_id
 * @property int|null $curso_id
 * @property int|null $aula_id
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * 
 * @property Aluno|null $aluno
 * @property Aula|null $aula
 * @property Curso|null $curso
 * @property Unidade|null $unidade
 * @property Vendedor|null $vendedor
 * @property Collection|AtualizacaoTicket[] $atualizacao_tickets
 *
 * @package App\Models
 */
class Ticket extends Model
{
	protected $table = 'tickets';

	protected $casts = [
		'aluno_id' => 'int',
		'vendedor_id' => 'int',
		'unidade_id' => 'int',
		'curso_id' => 'int',
		'aula_id' => 'int'
	];

	protected $fillable = [
		'titulo',
		'descricao',
		'status',
		'aluno_id',
		'vendedor_id',
		'unidade_id',
		'curso_id',
		'aula_id'
	];

	public function aluno()
	{
		return $this->belongsTo(Aluno::class);
	}

	public function aula()
	{
		return $this->belongsTo(Aula::class);
	}

	public function curso()
	{
		return $this->belongsTo(Curso::class);
	}

	public function unidade()
	{
		return $this->belongsTo(Unidade::class);
	}

	public function vendedor()
	{
		return $this->belongsTo(Vendedor::class);
	}

	public function atualizacao_tickets()
	{
		return $this->hasMany(AtualizacaoTicket::class);
	}
}
