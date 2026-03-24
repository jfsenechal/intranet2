<?php

declare(strict_types=1);

namespace AcMarche\Pst\Http\Controllers\Api;

use AcMarche\Pst\Models\User;
use Illuminate\Http\JsonResponse;

final class UserController
{
    public function index(): JsonResponse
    {
        $usernames = User::query()->pluck('username');

        return response()->json(['data' => $usernames]);
    }
}
