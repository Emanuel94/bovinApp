<?php

namespace BovinApp\Http\Controllers\Veterinary;

use Illuminate\Http\Request;

use BovinApp\Http\Requests;
use BovinApp\Http\Controllers\Controller;

use BovinApp\Badamecum;
use Session;

class BadamecumController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $farm= Session::get('farm');
        $badamecums = Badamecum::orderBy('id', 'desc')->paginate(6);       
        return view('veterinary.badamecum.index', compact('badamecums','farm'));
    }


     public function search_badamecum(Request $request)
    {   
        $farm= Session::get('farm');
        $badamecums=\DB::table('badamecums')->where('name', 'ILIKE', '%' . trim($request -> get(trim('name'))) . '%')        
                                            -> paginate(8);
        if(count($badamecums))
        {
            return view('veterinary.badamecum.index', compact('badamecums','farm'));  
       }else
       {
       $message = 'No hay concidencias';
            return redirect() -> route('badamecum-farm')->with('message', $message);
       }
    } 


    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Badamecum $badamecum)
    {
        
        $badamecum= Badamecum::where('slug',$badamecum->slug)->first();
        return view('veterinary.badamecum.show',compact('badamecum'));

    }

   
}
