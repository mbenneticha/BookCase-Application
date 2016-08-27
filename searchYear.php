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
<!-- Prints table of all user books in database that match entered year -->
<body class="body">
	<div class="container">
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
//globale variable
$add = 0;
//function to increment the COUNTS() 
function sum_counts($year){
	global $add;
	$add++;	
};
//Print all books with YEAR(add_date) matching user-entered year to table
if(!($stmt = $mysqli->prepare("SELECT i.first_name, i.last_name, b.title, a.first_name, a.last_name, p.add_date, YEAR( p.add_date ), COUNT( b.title ) AS booksRead FROM purchase p INNER JOIN individual i ON p.iid = i.id INNER JOIN book b ON p.bid = b.id INNER JOIN author a ON b.aid = a.id WHERE i.username = ? AND YEAR( p.add_date ) = ? GROUP BY b.title"))){
    echo "Prepare failed: " . $stmt->errno . " " . $stmt->error;
}
if(!($stmt->bind_param("ss",$_POST['y_username'],$_POST['s_year']))){
	echo "Bind failed: "  . $stmt->errno . " " . $stmt->error;
}
if (!$stmt->execute()){
  echo "Execute failed: " . $mysqli->connect_errno . " " . $mysqli->connect_error;
}
if (!$stmt->bind_result($name, $last, $title, $authorfname, $authorlname, $add_date, $year, $booksRead)){
  echo "Bind failed: " . $mysqli->connect_errno . " " . $mysqli->connect_error;
}
while($stmt->fetch()){
  echo "<tr>\n<td>\n" . $name . " " . $last . "\n</td>\n<td>\n" . $title . "\n</td>\n<td>\n" . $authorfname . " " . $authorlname . "\n</td>\n<td>\n" . $add_date . "\n</td>\n</tr>";
  sum_counts($year);
}
//Print how many books individual read in user-entered year
echo "<h4> You have read " . $add . " books in the year " . $year . ".</h4>";
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