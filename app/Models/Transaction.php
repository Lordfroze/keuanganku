<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;



class Transaction extends Model
{
    use SoftDeletes;

    public $fillable = [
        'user_id',
        'category_id',
        'amount',
        'description',
        'transaction_date',
        'deleted_at',
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }
}
