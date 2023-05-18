<?php require "view_begin.php";?>
    <section class="py-5 my-5">
        <div class="container">
            <div class="bg-white shadow rounded-lg d-block d-sm-flex">
                <div class="tab-content p-4 p-md-5" id="v-pills-tabContent">
                    <div class="tab-pane fade show active" id="compte" role="tabpanel" aria-labelledby="compte-tab">
                        <a href="?controller=compte&action=planning_s" class="faqretour">Retour</a><br><br>
                        <h3 class="mb-4">Modification</h3>
                        <?=$message?>
                        <form action="?controller=planning&action=updated" method="post">
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <input type="hidden" name="id" value="<?= e($creneau["id_creneau"]) ?>" />
                                        <p><label> Exposant : <input type="text"  class="form-control" name="exp" value="<?= e($creneau['nom']) ?>" disabled/> </label></p>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <p><label> Jour : <input type="text"  class="form-control" name="jour" value="<?= e($creneau['jour']) ?>" disabled/> </label></p>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <p><label> Capacité : <input type="number"  class="form-control" name="capacite" value="<?= e($creneau['capacite']) ?>" disabled/> </label></p>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <p><label> Niveau: <input type="text"  class="form-control" name="niveau" value="<?= e($creneau['niveau']) ?>" disabled/></label></p><br><br>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <p><label> Heure de début : <input type="text"  class="form-control" name="hd" value="<?= e($creneau['heure_d']) ?>"/> </label></p>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <p><label> Heure de fin : <input type="text"  class="form-control" name="hf" value="<?= e($creneau['heure_f']) ?>"/></label></p>
                                    </div>
                                </div>
                            </div>
                            <input type="submit" value="Modifier">
                        </form>
                    </div>
                </div>
            </div>
    </section>
<?php require "view_end.php"; ?>