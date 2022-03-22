<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class AtualizacaoTicket
 * 
 * @property int $id
 * @property string $descricao
 * @property int|null $aluno_id
 * @property int|null $ticket_id
 * @property int|null $vendedor_id
 * @property int|null $unidade_id
 * @property int|null $admin_id
 * @property int|null $professor_id
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * 
 * @property Admin|null $admin
 * @property Aluno|null $aluno
 * @property Professor|null $professor
 * @property Ticket|null $ticket
 * @property Unidade|null $unidade
 * @property Vendedor|null $vendedor
 *
 * @package App\Models
 */
class AtualizacaoTicket extends Model
{
	protected $table = 'atualizacao_tickets';

	protected $casts = [
		'aluno_id' => 'int',
		'ticket_id' => 'int',
		'vendedor_id' => 'int',
		'unidade_id' => 'int',
		'admin_id' => 'int',
		'professor_id' => 'int'
	];

	protected $fillable = [
		'descricao',
		'aluno_id',
		'ticket_id',
		'vendedor_id',
		'unidade_id',
		'admin_id',
		'professor_id'
	];

	public function admin()
	{
		return $this->belongsTo(Admin::class);
	}

	public function aluno()
	{
		return $this->belongsTo(Aluno::class);
	}

	public function professor()
	{
		return $this->belongsTo(Professor::class);
	}

	public function ticket()
	{
		return $this->belongsTo(Ticket::class);
	}

	public function unidade()
	{
		return $this->belongsTo(Unidade::class);
	}

	public function vendedor()
	{
		return $this->belongsTo(Vendedor::class);
	}
}
