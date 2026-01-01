<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\categories;
use Illuminate\Database\Eloquent\SoftDeletes;


class transactions extends Model
{
    use SoftDeletes;

    public $fillable = [
        'user_id',
        'category_id',
        'amount',
        'description',
        'transaction_date',
    ];

    public function category()
    {
        return $this->belongsTo(categories::class);
    }
}
