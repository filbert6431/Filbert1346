<?php

namespace App\Http\Controllers;
use App\Models\User; //Ini jangan lupa
use Illuminate\Http\Request;


class UserController extends Controller
{
      /**
     * Display a listing of the resource.
     */
    public function index()
    {
  	$data['dataUser'] = User::all();
		return view('User.index',$data);

    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
       	return view('user.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
                //dd($request->all());
	    $data['name'] = $request->name;
        		$data['email'] = $request->email;
		$data['password'] = $request->password;

		user::create($data);

		return redirect()->route('user.index')->with('success','Penambahan Data Berhasil!');

    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
      }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {

       }


}
