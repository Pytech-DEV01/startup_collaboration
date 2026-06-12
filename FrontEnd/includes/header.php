<?php
$isSubPage = strpos($_SERVER['PHP_SELF'], '/pages/') !== false;
$basePath = $isSubPage ? '..' : '.';
$apiPath = $isSubPage ? '../../api' : '../api';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Startup Collaboration Portal</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link rel="stylesheet" href="<?= $basePath ?>/assets/style.css">
    <link rel="stylesheet" href="<?= $basePath ?>/assets/dashboard.css">
    <link rel="stylesheet" href="<?= $basePath ?>/assets/forms.css">
</head>
<body>

<!-- Mobile Toggle -->
<button class="mobile-toggle">
    <i class="fas fa-bars"></i>
</button>

<!-- Sidebar -->
<aside class="sidebar">
    <div class="logo">
        <i class="fas fa-rocket"></i>
        <span>StartupHub</span>
    </div>
    <nav class="nav-links">
        <a href="<?= $isSubPage ? '../index.php' : 'index.php' ?>" class="<?= ($currentPage ?? '') === 'dashboard' ? 'active' : '' ?>">
            <i class="fas fa-th-large"></i>
            <span>Dashboard</span>
        </a>
        <a href="<?= $isSubPage ? 'startups.php' : 'pages/startups.php' ?>" class="<?= ($currentPage ?? '') === 'startups' ? 'active' : '' ?>">
            <i class="fas fa-rocket"></i>
            <span>Startups</span>
        </a>
        <a href="<?= $isSubPage ? 'events.php' : 'pages/events.php' ?>" class="<?= ($currentPage ?? '') === 'events' ? 'active' : '' ?>">
            <i class="fas fa-calendar-alt"></i>
            <span>Events</span>
        </a>
        <a href="<?= $isSubPage ? 'investors.php' : 'pages/investors.php' ?>" class="<?= ($currentPage ?? '') === 'investors' ? 'active' : '' ?>">
            <i class="fas fa-hand-holding-usd"></i>
            <span>Investors</span>
        </a>
        <a href="<?= $isSubPage ? 'organizations.php' : 'pages/organizations.php' ?>" class="<?= ($currentPage ?? '') === 'organizations' ? 'active' : '' ?>">
            <i class="fas fa-building"></i>
            <span>Organizations</span>
        </a>
        <a href="<?= $isSubPage ? 'applications.php' : 'pages/applications.php' ?>" class="<?= ($currentPage ?? '') === 'applications' ? 'active' : '' ?>">
            <i class="fas fa-file-alt"></i>
            <span>Applications</span>
        </a>
        <a href="<?= $isSubPage ? 'mentorships.php' : 'pages/mentorships.php' ?>" class="<?= ($currentPage ?? '') === 'mentorships' ? 'active' : '' ?>">
            <i class="fas fa-users"></i>
            <span>Mentorships</span>
        </a>
        <a href="<?= $isSubPage ? 'participants.php' : 'pages/participants.php' ?>" class="<?= ($currentPage ?? '') === 'participants' ? 'active' : '' ?>">
            <i class="fas fa-user-check"></i>
            <span>Participants</span>
        </a>
    </nav>
</aside>

<!-- Page Content -->
<div class="page-content">
    <!-- Toast Container -->
    <div class="toast-container"></div>
