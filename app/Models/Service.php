<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @property User $administrator
 * @property Collection|Event[] $events
 */
class Service extends Model
{
    use SoftDeletes;

    public $timestamps = true;

    protected $dates = [
        'deleted_at'
    ];

    protected $fillable = [
        'administrator_id',
        'name',
        'timespan',
        'is_active',
        'show_timespan'
    ];

    protected $visible = [
        'administrator_id',
        'name',
        'timespan',
        'is_active',
        'show_timespan'
    ];

    /**
     * @return HasMany
     */
    public function events(): HasMany
    {
        return $this->hasMany('Event', 'service_id');
    }

    /**
     * @return BelongsTo
     */
    public function administrator(): BelongsTo
    {
        return $this->belongsTo('User', 'administrator_id');
    }

}
