@extends('layout')

@section('content')
	<div class="panel panel-default">
		<div class="panel-heading text-center"><strong>Mail</strong></div>
		<div class="panel-body">
			<!-- information of this view -->
			<p>The ISP hosting the server for this website does not allow sending to any email address.</p>		
			<p>Below is the format of the email that will be shown when sent to the visitor that completed the form.</p>
			<p><a class='btn btn-info' href="result">Click to go to results </a></p>
			<hr>
		@if(isset($visitor))
			<!-- display visitor information to be displayed in email -->
			<p>Hi {{ $visitor['name'] }}</p>
			<p>Thank you for completing the sport poll system</p>
			<table border='1'>
				<tr>
					<th style='width:150px; padding:10px;'>Name </th><td style='width:200px; padding:10px;'>{{ $visitor['name'] }}</td>
				</tr>
				<tr>
					<th style='width:150px; padding:10px;'>Email </th><td style='width:200px; padding:10px;'>{{ $visitor['email'] }}</td>
				</tr>
				<tr>
					<th style='width:150px; padding:10px;'>Sport </th><td style='width:200px; padding:10px;'>{{ $visitor['sport'] }}</td>
				</tr>
				<tr>
					<th style='width:150px; padding:10px;'>Team </th><td style='width:200px; padding:10px;'>{{ $visitor['team'] }}</td>
				</tr>
				<tr>
					<th style='width:150px; padding:10px;'>Reason</th><td style='width:200px; padding:10px;'>{{ $visitor['reason'] }}</td>
				</tr>
			</table>
			<p>Kind regards</p>
			<p>System Administrator</p>
			<hr>
		@endif
		</div>
	</div>
@stop

