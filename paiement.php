<?php
    session_start();
    if(!isset($_SESSION['panier']) || empty($_SESSION['panier'])) {
        header('Location: ./index.php');
        exit();
    }
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Page de paiement</title>
    <link rel="stylesheet" href="./index.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
</head>

<body>
    <form action="./paiement.php" method="post">

    <div class="container p-0 mt-5">
        <div class="card px-4 position-absolute top-50 start-50 translate-middle">
            <p class="h2 py-3">Informations de paiement</p>
            <div class="row gx-3">

                <div class="col-12">
                    <div class="d-flex flex-column">
                        <p class="text mb-1">Nom</p>
                        <input class="form-control mb-3" type="text" placeholder="Nom" id="nom" required>
                    </div>
                </div>

                <div class="col-12">
                    <div class="d-flex flex-column">
                        <p class="text mb-1">Numéro de carte</p>
                        <input class="form-control mb-3" type="text" name="numCarte" placeholder="XXXX XXXX XXXX XXXX" id="numCarte" required>
                    </div>
                </div>

                <div class="col-6">
                    <div class="d-flex flex-column">
                        <p class="text mb-1">Date d'expiration</p>
                        <input class="form-control mb-3" type="text" name="dateExpiration" placeholder="MM/YY" id="dateExpiration" required>
                    </div>
                </div>

                <div class="col-6">
                    <div class="d-flex flex-column">
                        <p class="text mb-1">Cryptogramme</p>
                        <input class="form-control mb-3" type="text" name="crypto" placeholder="XXX" id="crypto" required>
                    </div>
                </div>
                
                <div class="d-flex flex-row my-3 justify-content-between">
                    <a href="./index.php" class="btn btn-danger col-auto">Retour à l'accueil</a>
                    <input class="btn btn-primary col-auto" type="submit" value="Valider">
                </div>
            </div>
        </div>
    </div>
    </form>

    <div class="modal fade" id="paiementModal" data-bs-backdrop="static" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5">Paiement accepté !</h1>
            </div>
            <div class="modal-body">
                <p class="text-muted">Redirection vers la page d'accueil dans quelques secondes...</p>
            </div>
        </div>
    </div>
    </div>

    <script src="./paiement.js" type="module"></script>
</body>

</html>

<?php
    if(isset($_POST['numCarte']) && isset($_POST['crypto']) && isset($_POST['dateExpiration'])) {
        $numCarte = $_POST['numCarte'];
        $crypto = $_POST['crypto'];
        $dateExpiration = $_POST['dateExpiration'];
        
        // Vérification de la validité de la carte
        if(!(is_numeric($numCarte) && strlen($numCarte) == 16 && $numCarte[0] == $numCarte[15])) {
            echo "<script>alert(\"Le numéro de carte est invalide\")</script>";
            return;
        }
        
        // Vérification de la validité du cryptogramme
        if(!(is_numeric($crypto) && strlen($crypto) == 3)) {
            echo "<script>alert(\"Le cryptogramme est invalide\")</script>";
            return;
        }
        
        // Transformation de la date d'expiration en yy-mm
        $dateExpiration = "20" . substr($dateExpiration, 3, 2) . "-" . substr($dateExpiration, 0, 2);

        // Vérification de la date d'expiration
        if(!($dateExpiration > date('Y-m', strtotime("+3 months")))) {
            echo "<script>alert(\"La date d'expiration est invalide\")</script>";
            return;
        }

        // Si tout est bon, on vide le panier puis affiche le modal de paiement accepté

        unset($_SESSION['panier']);

        echo "<script>
        var paiementModal = new bootstrap.Modal(document.getElementById('paiementModal'), {});
        paiementModal.show();
        </script>";
        echo "<script>setTimeout(function() {window.location.href = './index.php';}, 3000);</script>";
        exit();
    }
?>