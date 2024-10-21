<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nume = $_POST['nume'];
    $email = $_POST['email']; 
    $abonat = isset($_POST['abonat']) ? 'Da' : 'Nu';

    // Validăm emailul
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $_SESSION['errors'] = ['Emailul nu este valid.'];
        header('Location: index.php');
        exit();
    }

    // Opțional: verificăm dacă domeniul emailului există
    $domain = substr(strrchr($email, "@"), 1);
    if (!checkdnsrr($domain, "MX")) {
        $_SESSION['errors'] = ['Domeniul emailului nu există.'];
        header('Location: index.php');
        exit();
    }

    // Citim lista de utilizatori existentă
    $file = 'users.json';
    $users = [];

    if (file_exists($file)) {
        $json_users = file_get_contents($file);
        $users = json_decode($json_users, true) ?? [];
    }

    // Verificăm dacă email-ul este deja folosit
    foreach ($users as $user) {
        if ($user['email'] === $email) {
            $_SESSION['errors'] = ['Acest email este deja înregistrat.'];
            header('Location: index.php');
            exit();
        }
    }

    // Adăugăm noul utilizator la lista de utilizatori
    $new_user = [
        'id' => uniqid(),
        'nume' => htmlspecialchars($nume),
        'email' => htmlspecialchars($email),
        'abonat' => $abonat
    ];

    $users[] = $new_user;

    // Salvăm lista actualizată de utilizatori
    file_put_contents($file, json_encode($users));

    // Mesaj de succes
    $_SESSION['success'] = "Utilizatorul a fost adăugat cu succes!";
    header('Location: index.php');
    exit();
}
?>