<?php

namespace RED\Http\Controllers\Restaurante;

use Illuminate\Http\Request;

use RED\Http\Requests;
use RED\Http\Controllers\Controller;
use RED\Restaurante\Compra;
use RED\Restaurante\DetalleCompra;
use RED\Repositories\ProveedorRepo;
use RED\Despensa\Proveedore;
use RED\Restaurante\MateriaPrima;
use Resources;

class ComprasController extends Controller
{
	protected $proveedorrepo;
    public $opcionproveedor;

    public function __construct(ProveedorRepo $proveedorrepo)
    {
    	$this->proveedorrepo=$proveedorrepo;
    }
	
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $compras = Compra::orderBy('fecha','DESC')->paginate(10);
        return view('compra.index', compact('compras'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        //mostrar fecha actual
        $fecha = date('Y-m-d');
        //Cargar nombre de proveedores
        $opcionproveedor = Proveedore::all()->lists('nombre', 'id');
	   $materiaprima=Materiaprima::all();
        return view("compra.create", compact('opcionproveedor','materiaprima','fecha'));        
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  Request  $request
     * @return Response
     */
    public function store(Request $request)
    {
	 
        Compra::create($request->all());
	      Compra::create([
            'fecha' => $request['fecha'],
            'subtotal' => $request['subTotal'],
            'descuento' => $request['descuento'],
		 'proveedores_id' => $request['proveedores_id'],
		  'total' => $request['total'],
        ]);
	     
	   
	     $compra = Compra::all()->last();
	//  dd($compra);
	       if($request['check'] != null) {		  
            foreach ($request['check'] as $datos) {		  
			   DetalleCompra::create([          
            'compras_id' => $compra->id,
            'cantidad' => $request['cantidad'][$datos],
		 'costo' => $request['costo'][$datos],
		  'materia_prima_id' => $request['dato'][$datos],
        ]);
	   $subtotaldetalle= $request['cantidad'][$datos]*$request['costo'][$datos];
	   $subtotal=$compra->subtotal;
	   $compra->subtotal=$subtotal+$subtotaldetalle;
	  
	  $total=$compra->total;
	  $compra->total=$total+$subtotaldetalle;
	
	   $compra->save();
		   
               // $estudiante->cursos()->attach($idcurso[$dato]);
            }}
		  
	
		  
		  
        //Redirigir la compra al detalle de compra
	   return redirect('/compra/'.$compra->id);
      //  return redirect('/detallecompra/create');
        //return view("detallecompra.create");   
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function show($id)
    {
        $detalle = Compra::find($id);
        return view('detallecompra.detallecompra',compact('detalle'));
       //return redirect('detallescompra/'.$id);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function edit($id)
    {
        //$opcionproveedor = Proveedore::find($id)->lists('id');
        $compra = Compra::find($id);
        return view('compra.edit', ['compra'=>$compra]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  Request  $request
     * @param  int  $id
     * @return Response
     */
    public function update(Request $request, $id)
    {
        $compra = Compra::find($id);
        $compra->fill($request->all());
        $compra->save();
        return redirect('/compra')->with('message','edit');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($id)
    {
        //
    }
    
    public function proveedor($id)
    {
        //Buscamo al proveedor con ese id
	   $proveedore=$this->proveedorrepo->find($id);
	    return View('compra.comprasaproveedor',compact('proveedore'));
	   //dd($proveedore);
    }
}
