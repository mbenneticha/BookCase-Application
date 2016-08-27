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
<!--Link to Bootstrap stylesheets and my own stylesheet, etc.-->
<head>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">
  <link rel="stylesheet" href="styles.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.2/jquery.min.js"></script>
  <script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
</head>

<!-- Prints table of all genres in database -->
<body class="body">
	<div class="container">
	<br/><br/>
	    <div class="well well-sm" id="well">
	    	<table class="table">
	    		<thead>
		            <tr>
		              <th><i id="brand">BookCase Genres</i></th>
		        	</tr>
		        </thead>
			    <thead>
			      <tr>
			        <th>Genre</th>
			      </tr>
			    </thead>
<!-- php to insert the added genre into the database 'genre' table and print all genres in database to table-->
<?php
if(!($stmt = $mysqli->prepare("INSERT INTO genre (type) VALUES (?)"))){
	echo "Prepare failed: "  . $stmt->errno . " " . $stmt->error;
}
if(!($stmt->bind_param("s",$_POST['genre_type']))){
	echo "Bind failed: "  . $stmt->errno . " " . $stmt->error;
}
if(!$stmt->execute()){
	echo "Execute failed: "  . $stmt->errno . " " . $stmt->error;
} else {
	echo "Success!\nAdded " . $stmt->affected_rows . " rows to BookCase 'Genre' database.";
}
$stmt->close();

if(!($stmt2 = $mysqli->prepare("SELECT g.type FROM genre g ORDER BY g.type ASC"))){
    echo "Prepare failed: " . $stmt2->errno . " " . $stmt2->error;
}
if (!$stmt2->execute()){
	echo "Execute failed: " . $mysqli->connect_errno . " " . $mysqli->connect_error;
}
if (!$stmt2->bind_result($type)){
	echo "Bind failed: " . $mysqli->connect_errno . " " . $mysqli->connect_error;
}
while($stmt2->fetch()){
	echo "<tr>\n<td>\n" . $type . "\n</td>\n</tr>";
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