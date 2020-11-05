<?php

namespace App\Repositories\Buyer;

use Illuminate\Http\Request;
use App\Models\Buyer;

interface BuyerRepositoryInterface {
    public function index ();
    public function store(Request $request);
    public function delete(Buyer $buyer);
    public function response($data, int $statusCode);
}
