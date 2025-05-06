<?php
// signup.php
include 'db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $first_name = $_POST["first_name"];
    $last_name = $_POST["last_name"];
    $username = $_POST["username"];
    $email = $_POST["email"];
    $password = password_hash($_POST["password"], PASSWORD_DEFAULT);

    // Check if the username already exists
    $check_username_sql = "SELECT * FROM users WHERE username = '$username'";
    $result = $conn->query($check_username_sql);

    if ($result->num_rows > 0) {
        $error = "Username already taken, please choose a different one.";
    } else {
        // Proceed with inserting the new user
        $sql = "INSERT INTO users (first_name, last_name, username, email, password) 
                VALUES ('$first_name', '$last_name', '$username', '$email', '$password')";

        if ($conn->query($sql) === TRUE) {
            header("Location: login.php");
            exit();
        } else {
            $error = "Error: " . $conn->error;
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign Up</title>
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
            width: 60px;
            height: 60px;
            border-radius: 50%; /* Makes the logo circular */
            object-fit: cover;
        }
        h2 {
            text-align: center;
            font-weight: bold;
            margin-bottom: 20px;
        }
        label {
            display: block;
            text-align: left;
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
            margin: 5px 0;
            text-align: center;
            color: red;
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
            <h2>Sign Up</h2>
            <?php if(isset($error)) { echo '<p class="error">'.$error.'</p>'; } ?>
            <form action="signup.php" method="POST">
                <label>First Name</label>
                <input type="text" name="first_name" placeholder="Enter your first name" required>
                
                <label>Last Name</label>
                <input type="text" name="last_name" placeholder="Enter your last name" required>
                
                <label>Username</label>
                <input type="text" name="username" placeholder="Choose a username" required>
                
                <label>Email</label>
                <input type="email" name="email" placeholder="Enter your email" required>
                
                <label>Password</label>
                <input type="password" name="password" placeholder="Choose a password" required>
                
                <button type="submit">REGISTER</button>
            </form>
            <p style="text-align:center;">Already have an account? <a href="login.php">Log in now</a></p>
        </div>
    </div>
</body>
</html>
