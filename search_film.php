<!--    ####################################
        Liste déroulante GENRE
        #################################### -->
<select name="genreListe" id="genre">  <!-- creation du select avec un name et un id -->
    <option class="listeDeroulanteGenre" value="">Genre</option> <!-- creation de l'option avec classe et value -->
    <?php
    include "db.php";   // initialisation de la bdd
    // $statement1 = $bdd->query("select * from genre"); // preparation de la requete sql inutile
    foreach ($bdd->query("select * from genre") as $genre):// creation d'une boucle qui met le resultat d'une requete a chaque tour dans une variable 
    $idgenre = $genre["id_genre"]; // recupere id_genre dans une var
    $genrenom = $genre["nom"]; ?>  <!-- recupere nom du genre dans une var-->
    <option value="<?php echo $genrenom; ?>"><?php echo $genrenom; ?></option> <!-- met en value l'id genre et le nom dans la liste. -->
    <?php endforeach; ?>  <!-- les ":" attendent un endforeach pour finir la boucle, ce qui permet d'inserer du html, sinon il aurait fallut mettre le html dans un echo avec le html dedans -->
</select>
    <!--####################################

        ####################################
        Liste déroulante DISTRIB
        #################################### -->
<select name="distribListe" id="distrib">
    <option class="listeDeroulanteDistrib" value="">Distributeur</option>
    <?php
    // $statement2 = $bdd->query("select * from distrib");
    foreach ($bdd->query("select * from distrib") as $distrib):
    $iddistrib = $distrib["id_distrib"];
    $distribnom = $distrib["nom"]; ?>
    <option value="<?php echo $distribnom; ?>"><?php echo $distribnom; ?></option>
    <?php endforeach; ?>
</select>
    <?php
    //####################################

    //####################################
    // CONDITIONS D'AFFICHAGE
    //####################################
