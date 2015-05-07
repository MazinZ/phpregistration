<!-- Mazin Zakaria, PHP project -->

<!doctype html>
<html>
<head>
<meta charset="UTF-8">
<title>Course Registration</title>


<!-- Javascript function used to limit number of classes user can select-->
<script>
var total = 0
function limitCheckNum(box){ 
	if(box.checked){ 
		total+=1 
	}
	else{ 
		total-=1 
	} 
	if (total > 3){ 
		box.checked=false 
		total-=1 
		alert('You can only register for 3 courses.') 
	} 
} 


</script>

</head>

<body>
<?php
/* ////////////

	Connecting

   ////////////
 */
	$username = "root";
	$password = "";
	$dbname = "courseregister";
	$servername = "localhost";
	
	$conn = new mysqli($servername, $username, $password, $dbname)
		or die("unable to connect");

	if ($conn->connect_error) {
	    die("Connection failed: " . $conn->connect_error);
	} 

	mysql_select_db('courseregister');




////// Define globals used for error checking. I ran into issues with this because
////// I've normally done input validation with JQuery.
$firstnameErr = $lastnameErr = $emailErr = $streetErr = $cityErr = $stateErr = $zipErr = "";

// Returns true if any erros have been found (any errors are now not = ""), returns false otherwise
function errorsFound(){
	global $firstnameErr, $lastnameErr, $emailErr, $streetErr, $cityErr, $stateErr, $zipErr;
	if ($firstnameErr === "" && $lastnameErr === "" && $emailErr === "" && $streetErr === "" && $cityErr === ""
	&& $stateErr === "" && $zipErr === "") {
		return false;	
	}
	return true;
}

if(isset($_POST['submit'])) {
	$firstname = $middlename = $lastname = $email = $street = $city = $zip = $homephone = $cellphone = "";
	
	
	// This is where the input validation is done
	
	// FIRSTNAME
	if (empty($_POST["firstname"])) {
	    $firstnameErr = "First Name is required";
	}
	else {
		$firstname = $_POST['firstname'];
	}

	$middlename = $_POST['middlename'];
	
	// LASTNAME
	if (empty($_POST["lastname"])){
		$lastnameErr = "Last Name is required";
	}
	else {
		$lastname = $_POST['lastname'];
	}
	
	// EMAIL
	if (empty($_POST["email"]) || !filter_var($_POST["email"], FILTER_VALIDATE_EMAIL)){
		$emailErr = "Email is required and must be in the form (*****@*****.***)";	
	}
	else {
		$email = $_POST['email'];
	}
	
	// STREET
	if (empty($_POST["street"])){
		$streetErr = "Street is required";	

	}
	else {
		$street = $_POST['street'];
	}
	
	// CITY
	if (empty($_POST["city"])){
		$cityErr = "City is required";	

	}
	else {
		$city = $_POST['city'];
	}
	
	// STATE
	if (empty($_POST["state"])){
		$stateErr = "State is required";	

	}
	else {
		$state = $_POST['state'];
	}
	
	// ZIP - needs more validation
	
	if (empty($_POST["zip"])){
		$zipErr = "Zip is required";	
	}
	else {
		$zip = $_POST['zip'];
	}
	
	// CELL AND HOME PHONES - need more validation
	
	$homephone = $_POST['homephone']; 
	$cellphone = $_POST['cellphone']; 
	
	///// Query the database for the given email
	$getUserId = mysqli_query($conn, "SELECT * FROM `Students` WHERE `EmailAddress` = '".$email."'");
    $emailCheck = mysqli_fetch_array($getUserId);

	// Checks if user with given email already registered.
    if($emailCheck)
    {
        echo "This email address was already found in the system.";
    }
	else if (errorsFound()){
		echo "The following errors were found";	
		echo nl2br("\n" . $firstnameErr . "\n" . $lastnameErr . "\n" . $emailErr . "\n" . $cityErr . "\n" . $stateErr . "\n" . $zipErr . "\n");

	}
	
	else {
		
		$sql = "INSERT INTO Students (FirstName, MiddleName, LastName, EmailAddress, StreetAddress, City, Zip, HomePhone, CellPhone)
		VALUES ('$firstname', '$middlename', '$lastname', '$email', '$street', '$city', '$zip', '$homephone', '$cellphone');
		";
		if(!empty($_POST['checkboxarr'])) {
    		foreach($_POST['checkboxarr'] as $registerCourse) {
				$conn->query("INSERT INTO StudentCourses (EmailAddress, CourseName) VALUES ('$email', '$registerCourse');");
    		}
		}
		

		if ($conn->query($sql) && !errorsFound()) {
    		echo "Thank you for submitting " . $firstname . ".";

			/* 
			///////////////////////
			Send email to user with all of their registered courses - this hasn't been test 05/07/2014
			/////////////////////
			*/
			if(!empty($_POST['checkboxarr'])) {

				$usrmsg = "You registered for:\n";
				foreach($_POST['checkboxarr'] as $registerCourse) {
					$usrmsg .= $registerCourse . '\n';
				}
			
			$usrmsg = wordwrap($usrmsg,70);

			// send email
			mail($email,"Thank you for registering",$usrmsg);
				}
			else {
			mail($email, "Thank you for registering", "You registered for no courses.");
				}
			// Admin email message
			$adminmsg = "User" . $firstname . " " . $lastname . " just registered.";
			
			// Replace with admin email
			mail("mazinzakaria1@gmail.com", "New user registered", $adminmsg); 
			
		} else {
			
    		echo "Error: " . $sql . "<br>" . $conn->error;
		}
		$conn->close();
	}
}
else {
	// retrieve all courses
	$query = mysqli_query($conn,"SELECT * FROM Courses");

?>
	<br>
	<form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']);?>"  name= "register" method="post" id="registerform">
	
	<?
	
	
	//
	while ($row = mysqli_fetch_array($query)) { 
	  $courseName = $row['CourseName']; 
	  $description = $row['Description']; 
	  $credits = $row['Credits']; 
	  $teacher = $row['Teacher']; 
	  $classDays = $row['ClassDays']; 
	  $hours = $row['Hours']; 


//////////
	  echo '<div id="' . $courseName . '" class="courseBox"> <h4>' . $courseName . ' </h4>
	  
	 <p>' . $description . '</p>
	 <h5>' . $teacher . ' | ' . $classDays . ' | ' . $credits . ' Hour(s)/Credit(s)</h5>
	 <input type="checkbox" value="'. $courseName .'" name="checkboxarr[]"  onclick = "limitCheckNum(this)"> Register <br>
	 </div>';
	}
	
	?>
	*First name:<br>
	<input type="text" name="firstname">

	<br>
	Middle name:<br>
	<input type="text" name="middlename">
	<br>
    
	*Last name:<br>
	<input type="text" name="lastname">
	<br>
    
	*Email Address:<br>
	<input type="text" name="email">
	<br>
    
	*Street Address:<br>
	<input type="text" name="street">
	<br>
       
	*City:<br>
	<input type="text" name="city">
	<br>
    *State:<br>
	<input type="text" name="state">
	<br>
	*Zip:<br>
	<input type="text" name="zip" maxlength="5">
	<br>
	Home Phone:<br>
	<input type="text" name="homephone" maxlength="10">
	<br>
	Cell Phone:<br>
	<input type="text" name="cellphone" maxlength="10">
	<br>
	<br><br>
    
    
    
    
	<input name="submit" type="submit" id="submit" value="Submit">
	</form>
<?php  } ?>


</body>
</html>