<?php
require_once './db_connection.php';?>
<style> <?php include './form.css';?> </style>
<?php
if (isset($_POST['submit'])) {

    $country = ucfirst(mb_strtolower(trim($_POST['country'])));

// Test if country exists


    // 3: Tester si le country exist
    // cas1: le country exist et on recupère son id
    // cas2: Si il existe pas on le crée dans la base de donnée

    $stmt_countryIfExistOrNot = $pdo->prepare(
        'SELECT * FROM countries WHERE name = :countryName'
    );
    $stmt_countryIfExistOrNot->execute([
            'countryName' => $country
        ]

    );
    $existantCountry = $stmt_countryIfExistOrNot->fetchAll();

    if ($existantCountry) {
        $id_country = $existantCountry[0]["id_country"];
    } else {
        $stmt_country = $pdo->prepare(
            'INSERT INTO countries (name)
                   VALUE(:name)');
        $stmt_country->execute([
            'name' => $country

        ]);
        $id_country = $pdo->lastInsertId();
    }


    $stmt_adress = $pdo->prepare(
        'INSERT INTO adresses (street, postal_code, city, countries_id_country)
                   VALUES (:street, :postal_code, :city, :countries_id_country)');
    $stmt_adress->execute([
        'street' =>  ucfirst(mb_strtolower(trim($_POST['adress']))),
        'postal_code' => trim($_POST['postal']),
        'city' =>  ucfirst(mb_strtolower(trim($_POST['city']))),
        'countries_id_country' => $id_country,

    ]);
    $id_address = $pdo->lastInsertId();


    $stmt = $pdo->prepare(
        '  INSERT INTO users (first_name, last_name, birthdate, email, phone, civility, sex)
                   VALUES(:first_name, :last_name, :birthdate, :email, :phone, :civility, :sex)');
    $stmt->execute([
        'first_name' => ucfirst(mb_strtolower(trim($_POST['first_name']))),
        'last_name' => ucfirst(mb_strtolower(trim($_POST['last_name']))),
        'birthdate' => $_POST['birthdate'],
        'email' => mb_strtolower($_POST['email']),
        'phone' => trim($_POST['phone']),
        'civility' => $_POST['civility'],
        'sex' => $_POST['sex'],
    ]);
    $id_user = $pdo->lastInsertId();

    $stmtUserHasAdress = $pdo->prepare(
        'INSERT INTO users_has_adresses (users_id_user, adresses_id_adress) 
                VALUES(:users_id_user,:adresses_id_adress) '
    );
    $stmtUserHasAdress->execute([
        'users_id_user' => $id_user,
        'adresses_id_adress' => $id_address
    ]);
}

?>
    <form action="index.php" method="post">
        <label for="sex" id="sex">Votre sexe</label>
        <select name="sex" id="sex">
            <option value="0">Monsieur</option>
            <option value="1">Madame</option>
        </select>
        <label for="civility" id="civility">Votre civilité</label>
        <select name="civility" id="civility">
            <option value="0">Célibataire</option>
            <option value="1">Marié</option>
            <option value="2">Divorcé</option>
        </select><br>

        <label for="first_name">First name<br><input type="text" name="first_name"
                                                     placeholder="Enter your first name"><br><br>

        </label>
        <label for="last_name">Last name
            <br><input type="text" name="last_name" placeholder="Enter your last name"><br><br>
        </label>
        <label for="birthdate">Birthdate
            <br><input type="date" name="birthdate" placeholder="Enter your birthdate"><br><br>
        </label>
        <label for="email">Email
            <br><input type="email" name="email" placeholder="Enter your email"><br><br>
        </label>
        <label for="country">Votre pays
            <br><input type="text" name="country" placeholder="Sélectionner votre pays"><br><br>
        </label>
        <label for="adress">Votre adresse
            <br><input type="text" name="adress" placeholder="Votre adresse"><br><br>
        </label>
        <label for="city">Votre ville
            <br><input type="text" name="city" placeholder="Votre ville"><br><br>
        </label>
        <label for="postal">Code postal
            <br><input type="text" name="postal" placeholder="Ex. 1010"><br><br>
        </label>
        <label for="phone">Phone number
            <br><input type="tel" name="phone" maxlength="12" placeholder="Enter your phone number"><br><br>
        </label>
        <input id="submit_id" type="submit" name="submit" value="submit"><br><br>
    </form>
<div>
    <p><a href="events.php">Go to events >></a></p>
</div>
    <div>
        <p><a href="user-list.php">Go to list of users >></a></p>
    </div>

