<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Repositories\BranchOffice\BranchOfficeRepository;
use App\Http\Requests\BranchOfficeRequest;
use App\Models\BranchOffice;

class BranchOfficeController extends Controller
{
    //
    public function __construct(BranchOfficeRepository $branchOfficeRepository){
        $this->branchOfficeRepository = $branchOfficeRepository;
    }

    public function store(BranchOfficeRequest $request){
        $response = $this->branchOfficeRepository->store($request);
        return response()->json($response["data"], $response["statusCode"]);
    }

    public function index(){
        $response = $this->branchOfficeRepository->index();
        return response()->json($response["data"], $response["statusCode"]);
    }

    public function available(BranchOffice $branchOffice ){
        $response = $this->branchOfficeRepository->available( $branchOffice );
        return response()->json($response["data"], $response["statusCode"]);
    }

    public function delete(BranchOffice $branchOffice ){
        $response = $this->branchOfficeRepository->delete( $branchOffice );
        return response()->json($response["data"], $response["statusCode"]);
    }
}
