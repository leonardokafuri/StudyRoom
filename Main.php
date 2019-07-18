<html>
    <head>

    </head>
    <body>
            <div class="container main-container">
                    <div id="rooms" class=" page panel panel-primary">
                        <div class="panel-heading "><h4>Rooms Schedule</h4></div>
                        <div class="panel-body">
                            <form action="Main.php" method="POST">
                                <div class="row2">
                                    <div class="col">
                                        <input type="date" class="form-control" name="date"  placeholder="Date">
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
                                        <input type="submit" class="btn btn-primary" id="loadCalendar" value="Go" name="go">
                                    </div>
                                    
                                </div>
                            </form>
                        </div>
                        <div class="list-group" id="rooms-list"></div>
                    </div>
                </div>
    </body>
</html>

<?php
    if(isset($_POST['go']))
    {
        if(isset($_POST['date']))
        {
            $date = $_POST['date'];
            $db_conn = new mysqli('localhost', 'admin', 'admin', 'booking');
            if (mysqli_connect_errno()) {
                echo 'Connection to database failed:'.mysqli_connect_error();
                exit();
              }
        }
    }

?>