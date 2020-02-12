<?php
// D’ajouter, de supprimer, ou de modifier un abonnement à un client.
// MODIFIER ABONNEMENT
?>
<h1><a href="index.php">HOME</a></h1> 
<form action="subscribe_management.php" method="get">
<input type="hidden" name="id_perso" value="<?= isset($_GET['id_perso']) ? $_GET['id_perso'] : $_GET['searchID'] ?>">
<select name="subscribeListe" id="subscribeListe"> 
    <option class="listeDeroulanteSubscribe" value="">Modifier l'abonnement</option> 
    <?php
    include "db.php";  
    foreach ($bdd->query("select * from abonnement") as $nomAbonnement):
    $abonnement = $nomAbonnement["nom"];
    $idAbonnement = $nomAbonnement["id_abo"];
    ?> 
    <option value="<?php echo $idAbonnement; ?>"><?php echo $abonnement; ?></option>
    <?php endforeach; ?>
    <option value="" >Supprimer Abonnement</option>
</select>
<input type="submit" name="modSub" value="Valider">
</form>

<?php 
if (isset($_GET["modSub"])){
    if (isset($_GET['subscribeListe'])){
      if($_GET['subscribeListe'] === "") {
        $_GET['subscribeListe'] = null;
      }
        $modif_abo = $bdd->prepare(
        "UPDATE
        membre
        LEFT JOIN fiche_personne ON membre.id_fiche_perso = fiche_personne.id_perso
      SET
        membre.id_abo = ?
      WHERE
        id_perso = ?
        ");
        $modif_abo->execute(array($_GET['subscribeListe'],$_GET['id_perso']));
    }
    $modif_abo->closeCursor();
}

?>  

<?php 
if ((isset($_GET["searchIDButton"]) AND $_GET["searchIDButton"] == "Rechercher ID") || isset($_GET["id_perso"])) 
            {
             $_GET["searchID"] = $_GET["id_perso"] ? htmlspecialchars($_GET["id_perso"]) : htmlspecialchars($_GET["searchID"]);
             $searchID = $_GET["searchID"];
             $searchID = strip_tags($searchID); 
            }
            // Recherche par ID et inclusion du bouton de changement d'abo + requete sql update
            if (isset($searchID)){
                $select_search_member = $bdd->prepare("SELECT
                fiche_personne.nom as nom,
                prenom as prenom,abonnement.nom as abo_nom,id_perso,abonnement.id_abo as id_abo
              from
                fiche_personne
                left join membre on fiche_personne.id_perso = membre.id_fiche_perso
                left join abonnement on membre.id_abo = abonnement.id_abo
                WHERE
                fiche_personne.id_perso LIKE ?");
                $select_search_member->execute(array("$searchID")); 
                while($search_found_member = $select_search_member->fetch()) {
                echo "<div> <strong>Prenom</strong> : ".$search_found_member['prenom']." <strong>Nom</strong> : ".$search_found_member['nom']. 
                " <strong>ID</strong> : ".$search_found_member['id_perso']." <strong>Abonnement</strong> : ".$search_found_member['abo_nom'].
                " <strong>ID Abonnement</strong> : ".$search_found_member['id_abo']."</div>";
                  }
               }
               ?>
