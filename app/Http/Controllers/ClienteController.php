<?php

namespace App\Http\Controllers;

use App\Clientes;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class ClienteController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->has('txtBuscar')) {
            $cliente = Clientes::select('priNombre', 'segApellido', 'numCedula', 'codigoCli as codigo', 'email', 'estado')
                ->where('numCedula', 'LIKE', '%' . $request->txtBuscar . '%', 'estado', true)->orderBy('id', 'asc')
                ->get();

            return response()->json([
                'res' => true, 'data' => $cliente
            ]);
        } else {
            $cliente = DB::table('clientes')->join('ciudades', 'ciudades.id', '=', 'clientes.ciudad_id')
                ->join('discapacidades', 'discapacidades.id', '=', 'clientes.discapacidad_id')
                ->select('clientes.id','clientes.discapacidad_id', 'clientes.ciudad_id','clientes.priNombre', 'clientes.priApellido', 
                'clientes.numCedula', 'clientes.codigoCli as codigo', 'clientes.email', 'clientes.estado', 'ciudades.descripcion as ciudad',
                'clientes.nivelDiscapacidad')
                ->where('clientes.estado', true)->orderBy('id', 'asc')
                ->get();

            return response()->json([
                'res' => true, 'data' => $cliente
            ]);
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

        if (!$request->input('discapacidad_id')) {
            return response()->json([ 
                'res' => false,
                'message' => 'Seleccione una discapacidad.'
            ], 200);
        }

        if (!$request->input('ciudad_id')) {
            return response()->json([ 
                'res' => false,
                'message' => 'Selccione una ciudad.'
            ], 200);
        }

        if (!$request->input('priNombre')) {
            return response()->json([ 
                'res' => false,
                'message' => 'Ingrese el primer nombre.'
            ], 200);
        }

        if (!$request->input('segNombre')) {
            return response()->json([ 
                'res' => false,
                'message' => 'Ingrese el segundo nombre.'
            ], 200);
        }

        if (!$request->input('priApellido')) {
            return response()->json([ 
                'res' => false,
                'message' => 'Ingrese el primer apellido.'
            ], 200);
        }

        if (!$request->input('segApellido')) {
            return response()->json([ 
                'res' => false,
                'message' => 'Ingrese el segundo apellido.'
            ], 200);
        }

        if (!$request->input('numCedula')) {
            return response()->json([ 
                'res' => false,
                'message' => 'Ingrese el  numero de cedula.'
            ], 200);
        }

        if (!$request->input('codigoCli')) {
            return 0;
        }

        if (!$request->input('genero')) {
            return response()->json([ 
                'res' => false,
                'message' => 'Seleccione el genero.'
            ], 200);
        }

        if (!$request->input('nivelDiscapacidad')) {
            return response()->json([ 
                'res' => false,
                'message' => 'Ingrese el nivel de discapacidad.'
            ], 200);
        }

        $cedula = $request->input('numCedula');
        $numcedula = Clientes::where('numCedula', 'LIKE', '%' . $cedula . '%')->count();

        if ($numcedula != 0) {
            return response()->json([ 
                'res' => false,
                'message' => 'Ya existe este registro.'
            ], 200);
        }

        Clientes::create($request->all());
        return response()->json([
            'res' => true,
            'message' => 'Datos ingresados correctamente.'
        ], 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $cliente = Clientes::find($id);

        if (!$cliente) {
            return response()->json([
                'res' => false,
                'message' => 'No existe este cliente.'
            ], 204);
        }

        return response()->json([
            'res' => true,
            'data' => $cliente
        ], 200);
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
        $cliente = Clientes::find($id);
        $discapacidad_id = $request->input('discapacidad_id');
        $ciudad_id = $request->input('ciudad_id');
        $priNombre = $request->input('priNombre');
        $segNombre = $request->input('segNombre');
        $priApellido = $request->input('priApellido');
        $segApellido = $request->input('segApellido');
        $numCedula = $request->input('numCedula');
        $codigoCli = $request->input('codigoCli');
        $direccion = $request->input('direccion');
        $email = $request->input('email');
        $telefono = $request->input('telefono');
        $genero = $request->input('genero');
        $estado = $request->input('estado');
        $nivelDiscapacidad = $request->input('nivelDiscapacidad');

        if (!$discapacidad_id) {
            return 0;
        }

        if (!$ciudad_id) {
            return 0;
        }

        if (!$priNombre) {
            return 0;
        }

        if (!$segNombre) {
            return 0;
        }

        if (!$priApellido) {
            return 0;
        }

        if (!$segApellido) {
            return 0;
        }

        if (!$numCedula) {
            return 0;
        }

        if (!$codigoCli) {
            return 0;
        }

        if (!$genero) {
            return 0;
        }

        if (!$nivelDiscapacidad) {
            return 0;
        }

        $cliente->discapacidad_id = $discapacidad_id;
        $cliente->ciudad_id = $ciudad_id;
        $cliente->priNombre = $priNombre;
        $cliente->segNombre = $segNombre;
        $cliente->priApellido = $priApellido;
        $cliente->segApellido = $segApellido;
        $cliente->numCedula = $numCedula;
        $cliente->codigoCli = $codigoCli;
        $cliente->direccion = $direccion;
        $cliente->email = $email;
        $cliente->telefono = $telefono;
        $cliente->genero = $genero;
        $cliente->nivelDiscapacidad = $nivelDiscapacidad;
        $cliente->save();
        return response()->json([
            'res' => true,
            'message' => 'Datos actualizados correctamente.'
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Clientes::where('id', '=', $id)->update(['estado' => false]);

        return response()->json([
            'res' => true,
            'message' => 'Registro eliminado correctamente.'
        ], 200);
    }
}
