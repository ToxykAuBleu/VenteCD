<?php
	header('content-type:application/json');

	$ini = parse_ini_file("config.ini", true);

	// Tentative de connexion à la base de données.
	try {
		$link = mysqli_connect($ini["MYSQL"]["Adresse"], $ini["MYSQL"]["Utilisateur"], $ini["MYSQL"]["MotPasse"], $ini["MYSQL"]["Database"]);
	} catch (Exception $e) {
		echo json_encode(array("erreur" => "Erreur MySQL: " . $e->getMessage(), "code" => "N° : " . $e->getCode()));
		exit();
	}

	$nomtable = "cd";
	// Recherche dans la table CD avec potentiellement un tag en paramètre.
	if (! isset($_GET["search"]) || $_GET["search"] == "") {
		$query = "SELECT * FROM $nomtable";
	} else {
		$query = "SELECT * FROM $nomtable WHERE LOWER(".$_GET['tag'].") LIKE '%".$_GET['search']."%';";
	}
	$result = mysqli_query($link, $query);
	$resultats = array();
	while ($donnees=mysqli_fetch_assoc($result)) {
		$id = $donnees["ID"];
		$titre = $donnees["Titre"];
		$auteur = $donnees["Auteur"];
		$genre = $donnees["Genre"];
		$prix = $donnees["Prix"];
		array_push($resultats, array("id" => $id, "titre" => $titre, "auteur" => $auteur, "genre" => $genre, "prix" => $prix));
	}
	mysqli_close($link);
	
	// Vérification de la connexion de l'utilisateur.
	session_start();
	if (isset($_SESSION['user']) && isset($_SESSION['mdp'])) {
		$resultats["estConnecte"] = true;
	} else {
		$resultats["estConnecte"] = false;
	}
	echo json_encode($resultats);
	exit();
?>