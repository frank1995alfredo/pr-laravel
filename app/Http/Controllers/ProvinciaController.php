<?php

namespace App\Http\Controllers;

use App\Provincias;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class ProvinciaController extends Controller
{

    //GET listar registros
    public function index(Request $request)
    {
        if ($request->has('txtBuscar')) {
            $provincia = Provincias::where('id','descripcion', 'LIKE', '%' . $request->txtBuscar . '%', 'estado', true)->orderBy('id', 'asc')->get();
            return response()->json(['res' => true, 'data' => $provincia], 200);
        } else {
            $provincia =Provincias::where('estado', true)->orderBy('id', 'asc')->get();
            return response()->json(['res' => true, 'data' => $provincia], 200);
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

    //POST guardar datos
    public function store(Request $request)
    {

        if (!$request->input('descripcion')) {
            return 0;
        }
        $descripcion = $request->input('descripcion');
        $directorio = Provincias::where('descripcion', 'LIKE', '%' . $descripcion . '%')->count();

        if ($directorio != 0) {
            return response()->json([
                'res' => false,
                'message' => 'Ya existe este registro.'
            ], 200);
        }

        $provincia =  Provincias::create($request->all());
        return response()->json(['res' => true, 'data' => $provincia], 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

    //GET id, mostrar un solo registro
    public function show($id)
    {
        $provincia = Provincias::find($id);
        if (!$provincia) {
            return response()->json([
                'res' => false,
                'message' => 'No existe esta provincia.
                '
            ], 204);
        }

        return response()->json(['res' => true, 'data' => $provincia], 200);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
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
        $provincia = Provincias::find($id);

        if (!$provincia) {
            return response()->json([
                'res' => false,
                'message' => 'No existe esta provincia'
            ], 204);
        }

        //almacenamos en variables para facilitar el uso, los campos recibidos
        $descripcion = $request->input('descripcion');
        $estado = $request->input('estado');

        if ($descripcion != null && $descripcion != '' && $estado != null && $estado != '') {

            $provincia->descripcion = $descripcion;
            $provincia->estado = $estado;
            $provincia->save();

            return response()->json([
                'status' => 'ok',
                'data' => $provincia
            ], 200);

        } else if ($descripcion != null && $descripcion != '') {
            $provincia->descripcion = $descripcion;
            $provincia->save();

            return response()->json([
                'status' => 'ok',
                'data' => $provincia
            ], 200);

        } else if ($estado != null && $estado != '') {
            $provincia->estado = $estado;
            $provincia->save();

            return response()->json([
                'status' => 'ok',
                'data' => $provincia
            ], 200);
        } else {
            return 0;
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

    //DELETE id, elimina un registro
    public function destroy($id)
    {
        Provincias::where('id', '=' ,$id)->update(['estado' => false]);
    
        return response()->json([
            'res' => true,
            'message' => 'Registro eliminado correctamente.'
        ], 200);
    }
}
