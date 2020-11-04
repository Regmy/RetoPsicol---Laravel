<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Repositories\Buyer\BuyerRepository;
use App\Http\Requests\BuyerRequest;
use App\Models\Buyer;

class BuyersController extends Controller
{
    //
    public function __construct(BuyerRepository $buyerRepository){
        $this->buyerRepository = $buyerRepository;
    }

    public function store(BuyerRequest $request){
        $response = $this->buyerRepository->store($request);
        return response()->json($response["data"], $response["statusCode"]);
    }

  /*   public function edit(BuyerRequest $request){
        $response = $this->buyerRepository->edit($request);
        return response()->json($response["data"], $response["statusCode"]);
    } */
}
