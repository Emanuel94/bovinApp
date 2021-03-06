@extends('layouts.admin')

@section('content')

<div class="content-section-a">
    <div class="container" text-center>
        <div class="page-header">
            <h1>
                <i class="fa fa-shopping-cart"></i>
                PRODUCTOS 
                <a href="{{ route('admin.product.create') }}" class="btn btn-warning">
                    <i class="fa fa-plus-circle"></i> Producto
                </a>
            </h1>
        </div>
        <div class="page">
        @if(count($products))
            
            <div class="table-responsive">
                <table class="table table-striped table-bordered table-hover">
                    <thead>
                        <tr>
                            <th>Editar</th>
                            <th>Eliminar</th>
                            <th>Imagen</th>
                            <th>Nombre</th>                                                       
                            <th>Precio</th>
                            <th>Visible</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($products as $product)
                            <tr>
                                <td>
                                    <a href="{{ route('admin.product.edit', $product->slug) }}" class="btn btn-primary">
                                        <i class="fa fa-pencil-square-o"></i>
                                    </a>
                                </td>
                                <td>
                                    {!! Form::open(['route' => ['admin.product.destroy', $product->slug]]) !!}
                                        <input type="hidden" name="_method" value="DELETE">
                                        <button onClick="return confirm('Eliminar registro?')" class="btn btn-danger">
                                            <i class="fa fa-trash-o"></i>
                                        </button>
                                    {!! Form::close() !!}
                                </td>
                                <td>  <img class="img-index" src="/img/product/{{$product->image}}" ></td>
                                <td>{{ $product->name }}</td>                           
                                <td>${{ number_format($product->price,2) }}</td>
                                <td>{{$product->visible == 1 ? "Si" : "No" }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            
            <hr>
            
            <?php echo $products->render(); ?>

             @else
             <h3><span class="label label-warning">Noy hay productos</span></h3>
            @endif
            
        </div>
        <div align="center">
         <a class="btn btn-primary" href="{{url('admin')}}"><i class="fa fa-chevron-circle-left"></i>REGRESAR</a>      
        </div>
         

    </div>
</div>


@stop