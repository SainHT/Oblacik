<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Oblacik</title>

    <!-- Change the name if unsing on a different account -->
    <link rel="stylesheet" href="/~zivcic.k/oblacik/assets/css/w3.css">
    <link rel="stylesheet" href="/~zivcic.k/oblacik/assets/css/design.css">
    <link rel="stylesheet" href="/~zivcic.k/oblacik/assets/css/styles.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Electrolize&family=Honk&display=swap" rel="stylesheet">

    <script src="/~zivcic.k/oblacik/assets/js/functions.js"></script>
</head>
<body>

<div class="header">
    <a href="index.php" class="logo"><h1>OBLACIK</h1></a>
    <div>
        {if $logged} 
            {$user} is logged in
            <button onclick="location.href='logout.php'">Logout</button>
            <button onclick="location.href='index.php?page=upld'">Upload</button>
        {/if}
        {if !$logged}
            <div>
                <button onclick="location.href='index.php?page=log'">Login</button>
                <button onclick="location.href='index.php?page=reg'">Register</button>
            </div>
        {/if}
    </div>
    <a href="#profile" class="profpic"><img src="https://art.pixilart.com/sr2f2eafaa19c82.png" alt="Avatar" class="avatar"></a>
</div>
