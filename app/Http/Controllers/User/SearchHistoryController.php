<?php

namespace App\Http\Controllers\User;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\UserSearchHistory;
use Yajra\Datatables\Datatables;
use AC;
use Response;
use App\Http\Helpers\Datatable;

class SearchHistoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $keyword = trim($request->get('keyword',''));
        $type = $request->get('type');
        $query = UserSearchHistory::where('id', '!=', NULL)->orderby('created_at', 'DESC');
        $appendlinks = [];

        if (strlen($keyword) > 0) {

             $query->where(\DB::raw('CONCAT_WS(" ",`firstname`,`lastname`,`firstname`,`uuid`,`region`,`postalcode`)') ,'like', '%'.$keyword.'%');
           // $query->where(\DB::raw('CONCAT_WS(" ",`firstname`)') ,'like', '%'.$keyword.'%');
            $appendlinks['keyword'] = $keyword;
        }

        if (strlen($type) > 0) {
            $query->where('contact_type', $type);
            $appendlinks['type'] = $type;
        }

        $usersearch = $query->paginate(50);
        $usersearch->appends($appendlinks); 
        $number = $usersearch->firstItem();
        return view('admin.userhistory.index', compact('usersearch', 'number'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        UserSearchHistory::create([
            'uuid' => $request['uuid'],
            'residential_professional' => $request['residential_professional'],
            'postalcode' => $request['postalcode'],
            'familysize' => $request['familysize'],
            'single' => $request['single'],
            'day' => $request['day'],
            'night' => $request['night'],
            'excl_night' => $request['excl_night'],
            'current_electric_supplier' => $request['current_electric_supplier'],
            'gas_consumption' => $request['gas_consumption'],
            'current_gas_supplier' => $request['current_gas_supplier'],
            'email' => $request['email'],
        ]);

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $userhistory = UserSearchHistory::find($id);
        return view ('admin.userhistory.view', compact('userhistory'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function delete($id)
    {
        UserSearchHistory::where('id', $id)->delete();
        return redirect()->route('usersearch.index');
    }

    public function data()
    {

//         $usersearch = UserSearchHistory::get();
//         // return Datatables::of(UserSearchHistory::query())->make(true);
//         return Datatables::of($usersearch)
//                 ->addColumn('id',function($usersearch) {
//                 return $usersearch->id;
//             })
// //       
//                 ->addColumn('uuid',function($usersearch) {
//                     return $usersearch->uuid;
//             })
//                 ->addColumn('firstname',function($usersearch) {
//                         return $usersearch->firstname;
//                 })
//                 ->addColumn('lastname',function($usersearch) {
//                     return $usersearch->lastname;
//             })
//                 ->addColumn('postalcode',function($usersearch) {
//                     return $usersearch->postalcode;
//             })
//                 ->addColumn('region',function($usersearch) {
//                     return $usersearch->region;
//             })
                
//         ->make(true);


    }
}
