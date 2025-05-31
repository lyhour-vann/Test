<?php
    require_once 'connection.php';

    if (isset($_GET['id'])) {
        $id = $_GET['id'];
        $stmt = $conn->prepare("UPDATE role SET status = 0 WHERE id = :id");
        $stmt->execute(['id' => $id]);
    }

    header("Location: index.php");
    exit();

    // if (isset($_GET['id'])) {
    //     $id = $_GET['id'];
    //     $stmt = $conn->prepare("DELETE FROM products WHERE id = :id");
    //     $stmt->execute(['id' => $id]);
    // }

    // header("Location: index.php");
    // exit();




?>