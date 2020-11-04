<?php

namespace App\Repositories\Buyer;

use App\Models\Buyer;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use GuzzleHttp\Exception\ClientException;
use App\Repositories\Buyer\BuyerRepositoryInterface;

class BuyerRepository implements BuyerRepositoryInterface {

    const SUCCESSFULL_STATUS_CODE           = 200;
    const RESOURCE_CREATED_STATUS_CODE      = 201;
    const UNAUTHORISED_STATUS_CODE          = 401;
    const RESOURCE_NOT_FOUND_STATUS_CODE    = 404;

    public function __construct(Client $client) {
        $this->http = $client;
    }

    public function store(Request $request){
        $name = $request->name;
        $input = $request->all();
        Buyer::create($input);
        return $this->response([
            'message' => ' Successfully Created',
            'buyer'   => $name,  ],
        self::SUCCESSFULL_STATUS_CODE);
    }

    public function response($data, int $statusCode) {
        $response = ["data"=>$data, "statusCode"=>$statusCode];
        return $response;
    }
}
