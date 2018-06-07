<?php

namespace App\Http\Controllers\Usuarios;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Maatwebsite\Excel\Facades\Excel;
use App\Mail\UsuarioCreado;
use App\User;
use App\Perfil;
use App\Estado;


class UsuariosController extends Controller
{
    //FUNCION CONSTRUCTOR PARA VALIDAR USUARIOS
    public function __construct(){
        $this->middleware('auth');
        $this->middleware('admin',['exept'=>'index']);

    }

    public function index(Request $request) //se le agrega el request para la busqueda por formulario.
    {
        //para hacer la busqueda con SQL puro (ejemplo valido solo para buscar por nombre)
        //$usuarios = User::where('name','LIKE','%'.$request->name.'%')->paginate(10);

        //La busqueda por funcion
        $usuarios = User::Nombres($request->name)->Email($request->email)->Perfil($request->perfil_id)->Estado($request->estado_id)->paginate(10);
        $perfiles = Perfil::orderBy('nombre','asc')->pluck('nombre','id');
        $estados = Estado::orderBy('nombre','asc')->pluck('nombre','id');
        return view('admin.usuarios.index',compact('usuarios','perfiles','estados'));
    }

   
    public function create()
    {
        $perfiles = Perfil::orderBy('nombre','asc')->pluck('nombre','id');
        $estados = Estado::orderBy('nombre','asc')->pluck('nombre','id');
        return view('admin.usuarios.crear',compact('perfiles','estados'));
    }

   
    public function store(Request $request)
    {
        //Validar los campos
        $request->validate([
            'name' => 'required|max:255',
            'email' => 'required|unique:users|email',
            'password' => 'required',
            'perfil_id' => 'required',
            'estado_id' => 'required',
            'foto' => 'required|mimes:jpeg,png,jpg|max:3000'
        ]);

        //Subir foto a la carpeta public del proyecto. 
        $foto = $request->file('foto'); //cogiaendo la foto de la variable de entrada
        $ruta = public_path().'/fotos'; //definiendo la ruta donde se va a guardar
        $nombreFoto = uniqid()."-".$foto->getClientOriginalName(); // asignandole un nombre a la foto aleatoriamente
        $foto->move($ruta,$nombreFoto); //mover la foto 

        //Insertar los datos
        $usuario = User::create([
            'name'=>$request->name,
            'email'=>$request->email,
            'password'=>Hash::make($request->password),
            'perfil_id'=>$request->perfil_id,
            'estado_id'=>$request->estado_id,
            'foto'=>$nombreFoto
        ]);

        //enviar Mail
        /*$nombre = $request->name;
        $email = $request->email;
        $pass = $request->password;
        Mail::to($email)->send(new UsuarioCreado($nombre,$email,$pass));
        */
        //mensaje de creacion correctamente
        $mensaje = $usuario?'Usuario creado ok':'No se pudo crear el usuario';
        return redirect()->route('usuarios.index')->with('mensaje',$mensaje);

    }
  
    public function show($id)
    {
        //
    }

    public function edit($id)
    {
        $usuario = User::find($id);
        $perfiles = Perfil::orderBy('nombre','asc')->pluck('nombre','id');
        $estados = Estado::orderBy('nombre','asc')->pluck('nombre','id');
        return view('admin.usuarios.editar',compact('usuario','perfiles','estados'));
    }
   
    public function update(Request $request, $id)
    {
        //Validar los campos
        $request->validate([
            'name' => 'required|max:255',
            'email' => 'required|email',
            'perfil_id' => 'required',
            'estado_id' => 'required'
        ]);

        //Actualizar el usuario
        $usuario = User::find($id);
        $usuario->name = $request->name;
        $usuario->email = $request->email;
        //se pregunta si se quiere cambiar la contraseña - desde admin
        if($request->password)
            $usuario->password = Hash::make($request->password);
        $usuario->perfil_id = $request->perfil_id;
        $usuario->estado_id = $request->estado_id;
        $usuario->save();

        $mensaje = $usuario?'Usuario actualizado ok':'No se pudo actualizar';
        return redirect()->route('usuarios.index')->with('mensaje',$mensaje);
    }
  
    public function destroy($id)
    {
        $usuario = User::find($id);
        $usuario->estado_id = 2;
        $usuario->save();

        $mensaje = $usuario?'Usuario inactivado':'No se pudo inactivar';
        return redirect()->route('usuarios.index')->with('mensaje',$mensaje);
    }

    //funcion para exportar PDF
    public function exportarPDF(){
        $usuarios = User::all();
        $pdf = \App::make('dompdf.wrapper');
        $vista = \view('admin\usuarios.pdf',compact('usuarios'))->render(); //la funcion hace que lo renderice a pdf
        $pdf->loadHTML($vista);
        return $pdf->download('usuarios.pdf');
    }

     //funcion para exportar EXCEL
    public function exportarEXCEL(){
        Excel::create('Usuarios', function($excel){
            $excel->sheet('Usuarios', function($sheet){
                $usuarios = User::all();
                $sheet->fromArray($usuarios);
            });
        })->export('xlsx');
    }

    //funcion para importar usuarios desde EXCEL
    public function importarEXCEL(){
        Excel::load('Usuarios.xlsx', function($reader){
            foreach($reader->get() as $user){
                User::create([
                    'name' =>$user->name,
                    'email'=>$user->email,
                    'password'=>$user->password,
                    'perfil_id'=>$user->perfil_id,
                    'estado_id'=>$user->estado_id
                ]);
            }    
        });
        return redirect()->route('usuarios.index');
    }

}