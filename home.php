<?php
	include("function/session.php");
	include("db/dbconn.php");
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>OmarTill</title>
	<link rel="icon" href="img/logo.jpg">
	<link rel="stylesheet" type="text/css" href="css/style.css" media="all">
	<link rel="stylesheet" type="text/css" href="css/bootstrap.css">
	<script src="js/jquery-1.7.2.min.js"></script>
	<script src="js/bootstrap.min.js"></script>
</head>
<body>
	<div id="header">
		<img src="img/logo.jpg" alt="OmarTill Logo">
		<label>OmarTill</label>
		<?php
			$id = $_SESSION['id'];
			$query = $conn->prepare("SELECT * FROM customer WHERE customerid = ?");
			$query->bind_param("i", $id);
			$query->execute();
			$result = $query->get_result();
			$fetch = $result->fetch_assoc();
		?>
		<ul>
			<li><a href="function/logout.php"><i class="icon-off icon-white"></i>Logout</a></li>
			<li>Welcome:&nbsp;&nbsp;&nbsp;<a href="#profile" data-toggle="modal"><i class="icon-user icon-white"></i><?php echo htmlspecialchars($fetch['firstname']) . ' ' . htmlspecialchars($fetch['lastname']); ?></a></li>
		</ul>	
	</div>
	
	<div id="profile" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="width:700px;">
		<div class="modal-header">
			<button type="button" class="close" data-dismiss="modal" aria-hidden="true">x</button>
			<h3 id="myModalLabel">My Account</h3>
		</div>
		<div class="modal-body">
			<?php
				$query->execute();
				$result = $query->get_result();
				$fetch = $result->fetch_assoc();
			?>
			<center>
				<form method="post">
					<table>
						<tr>
							<td class="profile">Name:</td>
							<td class="profile"><?php echo htmlspecialchars($fetch['firstname']) . ' ' . htmlspecialchars($fetch['mi']) . ' ' . htmlspecialchars($fetch['lastname']); ?></td>
						</tr>
						<tr>
							<td class="profile">Address:</td>
							<td class="profile"><?php echo htmlspecialchars($fetch['address']); ?></td>
						</tr>
						<tr>
							<td class="profile">Country:</td>
							<td class="profile"><?php echo htmlspecialchars($fetch['country']); ?></td>
						</tr>
						<tr>
							<td class="profile">ZIP Code:</td>
							<td class="profile"><?php echo htmlspecialchars($fetch['zipcode']); ?></td>
						</tr>
						<tr>
							<td class="profile">Mobile Number:</td>
							<td class="profile"><?php echo htmlspecialchars($fetch['mobile']); ?></td>
						</tr>
						<tr>
							<td class="profile">Telephone Number:</td>
							<td class="profile"><?php echo htmlspecialchars($fetch['telephone']); ?></td>
						</tr>
						<tr>
							<td class="profile">Email:</td>
							<td class="profile"><?php echo htmlspecialchars($fetch['email']); ?></td>
						</tr>
					</table>
			</center>
		</div>
		<div class="modal-footer">
			<a href="account.php?id=<?php echo htmlspecialchars($fetch['customerid']); ?>"><input type="button" class="btn btn-success" name="edit" value="Edit Account"></a>
			<button class="btn btn-danger" data-dismiss="modal" aria-hidden="true">Close</button>
		</div>
				</form>
	</div>

	<br>
	<div id="container">
		<div class="nav">	
			<ul>
				<li><a href="home.php"><i class="icon-home"></i>Home</a></li>
				<li><a href="product1.php"><i class="icon-th-list"></i>Product</a></li>
				<li><a href="aboutus1.php"><i class="icon-bookmark"></i>About Us</a></li>
				<li><a href="contactus1.php"><i class="icon-inbox"></i>Contact Us</a></li>
				<li><a href="privacy1.php"><i class="icon-info-sign"></i>Privacy Policy</a></li>
				<li><a href="faqs1.php"><i class="icon-question-sign"></i>FAQs</a></li>
			</ul>
		</div>
		<br>
		
		<div id="carousel">
			<div id="myCarousel" class="carousel slide">
				<div class="carousel-inner">
					<div class="active item" style="padding:0; border-bottom:0 solid #111;">
						<img src="img/banner1.jpg" class="carousel" alt="Banner 1">
					</div>
					<div class="item" style="padding:0; border-bottom:0 solid #111;">
						<img src="img/banner2.jpg" class="carousel" alt="Banner 2">
					</div>
					<div class="item" style="padding:0; border-bottom:0 solid #111;">
						<img src="img/banner3.jpg" class="carousel" alt="Banner 3">
					</div>
				</div>
				<a class="carousel-control left" href="#myCarousel" data-slide="prev">&lsaquo;</a>
				<a class="carousel-control right" href="#myCarousel" data-slide="next">&rsaquo;</a>
			</div>
		</div>
	
		<div id="video">
			<video controls autoplay width="445px" height="300px">
				<source src="video/commercial.mp4" type="video/mp4">
			</video>
		</div>
		
		<div id="product" style="position:relative; margin-top:30%;">
			<center><h2><legend>Featured Items</legend></h2></center>
			<br>
			<?php 
				$query = $conn->prepare("SELECT * FROM product WHERE category='feature' ORDER BY product_id DESC");
				$query->execute();
				$result = $query->get_result();
				
				while ($fetch = $result->fetch_assoc()) {
					$pid = $fetch['product_id'];
					$query1 = $conn->prepare("SELECT * FROM stock WHERE product_id = ?");
					$query1->bind_param("i", $pid);
					$query1->execute();
					$rows = $query1->get_result()->fetch_assoc();
					
					$qty = $rows['qty'];
					if ($qty > 5) {
						echo "<div class='float'>";
						echo "<center>";
						echo "<a href='details.php?id=" . htmlspecialchars($fetch['product_id']) . "'><img class='img-polaroid' src='photo/" . htmlspecialchars($fetch['product_image']) . "' height='300px' width='300px' alt='Product Image'></a>";
						echo "<br>" . htmlspecialchars($fetch['product_name']) . "<br>";
						echo "P " . htmlspecialchars($fetch['product_price']) . "<br>";
						echo "<h3 class='text-info' style='position:absolute; margin-top:-90px; text-indent:15px;'>Size: " . htmlspecialchars($fetch['product_size']) . "</h3>";
						echo "</center>";
						echo "</div>";
					}
				}
			?>
		</div>
	</div>
	
	<br>
	<div id="footer">
		<div class="foot">
			<label style="font-size:17px;">Copyright &copy;</label>
			<p style="font-size:25px;">OmarTill GmbH. 2024</p>
		</div>
		<div id="foot">
			<h4>Links</h4>
			<ul>
				<li><a href="http://www.facebook.com">Facebook</a></li>
				<li><a href="http://www.twitter.com">Twitter</a></li>
				<li><a href="http://www.pinterest.com">Pinterest</a></li>
			</ul>
		</div>
	</div>
</body>
</html>
