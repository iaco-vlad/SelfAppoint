<?php

namespace App\Http\Controllers\API;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\JsonResponse;
use Illuminate\Routing\Controller as BaseController;

abstract class MainController extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    /**
     * The main execution body
     *
     * @param mixed ...$args
     * @return JsonResponse
     */
    abstract public function execute(...$args) : JsonResponse;
}
