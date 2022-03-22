<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Cobranca
 * 
 * @property int $id
 * @property string $valor
 * @property string $descricao
 * @property string $status
 * @property int $fatura_id
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * 
 * @property Fatura $fatura
 *
 * @package App\Models
 */
class Cobranca extends Model
{
	protected $table = 'cobrancas';

	protected $casts = [
		'fatura_id' => 'int'
	];

	protected $fillable = [
		'valor',
		'descricao',
		'status',
		'fatura_id'
	];

	public function fatura()
	{
		return $this->belongsTo(Fatura::class);
	}
}
