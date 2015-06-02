/***********************************************************
 *   file : DemoController.php                             *
************************************************************/
<?php
use Khill\Lavacharts\Lavacharts;

class DemoController extends BaseController {

	// Loasa main index page and sends sports name to be display on page
	public function getIndex() {
		$lists = poll_sport::lists('name'); // get names from sport record

		// create select option to be display in select box element

		$sport = "<option value='' selected disabled>Please select a sport</option>";

		foreach ($lists as $list) {
			$sport .= "<option value = '" . $list . "'>" . $list . "</option>";
		}


		return View::make('demo.index')->with('sport', $sport);
	}

	// get team names based on selected sport
	public function postTeam() {
		$val = Input::get('sport'); // get sport name chosen from input

		// get id of team from sport record based on sport value
		$input = poll_sport::where('name', '=', $val)->first(); 
	
		// get names of team record based on sport value
		$teams = poll_team::where('sport_id', '=', $input['id'])->lists('name');

		// create select box option to disply team names

		$list = "<option value='' selected disabled>Please select a team</option>";

		foreach ($teams as $team) {
			$list .= "<option value = '" . $team . "'>" . $team . "</option>";
		}

		return $list;
	}

	// Get Poll form submit
	public function postPoll() {
		
		// get all input values from form
		$input = Input::all();

		// set form rules 
		$rules =  array(
			'name' => 'required',
			'email' => 'required|email|unique:visitor',
			'sport' => 'required|not_in:""',
			'team' => 'required|not_in:""',
			'reason' => 'required',
		);
       
		// check validation on input
        $validate = Validator::make($input, $rules);
        
		// if validation fails return back to poll form and show errors
		// else continue save information to database
        if ($validate->fails()) {
			return Redirect::to('demo')->withErrors($validate);
		} else {
			// assign input values to array
			$visitor = array(
				'name' => $input['name'],
	            'email' => $input['email'],
	            'reason' => $input['reason'],
	            'team' => $input['team'],
	            'sport' => $input['sport'],
	        );
		
			// create a new record in table
			poll_visitor::create($visitor);

			// get sport and team record to add votes

			$voteSport = poll_sport::where('name', '=', $input['sport'])->first();
			$voteTeam = poll_team::where('name', '=', $input['team'])->first();

			$voteSport->vote++;
			$voteTeam->vote++;

			// save sport and team votes to database
			$voteSport->save();
			$voteTeam->save();

     		/* Here will contain the mail send method but due to isp restriction cannot use 
			   method to send email to visitor
               
			   Mail::send('view', $input, function($message) use ($input) {
       		   	$message->to($input['email'], $input['name'])->subject('Sport Poll System');
		       });
			*/

			// display view of email
			return View::make('demo.showmail')->with('visitor', $visitor);
	    }		
	}

	// Get sport result information
	public function Result() {
		// get sports records
		$sports = poll_sport::all();

		// get only sport names
		$lists = poll_sport::lists('name');

		// get total votes in sports DB
		$total_votes = DB::table('sport')->sum('vote');
		
// create select box for the name of sports
		$listsport = "<option value='' selected disabled>Select a sport to view responses</option>";

		foreach ($lists as $list) {
			$listsport .= "<option value = '" . $list . "'>" . $list . "</option>";
		}

		// send sport information and select list to result view
		return View::make('demo.result')->with('sports', $sports)->with('listsport', $listsport)
										->with('total_votes', $total_votes);
	}

	// get results based on sport name selected and return the visitor response
	public function getResponse() {
		// get sport name selected
		$val = Input::get('ressport');

		// get visitors based on sport name
		$visitors = poll_visitor::where('sport', '=', $val)->get();

		//get sport values based on sport name
		$sports = poll_sport::where('name', '=', $val)->first();

		// get total votes in sports DB
		$total_votes = DB::table('sport')->sum('vote');

		// calculate vote percentage
		$votepercentage = round(count($visitors) / $total_votes  * 100);

		// create view to show response of each visitor
		// show sport name and votes and percentage of the sport selected
		$display = "<p class='alert alert-success'>";
		$display .= "<strong> " . $sports['name'] . " Total Votes </strong> <span class='badge'> " . count($visitors) . " </span> ";
		$display .= "<strong> Percentage </strong> <span class='badge'> " . $votepercentage . "% </span></p> ";

		// create view of each visitor that chose the same sport and display there response
		foreach ($visitors as $visitor) {
			$display .= "<div class='panel panel-info'>"; 
			$display .= " <div class='panel-heading'>"; 
			$display .= "  <span class='glyphicon glyphicon-user'></span>"; 
			$display .= "  <strong>" . $visitor['name'] . " </strong> "; 
			$display .= " </div>"; 
			$display .= " <div class='panel-body'>"; 
			$display .= "  <p>" . $visitor['reason'] . "</p>"; 
			$display .= " </div>"; 
			$display .= " <div class='panel-footer'><strong> Team </strong> " . $visitor['team'] . "</div>";
			$display .= "</div>";
		}

		// send the information back to view
		return $display;
	}

