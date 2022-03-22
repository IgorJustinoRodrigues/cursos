<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Auditoria
 * 
 * @property int $id
 * @property string $descricao
 * @property string $ip
 * @property Carbon $data
 * @property int|null $admin_id
 * @property int|null $unidade_id
 * @property int|null $vendedor_id
 * @property int|null $aluno_id
 * 
 * @property Admin|null $admin
 * @property Aluno|null $aluno
 * @property Unidade|null $unidade
 * @property Vendedor|null $vendedor
 *
 * @package App\Models
 */
class Auditoria extends Model
{
	protected $table = 'auditorias';
	public $timestamps = false;

	protected $casts = [
		'admin_id' => 'int',
		'unidade_id' => 'int',
		'vendedor_id' => 'int',
		'aluno_id' => 'int'
	];

	protected $dates = [
		'data'
	];

	protected $fillable = [
		'descricao',
		'ip',
		'data',
		'admin_id',
		'unidade_id',
		'vendedor_id',
		'aluno_id'
	];

	public function admin()
	{
		return $this->belongsTo(Admin::class);
	}

	public function aluno()
	{
		return $this->belongsTo(Aluno::class);
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
