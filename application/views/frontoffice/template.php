
<!DOCTYPE HTML>
<html>
	<head>
		<title>Example</title>
		<meta http-equiv="content-type" content="text/html; charset=utf-8" />
		<link href="http://fonts.googleapis.com/css?family=Source+Sans+Pro:300,300italic,600|Source+Code+Pro" rel="stylesheet" />
		<link href="http://www.bootstrapcdn.com/font-awesome/3.1.1/css/font-awesome.css" rel="stylesheet" />
		<!--[if lte IE 8]><script src="js/html5shiv.js" type="text/javascript"></script><![endif]-->
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
		<script src="<?= base_url() ?>assets/skell/config.js"></script>
		<script src="<?= base_url() ?>assets/skell/skel.min.js"></script>
		<script src="<?= base_url() ?>assets/skell/skel-panels.min.js"></script>
	</head>
	<body>
		<div class="container">
			<?= $contents ?>
		</div>
		<!-- Bottom Panel -->
			<div id="bottomPanel">
				<form>
					<div class="row half">
						<div class="6u"><input type="text" placeholder="Name" /></div>
						<div class="6u"><input type="text" placeholder="Email" /></div>
					</div>
					<div class="row half">
						<div class="12u"><textarea placeholder="Message"></textarea></div>
					</div>
					<div class="row half">
						<div class="12u"><input type="button" class="button" value="Send Message" /></div>
					</div>
				</form>
			</div>
	</body>
</html>