<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @property User $administrator
 * @property Collection|Event[] $events
 *
 * @property int id
 * @property int administrator_id
 * @property string name
 * @property int timespan
 * @property bool is_active
 * @property bool show_timespan
 *
 * @method static getAllByAdministratorId($administratorId)
 *
 * @mixin Builder
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
        'id',
        'administrator_id',
        'name',
        'timespan',
        'is_active',
        'show_timespan'
    ];

    protected $casts = [
        'is_active' => 'bool',
        'show_timespan' => 'bool'
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

    /**
     * @param Builder $query
     * @param $administratorId
     * @return Collection|array
     */
    public function scopeGetAllByAdministratorId(Builder $query, $administratorId): Collection|array
    {
        return $query->where('administrator_id', $administratorId)->get();
    }
}
