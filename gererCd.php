<?php 
    session_start();
    if (!isset($_SESSION['user']) || !isset($_SESSION['mdp'])) {
        echo '<script>alert("Vous n\'êtes pas authentifié au site.");</script>';
        echo '<script>window.location.href = "index.php";</script>';
        exit();
    }

    if (isset($_GET['action'])){
        $action = $_GET['action'];
    } else {
        echo '<script>alert("Vous n\'êtes pas authentifié au site.");</script>';
        echo '<script>window.location.href = "index.php";</script>';
        exit();
    }

    // Connexion à la base de données.
    $ini = parse_ini_file("config.ini", true);
    $link = mysqli_connect($ini["MYSQL"]["Adresse"], $ini["MYSQL"]["Utilisateur"], $ini["MYSQL"]["MotPasse"], $ini["MYSQL"]["Database"]);
    
    $nomtable = $ini["MYSQL"]["Table"];
    switch ($action) {
        case 'supprimer':
            if (!isset($_GET['id'])) { 
                echo '<script>alert("Erreur, pas de CD sélectionné");</script>'; 
            } else {
                $query = "DELETE FROM ".$nomtable." WHERE ID=".$_GET['id'].";";
                        
                if (mysqli_query($link, $query) === FALSE) {
                    echo '<script>alert("Erreur, données invalides");</script>'; 
                } else {
                    $nomImage = glob("./pochettes/".$_GET['id']." *.jpg")[0];
                    unlink($nomImage);
                }
            }
            break;
            
        case 'ajouter':
            if (isset($_FILES) && !empty($_FILES)) {
                $dirname = "./pochettes/";
                $image = $_FILES["image"];
                if ( !file_exists($dirname) ) {
                    mkdir($dirname);
                }
                
                if ( is_uploaded_file($image["tmp_name"] ) ) {
                    // Insertion des données en BDD.
                    $query = "INSERT INTO ".$nomtable." (Titre, Auteur, Genre, Prix) VALUES ('".$_POST["titre"]."', '".$_POST["auteur"]."', '".$_POST["genre"]."', ".$_POST["prix"].");";
                    
                    if (mysqli_query($link, $query) === FALSE) {
                        echo '<script>alert("Erreur, données invalides");</script>'; 
                    } else {
                        // On veut récupérer l'identifiant généré par l'insertion.
                        $query = "SELECT ID FROM `CD` ORDER BY ID DESC LIMIT 1";
                        $id = mysqli_query($link, $query)->fetch_row()[0];
                        $imagePath = $dirname . $id ." - " . $_POST["titre"] . ".jpg";
                        
                        move_uploaded_file($image["tmp_name"], $imagePath);
                    }
                
                } else {
                    echo '<script>alert("Une erreur est survenue lors de l\'upload de la photo");</script>'; 
                }
                
            } else {
                echo '<script>alert("Erreur, aucune photo uploadée");</script>'; 
            }
            break;
    }
    mysqli_close($link);

    echo '<script>window.location.href = "index.php";</script>';
    exit();
?>