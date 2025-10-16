<?php

namespace App\Casts;

use Illuminate\Contracts\Database\Eloquent\CastsAttributes;
use Illuminate\Database\Eloquent\Model;

class DueWindowCast implements CastsAttributes
{
    public function get(Model $model, string $key, $value, array $attributes)
    {
        $arr = $value ? json_decode($value, true) : null;
        if (!$arr) return null;
        return [
            'start' => $arr['start'] ? \Carbon\Carbon::parse($arr['start']) : null,
            'end'   => $arr['end']   ? \Carbon\Carbon::parse($arr['end'])   : null,
        ];
    }

    public function set(Model $model, string $key, $value, array $attributes)
    {
        if (!$value) return null;
        return json_encode([
            'start' => isset($value['start']) ? (string)\Carbon\Carbon::parse($value['start']) : null,
            'end'   => isset($value['end'])   ? (string)\Carbon\Carbon::parse($value['end'])   : null,
        ]);
    }
}
