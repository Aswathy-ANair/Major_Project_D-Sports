<?php
$host = "localhost";
$user = "root";
$password = "";
$db = "dsports";

session_start();

$data = mysqli_connect($host, $user, $password, $db);

if ($data === false) {
    die("Connection error: " . mysqli_connect_error());
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST["username"];
    $password = $_POST["password"];

    $sql = "SELECT * FROM c_login WHERE c_username='" . $username . "' AND c_password='" . $password . "' AND status='active'";


    $result = mysqli_query($data, $sql);

    if (!$result) {
        die("Query failed: " . mysqli_error($data));
    }

    $row = mysqli_fetch_array($result);

    if ($row) {
    $userType = $row["c_usertype"];
    $_SESSION["c_username"] = $username;

    switch ($userType) {
        case "student":
            header("location: student_home.php");
            break;
        case "admin":
            header("location: admin_dash.php");
            break;
        case "teacher":
            header("location: teacher_home.php");
            break;
        default:
            echo "Invalid user type";
            break;
    }
} else {
    echo '<script>alert("Invalid credentials");</script>';
}
}
?>



<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Form</title>
    <style>
        body {
			background-image: url('img/login.jpg');
            font-family: 'Times New Roman', serif;
        }

        center {
            margin-top: 50px;
        }

        h1 {
            color: #333;
        }

        .login-container {
            background-color: #e0e0e0;
            width: 400px;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        label {
            display: block;
            margin: 10px 0 5px;
            color: #555;
        }

        input[type="text"],
        input[type="password"] {
            width: 100%;
            padding: 10px;
            margin-bottom: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
            box-sizing: border-box;
        }

        input[type="submit"] {
            background-color: #4CAF50;
            color: white;
            padding: 10px 15px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        input[type="submit"]:hover {
            background-color: #45a049;
        }

        /* Additional styling */
        img {
            height: 100%;
            width: 100%;
        }

        body {
            margin: 0;
            padding: 0;
            font-family: Arial, Helvetica, sans-serif;
        }

        .loginbox {
            width: 320px;
            height: 420px;
            background: #203354;
            color: black;
            top: 70%;
            left: 50%;
            position: absolute;
            transform: translate(-50%, -50%);
            box-sizing: border-box;
            padding: 70px 30px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        h1 {
            margin: 0;
            padding: 0 0 20px;
            text-align: center;
            font-size: 22px;
            color: white;
        }

        .loginbox p {
            margin: 0;
            padding: 0;
            font-weight: bold;
            color: white;
        }

        .loginbox input {
            width: 100%;
            margin-bottom: 20px;
        }

        .loginbox input[type="text"],
        .loginbox input[type="password"] {
            border: none;
            border-bottom: 1px solid white;
            background: transparent;
            outline: none;
            height: 40px;
            color: white;
            font-size: 16px;
        }

        .loginbox input[type="submit"] {
            border: none;
            outline: none;
            height: 40px;
            background: green;
            color: white;
            font-size: 18px;
            border-radius: 20px;
            cursor: pointer;
        }

        a:link,
        a:visited {
            color: brown;
            background-color: aqua;
            text-decoration: none;
        }

        a:hover {
            color: blueviolet;
        }

        a:active {
            color: yellow;
        }
          
    </style>
</head>

<body>

  
    <center>
       <center>
    <a href="home.php" style="color: navy; background-color:  #e0e0e0; padding: 5px 10px;">Home</a>
</center>


        <div class="loginbox">


            <h1>Login Form</h1>
            <form action="" method="POST" autocomplete="off">
                <label for="username">Username</label>
                <input type="text" name="username" required>

                <label for="password">Password</label>
                <input type="password" name="password" required>

                <input type="submit" value="Login">
                <p class="link">Forgot Passwords<br><br>
                    
                    <p class="liw">Login with Google</p>
            </form>
        </div>
    </center>
	

</body>

</html>






