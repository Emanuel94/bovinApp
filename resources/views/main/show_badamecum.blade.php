@extends('layouts.main')
@section('content')
<div class="container text-center"><hr>

      <div class="container">
        {!!Form::open(['route'=>'search_badamecum','method'=>'GET'])!!}
            <div class="row">                 
                <div class="col-md-12">
                    <div class="input-group" id="adv-search">                    
                        <input type="text" name="name" class="form-control" placeholder="Buscar Productos Veterinarios" />           
                             <div class="input-group-btn">                       
                                <button type="submit" class="btn btn-primary"><span class="glyphicon glyphicon-search" aria-hidden="true"></span></button>                          
                            </div>
                    </div>            
                </div>                     
            </div>
         {!! Form::close() !!}
        </div><hr>
        
    <div class="page">
         @if(count($badamecums))
        <div class="row">
            @foreach($badamecums as $badamecum)
            <div class="col-sm-6 col-md-4">
                <div class="thumbnail">                                      
                    <img src="/img/badamecum/{{$badamecum->image}}" alt="{{$badamecum->name}}">    
                    <div class="caption">                                        
                       <h3 >{{$badamecum->name}}</h3>
                    </div>
                    <p>
                        <a class="btn btn-primary" href="{{route('detail-badamecum',$badamecum->slug)}}"><i class="fa fa-chevron-circle-right"></i>Leer mas</a>
                    </p>
                </div>
            </div>
            @endforeach                           
        </div>
            <?php echo $badamecums->render(); ?>
        @else
            <h3><span class="label label-warning">Noy hay Ningún producto registrado</span></h3>
            @endif
            <hr>           
            <p>
                <a class="btn btn-primary" href="{{route('home')}}"> <i class="glyphicon glyphicon-home"> </i> Home</a>
            </p>                  
    </div>
</div>
<hr>
@stop