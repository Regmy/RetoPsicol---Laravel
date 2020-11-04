<?php

namespace App\Repositories\Buyer;

use Illuminate\Http\Request;

interface BuyerRepositoryInterface {
    public function store(Request $request);
    public function response($data, int $statusCode);
    // public function edit(Request $request);
    // public function refreshToken(Request $request);
    // public function details();
    // public function logout(Request $request);
    // public function getTokenAndRefreshToken(string $email, string $password);
    // public function sendRequest(string $route, array $formParams);
    // public function getOClient();
}
