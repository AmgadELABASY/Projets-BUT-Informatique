<?php require "view_begin.php";?>
<section class="py-5 my-5">
    <div class="container">
        <div class="bg-white shadow rounded-lg d-block d-sm-flex">
            <div class="border-right">
                <div class="p-4 text-center">
                    <div class="img-circle text-center mb-3">
                        <img src="Content/img/compte.png" alt="Icone d'un personnage" width="100px">
                    </div>
                    <h4 class="text-center"><?=$infos['prenom']?> <?=$infos['nom']?></h4>
                    <a href="?controller=compte&action=deconnexion" class="btn btn-outline-danger btn-sm active" role="button">Déconnexion</a>
                    <a href="?controller=home&action=home" class="btn btn-outline-secondary btn-sm active" role="button">Retour à la page d'accueil</a>
                </div>
                <div class="nav flex-column nav-pills" id="v-pills-tab" role="tablist" aria-orientation="vertical">
                    <a class="nav-link" data-toggle="pill" href="?controller=compte&action=compte_s" role="tab" aria-controls="compte" aria-selected="false">
                        Mes informations
                    </a>
                    <a class="nav-link active" data-toggle="pill" href="?controller=compte&action=planning_s" role="tab" aria-controls="planning" aria-selected="true">
                        Planning
                    </a>
                    <a class="nav-link" data-toggle="pill" href="?controller=compte&action=listeexposant" role="tab" aria-controls="listeexposant" aria-selected="false">
                        Liste des exposants
                    </a>
                    <a class="nav-link" data-toggle="pill" href="?controller=compte&action=listeenseignant" role="tab" aria-controls="listeenseignant" aria-selected="false">
                        Liste des enseignants
                    </a>
                    <a class="nav-link" data-toggle="pill" href="?controller=compte&action=modApp" role="tab" aria-controls="Modif" aria-selected="false">
                        Modifications appliquées
                    </a>
                    <a class="nav-link" data-toggle="pill" href="?controller=compte&action=creerS" role="tab" aria-controls="Csuperviseur" aria-selected="false">
                        Créer un compte superviseur
                    </a>
                </div>
            </div>
            <div class="tab-content p-4 p-md-5" id="v-pills-tabContent">
                <div class="tab-pane fade show active" id="compte" role="tabpanel" aria-labelledby="compte-tab">
                    <h3 class="mb-4">Planning</h3>
                    <h6><?=$message?></h6>
                    <form action="?controller=planning&action=import" method="post" enctype="multipart/form-data">
                        <input type="file" name="fichier" accept=".csv">
                        <input type="submit" class="btn btn-primary importer" name="import" value="Importer">
                    </form>
                    <a href="?controller=compte&action=formaddCreneau" class="btn btn-outline-dark btn-sm active" role="button">Ajouter un créneau</a>
                    <div style="height: 500px; overflow: auto;">
                        <?php foreach ($infosE as $v) : ?>
                        <details class="d1">
                            <summary><strong><?=$v?></strong></summary>
                            <details class="jeudi">
                                <summary>Jeudi</summary>
                            <table>
                                <thead>
                                <tr>
                                    <th>Créneaux</th>
                                    <th>Capacite</th>
                                    <th>Niveau</th>
                                    <th class="sansBordure"></th>
                                    <th class="sansBordure"></th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php foreach ($infosEJ[$v] as $p) : ?>
                                <tr>
                                        <td><?=$p['heure_d']?> - <?=$p['heure_f']?></td>
                                        <td><?=$p['capacite']?></td>
                                        <td><?=$p['niveau']?></td>
                                        <td class="sansBordure">
                                            <a href="?controller=planning&action=update&id_creneau=<?=$p['id_creneau']?>">
                                                <img class="icone" src="Content/img/edit-icon.png" alt="modifier"/>
                                            </a>
                                        </td>
                                        </td>
                                        <td class="sansBordure">
                                            <a href="?controller=planning&action=confirmSuppCreneau&id_creneau=<?=$p['id_creneau']?>&nom=<?=$v?>&deb=<?=$p['heure_d']?>&fin=<?=$p['heure_f']?>&jour=Jeudi">
                                                <img class="icone" src="Content/img/remove-icon.png" alt="supprimer"/>
                                            </a>
                                        </td>
                                </tr>
                                <?php endforeach?>
                                </tbody>
                            </table>
                            </details>
                            <details class="vendredi">
                                <summary>Vendredi</summary>
                            <table>
                                <thead>
                                <tr>
                                    <th>Créneaux</th>
                                    <th>Capacité</th>
                                    <th>Niveau</th>
                                    <th class="sansBordure"></th>
                                    <th class="sansBordure"></th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php foreach ($infosEV[$v] as $p) : ?>
                                <tr>
                                        <td><?=$p['heure_d']?> - <?=$p['heure_f']?></td>
                                        <td><?=$p['capacite']?></td>
                                        <td><?=$p['niveau']?></td>
                                        <td class="sansBordure">
                                            <a href="?controller=planning&action=update&id_creneau=<?=$p['id_creneau']?>">
                                                <img class="icone" src="Content/img/edit-icon.png" alt="modifier"/>
                                            </a>
                                        </td>
                                        </td>
                                        <td class="sansBordure">
                                            <a href="?controller=planning&action=confirmSuppCreneauV&id_creneau=<?=$p['id_creneau']?>&nom=<?=$v?>&deb=<?=$p['heure_d']?>&fin=<?=$p['heure_f']?>&jour=Vendredi">
                                                <img class="icone" src="Content/img/remove-icon.png" alt="supprimer"/>
                                            </a>
                                        </td>
                                </tr>
                                <?php endforeach?>
                                </tbody>
                            </table>
                            </details>
                        </details>
                        <?php endforeach;?>
                    </div>
            </div>
        </div>
    </div>
</section>
<?php require "view_end.php"; ?>

