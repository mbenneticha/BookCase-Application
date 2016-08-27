<?php
//Turn on error reporting
ini_set('display_errors', 'On');
//Connects to database
$mysqli = new mysqli("database","username", "password", "databasename");
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
<!-- Prints table of all users books from database -->
<body class="body">
	<div class="container">
	<br/><br/>
	    <div class="well well-sm" id="well">
	    	<table class="table table-hover">
			          <thead>
			            <tr>
			              <th><i id="brand">My BookCase Books</i></th>
			            </tr>
			          </thead>
			          <thead>
			            <tr>
			              <th>Name</th>
			              <th>Title</th>
			              <th>Author</th>
			              <th>Year Acquired</th>
			            </tr>
			          </thead>

<?php
//Many-Many relationship
//Link/Add Book to an Individual via a 'Purchase'

if(!($stmt = $mysqli->prepare("INSERT INTO purchase (bid, iid, add_date) VALUES (?, (SELECT individual.id FROM individual WHERE individual.username = ?), ?)"))){
	echo "Prepare failed: "  . $stmt->errno . " " . $stmt->error;
}
if(!($stmt->bind_param("iss",$_POST['i_book'],$_POST['i_username'],$_POST['purchase_date']))){
	echo "Bind failed: "  . $stmt->errno . " " . $stmt->error;
}
if(!$stmt->execute()){
	echo "Execute failed: "  . $stmt->errno . " " . $stmt->error;
}
else{
	echo "Success!\nAdded " . $stmt->affected_rows . " rows to BookCase.";
}
$stmt->close();

//Print al books to the table
if(!($stmt2 = $mysqli->prepare("SELECT i.first_name, i.last_name, a.first_name, a.last_name, b.title, p.add_date FROM individual i INNER JOIN purchase p ON i.id = p.iid INNER JOIN book b ON p.bid = b.id INNER JOIN author a ON b.aid = a.id WHERE i.username = ? GROUP BY b.title ORDER BY p.add_date DESC"))){
    echo "Prepare failed: " . $stmt2->errno . " " . $stmt2->error;
}
if(!($stmt2->bind_param("s",$_POST['i_username']))){
	echo "Bind failed: "  . $stmt2->errno . " " . $stmt2->error;
}
if (!$stmt2->execute()){
	echo "Execute failed: " . $mysqli->connect_errno . " " . $mysqli->connect_error;
}
if (!$stmt2->bind_result($name, $last, $authorfname, $authorlname, $title, $year)){
	echo "Bind failed: " . $mysqli->connect_errno . " " . $mysqli->connect_error;
}
while($stmt2->fetch()){
	echo "<tr>\n<td>\n" . $name . " " . $last . "\n</td>\n<td>\n" . $title . "\n</td>\n<td>\n" . $authorfname . " " . $authorlname . "\n</td>\n<td>\n" . $year . "\n</td>\n</tr>";
}
$stmt2->close();
?>
<!-- END php -->
		</table>
		</div>
		<!-- Button to return to Home Page -->
		<button type="submit" class="btn btn-default" name="backToHome"><a href="http://web.engr.oregonstate.edu/~bennemar/CS340/ProjectBookcase/bookHome.php">Back to Home</a></button>

	</div>
</body>
</html>
