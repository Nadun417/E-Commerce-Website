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
    <title>Add New Product</title>
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
            max-width: 800px;
            margin: 20px auto;
            background: white;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
        }
        .form-group {
            margin-bottom: 20px;
        }
        .form-group label {
            display: block;
            margin-bottom: 5px;
            font-weight: bold;
            color: #333;
        }
        .form-group input,
        .form-group select,
        .form-group textarea {
            width: 100%;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 5px;
            font-size: 16px;
        }
        .form-group textarea {
            height: 100px;
            resize: vertical;
        }
        .btn {
            background-color: #007bff;
            color: white;
            padding: 12px 30px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
            margin-right: 10px;
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
        .btn-secondary {
            background-color: #6c757d;
        }
        .btn-secondary:hover {
            background-color: #5a6268;
        }
        .success {
            color: green;
            background-color: #d4edda;
            border: 1px solid #c3e6cb;
            padding: 10px;
            border-radius: 5px;
            margin-bottom: 20px;
        }
        .error {
            color: red;
            background-color: #f8d7da;
            border: 1px solid #f5c6cb;
            padding: 10px;
            border-radius: 5px;
            margin-bottom: 20px;
        }
        .form-row {
            display: flex;
            gap: 20px;
        }
        .form-row .form-group {
            flex: 1;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>Add New Product</h1>
    </div>
    
    <div class="nav">
        <a href="admin_dashboard.php">Dashboard</a>
        <a href="admin_products.php">Manage Products</a>
        <a href="admin_orders.php">View Orders</a>
    </div>
    
    <div class="container">
        <h2>Add New Product</h2>
        
        <?php
        $conn = mysqli_connect('localhost', 'root', '', 'velvet_vogue');
        
        if (isset($_POST['btnAdd'])) {
            $product_name = $_POST['product_name'];
            $price = $_POST['price'];
            $description = $_POST['description'];
            $main_image = $_POST['main_image'];
            $category = $_POST['category'];
            $stock_quantity = $_POST['stock_quantity'];
            
            if (!$conn) {
                echo '<div class="error">Database connection failed!</div>';
            } else {
                $query = "INSERT INTO products (product_name, price, description, main_image, category, stock_quantity) 
                         VALUES ('$product_name', '$price', '$description', '$main_image', '$category', '$stock_quantity')";
                
                if (mysqli_query($conn, $query)) {
                    echo '<div class="success">Product added successfully!</div>';
                } else {
                    echo '<div class="error">Error adding product: ' . mysqli_error($conn) . '</div>';
                }
            }
        }
        ?>
        
        <form method="post" action="">
            <div class="form-group">
                <label for="product_name">Product Name:</label>
                <input type="text" id="product_name" name="product_name" required>
            </div>
            
            <div class="form-row">
                <div class="form-group">
                    <label for="price">Price:</label>
                    <input type="number" id="price" name="price" step="0.01" min="0" required>
                </div>
                
                <div class="form-group">
                    <label for="stock_quantity">Stock Quantity:</label>
                    <input type="number" id="stock_quantity" name="stock_quantity" min="0" required>
                </div>
            </div>
            
            <div class="form-group">
                <label for="category">Category:</label>
                <input type="text" id="category" name="category" placeholder="e.g., Electronics, Clothing, Books">
            </div>
            
            <div class="form-group">
                <label for="main_image">Main Image URL:</label>
                <input type="url" id="main_image" name="main_image" placeholder="https://example.com/image.jpg">
            </div>
            
            <div class="form-group">
                <label for="description">Description:</label>
                <textarea id="description" name="description" placeholder="Enter product description..."></textarea>
            </div>
            
            <div class="form-group">
                <button type="submit" name="btnAdd" class="btn btn-success">Add Product</button>
                <button type="reset" class="btn btn-secondary">Clear</button>
                <a href="admin_products.php" class="btn">Back to Products</a>
            </div>
        </form>
    </div>
</body>
</html>