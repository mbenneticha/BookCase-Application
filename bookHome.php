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

<body class="body">

  <!--Page Title-->
  <div class="page-header">
    <h1 id="titler">
      BookCase<br/>
      <small id="sub">Personalized Shared Library Database</small>
    </h1>
  </div>

  <!--Forms-->
  <div class="container">

    <!--Form that adds an individual to database -->
    <div class="well well-sm" id="well">  <!--Places form in well -->

      <div class="col-md-4 text-center">  <!--Centers Button -->
        <button type="button" class="btn btn-info" id="collapsebtn" data-toggle="collapse" data-target="#demo">Add a Reader</button>
      </div>

      <div id="demo" class="collapse">  <!--Collapsible Form -->

        <form method="post" action="addreader.php" role="form"> 

          <div class="form-group">
            <legend>Name</legend>
            <label for="first_name">First Name</label>
            <input type="text" class="form-control" name="first_name" placeholder="i.e. John">
            <label for="last_name">Last Name</label>
            <input type="text" class="form-control" name="last_name" placeholder="i.e. Smith">
          </div>

          <div class="form-group">
            <legend>Date Of Birth</legend>
            <label for="dob">DOB</label>
            <input type="text" class="form-control" name="dob" placeholder="yyyy-mm-dd">
          </div>

          <div class="form-group">
            <legend>Username</legend>
            <label for="username">Username</label>
            <input type="text" class="form-control" name="username" placeholder="i.e. jsmithy">
          </div>

          <button type="submit" class="btn btn-default" name="addReader">Submit</button>

        </form>
      </div>
    </div>
    <!-- END FORM -->




    <!--Form that adds an author to database -->
    <div class="well well-sm" id="well">  <!--Places form in well -->

      <div class="col-md-4 text-center">  <!--Centers Button -->
        <button type="button" class="btn btn-info" id="collapsebtn" data-toggle="collapse" data-target="#demo3">Add an Author</button>
      </div>

      <div id="demo3" class="collapse">  <!--Collapsible Form -->

        <form method="post" action="addAuthor.php" role="form">
        
          <div class="form-group">
            <legend>Author Name</legend>
            <label for="a_first_name">First Name</label>
            <input type="text" class="form-control" name="a_first_name" placeholder="i.e Ernest">
            <label for="a_last_name">Last Name</label>
            <input type="text" class="form-control" name="a_last_name" placeholder="i.e. Hemingway">
          </div>

          <button type="submit" class="btn btn-default" name="addAuthor">Submit</button>

        </form>
      </div>
    </div>
    <!-- END FORM -->



    <!--Form that adds a genre to database -->
    <div class="well well-sm" id="well">  <!--Places form in well -->

      <div class="col-md-4 text-center">  <!--Centers Button -->
        <button type="button" class="btn btn-info" id="collapsebtn" data-toggle="collapse" data-target="#demo4">Add a Genre</button>
      </div>

      <div id="demo4" class="collapse">  <!--Collapsible Form -->

        <form method="post" action="addGenre.php" role="form">    <!--Change this later-->
        
          <div class="form-group">
            <legend>Genre</legend>
            <label for="genre_type">Type</label>
            <input type="text" class="form-control" name="genre_type" placeholder="i.e. Science-Fiction">
          </div>

          <button type="submit" class="btn btn-default" name="addGenre">Submit</button>

        </form>
      </div>
    </div>
    <!-- END FORM -->



