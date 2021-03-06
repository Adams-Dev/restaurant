<?php 

$database = new PDO('mysql:host=localhost; dbname=restaurant', 'root', '');

if (isset($_POST['forminscription'])) 
{
	$nom=htmlspecialchars($_POST['nom']);
	$prenom=htmlspecialchars($_POST['prenom']);
	$mail=htmlspecialchars($_POST['mail']);
	$tel=htmlspecialchars($_POST['telephone']);
	$sexe=htmlspecialchars($_POST['sexe']);
	$mdp=sha1($_POST['mdp']);
	$cmdp=sha1($_POST['cmdp']);

	if (!empty($_POST['nom']) AND !empty($_POST['prenom']) AND !empty($_POST['mail']) AND !empty($_POST['telephone']) AND !empty($_POST['sexe']) AND !empty($_POST['mdp']) AND !empty($_POST['cmdp'])) 
	{
		if (filter_var($mail, FILTER_VALIDATE_EMAIL)) 
		{	
			$verifimail = $database->prepare("SELECT * FROM client WHERE mail=?");
			$verifimail-> execute(array($mail));
			$mailexist = $verifimail-> rowCount();
			if ($mailexist == 0) 
			{
				if ($mdp==$cmdp) 
					{
						$ajoutclient = $database->prepare("INSERT INTO client(nom, prenom, mail, telephone, sexe, mdp) VALUES(?, ?, ?, ?, ?, ?)");
						$ajoutclient-> execute(array($nom, $prenom, $mail, $tel, $sexe, $mdp));
						$erreur="Votre compte à bien été creer";
					}
				else
					{
						$erreur="Vos mots de passe ne correspondent pas";
					}
			}
			else
			{
				$erreur="Cette adresse E-mail existe deja";
			}
		}
		else
		{
			$erreur="Votre adresse E-mail n'est pas valide";
		}
		
	}
	else
	{
		$erreur="Veillez remplire tout les champs";
	}
}

 ?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta http-equiv="content-type" content="text/html">
	<title>Inscription</title>
	<link rel="stylesheet" type="text/css" href="css/for.css">
</head>
<body class="photo">
	
	<center>
		<h1>INSCRIPTION DE CLIENT</h1>
		<form action="#" method="post">
			<table>
				
					<tr>
						<td>Nom :</td><td><input class="position" type="text" name="nom" value=""></td>
					</tr>
					<tr>
						<td>Prénom :</td><td><input class="position" type="text" name="prenom" value=""></td>
					</tr>
					<tr>
						<td>Email :</td><td><input class="position" type="email" name="mail" ></td>
					</tr>
					<tr>
						<td>Tel :</td><td><input class="position" type="tel" name="telephone"></td>
					</tr>
					<tr>
						<td>Sexe :</td>
						<td>
							<label for="sexe1">Masculin<input type="radio" value="M" name="sexe" id="sexe1" checked></label>
							<label for="sexe2">Feminin<input type="radio" value="F" name="sexe" id="sexe2"></label>
						</td>
					</tr>
					<tr>
						<td>Mots de passe </td><td><input class="position" type="password" name="mdp"></td>
					</tr>
					<tr>
						<td>Confirmer le mots de passe </td><td><input class="position" type="password" name="cmdp"></td>
					</tr>
					<tr>
						<td><input class="annul" type="reset" value="Annuler"></td><td><input class="valide" type="submit" name="forminscription" value="S'incriire"></td>
					</tr>
					<tr>
						<td>Si vous avez déjà un compte </td><td><a href="connexion.php" class="redi">Criquez ici</a></td>
					</tr>
			</table>
		</form>
	</center>
	<br><br>
	<center>
	<?php 
		if (isset($erreur)) 
		{
			echo $erreur;
		}

	 ?>
	 </center>
</body>
</html>