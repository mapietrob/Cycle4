<?php
//start the session
session_start();

//Include Files
require_once "connect.php";

//Initial Variable
$currentFile = basename($_SERVER['PHP_SELF']);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo isset($pageTitle) ? $pageTitle : 'To-Do List Application'; ?></title>
    <link rel="stylesheet" href="main.css">
</head>
<body>
<header>
    <div id="header-content">
        <img src='media/logo.png' alt='Logo' width='50' height='50'>
        <h1>To-Do List Application</h1>
    </div>

    <nav>
        <?php
        // Navigation Links
        echo ($currentFile == "index.php") ? "Home " : "<a href='index.php'>Home  </a>";
        ?>
    </nav>
</header>
<main>
    <h2><?php if(isset($pageName)) echo $pageName;?></h2>