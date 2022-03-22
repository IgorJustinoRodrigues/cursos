<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Professor
 * 
 * @property int $id
 * @property string $nome
 * @property string|null $avatar
 * @property string|null $email
 * @property string|null $facebook
 * @property string|null $instagram
 * @property string|null $linkedin
 * @property string|null $site
 * @property string|null $curriculo
 * @property string $status
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * 
 * @property Collection|AtualizacaoTicket[] $atualizacao_tickets
 * @property Collection|Curso[] $cursos
 *
 * @package App\Models
 */
class Professor extends Model
{
	protected $table = 'professors';

	protected $fillable = [
		'nome',
		'avatar',
		'email',
		'facebook',
		'instagram',
		'linkedin',
		'site',
		'curriculo',
		'status'
	];

	public function atualizacao_tickets()
	{
		return $this->hasMany(AtualizacaoTicket::class);
	}

	public function cursos()
	{
		return $this->hasMany(Curso::class);
	}
}
