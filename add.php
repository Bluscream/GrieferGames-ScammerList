<?php
    include_once 'dbConfig.php';
    include_once 'header.php';
?>
			<a href="/">Home</a>
			<a class="active" href="add.php">Scammer melden</a>
			<a href="#about">Über</a>
			<a href="#contact">Kontakt</a>
			<input type="text" placeholder="Scammer suchen..">
		</div>
		<?php
			function get_title($url){
			  $str = file_get_contents($url);
			  if(strlen($str)>0){
				$str = trim(preg_replace('/\s+/', ' ', $str));
				preg_match("/\<title\>(.*)\<\/title\>/i",$str,$title);
				return $title[1];
			  }
			}
			if(isset($_POST['report'])){
				$proof = htmlspecialchars($_POST["proof"]);
				if (empty(get_title($proof))) {
					echo '<script language="javascript">alert("Invalid Proof!");window.location.href="/add.php"</script>';
					return;
				}
				$con=mysqli_connect($host,$user,$pass,$table);
				if (mysqli_connect_errno()) {
					echo "Failed to connect to MySQL: " . mysqli_connect_error();
				}
				$target_name = $_POST["target"];
				$json = file_get_contents("https://api.mojang.com/users/profiles/minecraft/$target_name");
				$obj = json_decode($json, true);
				$target_uuid = $obj['id'];
				$reporter_name = $_POST["reporter"];
				$json = file_get_contents("https://api.mojang.com/users/profiles/minecraft/$reporter_name");
				$obj = json_decode($json, true);
				$reporter_uuid = $obj['id'];
				$sql = "INSERT INTO ".$table." (target_name, target_uuid, reason, proof, reporter_name, reporter_uuid)
				VALUES ('".htmlspecialchars($target_name)."','".htmlspecialchars($target_uuid)."','".htmlspecialchars($_POST["reason"])."','".$proof."','".htmlspecialchars($reporter_name)."','".$reporter_uuid."')";
				echo $sql;
				mysqli_query($con,$sql);
			}
		?>
		<form method="post"> 
		<label>Minecraft Name des Scammers:</label><br/>
		<input type="text" name="target"><br/>
		<label>Grund der Meldung:</label><br/>
		<select name="reason">
			<option value="Scammen">Scammen</option>
			<option value="Hacken">Hacken</option>
			<option value="Duplizieren">Duplizieren</option>
		</select><br>
		<label>Beweis (Video/Screenshot):</label><br/>
		<input type="text" name="proof"><br/>
		<label>Dein Minecraft Name:</label><br/>
		<input type="text" name="reporter"><br/>
		<br/><button type="submit" name="report">Meldung absenden!</button>
		</form>
<?php
    include_once 'footer.php';
?>