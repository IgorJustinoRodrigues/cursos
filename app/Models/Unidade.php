<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Unidade
 * 
 * @property int $id
 * @property string $nome
 * @property string|null $logo
 * @property string $usuario
 * @property string $senha
 * @property string|null $email
 * @property string|null $whatsapp
 * @property string|null $contato
 * @property string|null $endereco
 * @property string|null $cidade
 * @property string|null $estado
 * @property string|null $facebook
 * @property string|null $instagram
 * @property string|null $site
 * @property string $status
 * @property int $parceiro_id
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * 
 * @property Parceiro $parceiro
 * @property Collection|AtualizacaoTicket[] $atualizacao_tickets
 * @property Collection|Auditoria[] $auditorias
 * @property Collection|Cupom[] $cupoms
 * @property Collection|Fatura[] $faturas
 * @property Collection|Matricula[] $matriculas
 * @property Collection|Ticket[] $tickets
 * @property Collection|Vendedor[] $vendedors
 *
 * @package App\Models
 */
class Unidade extends Model
{
	protected $table = 'unidades';

	protected $casts = [
		'parceiro_id' => 'int'
	];

	protected $fillable = [
		'nome',
		'logo',
		'usuario',
		'senha',
		'email',
		'whatsapp',
		'contato',
		'endereco',
		'cidade',
		'estado',
		'facebook',
		'instagram',
		'site',
		'status',
		'parceiro_id'
	];

	public function parceiro()
	{
		return $this->belongsTo(Parceiro::class);
	}

	public function atualizacao_tickets()
	{
		return $this->hasMany(AtualizacaoTicket::class);
	}

	public function auditorias()
	{
		return $this->hasMany(Auditoria::class);
	}

	public function cupoms()
	{
		return $this->hasMany(Cupom::class);
	}

	public function faturas()
	{
		return $this->hasMany(Fatura::class);
	}

	public function matriculas()
	{
		return $this->hasMany(Matricula::class);
	}

	public function tickets()
	{
		return $this->hasMany(Ticket::class);
	}

	public function vendedors()
	{
		return $this->hasMany(Vendedor::class);
	}
}
