
{{Form::open(array('url'=>'users','class'=>'form-horizontal','role'=>'form'))}}

<div class="form-group">
	{{Form::label('email','Email',array('class'=>'col-lg-3 control-label'))}}
	<div class="col-lg-4">
		{{Form::text('email',null,array('class'=>'form-control'))}}
		{{$errors->first('email')}}
	</div>
	<div class="clear"></div>
</div>

<div class="form-group">
	{{Form::label('username','Username',array('class'=>'col-lg-3 control-label'))}}
	<div class="col-lg-4">
		{{Form::text('username', null,array('class'=>'form-control'))}}
		{{$errors->first('username')}}
	</div>
	<div class="clear"></div>
</div>

<div class="form-group">
	{{Form::label('password','Password', array('class'=>'col-lg-3 control-label'))}}
	<div class="col-lg-4">
		{{Form::password('password', array('class'=>'form-control'))}}
		{{$errors->first('password')}}
	</div>
	<div class="clear"></div>
</div>

<div class="form-group">
	{{Form::label('password_confirmation', 'Password Confirm', array('class'=>'col-lg-3 control-label'))}}
	<div class="col-lg-4">
		{{Form::password('password_confirmation', array('class'=>'form-control'))}}
	</div>
	<div class="clear"></div>
</div>

<div class="form-group">
	<div class="col-lg-3"></div>
	<div class="col-lg-4">
	{{Form::submit('Signup', array('class'=>'btn btn-primary'))}}
</div>
<div class="clear"></div>
</div>
{{Form::close()}}
