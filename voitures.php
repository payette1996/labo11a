<?php
    if (session_status() === PHP_SESSION_NONE)
        session_start();

    require_once './inc/header.php';
    require_once './inc/car-info.php';
    require_once "./class/classVoitureManager.php";

    $bd = (string) "dblocation";
    $dsn = (string) "mysql:dbname=$bd;host=127.0.0.1";
    $user = (string) "root";
    $password = (string) "";
    $vm = new VoitureManager(new PDO($dsn, $user, $password));

    echo '<h1>Voitures disponibles</h1>';

    if (isset($_GET['idVoiture'])) {
        $voitureObj = selectCarById($_GET['idVoiture'], CAR_INFO);

        echo '<article class="grille">
                <h2>' . $voitureObj->get_marque() . ' ' . $voitureObj->get_modele() . ' - ' .
                    $voitureObj->get_categorie() . '</h2>
                <img src="./inc/img/' . $voitureObj->get_image() . '" alt="' . $voitureObj->get_marque() .
                    ' ' . $voitureObj->get_modele() . '" />
                <p><strong>Passager :</strong> ' . $voitureObj->get_nbPassager() . '</p>
                <p><strong>Description :</strong> ' . $voitureObj->get_description() . '</p>
              </article>
              <p class="retour"><a href="./voitures.php">Retour à la liste des voitures</a></p>';
    }

    else {
        echo '<h2>Sélectionnez une voiture pour en savoir plus</h2>
              <ul class="car_list">';

        $voituresArr = $vm->getVoitures($vm);
        foreach($voituresArr as $voiture) {
            echo "
                <li><a href='http://localhost/Laboratoire11B/voitures.php?idVoiture={$voiture['idVoiture']}'>
                    {$voiture['marque']} {$voiture['modele']}</a></li>
            ";
        }
    
        echo '</ul>';
    }

    require_once './inc/footer.html';
