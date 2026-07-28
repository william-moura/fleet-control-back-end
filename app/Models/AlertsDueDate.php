<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\Relations\MorphOne;
use Illuminate\Database\Eloquent\Relations\MorphToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;
use Illuminate\Database\Eloquent\Relations\HasOneThrough;

class AlertsDueDate extends Model
{
    use HasFactory, SoftDeletes;
    protected $table = 'alerts_due_date';
    protected $primaryKey = 'id';
    protected $fillable = ['user_id', 'description', 'due_date', 'status'];
    protected $casts = [
        'due_date' => 'date',
    ];
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
    public function alertable(): MorphTo
    {
        return $this->morphTo();
    }
}