<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Admin
 * 
 * @property int $id
 * @property string $nome
 * @property string $email
 * @property string $senha
 * @property string|null $token
 * @property Carbon|null $validade_token
 * @property string $avatar
 * @property string $tipo
 * @property string|null $anotacoes
 * @property string $status
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * 
 * @property Collection|AtualizacaoTicket[] $atualizacao_tickets
 * @property Collection|Auditoria[] $auditorias
 *
 * @package App\Models
 */
class Admin extends Model
{
	protected $table = 'admins';

	protected $dates = [
		'validade_token'
	];

	protected $hidden = [
		'token',
		'validade_token'
	];

	protected $fillable = [
		'nome',
		'email',
		'senha',
		'token',
		'validade_token',
		'avatar',
		'tipo',
		'anotacoes',
		'status'
	];

	public function atualizacao_tickets()
	{
		return $this->hasMany(AtualizacaoTicket::class);
	}

	public function auditorias()
	{
		return $this->hasMany(Auditoria::class);
	}
}
