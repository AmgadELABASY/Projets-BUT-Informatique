<?php require "view_begin.php";?>
<section class="py-5 my-5">
    <div class="container">
        <div class="bg-white shadow rounded-lg d-block d-sm-flex">
            <div class="tab-content p-4 p-md-5" id="v-pills-tabContent">
                <div class="tab-pane fade show active" id="compte" role="tabpanel" aria-labelledby="compte-tab">
                    <a href="?controller=compte&action=planning_p" class="faqretour">Retour</a><br><br>
                    <h3 class="mb-4">Créneaux disponibles</h3>
                    <form action="?controller=planning&action=valider_reservation" method="post">
                    <?php foreach ($infosE as $v) : ?>
                    <details class="d1">
                        <summary><strong><?=$v['nom']?></strong></summary>
                        <p><strong>Description :</strong> <?=$v['description']?></p>
                        <p><strong>Capacité d'accueil :</strong> <?=$v['capacite']?></p>
                            <input type="hidden" name="nom" value="<?= $v['nom'] ?>"/>
                            <?php foreach ($v['creneau'] as $c => $value) :?>
                                <input type="checkbox" name="creneau[]" value="<?=$c?>"> <?=$value?>
                            <?php endforeach ?>
                    </details>
                    <?php endforeach?>
                        <input type="submit" value="Réserver">
                    </form>
                </div>
            </div>
        </div>
</section>
<?php require "view_end.php"; ?>