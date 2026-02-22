<?php
session_start();
// Check if admin is logged in - only logged in admins can register new admins
if (!isset($_SESSION['admin_logged_in'])) {
    header("Location: admin_login.php");
    exit();
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>Admin Registration</title>
    <style type="text/css">
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }
        .header {
            background-color: #007bff;
            color: white;
            padding: 15px;
            text-align: center;
        }
        .nav {
            background-color: #333;
            overflow: hidden;
        }
        .nav a {
            float: left;
            display: block;
            color: white;
            text-align: center;
            padding: 14px 20px;
            text-decoration: none;
        }
        .nav a:hover {
            background-color: #ddd;
            color: black;
        }
        .register-container {
            max-width: 400px;
            margin: 50px auto;
            background: white;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }
        .register-header {
            text-align: center;
            margin-bottom: 30px;
            color: #333;
        }
        .form-group {
            margin-bottom: 20px;
        }
        .form-group label {
            display: block;
            margin-bottom: 5px;
            font-weight: bold;
            color: #555;
        }
        .form-group input {
            width: 100%;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 5px;
            font-size: 16px;
        }
        .btn {
            width: 100%;
            padding: 12px;
            background-color: #28a745;
            color: white;
            border: none;
            border-radius: 5px;
            font-size: 16px;
            cursor: pointer;
        }
        .btn:hover {
            background-color: #218838;
        }
        .btn-secondary {
            background-color: #6c757d;
            margin-top: 30px;
            display: block;
            text-align: center;
            text-decoration: none;
            width: 200px;
            margin-left: auto;
            margin-right: auto;
        }
        .btn-secondary:hover {
            background-color: #5a6268;
        }
        .error {
            color: red;
            text-align: center;
            margin-bottom: 20px;
        }
        .success {
            color: green;
            text-align: center;
            margin-bottom: 20px;
        }
        .info {
            background-color: #d1ecf1;
            color: #0c5460;
            padding: 10px;
            border-radius: 5px;
            margin-bottom: 20px;
            text-align: center;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>Register New Admin</h1>
        <p>Logged in as: <?php echo $_SESSION['admin_username']; ?></p>
    </div>
    
    <div class="nav">
        <a href="admin_dashboard.php">Dashboard</a>
        <a href="admin_products.php">Manage Products</a>
        <a href="admin_orders.php">View Orders</a>
        <a href="admin_register.php">Register Admin</a>
    </div>
    
    <div class="register-container">
        <div class="register-header">
            <h2>Register New Admin</h2>
        </div>
        
        <?php
        if (isset($_POST['btnRegister'])) {
            $username = $_POST['username'];
            $password = $_POST['password'];
            $confirm_password = $_POST['confirm_password'];
            
            if ($password != $confirm_password) {
                echo '<div class="error">Passwords do not match!</div>';
            } else {
                $conn = mysqli_connect('localhost', 'root', '', 'velvet_vogue');
                
                if (!$conn) {
                    echo '<div class="error">Database connection failed!</div>';
                } else {
                    // Check if username already exists
                    $check_query = "SELECT * FROM admin_users WHERE username='$username'";
                    $check_result = mysqli_query($conn, $check_query);
                    
                    if (mysqli_num_rows($check_result) > 0) {
                        echo '<div class="error">Username already exists!</div>';
                    } else {
                        $query = "INSERT INTO admin_users (username, password) VALUES ('$username', '$password')";
                        
                        if (mysqli_query($conn, $query)) {
                            echo '<div class="success">New admin registered successfully!</div>';
                        } else {
                            echo '<div class="error">Registration failed!</div>';
                        }
                    }
                }
            }
        }
        ?>
        
        <form method="post" action="">
            <div class="form-group">
                <label for="username">Username:</label>
                <input type="text" id="username" name="username" required>
            </div>
            
            <div class="form-group">
                <label for="password">Password:</label>
                <input type="password" id="password" name="password" required>
            </div>
            
            <div class="form-group">
                <label for="confirm_password">Confirm Password:</label>
                <input type="password" id="confirm_password" name="confirm_password" required>
            </div>
            
            <button type="submit" name="btnRegister" class="btn">Register Admin</button>
            <a href="admin_dashboard.php" class="btn btn-secondary">Back to Dashboard</a>
        </form>
    </div>
</body>
</html>