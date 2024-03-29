<?php
// Database configuration for dsports
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "dsports";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
<?php
include('db_connection.php');

// Process form data
$successMessage = '';
$errorMessages = array();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $password = mysqli_real_escape_string($conn, $_POST['password']); // Store the plain text password
    $usertype = mysqli_real_escape_string($conn, $_POST['usertype']);

    // Check if the username already exists
    $checkUsernameQuery = "SELECT * FROM c_login WHERE c_username = '$username'";
    $checkUsernameResult = $conn->query($checkUsernameQuery);

    if ($checkUsernameResult->num_rows > 0) {
        $errorMessages[] = "Username already exists. Please choose a different one.";
    } else {
        // Insert data into the 'c_login' table
        $sql = "INSERT INTO c_login (c_username, c_password, c_usertype) VALUES ('$username', '$password', '$usertype')";

        if ($conn->query($sql) === TRUE) {
            $successMessage = "Registration successful!";

            // Retrieve the last inserted ID
            $lastInsertedId = $conn->insert_id;

            // Based on the user type, insert data into the respective table
            switch ($usertype) {
                case "student":
                    $studentSql = "INSERT INTO c_student (c_username, c_password, status, c_student_id) VALUES ('$username', '$password', 'active', '$lastInsertedId')";
                    if ($conn->query($studentSql) !== TRUE) {
                        echo "Error inserting into c_student table: " . $conn->error;
                    }
                    break;
                case "teacher":
                    $teacherSql = "INSERT INTO c_teacher (c_username, c_password, status, c_teacher_id) VALUES ('$username', '$password', 'active', '$lastInsertedId')";
                    if ($conn->query($teacherSql) !== TRUE) {
                        echo "Error inserting into c_teacher table: " . $conn->error;
                    }
                    break;
                default:
                    // Handle other user types if needed
                    break;
            }

            // Add the following JavaScript code to display a popup message
            echo '<script>
                    setTimeout(function() {
                        alert("Successfully Registered!");
                        document.getElementById("successMessage").style.display = "none";
                    }, 3000);
                  </script>';
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
    }
}

// Display error messages
if (!empty($errorMessages)) {
    echo '<div style="color: red;">';
    foreach ($errorMessages as $errorMessage) {
        echo $errorMessage . '<br>';
    }
    echo '</div>';
}
?>



<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Registration</title>
    <style>

        body {
            font-family: 'Arial', sans-serif;
            margin: 0;
            padding: 0;
            background-color: #E5D599;
        }

       

        main {
            width: 60%;
            margin: 20px auto;
            padding: 20px;
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        form {
            max-width: 400px;
            margin: 0 auto;
        }

        label {
            display: block;
            margin-bottom: 8px;
        }

        input {
            width: 100%;
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }

        button {
            background-color: #5d8aa8;;
            color: #fff;
            padding: 10px 15px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        button:hover {
            background-color: #8e44ad;;
        }

        #home-link {
    color: #fff;
    text-decoration: none;
    font-weight: bold;
    font-size: 18px;
    margin-right: 20px;
    padding: 10px 15px;
    background-color: #5d8aa8;
    border-radius: 5px;
    border: 2px solid #fff; /* Add a border */
    display: inline-block; /* Make the link a block element */
    transition: background-color 0.3s ease;
}

#home-link:hover {
    background-color: #8e44ad;
}


    </style>
    
    <script>
        function validateEmail() {
            var email = document.getElementById("username").value;
            var emailRegex = /^[a-zA-Z0-9._%+-]+@(gmail\.com)$/i;

            var isValid = emailRegex.test(email);
            
            var emailError = document.getElementById("emailError");

            if (!isValid) {
                emailError.textContent = "Invalid email address";
            } else {
                emailError.textContent = "";
            }

            return isValid;
        }

        function validatePassword() {
    var password = document.getElementById("password").value;
    var passwordError = document.getElementById("passwordError");

    // Define the regular expressions for each condition
    var lengthRegex = /.{8,12}/;  // Password length between 8 and 12 characters
    var uppercaseRegex = /[A-Z]/;  // At least one uppercase letter
    var lowercaseRegex = /[a-z]/;  // At least one lowercase letter
    var numberRegex = /\d/;  // At least one digit
    var specialSymbolRegex = /[!@#$%^&*(),.?":{}|<>]/;  // At least one special symbol

    // Check each condition
    var isLengthValid = lengthRegex.test(password);
    var isUppercaseValid = uppercaseRegex.test(password);
    var isLowercaseValid = lowercaseRegex.test(password);
    var isNumberValid = numberRegex.test(password);
    var isSpecialSymbolValid = specialSymbolRegex.test(password);

    // Display error messages for each condition if not met
    passwordError.textContent = "";
    if (!isLengthValid) {
        passwordError.textContent += "Password must be between 8 and 12 characters. ";
    }
    if (!isUppercaseValid) {
        passwordError.textContent += "Password must contain at least one uppercase letter. ";
    }
    if (!isLowercaseValid) {
        passwordError.textContent += "Password must contain at least one lowercase letter. ";
    }
    if (!isNumberValid) {
        passwordError.textContent += "Password must contain at least one number. ";
    }
    if (!isSpecialSymbolValid) {
        passwordError.textContent += "Password must contain at least one special symbol. ";
    }

    // Return true only if all conditions are met
    return isLengthValid && isUppercaseValid && isLowercaseValid && isNumberValid && isSpecialSymbolValid;
}

    </script>
</head>

<body>

    <header>
    <a href="admin_dash.php" id="home-link">Admin Home</a>
        <h1></h1>
    </header>

    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post" onsubmit="return validateEmail() && validatePassword()" autocomplete="off">
            <label for="username">Username:</label>
            <input type="email" id="username" name="username" required oninput="validateEmail()">
            <span id="emailError" style="color: red;"></span>

            <label for="password">Password:</label>
            <input type="password" id="password" name="password" required oninput="validatePassword()">
            <span id="passwordError" style="color: red;"></span>

            <label for="usertype">Usertype:</label>
<select id="usertype" name="usertype" required>
    <option value="student">student</option>
    <option value="teacher">teacher</option>
    
   
</select>

            <button type="submit">Register</button>
        </form>
        <div id="successMessage" style="display: <?php echo $successMessage ? 'block' : 'none'; ?>">
            <?php echo $successMessage; ?>
        </div>
    </main>

</body>

</html>