<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Student;
use Auth;
use Hash;
use Carbon\Carbon;
use DB;


class HistoryController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
      $student_id = getUserId();
      $page = $request->input('page', 1);
      $per_page = $this->per_page;

      $data = [];

      $_data = compact('data','page');

      return view('histories.index',$_data)
              ->with('i', ($page - 1) * $per_page);

    }
    

}
