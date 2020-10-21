<?php
    session_start();
    if(!isset($_SESSION['login_user2'])){
    header("location: customerlogin.php"); 
    }
?>
<html>

<head>
  <title>FoodShala Explore </title>

  <link rel="stylesheet" type="text/css" href="css/index.css">
  <!-- <link rel="stylesheet" type = "text/css" href ="css/foodlist.css"> -->
  <link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@200&display=swap" rel="stylesheet">
  <script type="text/javascript" src="js/jquery.min.js"></script>
  <script type="text/javascript" src="js/bootstrap.min.js"></script>

</head>




<body class="bodyNew">
  <nav class="navbar navbar-inverse navbar-fixed-top navigation-clean-search" role="navigation">
    <div class="container">
      <div class="navbar-header">
        <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#myNavbar">
          <span class="sr-only">Toggle navigation</span>
          <span class="icon-bar"></span>
          <span class="icon-bar"></span>
          <span class="icon-bar"></span>
        </button>
        <a class="navbar-brand" href="index.php">FoodShala</a>
      </div>

      <div class="collapse navbar-collapse " id="myNavbar">
        <ul class="nav navbar-nav">
          <li><a href="index.php">Home</a></li>
         

        </ul>

        <?php
if(isset($_SESSION['login_user1'])){

?>


        <ul class="nav navbar-nav navbar-right">
          <li><a href="#"></span> Welcome <?php echo $_SESSION['login_user1']; ?> </a></li>
          <li><a href="myrestaurant.php">Manage Restaurant</a></li>
          <li><a href="logout_m.php"><span class="glyphicon glyphicon-log-out"></span> Log Out </a></li>
        </ul>
        <?php
}
else if (isset($_SESSION['login_user2'])) {
  ?>
        <ul class="nav navbar-nav navbar-right">
          <li><a href="#"></span> Welcome <?php echo $_SESSION['login_user2']; ?> </a></li>
          <li class="active"><a href="index.php"> Food Zone </a></li>
          <li><a href="cart.php"> Cart (<?php
              if(isset($_SESSION["cart"])){
              $count = count($_SESSION["cart"]); 
              echo "$count"; 
            }
              else
                echo "0";
              ?>) </a></li>
          <li><a href="logout_u.php"><span class="glyphicon glyphicon-log-out"></span> Log Out </a></li>
        </ul>
        <?php        
}
else {

  ?>

        <ul class="nav navbar-nav navbar-right">
          <li><a href="#" class="dropdown-toggle active" data-toggle="dropdown" role="button" aria-haspopup="true"
              aria-expanded="false"></span> Sign Up <span class="caret"></span> </a>
            <ul class="dropdown-menu">
              <li> <a href="customersignup.php"> User Sign-up</a></li>
              <li> <a href="managersignup.php"> Manager Sign-up</a></li>
              <li> <a href="#"> Admin Sign-up</a></li>
            </ul>
          </li>

          <li><a href="#" class="dropdown-toggle active" data-toggle="dropdown" role="button" aria-haspopup="true"
              aria-expanded="false"> Login <span class="caret"></span></a>
            <ul class="dropdown-menu">
              <li> <a href="customerlogin.php"> User Login</a></li>
              <li> <a href="managerlogin.php"> Manager Login</a></li>
              <li> <a href="#"> Admin Login</a></li>
            </ul>
          </li>
        </ul>

        <?php
}
?>


      </div>

    </div>
  </nav>


  <div >
    <div class="container text-center">
      <h1 class="titulo">Welcome To FoodShala</h1>
      <!--p>Let food be thy medicine and medicine be thy food</p-->
    </div>
  </div>




  <div class="container" style="width:95%;">

    <!-- Display all Food from food table -->
    <?php

require 'connection.php';
$conn = Connect();

$sql = "SELECT * FROM food WHERE options = 'ENABLE' ORDER BY F_ID";
$result = mysqli_query($conn, $sql);

if (mysqli_num_rows($result) > 0)
{
  $count=0;

  while($row = mysqli_fetch_assoc($result)){
    if ($count == 0)
      echo "<div class='row'>";
?>
    <div class="col-md-3">
      <form method="post" action="cart.php?action=add&id=<?php echo $row["F_ID"];?>">
        <div class="mypanel food-card">
          <img src="<?php echo $row["images_path"]; ?>" class="img-responsive food-image">
          <h4 class="text-dark"><?php echo $row["name"]; ?></h4>
          <h5 class="text-info"><?php echo $row["description"]; ?></h5>
          <div class="form-control1">
            <h5 class="food-price">&#8377; <?php echo $row["price"]; ?>/-</h5>
            <h5 class="text-info">Quantity: <input type="number" min="1" max="25" name="quantity" class="form-control" value="1" style="width: 60px;"> </h5>
                <input type="hidden" name="hidden_name" value="<?php echo $row["name"]; ?>">
                <input type="hidden" name="hidden_price" value="<?php echo $row["price"]; ?>">
                <input type="hidden" name="hidden_RID" value="<?php echo $row["R_ID"]; ?>">
            <input type="submit" name="add" style="margin-top:5px;" class="btn btn-success" value="Order">
          </div>

        </div>
      </form>
    </div>
    <script>
                      $("form").on("submit", function (e) {
          var dataString = $(this).serialize();
          
          $.ajax({
            type: "POST",
            url: "/Online-Food-Order/cart.php",
            data: dataString,
            success: function () {
              window.load(/Online-Food-Order/cart.php);
            }
          });
      
          e.preventDefault();
});
    </script>
    <?php
$count++;
if($count==4)
  {
    echo "</div>";
    $count=0;
  }
}
?>

  </div>
  </div>
  <?php
}
else
{
  ?>

  <div class="container">
    <div class="jumbotron">
      <center>
        <label style="margin-left: 5px;color: red;">
          <h1>Oops! No food is available.</h1>
        </label>
      </center>

    </div>
  </div>

  <?php

}

?>


</body>

</html>