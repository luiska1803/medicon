<?php

namespace App\Http\Controllers\Usuarios;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use App\Producto;
use App\Proveedor;


class ProductosController extends Controller
{
    public function index()
    {
        $productos = producto::paginate(10);
        return view('admin.contabilidad.index',compact('productos'));
    }

   
    public function create()
    {
        $proveedores = proveedor::orderBy('nombre','asc')->pluck('nombre','id');
        return view('admin.contabilidad.crear',compact('proveedores'));
    }

   
    public function store(Request $request)
    {
        //Validar los campos
        $request->validate([
            'nombre' => 'required',
            'precio' => 'required',
            'proveedor_id' => 'required'
        ]);

        //Insertar los datos
        $producto = producto::create([
            'nombre'=>$request->nombre,
            'precio'=>$request->precio,
            'proveedor_id'=>$request->proveedor_id,
        ]);

        $mensaje = $producto?'Producto creado ok':'No se pudo crear el Producto';
        return redirect()->route('contabilidad.index')->with('mensaje',$mensaje);

    }

    
    public function show($id)
    {
        //
    }

    
    public function edit($id)
    {
        $producto = producto::find($id);
        $proveedores = proveedor::orderBy('nombre','asc')->pluck('nombre','id');
        return view('admin.contabilidad.editar',compact('producto','proveedores'));
    }

    
    public function update(Request $request, $id)
    {
        //Validar los campos
        $request->validate([
            'nombre' => 'required',
            'precio' => 'required',
            'proveedor_id' => 'required'
        ]);

        //Actualizar el usuario
        $producto = producto::find($id);
        $producto->nombre = $request->nombre;
        $producto->precio = $request->precio;
        $producto->proveedor_id = $request->proveedor_id;
        $producto->save();

        $mensaje = $producto?'Usuario actualizado ok':'No se pudo actualizar';
        return redirect()->route('contabilidad.index')->with('mensaje',$mensaje);
    }

    
    public function destroy($id)
    {
        $producto = producto::find($id);
        $usuario = User::where('id',$producto->user_id)->first();
        $usuario->estado_id = 2;
        $usuario->save();

        $mensaje = $usuario?'producto inactivado':'No se pudo inactivar';
        return redirect()->route('contabilidad.index')->with('mensaje',$mensaje);
    }
}
