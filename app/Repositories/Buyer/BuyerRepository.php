<?php

namespace App\Repositories\Buyer;

use App\Models\Buyer;
use App\Models\BranchOffice;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use GuzzleHttp\Exception\ClientException;
use App\Repositories\Buyer\BuyerRepositoryInterface;
use App\Repositories\BranchOffice\BranchOfficeRepository;

class BuyerRepository implements BuyerRepositoryInterface {

    const SUCCESSFULL_STATUS_CODE           = 200;
    const RESOURCE_CREATED_STATUS_CODE      = 201;
    const UNAUTHORISED_STATUS_CODE          = 401;
    const RESOURCE_NOT_FOUND_STATUS_CODE    = 404;

    public function __construct(Client $client) {
        $this->http = $client;
    }

    public function store(Request $request){
        $name   = $request->name;
        $input  = $request->all();
        $status   = [
            'message' => ' Successfully Created',
            'buyer_name'   => $name,
        ];
        $data = [$status, ''];
        Buyer::create($input);

        return $this->response( $data , self::SUCCESSFULL_STATUS_CODE );
    }

    public function index (){
        $status   = [
            'message' => ' Successfully',
        ];
        $data = Buyer::all();
        $data =  [ $status, $data ];

        return $this->response( $data , self::SUCCESSFULL_STATUS_CODE );
    }

    public function delete(Buyer $buyer){
        $status   = [
            'message' => ' Successfully Eliminated',
            'buyer_name'   => $buyer->name,
        ];
        $buyer->delete();
        $data = [ $status, ''];

        return $this->response( $data , self::SUCCESSFULL_STATUS_CODE );
    }

    public function buyTicket( BuyerRequest $buyer, Request $request ){
        $branchOffice = BranchOffice::find($request->branch_office_id);
        $branchOfficeRepository = new BranchOfficeRepository();
        $branchOfficeStatus = $branchOfficeRepository->soldticket($branchOffice, $request->quantity_tickets);

        if( $branchOfficeStatus->message == 'successfully' ){
            $status   = [
                'message' => ' Successfully Eliminated',
                'buyer_name'   => $buyer->name,
            ];
            $buyer->branch_office_id    = $branchOffice->id;$status   = [
                'message' => ' Successfully Eliminated',
                'buyer_name'   => $buyer->name,
            ];
            $buyer->tickets_buyed       = $request->quantity_tickets;
            $buyer->update();
            $data = [
                'buyer_name'          => $buyer->name,
                'branch_office_name'  => $branchOffice->name,
                'tieckts_buyed'       => $request->quantity_tickets,
            ];
            $data = [$status, $data];
        }
        else{
            $status = $branchOfficeStatus;
            $data = [$status, ''];
        }

        return $this->response( $data , self::SUCCESSFULL_STATUS_CODE );
    }

    public function response($data, int $statusCode) {
        $response = ["data"=>$data, "statusCode"=>$statusCode];
        return $response;
    }

}
