<!-- presentation_huahine.php -->

<!DOCTYPE html>
<html lang="fr">
<head>
    <title>CyLanta</title>
    <meta charset="utf-8" />
    <meta name="description" content="CyLanta travel agency website" />
    <meta name="author" content="Developped by MI5-A TEAM" />
    <meta name="keywords" content="voyage, agence de voyage, séjour, escapade, vacances, rechercher une destination" />
    <link rel="icon" type="image/png" href="../assets/icons/ico_island.png" />
    <link rel="stylesheet" type="text/css" href="../src/base_style.css" />
    <link rel="stylesheet" type="text/css" href="../src/presentation_style.css" />
</head>
<body>
    <div class="container"> 
        <!-- Navigation bar -->
        <div class="headbar">
            <div class="headbar_left">
                <a href="../index.php">
                    <img class="logo_img" src="../assets/cylanta_logo.png" alt="CyLanta Logo" />
                </a>
            </div>
            <div class="headbar_rest">
                <a class="headbar_item" href="../index.php">Accueil</a>
                <a class="headbar_item" href="../src/search.php">Destinations</a>
                <a class="headbar_item" href="../src/advanced_search.php">Rechercher un voyage</a>
            </div>
            <div class="headbar_right">
                <a class="headbar_my_space" href="../src/userpage.php">Mon espace</a>
                <a href="../src/userpage.php"><img class="user_img_nav" src="../assets/example_pfp.jpg" /></a>
            </div>
         </div>
         <div class="separate_presentation"></div>

	<div class="image_container">   
    		<img class="presentation_img" src="../assets/pres_huahine_img.png" alt="huahine image" />
    			<div class="description">
        			<h2>Découvrez Huahine, l'île secrète de la Polynésie 🌊</h2>
        			<p>Sauvage et authentique, Huahine vous plonge au cœur d'une nature préservée où lagons turquoise, plages désertes et montagnes luxuriantes s’entrelacent harmonieusement.
                       Explorez ses vestiges archéologiques mystérieux, partez en pirogue à la rencontre des légendaires anguilles sacrées ou laissez-vous séduire par l’ambiance paisible de ses villages pittoresques.
                       Entre aventures marines et balades à travers des paysages enchanteurs, cette île envoûtante vous promet un voyage hors du temps. Ressentez la magie polynésienne et vivez une expérience inoubliable à Huahine.
        			</p>
                    <br>
                    <b>Note CyLanta : 4.83 ⭐</b>
        		</div>
	</div>
    <div class="separate_img">
        <br><br>
        <form action="#.php" method="post">
        <div class="board">
            <table>
                <thead>
                    <tr>
                        <th>Disponibilité</th>
                        <th>Hôtel</th>
                        <th>Pension</th>
                        <th>Chambres</th>
                        <th>Spécialité</th>
                        <th>Prix</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>
                            <input type="date" name="date_voyage">
                        </td>
                        <td>
                            <select name="Hôtel">
                                <option value="oasis_de_huahine">L'Oasis de Huahine (4⭐)</option>
                                <option value="bora_nuit">Bora Nui (5⭐)</option>
                                <option value="les_rives_du_vent">Les Rives du Vent (5⭐)</option>
                            </select>
                        </td>
                        <td>
                            <select name="Pension">
                                <option value="tout_inclus">Tout inclus</option>
                                <option value="petit_dejeuner">Petit déjeuner uniquement</option>
                                <option value="dejeuner">Déjeuner uniquement</option>
                                <option value="demi_pension">Demi-pension</option>
                            </select>
                        </td>
                        <td>
                            <select name="Chambres">
                                <option value="1_personne">1 personne</option>
                                <option value="2_personnes">2 personnes</option>
                                <option value="3_personnes">3 personnes</option>
                                <option value="4_personnes">4 personnes</option>
                                <option value="5_personnes">5 personnes</option>
                            </select>
                        </td>
                        <td>
                            Aventure
                        </td>
                        <td>
                            <!-- We will set an adaptive price during phase 2 -->
                            11300€
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
        <button onclick="window.location.href='#.php'">
            <a class="reservation_text" href="#".php">Réserver</a>
        </button>
    </div>
    </form>  
    </div>

    <div class="separate_footer"></div>  
    
    <!-- Footer -->
    <footer>
        <div class="footer_section">
            <h3>À Propos</h3>
            <p>Chez CyLanta, nous concevons des voyages sur mesure, uniques et adaptés à vos envies.
                Passionnés d'évasion et grâce à notre réseau de partenaires, nous sélectionnons pour vous les meilleures
                adresses et activités exclusives.
                Que ce soit un safari, un road trip ou un séjour bien-être, chaque voyage est pensé dans les moindres
                détails. Votre aventure commence ici !
            </p>
        </div>
        <div class="footer_section">
            <h3>Nos Contacts</h3>
            <ul class="other">
                <li><a href="mailto:CyLanta@cy-tech.fr">Email: CyLanta@cy-tech.fr</a></li>
                <li><a href="tel:+33123456789">Téléphone: +33 1 23 45 67 89</a></li>
                <li><a href="https://www.google.com/maps?q=49.035290202793036, 2.070567152915135" target="_BLANK">Adresse: Av. du Parc, 95000 Cergy</a></li>
            </ul>
        </div>
        <div class="footer_section">
            <h3>Nos Partenaires</h3>
            <div class="partners">
                <a href="https://www.cyu.fr/" target="_blank"><img src="../assets/cy_favicon.png" alt="Partenaire 1" /></a>
                <a href="https://cytech.cyu.fr/" target="_blank"><img src="../assets/cytech_icon.png" alt="Partenaire 2" /></a>
                <a href="https://www.cergy.fr/accueil/" target="_blank"><img src="../assets/cergy_ville.jpg" alt="Partenaire 3" /></a>
            </div>
        </div>
    </footer>
</body>
</html>
