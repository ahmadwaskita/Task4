@extends("layouts.application")

@section("content")

	<div>{{link_to('articles/create', 'Write Article', array('class' => 'btn btn-success'))}}</div>

	@if(Session::has('notice'))
		<div class="alert alert-info">{{Session::get('notice')}}</div>
	@endif
	
	@if($errors->has())
		<div class="alert alert-danger">
			@foreach($errors->all() as $error)
				{{$error}}<br>
			@endforeach
		</div>
	@endif

	{{Form::open(array('route'=>array('articles.import'), 'method'=>'POST', 'files'=>'true'))}}
    <p></p>
    {{Form::label('text','Select a file to import')}}
    {{Form::file('import',array('class'=>'btn btn-info'))}}
    <p></p>
    {{Form::submit('Import')}}
    {{Form::close()}}

    <div id="list-article">
		@include('articles.list')
	</div>

	<div class="pagination"> {{$articles->links()}} </div>
@stop
