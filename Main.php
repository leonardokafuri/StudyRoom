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
  height: 100%; /* only for demonstration, should be removed */
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
  width:80%;
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
    <?php
     session_start();
     ?>
     <header>
	<h1>Make Your Bookings</h1>
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
            <div class="container main-container">
                    <div id="rooms" class=" page panel panel-primary">
                        <div class="panel-heading "><h4>Rooms Schedule</h4></div>
                        <div class="panel-body">
                            <form action="Main.php" method="POST">
                                <div class="row2">
                                    <div class="col">
                                        <input type="date" class="form-control" name="date" id="date" placeholder="Date">
                                        <select name="time">
                                        <option name="0">8:00-8:30</option>
                                        <option name="1">8:30-9:00</option>
                                        <option name="2">9:00-9:30</option>
                                        <option name="3">9:30-10:00</option>
                                        <option name="4">10:00-10:30</option>
                                        <option name="5">10:30-11:00</option>
                                        <option name="6">11:00-11:30</option>
                                        <option name="7">11:30-12:00</option>
                                        <option name="8">12:00-12:30</option>
                                        <option name="9">13:00-13:30</option>
                                        <option name="10">13:30-14:00</option>
                                        <option name="11">14:00-14:30</option>
                                        <option name="12">14:30-15:00</option>
                                        <option name="13">15:00-15:30</option>
                                        <option name="14">15:30-16:00</option>
                                        <option name="15">16:00-16:30</option>
                                        <option name="16">16:30-17:00</option>
                                        <option name="17">17:00-17:30</option>
                                        <option name="18">17:30-18:00</option>
                                        <option name="19">18:00-18:30</option>
                                        <option name="20">18:30-19:00</option>
                                        <option name="21">19:00-19:30</option>
                                        <option name="22">19:30-20:00</option>
                                        <option name="9">20:00-20:30</option>
                                        <option name="9">20:30-21:00</option>

                                        </select>
                                    </div>
                                    <div class="col2">
                                        <br>
                                        <input type="submit" class="btn btn-primary" id="loadCalendar" value="Search" name="go">
                                    </div>
                                    
                                </div>
                            </form>
                        </div>
                        <div class="list-group" id="rooms-list"></div>
                    </div>
                </div>
               
                <?php
   
    if(isset($_POST['go']))
    {
        if(isset($_POST['date']))
        {
        	
            $date = $_POST['date'];
   		    $_SESSION['date'] = $date;
   		    
            $time = $_POST['time'];
            $_SESSION['time'] = $time;
            
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
              $sql = "SELECT * FROM Room WHERE Room.RoomNumber NOT IN (SELECT RoomNumber FROM RoomAvailability where date ="."'". $_SESSION['date']."'"."and time="."'". $_SESSION['time']."');";
              $res = mysqli_query($db_conn,$sql);
              if($res !== FALSE)
              {
                if(mysqli_num_rows($res) == 0)
                   print("no matching records");
                else
                {
                    $id = 0;
                    print("<form action='Main.php' method='POST'>");
                    for($row = 1;$row<=mysqli_num_rows($res);$row++)
                    {
                        $record = mysqli_fetch_assoc($res);
                        print("<input type='radio' name='room' value='".$record["RoomNumber"]."' id='".$id."'>".$record["RoomNumber"]." ".$record["Building"]."<br />");
                        $id++;
                    }
                    print("<br />");
                    print("<input type='submit' name='book' value='Book'>");
                    print("</form>");
                }
              }
              mysqli_close($db_conn);
        }
    }
    if(isset($_POST['book']))
    {

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
        $room = $_POST['room'];
        $user = $_SESSION['valid_user'];
        $date = $_SESSION['date'];
        $time = $_SESSION['time'];
        if(!empty($date) && !empty($time) && !empty($room))
        {
            $sql = "insert into RoomBooked(StudentID,RoomNumber,Date,Time)
            values('$user','$room','$date','$time')";
            $sql2 = "insert into RoomAvailability(RoomNumber,Date,Time)
            values('$room','$date','$time')";
            $res = mysqli_query($db_conn,$sql);
            $res = mysqli_query($db_conn,$sql2);
            if($res)
				print("Bookings added");
				
			else
                print("Problem ".mysqli_error($db_conn));
            
            mysqli_close($db_conn);    
        }
    }
    echo "</article>
</section>
<footer>
  <p>Welcome &nbsp".$_SESSION['fname']."&nbsp".$_SESSION['lname']."</p>
</footer>";

?>
             
    </body>
</html>

