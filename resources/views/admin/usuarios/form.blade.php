<div class="form-group">
	<label>Nombres</label>
	{!!Form::text('name',null,[
		'class'=>'form-control',
		'placeholder'=>'Sus nombres...',
		'required'=>'required'
	])!!}
</div>
<div class="form-group">
	<label>Email</label>
	{!!Form::email('email',null,[
		'class'=>'form-control',
		'placeholder'=>'Su email...',
		'required'=>'required'
	])!!}
</div>

<div class="form-group">
	<label>Password</label>
	{!!Form::password('password',[
		'class'=>'form-control',
		'placeholder'=>'Su contraseña...'
	])!!}
</div>
<div class="form-group">
	<label>Perfil</label>
	{!!Form::select('perfil_id',$perfiles,null,[
		'class'=>'form-control',
		'placeholder'=>'Escoger perfil...'
	])!!}
</div>

<div class="form-group">
	<label>Estado</label>
	{!!Form::select('estado_id',$estados,null,[
		'class'=>'form-control',
		'placeholder'=>'Escoger estado...'
	])!!}
</div>
<!-- Input para archivos -->
<div class="form-group">
	<label>Foto de perfil (jpg, jpeg, png) (3MB) </label>
	<input type="file" name="foto">
</div>


<!-- Botones de guardar y cancelar-->
<div class="form-group text-center">
	<button type="submit" class="btn btn-success">Guardar Usuario</button>
	<a class="btn btn-danger" href="{{ route('usuarios.index') }}">Cancelar</a>
</div>
