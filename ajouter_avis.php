<?php 
include "db.php"; ?>

<h1><a href="index.php">HOME</a></h1>
<?php

if (isset($_POST["searchID3"]))
  $searchID3 = $_POST["searchID3"];

if ((isset($_POST["searchIDButton3"]) AND $_POST["searchIDButton3"] == "Rechercher Membre")) 
            {
            //  $_POST["searchID3"] = $_POST["id_perso"] ? htmlspecialchars($_POST["id_perso"]) : htmlspecialchars($_POST["searchID3"]);
            // $searchID3 = $_POST["searchID3"];
            //  $searchID3 = strip_tags($searchID3); 
            }
            // Recherche par ID et inclusion du bouton de changement d'abo + requete sql update
            if (isset($searchID3)){
                $select_search_member = $bdd->prepare("SELECT
                fiche_personne.nom as nom,
                prenom as prenom,abonnement.nom as abo_nom,id_perso,abonnement.id_abo as id_abo
              from
                fiche_personne
                left join membre on fiche_personne.id_perso = membre.id_fiche_perso
                left join abonnement on membre.id_abo = abonnement.id_abo
                WHERE
                fiche_personne.id_perso LIKE ?");
                $select_search_member->execute(array("$searchID3")); 
                while($search_found_member = $select_search_member->fetch()) {
                echo "<div> <strong>Prenom</strong> : ".$search_found_member['prenom']." <strong>Nom</strong> : ".$search_found_member['nom']. 
                " <strong>ID</strong> : ".$search_found_member['id_perso']."</div>";
                  }
               }
               ?>


<br>
<form action = "ajouter_avis.php" method="post">
<label for = "text">Donnez votre avis sur un film</label> <br>
<input type="hidden" name="searchID3" value="<?php echo $searchID3 ?>">
<select name="filmList" id="films">  
    <option class="listeDeroulanteFilms" value="">SELECTIONNER FILM</option> 
    <?php
    foreach ($bdd->query("select titre,id_film from film order by id_film asc") as $filmList):
    ?>  
    <option value="<?php echo $filmList['id_film']; ?>"><?php echo $filmList['titre']; ?></option> 
    <?php endforeach; ?>  
</select> <br>
<textarea name="ajouter_avis_area" rows="10" cols="75">
</textarea>
<br>
<input type = "submit" name = "ajouter_avis_button" value="Ajouter avis">
</form>

<?php
if ((isset($_POST["ajouter_avis_button"]) AND $_POST["ajouter_avis_button"] == "Rechercher ID")
) 
            {
            //  $_POST["searchID"] = $_POST["id_perso"] ? htmlspecialchars($_POST["id_perso"]) : htmlspecialchars($_POST["searchID"]);
            //  $searchID = $_POST["searchID"];
            //  $searchID = strip_tags($searchID); 
            }
            // changer la requete, verifier variables avis est dans historique_membre
            if (isset($searchID3) && !empty('filmList') && isset($_POST['ajouter_avis_area'])){
                $select_search_member = $bdd->prepare("UPDATE
        membre
        LEFT JOIN fiche_personne ON membre.id_fiche_perso = fiche_personne.id_perso
        LEFT JOIN historique_membre ON historique_membre.id_membre = membre.id_membre
      SET
        historique_membre.avis = ?
      WHERE
        id_perso = ?
        AND id_film = ?
                ");
                $select_search_member->execute(array($_POST['ajouter_avis_area'],$_POST['searchID3'],$_POST['filmList'])); 
               }
?>