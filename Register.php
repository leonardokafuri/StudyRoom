<html>
	<header>
		<h1 style="text-align: center">Registration Page</h1>
	</header>
	<style>
		form{
		   position:fixed;
		   top:12%;
		   left:43%;
		   width: 250px;
		}
		p{
			color: #ff0000;
			position:fixed;
		   	top:28%;
		   	left:43%;
		   	width: 400px;
		}
		a{
			position:fixed;
		   	top:65%;
		   	left:43%;
		   	width: 250px;
		}
				p2{
			position:fixed;
		   	top:55%;
		   	left:43%;
		   	width: 250px;
		}
	</style>
	<body>
		<form action="Register.php" method="post">
		<table>
			<tr>
				<td> Student ID</td>
				<td>
				   <input type="text" name="SID" size="10" maxlength="9"/>
				</td>
			</tr>
			<tr>
				<td> First Name</td>
				<td>
				   <input type="text" name="fname" size="20" maxlength="16"/>
				</td>
			</tr>
			<tr>
				<td> Last Name </td>
				<td>
				   <input type="text" name="lname" size="20" maxlength="16"/>
				</td>
			</tr>
			<tr>
				<td> Password</td>
				<td>
				   <input type="password" name="password" size="15" maxlength="40"/>
				</td>
			</tr>
			<tr>
				<td colspan="2" style="text-align: center;" ><input type="submit" value="Create Login"/></td>
			</tr>
		</table>
		</form>
	</body>
</html>

<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST')
{
$userFname = $_POST['fname'];
$userLname = $_POST['lname'];
$userStudentID= $_POST['SID'];
$userPassword =$_POST['password'];
if (!$userFname || !$userLname  || !$userStudentID || !$userPassword)
	{
		
       echo "<p2>You have not entered all the required details.<br />
             Please try again.";
        echo "<a href='Login.php'>Return to the Login page </a></p2> &nbsp; &nbsp;";
        // if any of the fields are not set, show error message and exit the program  
    		exit;
    }

	  $socket = "/cloudsql/roombooking-248319:us-west1:roomdatabase";
	  $host=NULL;
	  $port=null;
	  $userDB="admin";
	  $dbpass="admin";
	  $db="booking";
	  $db_conn = new mysqli($host, $userDB, $dbpass, $db,$port,$socket);
	if (mysqli_connect_errno()) 
	{
	    echo 'Connection to database failed:'.mysqli_connect_error();
	    exit();
    }
    
    $query = "INSERT INTO Students(StudentID,fname,lname,Password) VALUES("."'".$userStudentID."',"."'".$userFname."',"."'".$userLname."',"."'".$userPassword."'".");";
    $stmt = $db_conn->prepare($query);
    
    $checkRepeat = "SELECT StudentID FROM Students"; // i am using the studentID in order to check if 
    // the student entered has already being registerd
    $stmt2 = $db_conn->prepare($checkRepeat);
    $stmt2->execute();
    $stmt2->store_result();
    
    $stmt2->bind_result($dbsid);
	 while($stmt2->fetch())
	  {
	      if($dbsid==$userStudentID)
	      {
		 	echo "<p2>Student ID already registered, please try a differet ID <br /> <br />";
		 	echo "<a href='Login.php'>Return to the login page </a></p2> &nbsp; &nbsp;";
	        //each user will have their own studentID and wont be able to register the same ID twice, if they try 
	        //show an error message and exit the program
	        exit;
		  }
    }
    
    $stmt->execute(); //insert user into the database 
    if ($stmt->affected_rows > 0) {
        echo  "<p2>Login created!<p2>";
        echo "<a href='Login.php'>Click here to login now!</a>";
	}else {
        echo "<p2>An error has occurred.<br/>
              The user was not added.</p2>";
    }
    $db_conn->close();
    
}
    

?>