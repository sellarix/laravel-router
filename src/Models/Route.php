<?php

declare(strict_types=1);

namespace Sellarix\Router\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Route extends Model
{
    protected $fillable = [
        'url', 'redirect', 'controller', 'method', 'model_id',
        'model_type', 'parameters', 'middleware', 'priority', 'name', 'method_type'
    ];

    // parameters and middleware are json encoded
    protected $casts = [
        'parameters' => 'array',
        'middleware' => 'array',
    ];

    public function getCreatedAtAttribute($value)
    {
        return Carbon::parse($value)->format('d/m/Y');
    }

    public function setUrlAttribute($value)
    {
        $this->attributes['url'] = trim(strtolower($value), '/');
    }

    public function scopeActive($query)
    {
        return $query->where('priority', 1);
    }

    public function scopeForModel($query, $modelType, $modelId)
    {
        return $query->where('model_type', $modelType)->where('model_id', $modelId);
    }
}
