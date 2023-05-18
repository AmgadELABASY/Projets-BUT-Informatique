<?php

class Controller_planning extends Controller
{
    /**
     * Action qui permet d'importer un fichier csv
     */
    public function action_import() {
        $m = Model::getModel();
        // Si le superviseur clique sur importer
        if (isset($_POST['import'])) {
            // Si ce n'est pas vide
            if (! empty($_FILES['fichier']["name"])) {
                $fileName = $_FILES['fichier']["name"];
                // On ouvre le fichier
                $file = fopen($fileName, "r");
                $count = 0;
                // On récupère les lignes du fichier jusqu'à la fin du fichier
                while (($donnees = fgetcsv($file, null, ",")) !== FALSE) {
                    $count ++;
                    // Si c'est l'entête, on saute la ligne
                    if ($count==1) {continue;}
                    $nom = $donnees[1];
                    $presenceJeudi = $donnees[2];
                    $presenceVendredi = $donnees[3];
                    $description = $donnees[4];
                    $niveau = $donnees[5];
                    $capacite = $donnees[6];
                    $horaire9h18h = $donnees[9];
                    $duree = $donnees[10];
                    $tempsintersession = $donnees[11];
                    $pausedejdebut = $donnees[12];
                    $pausedejfin = $donnees[13];
                    $nbateliers = $donnees[15];
                    // Si l'exposant est déjà dans la base de données, on saute la ligne
                    if ($m->getInfosE($nom)) {continue;}
                    // Sinon, on insère les informations dans les tables correspondantes
                    $m->insererInfosPlanning($nom, $horaire9h18h, $duree, $tempsintersession, $pausedejdebut, $pausedejfin);
                    $m->addExposant($nom, $capacite, $description, $niveau, $presenceJeudi, $presenceVendredi, $nbateliers);

                    // Si l'exposant n'est pas présent de 9h à 18h, on ne crée pas les créneaux
                    if ($horaire9h18h == "non") {continue;}
                    if ($duree == '') {continue;}
                    if ($tempsintersession == '') {continue;}

                    // Création des créneaux de 9h à la pause déjeuner
                    // On affecte 9h à "début"
                    $debut = strtotime("9:00:00");
                    // Et on affecte à "fin" l'heure de début de la pause déjeuner
                    $fin = strtotime($pausedejdebut);
                    // Tant que le début + la durée est inférieur à la pause déjeuner
                    while ($debut+intval($duree)*60 <= $fin) {
                        // Si l'exposant est présent jeudi
                        if ($presenceJeudi == "Présent") {
                            // On crée le nombre de créneaux en fonction du nombre d'ateliers
                            for ($i = 0; $i < $nbateliers; $i++) {
                                $m->insererCreneau($nom, date("H:i:s", $debut), date("H:i:s", $debut + intval($duree) * 60), "Jeudi");
                            }
                        }
                        // Si l'exposant est présent vendredi
                        if ($presenceVendredi == "Présent") {
                            // On crée le nombre de créneaux en fonction du nombre d'ateliers
                            for ($i = 0; $i < $nbateliers; $i++) {
                                $m->insererCreneau($nom, date("H:i:s", $debut), date("H:i:s", $debut + intval($duree) * 60), "Vendredi");
                            }
                        }
                        // On ajoute à l'heure de début, la durée et le temps d'intersession
                        $debut += (intval($duree)+intval($tempsintersession))*60;
                    }

                    // On fait la même chose de la fin de la pause déjeuner à 18h
                    // On affecte à "debut2", l'heure de fin de la pause déjeuner
                    $debut2 = strtotime($pausedejfin);
                    // Et on affecte à "fin" 18h
                    $fin2 = strtotime("18:00:00");
                    while($debut2+intval($duree)*60 <= $fin2) {
                        // Si l'exposant est présent jeudi
                        if ($presenceJeudi == "Présent") {
                            // On crée le nombre de créneaux en fonction du nombre d'ateliers
                            for ($i = 0; $i < $nbateliers; $i++) {
                                $m->insererCreneau($nom, date("H:i:s", $debut2), date("H:i:s", $debut2 + intval($duree) * 60), "Jeudi");
                            }
                        }
                        // Si l'exposant est présent vendredi
                        if ($presenceVendredi == "Présent") {
                            // On crée le nombre de créneaux en fonction du nombre d'ateliers
                            for ($i = 0; $i < $nbateliers; $i++) {
                                $m->insererCreneau($nom, date("H:i:s", $debut2), date("H:i:s", $debut2 + intval($duree) * 60), "Vendredi");
                            }
                        }
                        // On ajoute à l'heure de début, la durée et le temps d'intersession
                        $debut2 += (intval($duree)+intval($tempsintersession))*60;
                    }
                }
                $id = $m->getIdS($_SESSION['adr']);
                // On insère cette action dans la table des modifications appliquées par les superviseurs
                $m->insererModif($id["id_superviseur"], 'INSERT', "", $fileName);
                // On ferme le fichier
                fclose($file);
                // On affiche un message de succès
                $message = "Le fichier a été importé avec succès.";
            }
            else {
                $message = "Aucun fichier n'a été sélectionné.";
            }
        }
        else {
            $message = "Veuillez importer votre fichier .csv";
        }
        $infos = $m->getInfosS($_SESSION["adr"]);
        // On récupère les noms des exposants
        $infosE = $m->getExposant();
        // Si le tableau est vide
        if (count($infosE)==0) {
            // On retourne des variables vides
            $infosEJ = [];
            $infosEV = [];
        }
        // Sinon, on récupère les informations de chaque exposant en fonction du jour
        else {
            foreach ($infosE as $v) {
                $infosEJ[$v] = $m->getInfosDE($v, "Jeudi");
                $infosEV[$v] = $m->getInfosDE($v, "Vendredi");
            }
        }
        $message = "Veuillez importer votre fichier .csv";
        $data = ["infos"=>$infos, "message"=>$message, "infosEJ"=>$infosEJ, "infosEV"=>$infosEV, "infosE"=>$infosE ];
        $this->render("planning_s", $data);
    }

