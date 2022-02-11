<?php
require_once './db_connection.php';?>
<style> <?php include './form.css';?> </style>
<?php


/*

    $stmt = $pdo->prepare('SELECT * FROM users');
    $stmt->execute();
    $user = $stmt->fetchAll();

foreach ($user as $row) {
    echo "{$row['first_name']} - {$row['last_name']} - {$row['birthdate']}- {$row['email']} - {$row['phone']} - {$row['sex']} - {$row['civility']}<br>";



}
*/

$stmtUserAndAddress = $pdo->prepare(
        'SELECT * FROM users_has_adresses
           JOIN adresses a on a.id_adress = users_has_adresses.adresses_id_adress
           JOIN countries c on c.id_country = a.countries_id_country
           JOIN users u on u.id_user = users_has_adresses.users_id_user');
$stmtUserAndAddress -> execute();
$user = $stmtUserAndAddress -> fetchAll();



foreach ($user as $row){
    echo "{$row['first_name']} - {$row['last_name']} - {$row['street']} - {$row['postal_code']} - {$row['city']} - {$row['name']} - {$row['birthdate']}- {$row['email']} - {$row['phone']} - {$row['sex']} - {$row['civility']}<br>  ";
}

?>
<div>
    <p><a href="index.php">Go to sign in >></a></p>
</div>
<div>
    <p><a href="events.php">Go to events >></a></p>
</div>

