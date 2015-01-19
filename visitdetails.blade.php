<html>
	<!-- Display Visitor details for excel sheet -->
    <table>
    	<tr>
    		<th>Team</th><th>Email</th><th>Favourite Sport</th><th>Favourite Team</th><th>Response</th>
    	</tr>
    	<tbody>
    		@if(isset($exceldata))
    			@foreach ($exceldata as $xdat)
    				<tr>
    					<td>{{ $xdat['name'] }}</td><td>{{ $xdat['email'] }}</td><td>{{ $xdat['sport'] }}</td>
                        <td>{{ $xdat['team'] }}</td><td>{{ $xdat['reason'] }}</td>
    				</tr>
    			@endforeach
    		@endif
    	</tbody>
    </table>
</html>