if (isset($_GET["searchButton"]) AND $_GET["searchButton"] == "GO") // si le bouton est cliqué et si sa valeur est "GO" $_GET prend pour valeur la value de l'element dont il a le name en parametre 
            {
             $_GET["search"] = htmlspecialchars($_GET["search"]); // sécuriser le formulaire contre les failles html
             $search = $_GET["search"];
             // $search = trim($search); supprimer les espaces dans la requête de l'internaute
             $search = strip_tags($search); // supprimer les balises html dans la requête
            }
            // CAS 1 : Champs de recherche
            if (isset($search) && empty($_GET['genreListe']) && empty($_GET['distribListe']) && empty($_GET['searchDate'])){
                $search = strtolower($search); // met en lowercase la recherche, pas très utile
                $select_search = $bdd->prepare("SELECT
                film.*,
                genre.nom as 'genre_nom',
                distrib.nom as 'distrib_nom'
              FROM
                film
                LEFT JOIN genre ON film.id_genre = genre.id_genre
                LEFT JOIN distrib ON film.id_distrib = distrib.id_distrib
              WHERE
                titre LIKE ?
              ORDER BY
                titre ASC");
                $select_search->execute(array("%".$search."%")); // execute la requete préparée
                while($search_found = $select_search->fetch()) { //façon d'afficher la requete
                echo "<div><h2>".$search_found['titre']."</h2>"."Genre : ".$search_found['genre_nom']. "<br>Distributeur : ".$search_found['distrib_nom']."</div>";
               }
               $select_search->closeCursor(); // ferme la connexion
               } else 
               {
                $message = "Champs requis";
            }
            // CAS 2 : Champs de recherche + genre
            if (isset($search) && !empty($_GET['genreListe']) && empty($_GET['distribListe']) && empty($_GET['searchDate'])){
              $search = strtolower($search); // met en lowercase la recherche, pas très utile
              $select_search = $bdd->prepare(
              "SELECT
              film.*,
              genre.nom as 'genre_nom',
              distrib.nom as 'distrib_nom'
            FROM
              film
              LEFT JOIN genre ON film.id_genre = genre.id_genre
              LEFT JOIN distrib ON film.id_distrib = distrib.id_distrib
            WHERE
              titre LIKE ?
              AND genre.nom LIKE ?
            ORDER BY
              titre ASC");
              $select_search->execute(array("%".$search."%", $_GET['genreListe'])); // execute la requete préparée (array contenant les elements "?" utilisés a la suite)
              while($search_found = $select_search->fetch()) { //façon d'afficher la requete
              echo "<div><h2>".$search_found['titre']."</h2>"."Genre : ".$search_found['genre_nom']. "<br>Distributeur : ".$search_found['distrib_nom']."</div>";                       
            }
               $select_search->closeCursor(); // ferme la connexion
               } else 
               {
                $message = "Champs requis";
            }
            // CAS 3 : Champs de recherche + distrib
            if (isset($search) && empty($_GET['genreListe']) && !empty($_GET['distribListe']) && empty($_GET['searchDate'])){
                $search = strtolower($search); // met en lowercase la recherche, pas très utile
                $select_search = $bdd->prepare(
                "SELECT
                film.*,
                genre.nom as 'genre_nom',
                distrib.nom as 'distrib_nom'
              FROM
                film
                LEFT JOIN genre ON film.id_genre = genre.id_genre
                LEFT JOIN distrib ON film.id_distrib = distrib.id_distrib
              WHERE
                titre LIKE ?
                AND distrib.nom LIKE ?
              ORDER BY
                titre ASC");
                $select_search->execute(array("%".$search."%", $_GET['distribListe'])); // execute la requete préparée (array contenant les elements "?" utilisés a la suite)
                while($search_found = $select_search->fetch()) { // façon d'afficher la requete
                echo "<div><h2>".$search_found['titre']."</h2>"."Genre : ".$search_found['genre_nom']. "<br>Distributeur : ".$search_found['distrib_nom']."</div>";                       
            }
               $select_search->closeCursor(); // ferme la connexion
               } else 
               {
                $message = "Champs requis";
            }
            // CAS 4 : Champs de recherche + genre + distrib
            if (isset($search) && !empty($_GET['genreListe']) && !empty($_GET['distribListe']) && empty($_GET['searchDate'])){
                $search = strtolower($search); // met en lowercase la recherche, pas très utile
                $select_search = $bdd->prepare(
                "SELECT
                film.*,
                genre.nom as 'genre_nom',
                distrib.nom as 'distrib_nom'
              FROM
                film
                LEFT JOIN genre ON film.id_genre = genre.id_genre
                LEFT JOIN distrib ON film.id_distrib = distrib.id_distrib
              WHERE
                titre LIKE ?
                AND genre.nom LIKE ?
                AND distrib.nom LIKE ?
              ORDER BY
                titre ASC");
                $select_search->execute(array("%".$search."%", $_GET['genreListe'] ,$_GET['distribListe'])); // execute la requete préparée (array contenant les elements "?" utilisés a la suite)
                while($search_found = $select_search->fetch()) { // façon d'afficher la requete
                echo "<div><h2>".$search_found['titre']."</h2>"."Genre : ".$search_found['genre_nom']. "<br>Distributeur : ".$search_found['distrib_nom']."</div>";                       
            }
               $select_search->closeCursor(); // ferme la connexion
               } else 
               {
                $message = "Champs requis";
            }

            // CAS 5 : Champs de recherche + genre + distrib + date
            // voir operations sur les dates curdate() - date_fin_affiche  c'est de la putain de merde, merci
          //   if ( !empty($_GET['searchDate'])){
          //     var_dump($_GET['searchDate']);
          //     $select_search = $bdd->prepare(
          //     "SELECT
          //     film.*,
          //     genre.nom as 'genre_nom',
          //     distrib.nom as 'distrib_nom'
          //   FROM
          //     film
          //     LEFT JOIN genre ON film.id_genre = genre.id_genre
          //     LEFT JOIN distrib ON film.id_distrib = distrib.id_distrib
          //   WHERE
          //     titre LIKE ?
          //     AND genre.nom LIKE ?
          //     AND distrib.nom LIKE ?
          //     AND ? between UNIX_TIMESTAMP(date_debut_affiche) and UNIX_TIMESTAMP(date_fin_affiche)
          //   ORDER BY
          //     titre ASC");
          //     $select_search->execute(array("%".$search."%", $_GET['genreListe'] ,$_GET['distribListe'], $_GET['searchDate'])); // execute la requete préparée (array contenant les elements "?" utilisés a la suite)
          //     while($search_found = $select_search->fetch()) { // façon d'afficher la requete
          //     echo "<div><h2>".$search_found['titre']."</h2>"."Genre : ".$search_found['genre_nom']. "<br>Distributeur : ".$search_found['distrib_nom']. "<br>En salle jusqu'au : ".$search_found['date_fin_affiche']."</div>";                       
          // }
          //    $select_search->closeCursor(); // ferme la connexion
          //    } else 
          //    {
          //     $message = "Champs requis";
          // }
           // FIN DES CONDITIONS D'AFFICHAGE
?>