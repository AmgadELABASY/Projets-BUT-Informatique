<?php

class Controller_compte extends Controller
{
    /**
     * Affiche le compte de l'enseignant
     */
    public function action_compte_p() {
        $m = Model::getModel();
        $data = $m->getInfosP($_SESSION["adr"]);
        $this->render("compte_p", $data);
    }

    /**
     * Action par défaut du controller
     */
    public function action_default()
    {
        $this->action_compte_p();
    }

    /**
     * Affiche le compte de l'exposant
     */
    public function action_compte_e() {
        $m = Model::getModel();
        $nom = $m->getInfosE($_SESSION["stand"]);
        $infosJ = $m->getInfosReserv($_SESSION["stand"], 'Jeudi');
        $infosV = $m->getInfosReserv($_SESSION["stand"], 'Vendredi');
        $data = ["nom"=>$nom, "infosJ"=>$infosJ, "infosV"=>$infosV];
        $this->render("compte_e", $data);
    }

    /**
     * Affiche le compte du superviseur
     */
    public function action_compte_s() {
        $m = Model::getModel();
        $data = $m->getInfosS($_SESSION["adr"]);
        $this->render("compte_s", $data);
    }

    /**
     * Action qui permet de se déconnecter
     */
    public function action_deconnexion() {
        session_destroy();
        $data = [];
        // On retourne à la page d'accueil
        $this->render("home", $data);
    }

    /**
     * Affiche la page de planning de l'enseignant
     */
    public function action_planning_p() {
        $m = Model::getModel();
        $data = $m->getInfosP($_SESSION["adr"]);
        $this->render("planning_p", $data);
    }

    /**
     * Action qui permet de modifier les informations du professeur
     */
    public function action_update_p() {
        $m = Model::getModel();
        // Si les champs sont remplis
        if (isset($_POST["etablissement"]) and isset($_POST["ville"]) and isset($_POST["niveau"]) and isset($_POST["nb"])) {
            $_SESSION['niveau'] = $_POST['niveau'];
            $infos = [];
            $noms = ['etablissement', 'ville', 'niveau', 'nb'];
            foreach ($noms as $v) {
                if (isset($_POST[$v])) {
                    $infos[$v] = $_POST[$v];
                }
            }
            // On met à jour les informations dans la base de données
            $m->updateCompteP($infos, $_SESSION["adr"]);
        }
        // On récupère les données mises à jour
        $data = $m->getInfosP($_SESSION["adr"]);
        // On retourne à la page de compte
        $this->render("compte_p", $data);
    }

    /**
     * Action qui permet de modifier les informations du superviseur
     */
    public function action_update_s() {
        $m = Model::getModel();
        // Si les champs sont remplis
        if (isset($_POST["mdp"])) {
            // On met à jour les informations dans la base de données
            $m->updateCompteS($_POST["mdp"], $_SESSION["adr"]);
        }
        // On récupère les données mises à jour
        $data = $m->getInfosS($_SESSION["adr"]);
        // On retourne à la page de compte
        $this->render("compte_s", $data);
    }

    /**
     * Action qui permet d'afficher la page de création d'un compte superviseur
     */
    public function action_creerS() {
        $m = Model::getModel();
        $infos = $m->getInfosS($_SESSION["adr"]);
        $message = "Veuillez remplir les champs ci-dessous.";
        $data = [ "message"=>$message, "infos"=>$infos ];
        $this->render("inscription_s", $data);
    }

    /**
     * Action qui permet d'afficher la page des modifications appliquées par les superviseurs
     */
    public function action_modApp() {
        $m = Model::getModel();
        $modif = $m->getModification();
        $infos = $m->getInfosS($_SESSION["adr"]);
        $data = [ "modif"=>$modif, "infos"=>$infos ];
        $this->render("modifApp", $data);
    }

