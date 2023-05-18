<?php require "view_begin.php";?>
<section class="py-5 my-5">
    <div class="container">
        <div class="bg-white shadow rounded-lg d-block d-sm-flex">
            <div class="border-right">
                <div class="p-4 text-center">
                    <div class="img-circle text-center mb-3">
                        <img src="Content/img/compte.png" alt="Icone d'un personnage" width="100px">
                    </div>
                    <h4 class="text-center"><?=e($prenom)?> <?=e($nom)?></h4>
                    <a href="?controller=compte&action=deconnexion" class="btn btn-outline-danger btn-sm active" role="button">Déconnexion</a>
                    <a href="?controller=home&action=home" class="btn btn-outline-secondary btn-sm active" role="button">Retour à la page d'accueil</a>
                </div>
                <div class="nav flex-column nav-pills" id="v-pills-tab" role="tablist" aria-orientation="vertical">
                    <a class="nav-link active" data-toggle="pill" href="#compte" role="tab" aria-controls="compte" aria-selected="true">
                        Mes informations
                    </a>
                    <a class="nav-link" data-toggle="pill" href="?controller=compte&action=planning_p" role="tab" aria-controls="planning" aria-selected="false">
                        Planning
                    </a>
                    <a class="nav-link" data-toggle="pill" href="?controller=compte&action=reservation" role="tab" aria-controls="reservation" aria-selected="false">
                        Mes réservations
                    </a>
                </div>
            </div>
            <div class="tab-content p-4 p-md-5" id="v-pills-tabContent">
                <div class="tab-pane fade show active" id="compte" role="tabpanel" aria-labelledby="compte-tab">
                    <h3 class="mb-4">Mon compte</h3>
                    <form action="?controller=compte&action=update_p" method="post">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Prénom</label>
                                <input type="text" class="form-control" name="prenom" value="<?=e($prenom)?>" disabled>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Nom</label>
                                <input type="text" class="form-control" name="nom" value="<?=e($nom)?>" disabled>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Email</label>
                                <input type="email" class="form-control" name="adr" value="<?=e($adresse_mail)?>" disabled>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Nom d'établissement</label>
                                <input type="text" class="form-control" name="etablissement" value="<?php if (NULL == $etablissement) {echo ' ';} else {echo e($etablissement);}?>">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Ville</label>
                                <input type="text" class="form-control" name="ville" value="<?php if (NULL == $ville) {echo ' ';} else {echo e($ville);}?>">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Niveau des élèves</label>
                                <select class="form-control" name="niveau">
                                    <option disabled>--Veuillez choisir le niveau de vos élèves--</option>
                                    <option value="Primaire" <?php if ("Primaire" == $niveau) { echo 'selected'; } ?>>Primaire</option>
                                    <option value="Collège" <?php if ("Collège" == $niveau) { echo 'selected'; } ?>>Collège</option>
                                    <option value="Lycée" <?php if ("Lycée" == $niveau) { echo 'selected'; } ?>>Lycée</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <label>Nombre d'élèves</label>
                                <input type="number" class="form-control" name="nb" value="<?=e($nb_eleve_total)?>">
                            </div>
                        </div>
                    </div>
                    <br><br>
                    <div>
                        <input type="submit" value="Modifier">
                    </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>
<?php require "view_end.php"; ?>
