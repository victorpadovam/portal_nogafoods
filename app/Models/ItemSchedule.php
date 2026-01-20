<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ItemSchedule extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'item_schedule';

    protected $casts = [
        'day'=>'integer',
        'store_id'=>'integer',
        'item_id'=>'integer',
    ];

    protected $fillable = ['store_id', 'item_id','day','opening_time','closing_time'];

    public function item()
    {
        return $this->belongsTo(Item::class);
    }
}
