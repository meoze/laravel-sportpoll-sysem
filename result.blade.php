@extends('layout')

@section('content')
	<div class="panel panel-default">
		<div class="panel-heading text-center"><strong>Polling Results</strong></div>
		<div class="panel-body">
			<!-- Display sport votes -->
			<table class="table">
				<tr>
					<th>Sport</th><th>Total Votes</th><th>Percentage</th>
				</tr>
				<tbody>
				@if (isset($sports))
					@foreach ($sports as $sport)
						<tr>
							<td>{{ $sport['name'] }}</td><td>{{ $sport['vote'] }}</td><td>{{ round($sport['vote'] / $total_votes * 100) }}%</td>
						</tr>
					@endforeach
				@endif
				</tbody>
			</table>
		</div>
	</div>
	<!-- Sport select box and display vistor response based on sport selected -->
	<div class="panel panel-default">
		<div class="panel-heading text-center"><strong>Responses</strong></div>
		<div class="panel-body">
			@if(isset($listsport))
				<select class="form-control" name="responseSport" id="responseSport">{{ $listsport }}</select><br>
		    @endif
		    <div id="responselog"></div>
		</div>
	</div>
@stop

		