<!--Form that adds a book to database -->
    <div class="well well-sm" id="well">  <!--Places form in well -->

      <div class="col-md-4 text-center">  <!--Centers Button -->
        <button type="button" class="btn btn-info" id="collapsebtn" data-toggle="collapse" data-target="#demo2">Add a Book</button>
      </div>

      <div id="demo2" class="collapse">  <!--Collapsible Form -->

        <form method="post" action="addBook.php" role="form"> 
        
          <div class="form-group">
            <legend>Book</legend>
            <label for="title">Title</label>
            <input type="text" class="form-control" name="title" placeholder="i.e. The Old Man and the Sea">
            <label for="numBookPage">Page Number</label>
            <input type="number" class="form-control" name="numBookPage" placeholder="i.e. 1234">
          </div>

          <div class="form-group">
            <legend>Author</legend>
            <label for="author">Select Author:</label>
            <select class="form-control" name="author">
              <!-- php creates dropdown menu for author selection -->
              <?php
                if(!($stmt = $mysqli->prepare("SELECT id, first_name, last_name FROM author"))){
                  echo "Prepare failed: "  . $stmt->errno . " " . $stmt->error;
                }

                if(!$stmt->execute()){
                  echo "Execute failed: "  . $mysqli->connect_errno . " " . $mysqli->connect_error;
                }
                if(!$stmt->bind_result($id, $fname, $lname)){
                  echo "Bind failed: "  . $mysqli->connect_errno . " " . $mysqli->connect_error;
                }
                while($stmt->fetch()){
                  echo '<option value=" '. $id . ' "> ' . $fname . " " . $lname . '</option>\n';
                }
                $stmt->close();
              ?>
              <!-- END PHP -->
            </select>  
          </div>

          <div class="form-group">
            <legend>Genre</legend>
            <label for="genre">Select Genre:</label>
            <select class="form-control" name="genre">
              <!-- php creates dropdown menu for genre selection -->
              <?php
                if(!($stmt = $mysqli->prepare("SELECT id, type FROM genre"))){
                  echo "Prepare failed: "  . $stmt->errno . " " . $stmt->error;
                }

                if(!$stmt->execute()){
                  echo "Execute failed: "  . $mysqli->connect_errno . " " . $mysqli->connect_error;
                }
                if(!$stmt->bind_result($id, $type)){
                  echo "Bind failed: "  . $mysqli->connect_errno . " " . $mysqli->connect_error;
                }
                while($stmt->fetch()){
                  echo '<option value=" '. $id . ' "> ' . $type . '</option>\n';
                }
                $stmt->close();
              ?>
              <!-- END PHP -->
            </select>
          </div>

          <button type="submit" class="btn btn-default" name="addBook">Submit</button>

        </form>
      </div>
    </div>
    <!-- END FORM -->




    <!--Form that adds a book to an individual's bookcase in the database -->
    <div class="well well-sm" id="well">  <!--Places form in well -->

      <div class="col-md-4 text-center">  <!--Centers Button -->
        <button type="button" class="btn btn-info" id="collapsebtn" data-toggle="collapse" data-target="#demo5">Add Book to Your Bookcase</button>
      </div>

      <div id="demo5" class="collapse">  <!--Collapsible Form -->

        <form method="post" action="addToBookshelf.php" role="form">
        
          <div class="form-group">
            <legend>Username</legend>
            <label for="i_username">Username</label>
            <input type="text" class="form-control" name="i_username" placeholder="i.e. u$er-Name">
          </div>

          <div class="form-group">
            <legend>Book</legend>
            <label for="i_book">Select Book:</label>
            <select class="form-control" name="i_book">
              <!-- php creates dropdown menu for book selection -->
              <?php
                if(!($stmt = $mysqli->prepare('SELECT book.id, book.title FROM book'))){
                  echo "Prepare failed: "  . $stmt->errno . " " . $stmt->error;
                }

                if(!$stmt->execute()){
                  echo "Execute failed: "  . $mysqli->connect_errno . " " . $mysqli->connect_error;
                }
                if(!$stmt->bind_result($id, $title)){
                  echo "Bind failed: "  . $mysqli->connect_errno . " " . $mysqli->connect_error;
                }
                while($stmt->fetch()){
                  echo '<option value=" '. $id . ' "> ' . $title . '</option>\n';
                }
                $stmt->close();
              ?>
              <!-- END PHP -->
            </select>
          </div>

          <div class="form-group">
            <legend>Date Acquired/Completed</legend>
            <label for="purchase_date">Date</label>
            <input type="text" class="form-control" name="purchase_date" placeholder="yyyy-mm-dd">
          </div>

          <button type="submit" class="btn btn-default" name="addToBookshelf">Submit</button>

        </form>
      </div>
    </div>
    <!-- END FORM -->
  </div>

  <!-- Search Feature -->
  <div class="container">
    <div class="well well-sm" id="well">  

      <form method="post" action="searchUsername.php" role="form">
        
          <div class="form-group">
            <legend>Your <i id="brand">BookCase</i> by Username</legend>
            <label for="s_username">Username</label>
            <input type="text" class="form-control" name="s_username" placeholder="Search">
          </div>

          <button type="submit" class="btn btn-default" name="searchUsername">Search</button>
      </form>
    </div>
  </div>

  <!-- Search Feature -->
  <div class="container">
    <div class="well well-sm" id="well">  

      <form method="post" action="searchYear.php" role="form">
        
          <div class="form-group">
            <legend>Search Your <i id="brand">BookCase</i> by Year</legend>
            <label for="y_username">Username</label>
            <input type="text" class="form-control" name="y_username" placeholder="u$er-Name">
            <label for="s_year">Year Acquired</label>
            <input type="text" class="form-control" name="s_year" placeholder="yyyy">
          </div>

          <button type="submit" class="btn btn-default" name="searchYear">Search</button>
      </form>
    </div>
  </div>

</body>
</html>
