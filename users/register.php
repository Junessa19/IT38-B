<?php
require 'db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = trim($_POST["username"]);
    $email = trim($_POST["email"]);
    $password = password_hash($_POST["password"], PASSWORD_DEFAULT);

    $stmt = $conn->prepare("INSERT INTO users (username, email, password) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $username, $email, $password);

    if ($stmt->execute()) {
        header("Location: login.php");
        exit();
    } else {
        $error = "Registration failed. Try again.";
    }

    $stmt->close();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Register</title>
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
        justify-content: center;
        margin-bottom: 15px;
    }
    .logo {
        width: 80px;
        height: 80px;
        border-radius: 50%;
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
        <img src="logo.png" alt="Logo" class="logo" />
      </div>
      <h2>Register</h2>
      <?php if (isset($error)) echo "<p class='error'>$error</p>"; ?>
      <form method="POST" action="register.php">

      <label>First name</label>
        <input type="text" name="username" placeholder="Enter your username" required />

        <label>Last name</label>
        <input type="text" name="username" placeholder="Enter your username" required />

        <label>Username</label>
        <input type="text" name="username" placeholder="Enter your username" required />

        <label>Email</label>
        <input type="email" name="email" placeholder="Enter your email" required />

        <label>Password</label>
        <input type="password" name="password" placeholder="Create a password" required />

        <button type="submit">REGISTER</button>
      </form>
      <p style="text-align:center;">Already have an account? <a href="login.php">Login here</a></p>
    </div>
  </div>
</body>
</html>
