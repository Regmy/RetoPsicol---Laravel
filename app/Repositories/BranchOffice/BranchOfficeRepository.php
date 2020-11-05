<?php

namespace App\Repositories\BranchOffice;

use App\Models\BranchOffice;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use GuzzleHttp\Exception\ClientException;
use App\Repositories\BranchOffice\BranchOfficeRepositoryInterface;

class BranchOfficeRepository implements BranchOfficeRepositoryInterface {

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
            'branchOffice'   => $name,
        ];
        $data = [$status, ''];

        if( !$request->exists('tickets_sold') || $request['tickets_sold'] == '' ){
            $input['tickets_sold'] = 0;
        }

        BranchOffice::create($input);

        return $this->response( $data , self::SUCCESSFULL_STATUS_CODE );
    }

    public function index (){
        $status   = [
            'message' => ' Successfully',
        ];
        $data = BranchOffice::all();
        $data =  [ $status, $data ];

        return $this->response( $data , self::SUCCESSFULL_STATUS_CODE );
    }

    public function delete(BranchOffice $branchOffice){
        $status   = [
            'message' => ' Successfully Eliminated',
            'BranchOffice'   =>  $branchOffice->name,
        ];
        $branchOffice->delete();
        $data = [ $status, ''];

        return $this->response( $data , self::SUCCESSFULL_STATUS_CODE );
    }

    public function available(BranchOffice $branchOffice){
        $status   = [
            'message' => ' Successfully',
            'BranchOffice'   =>  $branchOffice->name,
        ];

        $tickets_available =  ($branchOffice->tickets_quantity) - ($branchOffice->tickets_sold);
        $data = [ $status, 'tickets_available' => $tickets_available ];

        return $this->response( $data , self::SUCCESSFULL_STATUS_CODE );
    }

    public function soldticket( $branchOffice_id, $quantity ){
        $branchOffice = BranchOffice::find($branchOffice_id);
        $branchOffice->tickets_sold += $quantity;
        if ($branchOffice->tickets_sold < 0){
            $status   = [
                'message' => ' that quiantity of ticket are not available in this Branch Office',
                'BranchOffice'   =>  $branchOffice->name,
            ];
            return $status;
        }
        $branchOffice->update();
        $status   = [
            'message' => 'successfully',
            'BranchOffice'   =>  $branchOffice->name,
        ];
        return $status;
    }

    public function response($data, int $statusCode) {
        $response = ["data"=>$data, "statusCode"=>$statusCode];
        return $response;
    }

}
