<!-- 
	=== Note: ==========================================
	THIS WILL TAKE A LONG TIME TO LOAD! It has to scan 
	through 255 IPs to check if they are online. If you
	have a bad internet connection or an extremely weak
	PC, do *not* use this tool!
-->

<?php
	set_time_limit(0);

	$hostname = "http://".gethostbyname(gethostname());
	$ip_arr = explode(".", $hostname);
	array_pop($ip_arr);
	$host = implode(".", $ip_arr).".";
?>

<p>You are <b><?= $hostname; ?></b></p>
<button id="hideOffline">Toggle offline</button><br>
<table>
	<thead>
		<th>Name / address</th>
		<th>Status</th>
	</thead>
	<tbody>
<?php
	for ($i=0; $i < 30; $i++) { 
		$cinit = curl_init($host.$i);
		curl_setopt($cinit, CURLOPT_CONNECTTIMEOUT, 1);
		curl_setopt($cinit, CURLOPT_HEADER, true);
		curl_setopt($cinit, CURLOPT_NOBODY, true);
		curl_setopt($cinit, CURLOPT_RETURNTRANSFER, true);
		$response = curl_exec($cinit);
		curl_close($cinit);
		$pcname = gethostbyaddr(str_replace("http://", "", $host.$i));

		if ($response) {
			echo "<tr class='online'>
							<td><a href='".$host.$i."' target='_blank'>".$pcname."</a></td>
							<td style='color:green;'>Online</td>
						</tr>";
		} else {
			echo "<tr class='offline'>
							<td>".$host."<b>".$i."</b></td>
							<td style='color:red';'>Offline</td>
						</tr>";
		}
	}
?>
	</tbody>
</table>
<script type="text/javascript" src="//code.jquery.com/jquery-1.11.1.min.js"></script>
<script type="text/javascript">
	$("#hideOffline").click(function() {
		$(".offline").toggle();
	});
</script>