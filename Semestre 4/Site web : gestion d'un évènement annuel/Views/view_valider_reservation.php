<?php require "view_begin.php";?>
<section class="py-5 my-5">
    <div class="container">
        <div class="bg-white shadow rounded-lg d-block d-sm-flex">
            <div class="tab-content p-4 p-md-5" id="v-pills-tabContent">
                <div class="tab-pane fade show active" id="compte" role="tabpanel" aria-labelledby="compte-tab">
                    <a href="?controller=compte&action=planning_p" class="faqretour">Retour</a><br><br>
                    <h3 class="mb-4">Veuillez confirmer vos réservations </h3>
                    <form action="?controller=planning&action=reservation" method="post">
                        <?php foreach ($donnees as $v) :?>
                            <h4>Exposant : <?= $v['nom'] ?></h4>
                            <input type="hidden" name="nom[]" value="<?= $v['nom'] ?>"/>
                            <p><strong>Créneaux : </strong><?=$v['heure_d']?> - <?=$v['heure_f']?></p>
                            <input type="hidden" name="creneau[]" value="<?= $v['id_creneau'] ?>"/>
                            <p><strong>Capacité d'accueil :</strong> <?=$v['capacite']?></p>
                            <p><strong>Nombre d'élèves : </strong><input type="number" name="nb[]" required max="<?=$v['capacite']?>" min="0"/></p><br><br>
                        <?php endforeach;?>
                        <input type="submit" value="Confirmer la réservation">
                    </form>
                </div>
            </div>
        </div>
</section>
<?php require "view_end.php"; ?>
