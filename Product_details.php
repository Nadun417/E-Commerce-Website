<?php
session_start(); // Start session at the beginning
include 'config.php';

// Check if user is logged in
if (!isset($_SESSION['username'])) {
    header("Location: Login.html");
    exit();
}

// Get product ID from URL
$product_id = isset($_GET['id']) ? intval($_GET['id']) : 1;

// Fetch product details
$query = "SELECT * FROM products WHERE product_id = $product_id";
$result = mysqli_query($conn, $query);
$product = mysqli_fetch_assoc($result);

// Fetch product images
$images_query = "SELECT * FROM product_images WHERE product_id = $product_id ORDER BY is_main DESC";
$images_result = mysqli_query($conn, $images_query);
$images = mysqli_fetch_all($images_result, MYSQLI_ASSOC);

// Fetch product sizes
$sizes_query = "SELECT * FROM product_sizes WHERE product_id = $product_id AND stock_quantity > 0";
$sizes_result = mysqli_query($conn, $sizes_query);
$sizes = mysqli_fetch_all($sizes_result, MYSQLI_ASSOC);

// Handle Add to Cart
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['add_to_cart'])) {
    $quantity = intval($_POST['quantity']);
    $size = $_POST['size'];
    
    // Get user_id from username
    $username = $_SESSION['username'];
    $user_query = "SELECT user_id FROM users WHERE Username = '$username'";
    $user_result = mysqli_query($conn, $user_query);
    $user_data = mysqli_fetch_assoc($user_result);
    $user_id = $user_data['user_id'];
    
    // Check if item already exists in cart
    $check_query = "SELECT * FROM cart WHERE user_id = $user_id AND product_id = $product_id AND size = '$size'";
    $check_result = mysqli_query($conn, $check_query);
    
    if (mysqli_num_rows($check_result) > 0) {
        // Update quantity
        $update_query = "UPDATE cart SET quantity = quantity + $quantity WHERE user_id = $user_id AND product_id = $product_id AND size = '$size'";
        mysqli_query($conn, $update_query);
    } else {
        // Insert new item
        $insert_query = "INSERT INTO cart (user_id, product_id, quantity, size) VALUES ($user_id, $product_id, $quantity, '$size')";
        mysqli_query($conn, $insert_query);
    }
    
    $success_message = "Item added to cart successfully!";
}

if (!$product) {
    echo "Product not found!";
    exit;
}
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $product['product_name']; ?> - Fashion Hub</title>
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
    
    <?php if (isset($success_message)): ?>
        <div class="success-message" style="background: #4CAF50; color: white; padding: 10px; text-align: center; margin: 10px 0;">
            <?php echo $success_message; ?>
        </div>
    <?php endif; ?>
    
    <!---------single product details----------->
    <div class="small-container single-product">
        <div class="row">
            <div class="col-2">
                <img src="<?php echo $product['main_image']; ?>" width="100%" id="ProductImg">
                
                <div class="small-img-row">
                    <?php foreach ($images as $image): ?>
                        <div class="small-img-col">
                            <img src="<?php echo $image['image_path']; ?>" width="100%" class="small-img">
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
            
            <div class="col-2">
                <p>Home / <?php echo $product['category']; ?></p>
                <h1><?php echo $product['product_name']; ?></h1>
                <h4>Rs.<?php echo number_format($product['price'], 2); ?></h4>
                
                <form method="POST" action="">
                    <select name="size" required>
                        <option value="">Select Size</option>
                        <?php foreach ($sizes as $size): ?>
                            <option value="<?php echo $size['size_name']; ?>">
                                <?php echo $size['size_name']; ?> (<?php echo $size['stock_quantity']; ?> available)
                            </option>
                        <?php endforeach; ?>
                    </select>
                    
                    <input type="number" name="quantity" value="1" min="1" max="10" required>
                    <button type="submit" name="add_to_cart" class="btn">Add To Cart</button>
                </form>
                
                <h3>Product Details <i class="fa fa-indent"></i></h3>
                <br>
                <p><?php echo $product['description']; ?></p>
            </div>
        </div>
    </div>

    <?php
    // Fetch related products
    $related_query = "SELECT * FROM products WHERE category = '{$product['category']}' AND product_id != $product_id LIMIT 4";
    $related_result = mysqli_query($conn, $related_query);
    $related_products = mysqli_fetch_all($related_result, MYSQLI_ASSOC);
    ?>

    <div class="small-container">
        <h2 class="title">Related Products</h2>
        <div class="row">
            <?php foreach ($related_products as $related): ?>
                <div class="col-4">
                    <a href="product_details.php?id=<?php echo $related['product_id']; ?>">
                        <img src="<?php echo $related['main_image']; ?>">
                        <h4><?php echo $related['product_name']; ?></h4>
                        <div class="rating">
                            <i class="fa-solid fa-star"></i>
                            <i class="fa-solid fa-star"></i>
                            <i class="fa-solid fa-star"></i>
                            <i class="fa-solid fa-star"></i>
                            <i class="fa-regular fa-star"></i>
                        </div>
                        <p>Rs.<?php echo number_format($related['price'], 2); ?></p>
                    </a>
                </div>
            <?php endforeach; ?>
        </div>
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

    <!--------- js for product gallery ----------->
    <script>
        var ProductImg = document.getElementById("ProductImg");
        var SmallImg = document.getElementsByClassName("small-img");
        
        for (let i = 0; i < SmallImg.length; i++) {
            SmallImg[i].onclick = function() {
                ProductImg.src = SmallImg[i].src;
            };
        }
    </script>
</body>
</html>