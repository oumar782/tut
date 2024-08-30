<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Formulaire de projet</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            margin: 0;
            padding: 0;
            overflow: auto;
            border: 4px solid black; /* Couleur de la bordure */
            background-color: black; /* Couleur de fond de secours pour les navigateurs ne prenant pas en charge les dégradés */
            background-image: linear-gradient(to bottom, white, black); /* Dégradé de noir à gris */
        }

        .container {
            background-color: #fff;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            padding: 40px;
            width: 400px;
            margin: auto;
            margin-top: 50px;
        }

        h1 {
            text-align: center;
            font-size: 24px;
            color: #333;
            margin-bottom: 20px;
        }

        p {
            text-align: center;
            font-size: 18px;
            color: #666;
            margin-bottom: 30px;
        }

        form {
            display: flex;
            flex-direction: column;
        }

        label {
            font-size: 16px;
            color: #555;
            margin-bottom: 8px;
        }

        input {
            padding: 10px;
            font-size: 16px;
            border: 1px solid #ccc;
            border-radius: 5px;
            margin-bottom: 20px;
        }

        input:focus {
            outline: none;
            border-color: #66afe9;
        }

        input[type="submit"] {
            padding: 10px;
            font-size: 18px;
            color: #fff;
            background-color: #007bff;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        input[type="submit"]:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>ETC_BTP vous remercie de nous avoir fait confiance pour vos projets</h1>
        <p>Nous aimerions en savoir plus sur votre idée de projet :</p>
        <form action="" method="post">
            <label for="nom_projet">Nom du projet</label>
            <input type="text" id="nom_projet" name="nom_projet" required>

            <label for="date_debut">Date de début</label>
            <input type="date" id="date_debut" name="date_debut" required>

            <label for="date_fin">Date de fin</label>
            <input type="date" id="date_fin" name="date_fin" required>

            <label for="lieu">Lieu</label>
            <input type="text" id="lieu" name="lieu" required>

            <label for="budget">Budget</label>
            <input type="number" id="budget" name="budget" required>

            <input type="submit" value="Envoyer">
        </form>
    </div>
</body>
</html>


<?php
$message = ""; // Initialisez la variable de message à vide

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Connexion à la base de données
    $host = 'localhost';
    $dbname = 'engycoord';
    $username = 'root';
    $password = 'root';
    
    try {
        $connexion = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    } catch (PDOException $e) {
        die("Impossible de se connecter à la base de données $dbname : " . $e->getMessage());
    }

    // Vérification si le formulaire est complet
    if (!empty($_POST["nom_projet"]) && !empty($_POST["date_debut"]) && !empty($_POST["date_fin"]) && !empty($_POST["lieu"]) && !empty($_POST["budget"])) {
        // Préparation de la requête SQL pour insérer les données dans la base de données
        $query = "INSERT INTO projet (Nom_projet, Date_debut, Date_fin, Lieu, Budget) VALUES (:nom_projet, :date_debut, :date_fin, :lieu, :budget)";
        $pdostmt = $connexion->prepare($query);

        // Exécution de la requête avec les données du formulaire
        $success = $pdostmt->execute([
            "nom_projet" => $_POST["nom_projet"],
            "date_debut" => $_POST["date_debut"],
            "date_fin" => $_POST["date_fin"],
            "lieu" => $_POST["lieu"],
            "budget" => $_POST["budget"]
        ]);

        if ($success) {
            // Message de confirmation si l'insertion est réussie
            $message = "Projet mentionné avec succès. Merci pour votre confiance!";
        } else {
            // Message d'erreur si l'insertion a échoué
            $message = "Erreur lors de la mention du projet. Veuillez réessayer.";
        }
    } else {
        // Message si le formulaire est incomplet
        $message = "Tous les champs du formulaire sont obligatoires!";
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Confirmation</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            background-color: #f4f4f4;
        }

        .container {
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            padding: 20px;
            text-align: center;
        }

        h1 {
            color: #333;
        }

        p {
            margin-bottom: 20px;
        }

        button {
            padding: 10px 20px;
            background-color: #007bff;
            color: #fff;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        button:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>
    <?php if (!empty($message)) : ?>
    <!-- Affiche le formulaire de remerciement si le message n'est pas vide -->
    <div class="container">
        <h1>Confirmation</h1>
        <p><?php echo $message; ?></p>
        <form action="index.html">
            <button type="submit">OK</button>
        </form>
    </div>
    <?php endif; ?>
</body>
</html>
