<?php

namespace App\Http\Controllers\API;

abstract class MainMiddlewareController extends MainController
{
    public function __construct()
    {
        $this->middleware('auth:sanctum');
    }
}
