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

    public function __construct(Client $client, BranchOfficeRepository $branchOfficeRepository) {
        $this->http = $client;
        $this->branchOfficeRepository = $branchOfficeRepository;
    }

    public function store(Request $request){
        $name   = $request->name;
        $input  = $request->all();
        $status   = [
            'message' => ' Successfully Created',
            'buyer_name'   => $name,
        ];
        $data = [$status, ''];

        if( !$request->exists('ticket_buyed') || $input['ticket_buyed'] == '' ){
            $input['ticket_buyed'] = 0;
        }
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

    public function assignament(Buyer $buyer, Request $request ){
        $status = $this->branchOfficeRepository
        ->soldticket($request->branch_office_id, $request->quantity_tickets);

        if( $status['message'] == 'successfully' ){
            $buyer->branch_office_id    = $request->branch_office_id;
            $buyer->ticket_buyed       = $request->quantity_tickets;
            $data = [
                'buyer_name'          => $buyer->name,
                'branch_office_id'    => $request->branch_office_id,
                'tieckts_buyed'       => $request->quantity_tickets,
            ];
            $buyer->update();
            $data = [$status, $data];
        }
        else{
            $data = [$status, ''];
        }

        return $this->response( $data , self::SUCCESSFULL_STATUS_CODE );
    }

    public function response($data, int $statusCode) {
        $response = ["data"=>$data, "statusCode"=>$statusCode];
        return $response;
    }

}
