<?php
//add in the db connection details using require_once
	require_once 'db.php';
	//create a new connection to the db
    $conn = new mysqli(DB_SERVER, DB_USER, DB_PASSWORD, DB_DATABASE);
    //create SQL query to run
    $sql = "SELECT * FROM incident_type"; 
    //create var result to contain the result-set from SQL query
    $result = $conn->query ($sql);
    //create array var incidentTypes
    $incidentTypes = [];
    //use while loop to extract each row of the result-set to var row
    while ($row = $result->fetch_assoc()) {
    	//assign the column value for incident_type_id to var id
        $id = $row['incident_type_id'];
        //assign the column value for incident_type_id to var type
        $type =  $row['incident_type_desc'];
        //create array var incidentType to hold the column values of each row
        $incidentType=["id" => $id, "type" => $type];
        //using the array_push function to assign all rows of the result set into array var incidentTypes
        array_push($incidentTypes, $incidentType);
    }
    $conn->close(); 
?>

<!doctype html>
	<html>
	<head>
		<meta charset="utf-8">
		<title>Log Call</title>
		<link href="css/bootstrap.css" rel="stylesheet" type="text/css">

		<form name="logcallform"action="dispatch.php"method="post" onsubmit="return validateForm()">

			<script type="text/javascript">
				function validateForm()
				{
					//callerName
					var a=document.forms["logcallform"]["callerName"].value;
					if(!isNaN(a))
					{
						alert("Caller Name must contain alphabet characters only.");
						return false;
					}

					//contactNo
					var b = document.forms["logcallform"]["contactNo"].value;
					if (b==null || b=="")
					{
						alert("Contact number must be 8 digits with no spaces and symbols.")
						return false;
					} else if (b.length != 8 || isNaN(b)){

						alert("Contact number must be 8 digits with no spaces and symbols.");
						return false;
					}

					//location of incident
					var c = document.forms["logcallform"]["locationofIncident"].value;
					if (c==null || c=="")
					{
						alert("Location of Incident is required.");
						return false;
					}

					//type of incident
					var d = document.forms["logcallform"]["typeofIncident"].value;
					if (!d)
					{
						alert("Please select Type of Incident.");
						return false;
					}

					//description of incident
					var f = document.forms["logcallform"]["descriptionofIncident"].value;
					if (f==null || f=="")
					{
						alert("Description of Incident is required");
						return false;
					}
					
				}
			</script>

	</head>
	<body>

		<div class="container" style="width: 80%">
			<!-- Use php require_once expression to include header image and navigation bar from nav.php -->
			<?php require_once 'nav.php' ?>

			<!-- Create section container to place web form -->
			<section style="margin-top:20px">
				<!-- Create web form with Caller Name, Contact number, Location of Incident, Type of Incident, Description of Incident input fields-->
				<form action="dispatch.php" method="post">

					<!-- Row for Caller Name label and textbox input-->
					<div class="form-group row">
						<label for="callerName" class="col-sm-4 col-form-label">Caller's Name</label>
						<div class="col-sm-8">
							<input type="text" class="form-control" id="callerName" name="callerName">
						</div>
					</div>

					<!-- Row for Contact No label and textbox input-->
					<div class="form-group row">
						<label for="contactNo" class="col-sm-4 col-form-label">Contact Number (Required)</label> 
						<div class="col-sm-8">
							<input type="text" class="form-control" id="contactNo" name="contactNo">
						</div>
					</div>

					<!-- Row for Location of Incident label and textbox input-->
					<div class="form-group row">
						<label for="locationofIncident" class="col-sm-4 col-form-label">Location of Incident (Required)</label>
						<div class="col-sm-8">
							<input type="text" class="form-control" id="locationofIncident" name="locationofIncident">
						</div>
					</div>

					<!-- Row for Type of Incident label and drop down input-->
					<div class="form-group row">
						<label for="typeofIncident" class="col-sm-4 col-form-label">Type of Incident (Required)</label>
						<div class="col-sm-8">
							<select id="typeofIncident" class="form-control" name="typeofIncident">
								<option value="">Select</option>
								<?php
								/*Using for loop to retrieve the data from array var incidentTypes*/
								for ($i=0;$i<count($incidentTypes);$i++){
									$incidentType=$incidentTypes[$i]; 
									echo "<option value='". $incidentType['id']."'>" . $incidentType['type']."</option>";
								}
								?>
							</select>
						</div>
					</div>

					<!-- Row for Description of Incident label and large textbox input-->
					<div class="form-group row">
						<label for="descriptionofIncident" class="col-sm-4 col-form-label">Description of Incident (Required)</label>
						<div class="col-sm-8">
							<textarea class="form-control" rows="5" id="descriptionofIncident" name="descriptionofIncident"></textarea>
						</div>
		            </div>
		            <div class="form-group row">
		            	<div class="col-sm-4"></div>
		            	<div class="col-sm-8" style="text-align:center">
		            		<input class="btn btn-primary" name="btnProcessCall" type="submit" value="Process Call">
		            		<input class="btn btn-primary" name="btnReset" type="reset" value="Reset">
		            	</div>
		            </div>




		            <!-- End of web form -->
		        </form>
		        <!-- End of section -->
		    </section>
		    <!---footer--->
		    <footer class="page-footer font-small blue pt-4 footer-copyright text-center py-3">&copy; 2021 Copyright</footer>
		</div>
		<script type="text/javascript" src="js/jquery-3.5.0.min.js"></script>
		<script type="text/javascript" src="js/bootstrap.js"></script>
		<script type="text/javascript" src="js/popper.min.js"></script>
	</body>
</html>
