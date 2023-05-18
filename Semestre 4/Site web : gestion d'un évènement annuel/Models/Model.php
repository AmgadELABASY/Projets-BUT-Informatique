<?php

class Model
{
    /**
     * Attribut contenant l'instance PDO
     */
    private $bd;

    /**
     * Attribut statique qui contiendra l'unique instance de Model
     */
    private static $instance = null;

    /**
     * Constructeur du modèle : permet d'effectuer la connexion à la base de données
     */
    private function __construct()
    {
        include "credentials.php";
        $this->bd = new PDO($dsn, $login, $mdp);
        $this->bd->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $this->bd->query("SET nameS 'utf8'");
    }

    /**
     * Méthode permettant de récupérer le modèle
     */
    public static function getModel()
    {
        if (self::$instance === null) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    /**
     * Méthode qui permet de récupérer le mot de passe associé à l'adresse mail d'un professeur
     * @param string $adr qui représente l'adresse mail du professeur
     * @return mixed
     */
    public function loginP($adr) {
        $requete = $this->bd->prepare('SELECT Mot_de_passe FROM Professeur where Adresse_mail = :adr');
        $requete->bindValue(":adr", $adr);
        $requete->execute();
        return $requete->fetch(PDO::FETCH_ASSOC);
    }

    /**
     * Méthode qui permet de récupérer le mot de passe associé à l'adresse mail d'un superviseur
     * @param string $adr qui représente l'adresse mail du superviseur
     * @return mixed
     */
    public function loginS($adr) {
        $requete = $this->bd->prepare('SELECT Mot_de_passe FROM Superviseur where Adresse_mail = :adr');
        $requete->bindValue(":adr", $adr);
        $requete->execute();
        return $requete->fetch(PDO::FETCH_ASSOC);
    }

    /**
     * Méthode qui ajoute un professeur dans la base de données
     * @param array $infos qui contient les informations permettant de créer un compte professeur
     * @return bool qui indique si l'opération a été faite
     */
    public function addProfesseur($infos) {
        $requete = $this->bd->prepare('INSERT INTO professeur (Nom, Prenom, Adresse_mail, Mot_de_passe, Etablissement, Ville, Niveau, Nb_eleve_total) VALUES (:nom, :prenom, :adr, :mdp, :etablissement, :ville, :niveau, :nb)');
        $marqueurs = ['nom', 'prenom', 'adr', 'etablissement', 'ville', 'niveau', 'nb'];
        foreach ($marqueurs as $value) {
            $requete->bindValue(':' . $value, $infos[$value]);
        }
        $requete->bindValue(':mdp', password_hash($infos['mdp'], PASSWORD_DEFAULT));
        $requete->execute();
        return (bool) $requete->rowCount();
    }

    /**
     * Méthode qui ajoute un superviseur dans la base de données
     * @param array $infos qui contient les informations permettant de créer un compte superviseur
     * @return bool qui indique si l'opération a été faite
     */
    public function addSuperviseur($infos) {
        $requete = $this->bd->prepare('INSERT INTO superviseur (Nom, Prenom, Adresse_mail, Mot_de_passe) VALUES (:nom, :prenom, :adr, :mdp)');
        $marqueurs = ['nom', 'prenom', 'adr'];
        foreach ($marqueurs as $value) {
            $requete->bindValue(':' . $value, $infos[$value]);
        }
        // Il faut rajouter cette ligne pour crypter le mot de pass
        $mdp_crypte = password_hash($infos['mdp'],PASSWORD_DEFAULT);
        $requete->bindValue(':mdp', $mdp_crypte, PDO::PARAM_STR);
        $requete->execute();
        return (bool) $requete->rowCount();
    }

    /**
     * Méthode qui ajoute un exposant dans la base de données
     * @param array $infos qui contient les informations permettant de créer un compte exposant
     * @return bool qui indique si l'opération a été faite
     */
    public function addExposant($nom, $capacite, $description, $niveau, $presence_jeudi, $presence_vendredi, $nb_stand) {
        $requete = $this->bd->prepare('INSERT INTO exposant (Nom, Capacite, Description, Niveau, Presence_jeudi, Presence_vendredi, Nb_stand) VALUES (:nom, :capacite, :description, :niveau, :presence_j, :presence_v, :nb)');
        $requete->bindValue(':nom', $nom);
        $requete->bindValue(':capacite', intval($capacite));
        $requete->bindValue(':description', $description);
        $requete->bindValue(':niveau', $niveau);
        $requete->bindValue(':presence_j', $presence_jeudi);
        $requete->bindValue(':presence_v', $presence_vendredi);
        $requete->bindValue(':nb', intval($nb_stand));
        $requete->execute();
        return (bool) $requete->rowCount();
    }

    /**
     * Méthode permettant de récupérer la liste des exposants
     * @return array qui contient le nom des exposants
     */
    public function getExposant() {
        $requete = $this->bd->prepare('SELECT Nom FROM exposant order by Nom ASC');
        $requete->execute();
        $reponse = [];
        while ($ligne = $requete->fetch(PDO::FETCH_ASSOC)) {
            $reponse[] = $ligne['nom'];
        }
        return $reponse;
    }

    /**
     * Méthode permettant de récuperer l'id du superviseur
     * @param $adr adresse du superviseur
     * @return id du superviseur
     */
    public function getIdS($adr) {
        $requete = $this->bd->prepare('SELECT id_superviseur From Superviseur where adresse_mail = :adr');
        $requete->bindValue(':adr', $adr);
        $requete->execute();
        return $requete->fetch(PDO::FETCH_ASSOC);
    }

    /**
     * Méthode permettant de récuperer l'id de l'enseignant
     * @param $adr adresse de l'enseignant
     * @return id de l'enseignant
     */
    public function getIdP($adr) {
        $requete = $this->bd->prepare('SELECT id_professeur From Professeur where adresse_mail = :adr');
        $requete->bindValue(':adr', $adr);
        $requete->execute();
        return $requete->fetch(PDO::FETCH_ASSOC);
    }

    /**
     * Méthode permettant de récupérer les informations d'un enseignant
     * @return array qui contient le nom, prenom, adresse mail, etablissement, ville, nombre d'élève, niveau des élèves de l'enseignant
     */
    public function getInfosP($adr) {
        $requete = $this->bd->prepare('SELECT Nom, Prenom, Adresse_mail, Ville, Etablissement, Nb_eleve_total, Niveau FROM professeur WHERE Adresse_mail = :adr');
        $requete->bindValue(':adr', $adr);
        $requete->execute();
        return $requete->fetch(PDO::FETCH_ASSOC);
    }

    /**
     * Méthode permettant de récupérer les informations d'un enseignant
     * @return array qui contient le nom, prenom, adresse mail, etablissement, ville, nombre d'élève, niveau des élèves de l'enseignant
     */
    public function getInfosPId($id) {
        $requete = $this->bd->prepare('SELECT Id_professeur, Nom, Prenom, Adresse_mail, Ville, Etablissement, Nb_eleve_total, Niveau FROM professeur WHERE id_professeur = :id');
        $requete->bindValue(':id', $id);
        $requete->execute();
        return $requete->fetch(PDO::FETCH_ASSOC);
    }

    public function getInfosSId($id) {
        $requete = $this->bd->prepare('SELECT Id_superviseur, Nom, Prenom, Adresse_mail FROM superviseur WHERE id_superviseur = :id');
        $requete->bindValue(':id', $id);
        $requete->execute();
        return $requete->fetch(PDO::FETCH_ASSOC);
    }

    /**
     * Méthode permettant de récupérer les informations d'un exposant
     * @return array qui contient le nom de l'exposant
     */
    public function getInfosE($stand) {
        $requete = $this->bd->prepare('SELECT * FROM exposant WHERE Nom = :stand');
        $requete->bindValue(':stand', $stand);
        $requete->execute();
        return $requete->fetch(PDO::FETCH_ASSOC);
    }

    /**
     * Méthode permettant de récupérer les informations d'un superviseur
     * @return array qui contient le nom, prénom, l'adresse mail et le mot de passe du superviseur
     */
    public function getInfosS($adr) {
        $requete = $this->bd->prepare('SELECT Nom, Prenom, Adresse_mail, Mot_de_passe FROM superviseur WHERE Adresse_mail = :adr');
        $requete->bindValue(':adr', $adr);
        $requete->execute();
        return $requete->fetch(PDO::FETCH_ASSOC);
    }

    /**
     * Méthode permettant de modifier le mot de passe de l'enseignant
     * @param $mdp qui contient le nouveau mot de passe
     * @param $adr qui contient l'adresse mail de l'enseignant
     * @return bool qui indique si l'opération a été faite
     */
    public function nvMdpP($mdp, $adr) {
        $requete = $this->bd->prepare('UPDATE professeur SET Mot_de_passe = :mdp WHERE Adresse_mail = :adr');
        $requete->bindValue(':mdp', $mdp);
        $requete->bindValue(':adr', $adr);
        $requete->execute();
        return (bool) $requete->rowCount();
    }

    /**
     * Méthode permettant de modifier le mot de passe du superviseur
     * @param $mdp qui contient le nouveau mot de passe
     * @param $adr qui contient l'adresse mail de l'enseignant
     * @return bool qui indique si l'opération a été faite
     */
    public function nvMdpS($mdp, $adr) {
        $requete = $this->bd->prepare('UPDATE superviseur SET Mot_de_passe = :mdp WHERE Adresse_mail = :adr');
        $requete->bindValue(':mdp', $mdp);
        $requete->bindValue(':adr', $adr);
        $requete->execute();
        return (bool) $requete->rowCount();
    }

    /**
     * Méthode permettant de savoir si l'enseignant existe dans la base de données
     * @param $adr adresse mail de l'enseignant
     * @return bool
     */
    public function isInDataBaseP($adr)
    {
        return $this->getInfosP($adr) !== false;
    }

    /**
     * Méthode permettant de savoir si le superviseur existe dans la base de données
     * @param $adr adresse mail du superviseur
     * @return bool
     */
    public function isInDataBaseS($adr)
    {
        return $this->getInfosS($adr) !== false;
    }

    /**
     * Méthode permettant de savoir si l'exposant existe dans la base de données
     * @param $nom string nom de l'exposant
     * @return bool
     */
    public function isInDataBaseE($nom)
    {
        return $this->getInfosE($nom) !== false;
    }

    /**
     * Méthode permettant de modifier les infos de l'enseignant
     * @param $infos informations concernant l'enseignant
     * @param $adr adresse mail de l'enseignant
     * @return bool
     */
    public function updateCompteP($infos, $adr) {
        $requete = $this->bd->prepare('UPDATE professeur SET Etablissement = :etablissement, Ville = :ville, Niveau = :niveau, Nb_eleve_total = :nb WHERE Adresse_mail = :adr');
        $marqueurs = ['etablissement', 'ville', 'niveau', 'nb'];
        foreach ($marqueurs as $v) {
            $requete->bindValue(':'. $v, $infos[$v]);
        }
        $requete->bindValue(':adr', $adr);
        $requete->execute();
        return (bool) $requete->rowCount();
    }

    /**
     * Méthode permettant de modifier les infos du superviseur
     * @param $mdp mot de passe du superviseur
     * @param $adr adresse mail du superviseur
     * @return bool
     */
    public function updateCompteS($mdp, $adr) {
        $requete = $this->bd->prepare('UPDATE superviseur SET Mot_de_passe = :mdp WHERE Adresse_mail = :adr');
        $requete->bindValue(':mdp', password_hash($mdp, PASSWORD_DEFAULT));
        $requete->bindValue(':adr', $adr);
        $requete->execute();
        return (bool) $requete->rowCount();
    }

    /**
     * Méthode permettant de récupérer les modifications appliquées par les superviseurs
     * @return array qui contient l'action, la date, l'ancien tuple et le nouveau tuple
     */
    public function getModification() {
        $requete = $this->bd->prepare('SELECT nom, action, estampille, old_tuple, new_tuple from Journal_modification as j join Superviseur as s on j.Id_superviseur = s.Id_superviseur ORDER BY estampille DESC');
        $requete->execute();
        return $requete->fetchALL(PDO::FETCH_ASSOC);
    }

    /**
     * Méthode permettant d'insérer les données du fichier csv dans la base de données
     * @param $nom nom de l'exposant
     * @param $horaire string permettant de savoir si l'exposant est présent de 9h à 18h
     * @param $duree int représentant la durée
     * @param $tmp int représentant le temps d'intersession
     * @param $pause_d heure de début de la pause
     * @param $pause_f heure de fin de la pause
     * @return bool indiquant si l'opération a été effectuée
     */
    public function insererInfosPlanning($nom, $horaire, $duree, $tmp, $pause_d, $pause_f) {
        $requete = $this->bd->prepare('INSERT INTO planning (Nom, Horaire, Duree, Temps_intersession, Pause_debut, Pause_fin) VALUES (:nom, :horaire, :duree, :tmp, :pause_d, :pause_f)');
        $requete->bindValue(':nom', $nom);
        $requete->bindValue(':horaire', $horaire);
        $requete->bindValue(':duree', intval($duree));
        $requete->bindValue(':tmp', intval($tmp));
        $pause_debut = date("H:i:s", strtotime($pause_d));
        $requete->bindValue(':pause_d', $pause_debut);
        $pause_fin = date("H:i:s", strtotime($pause_f));
        $requete->bindValue(':pause_f', $pause_fin);
        $requete->execute();
        return (bool) $requete->rowCount();
    }

    /**
     * Methode permettant d'insérer les modifications des superviseurs
     * @param $superviseur int id du superviseur
     * @param $action event insert, update ou delete
     * @param $old string ancienne valeur
     * @param $new string nouvelle valeur
     * @return bool indiquant si l'opération a été effectuée
     */
    public function insererModif($superviseur, $action, $old, $new) {
        $requete = $this->bd->prepare('INSERT INTO journal_modification (Id_superviseur, action, old_tuple, new_tuple) VALUES (:superviseur, :action, :old, :new)');
        $requete->bindValue(':superviseur', $superviseur);
        $requete->bindValue(':action', $action);
        $requete->bindValue(':old', $old);
        $requete->bindValue(':new', $new);
        $requete->execute();
        return (bool) $requete->rowCount();
    }

    /**
     * Méthode permettant d'insérer les créneaux à partir du fichier csv
     * @param $nom string nom de l'exposant
     * @param $debut date heure de debut de l'activité
     * @param $fin date heure de fin de l'activité
     * @param $jour string jour de l'activité
     * @return bool qui indique si l'opération a été faite
     */
    public function insererCreneau($nom, $debut, $fin, $jour) {
        $requete = $this->bd->prepare('INSERT INTO creneau (nom, heure_d, heure_f, jour) VALUES (:nom, :heure_d, :heure_f, :jour)');
        $requete->bindValue(':nom', $nom);
        $requete->bindValue(':heure_d', $debut);
        $requete->bindValue(':heure_f', $fin);
        $requete->bindValue(':jour', $jour);
        $requete->execute();
        return (bool) $requete->rowCount();
    }

    /**
     * Méthode retournant les créneaux et leur réservation
     * @param $exp string nom de l'exposant
     * @param $jour string jour concerné
     * @return array contenant les informations des réservations
     */
    public function getInfosReserv($exp, $jour) {
        $requete = $this->bd->prepare('SELECT distinct heure_d, heure_f, etablissement, niveau, nb_eleve FROM Professeur as p left outer join Reservation as r on p.id_professeur=r.id_professeur right outer join Creneau as c on r.id_creneau=c.id_creneau where c.nom = :exp and jour = :jour Order by heure_d ASC');
        $requete->bindValue(':exp', $exp);
        $requete->bindValue(':jour', $jour);
        $requete->execute();
        return $requete->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Méthode retournant les créneaux en fonction des exposants
     * @param $stand string nom de l'exposant
     * @param $jour string jour concerné
     * @return array
     */
    public function getInfosDE($stand, $jour) {
        $requete = $this->bd->prepare('SELECT id_creneau, heure_d, heure_f, niveau, capacite FROM Exposant as e full outer join Creneau as c on e.nom = c.nom where jour = :jour and e.nom = :stand Order by heure_d ASC');
        $requete->bindValue(':jour', $jour);
        $requete->bindValue(':stand', $stand);
        $requete->execute();
        return $requete->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Méthode permettant de supprimer un créneau
     * @param $id int id du créneau
     * @return bool indiquant si l'opération a été faite
     */
    public function removeCreneau($id)
    {
        $requete = $this->bd->prepare("DELETE FROM creneau WHERE id_creneau = :id");
        $requete->bindValue(':id', $id);
        $requete->execute();
        return (bool) $requete->rowCount();
    }

    /**
     * Méthode permettant de récupérer les créneaux disponibles
     * @param $jour string jour de l'événement
     * @param $debut date heure d'arrivée de l'enseignant
     * @param $fin date heure de départ de l'enseignant
     * @param $niveau string niveau des élèves
     * @return array contenant les créneaux, description et capacité du stand
     */
    public function getInfosPlanning($jour, $debut, $fin, $niveau) {
        $niveau = '.*'.$niveau.'.*';
        $requete = $this->bd->prepare("SELECT distinct id_creneau, c.nom, heure_d, heure_f, description, capacite from Creneau as c join Exposant as e on c.nom = e.nom where jour = :jour and niveau ~ :niveau and heure_d >= :debut and heure_f <= :fin and id_creneau not in (Select id_creneau from Reservation) order by c.nom asc");
        $requete->bindValue(':jour', $jour);
        $requete->bindValue(':niveau', $niveau);
        $requete->bindValue(':debut', $debut);
        $requete->bindValue(':fin', $fin);
        $requete->execute();
        return $requete->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Méthode permettant de récupérer les réservations d'un enseignant
     * @param $id int id de l'enseignant
     * @return array contenant les créneaux, l'exposant et le jour
     */
    public function getInfosReservP($id) {
        $requete = $this->bd->prepare("SELECT c.nom, r.id_creneau, heure_d, heure_f, jour from Creneau as c join Reservation as r on c.id_creneau = r.id_creneau where id_professeur = :id ORDER BY heure_d ASC, heure_f ASC, jour ASC");
        $requete->bindValue(':id', $id);
        $requete->execute();
        return $requete->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Méthode permettant d'ajouter les informations de la réservation dans la base de données
     * @param $nom string nom de l'exposant
     * @param $id int id de l'enseignant
     * @param $idc int id du creneau
     * @param $nb int nombre d'élèves
     * @return void
     */
    public function addReservation($nom, $id, $idc, $nb) {
        $requete = $this->bd->prepare("INSERT INTO Reservation (Nom, id_professeur, id_creneau, nb_eleve) VALUES (:nom, :id, :idc, :nb)");
        $requete->bindValue(':nom', $nom);
        $requete->bindValue(':id', $id);
        $requete->bindValue(':idc', $idc);
        $requete->bindValue(':nb', $nb);
        $requete->execute();
    }

    /**
     * Méthode qui permet de récupérer les informations d'un créneau
     * @param $id int id du créneau
     * @return mixed
     */
    public function getInfosCreneau($id) {
        $requete = $this->bd->prepare("SELECT id_creneau, c.nom, heure_d, heure_f, jour, capacite, niveau from Creneau as c join Exposant as e on c.nom = e.nom where id_creneau = :id");
        $requete->bindValue(':id', $id);
        $requete->execute();
        return $requete->fetch(PDO::FETCH_ASSOC);
    }

    /**
     * Méthode qui permet de modifier un créneau
     * @param $id int id du créneau
     * @param $hd string heure de début
     * @param $hf string heure de fin
     * @return void
     */
    public function updateCreneau($id, $hd, $hf) {
        $requete = $this->bd->prepare("UPDATE Creneau SET heure_d = :hd, heure_f = :hf where id_creneau = :id ");
        $requete->bindValue(':id', $id);
        $requete->bindValue(':hd', $hd);
        $requete->bindValue(':hf', $hf);
        $requete->execute();
    }

    /**
     * Méthode permettant de supprimer une réservation
     * @param $id int id du créneau
     * @return bool indiquant si l'opération a été faite
     */
    public function supprimerReservation($id)
    {
        $requete = $this->bd->prepare("DELETE FROM reservation WHERE id_creneau = :id");
        $requete->bindValue(':id', $id);
        $requete->execute();
        return (bool) $requete->rowCount();
    }

    /**
     * Méthode qui retourne les informations de tous les exposants
     * @return array|false
     */
    public function getInfosExposant() {
        $requete = $this->bd->prepare("SELECT * FROM Exposant ORDER BY nom ASC");
        $requete->execute();
        return $requete->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Méthode qui supprime un exposant de la table exposant
     * @param $id int id de l'exposant
     * @return bool qui indique si l'opération a été faite
     */
    public function removeExposant($id){
        $requete = $this->bd->prepare("DELETE FROM Exposant WHERE id_exposant = :id");
        $requete->bindValue(':id', $id);
        $requete->execute();
        return (bool) $requete->rowCount();
    }

    /**
     * Méthode qui supprime un exposant de la table planning
     * @param $nom string id de l'exposant
     * @return bool qui indique si l'opération a été faite
     */
    public function removeExp($nom){
        $requete = $this->bd->prepare("DELETE FROM Planning WHERE nom = :nom");
        $requete->bindValue(':nom', $nom);
        $requete->execute();
        return (bool) $requete->rowCount();
    }

    /**
     * Méthode qui supprime un exposant de la table creneau
     * @param $nom string id de l'exposant
     * @return bool qui indique si l'opération a été faite
     */
    public function removeExp1($nom){
        $requete = $this->bd->prepare("DELETE FROM Creneau WHERE nom = :nom");
        $requete->bindValue(':nom', $nom);
        $requete->execute();
        return (bool) $requete->rowCount();
    }

    /**
     * Méthode qui supprime un exposant de la table reservation
     * @param $nom string id de l'exposant
     * @return bool qui indique si l'opération a été faite
     */
    public function removeExp2($nom){
        $requete = $this->bd->prepare("DELETE FROM Reservation WHERE nom = :nom");
        $requete->bindValue(':nom', $nom);
        $requete->execute();
        return (bool) $requete->rowCount();
    }

    /**
     * Méthode qui retourne les informations de tous les enseignants
     * @return array|false
     */
    public function getInfosEnseignant() {
        $requete = $this->bd->prepare("SELECT * FROM Professeur ORDER BY nom ASC");
        $requete->execute();
        return $requete->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getInfosSuperviseur(){
        $requete = $this->bd->prepare("SELECT * FROM superviseur ORDER BY nom ASC");
        $requete->execute();
        return $requete->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Méthode qui supprime un enseignant de la table professeur
     * @param $nom string id de l'exposant
     * @return bool qui indique si l'opération a été faite
     */
    public function removeProf($id) {
        $requete = $this->bd->prepare("DELETE FROM Professeur WHERE id_professeur = :id");
        $requete->bindValue(':id', $id);
        $requete->execute();
        return (bool) $requete->rowCount();
    }

    /**
     * Méthode qui supprime un enseignant de la table Reservation
     * @param $nom string id de l'exposant
     * @return bool qui indique si l'opération a été faite
     */
    public function removeProfR($id) {
        $requete = $this->bd->prepare("DELETE FROM Reservation WHERE id_professeur = :id");
        $requete->bindValue(':id', $id);
        $requete->execute();
        return (bool) $requete->rowCount();
    }

    


    /**
     * Méthode retournant l'id d'un créneau
     * @param $nom string nom de l'exposant
     * @param $hd string heure de début
     * @param $hf string heure de fin
     * @param $j string jour
     * @return mixed
     */
    public function getIdCreneau($nom, $hd, $hf, $j) {
        $requete = $this->bd->prepare('SELECT Id_creneau FROM Creneau WHERE nom = :nom and heure_d = :hd and heure_f = :hf and jour = :j');
        $requete->bindValue(':nom', $nom);
        $requete->bindValue(':hd', $hd);
        $requete->bindValue(':hf', $hf);
        $requete->bindValue(':j', $j);
        $requete->execute();
        return $requete->fetch(PDO::FETCH_ASSOC);
    }

    /**
     * Méthode permettant de savoir si le créneau existe déjà
     * @param $nom string nom de l'exposant
     * @param $hd string heure de début
     * @param $hf string heure de fin
     * @param $j string jour
     * @return mixed
     */
    public function isInDataBaseC($nom, $hd, $hf, $j)
    {
        return $this->getIdCreneau($nom, $hd, $hf, $j) !== false;
    }
}

