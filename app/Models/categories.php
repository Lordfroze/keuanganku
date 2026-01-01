<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\transactions;
use Illuminate\Database\Eloquent\SoftDeletes;

class categories extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'user_id',
        'name',
        'type',
    ];

    public function transactions()
    {
        return $this->hasMany(transactions::class);
    }
}
