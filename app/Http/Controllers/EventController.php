<?php

namespace BovinApp\Http\Controllers;

use Illuminate\Http\Request;

use BovinApp\Http\Requests;

use BovinApp\Event;
use Auth;

use DateTime;

class EventController extends Controller
{
       /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = [
            'page_title' => 'Eventos',
            'events'     => Event::orderBy('start_time')
                                  ->where('idUser',Auth::id())
                                  ->get(),
        ];

        
        return view('event/list', $data);
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        
        $data = [
            'page_title' => 'Agregar Nuevo evento',
        ];
        
        return view('event/create', $data);
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    { 


        $rules= array(

            'name'  => 'required|max:15',
            'title' => 'required|max:100',
            'time'  => 'required'


            );
        $this->validate($request,$rules);  

       /* $this->validate($request, [
            'name'  => 'required|min:5|max:15',
            'title' => 'required|min:5|max:100',
            'time'  => 'required|available|duration'
        ]);*/
        
        $time = explode(" - ", $request->input('time'));
        //dd($this->change_date_format($time[0]));
       
        
        $event                  = new Event;
        $event->idUser =        Auth::id();
        //$event->allDay =    $request->has('visible') ? 1 : 0,
        $event->name            = $request->input('name');
        $event->title           = $request->input('name');
        $event->properties      = $request->input('title');
        $event->start_time      = $this->change_date_format($time[0]);
        $event->end_time        = $this->change_date_format($time[1]);
        $event->save();

        $message ='Evento Creado Correctamente!' ; 
        
        
        return redirect('events')->with('message', $message);
    }
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id, Request $request)
    {
        
        $event = Event::findOrFail($id);
        

        
        $first_date = new DateTime($event->start_time);
        $second_date = new DateTime($event->end_time);
        $difference = $first_date->diff($second_date);
        $data = [
            'page_title'    => $event->title,
            'event'         => $event,
            'duration'      => $this->format_interval($difference)
            
        ];
        
        return view('event/view', $data);
    }
    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $event = Event::findOrFail($id);
        $event->start_time =  $this->change_date_format_fullcalendar($event->start_time);
        $event->end_time =  $this->change_date_format_fullcalendar($event->end_time);       
       
      
        return view('event/edit',compact('event'));
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
        $this->validate($request, [
            'name'  => 'required|max:15',
            'title' => 'required|max:100',
            'time'  => 'required'
        ]);


        
        $time = explode(" - ", $request->input('time'));
        
        $event                  = Event::findOrFail($id);
        $event->name            = $request->input('name');
        $event->title           = $request->input('title');
        $event->start_time      = $this->change_date_format($time[0]);
        $event->end_time        = $this->change_date_format($time[1]);
        $event->save();

        $message ='Evento Actualizado Correctamente!' ; 
        return redirect('events')->with('message', $message);
        

    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $event = Event::find($id);
        $event->delete();

        $message ='Evento Eliminado!' ; 
        return redirect('events')->with('message', $message);
        
    }
    
    public function change_date_format($date)
    {
        $time = DateTime::createFromFormat('d/m/Y', $date);
        return $time->format('Y-m-d ');
    }
    
    public function change_date_format_fullcalendar($date)
    {
        $time = DateTime::createFromFormat('Y-m-d', $date);
        return $time->format('d/m/Y');
    }
    
    public function format_interval(\DateInterval $interval)
    {
        $result = "";
        if ($interval->y) { $result .= $interval->format("%y year(s) "); }
        if ($interval->m) { $result .= $interval->format("%m month(s) "); }
        if ($interval->d) { $result .= $interval->format("%d day(s) "); }
        if ($interval->h) { $result .= $interval->format("%h hour(s) "); }
        if ($interval->i) { $result .= $interval->format("%i minute(s) "); }
        if ($interval->s) { $result .= $interval->format("%s second(s) "); }
        
        return $result;
    }

  
}
