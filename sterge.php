<?php 
session_start();

// Preluare ID utilizator
$user_id = htmlspecialchars($_GET['user']);

// Fișierul JSON
$file = 'users.json';
$users = [];

// Verificare existență fișier
if (file_exists($file)) {
    $json_users = file_get_contents($file);
    $users = json_decode($json_users, true) ?? [];
}

// Filtrare utilizatori pentru a elimina cel cu ID-ul specificat
$users = array_filter($users, function($user) use($user_id) {
    return $user['id'] != $user_id;
});

// Mesaj de succes pentru ștergere
$_SESSION['success'] = "Utilizator șters cu succes!";

// Scriere lista actualizată de utilizatori în fișier
file_put_contents($file, json_encode($users, JSON_PRETTY_PRINT));

// Redirecționare către pagina principală
header('location:index.php');
exit();
?>
