<?php
    include_once 'dbConfig.php';
    include_once 'header.php';
?>
			<a href="/">Home</a>
			<a href="add.php">Scammer melden</a>
			<a href="#about">Über</a>
			<a href="#contact">Kontakt</a>
			<a class="active" href="#admin">Admin CP</a>
			<input type="text" placeholder="Scammer suchen..">
		</div> 
		<?php
			if(isset($_POST['delete'])){
				$con=mysqli_connect($host,$user,$pass,$table);
				if (mysqli_connect_errno())
				{
				echo "Failed to connect to MySQL: " . mysqli_connect_error();
				}
				$uuid = $_POST["uuid"];
				$sql = "DELETE FROM ".$table." WHERE uid = \"".$uuid."\" LIMIT 1";
				echo $sql;
				mysqli_query($con,$sql);
			}
		?>
		<form method="post"> 
		<label>UUID:</label><br/>
		<input type="text" name="uuid"><br/>
		<button type="submit" name="delete">Meldung löschen!</button>
		</form>;
<?php
    include_once 'footer.php';
?>