    /**
     * Action par défaut du controller
     */
    public function action_default() {
        $this->action_import();
    }

    /**
     * Action qui permet d'afficher les informations d'un créneau pour pouvoir ensuite modifier
     */
    public function action_update() {
        $m = Model::getModel();
        // Si les champs sont remplis
        if (isset($_GET["id_creneau"]) and preg_match("/^[1-9]\d*$/", $_GET["id_creneau"])) {
            // On récupère les informations concernant ce créneau
            $creneau = $m->getInfosCreneau($_GET["id_creneau"]);
            $message = "Veuillez remplir les champs ci-dessous.";
            $data = ["creneau"=>$creneau, "message"=>$message];
            // On affiche la page qui permet de modifier
            $this->render("update", $data);
        }
        else {}
    }

    /**
     * Action qui modifie un créneau
     */
    public function action_updated() {
        $m = Model::getModel();
        // Si les champs sont remplis
        if (isset($_POST['id']) and isset($_POST['hd']) and isset($_POST['hf'])) {
            // Si les horaires sont compris entre 09:00:00 et 18:00:00
            if (preg_match("/^(((09)|(1[0-7])):([0-5][0-9]):([0-5][0-9]))|(18:00:00)$/", $_POST["hd"]) and preg_match("/^(((09)|(1[0-7])):([0-5][0-9]):([0-5][0-9]))|(18:00:00)$/", $_POST["hf"])) {
                $donnees = $m->getInfosCreneau($_POST['id']);
                // On enregistre les anciennes valeurs du créneau dans une variable
                $donnees1 = 'Exposant : ' . $donnees['nom'] . "\n" . 'Heure de début : ' . $donnees['heure_d'] . "\n" . 'Heure de fin : ' . $donnees['heure_f'];
                // On met à jour la base de données
                $m->updateCreneau($_POST['id'], $_POST['hd'], $_POST['hf']);
                $ids = $m->getIdS($_SESSION['adr']);
                // On récupère les nouvelles données dans une variable
                $donnees2 = 'Exposant : ' . $donnees['nom'] . "\n" . 'Heure de début : ' . $_POST["hd"] . "\n" . 'Heure de fin : ' . $_POST['hf'];
                // On insère la modification dans la base de données
                $m->insererModif($ids["id_superviseur"], 'UPDATE', $donnees1, $donnees2);
            }
            else {
                $creneau = $m->getInfosCreneau($_POST["id"]);
                $message = "Erreur au niveau des heures indiquées!";
                $data = ["creneau"=>$creneau, "message"=>$message];
                $this->render("update", $data);
            }
        }

        $infos = $m->getInfosS($_SESSION["adr"]);
        // On récupère les noms des exposants
        $infosE = $m->getExposant();
        // Si le tableau est vide
        if (count($infosE)==0) {
            // On retourne des variables vides
            $infosEJ = [];
            $infosEV = [];
        }
        // Sinon, on récupère les informations de chaque exposant en fonction du jour
        else {
            foreach ($infosE as $v) {
                $infosEJ[$v] = $m->getInfosDE($v, "Jeudi");
                $infosEV[$v] = $m->getInfosDE($v, "Vendredi");
            }
        }
        $message = "Veuillez importer votre fichier .csv";
        $data = ["infos"=>$infos, "message"=>$message, "infosEJ"=>$infosEJ, "infosEV"=>$infosEV, "infosE"=>$infosE ];
        $this->render("planning_s", $data);
    }

