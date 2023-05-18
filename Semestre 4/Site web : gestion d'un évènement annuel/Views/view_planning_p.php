<?php require "view_begin.php";?>
<section class="py-5 my-5">
    <div class="container">
        <div class="bg-white shadow rounded-lg d-block d-sm-flex">
            <div class="border-right">
                <div class="p-4 text-center">
                    <div class="img-circle text-center mb-3">
                        <img src="Content/img/compte.png" alt="Icone d'un personnage" width="100px">
                    </div>
                    <h4 class="text-center"><?=$prenom?> <?=$nom?></h4>
                    <a href="?controller=compte&action=deconnexion" class="btn btn-outline-danger btn-sm active" role="button">Déconnexion</a>
                    <a href="?controller=home&action=home" class="btn btn-outline-secondary btn-sm active" role="button">Retour à la page d'accueil</a>
                </div>
                <div class="nav flex-column nav-pills" id="v-pills-tab" role="tablist" aria-orientation="vertical">
                    <a class="nav-link" data-toggle="pill" href="?controller=compte&action=compte_p" role="tab" aria-controls="compte" aria-selected="false">
                        Mes informations
                    </a>
                    <a class="nav-link active" data-toggle="pill" href="?controller=compte&action=planning_p" role="tab" aria-controls="planning" aria-selected="true">
                        Planning
                    </a>
                    <a class="nav-link" data-toggle="pill" href="?controller=compte&action=reservation" role="tab" aria-controls="reservation" aria-selected="false">
                        Mes réservations
                    </a>
                </div>
            </div>
            <div class="tab-content p-4 p-md-5" id="v-pills-tabContent">
                <div class="tab-pane fade show active" id="planning" role="tabpanel" aria-labelledby="planning-tab">
                    <h3 class="mb-4">Planning</h3>
                <form action="?controller=planning&action=rechercher" method="post">
                    <div class="row">
                        <div class="col-md-7">
                            <div class="form-group">
                            <select id="jour-selection" name="jour" class="form-control" required>
                                <option value="" selected disabled>Choisissez un jour</option>
                                <option value="Jeudi">Jeudi</option>
                                <option value="Vendredi">Vendredi</option>
                            </select>
                            </div>
                        </div>
                        <br><br>
                        <div class="col-md-7">
                            <div class="form-group">
                            <select id="niveau-selection" name="debut" class="form-control" required>
                                <option value="" selected disabled>Choisissez une heure de début</option>
                                <option value="09:00:00">9h</option>
                                <option value="10:00:00">10h</option>
                                <option value="11:00:00">11h</option>
                                <option value="12:00:00">12h</option>
                                <option value="13:00:00">13h</option>
                                <option value="14:00:00">14h</option>
                                <option value="15:00:00">15h</option>
                                <option value="16:00:00">16h</option>
                                <option value="17:00:00">17h</option>
                            </select>
                            </div>
                        </div>
                        <br><br>
                        <div class="col-md-7">
                            <div class="form-group">
                            <select id="niveau-selection" class="form-control" name="fin" required>
                                <option value="" selected disabled>Choisissez une heure de fin</option>
                                <option value="10:00:00">10h</option>
                                <option value="11:00:00">11h</option>
                                <option value="12:00:00">12h</option>
                                <option value="13:00:00">13h</option>
                                <option value="14:00:00">14h</option>
                                <option value="15:00:00">15h</option>
                                <option value="16:00:00">16h</option>
                                <option value="17:00:00">17h</option>
                                <option value="18:00:00">18h</option>
                            </select>
                            </div>
                        </div>
                        <br><br><br>
                        <div>
                            <input type="submit" class="rechercher" value="Rechercher">
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>
<?php require "view_end.php"; ?>
