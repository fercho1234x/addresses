<?php

namespace App\Http\Controllers;

use App\Http\Requests\ListOfStatesRequest;
use App\Models\State;

class StateController extends ApiController
{
    public function __construct()
    {
        parent::__construct();
    }

    public function index(ListOfStatesRequest $request)
    {
        return $this->showAll(State::states($request->getLimit(), $request->getPage())->get());
    }

    public function getLimit(): int
    {
        return $this->get('limit', 30);
    }

    public function getPage(): int
    {
        return $this->get('page', 1);
    }
}
