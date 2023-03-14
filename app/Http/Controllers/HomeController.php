<?php

namespace App\Http\Controllers;
use App\Http\Controllers\AppBaseController;
use App\Repositories\Base\HomeRepository;

class HomeController extends AppBaseController
{
    protected $repository;
    /**
     * Create a new controller instance.
     */
    public function __construct()
    {
        $this->middleware('auth');
        $this->repository = HomeRepository::class;
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {                
        return view('home', ['notifications' => $this->getNotifications()]);
    }

    private function getNotifications(){
        return $this->getRepositoryObj()->getNotifications();
    }    
}