    /**
     * Action qui permet de supprimer un créneau
     */
    public function action_remove() {
        $m = Model::getModel();
        if (isset($_GET["id_creneau"]) and preg_match("/^[1-9]\d*$/", $_GET["id_creneau"]) and isset($_GET["nom"]) and isset($_GET["deb"]) and isset($_GET["fin"]) and isset($_GET["jour"])) {
            $id = $_GET["id_creneau"];
            if ($_POST["submit"] == "Annuler") {
                $infos = $m->getInfosS($_SESSION["adr"]);
                $infosE = $m->getExposant();
                if (count($infosE)==0) {
                    $infosEJ = [];
                    $infosEV = [];
                }
                foreach ($infosE as $v) {
                    $infosEJ[$v] = $m->getInfosDE($v, "Jeudi");
                    $infosEV[$v] = $m->getInfosDE($v, "Vendredi");
                }
                $message = "Veuillez importer votre fichier .csv";
                $data = ["infos"=>$infos, "message"=>$message, "infosEJ"=>$infosEJ, "infosEV"=>$infosEV, "infosE"=>$infosE ];
                $this->render("planning_s", $data);
            }
            $m->supprimerReservation($id);
            $m->removeCreneau($id);
            $ids = $m->getIdS($_SESSION['adr']);
            $donnees = 'Exposant : '. $_GET["nom"] . "\n" . 'Créneau : ' . $_GET['deb'] . ' - ' . $_GET['fin'] . "\n" . 'Jour : ' . $_GET["jour"];
            $m->insererModif($ids["id_superviseur"], 'DELETE', $donnees, "");
        }
        $infos = $m->getInfosS($_SESSION["adr"]);
        // On récupère les noms des exposants
        $infosE = $m->getExposant();
        // Si le tableau est vide
        if (count($infosE)==0) {
            // On retourne des variables vides
            $infosEJ = [];
            $infosEV = [];
        }
        // Sinon, on récupère les informations de chaque exposant en fonction du jour
        else {
            foreach ($infosE as $v) {
                $infosEJ[$v] = $m->getInfosDE($v, "Jeudi");
                $infosEV[$v] = $m->getInfosDE($v, "Vendredi");
            }
        }
        $message = "Veuillez importer votre fichier .csv";
        $data = ["infos"=>$infos, "message"=>$message, "infosEJ"=>$infosEJ, "infosEV"=>$infosEV, "infosE"=>$infosE ];
        $this->render("planning_s", $data);
    }

    /**
     * Action qui permet de trouver les créneaux correspondants aux choix de l'enseignant
     */
    public function action_rechercher() {
        $m = Model::getModel();
        // On récupère le nom de l'exposant, la description, la capacité et les créneaux disponibles
        $info = $m->getInfosPlanning($_POST["jour"], $_POST["debut"], $_POST["fin"], $_SESSION["niveau"]);
        $_SESSION["jour"] = $_POST["jour"];
        $_SESSION["debut"] = $_POST["debut"];
        $_SESSION["fin"] = $_POST["fin"];
        $exp = [];
        foreach ($info as $v) {
            $exp[] = $v['nom'];
        }
        // Tableau qui stock les informations qui seront affichées sur la page
        $infosE = [];
        /**
         * Pour un affichage des créneaux disponibles en fonction des exposants
        **/
        // On récupère le nom des exposants sans doublon
        foreach (array_unique($exp) as $v) {
            foreach ($info as $value) {
                // Si l'exposant est déjà dans le tableau, on ne rajoute pas le nom de l'exposant
                if (in_array($v, $infosE)) {
                    continue;
                }
                // Sinon, on ajoute le nom de l'exposant dans le tableau
                else {
                    $infosE[$v]['nom'] = $v;
                }
                // Si les noms des exposants correspondent
                if ($value['nom'] == $v) {
                    // On ajoute les informations correspondantes dans le tableau
                    $infosE[$v]['creneau'][$value['id_creneau']] = $value['heure_d'] . ' - ' . $value['heure_f'];
                    $infosE[$v]['description'] = $value['description'];
                    $infosE[$v]['capacite'] = $value['capacite'];
                }
            }
        }
        $data = ['infosE' => $infosE];
        $this->render("choix", $data);
    }


