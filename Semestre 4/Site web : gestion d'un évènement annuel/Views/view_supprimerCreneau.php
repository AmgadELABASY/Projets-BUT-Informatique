<?php require "view_begin.php";?>
<section class="py-5 my-5">
    <div class="container">
        <div class="bg-white shadow rounded-lg d-block d-sm-flex">
            <div class="tab-content p-4 p-md-5" id="v-pills-tabContent">
                <div class="tab-pane fade show active" id="compte" role="tabpanel" aria-labelledby="compte-tab">
                    <h3 class="mb-4">Êtes-vous sûr de vouloir supprimer ce créneau ?</h3>
                    <form action="?controller=planning&action=remove&id_creneau=<?=$id_creneau?>&nom=<?=$nom?>&deb=<?=$heure_d?>&fin=<?=$heure_f?>&jour=Jeudi" method="post">
                        <h4>Exposant : <?= $nom ?></h4>
                        <p><strong>Créneaux : </strong><?=$heure_d?> - <?=$heure_f?></p>
                        <p><strong>Jour : </strong>Jeudi</p>
                        <input type="submit" name="submit" value="Supprimer" class="confirmation supprimer">
                        <input type="submit" name="submit" value="Annuler" class="confirmation">
                    </form>
                </div>
            </div>
        </div>
</section>
<?php require "view_end.php"; ?>
