<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class Observation extends Model
{
    protected $fillable = ['user_id', 'descricao', 'descricao', 'sala', 'dataHora', 'verificado'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}