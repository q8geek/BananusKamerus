<?php


	function GetRandomString($length)
	{
		$hash = "abcdefghijklmnopqrstuvwxyz0123456789";
		$ret = "";
		for($i = 0; $i < $length; $i++)
		{
			$ret .= $hash[rand(0,strlen($hash)-1)];
		}
		
		return $ret;
	}

	function PrintGallery()
	{
		
		$directory = "pictures";
		$files = scandir($directory);
		$files = array_diff($files, ['.','..']);
		
		$gg = "";
		$b = "";
		exec("ps aux | grep -i zip | grep -v grep",$gg,$b);
		
		echo "<div class=\"row\">\n";
		echo "	<div class=\"col\">\n";
		echo "		<div class=\"card\">\n";
		echo "  		<div class=\"card-header\">\n";
		echo "				<div class=\"row\">\n";
		echo "					<div class=\"col-4\"><h5>Photos</h5></div>\n";
		if (empty($gg))
		{
			if (file_exists("download.zip"))
			{
				echo "					<div class=\"col-4\"><a href=\"/download.zip\"<button type=\"button\" class=\"btn btn-primary\">Download all pictures</button></a></div>\n";
				echo "					<div class=\"col-4\"><a href=\"/?op=compress&view=gallery\"<button type=\"button\" class=\"btn btn-danger\">Recompress pictures</button></a></div>\n";
			}
			else
			{
				echo "					<div class=\"col-4\"><a href=\"/?op=compress&view=gallery\"<button type=\"button\" class=\"btn btn-danger\">Compress pictures</button></a></div>\n";
			}
		}
		else
		{
			echo "					<div class=\"col-8\"><button type=\"button\" class=\"btn btn-secondary\" disabled>Compressing pictures</button></div>\n";
		}
		echo "				</div>\n";
		echo "			</div>\n";
		echo "  		<div class=\"card-body\">\n";
		echo "				<div class=\"row\">\n";
		echo "					<div class=\"col-12\">\n";
		echo "						<div class=\"list-group\" style=\"height:300px; overflow:scroll; margin: 10px\">\n";
		foreach($files as $picture)
		{
			if (filesize($picture) > 0)
			{
				$thumb = exif_thumbnail("pictures/" . $picture, $width, $height, $type);
				echo " 							<a href=\"#\" class=\"list-group-item list-group-item-action\" onclick=\"showPic('pictures/" . $picture . "');\">\n";
				echo "								<div class=\"d-flex justify-content-left\">\n";
				echo "									<img class=\"img-thumbnail float-left\" width=\"" . $width . "\" height=\"" . $height . "\" src='data:" . image_type_to_mime_type($type) . ";base64," . base64_encode($thumb) . "'>";
				echo "									<h5 class=\"mb-1\" style=\"margin-left:2%\">" . $picture . "</h5>\n";
				echo "								</div>\n";
				echo "							</a>\n";
			}
		}	
		echo "						</div>\n";
		echo "					</div>\n";
		echo "				</div>\n";
		echo "				<div class=\"row\">\n";
		echo "					<div class=\"col-12\">\n";
		echo "						<img id=\"previewImage\" class=\"rounded img-fluid\" src=\"bananus.png\" style=\"width:100%; margin-left:auto; margin-right:auto\"/>\n";
		echo "					</div\n";	
		echo "				</div\n";	
		echo "  		</div>\n";
		echo "  	</div>\n";
		echo "	</div>\n";
		echo "<script>\n";
		echo "	function showPic(choice)\n";
		echo "	{\n";
		echo "		document.getElementById('previewImage').src=choice;\n";
		echo "	}\n";
		echo "</script> \n";
	}

	function PrintCamera($message = "")
	{
		$pid = "";
		$grep = "";
		exec("ps aux | grep -i raspistill | grep -v grep",$grep,$buff);

		echo "<div class=\"row\">\n";
		echo "<div class=\"col\">\n";
		echo "	<div class=\"card\">\n";
		echo "		<div class=\"card-header\">\n";
		echo "			<div class=\"row\">\n";
		echo "				<div class=\"col\"><h5>Live preview</h5></div>\n";
		echo "				<div class=\"col\"><a href=\"?op=rescam\"><button type=\"button\" class=\"btn btn-sm btn-danger\">Reboot Sensor</button></a></div>\n";
		echo "			</div>\n";
		echo "		</div>\n";
		echo "  	<div class=\"card-body\">\n";
		echo "			<div class=\"embed-responsive embed-responsive-4by3\">\n";
		echo "				<iframe class=\"embed-responsive-item\" frameborder=\"0\" src=\"preview.php\"></iframe>\n";
		echo "			</div>\n";
		echo "		</div>\n";
		echo "	</div>\n";
		echo "</div>\n";
		echo "</div>\n";
		echo "<br/>\n";
		echo "<div class=\"row\">\n";
		echo "<div class=\"col-sm\">\n";
		echo "	<div class=\"card\">\n";
		echo "  	<div class=\"card-header\"><h5>Camera drive</h5></div>\n";
		echo "  	<div class=\"card-body\">\n";
		echo "			<form action=\"/index.php\">\n";
		echo "				<div class=\"row\">\n";
		echo "					<div class=\"col-4\"><strong>Mode</strong></div>\n";
		echo "					<div class=\"col-8\">\n";
		echo "						<div class=\"btn-group btn-group-toggle\" data-toggle=\"buttons\">\n";
		echo "							<label class=\"btn btn-warning btn-sm\">\n";
		echo "								<input type=\"radio\" name=\"mode\" value=\"auto\" id=\"option1\" active> Auto</input>\n";
		echo "							</label>\n";
		echo "							<label class=\"btn btn-secondary btn-sm\">\n";
		echo "								<input type=\"radio\" name=\"mode\" value=\"dark\" id=\"option2\"> Dark</input>\n";
		echo "							</label>\n";
		echo "							<label class=\"btn btn-dark btn-sm\">\n";
		echo "								<input type=\"radio\" name=\"mode\" value=\"night\" id=\"option3\"> Night</input>\n";
		echo "							</label>\n";
		echo "						</div>\n";
		echo "					</div>\n";
		echo "				</div>\n";
		echo "				<br/>\n";
		echo "				<div class=\"row\">\n";
		echo "					<div class=\"col-4\"><strong>Drive</strong></div>\n";
		echo "					<div class=\"col-8\">\n";
		echo "						<div class=\"btn-group btn-group-toggle\" data-toggle=\"buttons\">\n";
		echo "							<label class=\"btn btn-success btn-sm\">\n";
		echo "								<input type=\"radio\" name=\"drive\" value=\"single\" id=\"option1\" onclick=\"ShowSettings('hide')\" active> Single</input>\n";
		echo "							</label>\n";
		echo "							<label class=\"btn btn-danger btn-sm\">\n";
		echo "								<input type=\"radio\" name=\"drive\" value=\"continuous\" id=\"option2\" onclick=\"ShowSettings('csettings')\"> Continuous</input>\n";
		echo "							</label>\n";
		echo "							<label class=\"btn btn-primary btn-sm\">\n";
		echo "								<input type=\"radio\" name=\"drive\" value=\"timelapse\" id=\"tlOption\" onclick=\"ShowSettings('tlsettings')\"> Time Lapse</input>\n";
		echo "							</label>\n";
		echo "						</div>\n";
		echo "					</div>\n";
		echo "				</div>\n";
		echo "				<br/>\n";
		echo "				<div id=\"tlSettings\" style=\"display: none\">\n";
		echo "					<div class=\"row\">\n";
		echo "						<div class=\"col-4\"><strong>Time Lapse Drive Settings</strong></div>\n";
		echo "						<div class=\"col-8\">\n";
		echo "							<div class=\"row\">\n";
		echo "								<div class=\"col\">\n";
		echo "									<div class=\"row\">\n";
		echo "										<input type=\"text\" name=\"tgap\" class=\"form-control\" placeholder=\"Gap (Seconds)\"></input>\n";	
		echo "									</div>\n";
		echo "									<div class=\"row\">\n";
		echo "										<input type=\"text\" name=\"tduration\" class=\"form-control\" placeholder=\"Duration (Seconds)\"></input>\n";	
		echo "									</div>\n";
		echo "								</div>\n";
		echo "							</div>\n";
		echo "						</div>\n";
		echo "					</div>\n";
		echo "				</div>\n";
		echo "				<div id=\"cSettings\" style=\"display: none\">\n";
		echo "					<div class=\"row\">\n";
		echo "						<div class=\"col-4\"><strong>Continuous Mode Drive Settings</strong></div>\n";
		echo "						<div class=\"col-8\">\n";
		echo "							<div class=\"row\">\n";
		echo "								<div class=\"col\">\n";
		echo "									<input type=\"text\" name=\"cgap\" class=\"form-control\" placeholder=\"Gap (Seconds)\"></input>\n";	
		echo "								</div>\n";
		echo "							</div>\n";
		echo "						</div>\n";
		echo "					</div>\n";
		echo "				</div>\n";
		echo "				<br/>\n";
		echo "				<br/>\n";
		echo "				<div class=\"row\">\n";
		echo "					<div class=\"col\">\n";
		echo "						<input type=\"hidden\" name=\"op\" value=\"cdrive\"</input>\n";
		echo "						<input type=\"submit\" class=\"btn btn-primary btn-lg btn-block\" value=\"Start\"/>\n";
		echo "					</div>\n";
		echo "				</div>\n";
		echo "			</form>\n";
		echo "  	</div>\n";
		echo "  	</div>\n";
		echo "	</div>\n";
		echo "</div>\n";
		echo "</div>\n";
		echo "<br/>\n";
		
		echo "<script>\n";
		echo "	function ShowSettings(status)\n";
		echo "	{\n";
		echo "		var x = document.getElementById(\"cSettings\");\n";
		echo "		var y = document.getElementById(\"tlSettings\");\n";
		echo "		if (status === \"csettings\")\n";
		echo "		{\n";
		echo "			x.style.display = \"block\";\n";
		echo "			y.style.display = \"none\";\n";
		echo "		}\n";
		echo "		else if (status === \"tlsettings\")\n";
		echo "		{\n";
		echo "			x.style.display = \"none\";\n";
		echo "			y.style.display = \"block\";\n";
		echo "		}\n";
		echo "		else\n";
		echo "		{\n";
		echo "			x.style.display = \"none\";\n";
		echo "			y.style.display = \"none\";\n";
		echo "		}\n";
		echo "	}\n";
		echo "	</script>\n";
	}

	function PrintNavBar($current = "dashboard")
	{
		echo "		  <li class=\"nav-item\">\n";
		echo "		  <a class=\"nav-link";
		if ($current == "dashboard")
			echo " active";
		echo "\" href=\"/\">Dashboard";
		if ($current == "dashboard")
			echo "<span class=\"sr-only\">(current)</span>";
		echo "</a>\n";
		echo "</li>\n";

		echo "		  <li class=\"nav-item\">\n";
		echo "		  <a class=\"nav-link";
		if ($current == "camera")
			echo " active";
		echo "\" href=\"/?view=camera\">Camera";
		if ($current == "camera")
			echo "<span class=\"sr-only\">(current)</span>";
		echo "</a>\n";
		echo "</li>\n";

		echo "		  <li class=\"nav-item\">\n";
		echo "		  <a class=\"nav-link";
		if ($current == "gallery")
			echo " active";
		echo "\" href=\"/?view=gallery\">Gallery";
		if ($current == "gallery")
			echo "<span class=\"sr-only\">(current)</span>";
		echo "</a>\n";
		echo "</li>\n";

		echo "		  <li class=\"nav-item\">\n";
		echo "		  <a class=\"nav-link";
		if ($current == "storage")
			echo " active";
		echo "\" href=\"/?view=storage\">Storage";
		if ($current == "storage")
			echo "<span class=\"sr-only\">(current)</span>";
		echo "</a>\n";
		echo "</li>\n";
		
		echo "		  <li class=\"nav-item\">\n";
		echo "		  <a class=\"nav-link";
		if ($current == "system")
			echo " active";
		echo "\" href=\"/?view=system\">System";
		if ($current == "system")
			echo "<span class=\"sr-only\">(current)</span>";
		echo "</a>\n";
		echo "</li>\n";
	}

	function PrintSystem()
	{
		$buff = 0;
		$os = "";
		$kernel = "";
		$user = "";
		$php = "";
		$wpa = "";
		$essid = "";
		$ipaddress = "";
		$hostname = "";
		exec("hostnamectl | grep \"Operating System\"",$os,$buff);
		exec("hostnamectl | grep \"Kernel\"",$kernel,$buff);
		exec("sudo nginx -v",$webserver,$buff);
		exec("php -v 'echo PHP_VERSION;'",$php,$buff);
		exec("whoami",$user,$buff);
		exec("hostname",$hostname,$buff);
		exec("cat /etc/hostapd/hostapd.conf | grep \"wpa_passphrase\"",$wpa,$buff);
		exec("cat /etc/hostapd/hostapd.conf | grep \"ssid\"",$essid,$buff);
		exec("ifconfig wlan0 | grep 'inet ' | cut -d: -f2 | awk '{print $2}'",$ipaddress,$buff);
		
		
		echo "<div class=\"container-fluid\">\n";
		echo "<div class=\"row\">\n";
		echo "<div class=\"col-sm\">\n";
		echo "	<div class=\"card\">\n";
		echo "  	<div class=\"card-header\"><h5>System</h5></div>\n";
		echo "  	<div class=\"card-body\">\n";
		if (!empty($os))
		{		
			echo "			<div class=\"row\">\n";
			echo "				<div class=\"col-4\"><strong>Operating System</strong></div>\n";
			echo "				<div class=\"col-8\">" . trim(explode(":",$os[0])[1]) . "</div>\n";
			echo "			</div>\n";
		}
		if (!empty($kernel))
		{		
			echo "			<div class=\"row\">\n";
			echo "				<div class=\"col-4\"><strong>Kernel</strong></div>\n";
			echo "				<div class=\"col-8\">" . trim(explode(":",$kernel[0])[1]) . "</div>\n";
			echo "			</div>\n";
		}
		if (!empty($php))
		{		
			echo "			<div class=\"row\">\n";
			echo "				<div class=\"col-4\"><strong>PHP</strong></div>\n";
			echo "				<div class=\"col-8\">" . $php[0] . "</div>\n";
			echo "			</div>\n";
		}
		if (!empty($user))
		{		
			echo "			<div class=\"row\">\n";
			echo "				<div class=\"col-4\"><strong>Account</strong></div>\n";
			echo "				<div class=\"col-8\">" . $user[0] . "</div>\n";
			echo "			</div>\n";
		}
		echo "  	</div>\n";
		echo "	</div>\n";
		echo "</div>\n";
		echo "</div>\n";
		echo "<br/>\n";
		
		echo "<div class=\"row\">\n";
		echo "<div class=\"col-sm\">\n";
		echo "	<div class=\"card\">\n";
		echo "  	<div class=\"card-header\"><h5>Network</h5></div>\n";
		echo "  	<div class=\"card-body\">\n";
		if (!empty($essid))
		{		
			echo "			<form action=\"/?op=uwifi\">\n";
			echo "				<div class=\"form-group\">\n";
			echo "					<div class=\"row\">\n";
			echo "						<div class=\"col-4\"><strong>SSID</strong></div>\n";
			echo "						<div class=\"col-8\"><input type=\"text\" class=\"form-control\" name=\"wname\" id=\"wifiname\" value=\"" . explode("=",$essid[0])[1] . "\"></div>\n";
			echo "					</div>\n";
			echo "					<br/>\n";
			echo "					<div class=\"row\">\n";
			echo "						<div class=\"col-4\"><strong>WPA KEY</strong></div>\n";
			echo "						<div class=\"col-8\"><input type=\"text\" class=\"form-control\" name=\"wpass\" id=\"password\" value=\"" . explode("=",$wpa[0])[1] . "\"></div>\n";
			echo "					</div>\n";
			echo "					<br/>\n";
			echo "					<input type=\"hidden\" name=\"op\" value=\"uwifi\">\n";

			echo "					<div class=\"row\">\n";
			echo "						<div class=\"col-4\">&nbsp;</div>\n";
			echo "						<div class=\"col-8\"><button type=\"submit\" class=\"btn btn-success btn-sm\">Update</button></div>\n";
			echo "					</div>\n";
			echo "				</div>\n";
			echo "			</form>\n";
		}
		if (!empty($ipaddress))
		{		
			echo "			<div class=\"row\">\n";
			echo "				<div class=\"col-4\"><strong>IP Address</strong></div>\n";
			echo "				<div class=\"col-8\">" . $ipaddress[0] . "</div>\n";
			echo "			</div>\n";
		}
		if (!empty($hostname))
		{		
			echo "			<div class=\"row\">\n";
			echo "				<div class=\"col-4\"><strong>Hostname</strong></div>\n";
			echo "				<div class=\"col-8\">" . $hostname[0] . "</div>\n";
			echo "			</div>\n";
		}
		echo "  	</div>\n";
		echo "	</div>\n";
		echo "</div>\n";
		echo "</div>\n";
		echo "<br/>\n";
		
		
		echo "<div class=\"row\">\n";
		echo "<div class=\"col-sm\">\n";
		echo "	<div class=\"card\">\n";
		echo "  	<div class=\"card-header\"><h5>Control</h5></div>\n";
		echo "  	<div class=\"card-body\">\n";
		echo "			<div class=\"row\">\n";
		echo "				<div class=\"col-4\"><a href=\"/?op=restart\" class=\"btn btn-danger btn-lg active\" role=\"button\" aria-pressed=\"true\">Restart</a></div>\n";
		echo "				<div class=\"col-4\"><a href=\"/?op=shutdown\" class=\"btn btn-danger btn-lg active\" role=\"button\" aria-pressed=\"true\">Shutdown</a></div>\n";
		echo "			</div>\n";
		echo "  	</div>\n";
		echo "	</div>\n";
		echo "</div>\n";
		echo "</div>\n";
		echo "<br/>\n";
		

		
	}

	function PrintOP($op)
	{
		$done = false;
		if ($op == "restart")
		{
			$done = true;
			$cli = "sudo shutdown -r now";
			$result = shell_exec($cli);
		}
		else if ($op == "shutdown")
		{
			$done = true;
			$cli = "sudo shutdown -P now";
			$result = shell_exec($cli);
		}
		else if ($op == "uwifi")
		{
			$wpa = "";
			$essid = "";
			$nwpa = "";
			$nessid = "";
			
			$void = "";
			$buff = 0;
			exec("cat /etc/hostapd/hostapd.conf | grep \"wpa_passphrase\"",$wpa,$buff);
			exec("cat /etc/hostapd/hostapd.conf | grep \"ssid\"",$essid,$buff);
			$wpa = explode("=",$wpa[0])[1];
			$essid = explode("=",$essid[0])[1];
			if (isset($_GET['wname']))
				$nessid = $_GET['wname'];
			if (isset($_GET['wpass']))
				$nwpa = $_GET['wpass'];
			
			if ($nwpa != "" && $nwpa != $wpa)
			{
				exec("sudo sed -i \"s/wpa_passphrase=.*/wpa_passphrase=" . $nwpa . "/g\" /etc/hostapd/hostapd.conf",$void,$buff);
				$done = true;
			}
			if ($nessid != "" && $nessid != $essid)
			{
				exec("sudo sed -i \"s/ssid=.*/ssid=" . $nessid . "/g\" /etc/hostapd/hostapd.conf",$void,$buff);
				$done = true;
			}
			
			if ($done)
			{
				exec("sudo systemctl reboot", $void, $buff);
			}
		}
		else if ($op == "erase")
		{
			$done = true;		
			$cli = "rm -f pictures/*";
			$result = shell_exec($cli);		
			$cli = "rm download.zip";
			$result = shell_exec($cli);		
		}
		else if ($op == "cdrive")
		{
			//raspistill -n -o pictures/2020_12_12__14_53_10.png
			$drive = "";
			$tduration = "";
			$cduration = "";
			$tgap = "";
			$cgap = "";
			$mode = "";
			$grep = "";
			$picname = "pictures/" . date("Ymd_His") . ".jpg";
			$cli = "";
			$message = "";
			$buff = "";
			$extra = "";
			$rand = GetRandomString(12);
			if (isset($_GET['mode']))
				$mode = $_GET['mode'];
				
			if (isset($_GET['drive']))
				$drive = $_GET['drive'];
				
			if (isset($_GET['tgap']))
				$tgap = $_GET['tgap'];
				
			if (isset($_GET['tduration']))
				$tduration = $_GET['tduration'];
				
			if (isset($_GET['cgap']))
				$cgap = $_GET['cgap'];
				
			if (isset($_GET['cduration']))
				$cduration = $_GET['cduration'];
			
			if ($drive == "continuous")
			{
				if (!is_numeric($cgap))
					$drive = "single";
				else
					$picname = "pictures/cont-" . $rand . "-%04d.jpg";
			}
			else if ($drive == "timelapse")
			{
				if (!is_numeric($tgap) || !is_numeric($tduration))
					$drive = "single";
				else
					$picname = "pictures/tl-" . $rand . "%04d.jpg";
			}
			else
				$drive = "single";
				
				
			//$cli = "raspistill -n -q 100 --timeout 1 " . ($extra * 1000) . " -o " . $picname;
			//raspistill -n -w 800 -h 600 -q 100 --timeout 1 -o preview.jpg
			if ($drive == "continuous")
				$extra = "0 -tl " . ($cgap * 1000) . " --burst";
			else if ($drive == "timelapse")
				$extra = ($tduration * 1000) . " -tl " . ($tgap * 1000);
			else if ($drive == "single")
				$extra = "1";

			
			if ($mode == "auto")
				$cli = "raspistill -n -q 100 --timeout " . $extra . " --thumb 64:48:35 -ex auto -o " . $picname;
			else if ($mode == "dark")
				$cli = "raspistill -n -q 100 --timeout " . $extra . " --thumb 64:48:35 -ex night -o " . $picname;
			else if ($mode == "night")
				$cli = "raspistill -n -q 100 --timeout " . $extra . " --thumb 64:48:35 -ex verylong -q -o " . $picname;
			else if ($mode == "darksky")
				$cli = "raspistill -n -q 100 --timeout " . $extra . " --thumb 64:48:35 -ISO 1600 -ss 30000000 -o " . $picname;
			else
				$cli = "raspistill -n -q 100 --timeout 1 --thumb -o " . $picname;
			
			exec("ps aux | grep -i raspistill | grep -v grep",$grep,$buff);
			
			
			while (!empty($grep))
			{
				sleep(0.1);
			}
			exec($cli . " > /dev/null 2>/dev/null &");
			PrintCamera();
		}
		else if ($op == "kill")
		{
			$pid = "";
			$cli = "";
			if (isset($_GET['p']) && is_numeric($_GET['p']))
				$pid = $_GET['p'];
			
			if ($pid != "")
			{
				$cli = "kill " . $pid;
				shell_exec($cli . " > /dev/null 2>/dev/null &");
			}			
		}
		else if ($op == "rescam")
		{
			while (!empty($grep))
			{
				sleep(0.1);
			}
			exec("raspistill -n -rs > /dev/null 2>/dev/null &");
			PrintStatus();
		}
		else if ($op == "compress")
		{
			while (!empty($grep))
			{
				sleep(0.1);
			}
			$gg = "";
			exec("zip -r download.zip pictures > /dev/null 2>/dev/null &");
			PrintGallery();
		}
		if ($done)
		{
			echo "<div class=\"container-fluid\">\n";
			echo "<div class=\"row\">\n";
			echo "<div class=\"col-sm\">\n";
			echo "	<div class=\"card\">\n";
			echo "  	<div class=\"card-header\"><h5>System Operation</h5></div>\n";
			echo "  	<div class=\"card-body\">\n";
			echo "		<p><h2>";
			if ($op == "restart" || $op == "uwifi")
				echo "Restarting device...\n";
			else if ($op == "shutdown")
				echo "Shutting device down...\n";
			else if ($op == "erase")
				echo "All pictures have been erased.\n";
			echo "		</h2></p>\n";
			echo "  	</div>\n";
			echo "	</div>\n";
			echo "</div>\n";
			echo "</div>\n";
			echo "<br/>\n";	
		}
	}

	function PrintStorage()
	{
		$gStorage = "";
		$size = "";
		$used = "";
		$available = "";
		$dName = "";
		$percentage = "";
		
		$directory = "pictures";
		$files = scandir($directory);
		$files = array_diff($files, ['.','..']);
		$num_files = count($files);
		$lastFile = "";
		$dGrep = "";
		$ipercentage = "";
		$du = "";

		if ($num_files > 0)
		{			
			rsort($files);
			$lastFile = $files[0];
		}				
		exec("df -h | grep root",$gStorage,$buff);
		exec("df | grep root",$dGrep,$buff);
		exec("du pictures",$du,$buff);

		if (!empty($gStorage))
		{
			$data = preg_split("#\s+#", "" . $gStorage[0]);
			$dName = $data[0];
			$size = $data[1];
			$used = $data[2];
			$available = $data[3];
			$percentage = str_replace("%","",$data[4]);
		}
		if (!empty($dGrep))
		{
			$data = preg_split("#\s+#", "" . $dGrep[0]);
			$dudu = preg_split("#\s+#", "" . $du[0]);
			$du = $dudu[0];
			$ipercentage = round(($du / $data[1]) * 100,1);
		}



		echo "<div class=\"row\">\n";
		echo "<div class=\"col-sm\">\n";
		echo "	<div class=\"card\">\n";
		echo "	  <div class=\"card-header\"><h5>Storage</h5></div>\n";
		echo "  	<div class=\"card-body\">\n";
		echo "			<div class=\"row\">\n";
		echo "				<div class=\"col-4\"><strong>Drive</strong></div>\n";
		echo "				<div class=\"col-8\">" . $dName . "</div>\n";
		echo "			</div>\n";
		echo "			<div class=\"row\">\n";
		echo "				<div class=\"col-8\">\n";
		echo "					<div class=\"progress\" style=\"height: 20px;\">\n";
		echo "						<div class=\"progress-bar bg-danger\" role=\"progressbar\" style=\"width: " . $ipercentage . "%;\" aria-valuenow=\"" . $ipercentage . "\" aria-valuemin=\"0\" aria-valuemax=\"100\">" . $ipercentage . "</div>\n";
		echo "						<div class=\"progress-bar bg-success\" role=\"progressbar\" style=\"width: " . ($percentage - $ipercentage) . "%;\" aria-valuenow=\"" . ($percentage - $ipercentage) . "\" aria-valuemin=\"0\" aria-valuemax=\"100\">" . ($percentage - $ipercentage) . "</div>\n";
		echo "					</div>\n";
		echo "				</div>\n";
		echo "			</div>\n";
		echo "			<div class=\"row\">\n";
		echo "				<div class=\"col-12\"><strong>Usage percentage</strong></div>\n";
		echo "			</div>\n";
		echo "			<div class=\"row\">\n";
		echo "				<div class=\"col-1\">&nbsp;</div>\n";
		echo "				<div class=\"col-3\"><strong>Pictures</strong></div>\n";
		echo "				<div class=\"col-8\">" . $ipercentage . "%</div>\n";
		echo "			</div>\n";
		echo "			<div class=\"row\">\n";
		echo "				<div class=\"col-1\">&nbsp;</div>\n";
		echo "				<div class=\"col-3\"><strong>Total used</strong></div>\n";
		echo "				<div class=\"col-8\">" . $percentage . "%</div>\n";
		echo "			</div>\n";
		echo "			<div class=\"row\">\n";
		echo "				<div class=\"col-4\"><strong>Drive size</strong></div>\n";
		echo "				<div class=\"col-8\">" . $size . "</div>\n";
		echo "			</div>\n";
		echo "			<div class=\"row\">\n";
		echo "				<div class=\"col-4\"><strong>Free space</strong></div>\n";
		echo "				<div class=\"col-8\">" . $available . "</div>\n";
		echo "			</div>\n";
		echo "			<div class=\"row\">\n";
		echo "				<div class=\"col-4\"><strong>Total used</strong></div>\n";
		echo "				<div class=\"col-8\">" . $used . "</div>\n";
		echo "			</div>\n";
		echo "			<div class=\"row\">\n";
		echo "				<div class=\"col-4\"><strong>Pictures stored</strong></div>\n";
		echo "				<div class=\"col-8\">" . $num_files . "</div>\n";
		echo "			</div>\n";
		echo "			<br/>\n";
		echo "			<div class=\"row\">\n";
		echo "				<div class=\"col-4\">&nbsp;</div>\n";
		echo "				<div class=\"col-4\"><a href=\"/?op=erase\" class=\"btn btn-danger btn-lg active\" role=\"button\" aria-pressed=\"true\">Erase pictures</a></div>\n";
		echo "				<div class=\"col-4\">&nbsp;</div>\n";
		echo "			</div>\n";
		echo "		</div>\n";
		echo "	</div>\n";
		echo "</div>\n";
		echo "</div>\n";

	}
	
	function PrintStatus()
	{
		$buff = 0;
		$user = "";
		$ipaddress = "";
		$date = "";
		$kernel = "";
		$essid = "";
		$wpa = "";

		$grep = "";
		$started = "";
		$type = "";
		$pid = "";

		$gStorage = "";
		$size = "";
		$used = "";
		$available = "";
		$dName = "";
		$percentage = "";
		
		$directory = "pictures";
		$files = scandir($directory);
		$files = array_diff($files, ['.','..']);
		$num_files = count($files);
		$lastFile = "";
		$dGrep = "";
		$ipercentage = "";
		$du = "";

		if ($num_files > 0)
		{			
			rsort($files);
			$lastFile = $files[0];
		}				
		exec("whoami",$user,$buff);
		exec("ifconfig wlan0 | grep 'inet ' | cut -d: -f2 | awk '{print $2}'",$ipaddress,$buff);
		exec("date",$date,$buff);
		exec("hostnamectl | grep \"Kernel\"",$kernel,$buff);
		exec("cat /etc/hostapd/hostapd.conf | grep \"wpa_passphrase\"",$wpa,$buff);
		exec("cat /etc/hostapd/hostapd.conf | grep \"ssid\"",$essid,$buff);
		exec("ps aux | grep -i raspistill | grep -v grep",$grep,$buff);
		exec("df -h | grep root",$gStorage,$buff);
		exec("df | grep root",$dGrep,$buff);
		exec("du pictures",$du,$buff);

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
		}
		
		if (!empty($gStorage))
		{
			$data = preg_split("#\s+#", "" . $gStorage[0]);
			$dName = $data[0];
			$size = $data[1];
			$used = $data[2];
			$available = $data[3];
			$percentage = str_replace("%","",$data[4]);
		}
		if (!empty($dGrep))
		{
			$data = preg_split("#\s+#", "" . $dGrep[0]);
			$dudu = preg_split("#\s+#", "" . $du[0]);
			$du = $dudu[0];
			$ipercentage = round(($du / $data[1]) * 100,1);
		}

		echo "<div class=\"container-fluid\">\n";
		echo "<div class=\"row\">\n";
		echo "<div class=\"col-sm\">\n";
		echo "	<div class=\"card\">\n";
		echo "  	<div class=\"card-header\"><h5>System</h5></div>\n";
		echo "  	<div class=\"card-body\">\n";
		if (!empty($essid))
		{		
			echo "			<div class=\"row\">\n";
			echo "				<div class=\"col-4\"><strong>Wifi name</strong></div>\n";
			echo "				<div class=\"col-8\">" . explode("=",$essid[0])[1] . "</div>\n";
			echo "			</div>\n";
		}
		if (!empty($wpa))
		{		
			echo "			<div class=\"row\">\n";
			echo "				<div class=\"col-4\"><strong>Password</strong></div>\n";
			echo "				<div class=\"col-8\">" . explode("=",$wpa[0])[1] . "</div>\n";
			echo "			</div>\n";
		}
		if (!empty($ipaddress))
		{		
			echo "			<div class=\"row\">\n";
			echo "				<div class=\"col-4\"><strong>IP Address</strong></div>\n";
			echo "				<div class=\"col-8\">" . $ipaddress[0] . "</div>\n";
			echo "			</div>\n";
		}
		if (!empty($user))
		{		
			echo "			<div class=\"row\">\n";
			echo "				<div class=\"col-4\"><strong>Username</strong></div>\n";
			echo "				<div class=\"col-8\">" . $user[0] . "</div>\n";
			echo "			</div>\n";
		}
		if (!empty($kernel))
		{		
			echo "			<div class=\"row\">\n";
			echo "				<div class=\"col-4\"><strong>Kernel</strong></div>\n";
			echo "				<div class=\"col-8\">" . $kernel[0] . "</div>\n";
			echo "			</div>\n";
		}
		echo "  	</div>\n";
		echo "	</div>\n";
		echo "</div>\n";
		echo "</div>\n";
		echo "<br/>\n";

		echo "<div class=\"row\">\n";
		echo "<div class=\"col-sm\">\n";
		echo "	<div class=\"card\">\n";
		echo "  	<div class=\"card-header\"><h5>Active captures</h5></div>\n";
		echo "  		<div class=\"card-body\">\n";
		echo "				<div class=\"row\">\n";
		echo "					<div class=\"col-12\">\n";
		echo "						<iframe style=\"width:100%\" frameborder=\"0\" src=\"active.php\"></iframe>\n";
		echo "  				</div>\n";
		echo "  			</div>\n";
		echo "  		</div>\n";
		echo "  	</div>\n";
		echo "  </div>\n";
		echo "</div>\n";


		echo "<br/>\n";
		echo "<div class=\"row\">\n";
		echo "<div class=\"col-sm\">\n";
		echo "	<div class=\"card\">\n";
		echo "	  <div class=\"card-header\"><h5>Storage</h5></div>\n";
		echo "  	<div class=\"card-body\">\n";
		echo "			<div class=\"row\">\n";
		echo "				<div class=\"col-4\"><strong>Drive</strong></div>\n";
		echo "				<div class=\"col-8\">" . $dName . "</div>\n";
		echo "			</div>\n";
		echo "			<div class=\"row\">\n";
		echo "				<div class=\"col-4\"><strong>Size</strong></div>\n";
		echo "				<div class=\"col-8\">" . $size . "</div>\n";
		echo "			</div>\n";
		echo "			<div class=\"row\">\n";
		echo "				<div class=\"col-4\"><strong>Used</strong></div>\n";
		echo "				<div class=\"col-8\">" . $used . "</div>\n";
		echo "			</div>\n";
		echo "			<div class=\"row\">\n";
		echo "				<div class=\"col-4\"><strong>Free</strong></div>\n";
		echo "				<div class=\"col-8\">" . $available . "</div>\n";
		echo "			</div>\n";
		echo "			<div class=\"row\">\n";
		echo "				<div class=\"col-4\"><strong>Percentage</strong></div>\n";
		echo "				<div class=\"col-2\">" . $percentage . "%</div>\n";
		echo "				<div class=\"col-6\">\n";
		echo "					<div class=\"progress\" style=\"height: 20px;\">\n";
		echo "						<div class=\"progress-bar\" role=\"progressbar\" style=\"width: " . $percentage . "%;\" aria-valuenow=\"" . $percentage . "\" aria-valuemin=\"0\" aria-valuemax=\"100\"></div>\n";
		echo "					</div>\n";
		echo "				</div>\n";
		echo "			</div>\n";
		echo "		</div>\n";
		echo "	</div>\n";
		echo "</div>\n";
		echo "</div>\n";
		echo "<br/>\n";
		echo "<div class=\"row\">\n";
		
		echo "<div class=\"col-sm\">\n";
		echo "	<div class=\"card\">\n";
		echo "	  <div class=\"card-header\"><h5>Pictures</h5></div>\n";
		echo "  	<div class=\"card-body\">\n";
		if ($num_files)
		{
			echo "			<div class=\"row\">\n";
			echo "				<div class=\"col-4\"><strong>In storage</strong></div>\n";
			echo "				<div class=\"col-8\">" . $num_files . "</div>\n";
			echo "			</div>\n";
			echo "			<div class=\"row\">\n";
			echo "				<div class=\"col-4\"><strong>Total size</strong></div>\n";
			echo "				<div class=\"col-8\">" . round($du/1024) . " MB</div>\n";
			echo "			</div>\n";
			echo "			<div class=\"row\">\n";
			echo "				<div class=\"col-4\"><strong>Percentage</strong></div>\n";
			echo "				<div class=\"col-2\">" . $ipercentage . "%</div>\n";
			echo "				<div class=\"col-6\">\n";
			echo "					<div class=\"progress\" style=\"height: 20px;\">\n";
			echo "						<div class=\"progress-bar\" role=\"progressbar\" style=\"width: " . $ipercentage . "%;\" aria-valuenow=\"" . $ipercentage . "\" aria-valuemin=\"0\" aria-valuemax=\"100\"></div>\n";
			echo "					</div>\n";
			echo "				</div>\n";
			echo "			</div>\n";
			echo "			<br/>\n";
			echo "			<div class=\"row\">\n";
			echo "				<div class=\"col-4\"><img src=\"pictures/" . $lastFile . "\" class=\"rounded img-fluid\" width=\"196\" height=\"196\"></div>\n";
			echo "				<div class=\"col-8\">\n";
			echo "					<div class=\"row\">\n";
			echo "						<div class=\"col-4\"><strong>Taken:</strong></div>\n";
			echo "						<div class=\"col-8\">" . date ("Y-m-d H:i:s", filemtime("pictures/" . $lastFile)) . "</div>\n";
			echo "					</div>\n";
			echo "					<div class=\"row\">\n";
			echo "						<div class=\"col-4\"><strong>Size:</strong></div>\n";
			echo "						<div class=\"col-8\">" . round(filesize("pictures/" . $lastFile)/1024/1024) . " MB</div>\n";
			echo "					</div>\n";
			echo "				</div>\n";
			echo "			</div>\n";
		}
		else
		{
			echo "			<div class=\"row\">\n";
			echo "				<div class=\"col-12\"><strong>Empty</strong></div>\n";
			echo "			</div>\n";
		}
		echo "	  </div>\n";
		echo "  </div>\n";
//		echo "</div>\n";
		
		
		echo "</div>\n";
		
	}



?>