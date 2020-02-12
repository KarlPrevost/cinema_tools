<?php
include "db.php";
if (isset($_GET["searchMemberButton"]) and $_GET["searchMemberButton"] == "Rechercher un membre") {
    $_GET["searchPrenom"] = htmlspecialchars($_GET["searchPrenom"]);
    $searchPrenom = $_GET["searchPrenom"];
    $searchPrenom = strip_tags($searchPrenom);

    $_GET["searchNom"] = htmlspecialchars($_GET["searchNom"]);
    $searchNom = $_GET["searchNom"];
    $searchNom = strip_tags($searchNom);
}
// CAS 1:PRENOM
if (!empty($searchPrenom) && empty($searchNom)) {
    $select_search_member = $bdd->prepare(" SELECT nom,prenom,id_perso FROM fiche_personne WHERE prenom like ?");
    $select_search_member->execute(array("%" . $searchPrenom . "%"));
    while ($search_found_member = $select_search_member->fetch()) {
        echo "<div> <strong>Prenom</strong> : " . $search_found_member['prenom'] . " <strong>Nom</strong> : " . $search_found_member['nom'] .
            " <strong>ID</strong> : " . $search_found_member['id_perso'] . "</div>";

    }
    $select_search_member->closeCursor();
}
// CAS 2:NOM
if (empty($searchPrenom) && !empty($searchNom)) {
    $select_search_member = $bdd->prepare(" SELECT nom,prenom,id_perso FROM fiche_personne WHERE nom like ?");
    $select_search_member->execute(array("%" . $searchNom . "%"));
    while ($search_found_member = $select_search_member->fetch()) {
        echo "<div> <strong>Prenom</strong> : " . $search_found_member['prenom'] . " <strong>Nom</strong> : " . $search_found_member['nom'] .
            " <strong>ID</strong> : " . $search_found_member['id_perso'] . "</div>";

    }
    $select_search_member->closeCursor();
}
// CAS 3 NOM ET PRENOM
if (!empty($searchPrenom) && !empty($searchNom)) {
    $select_search_member = $bdd->prepare(" SELECT nom,prenom,id_perso FROM fiche_personne WHERE prenom like ? AND nom like ?");
    $select_search_member->execute(array("%" . $searchPrenom . "%", "%" . $searchNom . "%"));
    while ($search_found_member = $select_search_member->fetch()) {
        echo "<div> <strong>Prenom</strong> : " . $search_found_member['prenom'] . " <strong>Nom</strong> : " . $search_found_member['nom'] .
            " <strong>ID</strong> : " . $search_found_member['id_perso'] . "</div>";

    }
    $select_search_member->closeCursor();
}