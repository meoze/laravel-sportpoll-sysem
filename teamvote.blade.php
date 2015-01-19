<html>
	<!-- Display team votes for excel sheet -->
    <table>
    	<tr>
    		<th>Team</th><th>Votes</th>
    	</tr>
    	<tbody>
    		@if(isset($exceldata))
    			@foreach ($exceldata as $xdat)
    				<tr>
    					<td>{{ $xdat['name'] }}</td><td>{{ $xdat['vote'] }}</td>
    				</tr>
    			@endforeach
    		@endif
    	</tbody>
    </table>
</html>
