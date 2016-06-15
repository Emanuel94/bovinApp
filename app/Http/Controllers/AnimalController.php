<?php

namespace BovinApp\Http\Controllers;
use Illuminate\Http\Request;
use BovinApp\Http\Requests;


use BovinApp\Animal;
use BovinApp\Natural_mating;
use BovinApp\Invitro_fertilization;
use BovinApp\Embryo_transfer;
use BovinApp\Artificial_insemination;
use Auth;
use Session;
use Input;

class AnimalController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $animals= Animal::where('idUser',Auth::id())
                -> paginate(8);
        return view('animal.index',compact('animals'));
       
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
         return view("animal.create");
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
            //Validaciones
        $rules =array(              
                        'name'               => 'required',                       
                        'breed'              => 'required',                      
                        'gender'             => 'required',
                        'birthdate'          => 'required',
                        'feature'            => 'required'  
                      );
        $this->validate($request,$rules);

        $animal = new Animal();
        $animal->idUser = Auth::id();
        $animal->idFarm=Session::get('farm');
        $animal->name=$request->name;
        $animal->slug=str_slug($request->get('name'));
        $animal->breed=$request->breed;
        $animal->gender=$request->gender;
        $animal->feature=$request->feature;
        $animal->birthdate=$request->birthdate; 
        $animal->status=$request->status;


            //Validacion de imagen 
        if (Input::hasFile('image')) 
        {   
            $file = Input::file('image');//Creamos una instancia de la libreria instalada
            $image = \Image::make(\Input::file('image'));//Ruta donde queremos guardar las imagenes

            $path = 'img/animal/';

            // Cambiar de tamaño
            $image -> resize(331, 152);
            $image -> save($path . $file -> getClientOriginalName());   
            $animal->image = $file -> getClientOriginalName();
            //$animal->save(); 
            //return redirect() -> route('animal.index');
         }else
         {
            //Si no hay imagen, se guarda una por defecto
            $image='animal';  
            $default = 'animal.jpg';
            $animal->image = $default;              
            //$animal->save();
         }

         $animal->save();


         if($request->fi=="fi"){

            $invitro_fertilizations= new Invitro_fertilization();
            $invitro_fertilizations->father=$request->father;
            $invitro_fertilizations->donorMother=$request->donorMother;
            $invitro_fertilizations->receivingMother=$request->receivingMother;
            $animal->origin()->save($invitro_fertilizations);
         }

         if($request->ia=='ia'){

            $artificial_inseminations= new Artificial_insemination();
            $artificial_inseminations->father=$request->father;
            $artificial_inseminations->mother=$request->mother;
            $animal->origin()->save($artificial_inseminations);
         }
         if($request->mt=='mt'){

            $natural_matings= new Natural_mating();
            $natural_matings->father=$request->father;
            $natural_matings->mother=$request->mother;
            $animal->origin()->save($natural_matings);
         }
         if($request->te=='te'){

            $embryo_transfers= new Embryo_transfer();
            $embryo_transfers->father=$request->father;
            $embryo_transfers->donorMother=$request->donorMother;
            $embryo_transfers->receivingMother=$request->receivingMother;
            $animal->origin()->save($embryo_transfers);
         }
    return redirect() -> route('animal-index');


    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($slug)
    {
        $animal=Animal::where('slug',$slug)->first();
        return view('animal.show',compact('animal'));
        
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($slug)
    {
        
        $animal=Animal::where('slug',$slug)->first();
        //dd($animal);
        return view('animal.edit', compact('animal'));
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
}