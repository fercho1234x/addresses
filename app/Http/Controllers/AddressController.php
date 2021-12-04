<?php

namespace App\Http\Controllers;

use App\Http\Requests\ListOfAddressesRequest;
use App\Models\Address;

class AddressController extends ApiController
{
    public function __construct()
    {
        parent::__construct();
    }

    public function index(ListOfAddressesRequest $request)
    {
        return $this->showAll(Address::with('state')
                        ->addresses($request->getLimit(), $request->getPage())
                        ->code($request->getCode())
                        ->municipality($request->getMunicipality())
                        ->city($request->getCity())
                        ->get());
    }
}
