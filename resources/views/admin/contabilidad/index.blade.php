@extends('admin.template')
@section('titulo','productos')

@section('titulocontenido')
	<h1>Productos <small>Listado</small></h1>
@endsection

@section('contenido')
	<div class="container box box-success">
		<br>
			<a class="btn btn-primary" href="{{ route('productos.create') }}">Crear Nuevo</a>
			<hr>	
		@if(\Session::has('mensaje'))
			<div class="alert alert-success alert-dismissible">
			  <button type="button" class="close" data-dismiss="alert">&times;</button>
			   {{\Session::get('mensaje')}}
			</div>
		@endif
		<table class="table table-bordered table-striped">
			<thead>
				<tr>
					<th class="text-center">Nombres</th>
					<th class="text-center">precio</th>
					<th class="text-center">Proveedor</th>
					<th class="text-center">Editar</th>
					<th class="text-center">Borrar</th>
				</tr>
			</thead>
			<tbody>
				@foreach($productos as $producto)
					<tr>
						<td>{{$producto->nombre}}</td>
						<td>{{$producto->precio}}</td>
						<td>{{$producto->proveedor_id}}</td>
						<td class="text-center"><a class="btn btn-warning" href="{{ route('productos.edit',$producto->id) }}">Editar</a></td>
						<td class="text-center">
							<form method="post" action="{{ route('productos.destroy',$producto->id) }}">
								@csrf
								<input type="hidden" name="_method" value="DELETE">
								<button class="btn btn-danger" type="submit" onClick="return confirm('¿Desea Inhabilitar el Producto?')">Borrar</button>
							</form>
						</td>
					</tr>
				@endforeach
			</tbody>
		</table>
		<hr>
		
		<div class="text-center">
			{{$productos->links()}}
		</div>	
		
	</div>
@endsection