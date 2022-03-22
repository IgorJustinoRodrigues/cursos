<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Aluno
 * 
 * @property int $id
 * @property string $nome
 * @property Carbon|null $nascimento
 * @property string|null $sexo
 * @property string|null $avatar
 * @property string $email
 * @property string|null $whatsapp
 * @property string|null $telefone
 * @property string|null $contato
 * @property string|null $cidade
 * @property string|null $estado
 * @property string $senha
 * @property string|null $token
 * @property Carbon|null $recupera_senha
 * @property int $pontuacao
 * @property string $status
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * 
 * @property Collection|AtualizacaoTicket[] $atualizacao_tickets
 * @property Collection|Auditoria[] $auditorias
 * @property Collection|Aula[] $aulas
 * @property Collection|Certificado[] $certificados
 * @property Collection|Matricula[] $matriculas
 * @property Collection|Ticket[] $tickets
 *
 * @package App\Models
 */
class Aluno extends Model
{
	protected $table = 'alunos';

	protected $casts = [
		'pontuacao' => 'int'
	];

	protected $dates = [
		'nascimento',
		'recupera_senha'
	];

	protected $hidden = [
		'token'
	];

	protected $fillable = [
		'nome',
		'nascimento',
		'sexo',
		'avatar',
		'email',
		'whatsapp',
		'telefone',
		'contato',
		'cidade',
		'estado',
		'senha',
		'token',
		'recupera_senha',
		'pontuacao',
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

	public function aulas()
	{
		return $this->belongsToMany(Aula::class, 'aula_alunos')
					->withPivot('id', 'nota', 'abertura', 'conclusao', 'avaliacao_aula', 'descricao', 'anotacao', 'curso_id')
					->withTimestamps();
	}

	public function certificados()
	{
		return $this->hasMany(Certificado::class);
	}

	public function matriculas()
	{
		return $this->hasMany(Matricula::class);
	}

	public function tickets()
	{
		return $this->hasMany(Ticket::class);
	}
}
