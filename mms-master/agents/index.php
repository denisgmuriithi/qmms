<?php
  require_once "../config/database.php";
  session_start();
  if(!isset($_SESSION['user'])){
    header("Location: index.php");
    exit();
  }

  $db = new Database();
  $pdo = $db->getConnection();

?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta http-equiv="X-UA-Compatible" content="ie=edge" />
    <title>QET - Marketing Management System</title>
    <link rel="stylesheet" type="text/css" href="../font/roboto/roboto.css">
    <link rel="stylesheet" type="text/css" href="../font/material/material-icons.css">

    <link rel="stylesheet" type="text/css" href="../css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="../css/style.css">

  </head>
  <body>
<nav class="navbar navbar-expand-lg navbar-dark bg-primary">
  <a class="navbar-brand" href="#">QET-Marketing Management System</a>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarColor01" aria-controls="navbarColor01" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>

  <div class="collapse navbar-collapse" id="navbarColor01">
    <ul class="navbar-nav mr-auto float-right">
      <li class="nav-item active">
        <a class="nav-link" href="../home.php">Home <span class="sr-only">(current)</span></a>
      </li>
      <li class="nav-item active">
        <a class="nav-link" href="#"></a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="../logout.php">Logout</a>
      </li>
    </ul>
  </nav>

  <main class="container"> 
 <!-- leads table -->
        <h2 class="display-4 page-header">Manage Agents</h2>
        <p>You can edit Agents by clicking the edit icon.</p>
        <p>Add Agents using the Add Agent button, Search for Agents using the search bar</p>
        <div class="row">
            <form action="index.php" class="form-inline col-md-6" role="form" method="get">
                <div class="form-group">
                    <input type="text" name="search" class="form-control" placeholder="Search">
                    <button type="submit" name="submit-search" class="btn btn-default form-control">
                        <i class="material-icons">search</i></button>
                        <?php
                if (isset($_GET['submit-search'])) {
                    echo "<a href='index.php'><button class='btn btn-info form-control'>" . $_GET['search'] . " &times; </button></a>";
                }
                ?>

                </div>
            </form>
                  
            <div class="col-md-6">
            <a href="add.php" class="col-md-6">
                <button class="btn btn-success pull-right">Add Agents</button>
            </a>
            </div>
        </div>
        <table class="table my-5">
            <thead class="thead-dark">
            <tr>
                <th scope="col">#</th>
                <th scope="col">Agent Name</th>
                <th scope="col">Email</th>
                <th scope="col">Phone Number</th>
                <th scope="col">status</th>
                <th scope="col">Operations</th>
            </tr>
            </thead>
            <tbody id="tcontent">
            <?php
            
              $statement = $pdo->prepare("SELECT * FROM `agents`");
              if ($statement->execute()) {
                  $results = $statement->fetchAll();
              } else {
                  echo "<div class='alert alert-info'><i class='material-icons'>face</i> No Records Yet</div>";
              }
              //if search is set display results
              if (isset($_GET['submit-search'])) {
  
                  $search = sanitize($_GET['search']);
  
                  if (empty($search)) {
                      echo "<div class=\"alert alert-warning\"><strong>Warning!</strong> please enter a search term.</div>";
                  } elseif (!empty($search)) {
                      $search_term = "%" . $search . "%";
                      $stm = $pdo->prepare("SELECT * FROM `agents` WHERE (`name` LIKE ? OR `email` LIKE ? OR `phone` LIKE ?)");
                      $stm->execute(array($search_term, $search_term, $search_term, $search_term));
                      $results = $stm->fetchAll();
  
                      if ($stm->rowCount() == 0) {
                          echo "<div class=\"alert alert-warning\"><strong>Warning!</strong> No results found for " . $search . ".</div>";
                      } else {
                          fetchRecords($results);
                      }
                  }
              } else {
                  fetchRecords($results);
              }
            
            ?>
            </tbody>
        </table>
  </main>
<script src="../js/jquery-3.3.1.min.js"></script>
<script src="../js/bootstrap.min.js"></script>
</body>
</html>
<?php
function fetchRecords($records)
{
    $counter = 1;
    foreach ($records as $record) {
   if($record['status'] == 1){
       $status = "active";
   }else{
       $status = "deactivated";
   }
        echo "
        <tr>
        <td scope='col'>{$counter}</td>
        <td scope='col'> {$record['name']}</td>
        <td scope='col'>{$record['email']}</td>
        <td scope='col'>{$record['phone']}</td>
        <td scope='col'>{$status}</td>
        
        <td scope='col'>
        <a href=\"update.php?id={$record['id']}\" class='text-primary'>
                        <i class=\"material-icons\">edit</i>
                    </a>&nbsp;
                    <a href=\"delete.php?id={$record['id']}\" class='text-danger'>
                        <i class=\"material-icons\">delete</i>
                    </a
</td>
</tr>
        ";
        $counter++;
    }
}

function sanitize($data)
{
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

?>

