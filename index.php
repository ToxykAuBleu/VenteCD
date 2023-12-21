<?php
    $user_valide = "admin";
    $mdp_valide = "admin";
    
    session_start();
    if (isset($_POST['user']) && isset($_POST['mdp'])) {
        if ($user_valide == $_POST['user'] && $mdp_valide == $_POST['mdp']) {
            $_SESSION['user'] = $_POST['user'];
            $_SESSION['mdp'] = $_POST['mdp'];
        } else {
            echo '<body onLoad="alert(\'Utilisateur ou mot de passe incorrect\')">';
        }
    }

?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Site de vente de CD</title>
    <link rel="stylesheet" href="./index.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.2/font/bootstrap-icons.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
</head>
<body>
    <!-- Barre de navigation -->
    <nav class="navbar fixed-top navbar-expand-lg bg-primary text-white">
        <div class="container-fluid">
            <a class="navbar-brand text-white" href="#">Site de vente de CD</a>
            
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbar">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbar">
                <ul class="d-flex me-auto mb-2 mb-lg-0">
                    <form method="GET" action="index.php">
                        <div class="input-group">
                            <select class="form-select" id="searchTag">
                                <option selected value="titre">Titre</option>
                                <option value="auteur">Auteur</option>
                                <option value="genre">Genre</option>
                            </select>

                            <input class="form-control me-2" type="search" id="search" name="search" placeholder="Recherche">
                        </div>
                    </form>
                </ul>
                
                <?php
                // Bouton connexion (si pas connecté).
                if (!isset($_SESSION['user']) || !isset($_SESSION['mdp'])) {
                    echo '<button class="btn btn-primary" type="button" data-bs-toggle="modal" data-bs-target="#connexionModal">
                        <i class="bi bi-box-arrow-in-right"></i> Connexion
                    </button>';
                // Bouton déconnexion & ajouter un CD.
                } else {
                    echo '<button class="btn btn-primary" type="button" data-bs-toggle="modal" data-bs-target="#ajouterCDModal"><i class="bi bi-disc"></i> Ajouter CD</button>';
                    echo '<a href="logout.php"><button class="btn btn-primary" type="button"><i class="bi bi-box-arrow-in-left"></i> Déconnexion</button></a>';
                }
                ?>

                <!-- Bouton pour accéder au panier -->
                <button class="btn btn-primary" type="button" data-bs-toggle="offcanvas" data-bs-target="#Panier" aria-controls="Panier">
                    <i class="bi bi-cart"></i> Panier
                </button>
            </div>
        </div>
    </nav>
    
    <!-- Panier -->
    <div class="offcanvas offcanvas-end" data-bs-scroll="true" tabindex="-1" id="Panier" aria-labelledby="offcanvasRightLabel">
        <div class="offcanvas-header">
            <h3 class="offcanvas-title" id="offcanvasRightLabel"><i class="bi bi-cart"></i> Panier</h3>
            <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Fermer"></button>
        </div>
        <div class="offcanvas-body d-flex flex-column" id="PanierContenu"></div>
    </div>
    
    <!-- Modal de connexion -->
    <div class="modal fade" id="connexionModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5">Connexion</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="index.php" method="POST">
                <div class="modal-body">
                    <div class="form-floating mb-3">
                        <input type="text" class="form-control" name="user" id="user" placeholder="Pseudonyme">
                        <label for="user">Pseudonyme</label>
                    </div>
                    <div class="form-floating">
                        <input type="password" class="form-control" name="mdp" id="mdp" placeholder="Mot de passe">
                        <label for="mdp">Mot de passe</label>
                    </div>
                </div>
                <div class="modal-footer">
                    <input type="submit" value="Connexion" class="btn btn-primary">
                </div>
            </form>
        </div>
    </div>
    </div>

    <?php
    if (isset($_SESSION['user']) && isset($_SESSION['mdp'])) {
        echo '<!-- Modal ajouter CD -->
        <div class="modal fade" id="ajouterCDModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5">Ajouter CD</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form enctype="multipart/form-data" action="gererCd.php?action=ajouter" method="POST">
                    <div class="modal-body">
                        <div class="form-floating mb-3">
                            <input type="text" class="form-control" name="titre" id="titre" placeholder="Titre">
                            <label for="titre">Titre</label>
                        </div>
                        <div class="form-floating mb-3">
                            <input type="text" class="form-control" name="auteur" id="auteur" placeholder="Auteur">
                            <label for="auteur">Auteur</label>
                        </div>
                        <div class="form-floating mb-3">
                            <input type="text" class="form-control" name="genre" id="genre" placeholder="Genre">
                            <label for="genre">Genre</label>
                        </div>
                        <div class="form-floating mb-3">
                            <input type="number" class="form-control" name="prix" id="prix" min="0" placeholder="Prix (€)">
                            <label for="prix">Prix (€)</label>
                        </div>
                        <h5 class="text">Ajouter vignette: </h5>
                        <div class="input-group">
                            <input type="file" class="form-control" name="image" aria-describedby="image" aria-label="Ajouter vignette">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <input type="submit" value="Ajouter" class="btn btn-success">
                    </div>
                </form>
            </div>
        </div>
        </div>';

        echo '<!-- Modal supprimer CD -->
        <div class="modal fade" id="supprimerCDModal" aria-hidden="true">
            <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5">Supprimer CD ?</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="formSupprimer" method="POST">
                    <div class="modal-body">
                        <p class="text-muted">Êtes-vous sûr de vouloir supprimer ce CD ?</p>
                        <input type="submit" value="Supprimer" class="btn btn-danger">
                    </div>
                </form>
            </div>
            </div>
        </div>';
    }
    ?>

    <!-- Liste des CD -->
    <div id="cds" class="container"></div>

    <!-- Modal info CD -->
    <div id="infoModals"></div>

    <!-- Footer -->
    <footer class="bg-light py-3 fixed-bottom">
        <p class="text-center my-0">Site entièrement réalisé avec ❤ par <a href="https://github.com/ToxykAuBleu">@ToxykAuBleu</a> et <a href="https://github.com/Alakamar">@Alakamar</a>.
        <br/>
        <i class="bi bi-github"></i>
        <a href="https://github.com/ToxykAuBleu/VenteCD" class="link-body-emphasis link-offset-2 link-underline-opacity-25 link-underline-opacity-75-hover">Code source</a> | Version 1.0
        </p>
    </footer>
    <script src="./index.js" type="module"></script>
</body>
</html>