<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Estudiante;
use Illuminate\Support\Facades\Validator;

class estudianteController extends Controller
{
    public function readAll()
    {
        $estudiantes = Estudiante::all();

        // if( $estudiantes->isEmpty() ){ //cuando esta vacio
        //     $data = [
        //         'message' => 'no hay estudiantes registrados',
        //         'status' => 200
        //     ];
        //     return response()->json( $data, 404);
        // }

        $datos = [
            'estudiantes' => $estudiantes,
            'status' => 200 // solicitud HTTP ha sido exitosa
        ];

        return response()->json($datos, 200);
        // return response($estudiantes);
    }

    public function insert(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nombre' => 'required|string',
            'email' => 'required|email|unique:estudiante',
            'telefono' => 'required|digits:10',
            'habilidad' => 'required|string|in:sql,php,java,html'  //pa patron de entrada
        ]);

        //valida datos
        if ($validator->fails()) {
            $data = [
                'messaje' => 'error en la validación de datos',
                'errors' => $validator->errors(),
                'status' => 400 //pa datos incorrectos , datos mal formados, sintaxis incorrecta, o una solicitud que no cumple con los requisitos del servido
            ];
            return response()->json($data, 400);
        }

        $estudiante = Estudiante::create([
            'nombre' => $request->nombre,
            'email' => $request->email,
            'telefono' => $request->telefono,
            'habilidad' => $request->habilidad
        ]);

        //fi fallo al crear el estudiante model
        if (!$estudiante) {
            $data = [
                'messaje' => 'error al crear el estudiante',
                'status' => 500 //error en el server , servidor encontró una condición inesperada que le impidió completar la solicitud del cliente
            ];
            return response()->json($data, 500);
        }

        $data = [
            'estudiante' => $estudiante,
            'status' => 201 //creación de un nuevo recurso exitosa
        ];
        return response()->json($data, 201);
    }

    public function readOne($id)
    {
        $estudiante = Estudiante::find($id);

        //si no encontro
        if (!$estudiante) {
            $data = [
                'messaje' => 'estudiante no econtrado',
                'status' => 404
            ];
            return response()->json($data, 404);
        }

        //si encontro
        $datos = [
            'estudiante' => $estudiante,
            'status' => 200
        ];

        return response()->json($datos, 200);
    }

    public function delete($id)
    {
        $estudiante = Estudiante::find($id);

        //si no encontro
        if (!$estudiante) {
            $data = [
                'messaje' => 'estudiante no econtrado',
                'status' => 404
            ];
            return response()->json($data, 404);
        }

        //si encontro
        $estudiante->delete();

        $data = [
            'messaje' => 'estudiante eliminado',
            'status' => 200
        ];
        return response()->json($data, 200);
    }

    public function update(Request $request, $id)
    {
        $estudiante = Estudiante::find($id);
        //si no encontro
        if (!$estudiante) {
            $data = [
                'messaje' => 'estudiante no econtrado',
                'status' => 404
            ];
            return response()->json($data, 404);
        }

        //si encontro

        //valida datos
        $validator = Validator::make($request->all(), [
            'nombre' => 'required|string',
            'email' => 'required|email|unique:estudiante',
            'telefono' => 'required|digits:10',
            'habilidad' => 'required|string|in:sql,php,java,html'  //pa patron de entrada
        ]);

        if ($validator->fails()) {
            $data = [
                'messaje' => 'error en la validación de datos',
                'errors' => $validator->errors(),
                'status' => 400 //pa datos incorrectos , datos mal formados, sintaxis incorrecta, o una solicitud que no cumple con los requisitos del servido
            ];
            return response()->json($data, 400);
        }

        //actualiza datos
        $estudiante->nombre = $request->nombre;
        $estudiante->email = $request->email;
        $estudiante->telefono = $request->telefono;
        $estudiante->habilidad = $request->habilidad;

        $estudiante->save();

        $data = [
            'messaje' => 'estudiante actualizado',
            'estudiante' => $estudiante,
            'status' => 200
        ];
        return response()->json($data, 200);
    }

    public function updatePartial(Request $request, $id)
    {
        $estudiante = Estudiante::find($id);

        //si no encontro
        if (!$estudiante) {
            $data = [
                'messaje' => 'estudiante no econtrado',
                'status' => 404
            ];
            return response()->json($data, 404);
        }

        //si encontro

        //valida datos
        $validator = Validator::make($request->all(), [
            'nombre' => 'string',
            'email' => 'email|unique:estudiante',
            'telefono' => 'digits:10',
            'habilidad' => 'string|in:sql,php,java,html'  //pa patron de entrada
        ]);

        if ($validator->fails()) {
            $data = [
                'messaje' => 'error en la validación de datos',
                'errors' => $validator->errors(),
                'status' => 400
            ];
            return response()->json($data, 400);
        }

        //actualiza datos solo pa lo necesario
        if ($request->has('nombre'))
            $estudiante->nombre = $request->nombre;

        if ($request->has('email'))
            $estudiante->email = $request->email;

        if ($request->has('telefono'))
            $estudiante->telefono = $request->telefono;

        if ($request->has('habilidad'))
            $estudiante->habilidad = $request->habilidad;

        $estudiante->save();

        $data = [
            'messaje' => 'estudiante actualizado',
            'estudiante' => $estudiante,
            'status' => 200
        ];
        return response()->json($data, 200);
    }
}
