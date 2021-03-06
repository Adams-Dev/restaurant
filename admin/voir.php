<?php 

	require 'database.php';

	if (!empty($_GET['id'])) 
	{
		$id = checkInput($_GET['id']);
	}

	$db = Database::connect();
	$statement = $db->prepare('SELECT elements.id, elements.nom, elements.description, elements.prix, elements.image, categories.nom AS category
							FROM elements LEFT JOIN categories ON elements.category = categories.id
							WHERE elements.id = ?');
	$statement -> execute(array($id));
	$item = $statement -> fetch();
	Database::disconnect();

	function checkInput($data)
	{
		$data = trim($data);
		$data = stripcslashes($data);
		$data = htmlspecialchars($data);
		return $data;
	}

 ?>

<!DOCTYPE html>
<html>
<head>
	<title>Resto super Goût</title>
    <meta charset="utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>
	<center>
		<h1 class="text-logo"><span class="glyphicon glyphicon-cutlery"></span> MON RESTO SUPER-GOÛT <span class="glyphicon glyphicon-cutlery"></span></h1>
	</center>
	<div class="container admin">
	
		<div class="row">
			<div class="col-sm-6">
				<h1><strong> Voir un elements </strong></h1>
				<br>
				<form >
					<div class=" form-group">
						<label> Nom:</label><?php echo ' ' .$item['nom']; ?>
					</div>
					<div class=" form-group">
						<label> Description:</label><?php echo ' ' .$item['description']; ?>
					</div>
					<div class=" form-group">
						<label> Prix:</label><?php echo ' ' .$item['prix']; ?>
					</div>
					<div class=" form-group">
						<label> Categorie:</label><?php echo ' ' .$item['category']; ?>
					</div>
					<div class=" form-group">
						<label> Image:</label><?php echo ' ' .$item['image']; ?>
					</div>
				</form>
				<div class="form-action">
					<a class="btn btn-primary" href="index.php"><span class="glyphicon glyphicon-arrow-left"></span> Retour </a>
				</div>
				
			</div>
			<div class="col-sm-6">
				<div class="thumbnail">
					<img src=<?php echo '../image/' . $item['image'] ;  ?>>
					<div> <?php echo  $item['prix']; ?></div>
					<div class="caption">
						<p><?php echo $item['nom']; ?></p>
						<p><?php echo $item['description']; ?></p>
						<a href="#" class="btn btn-order" role="button"> <span class="glyphicon glyphicon-shopping-cart"></span> comander</a>
					</div>
				</div>	
			</div>
			
		</div>
		
	</div>

</body>
</html>