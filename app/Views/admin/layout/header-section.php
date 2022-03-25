<?php
$session = session();
$sessData = $session->get('loginInfo');
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title><?= $title; ?></title>
    <?php include __DIR__ . '/../layout/cssLinks.php'; ?>   
</head>
<body class="sidebar-icon-only">
    <?php //include __DIR__ . '/../layout/loader.php'; ?>
    <div class="container-scroller">
        <?php include __DIR__ . '/../layout/navbar.php'; ?>
        <div class="container-fluid page-body-wrapper">
            <?php include __DIR__ . '/../layout/sidebar.php'; ?>
            <div class="main-panel">
                <!--content codes-->