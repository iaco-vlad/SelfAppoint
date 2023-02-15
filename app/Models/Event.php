<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 *
 * @property Service $service
 * @property User $administrator
 * @property User $user
 */
class Event extends Model
{
    use SoftDeletes;

    public $timestamps = true;

    protected $fillable = [
        'administrator_id',
        'user_id',
        'service_id',
        'date',
        'time',
        'status',
        'description'
    ];

    /**
     * @return BelongsTo
     */
    public function service(): BelongsTo
    {
        return $this->belongsTo('Service', 'service_id');
    }

    /**
     * @return BelongsTo
     */
    public function administrator(): BelongsTo
    {
        return $this->belongsTo('User', 'administrator_id');
    }

    /**
     * @return BelongsTo
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo('User', 'user_id');
    }
}
