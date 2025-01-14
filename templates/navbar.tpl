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

<div id="navbar">
    <div id="navbarcomp">
        <a href="index.php">Home</a>
        {foreach $categories as $key => $value}
        <a href="#{$key}">{$key|capitalize}</a>
        {/foreach}
    </div>

    <div id="navbarmobile">
        <a href="index.php">Home</a>
        {foreach $categories as $key => $value}
        <a href="#{$key}">{$key|capitalize}</a>
        {/foreach}
        <a href="javascript:void(0);" class="icon" onclick="myFunction()">
            <i class="fa fa-bars"></i>
        </a>
    </div>

    <input type="text" placeholder="Search..">

    {if $admin}
      <a href="index.php?{#admin#}={#getter#}" style="float: right;">Admin Panel</a>
    {/if}
</div>

</body>