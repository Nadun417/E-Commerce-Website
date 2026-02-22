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
    <title>Manage Products</title>
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
        .btn-danger {
            background-color: #dc3545;
        }
        .btn-warning {
            background-color: #ffc107;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            background: white;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
        }
        th, td {
            padding: 12px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }
        th {
            background-color: #007bff;
            color: white;
        }
        .product-image {
            width: 50px;
            height: 50px;
            object-fit: cover;
            border-radius: 4px;
        }
        .search-bar {
            margin-bottom: 20px;
        }
        .search-bar input {
            padding: 10px;
            width: 300px;
            border: 1px solid #ddd;
            border-radius: 5px;
        }
        .pagination {
            text-align: center;
            margin-top: 20px;
        }
        .pagination a {
            color: #007bff;
            padding: 8px 16px;
            text-decoration: none;
            border: 1px solid #ddd;
            margin: 0 4px;
        }
        .pagination a:hover {
            background-color: #007bff;
            color: white;
        }
        .low-stock {
            background-color: #fff3cd;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>Manage Products</h1>
    </div>
    
    <div class="nav">
        <a href="admin_dashboard.php">Dashboard</a>
        <a href="admin_products.php">Manage Products</a>
        <a href="admin_orders.php">View Orders</a>
        <a href="admin_register.php">Admin Registration</a>
    </div>
    
    <div class="container">
        <div class="search-bar">
            <a href="admin_add_product.php" class="btn btn-success">Add New Product</a>
            <form method="GET" style="display: inline;">
                <input type="text" name="search" placeholder="Search products..." value="<?php echo isset($_GET['search']) ? $_GET['search'] : ''; ?>">
                <button type="submit" class="btn">Search</button>
            </form>
        </div>
        
        <?php
        $conn = mysqli_connect('localhost', 'root', '', 'velvet_vogue');
        
        if (!$conn) {
            echo '<div style="color: red;">Database connection failed!</div>';
        } else {
            // Handle delete request
            if (isset($_GET['delete'])) {
                $product_id = $_GET['delete'];
                $delete_query = "DELETE FROM products WHERE product_id = '$product_id'";
                
                if (mysqli_query($conn, $delete_query)) {
                    echo '<div style="color: green; margin-bottom: 20px;">Product deleted successfully!</div>';
                } else {
                    echo '<div style="color: red; margin-bottom: 20px;">Error deleting product!</div>';
                }
            }
            
            // Pagination
            $page = isset($_GET['page']) ? $_GET['page'] : 1;
            $records_per_page = 10;
            $offset = ($page - 1) * $records_per_page;
            
            // Search functionality
            $search_condition = '';
            if (isset($_GET['search']) && !empty($_GET['search'])) {
                $search = $_GET['search'];
                $search_condition = "WHERE product_name LIKE '%$search%' OR category LIKE '%$search%'";
            }
            
            // Filter for low stock
            if (isset($_GET['filter']) && $_GET['filter'] == 'low_stock') {
                $search_condition = "WHERE stock_quantity < 10";
            }
            
            // Get total records for pagination
            $total_query = "SELECT COUNT(*) as total FROM products $search_condition";
            $total_result = mysqli_query($conn, $total_query);
            $total_records = mysqli_fetch_assoc($total_result)['total'];
            $total_pages = ceil($total_records / $records_per_page);
            
            // Get products
            $query = "SELECT * FROM products $search_condition ORDER BY product_id DESC LIMIT $records_per_page OFFSET $offset";
            $result = mysqli_query($conn, $query);
            
            if (mysqli_num_rows($result) > 0) {
                echo '<table>';
                echo '<tr>
                        <th>ID</th>
                        <th>Image</th>
                        <th>Name</th>
                        <th>Price</th>
                        <th>Category</th>
                        <th>Stock</th>
                        <th>Actions</th>
                      </tr>';
                
                while ($row = mysqli_fetch_assoc($result)) {
                    $row_class = ($row['stock_quantity'] < 10) ? 'low-stock' : '';
                    echo '<tr class="' . $row_class . '">';
                    echo '<td>' . $row['product_id'] . '</td>';
                    echo '<td>';
                    if (!empty($row['main_image'])) {
                        echo '<img src="' . $row['main_image'] . '" alt="Product Image" class="product-image">';
                    } else {
                        echo 'No Image';
                    }
                    echo '</td>';
                    echo '<td>' . $row['product_name'] . '</td>';
                    echo '<td>$' . number_format($row['price'], 2) . '</td>';
                    echo '<td>' . $row['category'] . '</td>';
                    echo '<td>' . $row['stock_quantity'] . '</td>';
                    echo '<td>';
                    echo '<a href="admin_edit_product.php?id=' . $row['product_id'] . '" class="btn btn-warning">Edit</a>';
                    echo '<a href="admin_products.php?delete=' . $row['product_id'] . '" class="btn btn-danger" onclick="return confirm(\'Are you sure you want to delete this product?\')">Delete</a>';
                    echo '</td>';
                    echo '</tr>';
                }
                echo '</table>';
                
                // Pagination links
                if ($total_pages > 1) {
                    echo '<div class="pagination">';
                    for ($i = 1; $i <= $total_pages; $i++) {
                        $search_param = isset($_GET['search']) ? '&search=' . $_GET['search'] : '';
                        $filter_param = isset($_GET['filter']) ? '&filter=' . $_GET['filter'] : '';
                        echo '<a href="admin_products.php?page=' . $i . $search_param . $filter_param . '">' . $i . '</a>';
                    }
                    echo '</div>';
                }
            } else {
                echo '<div style="text-align: center; padding: 50px;">No products found.</div>';
            }
        }
        ?>
    </div>
</body>
</html>