<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Office Appointments</title>
</head>

<body>
    <h2>Office Appointments</h2>
    <?php
    $user = "root"; 
    $password = "root";
    $host="localhost"; 

    $DBConnect = mysqli_connect($host, $user, $password); 

    if ($DBConnect === FALSE) echo "<p>Error. Unable to connect to the database server.</p>" . "<p>Error code " . mysqli_errno() . ": " . mysqli_error() . "</p>"; 
    else {
        $DBName = "medicalOfficeDB"; 

        if (!mysqli_select_db($DBConnect, $DBName)) echo "<p>Unable to connect. There are no appointments scheduled.</p>";
        else {
            $TableName = "appointments";
            $SQLString = "SELECT * FROM $TableName"; 
            $QueryResult = mysqli_query($DBConnect, $SQLString); 

            if (mysqli_num_rows($QueryResult) == 0) echo "<p>There are no appointments scheduled.</p>";
            else {
                echo "<p>These are the appointments on calendar:</p>"; 
                echo "<table width='100%' border='1'>"; 
                echo "<tr><th>First Name</th><th>Last Name</th><th>DOB</th><th>Age</th><th>Appointment Date</th><th>Appointment Time</th><th>Reason for Visit</th></tr>"; 
                while ($Row = mysqli_fetch_array($QueryResult)) {
                    echo "<tr><td>{$Row['first_name']}</td>";
                    echo "<td>{$Row['last_name']}</td>";
                    echo "<td>{$Row['date_of_birth']}</td>"; 
                    echo "<td>{$Row['age']}</td>"; 
                    echo "<td>{$Row['appointment_date']}</td>"; 
                    echo "<td>{$Row['appointment_time']}</td>"; 
                    echo "<td>{$Row['reason']}</td>";  
                }
            }
            mysqli_free_result($QueryResult); 
        }
        mysqli_close($DBConnect); 
    }
    ?>
<p><a href="landingPage.html">Home Page</a></p>
</body>

</html>