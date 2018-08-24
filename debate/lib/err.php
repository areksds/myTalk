<?php 

	function error($number, $message, $fileDir, $base){ 
	include 'header.php';
		
?>
	<?php include 'templates/header.php'; ?>
	<link href="<?php echo $fileDir; ?>/css/signin.css" rel="stylesheet">
<?php if ($number === "SQL") { ?>
	<style>
		.error {
			box-shadow: none;
			border-color: rgb(95,83,146) !important;
			border-radius: 10px;
		}

	</style>
	<title>Database connection error</title>
	</head>

	<body class="text-center">
		<form class="form-signin">
			<h1 style="color: white" class="font-weight-normal">We couldn't connect to the database.</h1>
			<hr>
			<h1 style="color: white" class="h4 mb-3 font-weight-normal">Here's the error reported:</h1>
			<table class="table table-dark error">
				 <tbody>
					 <tr class="bg-danger">
						<td class="error"><?php echo $message; ?></td>
					</tr>
				</tbody>
			</table>
			<hr>
		  	<h1 style="color: white" class="h4 mb-3 font-weight-normal">Please address the issue(s) or contact your systems administrator.</h1>
		  <?php include 'templates/footer.php'; ?>
		</form>

		<?php include 'templates/javascript.php'; ?>
	</body>
	</html>	
<?php } elseif ($number === 403) { ?>
	<title>Error <?php echo $number; ?>: No Permission</title>
	</head>

	<body class="text-center">
		<form class="form-signin">
			<h1 style="color: white" class="font-weight-normal">Error <?php echo $number; ?></h1>
			<h1 style="color: white" class="h3 mb-3 font-weight-normal">You don't have permission to view this.</h1>
			<hr>
		  <a href="<?php echo $base . $fileDir; ?>" class="btn btn-lg btn-success btn-block">Return home</a>
		  <?php include 'templates/footer.php'; ?>
		</form>

		<?php include 'templates/javascript.php'; ?>
	</body>
	</html>

<?php } elseif ($number === 404) { ?>
	<title>Error <?php echo $number; ?>: Page Not Found</title>
	</head>

	<body class="text-center">
		<form class="form-signin">
			<h1 style="color: white" class="font-weight-normal">Error <?php echo $number; ?></h1>
			<h1 style="color: white" class="h3 mb-3 font-weight-normal">The page "<?php echo $message; ?>" could not be found.</h1>
			<hr>
		  <a href="<?php echo $base . $fileDir; ?>" class="btn btn-lg btn-success btn-block">Return home</a>
		  <?php include 'templates/footer.php'; ?>
		</form>

		<?php include 'templates/javascript.php'; ?>
	</body>
	</html>

<?php }
	} ?>