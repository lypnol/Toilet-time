<html lang="en">
	<head>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		
		<title>Toilet time</title>
		
		<link rel="icon" href="img/paper.ico">
		
		<link rel="stylesheet" href="css/bootstrap.min.css">
		<link rel="stylesheet" href="css/style.css">
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css">
	</head>
	
	<body>
	
		<div id="body-wrapper">
			<nav id="nav-bar" class="navbar navbar-default">
				<div class="container-fluid">
					<div class="navbar-header">
						<a class="navbar-brand"> Toilet time </a>
						<a data-toggle="modal" data-target="#modal-paypal" href="#" >
							Buy paper roll
						</a>
					</div>
				</div>  
			</nav>
			
			
			<div id="wrapper">
				<div id="map">
						
				</div>
			</div>
			
			<div id="ad-wrapper">
				<div id="ad">
					<a data-toggle="modal" data-target="#modal-paypal" href="#" >
						<img src="img/banner.jpg" id="ad-banner" alt="banner ad"></img>
					</a>
				</div>
			</div>
		</div>
		
		<div id="modal" class="modal fade" role="dialog">
			<div class="modal-dialog">
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal">&times;</button>
						<h4 class="modal-title" id="modal-title"></h4>
					</div>
					<div class="modal-body">
						<div id="modal-body">
							<div id="activity-container" class="row">
							</div>
						</div>
						<img src="img/ajax-loader.gif" id="preloader" alt="loading..."></img>
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
					</div>
				</div>
			</div>
		</div>
		
		<div id="modal-paypal" class="modal fade" role="dialog">
			<div class="modal-dialog">
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal">&times;</button>
						<h4 class="modal-title"><b>Buy a toilet paper</b></h4>
					</div>
					<div class="modal-body text-center">
						<img id="paper-roll-img" src="img/toilet-paper.jpg"></img>
						<br>
						<div class="row" id="form-container">
							<form id="checkout" method="post" action="checkout.php" >
								<div id="payment-form"></div>
								<button class="btn btn-primary" id="buy-btn" type="submit">Buy toilet paper for $1</button>
							</form>
						</div>
						<div class="row" id="response-container">
							
						</div>
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
					</div>
				</div>
			</div>
		</div>
		
		<div id="modal-response" class="modal fade" role="dialog">
			<div class="modal-dialog">
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal">&times;</button>
						<h4 class="modal-title" id="modal-response-title">Payment</h4>
					</div>
					<div class="modal-body text-center" id="modal-response-body">
						
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
					</div>
				</div>
			</div>
		</div>
		
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
		<script src="js/bootstrap.min.js"></script>
		<script src="https://js.braintreegateway.com/v2/braintree.js"></script>
		<script src="js/toilets.js"></script>
		<script defer async src="https://maps.googleapis.com/maps/api/js?key=AIzaSyD1IpQmq8bXwqY-79mSFhKwpmpEFCznr6Y&callback=initMap"></script>
		<script src="js/buy_paper_roll.js"></script>
	</body>	
</html>

