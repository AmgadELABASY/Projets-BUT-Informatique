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
                    <a class="nav-link" data-toggle="pill" href="?controller=compte&action=planning_s" role="tab" aria-controls="planning" aria-selected="false">
                        Planning
                    </a>
                    <a class="nav-link" data-toggle="pill" href="?controller=compte&action=listeexposant" role="tab" aria-controls="listeexposant" aria-selected="false">
                        Liste des exposants
                    </a>
                    <a class="nav-link active" data-toggle="pill" href="?controller=compte&action=listeenseignant" role="tab" aria-controls="listeenseignant" aria-selected="true">
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
                    <h3 class="mb-4">Liste des superviseurs</h3>
                    <div style="height: 500px; overflow: auto;">
                        <table>
                            <tr>
                                <th>Nom</th>
                                <th>Prénom</th>
                                <th>Adresse mail</th>
                            </tr>
                            <?php foreach ($superviseur as $v) : ?>
                                <tr>
                                    <td> <?= e($v['nom']) ?> </td>
                                    <td> <?= e($v['prenom']) ?> </td>
                                    <td> <?= e($v['adresse_mail']) ?> </td>
                                    <td class="sansBordure">
                                        <a href="?controller=compte&action=confirmSuppSuperviseur&id=<?=$v['id_superviseur']?>&nom=<?=$v['nom']?>&prenom=<?=$v['prenom']?>">
                                            <img class="icone" src="Content/img/remove-icon.png" alt="supprimer"/>
                                        </a>
                                    </td>
                                </tr>
                            <?php endforeach ?>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<?php require "view_end.php"; ?>
