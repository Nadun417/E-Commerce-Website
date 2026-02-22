<?php
session_start(); // Start session at the beginning
include 'config.php';

// Check if user is logged in
if (!isset($_SESSION['username'])) {
    header("Location: Login.html");
    exit();
}

// Get user_id from username
$username = $_SESSION['username'];
$user_query = "SELECT user_id FROM users WHERE Username = '$username'";
$user_result = mysqli_query($conn, $user_query);
$user_data = mysqli_fetch_assoc($user_result);
$user_id = $user_data['user_id'];

// Handle quantity updates
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['update_cart'])) {
    $cart_id = intval($_POST['cart_id']);
    $new_quantity = intval($_POST['quantity']);
    
    if ($new_quantity > 0) {
        $update_query = "UPDATE cart SET quantity = $new_quantity WHERE cart_id = $cart_id AND user_id = $user_id";
        mysqli_query($conn, $update_query);
    }
}

// Handle item removal
if (isset($_GET['remove']) && is_numeric($_GET['remove'])) {
    $cart_id = intval($_GET['remove']);
    $remove_query = "DELETE FROM cart WHERE cart_id = $cart_id AND user_id = $user_id";
    mysqli_query($conn, $remove_query);
    header("Location: Shopping_cart.php");
    exit;
}

// Fetch cart items
$cart_query = "SELECT c.*, p.product_name, p.price, p.main_image 
               FROM cart c 
               JOIN products p ON c.product_id = p.product_id 
               WHERE c.user_id = $user_id";

$cart_result = mysqli_query($conn, $cart_query);
$cart_items = mysqli_fetch_all($cart_result, MYSQLI_ASSOC);

// Calculate totals
$subtotal = 0;
foreach ($cart_items as $item) {
    $subtotal += $item['price'] * $item['quantity'];
}
$tax = $subtotal * 0.10; // 10% tax
$total = $subtotal + $tax;
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Shopping Cart - Velvet Vogue</title>
    <link rel="stylesheet" href="style.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css">
</head>
<body>
    <div class="container">
        <div class="navbar">
            <div class="logo">
                <a href="VVhome.php"><img src="Logos/logo.png" width="125px"></a>
            </div>
            <nav>
                <ul id="MenuItems">
                    <li><a href="VVhome.php">Home</a></li>
                    <li><a href="Product.php">Products</a></li>
                    <li><a href="Account.php">Account</a></li>
                </ul>
            </nav>
            <a href="Shopping_cart.php"><img src="Images/shopping-cart.png" width="30px" height="30px"></a>
            <img src="Logos/menu 1.png" class="menu-icon" onclick="menuToggle()">
        </div>
    </div>

    <!-- Welcome message for logged in user -->
    <div style="background: #f8f9fa; padding: 10px; text-align: center; margin: 10px 0;">
        <p>Welcome, <?php echo $_SESSION['RN']; ?>! | <a href="logout.php">Logout</a></p>
    </div>

    <div class="small-container cart-page">
        <h2 class="title">Shopping Cart</h2>
        
        <?php if (empty($cart_items)): ?>
            <div style="text-align: center; padding: 50px;">
                <h3>Your cart is empty</h3>
                <p>Add some products to your cart to see them here.</p>
                <a href="Product.php" class="btn">Continue Shopping</a>
            </div>
        <?php else: ?>
            <table>
                <tr>
                    <th>Product</th>
                    <th>Quantity</th>
                    <th>Subtotal</th>
                </tr>
                <?php foreach ($cart_items as $item): ?>
                    <tr>
                        <td>
                            <div class="cart-info">
                                <img src="<?php echo $item['main_image']; ?>" width="80" height="80">
                                <div>
                                    <p><?php echo $item['product_name']; ?></p>
                                    <small>Price: Rs.<?php echo number_format($item['price'], 2); ?></small>
                                    <br>
                                    <small>Size: <?php echo $item['size']; ?></small>
                                    <br>
                                    <a href="?remove=<?php echo $item['cart_id']; ?>" onclick="return confirm('Are you sure you want to remove this item?')">Remove</a>
                                </div>
                            </div>
                        </td>
                        <td>
                            <form method="POST" action="" style="display: inline;">
                                <input type="hidden" name="cart_id" value="<?php echo $item['cart_id']; ?>">
                                <input type="number" name="quantity" value="<?php echo $item['quantity']; ?>" min="1" max="10" onchange="this.form.submit()">
                                <input type="hidden" name="update_cart" value="1">
                            </form>
                        </td>
                        <td>Rs.<?php echo number_format($item['price'] * $item['quantity'], 2); ?></td>
                    </tr>
                <?php endforeach; ?>
            </table>
            
            <div class="total-price">
                <table>
                    <tr>
                        <td>Subtotal</td>
                        <td>Rs.<?php echo number_format($subtotal, 2); ?></td>
                    </tr>
                    <tr>
                        <td>Tax (10%)</td>
                        <td>Rs.<?php echo number_format($tax, 2); ?></td>
                    </tr>
                    <tr>
                        <td>Total</td>
                        <td>Rs.<?php echo number_format($total, 2); ?></td>
                    </tr>
                </table>
                <div style="text-align: center; margin-top: 20px;">
                    <a href="Product.php" class="btn" style="background: #666; margin-right: 10px;">Continue Shopping</a>
                    <a href="checkout.php" class="btn">Proceed to Checkout</a>
                </div>
            </div>
        <?php endif; ?>
    </div>

    <!-------footer------->
    <footer class="footer">
        <div class="container">
            <div class="row">
                <div class="footer-col-6">
                    <h4>Download Our App</h4>
                    <p>Download App for Android and iOS mobile phone.</p>
                    <div class="app-logo">
                        <img src="Logos/icon 6.png">
                    </div>
                </div>
                <div class="footer-col-6">
                    <img src="Logos/logo.png" alt="Logo">
                    <p>
                        Our purpose is to sustainably make the pleasure and benefits of
                        sports accessible to the many.
                    </p>
                </div>
                <div class="footer-col-6">
                    <h4>Useful Links</h4>
                    <ul>
                        <li><a href="#">Coupons</a></li>
                        <li><a href="#">Blog Post</a></li>
                        <li><a href="#">Return Policy</a></li>
                        <li><a href="#">Join Affiliate</a></li>
                    </ul>
                </div>
                <div class="footer-col-6">
                    <h4>Follow Us</h4>
                    <ul class="social-icons">
                        <li><a href="#"><i class="fab fa-facebook-f"></i></a></li>
                        <li><a href="#"><i class="fab fa-twitter"></i></a></li>
                        <li><a href="#"><i class="fab fa-instagram"></i></a></li>
                        <li><a href="#"><i class="fab fa-youtube"></i></a></li>
                    </ul>
                </div>
            </div>
            <hr>
            <p class="copyright">Copyright 2024 - Velvet Vogue</p>
        </div>
    </footer>

    <!-------js for toggle menu-------->
    <script>
        var MenuItems = document.getElementById("MenuItems");
        MenuItems.style.maxHeight = "0px";

        function menuToggle() {
            if (MenuItems.style.maxHeight === "0px") {
                MenuItems.style.maxHeight = "200px";
            } else {
                MenuItems.style.maxHeight = "0px";
            }
        }
    </script>
</body>
</html>