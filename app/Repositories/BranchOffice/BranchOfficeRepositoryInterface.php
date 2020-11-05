<?php

namespace App\Repositories\BranchOffice;

use Illuminate\Http\Request;
use App\Models\BranchOffice;

interface BranchOfficeRepositoryInterface {
    public function index ();
    public function store(Request $request);
    public function response($data, int $statusCode);
    public function delete(BranchOffice $branchOffice);
    public function available(BranchOffice $branchOffice);
    public function soldticket( BranchOffice $branchOffice, $quantity );
}
