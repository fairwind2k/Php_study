<?php
ini_set('display_errors', 1); 
date_default_timezone_set ('Europe/Amsterdam' );
	
	$host = 'localhost'; 
	$user = 'root'; 
	$password = ''; 
	$db_name = 'myTest';

	$link = mysqli_connect($host, $user, $password, $db_name) or die(mysqli_error($link));
	mysqli_query($link, "SET NAMES 'utf8'");
 	
	if ( isset($_REQUEST["submit"]) && (!empty($_REQUEST["user"])) && (!empty($_REQUEST["message"])) ) { 

		$name = $_REQUEST['user'];
		$message = $_REQUEST['message'];
			
		$query = "INSERT INTO MyComments SET autor='$name', article='$message', date = NOW(8) ";
		mysqli_query($link, $query) or die(mysqli_error($link));
	}
			
	if (isset($_GET['page'])) {
			$page = $_GET['page'];
		} else {
			$page = 1;
	}

	$notesOnPage = 2;
	$from = ($page - 1) * $notesOnPage;

			
?>

<!DOCTYPE html>
<html lang="ru">
	<head>
		<meta charset="utf-8">  
		<title>Гостевая книга</title>
		<link rel="stylesheet" href="css/bootstrap/css/bootstrap.css">
		<link rel="stylesheet" href="css/styles.css">
	</head>
	<body>
		<div id="wrapper">
			<h1>Гостевая книга</h1>
			<div>
				<nav>
				  <ul class="pagination">
					<li class="disabled">
						<a href="?page=1"  aria-label="Previous">
							<span aria-hidden="true">&laquo;</span>
						</a>
					</li>
					
					<?php  
					
					$query = "SELECT COUNT(*) as count FROM MyComments";
					$result = mysqli_query($link, $query) or die(mysqli_error($link));
					$count = mysqli_fetch_assoc($result)['count'];
					$pageCount = ceil($count/$notesOnPage);

					for ( $i = 1; $i <= $pageCount; $i++ ) {
						if ($page == $i) {
							$class = 'class="active"';
						} else {
							$class = '';
						}

					echo "<li $class><a href=\"?page=$i\">$i</a></li>";
					
					}

					?>

					<!-- <li class="active"><a href="?page=1">1</a></li>
					<li><a href="?page=2">2</a></li>
					<li><a href="?page=3">3</a></li>
					<li><a href="?page=4">4</a></li>
					<li><a href="?page=5">5</a></li> -->
					<li>
						<a href="?page=<?php echo $pageCount+1 ?>" aria-label="Next">
							<span aria-hidden="true">&raquo;</span>
						</a>
					</li>
				  </ul>
				</nav>
			</div>
			<div class="note">
			<p>
					<span class="date">18.04.2014 23:59:59</span>
					<span class="name">Дмитрий</span>
				</p>
				<p>
					Lorem ipsum dolor sit amet, 
					consectetur adipiscing elit. 
					Nulla efficitur elementum lorem id venenatis. 
					Nullam id sagittis urna, eu ultrices risus. 
					Duis ante lorem, semper nec fringilla eu,
					commodo vel mauris. Nunc tristique odio lectus, eget condimentum nunc consectetur eu. Nullam non varius nisl, aliquet fringilla lectus. Aliquam erat volutpat. Ut vel mi et lectus hendrerit ornare vel ut neque. Quisque venenatis nisl eu mi
				</p>

	<table>

	<?php    

			$query = "SELECT * from MyComments WHERE id > 0 LIMIT $from, $notesOnPage ";
			$result = mysqli_query($link, $query) or die(mysqli_error($link));
			for ($data = []; $row = mysqli_fetch_assoc($result); $data[] = $row);
		        $result = '';

			foreach ($data as $elem) {
	    		$result .= '<tr>';					
				$result .= '<td><span class="date">' . date("d.m.Y H:i:s ",strtotime($elem['date'])) . '</span></td>';
				$result .= '<td><span class="name">' . $elem['autor'] . '</span></td>';
				$result .= '</tr>';			
				$result .= '<td>'. $elem['article'] . '</td>';
			 }

			echo $result;
			echo '<br>';
	?>

	</table>

	<?php

		if (isset($_REQUEST["submit"]) && (!empty($_REQUEST["user"])) ) { 
	?>
		<div class="info alert alert-info">
			Запись успешно сохранена!
		</div>

	<?php } ?>

	<form action="#form" method="POST">

		<input class="form-control" type = "text" name = "user" placeholder = "Введите имя" autocomplete="off"> <br>
		<textarea class="form-control" name = "message" placeholder = "Ваш отзыв" autocomplete="off"></textarea> <br>
		<input type = "submit" class="btn btn-info btn-block" value = "send form" name = "submit">

	</form>

	</body>
