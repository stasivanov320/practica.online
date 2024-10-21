<?php
session_start();
$file = "users.json";
$users = [];

if (file_exists($file)) {
    $json_users = file_get_contents($file);
    $users = json_decode($json_users, true) ?? [];
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="parallax effect">
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <title>Jungle - parallax</title>
    <style>
        body { background-color: #fff; color: #121212; font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif; }
        header { padding: 20px; }
        .logo { font-size: 2rem; }
        .navigation a { margin: 0 15px; color: #fff; text-decoration: none; }
        .navigation a.active { font-weight: bold; }
        .parallax { position: relative; overflow: hidden; }
        .parallax img { width: 100%; position: absolute; }
        #text { position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%); }
        .parallax-scrolling { padding: 20px; }
        .table { background-color: #181818; color: #fff; }
        .alert-success { background-color: #359383; }
        .alert-danger { background-color: #e22134; }
    </style>
</head>
<body>
    <header>
        <h2 class="logo">Utilizatori</h2>
    </header>

    <section class="parallax">
        <img src="assets/hill1.png" id="hill1" alt="A green hill">
        <img src="assets/hill2.png" id="hill2" alt="A green hill">
        <img src="assets/hill3.png" id="hill3" alt="A green hill">
        <img src="assets/hill4.png" id="hill4" alt="A green hill">
        <img src="assets/hill5.png" id="hill5" alt="A green hill">
        <img src="assets/tree.png" id="tree" alt="A tree">
        <h2 id="text">Lista Utilizatorilor</h2>
        <img src="assets/leaf.png" id="leaf" alt="A leaf">
        <img src="assets/plant.png" id="plant" alt="A green plant">
    </section>
    
    <div class="container my-4">
        
        <?php if (isset($_SESSION['success'])): ?>
            <div class="alert alert-success"><?= $_SESSION['success'] ?></div>
            <?php unset($_SESSION['success']); endif; ?>
            
            <?php if (isset($_SESSION['errors'])): ?>
                <div class="alert alert-danger">
                    <ul>
                        <?php foreach ($_SESSION['errors'] as $error): ?>
                            <li><?= $error ?></li>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                    <?php unset($_SESSION['errors']); endif; ?>
                    
                    <button type="button" class="btn btn-dark mb-3" data-bs-toggle="modal" data-bs-target="#addUserModal">
                        Adaugă utilizator
                    </button>
                    
                    <div class="modal fade" id="addUserModal" tabindex="-1" aria-labelledby="addUserModalLabel" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="addUserModalLabel">Adaugă un utilizator nou</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <form action="save_user.php" method="post">
                                        <div class="mb-3">
                                            <label for="nume" class="form-label">Nume</label>
                                            <input type="text" name="nume" id="nume" class="form-control" required>
                                        </div>
                                        <div class="mb-3">
                                            <label for="email" class="form-label">Email</label>
                                <input type="email" name="email" id="email" class="form-control" required>
                            </div>
                            <div class="form-check mb-3">
                                <input class="form-check-input" type="checkbox" name="abonat" id="abonat">
                                <label class="form-check-label" for="abonat">Doresc să primesc emailuri</label>
                            </div>
                            <button type="submit" class="btn btn-dark">Adaugă utilizator</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Nume</th>
                    <th>Email</th>
                    <th>Abonat</th>
                    <th>Acțiuni</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($users)): ?>
                    <?php foreach ($users as $index => $user): ?>
                        <tr>
                            <td><?= $index + 1 ?></td>
                            <td><?= htmlspecialchars($user['nume']) ?></td>
                            <td><?= htmlspecialchars($user['email']) ?></td>
                            <td><?= htmlspecialchars($user['abonat'] ? 'Da' : 'Nu') ?></td>
                            <td>
                                <a href="sterge.php?user=<?= $user['id'] ?>" class="btn btn-danger btn-sm" onclick="return confirm('Esti sigur ca vrei sa stergi?');">Șterge</a>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                        <?php else: ?>
                    <tr>
                        <td colspan="5" class="text-center">Nu există utilizatori</td>
                    </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
        
        <script src="index.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    </body>
    </html>
