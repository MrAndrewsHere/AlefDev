<?php

declare(strict_types=1);

namespace App\Domain\Share\Controllers;

use App\Domain\Share\Controllers\Traits\HasRequestPerPage;
use Illuminate\Routing\Controller as BaseController;

abstract class Controller extends BaseController
{
    use HasRequestPerPage;
}
