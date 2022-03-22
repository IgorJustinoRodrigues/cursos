<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Newsletter
 * 
 * @property int $id
 * @property string $nome
 * @property string $email
 * @property string $hash
 * @property string $status
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 * @package App\Models
 */
class Newsletter extends Model
{
	protected $table = 'newsletters';

	protected $fillable = [
		'nome',
		'email',
		'hash',
		'status'
	];
}
