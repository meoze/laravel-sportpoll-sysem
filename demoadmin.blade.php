@extends('layout')

@section('content')

	<div class="panel panel-default">
		<div class="panel-heading text-center"><strong>Administration</strong></div>
		<div class="panel-body">
			<!-- show filters and file type to export form -->
			{{ Form::open(array('url' => 'postexport')) }}
				<!-- display error -->
  				@if($errors->any())
					<div class="alert alert-danger">
						<a href="#" class="close" data-dismiss="alert">&times;</a>
						{{ implode('', $errors->all('<li class="error">:message</li>'))}}
					</div>
				@endif
			<!-- display filter select box -->
			<div class="col-sm-4">
				<select name="exportfilter" class="form-control">
					<option value="" selected disabled>Select a filter</option>
					<option value="visitdetails">Visitors details</option>
					<option value="visitresponse">Visitors responses</option>
					<option value="sportvote">Sports votes</option>
					<option value="teamvote">Team votes</option>
				</select>
			</div>
			<!-- display file type select box -->
			<div class="col-sm-2">
				<select name="filetype" class="form-control">
					<option value="" selected disabled>Select file type</option>
					<option value="xlsx">EXCEL</option>
					<option value="csv">CSV</option>
				</select>
			</div>
			<!-- download button -->
			<button type="submit" class="btn btn-primary">Download</button>
			{{ Form::close() }}
		</div>	
	</div>

	<!-- Summary with charts and graphs -->

	<div class="panel panel-default">
		<div class="panel-heading text-center"><strong>Summary</strong></div>
		<div class="panel-body">
			<!-- display pie chart -->
			<div id="chart-div"></div>
			@piechart('Sports', 'chart-div')
			<hr>
			<!-- display column chart -->
			<div id="column-div"></div>
			@columnchart('Teams', 'column-div')

		</div>	
	</div>

@stop

