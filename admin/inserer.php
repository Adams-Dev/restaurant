<?php  
	require 'database.php';
	$nom = $prix = $categorie = $image = $description = $nomError = $prixError = $categorieError = $imageError = $descriptionError = "";

	if (!empty($_POST)) 
	{
		$nom 				= checkInput($_POST['nom']);
		$categorie 			= checkInput($_POST['categorie']);
		$prix 				= checkInput($_POST['prix']);
		$description 		= checkInput($_POST['description']);
		$image 				= checkInput($_FILES['image']['name']);
		$imagePath			= '../image/' .basename($image);
		$imageExtension		= pathinfo($imagePath, PATHINFO_EXTENSION);
		$isSuccess			= true;
		$isUpload			= false;

		if (empty($nom)) 
		{
			$nomError = 'Ce champ ne peux pas etre vide';
			$isSuccess = false;
		}
		if (empty($description)) 
		{
			$descriptionError = 'Ce champ ne peux pas etre vide';
			$isSuccess = false;
		}
		if (empty($prix)) 
		{
			$prixError = 'Ce champ ne peux pas etre vide';
			$isSuccess = false;
		}
		if (empty($categorie)) 
		{
			$categorieError = 'Ce champ ne peux pas etre vide';
			$isSuccess = false;
		}
		if (empty($image)) 
		{
			$imageError = 'Ce champ ne peux pas etre vide';
			$isSuccess = false;
		}
		else
		{
			$isUpload = true;
			if ($imageExtension != "jpg" && $imageExtension != "png" && $imageExtension != "jpeg" && $imageExtension != "gif") 
			{
				$imageError = " Les fichiers autorisés sont : jpg, .jpeg, .png, .gif";
				$isUpload = false;
			}
			if (file_exists($imagePath)) 
			{
				$imageError = "Le fichier existe deja ";
				$isUpload = false;
			}
			if ($_FILES["image"]["size"] > 500000) 
			{
				$imageError = "Le fichier ne doit pas depasser 500kb";
				$isUpload = false;
			}
			if ($isUpload) 
			{
				if (!move_uploaded_file($_FILES["image"]["tmp_name"], $imagePath)) 
				{
					$imageError = "Il a eu une erreur lors du telechargement de l'image";
					$isUpload = false;
				}
			}
		}

		if ($isSuccess && $isUpload) 
		{
			$db = Database::connect();
			$statement = $db->prepare("INSERT INTO  elements (nom, description, prix, image, categorie) VALUES (?, ?, ?, ?, ?)");
			$statement -> execute(array($nom, $description, $prix, $image, $categorie));
			header("Location: index.php");
		}
	}



	function checkInput($data)
	{
		$data = trim($data);
		$data = stripcslashes($data);
		$data = htmlspecialchars($data);
		return $data;
	}

?>


<!DOsCTYPE html>
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
	
		<div>
			<h1><strong> Ajouter Un Element </strong></h1>
			<br>
			<form class="form" role="form" action=" " method="post" enctype="multipart/form-data" >
				<div class=" form-group">
					<label for="nom"> Nom:</label>
					<input type="text" class="form-control" id="nom" name="nom" value="<?php echo $nom ?>" placeholder="Nom">
					<span class="help-inline"><?php echo $nomError; ?></span>
				</div>
				<div class=" form-group">
					<label for="description"> Descriptions :</label>
					<input type="text" class="form-control" id="description" name="description" value="<?php echo $description ?>" placeholder="La description">
					<span class="help-inline"><?php echo $descriptionError; ?></span>
				</div>
				<div class=" form-group">
					<label for="prix"> Prix en Fcfa </label>
					<input type="number" step="5" class="form-control" id="prix" name="prix" value="<?php echo $prix ?>" placeholder="le prix">
					<span class="help-inline"><?php echo $prixError; ?></span>
				</div>
				<div class=" form-group">
					<label for="categorie"> Categorie :</label>
					<select name="categorie" class="form-control">
						<?php 

							$db = Database::connect();
							foreach ($db ->query('SELECT * FROM categories') as $row) 
							{
								echo '<option value="' .$row['id']. '">' .$row['nom']. '</option>';
							}
							Database::disconnect();
						 ?>
					</select>
					<span class="help-inline"><?php echo $categorieError; ?></span>
				</div>
				<div class=" form-group">
					<label for="image"> Selectionner une image </label>
					<input type="file" class="form-control" id="image" name="image">
					<span class="help-inline"><?php echo $imageError; ?></span>
				</div>
				<div class="form-action">
					<a class="btn btn-primary" href="index.php"><span class="glyphicon glyphicon-arrow-left"></span> Retour </a>
					<button type="submit" class="btn btn-success"><span class="glyphicon glyphicon-pencil"></span> Ajouter</button>
				</div>
		</form>
			
		</div>
		
	</div>

</body>
</html>