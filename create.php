<?php
require_once 'connection.php'; // connection from db

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    
    $name = $_POST['name'];

    $description = $_POST['description'];
    
    $stmt = $conn->prepare("INSERT INTO role (name, description) 
            VALUES (:name, :description)");
    $stmt->execute([
        'name' => $name,
        'description' => $description
    ]);
    
    header("Location: index.php");
    
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Create Role</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100">
    <div class="container mx-auto p-4">

        <h1 class="text-2xl font-bold mb-4">Create New Role</h1>

        <form method="POST" class="bg-white p-6 rounded shadow-md">

            <div class="mb-4">
                <label class="block text-gray-700">Role Name</label>
                <input type="text" name="name" required class="w-full p-2 border rounded">
            </div>
            <div class="mb-4">
                <label class="block text-gray-700">Description</label>
                <textarea name="description" class="w-full p-2 border rounded"></textarea>
            </div>

            <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded">Create</button>

            <a href="index.php" class="bg-gray-500 text-white px-4 py-2 rounded ml-2">Cancel</a>

        </form>
    </div>
</body>
</html>