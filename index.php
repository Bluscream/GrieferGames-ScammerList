<?php
    include_once 'dbConfig.php';
    include_once 'header.php';
?>
			<a class="active" href="/">Home</a>
			<a href="add.php">Scammer melden</a>
			<a href="#about">Über</a>
			<a href="#contact">Kontakt</a>
			<input type="text" placeholder="Scammer suchen..">
		</div>
		<br><center><table border='1' width='90%'>
			<tr>
				<th>Datum / Uhrzeit</th>
				<th>Scammer</th>
				<th>Grund</th>
				<th>Beweis(e)</th>
				<th>Reporter</th>
			</tr>
		<?php
			$con=mysqli_connect($host,$user,$pass,$table);
			if (mysqli_connect_errno()) {
				echo "Failed to connect to MySQL: " . mysqli_connect_error();
			}
			$result = mysqli_query($con,"SELECT * FROM griefers");
			function get_title($url){
			  $str = file_get_contents($url);
			  if(strlen($str)>0){
				$str = trim(preg_replace('/\s+/', ' ', $str));
				preg_match("/\<title\>(.*)\<\/title\>/i",$str,$title);
				return $title[1];
			  }
			}
			while($row = mysqli_fetch_array($result))
			{
				$target_uuid = $row['target_uuid'];
				$target_json = file_get_contents("https://api.mojang.com/user/profiles/$target_uuid/names");
				$target_obj = json_decode($target_json, true);
				$target_curname = $target_obj[0]["name"];
				$reporter_uuid = $row['reporter_uuid'];
				$reporter_json = file_get_contents("https://api.mojang.com/user/profiles/$reporter_uuid/names");
				$reporter_obj = json_decode($reporter_json, true);
				$reporter_curname = $reporter_obj[0]["name"];
				echo "<tr>";
				echo "<td>".$row['timestamp']."</td>";
				echo "<td title=".$target_json."><a href='https://mcuuid.net/?q=".$target_uuid."'>".$target_curname."</a></td>";
				echo "<td>".$row['reason']."</td>";
				echo "<td><a href='".$row['proof']."'>".htmlspecialchars(get_title($row['proof']))."</a></td>";
				echo "<td title=".$reporter_json."><a href='https://mcuuid.net/?q=".$reporter_uuid."'>".$reporter_curname."</a></td>";
				echo "</tr>";
			}
			echo "</table></center>";

			mysqli_close($con);
		?>
<?php
    include_once 'footer.php';
?>