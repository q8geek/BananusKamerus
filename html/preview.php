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
			  <!-- Custom styles for this template-->		</head>
	<body class="w100 h100">
<?php
	//raspistill -tl 2000 -t 0 -o preview.jpg
	$grep = "";
	$buff = 0;
	exec("ps aux | grep -i raspistill | grep -v grep",$grep,$buff);
	if (empty($grep))
	{
		$preview = "raspistill -n -w 800 -h 600 -q 100 --timeout 1 -o preview.jpg";
		exec($preview);
	}
?>
	<div class="custom-control custom-switch">
		<input type="checkbox" class="custom-control-input" name="previewToggle" checked="false" id="previewToggle">
		<label class="custom-control-label" for="previewToggle">Live preview</label>
	</div>
	<br/>
	<img src="preview.jpg" class="rounded" style="width:97%;height:97%"/>
	
	
	<script>
			window.setInterval(function()
			{
				reloadIFrame()
			}, 5000);

			function reloadIFrame()
			{
				if (document.getElementById('previewToggle').checked)
				{
					console.log('reloading..');
					location.reload();  
				}
			}
		</script>
		
	</body>
</html>