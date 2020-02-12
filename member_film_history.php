<?php
include "db.php";
if (isset($_GET["searchHistoryButton"]) and $_GET["searchHistoryButton"] == "Rechercher Historique") {
    $_GET["searchHistory"] = htmlspecialchars($_GET["searchHistory"]);
    $searchHistory = $_GET["searchHistory"];
    $searchHistory = strip_tags($searchHistory);
}
// Recherche par ID et inclusion du bouton de changement d'abo + requete sql update
if (isset($searchHistory)) {
    $select_search_member = $bdd->prepare("SELECT
                historique_membre.*,
                titre,
                nom,
                prenom,
                id_perso
              from
                historique_membre
                left join membre on membre.id_membre = historique_membre.id_membre
                left join fiche_personne on membre.id_fiche_perso = fiche_personne.id_perso
                left join film on film.id_film = historique_membre.id_film
              where
                id_fiche_perso like ?
                order by historique_membre.date asc");
    $select_search_member->execute(array("$searchHistory"));
    while ($search_found_member = $select_search_member->fetch()) {
        if (!isset($ruseSioux1)) {
            echo "<div><strong>Prenom</strong> : " . $search_found_member['prenom'] . " <strong>Nom</strong> : " . $search_found_member['nom'] .
                " <strong>ID</strong> : " . $search_found_member['id_perso'] . "<div><br>";
        }
        $ruseSioux1 = "A bats les mohicans!";
        echo "<div> <strong>Films vus</strong> : " . $search_found_member['titre'] . "<strong> Date: </strong>" . $search_found_member['date'] . "</div>";
    }
}
