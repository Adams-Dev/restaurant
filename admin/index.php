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
			<h1><strong> Liste des elements </strong><a href="inserer.php" class="btn btn-success btn-lg"><span class="glyphicon glyphicon-plus"></span> Ajouter</a></h1>
			<table class="table table-stripped table-bordered">
				<thead>
					<tr>
						<th>Nom</th>
						<th>Description</th>
						<th>Prix en FCFA</th>
						<th>Catégorie</th>
						<th>Action</th>
					</tr>
				</thead>
				<tbody>
					<?php 
					require 'database.php';
					$db = Database::connect();
					$statement = $db->query('SELECT elements.id, elements.nom, elements.description, elements.prix, categories.nom AS category
											FROM elements LEFT JOIN categories ON elements.category = categories.id
											ORDER BY elements.id DESC');
					while($item = $statement -> fetch())
					{
						echo '<tr>';
						echo '<td>' . $item['nom'] . '</td>';
						echo '<td>' . $item['description'] . '</td>';
						echo '<td>' . $item['prix'] . '</td>';
						echo '<td>' . $item['category'] . '</td>';
						echo '<td width="300">';
						echo '<a class="btn btn-default" href="voir.php?id=' .$item['id']. '"><span class="glyphicon glyphicon-eye-open"></span> Voir</a>';
						echo ' ';
						echo '<a class="btn btn-primary" href="modifier.php?id=' .$item['id']. '"><span class="glyphicon glyphicon-pencil"></span> Modifier</a>';
						echo ' ';
						echo '<a class="btn btn-danger" href="supprimer.php?id=' .$item['id']. '"><span class="glyphicon glyphicon-remove"></span> Supprimer</a>';
						echo '</td>';
						echo '</tr>';
					}
					Database::disconnect();
					 ?>
				</tbody>
			</table>
		</div>
		
	</div>

</body>
</html>