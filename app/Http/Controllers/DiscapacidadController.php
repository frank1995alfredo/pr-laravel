<?php

namespace App\Http\Controllers;

use App\Discapacidades;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class DiscapacidadController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->has('txtBuscar')) {
            $discapacidad = Discapacidades::select('descripcion')
                ->where( 'id','descripcion', 'LIKE', '%' . $request->txtBuscar . '%', 'estado', true)->orderBy('id', 'asc')
                ->get();
            return response()->json([
                'res' => true, 'data' => $discapacidad
            ], 200);
        } else {
            $discapacidad = Discapacidades::select('id' ,'descripcion', 'estado')
                ->where('estado', true)
                ->orderBy('id', 'asc')
                ->get();
            return response()->json(
                ['res' => true, 'data' =>  $discapacidad],
                200
            );
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if (!$request->input('descripcion')) {
            return 0;
        }

        $descripcion = $request->input('descripcion');
        $directorio = Discapacidades::where('descripcion', 'LIKE', '%' . $descripcion . '%')->count();

        if ($directorio != 0) {
            return response()->json([
                'res' => false,
                'message' => 'Ya existe este registro.'
            ], 200);
        }

        $discapacidad =  Discapacidades::create($request->all());
        return response()->json(
            ['res' => true, 'data' =>  $discapacidad],
            200
        );
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        
        $discapacidad = Discapacidades::find($id);
        if (!$discapacidad) {
            return response()->json([
                'res' => false,
                'data' => 'No existe esta discapacidad.
                '
            ], 204);
        }

        return response()->json(['res' => true, 'data' => $discapacidad], 200);
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
        $discapacidad = Discapacidades::find($id);

        if (!$discapacidad) {
            return response()->json([
                'res' => false,
                'data' => 'No existe esta discapacidad'
            ], 204);
        }

        //almacenamos en variables para facilitar el uso, los campos recibidos
        $descripcion = $request->input('descripcion');
        $estado = $request->input('estado');

        if ($descripcion != null && $descripcion != '' && $estado != null && $estado != '') {

            $discapacidad->descripcion = $descripcion;
            $discapacidad->estado = $estado;
            $discapacidad->save();

            return response()->json([
                'status' => 'ok',
                'data' => $discapacidad
            ], 200);
        } else if ($descripcion != null && $descripcion != '') {
            $discapacidad->descripcion = $descripcion;
            $discapacidad->save();

            return response()->json([
                'status' => 'ok',
                'data' => $discapacidad
            ], 200);
        } else if ($estado != null && $estado != '') {
            $discapacidad->estado = $estado;
            $discapacidad->save();

            return response()->json([
                'status' => 'ok',
                'data' => $discapacidad
            ], 200);
        } else {
            return response()->json([
                'res' => false,
                'data' => 'Debe ingresar una descripcion.'
            ], 204);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Discapacidades::where('id', '=', $id)->update(['estado' => false]);
        
        return response()->json([
            'res' => true,
            'data' => 'Registro eliminado satisfactoriamente.'
        ], 200);
    }
}
