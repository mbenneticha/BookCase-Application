<?php
//Turn on error reporting
ini_set('display_errors', 'On');
//Connects to database
$mysqli = new mysqli("oniddb.cws.oregonstate.edu","bennemar-db", "yA5TEFEdN2cg9bes", "bennemar-db");
if($mysqli->connect_errno){
  echo "Connection error " . $mysqli->connect_errno . " " . $mysqli->connect_error;
  }
?>

<!DOCTYPE html>
<html>
<!--Link to Bootstrap stylesheets and own stylesheet, etc.-->
<head>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">
  <link rel="stylesheet" href="styles.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.2/jquery.min.js"></script>
  <script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
</head>

<!-- Prints table of all authors in database -->
<body class="body">
	<div class="container">
	<br/><br/>
	    <div class="well well-sm" id="well">
	    	<table class="table">
	    		<thead>
		            <tr>
		              <th><i id="brand">BookCase Authors</i></th>
		        	</tr>
		        </thead>
			    <thead>
			      <tr>
			        <th>Firstname</th>
			        <th>Lastname</th>
			      </tr>
			    </thead>
<!-- php to insert the added author into the database 'author' table and print all authors in database to table-->
<?php
if(!($stmt = $mysqli->prepare("INSERT INTO author (first_name, last_name)
VALUES (?,?)"))){
	echo "Prepare failed: "  . $stmt->errno . " " . $stmt->error;
}
if(!($stmt->bind_param("ss",$_POST['a_first_name'],$_POST['a_last_name']))){
	echo "Bind failed: "  . $stmt->errno . " " . $stmt->error;
}
if(!$stmt->execute()){
	echo "Execute failed: "  . $stmt->errno . " " . $stmt->error;
} else {
	echo "Success!\nAdded " . $stmt->affected_rows . " rows to BookCase 'Author' database.";
}
$stmt->close();

if(!($stmt2 = $mysqli->prepare("SELECT a.first_name, a.last_name FROM author a ORDER BY a.last_name ASC"))){
    echo "Prepare failed: " . $stmt2->errno . " " . $stmt2->error;
}
if (!$stmt2->execute()){
	echo "Execute failed: " . $mysqli->connect_errno . " " . $mysqli->connect_error;
}
if (!$stmt2->bind_result($name, $last)){
	echo "Bind failed: " . $mysqli->connect_errno . " " . $mysqli->connect_error;
}
while($stmt2->fetch()){
	echo "<tr>\n<td>\n" . $name . "\n</td>\n<td>\n" . $last . "\n</td>\n</tr>";
}
$stmt2->close();
?>
<!-- END php -->
		</table>
		</div>
		<!-- Button to return to Home Page -->
		<a href="http://web.engr.oregonstate.edu/~bennemar/CS340/ProjectBookcase/bookHome.php"><button type="submit" class="btn btn-default" name="backToHome">Back to Home</button></a>
		
	</div>
</body>
</html>