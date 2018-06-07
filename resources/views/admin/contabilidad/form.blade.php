<div class="form-group">
	<label>Nombre: </label>
	{!!Form::text('telefono',null,[
		'class'=>'form-control',
		'placeholder'=>'Nombre...',
		'required'=>'required'
	])!!}
</div>

<div class="form-group">
	<label>Precio</label>
	{!!Form::text('telefono',null,[
		'class'=>'form-control',
		'placeholder'=>'Telefono...',
		'required'=>'required'
	])!!}
</div>

<div class="form-group">
	<label>Proveedor</label>
	{!!Form::select('proveedor_id',$proveedores,null,[
		'class'=>'form-control',
		'placeholder'=>'Escoger Proveedor...'
	])!!}
</div>

<!-- Botones de guardar y cancelar-->
<div class="form-group text-center">
	<button type="submit" class="btn btn-success">Guardar Producto</button>
	<a class="btn btn-danger" href="{{ route('medicos.index') }}">Cancelar</a>
</div>