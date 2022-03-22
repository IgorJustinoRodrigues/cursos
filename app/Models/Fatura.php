<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Fatura
 * 
 * @property int $id
 * @property string $mes_referencia
 * @property int $unidade_id
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * 
 * @property Unidade $unidade
 * @property Collection|Cobranca[] $cobrancas
 * @property Collection|Pagamento[] $pagamentos
 *
 * @package App\Models
 */
class Fatura extends Model
{
	protected $table = 'faturas';

	protected $casts = [
		'unidade_id' => 'int'
	];

	protected $fillable = [
		'mes_referencia',
		'unidade_id'
	];

	public function unidade()
	{
		return $this->belongsTo(Unidade::class);
	}

	public function cobrancas()
	{
		return $this->hasMany(Cobranca::class);
	}

	public function pagamentos()
	{
		return $this->hasMany(Pagamento::class);
	}
}
