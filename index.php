<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="css/style.css">
    <script src="script.js"></script>
    <title>My_Cinema</title>
</head>
<body>
    <header>
        <h1><a href="index.php">HOME</a></h1>
    </header>
    <main>

            <h2>Rechercher un Film</h2>
                <form action = "#" method = "get">
                    <label for="search">Rechercher un film:</label>
                    <input type="search" id="search" name="search"  size="10">
                    <input type="search" id="search" name="searchDate"  size="6" placeholder="DD MM YY">
                    <input type = "submit" name = "searchButton" value = "GO">
                    <?php include "search_film.php";?>
                </form> 

                <br><br>
            <h2>Rechercher un membre</h2>
                <form action ="#" method = "get"> 
                    <label for="search">Prénom</label>
                    <input type="search" id="searchPrenom" name="searchPrenom" size="10">
                    <label for="search">Nom</label>
                    <input type="search" id="searchNom" name="searchNom" size="10">
                    <input type="submit" name="searchMemberButton" value="Rechercher un membre">
                    <?php include "search_member.php";?>
                </form>


                <br><br>
            <h2>Modifier l'abonnement d'un membre</h2>
                <form action ="subscribe_management.php" method = "get">
                    <label for="search">Identifiant Membre</label>
                    <input type="search" id="searchID" name="searchID" size="3">
                    <input type="submit" name="searchIDButton" value="Rechercher ID">
                </form>

                <br><br>
            <h2>Afficher l'historique d'un membre</h2>
                <form action ="#" method = "get">
                    <label for="search">Identifiant Membre</label>
                    <input type="search" id="searchHistory" name="searchHistory" size="3">
                    <input type="submit" name="searchHistoryButton" value="Rechercher Historique">
                    <?php include "member_film_history.php";?>
                </form>

                <br><br>
            <h2>Ajouter une entrée à l'historique d'un membre</h2>
                <form action ="member_add_history.php" method = "post">
                    <label for="search">Identifiant Membre</label>
                    <input type="search" id="searchID2" name="searchID2" size="3">
                    <input type="submit" name="searchIDButton2" value="Rechercher Membre">
                </form>

                <br><br>
            <h2>Ajouter un avis sur un film à un membre</h2>
            <form action = "ajouter_avis.php" method ="post">
                <label for = "search">Identifiant Membre</label>
                <input type = "search" name = "searchID3" size = "3">
                <input type = "submit" name = "searchIDButton3" value="Rechercher Membre">
                </form>
    </main>
</body>
</html>