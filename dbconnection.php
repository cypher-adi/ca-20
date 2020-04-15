<?php
    $server="localhost";
    $username="root";
    $password="";
    $dbname="ca-20";

    $conn= mysqli_connect( $server , $username , $password , $dbname);
    if(!$conn)
    {
        echo "Connection Error:".mysql_connect_error();
    
    }

?>
