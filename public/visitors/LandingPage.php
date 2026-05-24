<!-- HEADER -->
<?php
$pageTitle = 'Home - Tomas Del Rosario College';
include __DIR__ . '/../../includes/header.php';
?>

<!-- HERO SECTION -->
<?php
include __DIR__ . '/components/HeroSection.php';
?>

<!-- NEWS LETTER SECTION -->
<?php
include __DIR__ . '/components/NewsletterSection.php';
?>

<!-- CARDS SECTION -->
<?php
include __DIR__ . '/components/CourseCardsSection.php';
?>

<footer>
    <div class="bg-light text-dark text-center p-3">
        <p class="mb-0">&copy; 2026 Tomas Del Rosario College. All rights reserved.</p>
    </div>
</footer>

<script src="/Modern Student Portal/public/visitors/scripts/LandingPage.js"></script>
<?php include __DIR__ . '/../../includes/footer.php'; ?>