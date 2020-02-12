<?php
try
            {
             $bdd = new PDO('mysql:host=localhost;dbname=cinema;charset=utf8', 'root', ''); // Hidden password on Github.
             $bdd ->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            }
            catch(Exception $e)
            {
                die('Erreur : '.$e->getMessage());
            }
            $bdd->query("SET NAMES UTF8");
?>            