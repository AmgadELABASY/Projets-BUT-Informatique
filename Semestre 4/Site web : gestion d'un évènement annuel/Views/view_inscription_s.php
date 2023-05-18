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
                        <a class="nav-link" data-toggle="pill" href="?controller=compte&action=listeenseignant" role="tab" aria-controls="listeenseignant" aria-selected="false">
                            Liste des enseignants
                        </a>
                        <a class="nav-link" data-toggle="pill" href="?controller=compte&action=modApp" role="tab" aria-controls="Modif" aria-selected="false">
                            Modifications appliquées
                        </a>
                        <a class="nav-link active" data-toggle="pill" href="?controller=compte&action=creerS" role="tab" aria-controls="Csuperviseur" aria-selected="true">
                            Créer un compte superviseur
                        </a>
                    </div>
                </div>
                <div class="tab-content p-4 p-md-5" id="v-pills-tabContent">
                    <div class="tab-pane fade show active" id="compte" role="tabpanel" aria-labelledby="compte-tab">
                        <h3 class="mb-4">Créer un compte superviseur</h3>
                        <h6 class="mb-4"><?=$message?></h6>
                        <form action="?controller=inscription&action=creation_s" method="post">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Prénom</label>
                                        <input type="text" class="form-control" name="prenom">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Nom</label>
                                        <input type="text" class="form-control" name="nom">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Email</label>
                                        <input type="email" class="form-control" name="adr">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Mot de passe</label>
                                        <input type="password" class="form-control monmdp" name="mdp">
                                        <i class="far fa-eye" id="togglePassword" style="margin-left: 1px; cursor: pointer;"></i>
                                    </div>
                                </div>
                            </div>
                            <br><br>
                            <div>
                                <input type="submit" value="Créer">
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
<?php require "view_end.php"; ?>