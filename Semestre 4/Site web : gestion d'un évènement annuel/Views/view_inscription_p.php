<?php require "view_begin.php";?>
<div class="center enseignantinscrip">
    <a href="?controller=login&action=login_p" class="retour">Retour à la page de connexion</a><br><br>
    <h1>Inscription</h1>
    <h6><?=$message?></h6>
    <form action="?controller=inscription&action=creation_p" method="post">
        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label>Prénom</label>
                    <input type="text" class="form-control" name="prenom" required>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label>Nom</label>
                    <input type="text" class="form-control" name="nom" required>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label>Nom d'établissement</label>
                    <input type="text" class="form-control" name="etablissement" required>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label>Ville</label>
                    <input type="text" class="form-control" name="ville" required>
                </div>
            </div>
            <div class="col-md-7">
                <div class="form-group">
                    <label>Niveau des élèves</label>
                    <select class="form-control" name="niveau" required>
                        <option disabled selected>--Veuillez choisir le niveau de vos élèves--</option>
                        <option value="Primaire">Primaire</option>
                        <option value="Collège">Collège</option>
                        <option value="Lycée">Lycée</option>
                    </select>
                </div>
            </div>
            <div class="col-md-5">
                <div class="form-group">
                    <label>Nombre d'élèves</label>
                    <input type="number" class="form-control" name="nb" required>
                </div>
            </div>
            <div class="col-md-7">
                <div class="form-group">
                    <label>Adresse mail</label>
                    <input type="email" class="form-control" name="adr" required>
                </div>
            </div>
            <div class="col-md-5">
                <div class="form-group">
                    <label>Mot de passe</label>
                    <input type="password" class="form-control monmdp" name="mdp" required>
                    <i class="far fa-eye" id="togglePassword" style="margin-left: 1px; cursor: pointer;"></i>
                </div>
            </div>
        </div>
        <center>
            <input type="checkbox" name="acceptecgu" required> J'ai lu et j'accepte les Conditions générales d'utilisations
            <div class="form-group ms-2 mb-4">
                <button type="button" class="btn btn-warning" data-bs-toggle="modal" data-bs-target=".bd-example-modal-lg">
                    Voir les CGU</button>
            </div>
        </center>
        <input type="submit" value="Créer">
    </form>
        <!-- Modal -->
        <div class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="-1">Conditions générales d'utilisation</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        Bienvenue sur le site des inscriptions des groupes scolaires du Salon Culture et Jeux Mathématiques ! En vous inscrivant pour créer un compte sur notre site, vous acceptez d’être lié(e) par les conditions générales d’utilisation suivantes.<br><br>

                        <strong>Article 1: Mention légale</strong> <br><br>
                        Le site d’inscription au salon culture et jeux mathématiques, inscription.salon-math.fr, est la propriété de l’association Animath – IHP domicilié au 11-13 Rue Pierre et Marie Curie, 75231 Paris Cedex 05. Le bureau administratif d’Animath est ouvert du lundi au vendredi de 9h à 13h et de 14h à 17h. Pour toute question contacter : salon-culture-jeux-maths@animath.fr <br><br>

                        Hébergeur :<br>
                        Le présent site est hébergé en France par l’entreprise Scaleway.<br>
                        Société par Actions Simplifiée au capital de 214 410,50 Euros<br>
                        SIREN : 433 115 904 RCS Paris<br>
                        Siège social : 8 rue de la Ville l’Evêque, 75008 Paris<br><br>


                        <strong>Article 2: Accès au site/à l’application</strong><br>
                        Le site inscription.salon-math.fr, a pour objectif l’inscription autonome des enseignant·es, accompagnés de groupes scolaires, souhaitant se rendre au Salon Culture et Jeux Mathématiques ayant lieu le dernier weekend de mai, Place Saint Sulpice, Paris 75006.<br><br>

                        La création d’un compte enseignant·e, permet à l’utilisateur de programmer sa visite au salon en sélectionnant les activités, ateliers ou conférences en fonction du niveau de sa ou ses classes et des créneaux disponibles proposés par les exposants et conférenciers présents durant le salon. <br><br>


                        <strong>Article 3: Les droits et les obligations de l’éditeur</strong><br>
                        Le site inscription.salon-math.fr et l’association Animath mettent tout en œuvre pour offrir aux utilisateurs un site accessible 24 heures sur 24 et 7 jours sur 7, à l’exception des cas de force majeure et difficultés techniques ou informatiques. Le site s’engage également à ne publier que des informations et/ou des outils vérifiés, mais ne saurait être tenu responsable des erreurs, d’une absence de disponibilité des informations et/ou de la présence de virus sur son site.<br><br>

                        L’association Animath, dont les coordonnées figurent à l’article 1 de la présente charte, s’engage à ne pas transmettre, sous aucun prétexte, les informations collectées lors de l'inscription de l’enseignant·e. Ces informations ne seront traitées et collectées que par l’association Animath, à but informatif afin de permettre la mise en place d’un planning global des visites. <br><br>

                        Des mises à jour régulières du site peuvent être également effectuées, dans ce cas l’utilisateur en sera informé. Dans le cas où celles-ci rendraient impossible l’accès à son compte enseignant·e, l’utilisateur sera invité à réitérer sa tentative de connexion ultérieurement.<br><br>

                        Le site inscription.salon-math.fr, s’engage à ne pas partager les informations données par l’utilisation lors de la création de son compte personnel enseignant·e. <br><br>


                        <strong>Article 4: Les droits et les obligations de l’utilisateur</strong><br>
                        L’utilisateur s'engage lors de l'inscription à fournir des informations exactes et à maintenir confidentiels ses identifiants de connexion. L’utilisateur s’engage également à ne pas tenter de nuire au bon fonctionnement du site  inscription.salon-math.fr,  en respectant les règles d’utilisation du présent site. En cas de non-respect des règles ci-dessus, le compte enseignant·e de l’utilisateur sera supprimé et ses réservations annulées. <br><br>

                        Tout contenu téléchargé se fait aux risques de l’utilisateur et sous son entière responsabilité. En conséquence, le présent site ne saurait être tenu responsable d’un quelconque dommage subi par l’ordinateur de l’utilisateur à la suite de ce téléchargement.<br><br>

                        En application de l’article 27 de la loi du 6 janvier 1978, les utilisateurs disposent d’un droit d’accès, de rectification, de modification et de suppression, des données personnelles qui les concernent. Il suffit d’en faire la demande auprès de l’association Animath.<br><br>


                        <strong>Article 5: Propriété intellectuelle </strong><br>
                        La structure générale, les logiciels, textes, images, vidéos, sons, et plus généralement toutes autres informations et contenus figurant dans le site inscription.salon-math.fr, sont la propriété d’Animath font l’objet d’une protection par le code de la protection intellectuelle et plus particulièrement soumis à la législation protégeant le droit d’auteur.<br><br>

                        Tout utilisateur doit solliciter une autorisation préalable du propriétaire pour toute reproduction, publication, copie des différents contenus et s'engage en cas d’accord à une utilisation des contenus du site dans un cadre strictement privé. Toute utilisation à des fins commerciales et publicitaires est strictement interdite.<br><br>

                        Toute représentation, modification, reproduction, dénaturation, totale ou partielle, de tout ou partie du site ou de son contenu, par quelques procédés que ce soit, et sur quelque support que ce soit constituerait une contrefaçon sanctionnée par les articles L 335-2 et suivants du Code de la Propriété Intellectuelle. II est également rappelé que conformément à l'article L122-5 du Code de propriété intellectuelle que l'utilisateur qui reproduit, copie ou publie le contenu protégé doit obligatoirement citer l'auteur et sa source.<br><br>

                        <strong>Article 6: Lien hypertexte et contenus intégrés </strong><br>
                        Les articles de ce site peuvent inclure des contenus intégrés, par exemple des vidéos, images, articles, liens hypertextes de sites extérieurs. L’association Animath ne peut être tenue responsable des éventuelles erreurs présentes sur ces sites.<br><br>

                        Le contenu intégré depuis d’autres sites se comporte de la même manière que si le visiteur se rendait sur cet autre site. Ces sites web pourraient collecter des données sur vous, utiliser des cookies, embarquer des outils de suivis tiers, suivre vos interactions avec ces contenus embarqués si vous disposez d’un compte connecté sur leur site web.<br><br>
                        <strong>Article 7: Cookies</strong> <br>
                        L’utilisateur est informé que lors de ses visites sur le site, des cookies peuvent s’installer automatiquement sur son logiciel de navigation.<br><br>

                        Les cookies sont des blocs de données stockés temporairement sur le disque dur de l'ordinateur d’un utilisateur par leur navigateur qui ne permet pas de l’identifier, mais qui sert à enregistrer des informations relatives à la navigation de celui-ci. Les utilisateurs peuvent supprimer ces cookies grâce à des paramètres figurant au sein de son logiciel de navigation.<br><br>

                        En naviguant sur l’application, l'utilisateur accepte ces cookies.<br><br>


                        <strong>Article 8: Droit applicable et juridiction compétente</strong><br>
                        La législation française s'applique à la présente charte. En cas d'absence de résolution amiable d'un litige, les tribunaux français seront donc seuls compétents pour le résoudre.<br><br>

                        Pour toute question relative à l'application des présentes conditions, nous vous invitons à joindre l'éditeur aux coordonnées mentionnées dans l’article premier.<br><br>

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fermer</button>
                    </div>
                </div>
            </div>
        </div>
</div>
<?php require "view_end.php";?>

