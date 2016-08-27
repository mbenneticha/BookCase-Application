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
<!-- Prints table of all user's books in database -->
<body class="body">
	<div class="container">
	<br/><br/>
	    <div class="well well-sm" id="well"> <!--Places table in well -->
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
//global variable for COUNT() aggregate function
$add = 0;

//function to increment the number of COUNT() in the table
function sum_counts(){
	global $add;
	$add++;	
};

//Print all user books to table
if(!($stmt = $mysqli->prepare("SELECT i.first_name, i.last_name, b.title, a.first_name, a.last_name, p.add_date, COUNT( b.title ) AS booksRead  FROM individual i INNER JOIN purchase p ON i.id = p.iid INNER JOIN book b ON p.bid = b.id INNER JOIN author a ON b.aid = a.id WHERE i.username = ? GROUP BY b.title ORDER BY p.add_date DESC"))){
    echo "Prepare failed: " . $stmt->errno . " " . $stmt->error;
}
if(!($stmt->bind_param("s",$_POST['s_username']))){
	echo "Bind failed: "  . $stmt->errno . " " . $stmt->error;
}
if (!$stmt->execute()){
	echo "Execute failed: " . $mysqli->connect_errno . " " . $mysqli->connect_error;
}
if (!$stmt->bind_result($name, $last, $title, $authorfname, $authorlname, $year, $booksRead)){
	echo "Bind failed: " . $mysqli->connect_errno . " " . $mysqli->connect_error;
}
while($stmt->fetch()){
	echo "<tr>\n<td>\n" . $name . " " . $last . "\n</td>\n<td>\n" . $title . "\n</td>\n<td>\n" . $authorfname . " " . $authorlname . "\n</td>\n<td>\n" . $year . "\n</td>\n</tr>";
	sum_counts($year);
}
//Prints number value of how many books a user has on BookCase
echo "<h4> You have " . $add . " books in your <i id='brand'>BookCase</i>.</h4>";
$stmt->close();
?>
<!-- END php -->
		</table>
		</div>
		<!-- Button to return to Home Page -->
		<a href="http://web.engr.oregonstate.edu/~bennemar/CS340/ProjectBookcase/bookHome.php"><button type="submit" class="btn btn-default" name="backToHome">Back to Home</button></a>

	</div>
</body>
</html>