<?php

declare(strict_types=1);

namespace App\Domain\Share\Controllers\Traits;

use Illuminate\Http\Request;

trait HasRequestPerPage
{
    protected function requestPerPage(?Request $request = null, int $default = 15, int $max = 100): int
    {
        return max(1, min($max, ($request ?? request())->integer('per_page', $default)));
    }
}
