<?php
session_start();
if (!isset($_SESSION['admin_logged_in'])) {
    header("Location: admin_login.php");
    exit();
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>Orders & Cart Management</title>
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
        .btn-danger {
            background-color: #dc3545;
        }
        .btn-danger:hover {
            background-color: #c82333;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            background: white;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
            margin-bottom: 20px;
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
        .filter-bar {
            margin-bottom: 20px;
            background: white;
            padding: 15px;
            border-radius: 8px;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
        }
        .filter-bar select,
        .filter-bar input {
            padding: 8px;
            margin-right: 10px;
            border: 1px solid #ddd;
            border-radius: 4px;
        }
        .summary-cards {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 20px;
            margin-bottom: 20px;
        }
        .summary-card {
            background: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
            text-align: center;
        }
        .summary-card h3 {
            margin: 0 0 10px 0;
            color: #333;
        }
        .summary-card .number {
            font-size: 2em;
            font-weight: bold;
            color: #007bff;
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
        .empty-state {
            text-align: center;
            padding: 50px;
            color: #666;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>Orders & Cart Management</h1>
    </div>
    
    <div class="nav">
        <a href="admin_dashboard.php">Dashboard</a>
        <a href="admin_products.php">Manage Products</a>
        <a href="admin_orders.php">View Orders</a>
        <a href="admin_register.php">Admin Registration</a>
    </div>
    
    <div class="container">
        <?php
        $conn = mysqli_connect('localhost', 'root', '', 'velvet_vogue');
        
        if (!$conn) {
            echo '<div style="color: red;">Database connection failed!</div>';
        } else {
            // --- Summary Statistics (same as before) ---
            $total_cart_items_query = "SELECT COUNT(*) as total FROM cart";
            $total_cart_items_result = mysqli_query($conn, $total_cart_items_query);
            $total_cart_items = mysqli_fetch_assoc($total_cart_items_result)['total'];

            $total_users_query = "SELECT COUNT(DISTINCT COALESCE(user_id, session_id)) as total FROM cart";
            $total_users_result = mysqli_query($conn, $total_users_query);
            $total_users = mysqli_fetch_assoc($total_users_result)['total'];

            $today_items_query = "SELECT COUNT(*) as total FROM cart WHERE DATE(added_at) = CURDATE()";
            $today_items_result = mysqli_query($conn, $today_items_query);
            $today_items = mysqli_fetch_assoc($today_items_result)['total'];

            $total_quantity_query = "SELECT SUM(quantity) as total FROM cart";
            $total_quantity_result = mysqli_query($conn, $total_quantity_query);
            $total_quantity = mysqli_fetch_assoc($total_quantity_result)['total'];
            
            echo '<div class="summary-cards">';
            echo '<div class="summary-card"><h3>Total Cart Items</h3><div class="number">' . $total_cart_items . '</div></div>';
            echo '<div class="summary-card"><h3>Active Users/Sessions</h3><div class="number">' . $total_users . '</div></div>';
            echo '<div class="summary-card"><h3>Today\'s Items</h3><div class="number">' . $today_items . '</div></div>';
            echo '<div class="summary-card"><h3>Total Quantity</h3><div class="number">' . ($total_quantity ? $total_quantity : 0) . '</div></div>';
            echo '</div>';
            
            // Filter options
            echo '<div class="filter-bar">';
            echo '<form method="GET" style="display: inline;">';
            echo '<select name="filter" onchange="this.form.submit()">';
            echo '<option value="">All Records</option>';
            echo '<option value="today"' . (isset($_GET['filter']) && $_GET['filter'] == 'today' ? ' selected' : '') . '>Today Only</option>';
            echo '<option value="week"' . (isset($_GET['filter']) && $_GET['filter'] == 'week' ? ' selected' : '') . '>This Week</option>';
            echo '<option value="logged_users"' . (isset($_GET['filter']) && $_GET['filter'] == 'logged_users' ? ' selected' : '') . '>Logged Users Only</option>';
            echo '</select>';
            echo '</form>';
            echo '</div>';
            
            // Handle delete cart item
            if (isset($_GET['delete_cart'])) {
                $cart_id = mysqli_real_escape_string($conn, $_GET['delete_cart']);
                $delete_query = "DELETE FROM cart WHERE cart_id = '$cart_id'";
                
                if (mysqli_query($conn, $delete_query)) {
                    echo '<div style="color: green; margin-bottom: 20px;">Cart item deleted successfully!</div>';
                } else {
                    echo '<div style="color: red; margin-bottom: 20px;">Error deleting cart item: ' . mysqli_error($conn) . '</div>';
                }
            }
            
            // Pagination
            $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
            $records_per_page = 15;
            $offset = ($page - 1) * $records_per_page;
            
            // Build where conditions
            $where_conditions = array();
            
            if (isset($_GET['filter'])) {
                switch ($_GET['filter']) {
                    case 'today':
                        $where_conditions[] = "DATE(added_at) = CURDATE()";
                        break;
                    case 'week':
                        $where_conditions[] = "added_at >= DATE_SUB(CURDATE(), INTERVAL 7 DAY)";
                        break;
                    case 'logged_users':
                        $where_conditions[] = "user_id IS NOT NULL";
                        break;
                }
            }
            
            $where_clause = !empty($where_conditions) ? 'WHERE ' . implode(' AND ', $where_conditions) : '';
            
            // Get total records for pagination
            $total_query = "SELECT COUNT(*) as total FROM cart $where_clause";
            $total_result = mysqli_query($conn, $total_query);
            
            if ($total_result === false) {
                echo '<div style="color: red;">Error fetching total records: ' . mysqli_error($conn) . '</div>';
                $total_records = 0;
            } else {
                $total_records = mysqli_fetch_assoc($total_result)['total'];
            }
            
            $total_pages = ceil($total_records / $records_per_page);
            
            // =============================================
            // OPTION 1: SEPARATE QUERIES (NO JOINS)
            // =============================================
            
            // Step 1: Get cart data only
            $cart_query = "SELECT * FROM cart 
                          $where_clause
                          ORDER BY added_at DESC 
                          LIMIT $records_per_page OFFSET $offset";
            
            $cart_result = mysqli_query($conn, $cart_query);
            
            if ($cart_result === false) {
                echo '<div style="color: red;">Error fetching cart data: ' . mysqli_error($conn) . '</div>';
            } elseif (mysqli_num_rows($cart_result) > 0) {
                
                // Step 2: Collect all product IDs and user IDs for batch queries
                $product_ids = array();
                $user_ids = array();
                $cart_items = array();
                
                while ($row = mysqli_fetch_assoc($cart_result)) {
                    $cart_items[] = $row;
                    if ($row['product_id']) {
                        $product_ids[] = $row['product_id'];
                    }
                    if ($row['user_id']) {
                        $user_ids[] = $row['user_id'];
                    }
                }
                
                // Step 3: Get all products in one query
                $products = array();
                if (!empty($product_ids)) {
                    $product_ids_str = implode(',', array_unique($product_ids));
                    $product_query = "SELECT product_id, product_name, price, main_image FROM products WHERE product_id IN ($product_ids_str)";
                    $product_result = mysqli_query($conn, $product_query);
                    
                    if ($product_result) {
                        while ($product_row = mysqli_fetch_assoc($product_result)) {
                            $products[$product_row['product_id']] = $product_row;
                        }
                    }
                }
                
                // Step 4: Get all users in one query
                $users = array();
                if (!empty($user_ids)) {
                    $user_ids_str = implode(',', array_unique($user_ids));
                    
                    // Try users table first
                    $user_query = "SELECT user_id, RealName FROM users WHERE user_id IN ($user_ids_str)";
                    $user_result = mysqli_query($conn, $user_query);
                    if ($user_result) {
                        while ($user_row = mysqli_fetch_assoc($user_result)) {
                            $users[$user_row['user_id']] = $user_row['RealName'];
                        }
                    }
                    
                    // Try logsch table for missing users
                    $logsch_query = "SELECT log_id, RealName FROM logsch WHERE log_id IN ($user_ids_str)";
                    $logsch_result = mysqli_query($conn, $logsch_query);
                    if ($logsch_result) {
                        while ($log_row = mysqli_fetch_assoc($logsch_result)) {
                            if (!isset($users[$log_row['log_id']])) {
                                $users[$log_row['log_id']] = $log_row['RealName'];
                            }
                        }
                    }
                }
                
                // Step 5: Display the data
                echo '<table>';
                echo '<tr>
                        <th>Cart ID</th>
                        <th>Product</th>
                        <th>User/Session</th>
                        <th>Quantity</th>
                        <th>Size</th>
                        <th>Price</th>
                        <th>Total</th>
                        <th>Added Date</th>
                        <th>Actions</th>
                      </tr>';
                
                foreach ($cart_items as $row) {
                    // Get product info
                    $product = isset($products[$row['product_id']]) ? $products[$row['product_id']] : null;
                    $product_name = $product ? $product['product_name'] : 'Product ID: ' . $row['product_id'];
                    $price = $product ? $product['price'] : 0;
                    
                    // Get user info
                    $user_info = '';
                    if (isset($users[$row['user_id']])) {
                        $user_info = $users[$row['user_id']];
                    } else {
                        $user_info = 'Session: ' . ($row['session_id'] ? substr($row['session_id'], 0, 8) . '...' : 'N/A');
                    }
                    
                    $total_price = $price * $row['quantity'];
                    
                    echo '<tr>';
                    echo '<td>' . htmlspecialchars($row['cart_id']) . '</td>';
                    echo '<td>' . htmlspecialchars($product_name) . '</td>';
                    echo '<td>' . htmlspecialchars($user_info) . '</td>';
                    echo '<td>' . htmlspecialchars($row['quantity']) . '</td>';
                    echo '<td>' . htmlspecialchars($row['size'] ? $row['size'] : 'N/A') . '</td>';
                    echo '<td>$' . number_format($price, 2) . '</td>';
                    echo '<td>$' . number_format($total_price, 2) . '</td>';
                    echo '<td>' . date('Y-m-d H:i', strtotime($row['added_at'])) . '</td>';
                    echo '<td>';
                    echo '<a href="admin_orders.php?delete_cart=' . htmlspecialchars($row['cart_id']) . '" class="btn btn-danger" onclick="return confirm(\'Are you sure you want to delete this cart item?\')">Delete</a>';
                    echo '</td>';
                    echo '</tr>';
                }
                echo '</table>';
                
                // Pagination links
                if ($total_pages > 1) {
                    echo '<div class="pagination">';
                    for ($i = 1; $i <= $total_pages; $i++) {
                        $filter_param = isset($_GET['filter']) ? '&filter=' . htmlspecialchars($_GET['filter']) : '';
                        echo '<a href="admin_orders.php?page=' . $i . $filter_param . '">' . $i . '</a>';
                    }
                    echo '</div>';
                }
                
            } else {
                echo '<div class="empty-state">';
                echo '<h3>No cart items found</h3>';
                echo '<p>There are no cart items matching your current filter.</p>';
                echo '</div>';
            }
        }
        
        // Close the database connection
        if ($conn) {
            mysqli_close($conn);
        }
        ?>
    </div>
</body>
</html>