@extends("layouts.application")
@section("content")
@if(Session::has('error'))
	<div class="alert alert-danger">{{Session::get('error')}}</div>
@endif
{{Form::open(array('url'=>'process-reset-password','class'=>'form-horizontal','role'=>'form'))}}
<div class="form-group">

      {{Form::label('email', 'email', array('class' => 'col-lg-3 control-label'))}} 

      <div class="col-lg-4">

        {{Form::text('email', null, array('class' => 'form-control', 'autofocus' => true))}}

        {{$errors->first('email')}}

      </div>

      <div class="clear"></div>

    </div>

    <div class="form-group">

      <div class="col-lg-3"></div>

      <div class="col-lg-4">

        {{Form::submit('Send Reset Instruction', array('class' => 'btn btn-primary'))}}

      </div>

      <div class="clear"></div>

    </div>

  {{Form::close()}}

@stop