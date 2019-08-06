<?php
session_start();

if (isset($_POST['userid']) && isset($_POST['password']))
{
  // if the user has just tried to log in
  $userid = $_POST['userid'];
  $password = $_POST['password'];
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

  $query = "select * from Students where 
            StudentID='".$userid."' and 
            password='".$password."'";

  $result = mysqli_query($db_conn,$query);
  if (mysqli_num_rows($result))
{ 
    // if they are in the database register the user id
    $_SESSION['valid_user'] = $userid;
    $query = "SELECT * FROM  Students where StudentID ="."'".$userid."';";
  	
  	$stmt = $db_conn->prepare($query);
    $stmt->execute();
    $stmt->store_result();
    $stmt->bind_result($SID,$fName,$lName,$pass);
    while($stmt->fetch()) {
    	$_SESSION['fname'] =$fName;
    	$_SESSION['lname'] =$lName;
    }
  }
  $db_conn->close();
}

?>
<!DOCTYPE html>
<html>
<head>
   <title>Book a Study Room</title>
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
  height: 75%; /* only for demonstration, should be removed */
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
  height: 75%;

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
<header>Login Page</header>

<?php
   if (isset($_SESSION['valid_user']))
  {
    echo '<p>You are logged in as: '.$_SESSION['valid_user'].' <br />';
    echo '<a href="Main.php">Book a room</a></p>';
    echo '<a href="DeleteBooking.php">Manage  your Bookings</a></p>';
	echo '<a href="logout.php">Log out</a></p>';
  }
  else
  {
    if (isset($userid))
    {
      // if they've tried and failed to log in
      echo '<p>Could not log you in.</p>';
    }
    else
    {
      // they have not tried to log in yet or have logged out
      echo '<p>You are not logged in.</p>';
    } 

    // provide form to log in
    echo '<form action="Login.php" method="post">';
    echo '<fieldset>';
    echo '<legend>Login Now!</legend>';
    echo '<p><label for="userid">StudentID:</label>';
    echo '<input type="text" name="userid" id="userid" size="30"/></p>';
    echo '<p><label for="password">Password:</label>';
    echo '<input type="password" name="password" id="password" size="30"/></p>';    
    echo '</fieldset>';
    echo '<button type="submit" name="login">Login</button>';
    echo '</form>';
    echo "<br />";
    
    echo '<a href="Register.php">Click here to create a Login</a>';
  }
?>
<br/> <br />

</body>
</html>