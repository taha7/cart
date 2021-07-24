<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Resources\PrivateUserResource;

class MeController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth']);
    }
    public function __invoke()
    {
        return new PrivateUserResource(auth()->user());
    }
}
