<html>
	<!-- Display visitor response for excel sheet -->
    <table>
    	<tr>
    		<th>Name</th><th>Response</th>
    	</tr>
    	<tbody>
    		@if(isset($exceldata))
    			@foreach ($exceldata as $xdat)
    				<tr>
    					<td>{{ $xdat['name'] }}</td><td>{{ $xdat['reason'] }}</td>
    				</tr>
    			@endforeach
    		@endif
    	</tbody>
    </table>
</html>
