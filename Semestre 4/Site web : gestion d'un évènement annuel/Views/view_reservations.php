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
                    <a class="nav-link" data-toggle="pill" href="?controller=compte&action=compte_p" role="tab" aria-controls="compte" aria-selected="false">
                        Mes informations
                    </a>
                    <a class="nav-link" data-toggle="pill" href="?controller=compte&action=planning_p" role="tab" aria-controls="planning" aria-selected="false">
                        Planning
                    </a>
                    <a class="nav-link active" data-toggle="pill" href="?controller=compte&action=reservation" role="tab" aria-controls="reservation" aria-selected="true">
                        Mes réservations
                    </a>
                </div>
            </div>
            <div class="tab-content p-4 p-md-5" id="v-pills-tabContent">
                <div class="tab-pane fade show active" id="compte" role="tabpanel" aria-labelledby="compte-tab">
                    <h3 class="mb-4">Mes réservations</h3>
                    <a href="?controller=compte&action=imprimerP" class="btn btn-outline-success btn-sm active" role="button">Imprimer</a><br><br>
                    <div style="height: 450px; overflow: auto;">
                        <table>
                            <tr>
                                <th>Exposant</th>
                                <th>Jour</th>
                                <th>Créneaux</th>
                            </tr>
                            <?php foreach ($reservation as $v) : ?>
                                <tr>
                                    <td> <?= e($v['nom']) ?> </td>
                                    <td> <?= $v['jour']?> </td>
                                    <td> <?=$v['heure_d']?> - <?=$v['heure_f']?> </td>
                                    <td class="sansBordure">
                                        <a href="?controller=planning&action=supprimerReservation&id=<?=$v['id_creneau']?>">
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
</section>
<?php require "view_end.php"; ?>

