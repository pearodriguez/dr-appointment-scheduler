<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Patient Search Result</title>
</head>
<body>
    <?php

    if (empty($_POST['last_name']) || empty($_POST['dob'])) {
        echo "<p>You must input data into each field. 
            Click your browser's Back button to go to the search form.</p>\n";
    } else {
        $user = "root";
        $password = "root";
        $host = "localhost";

        $DBConnect = mysqli_connect($host, $user, $password);
        if ($DBConnect === FALSE) {
            echo "<p>Unable to connect to the database server.</p>" . "<p>Error code " . mysqli_errno() . ": " . mysqli_error() . "</p>";
        } else {
            $DBName = "medicalOfficeDB";

            if (!mysqli_select_db($DBConnect, $DBName)) {
                echo "Error. The database has not been created."; 
            }
            mysqli_select_db($DBConnect, $DBName);
            $TableName = "appointments";
            $last_name = stripslashes($_POST['last_name']); 
            $dob = $_POST['dob']; 
            $SQLstring = "SELECT * FROM $TableName WHERE last_name = '$last_name' AND date_of_birth = '$dob'"; 

            $QueryResult = mysqli_query($DBConnect, $SQLstring); 

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
        <p><a href="landingPage.html">Return to Home Page</a></p>
</body>

</html>