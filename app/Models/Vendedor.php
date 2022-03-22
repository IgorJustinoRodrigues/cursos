<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Vendedor
 * 
 * @property int $id
 * @property string $nome
 * @property string|null $cpf
 * @property string|null $avatar
 * @property string|null $email
 * @property string|null $whatsapp
 * @property string $usuario
 * @property string $senha
 * @property string $status
 * @property int $unidade_id
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * 
 * @property Unidade $unidade
 * @property Collection|AtualizacaoTicket[] $atualizacao_tickets
 * @property Collection|Auditoria[] $auditorias
 * @property Collection|Matricula[] $matriculas
 * @property Collection|Ticket[] $tickets
 *
 * @package App\Models
 */
class Vendedor extends Model
{
	protected $table = 'vendedors';

	protected $casts = [
		'unidade_id' => 'int'
	];

	protected $fillable = [
		'nome',
		'cpf',
		'avatar',
		'email',
		'whatsapp',
		'usuario',
		'senha',
		'status',
		'unidade_id'
	];

	public function unidade()
	{
		return $this->belongsTo(Unidade::class);
	}

	public function atualizacao_tickets()
	{
		return $this->hasMany(AtualizacaoTicket::class);
	}

	public function auditorias()
	{
		return $this->hasMany(Auditoria::class);
	}

	public function matriculas()
	{
		return $this->hasMany(Matricula::class);
	}

	public function tickets()
	{
		return $this->hasMany(Ticket::class);
	}
}
