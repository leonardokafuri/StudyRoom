<html>
<head>
	
	<style>
* {
  box-sizing: border-box;
}

body {
  font-family: Arial, Helvetica, sans-serif;
}

/* Style the header */
header {
  background-color: #666;
  padding: 30px;
  text-align: center;
  font-size: 35px;
  color: white;
}

/* Create two columns/boxes that floats next to each other */
nav {
  float: left;
  width: 20%;
  height: 100%; 
  background: #ccc;
  padding: 20px;
}

/* Style the list inside the menu */
nav ul {
  list-style-type: none;
  padding: 0;
}

article {
  float: left;
  padding: 20px;
  width: 80%;
  background-color: #f1f1f1;
  height: 100%;

}

/* Clear floats after the columns */
section:after {
  content: "";
  display: table;
  clear: both;
}

/* Style the footer */
footer {
  background-color: #777;
  padding: 10px;
  text-align: center;
  color: white;
}

/* Responsive layout - makes the two columns/boxes stack on top of each other instead of next to each other, on small screens */
@media (max-width:600px) {
  nav, article {
    width: 100%;
    height: auto;
  }
}
</style>
</head>
<body>
<header>
	<h1>Manage your Bookings</h1>
</header>
<section>
  <nav>
    <ul>
      <li><a href="Login.php"">Login</a></li>
      <li><a href="Main.php">Book Room</a></li>
      <li><a href="DeleteBooking.php">Manage Booking</a></li>
    </ul>
  </nav>
  <article>

<?php
session_start();
if (isset($_SESSION['valid_user']))
  {
    echo '<p>You are logged in as StudentID: '.$_SESSION['valid_user'].' <br />';
	$user = $_SESSION['valid_user'];
	
  $socket = "/cloudsql/roombooking-248319:us-west1:roomdatabase";
  $host=NULL;
  $port=null;
  $userDB="admin";
  $dbpass="admin";
  $db="booking";
  $db_conn = new mysqli($host, $userDB, $dbpass, $db,$port,$socket);

 	if (mysqli_connect_errno()) {
    echo 'Connection to database failed:'.mysqli_connect_error();
    exit();
  	}
  	
  	$query = "SELECT * FROM  RoomBooked where StudentID ="."'".$user."';";
  	
  	$stmt = $db_conn->prepare($query);
    $stmt->execute();
    $stmt->store_result();
    $stmt->bind_result($BID,$SID,$RN,$Date,$Time);
    $booking= array();
    $i=0;
    echo '<form method="post">';
	 while($stmt->fetch()) {
	  echo '<p><input type="radio" name="radio" value='.$i.' >';
      echo "<strong>Booking ID: </strong>".$BID;
      echo "&nbsp<strong>Student ID: </strong>".$SID;
      echo "&nbsp<strong>Room Number: </strong>".$RN;
      echo "&nbsp<strong>Date: </strong>".$Date;
      echo "&nbsp<strong>Time: </strong>".$Time ."</p> <br />";
      $booking[]=array($BID,$SID,$RN,$Date,$Time);
      $i++;
      
    } 

    
    echo ' Select a booking to be Updated <button type="submit" name="edit">Update</button></br><strong>OR</strong></br> Enter BookingID to Delete: ';
    echo '<input type:"text" name="deleteid" id="deleteid" size="10" /> &nbsp';
    echo '<button type="submit" name="delete">Delete</button>&nbsp</br></br>';
  
    
    
    if (isset($_POST['edit'])) {
	if(isset($_POST['radio']))
	{
		 $_SESSION['bookingID'] = $booking[$_POST['radio']][0];
		 $_SESSION['roomID']=$booking[$_POST['radio']][2];
		 $_SESSION['dateID']=$booking[$_POST['radio']][3];
		 $_SESSION['timeID']=$booking[$_POST['radio']][4];
		
	echo "You have selected Booking ID :".$booking[$_POST['radio']][0];  //  Displaying Selected Value
	echo "<p>Update Room Number: ";
echo "<select name='room'>
<option selected='selected'>".$booking[$_POST['radio']][2]."</option>
        <option name='0'>101</option>
        <option name='1'>102</option>
        <option name='2'>103</option>
        <option name='3'>104</option>
        <option name='4'>105</option>
        <option name='5'>106</option>
        <option name='6'>107</option>
        <option name='7'>108</option>
        <option name='8'>109</option>
        <option name='9'>110</option>
        <option name='10'>111</option>
        <option name='11'>112</option>
        <option name='12'>113</option>
        <option name='13'>114</option>
        <option name='14'>115</option>
        <option name='15'>116</option>
        <option name='16'>117</option>
        <option name='17'>118</option>
        <option name='18'>119</option>
        <option name='19'>120</option>
        </select></p>";
	echo "<p>Update Date: ";
	echo '<input type="date" class="form-control" name="date" id="date" placeholder="Date" value='.$booking[$_POST['radio']][3].'></p>';
	echo "<p>Update Time: ";
	echo "<select name='time'>
	<option selected='selected'>".$booking[$_POST['radio']][4]."</option>
        <option name='0'>8:00-8:30</option>
        <option name='1'>8:30-9:00</option>
        <option name='2'>9:00-9:30</option>
        <option name='3'>9:30-10:00</option>
        <option name='4'>10:00-10:30</option>
        <option name='5'>10:30-11:00</option>
        <option name='6'>11:00-11:30</option>
        <option name='7'>11:30-12:00</option>
        <option name='8'>12:00-12:30</option>
        <option name='9'>13:00-13:30</option>
        <option name='10'>13:30-14:00</option>
        <option name='11'>14:00-14:30</option>
        <option name='12'>14:30-15:00</option>
        <option name='13'>15:00-15:30</option>
        <option name='14'>15:30-16:00</option>
        <option name='15'>16:00-16:30</option>
        <option name='16'>16:30-17:00</option>
        <option name='17'>17:00-17:30</option>
        <option name='18'>17:30-18:00</option>
        <option name='19'>18:00-18:30</option>
        <option name='20'>18:30-19:00</option>
        <option name='21'>19:00-19:30</option>
        <option name='22'>19:30-20:00</option>
        <option name='9'>20:00-20:30</option>
        <option name='9'>20:30-21:00</option>
	</select></p>";
	    echo '<button type="submit" name="check">Update Booking</button></form>';
	    

	}
	}
	if(isset($_POST['check']))
    {
    		
		//check if avalable
		$query = "select * from RoomBooked where 
            RoomNumber='".$_POST['room']."' and 
            Date='".$_POST['date']."' and
            Time='".$_POST['time']."'";
            $result = mysqli_query($db_conn,$query);
  if (mysqli_num_rows($result))
  {
	echo "Room not available, try again";
  }else{
  	$sqlUpdate = "UPDATE RoomBooked SET RoomNumber='".$_POST['room']."',
            Date='".$_POST['date']."',
            Time='".$_POST['time']."' where BookingID ='" .$_SESSION['bookingID']."'" ;

		$stmt = $db_conn->prepare($sqlUpdate);
	     $stmt->execute();
	     echo "BookingID: ".$_SESSION['bookingID']." updated successfully <br /> <br />";
	     
  }
  

   	
}
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
   	
  echo "</article>
</section>
<footer>
  <p>Welcome &nbsp".$_SESSION['fname']."&nbsp".$_SESSION['lname']."</p>
</footer>";

?>

</body>
</html>