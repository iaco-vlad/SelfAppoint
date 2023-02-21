<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 *
 * @property Service $service
 * @property User $administrator
 * @property User $user
 *
 * @property int $id
 * @property int $administrator_id
 * @property int $user_id
 * @property int $service_id
 * @property string $date
 * @property string $time
 * @property string $status
 * @property string $description
 *
 * @property bool $isInThePast
 *
 * @method static getAllByUserId($userId)
 *
 * @mixin Builder
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

    protected $visible = [
        'id',
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
        return $this->belongsTo(Service::class, 'service_id');
    }

    /**
     * @return BelongsTo
     */
    public function administrator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'administrator_id');
    }

    /**
     * @return BelongsTo
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * @param Builder $query
     * @param $userId
     * @return Collection|array
     */
    public function scopeGetAllByUserId(Builder $query, $userId): Collection|array
    {
        return $query->with('user', 'service')
            ->orderBy('date', 'desc')
            ->where('administrator_id', $userId)
            ->orWhere('user_id', $userId)
            ->get();
    }

    /**
     * @return bool
     */
    public function getIsInThePastAttribute(): bool
    {
        $eventDate = Carbon::createFromFormat('Y-m-d H:i:s', $this->date);
        $eventDateTime = $eventDate->format('Y-m-d') . ' ' . $this->time;
        return Carbon::parse($eventDateTime)->isBefore(now());
    }
}
