<html>
<body>

<?php

echo "<h2>Initializing DB:</h2>";

error_reporting(E_ALL);
ini_set("display_errors", 1);

echo ("MySQL - PHP Connect Test <br/>");
$hostname = "localhost";
$username = "cse20161614";
$password = "stargazer";
$dbname = "db_cse20161614";

$connect = new mysqli($hostname, $username, $password, $dbname)
        or die("DB Connection Failed.");
//$result = mysql_select_db($dbname, $connect);

if($connect){
 echo("MySQL Serer Connect Success!");
 echo "<br>";
}
else{
 echo("MySQL Server Connect Failed!");
 echo "<br>";
}

?>



<?php
echo "<h2>Confirmed Choice:</h2>";


$CHOICE="";

if ($_SERVER["REQUEST_METHOD"] == "POST"){
   $CHOICE = test_input($_POST["Choice"]);
   echo "Order By : " , $CHOICE;

}

function test_input($data){
   $data = trim($data);
   $data = stripslashes($data);
   $data = htmlspecialchars($data);
   return $data;
}

?>

<?php

echo "<h2>Searching Datas...</h2>";

$sql = "SELECT * FROM Orders ORDER BY $CHOICE;";

$result = $connect->query($sql);

if ($result->num_rows > 0) {
    // output data of each row
    echo "<table border='2'><tr>
    <th> ORDERNUMBER </th>
    <th> USERID </th>
    <th> USERNAME </th>
    <th> EMAIL </th>
    <th> PHONE </th>
    <th> TOPPING </th>
    <th> PAYMETHOD </th>
    <th> CALLFIRST </th>
    <th> ORDERDATE </th></tr>";
    
    while($row = $result->fetch_assoc()) {
        echo "<tr><td>" . 
        $row["ORDERNUMBER"]. "</td><td>" . 
        $row["USERID"]. "</td><td>" . 
        $row["USERNAME"]. "</td><td>". 
        $row["EMAIL"].  "</td><td>".
        $row["PHONE"].  "</td><td>".
        $row["TOPPING"].  "</td><td>".
        $row["PAYMETHOD"].  "</td><td>".
        $row["CALLFIRST"].  "</td><td>".
        $row["ORDERDATE"];
    }
  } else {
    echo "0 results";
  }

?>


</body>
</html>