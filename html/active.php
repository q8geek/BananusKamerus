<?php
	$pkill = -100;
	
	if (isset($_GET['p']))
	{
		if (is_numeric($_GET['p']))
			$pkill = $_GET['p'];
	}

	if ($pkill != -100)
	{
		$cli = "kill " . $pkill;
		shell_exec($cli);
		header('Location: active.php');
	}

?>

<html lang="en">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
		
		<link href="bootstrap.min.css" rel="stylesheet" integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2" crossorigin="anonymous">
		<style>
		  .bd-placeholder-img {
			font-size: 1.125rem;
			text-anchor: middle;
			-webkit-user-select: none;
			-moz-user-select: none;
			-ms-user-select: none;
			user-select: none;
		  }

		  @media (min-width: 768px) {
			.bd-placeholder-img-lg {
			  font-size: 3.5rem;
			}
		  }
		</style>
		<!-- Custom styles for this template -->
		<link href="dashboard.css" rel="stylesheet">
			  <!-- Custom styles for this template-->	
	</head>
	<body style="width:95%">
<?php

	$grep = "";
	$started = "";
	$type = "";
	$pid = "";

	exec("ps aux | grep -i raspistill | grep -v grep",$grep,$buff);

	if (!empty($grep))
	{
		$data = preg_split("#\s+#", $grep[0]);
		$pid = $data[1];
		$started = $data[8];
		if (count($data) > 15)
		{
			if ($data[15] == 0)
				$type = "Continuous";
			else if ($data[15] == 1)
				$type = "Single";
			else
			{
				if (is_numeric($data[15]))
					$type = "Preview";
				else
					$type = "Time Lapse";
			}
		}
		else
			$type = "Other";

		echo "					<div class=\"row\">\n";
		echo "						<div class=\"col-4\"><strong>Process ID</strong></div>\n";
		echo "						<div class=\"col-8\">" . $pid . "</div>\n";
		echo "					</div>\n";
		echo "					<div class=\"row\">\n";
		echo "						<div class=\"col-4\"><strong>Started</strong></div>\n";
		echo "						<div class=\"col-8\">" . $started . "</div>\n";
		echo "					</div>\n";
		echo "					<div class=\"row\">\n";
		echo "						<div class=\"col-4\"><strong>Type</strong></div>\n";
		echo "						<div class=\"col-8\">" . $type . "</div>\n";
		echo "					</div>\n";
		echo "					<br/>\n";
		echo "					<div class=\"row\">\n";
		echo "						<div class=\"col-4\">&nbsp</div>\n";
		echo "						<div class=\"col-8\"><a href=\"active.php?p=" . $pid . "\" type=\"button\" class=\"btn btn-danger\">Kill task</a></div>\n";
		echo "					</div>\n";
	}
	else
	{
		echo "					<div class=\"row\">\n";
		echo "						<div class=\"col-12\"><strong>No active captures</strong></div>\n";
		echo "					</div>\n";		
	}

?>
		<script>
			window.setInterval(function()
			{
				reloadIFrame()
			}, 1000);

			function reloadIFrame()
			{
				console.log('reloading..');
				location.reload();  
			}
		</script>
		
	</body>
</html>