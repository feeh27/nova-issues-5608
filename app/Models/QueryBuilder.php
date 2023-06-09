<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class QueryBuilder extends Model
{
    use SoftDeletes;

    protected $table = 'query_builder';

    protected $fillable = [
        'parent_id',
        'name',
        'condition',
        'operator',
        'value',
    ];

    public function parent(): BelongsTo
    {
        return $this->belongsTo(
            static::class,
            'parent_id',
            'id',
        );
    }
}
