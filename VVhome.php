<?php
	session_start();
	if(isset($_SESSION['username'])){
?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Velvet Vogue</title>
	<link rel="stylesheet" href="style.css">
	<link rel="preconnect" href="https://fonts.googleapis.com">
	<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
	<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css">
</head>
<body>

<?php
echo '
<div class="header">
	<div class="container">
		<div class="navbar">
			<div class="logo">
				<a href="VVhome.php"><img src="Logos/logo.png" alt="Velvet Vogue Logo"></a>
			</div>
			<nav>
				<ul id="MenuItems">
					<li><a href="VVhome.php">Home</a></li>
					<li><a href="#new-arrivals">New Arrivals</a></li>
					<li><a href="#mens-products">Men</a></li>
					<li><a href="#womens-products">Women</a></li>
					<li><a href="#kids-products">Kids</a></li>
					<li><a href="Product.php">All Products</a></li>
					<li><a href="Account.php">Account</a></li>
				</ul>
			</nav>

			<div class="user-section">
				<p style="color: white; margin-right: 15px; font-size: 14px;">
					Welcome, ' . $_SESSION['username'] . ' 
					<a href="logout.php" style="color:rgb(255, 255, 255); text-decoration: none; margin-left: 10px;">
						(Logout <i class="fas fa-sign-out-alt"></i>)
					</a>
				</p>
				<a href="Shopping_cart.php"><img src="Images/shopping-cart.png" width="30px" height="30px"></a>
			</div>
			<img src="Logos/menu 1.png" class="menu-icon" onclick="menuToggle()">

		</div>
		<div class="row">
			<div class="col-2">
				<h1>Give Your workout<br>A New Style!</h1>
				<p>Success isn\'t always about greatness. It\'s about consistency. Consistent<br>hard work gains success. Greatness will come.</p>
				<a href="Product.php" class="btn">Shop Now &#8594;</a>
			</div>
			<div class="col-2">
				<img src="Images/pngwing.com (2).png">
			</div>
		</div>
	</div>
</div>
	
<!-----featured categories----->
	<div class="categories">
	<div class="small container">
			<div class="row">
			<div class="col-3">
				<img src="Images/clothes 5.webp">
			</div>
			<div class="col-3">
			<img src="Images/clothes 6.webp">
			</div>
			<div class="col-3">
			<img src="Images/clothes 7.webp">
			</div>
		</div>
	</div>		
	</div>	
<!-----featured products----->	
	<div id="new-arrivals" class="small container">
		<h2 class="title">New Arrivals</h2>
		<div class="row">
			<div class="col-4">
				<a href="product_details.php?id=1"><img src="Images/clothes 8.webp"></a>
				<a href="product_details.php?id=1"><h4>Pink Floral Work Wear Blazer</h4></a>
				<div class="rating">
					<i class="fa-solid fa-star"></i>
					<i class="fa-solid fa-star"></i>
					<i class="fa-solid fa-star"></i>
					<i class="fa-regular fa-star"></i>
				</div>
				<P>Rs.3500.00</p>
			</div>
			<div class="col-4">
				<a href="Product_details.php?id=2"><img src="Images/clothes 11.webp"></a>
				<a href="Product_details.php?id=2"><h4>Deep Vneck Strappy Embellished White Maxi Dress</h4></a>
				<div class="rating">
					<i class="fa-solid fa-star"></i>
					<i class="fa-solid fa-star"></i>
					<i class="fa-solid fa-star"></i>
					<i class="fa-solid fa-star"></i>
					<i class="fa fa-star-half"></i>
				</div>
				<P>Rs.6000.00</p>
			</div>
			<div class="col-4">
				<a href="Product_details3.php"><img src="Images/clothes 10.webp"></a>
				<a href="Product_details3.php"><h4>One Shoulder Puff Sleeve White Dress</h4></a>
				<div class="rating">
					<i class="fa-solid fa-star"></i>
					<i class="fa-solid fa-star"></i>
					<i class="fa-solid fa-star"></i>
					<i class="fa-solid fa-star"></i>
					<i class="fa fa-star-half-o"></i>
				</div>
				<P>Rs.4450.00</p>
			</div>
			<div class="col-4">
				<a href="product_details.php?id=4"><img src="Images/clothes 9.webp"></a>
				<a href="product_details.php?id=4"><h4>Round Neck Chiffon Printed Shift Dress</h4></a>
				<div class="rating">
					<i class="fa-solid fa-star"></i>
					<i class="fa-solid fa-star"></i>
					<i class="fa-solid fa-star"></i>
					<i class="fa-solid fa-star"></i>
					<i class="fa-regular fa-star"></i>
				</div>
				<P>Rs.5000.00</p>
			</div>
		</div>
		<h2 id="mens-products" class="title">Men\'s Products</h2>
		<div class="row">
			<div class="col-4">
				<img src="Images/mens 1.webp">
				<h4>Vintage Combat Overshirt</h4>
				<div class="rating">
					<i class="fa-solid fa-star"></i>
					<i class="fa-solid fa-star"></i>
					<i class="fa-solid fa-star"></i>
					<i class="fa-solid fa-star"></i>
					<i class="fa-regular fa-star"></i>
				</div>
				<P>Rs.7500.00</p>
			</div>
			<div class="col-4">
				<img src="Images/mens 2.webp">
				<h4>Vintage Combat Overshirt</h4>
				<div class="rating">
					<i class="fa-solid fa-star"></i>
					<i class="fa-solid fa-star"></i>
					<i class="fa-solid fa-star"></i>
					<i class="fa-solid fa-star"></i>
					<i class="fa fa-star-half"></i>
				</div>
				<P>Rs.8000.00</p>
			</div>
			<div class="col-4">
				<img src="Images/mens 3webp.webp">
				<h4>Double PKT Crew Neck T-Shirt</h4>
				<div class="rating">
					<i class="fa-solid fa-star"></i>
					<i class="fa-solid fa-star"></i>
					<i class="fa-solid fa-star"></i>
					<i class="fa-solid fa-star-half"></i>
			
				</div>
				<P>Rs.6350.00</p>
			</div>
			<div class="col-4">
				<img src="Images/mens clothes.webp">
				<h4>Round Neck Chiffon Printed Shift Dress</h4>
				<div class="rating">
					<i class="fa-solid fa-star"></i>
					<i class="fa-solid fa-star"></i>
					<i class="fa-solid fa-star"></i>
					<i class="fa-solid fa-star"></i>
					<i class="fa-regular fa-star"></i>
				</div>
				<P>Rs.8500.00</p>
			</div>
		</div>
		<h2 id="womens-products" class="title">Women\'s Products</h2>
		<div class="row">
			<div class="col-4">
				<img src="Images/clothes 14.webp">
				<h4>Lost In Space Oversized Tshirt</h4>
				<div class="rating">
					<i class="fa-solid fa-star"></i>
					<i class="fa-solid fa-star"></i>
					<i class="fa-solid fa-star"></i>
					<i class="fa-solid fa-star"></i>
					<i class="fa-regular fa-star"></i>
				</div>
				<P>Rs.3000.00</p>
			</div>
			<div class="col-4">
				<img src="Images/clothes 15.webp">
				<h4>Oversized Pink Printed Shirt</h4>
				<div class="rating">
					<i class="fa-solid fa-star"></i>
					<i class="fa-solid fa-star"></i>
					<i class="fa-solid fa-star"></i>
					<i class="fa-solid fa-star"></i>
					<i class="fa-regular fa-star"></i>
				</div>
				<P>Rs.4450.00</p>
			</div>
			<div class="col-4">
				<img src="Images/clothes 16.webp">
				<h4>Urban Workwear Beige Jacket</h4>
				<div class="rating">
					<i class="fa-solid fa-star"></i>
					<i class="fa-solid fa-star"></i>
					<i class="fa-solid fa-star"></i>
					<i class="fa-solid fa-star-half"></i>
			
				</div>
				<P>Rs.6750.00</p>
			</div>
			<div class="col-4">
				<img src="Images/clothes 17.webp">
				<h4>White Satin Dress</h4>
				<div class="rating">
					<i class="fa-solid fa-star"></i>
					<i class="fa-solid fa-star"></i>
					<i class="fa-solid fa-star"></i>
					<i class="fa-solid fa-star"></i>
					<i class="fa-solid fa-star-half"></i>
				</div>
				<P>Rs.9000.00</p>
			</div>
		</div>
		<h2 id="kids-products" class="title">Kid\'s Products</h2>
		<div class="row">
			<div class="col-4">
				<img src="Images/Kids 1.jpg">
				<h4>AMY GIRLS FROCK</h4>
				<div class="rating">
					<i class="fa-solid fa-star"></i>
					<i class="fa-solid fa-star"></i>
					<i class="fa-solid fa-star"></i>
					<i class="fa-solid fa-star"></i>
					<i class="fa-regular fa-star"></i>
				</div>
				<P>Rs.3300.00</p>
			</div>
			<div class="col-4">
				<img src="Images/Kids 3.jpg">
				<h4>BOYS SHORT SLEEVES T – SHIRT</h4>
				<div class="rating">
					<i class="fa-solid fa-star"></i>
					<i class="fa-solid fa-star"></i>
					<i class="fa-solid fa-star"></i>
					<i class="fa fa-star-half"></i>
				</div>
				<P>Rs.1800.00</p>
			</div>
			<div class="col-4">
				<img src="Images/Kids 2.jpg">
				<h4>Girls floral printed dress</h4>
				<div class="rating">
					<i class="fa-solid fa-star"></i>
					<i class="fa-solid fa-star"></i>
					<i class="fa-solid fa-star"></i>
					<i class="fa-solid fa-star-half"></i>
			
				</div>
				<P>Rs.2000.00</p>
			</div>
			<div class="col-4">
				<img src="Images/Kids 4.jpg">
				<h4>Enzo premium boys typo graphic printed t-shirt</h4>
				<div class="rating">
					<i class="fa-solid fa-star"></i>
					<i class="fa-solid fa-star"></i>
					<i class="fa-regular fa-star"></i>
				</div>
				<P>Rs.1500.00</p>
			</div>
		</div>
	</div>
<!------offer------>
	<div class="offer">
		<div class="small-container">
			<div class="row">
				<div class="col-2">
                <img src="Images/clothes 13.webp" alt="White Chiffon Dress" class="offer-img">
				</div>
				<div class="col-2">
                <p>Exclusively Available on Fashion Hub</p>
                <h1>White Chiffon Dress</h1>
				<h2>20% off</h2>
                <small>Hurry! Get This Beautiful Dress in Stock! Only 10 Dresses left
				</small>
				<a href="" class="btn">Buy Now &#8594;</a>
				</div>
			</div>
		</div>
	</div>

<!-------testimonial------->
	<div class="testimonial">
		<div class="small container">
			<div class="row">
				<div class="col-3">
					<i class="fa-solid fa-quote-left"></i>
					<p>Amazing collection! Perfect blend of comfort and fashion. Definitely my go-to store now!</p>
					<div class="rating">
						<i class="fa-solid fa-star"></i>
						<i class="fa-solid fa-star"></i>
						<i class="fa-solid fa-star"></i>
						<i class="fa-solid fa-star"></i>
						<i class="fa fa-star-half"></i>
					</div>
					<img src="users/user 1.jpg">
					<h3>Sean Parker</h3>
				</div>
				<div class="col-3">
					<i class="fa-solid fa-quote-left"></i>
					<p>Absolutely love the designs and quality! Every piece feels unique and stylish.</p>
					<div class="rating">
						<i class="fa-solid fa-star"></i>
						<i class="fa-solid fa-star"></i>
						<i class="fa-solid fa-star"></i>
						<i class="fa-solid fa-star"></i>
						<i class="fa fa-star-half"></i>
					</div>
					<img src="users/user 2.jpg">
					<h3>jemy crol </h3>
				</div>
				<div class="col-3">
					<i class="fa-solid fa-quote-left"></i>
					<p>The fabric feels so soft and luxurious. Perfect for everyday wear and special occasions!</p>
					<div class="rating">
						<i class="fa-solid fa-star"></i>
						<i class="fa-solid fa-star"></i>
						<i class="fa-solid fa-star"></i>
						<i class="fa-solid fa-star"></i>
						<i class="fa fa-star-half"></i>
					</div>
					<img src="users/user 3.jpg">
					<h3>Mabel joe</h3>
				</div>
			</div>
		</div>
	</div>
	
<!-------brands------->	
	<div class="brands">
		<div class="small container">
			<div class="row">
				<div class="col-5">
				<img src="Logos/logo 1.png">
				</div>
				<div class="col-5">
				<img src="Logos/logo 2.png">
				</div>
				<div class="col-5">
				<img src="Logos/logo 3.png">
				</div>
				<div class="col-5">
				<img src="Logos/logo 4.png">
				</div>
				<div class="col-5">
				<img src="Logos/logo 5.png">
				</div>
			</div>
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
						fashion accessible to the many.
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
	</footer>';
?>

<!-------js for toggle menu-------->
	<script>
    // Get the menu items element
    var MenuItems = document.getElementById("MenuItems");

    // Set initial height
    MenuItems.style.maxHeight = "0px";

    // Toggle function for the menu
    function menuToggle() {
        if (MenuItems.style.maxHeight === "0px") {
            MenuItems.style.maxHeight = "200px"; // Expand menu
        } else {
            MenuItems.style.maxHeight = "0px"; // Collapse menu
        }
    }
	</script>

<?php
	} else {
		// If user is not logged in, redirect to login page
		header("Location: login.php");
		exit();
	}
?>

</body>
</html>