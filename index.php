<?php

$path = "documents/";
$secret_number = 1;//you must change this secret number at installation
$extention = "txt";

if(isset($_POST["document"])){
	
	$content = $_POST["document"];
	
	if(strlen($content) <= 0){
		$error = "Too short";
	}elseif(strlen($content) > 500){
		$error = "Too long : max 500 chars";
	}
	
	if(!isset($error)){
		$number_of_files = count(glob($path."/*.".$extention));
		mt_srand($secret_number."0".$number_of_files);
		
		$ref = mt_rand();
		
		while(file_exists($path.$ref.".".$extention)){
			$ref++;
		}
		
		file_put_contents($path.$ref.".".$extention, $content);
		
		header("Location: ./".$ref);
	}
	
}
?>
<!DOCTYPE html>
<html>
	<head>
		<title>Pasteban</title>
		<style>
			body {
				text-align: center;
				padding-top: 125px;
				font-family: arial;
			}
			a {
				color: inherit;
				text-decoration: none;
			}
			#menu {
				position: fixed;
				top: 0;
				left: 0;
				right: 0;
				background: #bd3737;
				width:100%;
				height: 50px;
			}
			#logo {
				color: white;
				font-weight: bold;
				font-size: 40px;
				position: absolute;
				left: 15px;
			}
			#count {
				color: white;
				font-size: 20px;
				position: absolute;
				top: 10px;
				right: 25px;
			}
			#show_id, #error {
				margin-bottom: 60px;
			}
			#error {
				color: red;
			}
			#document_textarea {
				width: 50%;
				height: 50%;
				border: solid 1px black;
				outline: none;
				padding: 1%;
			}
			#pasteban_content {
				width: 50%;
				height: 50%;
				position: absolute;
				left: 24%;
				right: 25%;
				padding: 1%;
				border: solid 1px black;
				text-align: left;
				word-break: break-all;
			}
			#publish_button {
				margin-top: 50px;
			}
		</style>
	</head>
	<body>
		<div id="menu">
			<a href="./"><span id="logo">PASTEBAN</span></a><span id="count"><?php echo count(glob($path."/*.".$extention)); ?> files</span>
		</div>
		<?php
		if(isset($_GET["ref"])){
			$ref = preg_replace('/[^0-9]/', '', $_GET["ref"]);
			if(strlen($ref) && file_exists($path.$ref.".".$extention)){
				$file = $path.$ref.".".$extention;
				?>
				<div id="show_id">Pasteban ID : <?php echo $ref; ?></div>
				<div id="pasteban_content">
					<?php echo nl2br(htmlentities(file_get_contents($file))); ?>
				</div>
				<?php
			}else{
				echo "Not found";
			}
		}else{
			if(isset($error)){
				?>
				<div id="error">Error : <?php echo $error; ?></div>
				<?php
			}
			?>
			<form method="POST">
				<textarea id="document_textarea" name="document" placeholder="Write here..."></textarea>
				<br/>
				<button type="submit" id="publish_button">Publish</button>
			</form>
			<?php
		}
		?>
	</body>
</html>