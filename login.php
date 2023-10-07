<?php
//mysqli_query($connection,"TRUNCATE TABLE accounts");
$warning = false;
if (isset($_POST["login-submit"]) && !empty($_POST["username"]) && !empty($_POST["password"])) {
  include("./partials/_dbconnect.php");
  $username = $_POST["username"];
  $password = $_POST["password"];
  $outcome = mysqli_query($connection,"SELECT * FROM accounts WHERE username = '$username'");
  $row = mysqli_fetch_assoc($outcome);
  if ((mysqli_num_rows($outcome) == 1) && password_verify($password,$row["password"])) {
    session_start();
    $_SESSION["loggedin"] = true;
    $_SESSION["username"] = $username;
    header("location:./welcome.php");
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
  <title>Login</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-4bw+/aepP/YC94hEpVNVgiZdgIC5+VKNBQNGCHeKRQN+PtmoHDEXuppvnDJzQIu9" crossorigin="anonymous">
</head>
<body>
  <?php include("./partials/_nav.php");
  if ($warning) {
    echo '<div class="alert alert-danger alert-dismissible fade show" role="alert">
  <strong>Error!</strong> Invalid username and password.
  <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>';
  };
  ?>
  <div class="container p-3">
    <h1 style="margin:10px 0" class="text-center">Login To Our Website</h1>
    <form action="./login.php" method="post">
      <div class="mb-3 ">
        <label for="username" class="form-label">Username<span class="text-danger">*</span></label>
        <input type="text" class="form-control" id="username" name="username" aria-describedby="usernameHelp">
        <?php
        if (isset($_POST["login-submit"])) {
          if (empty($_POST["username"])) {
            echo "<span class='text-danger'>Username cannot be empty.</span>";
          }
        };
        ?>
      </div>
      <div class="mb-3 ">
        <label for="password" class="form-label">Password<span class="text-danger">*</span></label>
        <input type="password" class="form-control" id="password" name="password">
            <?php 
    if(isset($_POST["login-submit"])){
      if(empty($_POST["password"])){
        echo "<span class='text-danger'>Passoword cannot be empty.</span>";
      }
    };
    ?>
      </div>
      <button type="submit" class="btn btn-primary" name="login-submit" style="width:100%;">Login</button>
    </form>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-HwwvtgBNo3bZJJLYd8oVXjrBZt8cqVSpeBNS5n7C8IVInixGAoxmnlMuBnhbgrkm" crossorigin="anonymous"></script>
</body>
</html>