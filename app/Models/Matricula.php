<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Matricula
 * 
 * @property int $id
 * @property string $ativacao
 * @property string $tipo_pagamento
 * @property string|null $quant_parcelas
 * @property string|null $mes_inicio_pagamento
 * @property string|null $valor_venda
 * @property string $nivel_curso
 * @property Carbon|null $data_ativacao
 * @property string $status
 * @property int|null $aluno_id
 * @property int $unidade_id
 * @property int|null $curso_id
 * @property int|null $vendedor_id
 * @property int|null $cupom_id
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * 
 * @property Aluno|null $aluno
 * @property Cupom|null $cupom
 * @property Curso|null $curso
 * @property Unidade $unidade
 * @property Vendedor|null $vendedor
 * @property Collection|Certificado[] $certificados
 *
 * @package App\Models
 */
class Matricula extends Model
{
	protected $table = 'matriculas';

	protected $casts = [
		'aluno_id' => 'int',
		'unidade_id' => 'int',
		'curso_id' => 'int',
		'vendedor_id' => 'int',
		'cupom_id' => 'int'
	];

	protected $dates = [
		'data_ativacao'
	];

	protected $fillable = [
		'ativacao',
		'tipo_pagamento',
		'quant_parcelas',
		'mes_inicio_pagamento',
		'valor_venda',
		'nivel_curso',
		'data_ativacao',
		'status',
		'aluno_id',
		'unidade_id',
		'curso_id',
		'vendedor_id',
		'cupom_id'
	];

	public function aluno()
	{
		return $this->belongsTo(Aluno::class);
	}

	public function cupom()
	{
		return $this->belongsTo(Cupom::class);
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

	public function certificados()
	{
		return $this->hasMany(Certificado::class);
	}
}
