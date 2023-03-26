@extends('layouts.app')

@section('content')
    <section class="section">
        <div class="section-header">
            <h3 class="page__heading">Ordenes</h3>
        </div>
        <div class="section-body">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-body">
                
            
                        @can('crear-orden')
                        <a class="btn btn-warning" href="{{ route('ordenes.create') }}">Nuevo</a>
                        @endcan
            
                        <table class="table table-striped mt-2">
                                <thead style="background-color:#6777ef">                                     
                                    <th style="display: none;">ID</th>
                                    <th style="color:#fff;">status</th>
                                    <th style="color:#fff;">direccion</th>                                    
                                    <th style="color:#fff;">notas</th>
                                    <th style="color:#fff;">photo</th>   
                                    <th style="color:#fff;">customer_number</th>
                                    <th style="color:#fff;">created_at</th>                                                                      
                                                                      
                              </thead>
                              <tbody>
                            @foreach ($ordenes as $order)
                            <tr>
                                <td style="display: none;">{{ $order->id }}</td>                                
                                <td>{{ $order->status }}</td>
                                <td>{{ $order->direccion }}</td>
                                <td>{{ $order->notas }}</td>
                                <td>{{ $order->photo }}</td>
                                <td>{{ $order->customer_number }}</td>
                                <td>{{ $order->created_at }}</td>

                                <td>
                                    <form action="{{ route('ordenes.destroy',$order->id) }}" method="POST">                                        
                                        @can('editar-orden')
                                        <a class="btn btn-info" href="{{ route('ordenes.edit',$order->id) }}">Editar</a>
                                        @endcan

                                        @csrf
                                        @method('DELETE')
                                        @can('borrar-orden')
                                        <button type="submit" class="btn btn-danger">Borrar</button>
                                        @endcan
                                    </form>
                                </td>
                            </tr>
                            @endforeach
                            </tbody>
                        </table>

                        <!-- Ubicamos la paginacion a la derecha -->
                        <div class="pagination justify-content-end">
                            {!! $ordenes->links() !!}
                        </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection