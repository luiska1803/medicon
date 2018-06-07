@extends('admin.template')
@section('titulo','Usuarios')

@section('titulocontenido')
	<h1>Usuarios <small>Listado</small></h1>
@endsection

@section('contenido')
	<div class="container box box-success">
		<br>
			<a class="btn btn-primary" href="{{ route('usuarios.create') }}">Crear Nuevo Usuario</a>
			<!-- PDF -->
			<a class="btn btn-danger" href="{{ route('pdfusuarios' )}}">Exportar PDF</a>
			<!-- EXCEL -->
			<a class="btn btn-success" href="{{ route('excelusuarios' )}}">Exportar EXCEL</a>

			<hr>	
		@if(\Session::has('mensaje'))
			<div class="alert alert-success alert-dismissible">
			  <button type="button" class="close" data-dismiss="alert">&times;</button>
			   {{\Session::get('mensaje')}}
			</div>
		@endif

		<!-- FORMULARIO DE FILTROS-->
				{!!Form::open(['route'=>'usuarios.index','method'=>'get','class'=>'form-inline text-right'])!!}
					{!! Form::text('name', null,['class'=>'form-control','placeholder'=>'Nombre...']) !!}
					{!! Form::text('email', null,['class'=>'form-control','placeholder'=>'Email...']) !!}
					{!!Form::select('perfil_id',$perfiles,null,['class'=>'form-control','placeholder'=>'Perfil...'])!!}
					{!!Form::select('estado_id',$estados,null,['class'=>'form-control','placeholder'=>'Estado...'])!!}


					<button class="btn btn-primary" type="submit"><i class="fa fa-search"></i></button>

				{!! Form::close() !!}
				<br>		
		<!-- END FORMULARIO-->
		<table class="table table-bordered table-striped">
			<thead>
				<tr>
					<th class="text-center">Nombres</th>
					<th class="text-center">Email</th>
					<th class="text-center">Perfil</th>
					<th class="text-center">Estado</th>
					<th class="text-center">Editar</th>
					<th class="text-center">Borrar</th>
				</tr>
			</thead>
			<tbody>
				@foreach($usuarios as $usuario)
					<tr @if($usuario->estado_id==2) class="danger" @endif>
						<td>{{$usuario->name}}</td>
						<td>{{$usuario->email}}</td>
						<td class="text-center">{{$usuario->perfil->nombre}}</td>
						<td class="text-center">{{$usuario->estado->nombre}}</td>
						<td class="text-center"><a class="btn btn-warning" href="{{ route('usuarios.edit',$usuario->id) }}">Editar</a></td>
						<td class="text-center">
							<form method="post" action="{{ route('usuarios.destroy',$usuario->id) }}">
								@csrf
								<input type="hidden" name="_method" value="DELETE">
								<button class="btn btn-danger" type="submit" onClick="return confirm('¿Desea Inhabilitar el usuario {{$usuario->name}} ?')">Borrar</button>
							</form>
						</td>
					</tr>
				@endforeach
			</tbody>
		</table>
		<hr>
		
		<div class="text-center">
			{{$usuarios->links()}}
		</div>	
		
	</div>
@endsection