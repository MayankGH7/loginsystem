<?php
include("./partials/_dbconnect.php");
//mysqli_query($connection,"TRUNCATE TABLE accounts");
$showAlert = false;
$warning = false;
if (isset($_POST["signup-submit"])) {
  $username = $_POST["username"];
  $password = $_POST["password"];
  $cpassword = $_POST["cpassword"];
  $outcome = mysqli_query($connection,"SELECT * FROM accounts WHERE username = '$username'");
  if ($password == $cpassword && !empty($username) && !empty($password) && !empty($cpassword) && !(mysqli_num_rows($outcome) >= 1)) {
    $hash = password_hash($password,PASSWORD_DEFAULT);
    $query = "INSERT INTO accounts (sno,username,password,dt) values(NULL,'$username','$hash', CURRENT_TIMESTAMP)";
    $result = mysqli_query($connection, $query);
    if ($result) {
      $showAlert = true;
    }
  } else {
    $warning = true;
  }
}
?>

<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>SignUp</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-4bw+/aepP/YC94hEpVNVgiZdgIC5+VKNBQNGCHeKRQN+PtmoHDEXuppvnDJzQIu9" crossorigin="anonymous">
</head>
<body>
  <?php include("./partials/_nav.php");
  if ($showAlert) {
    echo '<div class="alert alert-success alert-dismissible fade show" role="alert">
  <strong>Success!</strong> Your account has been created successfull you can login now.
  <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>';
  };
  if ($warning) {
    echo '<div class="alert alert-danger alert-dismissible fade show" role="alert">
  <strong>Error!</strong> An error occured.
  <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>';
  }
  ?>



  <div class="container p-3">
    <h1 style="margin:10px 0" class="text-center">SignUp To Our Website</h1>
    <form action="./signup.php" method="post">
      <div class="mb-3 ">
        <label for="username" class="form-label">Username<span class="text-danger">*</span></label>
        <input type="text" class="form-control" id="username" name="username" maxlength="11" aria-describedby="usernameHelp">
        <?php
        if (isset($_POST["signup-submit"])) {
          if (empty($_POST["username"])) {
            echo "<span class='text-danger'>Username cannot be empty.</span>";
          }
          // check if username already exists
         
         if(mysqli_num_rows($outcome) >= 1){
            echo "<span class='text-danger'>Username already exists.</span>";
          }
        };
        ?>
      </div>
      <div class="mb-3 ">
        <label for="password" class="form-label">Password<span class="text-danger">*</span></label>
        <input type="password" class="form-control" id="password" maxlength="27" name="password">
            <?php 
    if(isset($_POST["signup-submit"])){
      if(empty($_POST["password"])){
        echo "<span class='text-danger'>Passoword cannot be empty.</span>";
      }
    };
    ?>
      </div>
      <div class="mb-3 ">
        <label for="cpassword" class="form-label">Confirm Password<span class="text-danger">*</span></label>
        <input type="text" class="form-control" id="cpassword" name="cpassword">
            <?php 
    if(isset($_POST["signup-submit"])){
      if(empty($_POST["cpassword"])){
        echo "<span class='text-danger'>Password cannot be empty.</span>";
      };
      if(!($password == $cpassword)){
        echo '<span class="text-danger">Password did not match.</span>';
      }
    };
    ?>
        <div id="emailHelp" class="form-text">
          Make sure to type the same password.
        </div>
      </div>
      <button type="submit" class="btn btn-primary" name="signup-submit" style="width:100%;">SignUp</button>
    </form>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-HwwvtgBNo3bZJJLYd8oVXjrBZt8cqVSpeBNS5n7C8IVInixGAoxmnlMuBnhbgrkm" crossorigin="anonymous"></script>
</body>
</html>