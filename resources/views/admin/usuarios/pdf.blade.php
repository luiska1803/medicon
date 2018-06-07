<!DOCTYPE html>
<html>
<head>
	<title>Listado de Usuarios</title>
</head>
<body>
	<img src="http://osmaro.com/medicon/logo-doctores.png">
	<h1>Listado de Usuarios</h1>
		<table width="100%" border="1">
			<tr>
				<th>Nombres: </th>
				<th>Email: </th>
				<th>Perfil: </th>
				<th>Estado: </th>
			</tr>
			@foreach($usuarios as $usuario)
				<tr @if($usuario->estado_id==2) class="danger" @endif>
					<td>{{$usuario->name}}</td>
					<td>{{$usuario->email}}</td>
					<td class="text-center">{{$usuario->perfil->nombre}}</td>
					<td class="text-center">{{$usuario->estado->nombre}}</td>
				</tr>
			@endforeach
		</table>

</body>
</html>