<?php 
include "db.php";

?>
<h1><a href="index.php">HOME</a></h1>
<form action = "member_add_history.php" method = "post">
<input type="hidden" name="id_perso" value="<?= isset($_POST['searchID2']) ? $_POST['searchID2'] : $_POST['searchID'] ?>">
<select name="filmList" id="films">  
    <option class="listeDeroulanteFilms" value="">SELECTIONNER FILM</option> 
    <?php
    foreach ($bdd->query("select titre,id_film from film order by id_film asc") as $filmList):
    ?>  
    <option value="<?php echo $filmList['id_film']; ?>"><?php echo $filmList['titre']; ?></option> 
    <?php endforeach; ?>  
    <input type="submit" name="addFilmToHistory" value="Valider">
</select>
<form>


<?php 
if (isset($_POST["addFilmToHistory"])){
    if (isset($_POST['filmList'])){
      if($_POST['filmList'] === "") {
        $_POST['filmList'] = null;
      }
      $statement = $bdd->prepare("SELECT
      id_membre from membre where id_fiche_perso = ?");
      $statement->execute([$_POST['id_perso']]);
      $id_membre = $statement->fetch()['id_membre'];
        $insert_film = $bdd->prepare(
        "INSERT INTO
        historique_membre
        (id_membre,id_film,date)
        VALUES 
        (?, ?,CURDATE() 
        )
        ");
        $insert_film->execute(array($id_membre,$_POST['filmList']));
    }
}

?>  

<?php

if ((isset($_POST["searchIDButton2"]) AND $_POST["searchIDButton2"] == "Rechercher Membre") || isset($_POST["id_perso"])) 
            {
             $_POST["searchID2"] = $_POST["id_perso"] ? htmlspecialchars($_POST["id_perso"]) : htmlspecialchars($_POST["searchID2"]);
             $searchID2 = $_POST["searchID2"];
             $searchID2 = strip_tags($searchID2); 
            }
            if (isset($searchID2)){
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
    $select_search_member->execute(array("$searchID2"));
    while ($search_found_member = $select_search_member->fetch()) {
        if (!isset($ruseSioux1)) {
            echo "<div><br><strong>Prenom</strong> : " . $search_found_member['prenom'] . " <strong>Nom</strong> : " . $search_found_member['nom'] .
                " <strong>ID</strong> : " . $search_found_member['id_perso'] . "<div><br>";
        }
        $ruseSioux1 = "A bats les mohicans!";
        echo "<div> <strong>Films vus</strong> : " . $search_found_member['titre'] . "<strong> Date: </strong>" . $search_found_member['date'] . "</div>";
    }
               }
?>

