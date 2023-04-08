<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Submit Patient Form</title>
</head>

<body>
<?php
    if (
        empty($_POST['first_name']) || empty($_POST['last_name']) || empty($_POST['dob'])
        || empty($_POST['age']) || empty($_POST['appt_date']) || empty($_POST['appt_time'])
        || empty($_POST['reason'])
    ) {
        echo "<p>You must input data into each field. 
            Click your browser's Back button to go to the form.</p>\n";
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
                $SQLstring = "CREATE DATABASE $DBName";
                $QueryResult = mysqli_query($DBConnect, $SQLstring);

                if ($QueryResult === FALSE) {
                    echo "<p>Unable to execute the query.</p>" . "<p>Error code " . mysqli_errno($DBConnect) . ": " . mysqli_error($DBConnect) . "</p>";
                } else {
                    echo "<p>This is the first appointment on calendar.</p>";
                }
            }
            mysqli_select_db($DBConnect, $DBName);

            $TableName = "appointments";
            $SQLstring = "SHOW TABLES LIKE '$TableName'";
            $QueryResult = mysqli_query($DBConnect, $SQLstring);

            if (mysqli_num_rows($QueryResult) === 0) {
                $SQLstring = "CREATE TABLE $TableName (countID SMALLINT NOT NULL AUTO_INCREMENT PRIMARY KEY, first_name VARCHAR(50), last_name VARCHAR(50), date_of_birth DATE, 
                                                        age VARCHAR(50), appointment_date DATE, appointment_time TIME, reason VARCHAR(100))";
                $QueryResult = mysqli_query($DBConnect, $SQLstring);
                if ($QueryResult === FALSE) {
                    echo "<p>Unable to create the table.</p>" . "<p>Error code " . mysqli_errno($DBConnect) . ": " . mysqli_error($DBConnect) . "</p>";
                }
            }
            $firstName = stripslashes($_POST['first_name']);
            $lastName = stripslashes($_POST['last_name']);
            $dob = $_POST['dob']; 
            $age = stripslashes($_POST['age']);
            $appointmentDate = stripslashes($_POST['appt_date']);
            $appointmentTime = stripslashes($_POST['appt_time']);
            $reason = stripslashes($_POST['reason']);

            $SQLstring = "INSERT INTO $TableName VALUES(NULL, '$firstName', '$lastName', '$dob', '$age', '$appointmentDate', '$appointmentTime', '$reason')";
            $QueryResult = mysqli_query($DBConnect, $SQLstring);

            if ($QueryResult === FALSE) {
                echo "<p>Unable to execute the query.</p>" . "<p>Error code " . mysqli_errno($DBConnect) . ": " . mysqli_error($DBConnect) . "</p>";
            } else {
                echo "<h1>Your appointment has been added to the calendar!</h1>";
            }
            mysqli_close($DBConnect);
        }
    }
    ?>
    <p><a href="landingPage.html">Return to Home Page</a></p>
</body>

</html>