<?php 
session_start(); 
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Velvet Vogue - Login Processing</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css">
    <style>
        body {
            font-family: "Poppins", serif;
            background: linear-gradient(135deg, #b2d7fe 0%, #e9b2fe 100%);
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }
        .message-container {
            background: #fff;
            padding: 40px;
            border-radius: 15px;
            text-align: center;
            max-width: 400px;
            box-shadow: 0 20px 40px rgba(0,0,0,0.1);
        }
        .message-container h2 {
            color: #d32f2f;
            margin-bottom: 20px;
        }
        .message-container a {
            color: #ff523b;
            text-decoration: none;
            font-weight: bold;
        }
        .message-container a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>

<?php
// Get input safely
$un = $_POST['txtUN'] ?? '';
$pw = $_POST['txtPW'] ?? '';

// Connect to database
$conn = mysqli_connect('localhost', 'root', '', 'velvet_vogue');

if (!$conn) {
    echo "<div class='message-container'>";
    echo "<h2>Database Connection Failed</h2>";
    echo "<p>" . mysqli_connect_error() . "</p>";
    echo "<a href='Login.html'>Go back to login</a>";
    echo "</div>";
    exit();
}

// Sanitize inputs
$un = mysqli_real_escape_string($conn, $un);
$pw = mysqli_real_escape_string($conn, $pw);

// Check user credentials
$query = "SELECT RealName FROM users WHERE Username='$un' AND Password='$pw'";
$result = mysqli_query($conn, $query);

if (mysqli_num_rows($result) > 0) {
    $value = mysqli_fetch_assoc($result);
    $_SESSION['RN'] = $value["RealName"];
    $_SESSION['username'] = $un; // ✅ Store username

    // Log login time
    $rn = $value['RealName'];
    $logQuery = "INSERT INTO LogSch(RealName, Login) VALUES('$rn', NOW())";
    mysqli_query($conn, $logQuery);

    // ✅ Redirect to protected homepage
    header("Location: VVhome.php");
    exit();
} else {
    echo "<div class='message-container'>";
    echo "<h2>Unauthorized Access</h2>";
    echo "<p>Incorrect username or password.<br>Please try again or contact admin if you don’t have an account.</p>";
    echo "<a href='Login.html'>Back to Login</a>";
    echo "</div>";
}
?>

</body>
</html>
