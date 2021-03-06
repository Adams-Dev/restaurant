<?php 
session_start();

$database = new PDO('mysql:host=localhost; dbname=restaurant', 'root', '');

if (isset($_POST['formconnexion'])) 
{
	$mailconnect=htmlspecialchars($_POST['mailconnect']);
	$mdpconnect=sha1($_POST['mdpconnect']);

	if (!empty($_POST['mailconnect']) AND !empty($_POST['mdpconnect']))  
	{
		$user= $database->prepare("SELECT * FROM client WHERE mail=? AND mdp=?");
		$user->execute(array($mailconnect, $mdpconnect));
		$userexist=$user->rowCount();
		if ($userexist==1) 
		{
			$userinfo=$user->fetch();
			$_SESSION['id']=$userinfo['id'];
			$_SESSION['nom']=$userinfo['nom'];
			$_SESSION['prenom']=$userinfo['prenom'];
			$_SESSION['mail']=$userinfo['mail'];
			$_SESSION['telephone']=$userinfo['telephone'];
			$_SESSION['sexe']=$userinfo['sexe'];
			header("Location: achat.php?id=".$_SESSION['id']."page?officielle?nom=".$_SESSION['nom']."?prenom=".$_SESSION['prenom']);
		}
		else
		{
			$erreur="Adresse mail ou mots de passe incorecte";
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
	<title>Connexion</title>
	<link rel="stylesheet" type="text/css" href="css/for.css">
</head>
<body class="photo">
	<div ></div>
	
	<center>
		<h1>AUTHENTIFICATION</h1>
		<form action="#" method="post">
			
			<table>
					<tr>
						<td>Email :</td><td><input class="position" type="email" name="mailconnect"></td>
					</tr>
					
					<tr>
						<td>Mots de passe :</td><td><input class="position" type="password" name="mdpconnect"></td>
					</tr>
					
					<tr>
						<td></td><td><input class="valide" type="submit" name="formconnexion" value="Se connecter"></td>
					</tr>
					<tr>
						<td>Pour créer un compte </td><td><a href="inscription.php" class="redi">Criquez ici</a></td>
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