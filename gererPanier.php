<?php

    header('content-type:application/json');

    session_start();
    if (isset($_SESSION['panier'])){
        $panier = $_SESSION['panier'];
    } else {
        $panier = array();
    }

    if (isset($_GET['action'])){
        $action = $_GET['action'];
    } else {
        echo json_encode("Erreur, pas d'action sélectionnée");
        exit();
    }

    if (isset($_GET['id'])){
        $id = $_GET['id'];
    } elseif ($action !== "vider" && $action !== "afficher") {
        echo json_encode("Erreur, pas de CD sélectionné");
        exit();
    }


    if ($action != "afficher" && isset($panier["prixTotal"])) {
        unset($panier["prixTotal"]);
    }
    switch($action){
        case "afficher":
            $_SESSION['panier'] = $panier;
            break;

        case "ajouter":
            // On veut récupérer les informations du cd sélectionné.
            
            // Tentative de connexion à la base de données.
            $ini = parse_ini_file("config.ini");
            try {
                $link = mysqli_connect($ini["Adresse"], $ini["Utilisateur"], $ini["MotPasse"], $ini["Database"]);
            } catch (Exception $e) {
                echo json_encode(array("erreur" => "Erreur MySQL: " . $e->getMessage(), "code" => "N° : " . $e->getCode()));
                exit();
            }
            
            $nomtable = "CD";
            $query = "SELECT * FROM $nomtable WHERE ID=" . $id . " ;";
            
            $result = mysqli_query($link, $query);
            $resultats = array();
            while ($donnees=mysqli_fetch_assoc($result)) {
                $titre = $donnees["Titre"];
                $auteur = $donnees["Auteur"];
                $genre = $donnees["Genre"];
                $prix = $donnees["Prix"];
            }
            mysqli_close($link);

            if (isset($panier[$id])){
                // On augmente la quantité si présent dans le panier
                $panier[$id]["quantite"]++;
            } else {
                // On ajoute le cd au panier.
                $panier[$id] = array("id" => $id, "titre" => $titre, "auteur" => $auteur, "genre" => $genre, "prix" => $prix, "quantite" => 1);
            }

            // Prix total du panier.
            if (!empty($panier)) {
                $prixTotal = 0;
                foreach ($panier as $key => $cd) {
                    if ($key != "prixTotal") {
                        $prixTotal += $cd['prix'] * $cd['quantite'];
                    }
                }
                $panier['prixTotal'] = $prixTotal;
            }
            $panier['prixTotal'] = $prixTotal;
            $_SESSION['panier'] = $panier;
            break;

        case "retirer":
            if (isset($panier[$id])){
                if ($panier[$id]["quantite"] > 1) {
                    $panier[$id]["quantite"]--;
                } else {
                    unset($panier[$id]);
                }
            }

            // Prix total du panier.
            if (!empty($panier)) {
                $prixTotal = 0;
                foreach ($panier as $key => $cd) {
                    if ($key != "prixTotal") {
                        $prixTotal += $cd['prix'] * $cd['quantite'];
                    }
                }
                $panier['prixTotal'] = $prixTotal;
            }

            $_SESSION['panier'] = $panier;
            break;

        case "vider":
            unset($_SESSION['panier']);
            break;
    }

    if (empty($_SESSION['panier'])) {
        echo json_encode(0);
    } else {
        echo json_encode($_SESSION['panier']);
    }
    exit();
?>