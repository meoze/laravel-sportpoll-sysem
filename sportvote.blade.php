<html>
	<!-- Display sport votes for excel sheet -->
    <table>
    	<tr>
    		<th>Sport</th><th>Votes</th>
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