    /**
     * Méthode qui récupère les créneaux et affiche la page de confirmation des réservations
     */
    public function action_valider_reservation() {
        $m = Model::getModel();
        $donnees = [];
        // Si l'enseignant a selectionné au moins un créneau
        if (isset ($_POST['creneau'])) {
            for ($i = 0; $i < count($_POST['creneau']); $i++) {
                // On récupère les informations concernant ces créneaux
                $donnees[$_POST['creneau'][$i]] = $m->getInfosCreneau($_POST['creneau'][$i]);
            }
        }
        // Sinon, on reste sur la même page
        else {
            $info = $m->getInfosPlanning($_SESSION["jour"], $_SESSION["debut"], $_SESSION["fin"], $_SESSION["niveau"]);
            $exp = [];
            foreach ($info as $v) {
                $exp[] = $v['nom'];
            }
            $infosE = [];
            foreach (array_unique($exp) as $v) {
                foreach ($info as $value) {
                    if (in_array($v, $infosE)) {
                        continue;
                    }
                    else {
                        $infosE[$v]['nom'] = $v;
                    }
                    if ($value['nom'] == $v) {
                        $infosE[$v]['creneau'][$value['id_creneau']] = $value['heure_d'] . ' - ' . $value['heure_f'];
                        $infosE[$v]['description'] = $value['description'];
                        $infosE[$v]['capacite'] = $value['capacite'];
                    }
                }
            }
            $data = ['infosE' => $infosE];
            $this->render("choix", $data);
        }
        $data = ["donnees"=>$donnees];
        $this->render("valider_reservation", $data);
    }

    /**
     * Méthode qui permet de réserver des créneaux
     */
    public function action_reservation() {
        $m = Model::getModel();
        $id = $m->getIdP($_SESSION["adr"]);
        if (isset($_POST['creneau']) and isset($_POST['nb']) and isset($_POST['nom'])) {
            // Pour chaque créneau sélectionné
            for ($i = 0; $i < count($_POST['creneau']); $i++) {
                // On ajoute la réservation dans la base de données
                $m->addReservation($_POST['nom'][$i], $id['id_professeur'], $_POST['creneau'][$i], $_POST['nb'][$i]);
            }
        }
        $infos = $m->getInfosP($_SESSION["adr"]);
        $reservation = $m->getInfosReservP($id["id_professeur"]);
        $data = ['infos'=>$infos, 'reservation'=>$reservation];
        $this->render("reservations", $data);
    }

    /**
     * Méthode qui permet de supprimer une réservation (point de vue enseignant)
     */
    public function action_supprimerReservation() {
        $m = Model::getModel();
        if (isset($_GET['id'])) {
            $m->supprimerReservation($_GET['id']);
        }
        $infos = $m->getInfosP($_SESSION["adr"]);
        $id = $m->getIdP($_SESSION["adr"]);
        $reservation = $m->getInfosReservP($id["id_professeur"]);
        $data = ['infos'=>$infos, 'reservation'=>$reservation];
        $this->render("reservations", $data);
    }

    /**
     * Affiche page de confirmation pour supprimer un creneau
     */
    public function action_confirmSuppCreneau() {
        $m = Model::getModel();
        if (isset($_GET["id_creneau"]) and preg_match("/^[1-9]\d*$/", $_GET["id_creneau"]) and isset($_GET["nom"]) and isset($_GET["deb"]) and isset($_GET["fin"]) and isset($_GET["jour"])) {
            $data = $m->getInfosCreneau($_GET["id_creneau"]);
            $this->render('supprimerCreneau', $data);
        }
        else {}
    }

    /**
     * Affiche page de confirmation pour supprimer un creneau
     */
    public function action_confirmSuppCreneauV() {
        $m = Model::getModel();
        if (isset($_GET["id_creneau"]) and preg_match("/^[1-9]\d*$/", $_GET["id_creneau"]) and isset($_GET["nom"]) and isset($_GET["deb"]) and isset($_GET["fin"]) and isset($_GET["jour"])) {
            $data = $m->getInfosCreneau($_GET["id_creneau"]);
            $this->render('supprimerCreneauV', $data);
        }
        else {}
    }
}