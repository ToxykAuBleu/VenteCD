<?php
    header("Content-type: image/jpeg");
    $nomImage = glob("./pochettes/".$_GET['idImage']." *.jpg")[0];

    $tailleImage = getimagesize($nomImage);

    $ancienneL = $tailleImage[0];
    $ancienneH = $tailleImage[1];

    $nouvelleL = 600;
    $nouvelleH = 600;

    $image = imagecreatefromjpeg($nomImage); 
    $vignette = imagecreatetruecolor($nouvelleL, $nouvelleH);

    imageCopyResampled($vignette, $image, 0, 0, 0, 0, $nouvelleL, $nouvelleH, $ancienneL, $ancienneH);

    ImageJpeg($vignette);

    ImageDestroy($image);
    ImageDestroy($vignette);
?>