    /**
     * Action qui permet d'afficher la page de planning
     */
    public function action_planning_s() {
        $m = Model::getModel();
        $infos = $m->getInfosS($_SESSION["adr"]);
        $infosE = $m->getExposant();
        if (count($infosE)==0) {
            $infosEJ = [];
            $infosEV = [];
        }
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
     * Affiche la page des réservations de l'enseignant
     */
    public function action_reservation() {
        $m = Model::getModel();
        $infos = $m->getInfosP($_SESSION["adr"]);
        $id = $m->getIdP($_SESSION["adr"]);
        $reservation = $m->getInfosReservP($id["id_professeur"]);
        $data = ['infos'=>$infos, 'reservation'=>$reservation];
        $this->render("reservations", $data);
    }

    /**
     * Affiche la page contenant la liste des exposants
     */
    public function action_listeexposant(){
        $m = Model::getModel();
        $exposant = $m->getInfosExposant();
        $infos = $m->getInfosS($_SESSION["adr"]);
        $data = ['infos'=>$infos, 'exposant'=>$exposant];
        $this->render("liste_exposant", $data);
    }

    /**
     * Action qui permet de supprimer un exposant
     */
    public function action_removeExp(){
        $m = Model::getModel();
        if (isset($_GET["id"]) and preg_match("/^[1-9]\d*$/", $_GET["id"]) and isset($_GET["nom"])) {
            if ($_POST["submit"] == "Annuler") {
                $exposant = $m->getInfosExposant();
                $infos = $m->getInfosS($_SESSION["adr"]);
                $data = ['infos'=>$infos, 'exposant'=>$exposant];
                $this->render("liste_exposant", $data);
            }
            // On supprime l'exposant
            $m->removeExposant($_GET['id']);
            // On supprime les creneaux de l'exposant
            $m->removeExp2($_GET['nom']);
            // On supprime les reservations des enseignants pour cet exposant
            $m->removeExp1($_GET['nom']);
            // On supprime l'exposant de la table planning
            $m->removeExp($_GET['nom']);
            $ids = $m->getIdS($_SESSION['adr']);
            $donnees = 'Exposant : '. $_GET["nom"] ;
            $m->insererModif($ids["id_superviseur"], 'DELETE', $donnees, "");
        }
        $exposant = $m->getInfosExposant();
        $infos = $m->getInfosS($_SESSION["adr"]);
        $data = ['infos'=>$infos, 'exposant'=>$exposant];
        $this->render("liste_exposant", $data);
    }

    /**
     * Affiche la page contenant la liste des enseignants
     */
    public function action_listeenseignant(){
        $m = Model::getModel();
        $enseignant = $m->getInfosEnseignant();
        $infos = $m->getInfosS($_SESSION["adr"]);
        $data = ['infos'=>$infos, 'enseignant'=>$enseignant];
        $this->render("listeenseignant", $data);
    }

    public function action_listesuperviseur(){
        $m = Model::getModel();
        $superviseur = $m->getInfosSuperviseur();
        $infos = $m->getInfosS($_SESSION["adr"]);
        $data = ['infos'=>$infos, 'superviseur'=>$superviseur];
        $this->render("listesuperviseur",$data);
    }
    /**
     * Action qui permet de supprimer un enseignant
     */
    public function action_removeP(){
        $m = Model::getModel();
        if (isset($_GET["id"]) and preg_match("/^[1-9]\d*$/", $_GET["id"]) and isset($_GET["nom"]) and isset($_GET["prenom"])) {
            if ($_POST["submit"] == "Annuler") {
                $enseignant = $m->getInfosEnseignant();
                $infos = $m->getInfosS($_SESSION["adr"]);
                $data = ['infos'=>$infos, 'enseignant'=>$enseignant];
                $this->render("listeenseignant", $data);
            }
            // On supprime les réservations de l'enseignant
            $m->removeProfR($_GET['id']);
            // On supprime l'enseignant
            $m->removeProf($_GET['id']);
            $ids = $m->getIdS($_SESSION['adr']);
            $donnees = "Nom de l'enseignant : ". $_GET["nom"] . "\n" . 'Prénom : ' . $_GET['prenom'];
            $m->insererModif($ids["id_superviseur"], 'DELETE', $donnees, "");
        }
        $enseignant = $m->getInfosEnseignant();
        $infos = $m->getInfosS($_SESSION["adr"]);
        $data = ['infos'=>$infos, 'enseignant'=>$enseignant];
        $this->render("listeenseignant", $data);
    }

    public function action_removeSuperviseur(){
        $m = Model::getModel();
        if (isset($_GET["id"]) and preg_match("/^[1-9]\d*$/", $_GET["id"]) and isset($_GET["nom"]) and isset($_GET["prenom"])) {
            if ($_POST["submit"] == "Annuler") {
                $enseignant = $m->getInfosSuperviseur();
                $infos = $m->getInfosS($_SESSION["adr"]);
                $data = ['infos'=>$infos, 'superviseur'=>$superviseur];
                $this->render("listesuperviseur", $data);
            }
           
            $ids = $m->getIdS($_SESSION['adr']);
            $donnees = "Nom du superviseur : ". $_GET["nom"] . "\n" . 'Prénom : ' . $_GET['prenom'];
            $m->insererModif($ids["id_superviseur"], 'DELETE', $donnees, "");
        }
        $superviseur = $m->getInfosSuperviseur();
        $infos = $m->getInfosS($_SESSION["adr"]);
        $data = ['infos'=>$infos, 'superviseur'=>$superviseur];
        $this->render("listesuperviseur", $data);
    }

    /**
     * Action qui affiche le formulaire d'ajout d'un exposant
     */
    public function action_formaddExposant(){
        $m = Model::getModel();
        $message = "Veuillez compléter le formulaire ci-dessous.";
        $data = ["message"=>$message];
        $this->render("ajouterExposant", $data);
    }

    /**
     * Action qui permet d'ajouter un exposant et remplir ses créneaux automatiquement
     */
    public function action_addExposant() {
        $m = Model::getModel();
        // Si les champs du formulaire sont remplis
        if (isset($_POST['exp']) and isset($_POST['description']) and isset($_POST['niveau']) and isset($_POST['capacite']) and isset($_POST['duree']) and isset($_POST['ti']) and isset($_POST['hd']) and preg_match("/^(((09)|(1[0-7])):([0-5][0-9]):([0-5][0-9]))|(18:00:00)$/", $_POST["hd"]) and isset($_POST['hf']) and preg_match("/^(((09)|(1[0-7])):([0-5][0-9]):([0-5][0-9]))|(18:00:00)$/", $_POST["hf"]) and isset($_POST['heure']) and isset($_POST['pj']) and isset($_POST['pv']) and isset($_POST['nb'])) {
            // Si l'exposant est déjà dans la base de données
            if ($m->isInDataBaseE($_POST['exp'])) {
                // On affiche ce message
                $message = "Cet exposant existe déjà!";
                $data = ["message"=>$message];
                // On retourne à la page d'ajout
                $this->render("ajouterExposant", $data);
            }
            // Si on a réussi à insérer les informations dans le planning
            if ($m->insererInfosPlanning($_POST['exp'], $_POST['heure'], $_POST['duree'], $_POST['ti'], $_POST['hd'], $_POST['hf'])) {
                // Si c'est de 9h à 18h
                if ($_POST['heure'] == "oui") {
                    // S'il y a des erreurs de remplissage au niveau des horaires
                    if ($_POST['hd'] > $_POST['hf']) {
                        // On affiche une erreur
                        $message = "Erreur : La pause déjeuner - début est supérieur à la pause déjeuner - fin!";
                        $data = ["message"=>$message];
                        $this->render("ajouterExposant", $data);
                    }
                    // Sinon, on affecte 9h à "début"
                    $debut = strtotime("9:00:00");
                    // Et on affecte à "fin" l'heure de début de la pause déjeuner
                    $fin = strtotime($_POST['hd']);
                    // Tant que le début + la durée est inférieur à la pause déjeuner
                    while ($debut + intval($_POST['duree']) * 60 <= $fin) {
                        // Si l'exposant est présent Jeudi
                        if ($_POST['pj'] == "Présent") {
                            // On créé les créneaux autant de fois qu'il y a d'activité en parallèle sur un même créneau
                            for ($i = 0; $i < $_POST['nb']; $i++) {
                                $m->insererCreneau($_POST['exp'], date("H:i:s", $debut), date("H:i:s", $debut + intval($_POST['duree']) * 60), "Jeudi");
                            }
                        }
                        // Si l'exposant est présent Vendredi
                        if ($_POST['pv'] == "Présent") {
                            // On créé les créneaux autant de fois qu'il y a d'activité en parallèle sur un même créneau
                            for ($i = 0; $i < $_POST['nb']; $i++) {
                                $m->insererCreneau($_POST['exp'], date("H:i:s", $debut), date("H:i:s", $debut + intval($_POST['duree']) * 60), "Vendredi");
                            }
                        }
                        // On ajoute à l'heure de début, la durée et le temps d'intersession
                        $debut += (intval($_POST['duree']) + intval($_POST['ti'])) * 60;
                    }

                    // On affecte à "debut2", l'heure de fin de la pause déjeuner
                    $debut2 = strtotime($_POST['hf']);
                    // Et on affecte à "fin" 18h
                    $fin2 = strtotime("18:00:00");
                    // Tant que le début + la durée est inférieur à la pause déjeuner
                    while ($debut2 + intval($_POST['duree']) * 60 <= $fin2) {
                        // Si l'exposant est présent Jeudi
                        if ($_POST['pj'] == "Présent") {
                            // On créé les créneaux autant de fois qu'il y a d'activité en parallèle sur un même créneau
                            for ($i = 0; $i < $_POST['nb']; $i++) {
                                $m->insererCreneau($_POST['exp'], date("H:i:s", $debut2), date("H:i:s", $debut2 + intval($_POST['duree']) * 60), "Jeudi");
                            }
                        }
                        // Si l'exposant est présent Vendredi
                        if ($_POST['pv'] == "Présent") {
                            // On créé les créneaux autant de fois qu'il y a d'activité en parallèle sur un même créneau
                            for ($i = 0; $i < $_POST['nb']; $i++) {
                                $m->insererCreneau($_POST['exp'], date("H:i:s", $debut2), date("H:i:s", $debut2 + intval($_POST['duree']) * 60), "Vendredi");
                            }
                        }
                        // On ajoute à l'heure de début, la durée et le temps d'intersession
                        $debut2 += (intval($_POST['duree']) + intval($_POST['ti'])) * 60;
                    }
                }
            }
            else {
                $message = "Une erreur est survenue.";
                $data = ["message"=>$message];
                $this->render("ajouterExposant", $data);
            }
            /**
             * Pour un affichage de plusieurs niveaux sélectionnés identiques à celui dans la base de données
             **/
            // On affecte à "niveau" le premier niveau sélectionné
            $niveau = $_POST['niveau'][0];
            // S'il y en a plusieurs, on rajoute la virgule entre chaque niveau
            for ($i = 1; $i < count($_POST['niveau'])-1; $i++) {
                $niveau = $niveau . ', ' . $_POST['niveau'][$i];
            }
            // Pour le dernier niveau, il ne faut pas de virgule à la fin
            if (count($_POST['niveau']) > 1) {
                $niveau = $niveau . ', ' . $_POST['niveau'][$i];
            }
            // On ajoute l'exposant dans la base de données
            $m->addExposant($_POST['exp'], $_POST['capacite'], $_POST['description'], $niveau, $_POST['pj'], $_POST['pv'], $_POST['nb']);
            $ids = $m->getIdS($_SESSION['adr']);
            $donnees = "Exposant : ". $_POST["exp"];
            $m->insererModif($ids["id_superviseur"], "INSERT", "", $donnees);
        }
        else {
            $message = "Le formulaire n'a pas été complété correctement!";
            $data = ["message"=>$message];
            $this->render("ajouterExposant", $data);
        }
        $message = "L'exposant a été ajouté.";
        $data = ["message"=>$message];
        $this->render("ajouterExposant", $data);
    }

    /**
     * Action qui affiche le formulaire d'ajout d'un creneau
     */
    public function action_formaddCreneau(){
        $m = Model::getModel();
        $exposant = $m->getExposant();
        $message = "Veuillez compléter le formulaire ci-dessous.";
        $data = ["message"=>$message, "exposant"=>$exposant];
        $this->render("ajouterCreneau", $data);
    }

    /**
     * Action qui permet d'ajouter un créneau
     */
    public function action_addCreneau() {
        $m = Model::getModel();
        if (isset($_POST['exp']) and isset($_POST['jour']) and isset($_POST['hd']) and preg_match("/^(((09)|(1[0-7])):([0-5][0-9]):([0-5][0-9]))|(18:00:00)$/", $_POST["hd"]) and isset($_POST['hf']) and preg_match("/^(((09)|(1[0-7])):([0-5][0-9]):([0-5][0-9]))|(18:00:00)$/", $_POST["hf"])) {
            $m->insererCreneau($_POST['exp'], $_POST['hd'], $_POST['hf'], $_POST['jour']);
            $ids = $m->getIdS($_SESSION['adr']);
            $donnees = "Exposant : ". $_POST["exp"] . "\n" . "Créneau : ". $_POST["hd"] . ' - ' . $_POST['hf'] . "\n" . 'Jour : ' . $_POST['jour'];
            $m->insererModif($ids["id_superviseur"], "INSERT", "", $donnees);
        }
        else {
            $exposant = $m->getExposant();
            $message = "Le formulaire n'a pas été complété correctement!";
            $data = ["message"=>$message, "exposant"=>$exposant];
            $this->render("ajouterCreneau", $data);
        }
        $exposant = $m->getExposant();
        $message = "Le créneau a été ajouté!";
        $data = ["message"=>$message, "exposant"=>$exposant];
        $this->render("ajouterCreneau", $data);
    }

    /**
     * Action qui permet d'imprimer les réservations d'un enseignant
     */
    public function action_imprimerP() {
        require_once("fpdf185/fpdf.php");
        $pdf = new FPDF();
        $pdf->AddPage();
        $pdf->SetFont('Times', '', '12');
        $pdf->Cell(100,10,"Exposant",1,0);
        $pdf->Cell(40,10,"Jour",1,0);
        $pdf->Cell(50,10,"Creneaux",1,0);
        $pdf->Ln();
        $m = Model::getModel();
        $id = $m->getIdP($_SESSION["adr"]);
        $reservation = $m->getInfosReservP($id["id_professeur"]);
        foreach ($reservation as $v) {
            $pdf->Cell(100,10,$v['nom'],1,0);
            $pdf->Cell(40,10,$v['jour'],1,0);
            $pdf->Cell(50,10,$v['heure_d'] . ' - ' . $v['heure_f'],1,0);
            $pdf->Ln();
        }
        $file = 'Mes_reservations.pdf';
        $pdf->output($file, 'D');
    }

    /**
     * Affiche page de confirmation pour supprimer un exposant
     */
    public function action_confirmSuppExposant() {
        $m = Model::getModel();
        if (isset($_GET["id"]) and preg_match("/^[1-9]\d*$/", $_GET["id"]) and isset($_GET["nom"])) {
            $data = $m->getInfosE($_GET["nom"]);
            $this->render('supprimerExposant', $data);
        }
        else {}
    }

    /**
     * Affiche page de confirmation pour supprimer un enseignant
     */
    public function action_confirmSuppEnseignant() {
        $m = Model::getModel();
        if (isset($_GET["id"]) and preg_match("/^[1-9]\d*$/", $_GET["id"]) and isset($_GET["nom"]) and isset($_GET["prenom"])) {
            $data = $m->getInfosPId($_GET["id"]);
            $this->render('supprimerEnseignant', $data);
        }
        else {}
    }

    public function action_confirmSuppSuperviseur() {
        $m = Model::getModel();
        if (isset($_GET["id"]) and preg_match("/^[1-9]\d*$/", $_GET["id"]) and isset($_GET["nom"]) and isset($_GET["prenom"])) {
            $data = $m->getInfosPId($_GET["id"]);
            $this->render('supprimerSuperviseur', $data);
        }
        else {}
    }

    /**
     * Action qui permet d'imprimer les réservations du point de vue exposant
     */
    public function action_imprimerE() {
        require_once("fpdf185/fpdf.php");
        $pdf = new FPDF();
        $pdf->AddPage();
        $pdf->SetFont('Times', '', '12');
        $pdf->Cell(180,10,"Jeudi",1,0);
        $pdf->Ln();
        $pdf->Cell(40,10,"Creneau",1,0);
        $pdf->Cell(70,10,"Etablissement",1,0);
        $pdf->Cell(30,10,"Niveau",1,0);
        $pdf->Cell(40,10,"Nombre d'élèves",1,0);
        $pdf->Ln();
        $m = Model::getModel();
        $infosJ = $m->getInfosReserv($_SESSION["stand"], 'Jeudi');
        $infosV = $m->getInfosReserv($_SESSION["stand"], 'Vendredi');
        foreach ($infosJ as $v) {
            $pdf->Cell(40,10,$v['heure_d'] . ' - ' . $v['heure_f'],1,0);
            $pdf->Cell(70,10,$v['etablissement'],1,0);
            $pdf->Cell(30,10,$v['niveau'],1,0);
            $pdf->Cell(40,10,$v['nb_eleve'],1,0);
            $pdf->Ln();
        }
        $pdf->Ln();
        $pdf->Cell(180,10,"Vendredi",1,0);
        $pdf->Ln();
        $pdf->Cell(40,10,"Creneau",1,0);
        $pdf->Cell(70,10,"Etablissement",1,0);
        $pdf->Cell(30,10,"Niveau",1,0);
        $pdf->Cell(40,10,"Nombre d'élèves",1,0);
        $pdf->Ln();
        foreach ($infosV as $v) {
            $pdf->Cell(40,10,$v['heure_d'] . ' - ' . $v['heure_f'],1,0);
            $pdf->Cell(70,10,$v['etablissement'],1,0);
            $pdf->Cell(50,10,$v['niveau'],1,0);
            $pdf->Cell(40,10,$v['nb_eleve'],1,0);
            $pdf->Ln();
        }
        $pdf->Ln();
        $file = 'Planning_exposant.pdf';
        $pdf->output($file, 'D');
    }
}