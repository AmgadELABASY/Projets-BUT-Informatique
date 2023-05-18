<?php require "view_begin.php";?>
<section class="py-5 my-5">
    <div class="container">
        <div class="bg-white shadow rounded-lg d-block d-sm-flex">
            <div class="tab-content p-4 p-md-5" id="v-pills-tabContent">
                <div class="tab-pane fade show active" id="compte" role="tabpanel" aria-labelledby="compte-tab">
                    <a href="?controller=compte&action=planning_s" class="faqretour">Retour</a><br><br>
                    <h3 class="mb-4">Ajouter un créneau</h3>
                    <h6 class="mb-4"><?=$message?></h6>
                    <form action="?controller=compte&action=addCreneau" method="post">
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <p><label> Exposant :
                                            <select name="exp" class="form-control" required>
                                                <option disabled selected>--Veuillez sélectionner un exposant--</option>
                                                <?php foreach ($exposant as $v):?>
                                                <option value="<?=$v?>"><?=$v?></option>
                                                <?php endforeach;?>
                                            </select>
                                        </label></p>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <p><label> Heure - début : <input type="text"  class="form-control" name="hd"  value="Format h:m:s" required/> </label></p>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <p><label> Heure - fin : <input type="text"  class="form-control" name="hf" value="Format h:m:s" required"/></label></p>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <p><label> Jour :
                                            <select name="jour" required class="form-control">
                                                <option disabled selected>--Veuillez sélectionner une réponse--</option>
                                                <option value="Jeudi">Jeudi</option>
                                                <option value="Vendredi">Vendredi</option>
                                            </select>
                                        </label></p>
                                </div>
                            </div>
                        </div><br><br>
                        <input type="submit" value="Ajouter">
                    </form>
                </div>
            </div>
        </div>
</section>
<?php require "view_end.php"; ?>