	// display the contents for a email in a view
	public function ShowMail() {
		// get session data of visitor from function in controller 
		$visitor = Input::old('visitor');

		// if session visitor have data to display send it to the view or redirect to the previous view
		if (isset($visitor))
			return View::make('demo.showmail')->with('visitor', $visitor);
		else
			return Redirect::to('demo');
	}

	// This display the admin
	public function DemoAdmin() {
		// get sports and team information
		$sports = poll_sport::all();
		$teams = poll_team::all();

		// Pie Chart showing Sports
		$sportvote = Lava::DataTable();

		// create column for the pie chart
		$sportvote->addStringColumn('Sports')
        		  ->addNumberColumn('Percent');

		// add row with sport name and votes
        foreach ($sports as $sport) {
        	$sportvote->addRow(array($sport['name'], $sport['vote']));
        }
        		
		// create the pie chart with properties to view in 3D with title
        $piechart = Lava::PieChart('Sports')
                 ->setOptions(array(
                   'datatable' => $sportvote,
                   'title' => 'Most sports voted',
                   'is3D' => true
                  ));

		// Column Chart showing Team
		$teamvote = Lava::DataTable();

		// create column for the Column chart
		$teamvote->addStringColumn('Teams')
        		  ->addNumberColumn('Percent');
		
		// add row with team name and votes
        foreach ($teams as $team) {
        	$teamvote->addRow(array($team['name'], $team['vote']));
        }
        
		// create the Column chart with style
        $columnchart = Lava::ColumnChart('Teams')
                 ->setOptions(array(
                   'datatable' => $teamvote,
                   'title' => 'Most teams voted',
                   'titleTextStyle' => Lava::TextStyle(array(
                        'color' => '#00000',
                        'fontSize' => 14
                      ))
                  ));

		// open view for the admin
		return View::make('demo.demoadmin');
	}

	// get and export data to excel/csv file
	public function PostExport() {
		// get user choices
		$input = Input::all();

		//assign input values ti variables
		$filtertype = $input['exportfilter'];
		$filetype = $input['filetype'];

		// set rules for validation to see if customer selected all fields
		$rules =  array(
			'filetype' => 'required|not_in:""',
			'exportfilter' => 'required|not_in:""'
		);
       
		// create rules
        $validate = Validator::make($input, $rules);
        
		// if validation fails return to initial view and display errors or else continue with export file
        if ($validate->fails()) {
			return Redirect::to('demoadmin')->withErrors($validate);
		} else {
			// check on the option the user selected and get data based on choice made
			if($filtertype == "visitdetails") {
		        $sheetname = 'visitdetails';           // assign sheet and filename to a variable
		        $viewname = 'demo.visitdetails';       // assign the view name to a variable
		        $exceldata = poll_visitor::all();      // get specific data from database on user choice
			} elseif($filtertype == "visitresponse") {
		        $sheetname = 'visitresponse';
		        $viewname = 'demo.visitresponse';
		        $exceldata = poll_visitor::all();				        
			} elseif($filtertype == "sportvote") {
		        $sheetname = 'sportvote';
		        $viewname = 'demo.sportvote';
		        $exceldata = poll_sport::all();				        
			} elseif($filtertype == "teamvote") {
		        $sheetname = 'teamvote';
		        $viewname = 'demo.teamvote';
		        $exceldata = poll_team::all();				        			
			}

			// create the excel file and passes sheet name and view name to excel file
			Excel::create($sheetname, function($excel) use ($exceldata, $sheetname, $viewname) {

				// set properties of sheet
			    $excel->setTitle('Sport Polling System');
			    $excel->setCreator('Mohamed Moosa')->setCompany('Mohamed Moosa');
			    $excel->setDescription('Sport Polling System');

				// create sheet
				$excel->sheet($sheetname, function($sheet) use ($exceldata, $viewname)  {
					// send view to sheet
					$sheet->loadView($viewname, array('exceldata' => $exceldata));
    			});

			})->export($filetype);	// create excel file base on file type (xlsx/csv)
		}
	}
}


