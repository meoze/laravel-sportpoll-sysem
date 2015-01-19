@extends('layout')

@section('content')
	<div class="panel panel-default">
		<div class="panel-heading text-center"><label>Sports Poll System</label></div>
  			<div class="panel-body">
				<!-- display form poll form -->
  				{{ Form::open(array('url' => 'postpolls', 'class' => 'col-md-offset-4 col-md-4')) }}
  				@if($errors->any())
					<!-- display errors -->
					<div class="alert alert-danger">
						<a href="#" class="close" data-dismiss="alert">&times;</a>
						{{ implode('', $errors->all('<li class="error">:message</li>'))}}
					</div>
				@endif
				<!-- display name field -->
	       		<div class="form-group">
					{{ Form::label('name', 'Name') }}
					{{ Form::text('name', '', array('class' => 'form-control', 'placeholder' => 'Enter your Name...', 'autofocus'=>'autofocus')) }}
	       		</div>
				<!-- display email field -->
	       		<div class="form-group">
					{{ Form::label('email', 'Email Address') }}
					{{ Form::text('email', '', array('class' => 'form-control', 'placeholder' => 'Enter your Email Address...')) }}
	       		</div>
				<!-- display sport field -->
	       		<div class="form-group">
					{{ Form::label('sport', 'Sport') }}
					@if(isset($sport))
						<select class="form-control" name="sport" id="sport">{{ $sport }}</select>
		        	@endif
					
	       		</div>	  
				<!-- display team field -->
	       		<div class="form-group">
					{{ Form::label('team', 'Team') }}
					<select class="form-control" name="team" id="team"></select>
	       		</div>		       		
				<!-- display reason field -->   		
	       		<div class="form-group">
					{{ Form::label('reason', 'Reason') }}
					{{ Form::textarea('reason', '', array('class' => 'form-control', 'size' => '30x5', 'placeholder' => 'Enter your Reason...')) }}
	       		</div>
				<!-- form submit button -->
				{{ Form::submit('Submit', array('class' => 'btn btn-primary')) }}
				{{ Form::close() }}
			</div>
		</div>
	</div>
@stop

