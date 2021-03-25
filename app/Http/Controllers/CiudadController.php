<?php

namespace App\Http\Controllers;

use App\Ciudades;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class CiudadController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->has('txtBuscar')) {

            $ciudad = DB::table('ciudades')->join('provincias', 'provincias.id', '=', 'ciudades.provincia_id')
                ->select('ciudades.id', 'ciudades.provincia_id', 'provincias.descripcion as provincia', 'ciudades.descripcion as ciudad', 'ciudades.estado as estado')
                ->where('ciudades.descripcion', 'LIKE', '%' . $request->txtBuscar . '%', 'ciudades.estado', true)->orderBy('id', 'asc')
                ->get();

            return response()->json([
                'res' => true, 'data' => $ciudad
            ], 200);

        } else {

            $ciudad = DB::table('ciudades')->join('provincias', 'provincias.id', '=', 'ciudades.provincia_id')
                ->select('ciudades.id', 'ciudades.provincia_id', 'provincias.descripcion as provincia', 'ciudades.descripcion as ciudad', 'ciudades.estado as estado')
                ->where('ciudades.estado', true)->orderBy('id', 'asc')
                ->get();

            return response()->json(
                ['res' => true, 'data' => $ciudad],
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
        //
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

        if (!$request->input('provincia_id')) {
            return 0;
        }

        $descripcion = $request->input('descripcion');
        $directorio = Ciudades::where('descripcion', 'LIKE', '%' . $descripcion . '%')->count();

        if ($directorio != 0) {
            return response()->json([ 
                'res' => false,
                'message' => 'Ya existe este registro.'
            ], 200);
        }

        Ciudades::create($request->all());

        $ciudad = DB::table('ciudades')->join('provincias', 'provincias.id', '=', 'ciudades.provincia_id')
        ->select('ciudades.id', 'ciudades.provincia_id', 'provincias.descripcion as provincia', 'ciudades.descripcion as ciudad', 
        'ciudades.estado as estado')
        ->where('ciudades.estado', true)->orderBy('id', 'desc')
        ->limit(1)
        ->get();

        return response()->json([
            'res' => true,
            'data' => $ciudad,
        ], 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $ciudad = Ciudades::find($id);
        if (!$ciudad) {
            return response()->json([
                'res' => false,
                'message' => 'No existe esta ciudad.
                '
            ], 204);
        }

        return response()->json(['res' => true, 'data' => $ciudad], 200);
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
        $ciudad = Ciudades::find($id);
        //almacenamos en variables para facilitar el uso, los campos recibidos
        $provincia_id = $request->input('provincia_id');
        $descripcion = $request->input('descripcion');
        $estado = $request->input('estado');

        if (!$ciudad) {
            return response()->json([
                'res' => false,
                'data' => 'No existe esta ciudad.'
            ], 204);
        }

        if (
            $descripcion != null && $descripcion != ''  && $provincia_id != null && $provincia_id != ''
        ) {

            $ciudad->provincia_id = $provincia_id;
            $ciudad->descripcion = $descripcion;
            $ciudad->save();

            $ciudad = DB::table('ciudades')->join('provincias', 'provincias.id', '=', 'ciudades.provincia_id')
            ->select('ciudades.id', 'ciudades.provincia_id', 'provincias.descripcion as provincia', 'ciudades.descripcion as ciudad', 'ciudades.estado as estado')
            ->where('ciudades.id','=', $id)
            ->get();

            return response()->json([
                'res' => true,
                'data' => $ciudad
            ], 200);

        } else if (
            $descripcion != null && $descripcion != '' && $estado != null &&
            $estado != ''
        ) {
            $ciudad->estado = $estado;
            $ciudad->descripcion = $descripcion;
            $ciudad->save();

            return response()->json([
                'res' => true,
                'data' => 'Datos actualizados correctamente'
            ], 200);

        } else if ($descripcion != null && $descripcion != '') {
            $ciudad->descripcion = $descripcion;
            $ciudad->save();

            return response()->json([
                'res' => true,
                'data' => 'Datos actualizados correctamente'
            ], 200);

        } else if ($estado != null && $estado != '') {
            $ciudad->estado = $estado;
            $ciudad->save();

            return response()->json([
                'res' => true,
                'data' => 'Datos actualizados correctamente'
            ], 200);

        } else if ($provincia_id != null && $provincia_id != '') {
            $ciudad->provincia_id = $provincia_id;
            $ciudad->save();

            return response()->json([
                'res' => true,
                'message' => 'Datos actualizados correctamente'
            ], 200);

        } else {
            
            return response()->json([
                'res' => false,
                'message' => 'Debe ingresar una descripcion y seleccionar una provincia.'
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
        Ciudades::where('id', '=', $id)->update(['estado' => false]);

        return response()->json([
            'res' => true,
            'message' => 'Registro eliminado correctamente.'
        ], 200);
    }
}
