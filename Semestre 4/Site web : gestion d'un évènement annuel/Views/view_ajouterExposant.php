<?php require "view_begin.php";?>
    <section class="py-5 my-5">
        <div class="container">
            <div class="bg-white shadow rounded-lg d-block d-sm-flex">
                <div class="tab-content p-4 p-md-5" id="v-pills-tabContent">
                    <div class="tab-pane fade show active" id="compte" role="tabpanel" aria-labelledby="compte-tab">
                        <a href="?controller=compte&action=listeexposant" class="faqretour">Retour</a><br><br>
                        <h3 class="mb-4">Ajouter un exposant</h3>
                        <h6 class="mb-4"><?=$message?></h6>
                        <form action="?controller=compte&action=addExposant" method="post">
                            <div class="row">
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <p><label> Exposant : <input type="text" class="form-control" name="exp" required/> </label></p>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <p><label> Description : <textarea cols="30" rows="4" name="description" class="form-control" required></textarea> </label></p>
                                    </div>
                                </div>
                                <div class="col-md-5">
                                    <div class="form-group">
                                        <p><label> Niveau :<br>
                                                <input type="checkbox" name="niveau[]" value="Primaire"> Primaire<br>
                                                <input type="checkbox" name="niveau[]" value="Collège"> Collège<br>
                                                <input type="checkbox" name="niveau[]" value="Lycée"> Lycée
                                        </label>
                                    </p>
                                    </div>
                                </div>
                                <div class="col-md-1">
                                    <div class="form-group">
                                        <p><label> Capacité : <input type="number" name="capacite" class="form-control" min="0" required/> </label></p>
                                    </div>
                                </div>
                                <div class="col-md-1">
                                    <div class="form-group">
                                        <p><label> Durée : <input type="number" name="duree" class="form-control" min="0" required/> </label></p>
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <p><label> Nombre de stand : <input type="number" name="nb" class="form-control" min="0" required/> </label></p>
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <p><label> Temps d'intersession : <input type="number" name="ti" class="form-control" min="0" required/> </label></p>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <p><label> Pause déjeuner - début : <input type="text"  class="form-control" name="hd"  value="Format h:m:s" required/> </label></p>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <p><label> Pause déjeuner - fin : <input type="text"  class="form-control" name="hf" value="Format h:m:s" required"/></label></p>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <p><label> 9h-18h?
                                                <select name="heure" required class="form-control">
                                                    <option disabled selected>--Veuillez sélectionner une réponse--</option>
                                                    <option value="oui">Oui</option>
                                                    <option value="non">Non</option>
                                                </select>
                                            </label>
                                        </p>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <p><label> Présence jeudi?
                                            <select name="pj" required class="form-control">
                                                <option disabled selected>--Veuillez sélectionner une réponse--</option>
                                                <option value="Présent">Oui</option>
                                                <option value="Absent">Non</option>
                                            </select>
                                        </label>
                                        </p>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <p><label> Présence vendredi?
                                            <select name="pv" required class="form-control">
                                                <option disabled selected>--Veuillez sélectionner une réponse--</option>
                                                <option value="Présent">Oui</option>
                                                <option value="Absent">Non</option>
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