<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;


use App\Models\Order;

class OrdenController extends Controller
{
    function __construct()
    {
        //$this->middleware('permission:ver-orden|crear-orden|editar-orden|borrar-orden', ['only' =>['index']]);
        $this->middleware('permission:crear-orden', ['only' =>['create','store']]);
        $this->middleware('permission:editar-orden', ['only' =>['edit','update']]);
        $this->middleware('permission:borrar-orden', ['only' =>['destroy']]);


    }

    public function archive()
    {
        $ordenes = Order::onlyTrashed()->get();
        return view('ordenes.archive', compact('ordenes'));
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $ordenes = Order::paginate(5);
        return view('ordenes.index',compact('ordenes'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('ordenes.crear');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'status' => 'required',
            'direccion' => 'required',
            'notas' => 'required',
            'photo' => 'required',
        ]);
    
        $customerNumber = Str::random(10);
        while (Order::where('customer_number', $customerNumber)->exists()) {
            $customerNumber = Str::random(10);
        }
    
        $validatedData = $request->all();
        $validatedData['customer_number'] = $customerNumber;
    
        Order::create($validatedData);
    
        return redirect()->route('ordenes.index');
        
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Order $order)
    {
        return view('ordenes.editar',compact('order'));
        //Aqui ordenes podria ser orden, en el video venia blog en singular

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Order $order)
    {
        request()->validate([
            'status' => 'required',
            'direccion' => 'required',
            'notas' => 'required',
            'photo' => 'required',
            //Customer number no porque eso es automatico
        ]);

        $order->update($request->all());
    
        return redirect()->route('ordenes.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Order $order)
    {
        if($order->trashed()){
            $order->forceDelete();
            return redirect()->to('/ordenes');
        }
        $order->delete();
    
        return redirect()->route('ordenes.index');
    }

    public function restore(Order $order)
    {
        $order->restore();
        return redirect()->to('/ordenes');
    }
}
