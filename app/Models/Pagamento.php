<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Pagamento
 * 
 * @property int $id
 * @property string $valor
 * @property string|null $comprovante
 * @property string $status
 * @property int $fatura_id
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * 
 * @property Fatura $fatura
 *
 * @package App\Models
 */
class Pagamento extends Model
{
	protected $table = 'pagamentos';

	protected $casts = [
		'fatura_id' => 'int'
	];

	protected $fillable = [
		'valor',
		'comprovante',
		'status',
		'fatura_id'
	];

	public function fatura()
	{
		return $this->belongsTo(Fatura::class);
	}
}
