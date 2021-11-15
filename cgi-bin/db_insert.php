<html>
<body>

<?php

echo "<h2>Initializing DB:</h2>";
// intializing DB


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

$sql = "CREATE TABLE Orders(
        ORDERNUMBER INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
        USERID VARCHAR(10) UNIQUE KEY,
        USERNAME VARCHAR(30) NOT NULL,
        EMAIL VARCHAR(30) NOT NULL,
        PHONE VARCHAR(20) ,
        TOPPING VARCHAR(20) NOT NULL,
        PAYMETHOD VARCHAR(20) NOT NULL,
        CALLFIRST VARCHAR(10) NOT NULL,
        ORDERDATE TIMESTAMP
        )";

if( $connect -> query($sql) === TRUE){
        echo "Table Created Successfully";
        echo ("<br>");
}
else{
        echo "Error creating table:" . $connect->error;
        echo ("<br>");
}


//$connect->close();
?>


<?php
$idnumber = $name = $email = $phone = $topping = $paymethod = $callfirst = "";

if ($_SERVER["REQUEST_METHOD"] == "POST"){
   $idnumber = test_input($_POST["idnumber"]);
   $name = test_input($_POST["name"]);
   $email = test_input($_POST["email"]);
   $phone = test_input($_POST["phone"]);
   $topping = test_input($_POST["topping"]);
   if($topping === "")
        $topping = "none";
   $paymethod = test_input($_POST["paymethod"]);
   $callfirst = test_input($_POST["callfirst"]);
   
}

function test_input($data){
   $data = trim($data);
   $data = stripslashes($data);
   $data = htmlspecialchars($data);
   $data = addslashes($data);
   return $data;
}
?>


<?php

// Echoing Input Datas

echo "<h2>Echoed Datas:</h2>";
echo "ID Number : ";
echo $idnumber;
echo "<br>";
echo "Name : ";
echo $name;
echo "<br>";
echo "E-mail : ";
echo $email;
echo "<br>";
echo "Phone Number : ";
echo $phone;
echo "<br>";
echo "Topping : ";
echo $topping;
echo "<br>";
echo "Pay Method : ";
echo $paymethod;
echo "<br>";
echo "Call First : ";
echo $callfirst;

//$connect->close();
?>

<?php
// Inserting Datas
echo "<h2>Inserting Datas...</h2>";

$sql = "INSERT INTO Orders (USERID,USERNAME,EMAIL,PHONE,TOPPING,PAYMETHOD,CALLFIRST)
        VALUES ('$idnumber', '$name', '$email', '$phone', '$topping', '$paymethod', '$callfirst')";
if($connect->query($sql)===TRUE){
        echo ("Insertion Done");
        echo ("<br>");
}
else{
        echo ("Error: " . $sql . "<br>" . $connect->error);
}
?>



</body>
</html>