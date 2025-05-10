<?php
// Include database connection file
include 'db.php'; 
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = trim($_POST["username"]);
    $first_name = trim($_POST["first_name"]);
    $last_name = trim($_POST["last_name"]);
    $email = trim($_POST["email"]);
    $raw_password = $_POST["password"];
    $raw_confirm_password = $_POST["confirm_password"];

    // Check if passwords match
    if ($raw_password !== $raw_confirm_password) {
        $error = "Passwords do not match!";
    } else {
        // Check if username or email already exists
        $check_stmt = $conn->prepare("SELECT id FROM users WHERE username = ? OR email = ?");
        $check_stmt->bind_param("ss", $username, $email);
        $check_stmt->execute();
        $check_stmt->store_result();

        if ($check_stmt->num_rows > 0) {
            $error = "Username or email already exists!";
        } else {
            $password = password_hash($raw_password, PASSWORD_DEFAULT);

            // Insert new user
            $stmt = $conn->prepare("INSERT INTO users (username, first_name, last_name, email, password) VALUES (?, ?, ?, ?, ?)");
            $stmt->bind_param("sssss", $username, $first_name, $last_name, $email, $password);

            if ($stmt->execute()) {
                header("Location: login.php");
                exit();
            } else {
                $error = "Registration failed. Try again.";
            }

            $stmt->close();
        }

        $check_stmt->close();
    }
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
        width: 90%;
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
        <label>Username</label>
        <input type="text" name="username" placeholder="Enter your username" required />

        <label>First Name</label>
        <input type="text" name="first_name" placeholder="Enter your first name" required />

        <label>Last Name</label>
        <input type="text" name="last_name" placeholder="Enter your last name" required />

        <label>Email</label>
        <input type="email" name="email" placeholder="Enter your email" required />

        <label>Password</label>
        <input type="password" name="password" placeholder="Create a password" required />

        <label>Confirm Password</label>
        <input type="password" name="confirm_password" placeholder="Confirm your password" required />

        <button type="submit">REGISTER</button>
      </form>
      <p style="text-align:center;">Already have an account? <a href="login.php">Login here</a></p>
    </div>
  </div>
</body>
</html>
