<html>
<head>
	<h1>Manage your Bookings</h1>
</head>
<?php
session_start();
if (isset($_SESSION['valid_user']))
  {
    echo '<p>You are logged in as: '.$_SESSION['valid_user'].' <br />';
	$user = $_SESSION['valid_user'];
	
	$db_conn = new mysqli('localhost', 'admin', 'admin', 'booking');

 	if (mysqli_connect_errno()) {
    echo 'Connection to database failed:'.mysqli_connect_error();
    exit();
  	}
  	
  	$query = "SELECT * FROM  RoomBooked where StudentID ="."'".$user."';";
  	
  	$stmt = $db_conn->prepare($query);
    $stmt->execute();
    $stmt->store_result();
    $stmt->bind_result($BID,$SID,$RN,$Date,$Time);
	 while($stmt->fetch()) {
      echo "<p><strong>Booking ID: </strong>".$BID;
      echo "&nbsp<strong>Student ID: </strong>".$SID;
      echo "&nbsp<strong>Room Number: </strong>".$RN;
      echo "&nbsp<strong>Date: </strong>".$Date;
      echo "&nbsp<strong>Time: </strong>".$Time ."</p> <br />";
    } 
    
    echo '<form method="post">';
    echo 'Choose a booking to be deleted : ';
    echo '<input type:"text" name="deleteid" id="deleteid" size="10" /> &nbsp';
    echo '<button type="submit" name="delete">delete</button>';
    echo '</form>';
    
    if(isset($_POST['delete']))
    {
    		$deleteID = $_POST['deleteid'];
    		$deletequery = "delete from RoomBooked where BookingID ="."'".$deleteID."';";
   		$stmt = $db_conn->prepare($deletequery);
	    $stmt->execute();
		echo "Booking deleted successfully <br /> <br />";
   	}
	$db_conn->close();
  }
  else
  {
  		echo "You are not logged in";
  		echo '<a href="Login.php">Click here to Login</a></p>';
  		exit;
  }
?>
</html>