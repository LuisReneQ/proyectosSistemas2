<?php

namespace RED\Http\Controllers\Restaurante;

use Illuminate\Http\Request;

use RED\Http\Requests;
use RED\Http\Controllers\Controller;
use RED\Restaurante\Platillo;
use RED\Restaurante\Temporada;
use Resources;


class PlatilloController extends Controller
{
    /**
     * Desplegar platillos
     *
     * @return Response
     */
    
    public function mostrar()
    {
        $platillo = Platillo::all();
        return View('platillo.platillo',compact('platillo'));
    }


    /**
     * Desplegar platillos por temporada
     *
     * @return Response
     */
    
    public function mostrarplatillotemporada($id)
    {
        $temporada = Temporada::find($id);
        return View('platillo.platillotemporada',compact('temporada'));
    }
    
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
       $platillo = Platillo::all();
        return View('platillo.platillo',compact('platillo'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  Request  $request
     * @return Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function edit($id)
    {
        //
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
        //
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
    
}
