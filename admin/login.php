<?php
// login.php
include 'db.php';
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST["username"];
    $password = $_POST["password"];

    $sql = "SELECT * FROM users WHERE username='$username'";
    $result = $conn->query($sql);

    if ($result->num_rows == 1) {
        $user = $result->fetch_assoc();
        if (password_verify($password, $user["password"])) {
            $_SESSION["user"] = $user["username"];
            header("Location: dashboard.php");
            exit();
        } else {
            $error = "Incorrect password!";
        }
    } else {
        $error = "User not found!";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Login</title>
  <style>
    body {
        font-family: Arial, sans-serif;
        background-color: #8B6F3F;
        display: flex;
        justify-content: center;
        align-items: center;
        height: 100vh;
        margin: 0;
    }
    .container {
        width: 100%;
        max-width: 400px;
    }
    .form-box {
        background: #f2f2f2;
        padding: 20px;
        border-radius: 10px;
        box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
    }
    .logo-container {
        display: flex;
        align-items: center;
    }
    .logo {
        width: 80px;
        height: 80px;
        border-radius: 50%; /* Makes the logo a circle */
        object-fit: cover;
    }
    h2 {
        text-align: center;
        font-weight: bold;
        margin-bottom: 20px;
    }
    label {
        display: block;
        margin-top: 10px;
        font-size: 14px;
    }
    input {
        width: 100%;
        padding: 10px;
        margin-top: 5px;
        margin-bottom: 10px;
        border: 1px solid #ccc;
        border-radius: 5px;
    }
    button {
        background-color: #A67C52;
        color: #fff;
        width: 100%;
        padding: 10px;
        margin-top: 10px;
        border: none;
        border-radius: 5px;
        cursor: pointer;
        font-size: 16px;
    }
    button:hover {
        background-color: #8C6842;
    }
    .forgot {
        font-size: 12px;
        margin: 5px 0;
        text-align: left;
    }
    .error {
        font-size: 12px;
        color: red;
        margin: 5px 0;
        text-align: center;
    }
    a {
        color: #007BFF;
        text-decoration: none;
    }
    a:hover {
        text-decoration: underline;
    }
  </style>
</head>
<body>
  <div class="container">
      <div class="form-box">
          <div class="logo-container">
              <img src="logo.png" alt="Logo" class="logo">
          </div>
          <h2>Login</h2>
          <?php if(isset($error)) { echo '<p class="error">'.$error.'</p>'; } ?>
          <form action="login.php" method="POST">
              <label>username</label>
              <input type="text" name="username" placeholder="Enter your Email" required>
              
              <label>Password</label>
              <input type="password" name="password" placeholder="Enter your password" required>
              
              <p class="forgot"><a href="forgot.php">Forgot password?</a></p>
              <button type="submit">LOGIN</button>
          </form>
          <p style="text-align:center;">Not a member? <a href="signup.php">Sign up now</a></p>
      </div>
  </div>
</body>
</html>
