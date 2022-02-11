<?php
require_once './db_connection.php'; ?>
<style> <?php include './form.css';?> </style>
<?php
if (isset($_POST['submit'])){

    $stmtNameEvent = $pdo->prepare(
        'INSERT INTO events (name, description,start_time,end_time)
                   VALUES (:name,:description,:start_time,:end_time)');
    $stmtNameEvent->execute([
        'name' => $_POST['name-event'],
        'description' => $_POST['description-event'],
        'start_time' => $_POST['start-event'],
        'end_time' => $_POST['end-event'],

    ]);
}

?>

<form action="events.php" method="post">


    <label for="name-event">Add new event
        <br><input type="text" name="name-event" placeholder="Write the name of the event"><br><br>
    </label>

    <label for="description-event">Description of the event
        <br><textarea name="description-event" placeholder="Write a description of the event"></textarea><br><br>
    </label>

    <label for="start-event">Start time of the event
        <br><input type="datetime-local" name="start-event"><br><br>
    </label>

    <label for="end-event">End time of the event
        <br><input type="datetime-local" name="end-event"><br><br>
    </label>


    <input id="submit_id" type="submit" name="submit" value="submit"><br><br>
</form>

<div>
    <p><a href="index.php"> Go to sign in </a></p>
</div>
<div>
    <p><a href="user-list.php">Go to list of users >></a></p>
</div>
