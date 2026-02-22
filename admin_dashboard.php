<?php
session_start();
if (!isset($_SESSION['admin_logged_in'])) {
    header("Location: admin_login.php");
    exit();
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>Admin Dashboard</title>
    <style type="text/css">
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f4;
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
        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 20px;
        }
        .dashboard-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 20px;
            margin-bottom: 30px;
        }
        .card {
            background: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
        }
        .card h3 {
            margin-top: 0;
            color: #333;
        }
        .stat-number {
            font-size: 2em;
            font-weight: bold;
            color: #007bff;
        }
        .btn {
            background-color: #007bff;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            text-decoration: none;
            display: inline-block;
            margin: 5px;
        }
        .btn:hover {
            background-color: #0056b3;
        }
        .btn-success {
            background-color: #28a745;
        }
        .btn-success:hover {
            background-color: #218838;
        }
        .btn-warning {
            background-color: #ffc107;
        }
        .btn-warning:hover {
            background-color: #e0a800;
        }
        .logout {
            float: right;
            background-color: #dc3545;
        }
        .logout:hover {
            background-color: #c82333;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>Admin Dashboard</h1>
        <p>Welcome, <?php echo $_SESSION['admin_username']; ?>!</p>
        <a href="admin_logout.php" class="btn logout">Logout</a>
    </div>
    
    <div class="nav">
        <a href="admin_dashboard.php">Dashboard</a>
        <a href="admin_products.php">Manage Products</a>
        <a href="admin_orders.php">View Orders</a>
        <a href="admin_register.php">Admin Registration</a>
    </div>
    
    <div class="container">
        <div class="dashboard-grid">
            <?php
            $conn = mysqli_connect('localhost', 'root', '', 'velvet_vogue');
            
            if ($conn) {
                // Get total products
                $product_query = "SELECT COUNT(*) as total FROM products";
                $product_result = mysqli_query($conn, $product_query);
                $product_count = mysqli_fetch_assoc($product_result)['total'];
                
                // Get total cart items
                $cart_query = "SELECT COUNT(*) as total FROM cart";
                $cart_result = mysqli_query($conn, $cart_query);
                $cart_count = mysqli_fetch_assoc($cart_result)['total'];
                
                // Get low stock products
                $low_stock_query = "SELECT COUNT(*) as total FROM products WHERE stock_quantity < 10";
                $low_stock_result = mysqli_query($conn, $low_stock_query);
                $low_stock_count = mysqli_fetch_assoc($low_stock_result)['total'];
                
                // Get recent orders/cart activity
                $recent_query = "SELECT COUNT(*) as total FROM cart WHERE DATE(added_at) = CURDATE()";
                $recent_result = mysqli_query($conn, $recent_query);
                $recent_count = mysqli_fetch_assoc($recent_result)['total'];
            ?>
            
            <div class="card">
                <h3>Total Products</h3>
                <div class="stat-number"><?php echo $product_count; ?></div>
                <a href="admin_products.php" class="btn">Manage Products</a>
            </div>
            
            <div class="card">
                <h3>Cart Items</h3>
                <div class="stat-number"><?php echo $cart_count; ?></div>
                <a href="admin_orders.php" class="btn">View Orders</a>
            </div>
            
            <div class="card">
                <h3>Low Stock Products</h3>
                <div class="stat-number"><?php echo $low_stock_count; ?></div>
                <a href="admin_products.php?filter=low_stock" class="btn btn-warning">Check Stock</a>
            </div>
            
            <div class="card">
                <h3>Today's Activity</h3>
                <div class="stat-number"><?php echo $recent_count; ?></div>
                <a href="admin_orders.php?filter=today" class="btn btn-success">View Today</a>
            </div>
            
            <?php
            } else {
                echo '<div class="card"><h3>Database Error</h3><p>Unable to connect to database</p></div>';
            }
            ?>
        </div>
        
        <div class="card">
            <h3>Quick Actions</h3>
            <a href="admin_add_product.php" class="btn btn-success">Add New Product</a>
            <a href="admin_products.php" class="btn">View All Products</a>
            <a href="admin_orders.php" class="btn">View All Orders</a>
        </div>
    </div>
</body>
</html>