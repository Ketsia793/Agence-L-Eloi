<?php 
    error_reporting(-1);
    ini_set( 'display_errors', 1 );

    include 'database/connection.php';
    include 'database/sql-queries.php';
?>

<!doctype html>
<html lang="fr">
    <head>
        <meta charset="utf-8">
        <title>ReSoC - Inscription</title> 
        <meta name="author" content="Julien Falconnet">
        <link rel="stylesheet" href="style2.css"/>
    </head>
    <body>
        <?php 
        include 'header.php';
        ?>
        <div id="wrapper" >

            <aside>
                <h2>Présentation</h2>
                <p>Bienvenue sur notre réseau social.</p>
            </aside>
            <main>
                <article>
                    <h2>Inscription</h2>

                    <?php
                    function validateEmail($email) {
                        $pattern = "/^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/";
                        return preg_match($pattern, $email);
            
                        if(isset($_POST['email'])) {
                            echo "Valid email address.";
                        } else {
                            echo "Invalid email address.";
                        }
                    }
                    function validatePseudo($pseudo) {
                        if (isset($_POST['pseudo'])) {
                            if (preg_match('#^[a-zA-Z0-9.-_]{3,20}$#', $_POST['pseudo'])) { // Contrôle que le pseudo contient 3 à 20 caractères
                                $pseudo = htmlspecialchars($_POST['pseudo']); // Enregistre le pseudo en tant que '$pseudo'
                                return $pseudo; // Retourne le pseudo validé
                            } else {
                                return false; // Retourne 'false' en cas de problème
                            }
                        }
                        return false; // Retourne 'false' si 'pseudo' n'est pas défini dans le formulaire
                    }
                    
                    // function validatePassword($password) {
                    //     // Définition de l'expression régulière pour valider le mot de passe
                    //     $pattern = "/^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/";
                    
                    //     // Vérifie si le mot de passe correspond au pattern
                    //     if (preg_match($pattern, $password)) {
                    //         return true; // Le mot de passe est valide
                    //     } else {
                    //         return false; // Le mot de passe est invalide
                    //     }
                    // }
                    
                    
                    /**
                     * TRAITEMENT DU FORMULAIRE
                     */
                    // Etape 1 : vérifier si on est en train d'afficher ou de traiter le formulaire
                    // si on recoit un champs email rempli il y a une chance que ce soit un traitement
                    $enCoursDeTraitement = isset($_POST['email']);
                    $pseudo_name = isset($_POST['pseudo']);
                    // $password = isset($_POST['motpasse']);
                    if ($enCoursDeTraitement)
                    {
                        // on ne fait ce qui suit que si un formulaire a été soumis.
                        // Etape 2: récupérer ce qu'il y a dans le formulaire @todo: c'est là que votre travaille se situe
                        // observez le résultat de cette ligne de débug (vous l'effacerez ensuite)
                        // echo "<pre>" . print_r($_POST, 1) . "</pre>";
                        // et complétez le code ci dessous en remplaçant les ???
                        $new_email = $_POST['email'];
                        $new_alias = $_POST['pseudo'];
                        $new_passwd = $_POST['motpasse'];


                        //Etape 3 : Ouvrir une connexion avec la base de donnée.
                        $mysqli = connectToDatabase();

                        //Etape 4 : Petite sécurité
                        // pour éviter les injection sql : https://www.w3schools.com/sql/sql_injection.asp
                        $new_email = $mysqli->real_escape_string($new_email);
                        $new_alias = $mysqli->real_escape_string($new_alias);
                        $new_passwd = $mysqli->real_escape_string($new_passwd);

                        // on crypte le mot de passe pour éviter d'exposer notre utilisatrice en cas d'intrusion dans nos systèmes
                        $new_passwd = md5($new_passwd);
                        // NB: md5 est pédagogique mais n'est pas recommandée pour une vraies sécurité

                        //Etape 5 : construction de la requete
                        // echo ("retour validate email:" . validateEmail($_POST['email']));
                        // echo ("retour validate pseudo:" . validatePseudo($_POST['pseudo']));
                        // echo ("retour validate mdp:" . validatePassword($_POST['motpasse']));

                        if (validateEmail($_POST['email']) && validatePseudo($_POST['pseudo'])) {
                            $lInstructionSql = "INSERT INTO users (id, email, password, alias) "
                            . "VALUES (NULL, "
                            . "'" . $new_email . "', "
                            . "'" . $new_passwd . "', "
                            . "'" . $new_alias . "'"
                            . ");";
                            // Etape 6: exécution de la requete
                            $ok = $mysqli->query($lInstructionSql);
                            if ( ! $ok)
                            {
                                echo "L'inscription a échouée : " . $mysqli->error;
                            } else
                            {
                                echo "Votre inscription est un succès " . $new_alias . ".";
                                echo " <a href='login.php'>Connectez-vous.</a>";
                            }


                            if ($_POST['pseudo']) {
                                echo 'Pseudo validé : ' . $_POST['pseudo'] . '<br/>';
                            } else {
                                echo 'Le pseudo doit contenir entre 3 et 20 caractères, sans espace.<br/>';
                            }

                            }

                            // $password = $_POST['motpasse'];

                            // if (validatePassword($password)) {
                            //     echo "Mot de passe valide.";
                            // } else {
                            //     echo "Mot de passe invalide. Le mot de passe doit contenir au moins 8 caractères, une majuscule, une minuscule, un chiffre, et un caractère spécial.";
                            // }

                        // } else {
                        //     echo "L'inscription a échouée : ";
                        // }  
                        }
                    ?>        
                 
                    <form action="registration.php" method="post">
                        <input type='hidden' name='???' value='achanger'>
                        <form action="registration.php" method="post">
                        <input type='hidden' name='???' value='achanger'>

                           
                        <dl>
                            <dt><label for='pseudo'>Pseudo</label></dt>
                            <dd><input type='text'name='pseudo' id="text" aria-describedby="text-id"></dd>
                            <p id="text-id" aria-hidden="true">
                             
                          

                            <dt><label for='email'>E-Mail</label></dt>
                            <dd><input type='text'name='email' id="email" aria-describedby="email-id"></dd>
                            <p id="email-id" aria-hidden="true">
                            
                        

                            <dt><label for='motpasse'>Mot de passe</label></dt>
                            <dd><input type='password'name='motpasse' id='password'aria-describedby="password"></dd>
                
                          

                        </dl>
                        <input type='submit'>
                    </form>
                </article>
            </main>
        </div>
    </body>
</html>
