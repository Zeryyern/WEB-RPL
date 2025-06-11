<?php
// filepath: c:\xampp\htdocs\yourDietBuddy\php\footer.php
if (!isset($social_links)) $social_links = [];
$icon_map = [
    'facebook' => 'facebook',
    'instagram' => 'instagram',
    'twitter' => 'twitter',
    'github' => 'github',
    // Add more if needed
];
?>
<footer class="bg-dark text-white text-center p-4 mt-5">
    <p class="mb-2">Follow us:</p>
    <?php foreach ($social_links as $link):
        $platform = strtolower($link['platform']);
        $icon = isset($icon_map[$platform]) ? $icon_map[$platform] : 'link';
    ?>
    <a href="<?= htmlspecialchars($link['url']) ?>" class="text-white me-3 fs-4" target="_blank">
        <i class="bi bi-<?= $icon ?>"></i>
    </a>
    <?php endforeach; ?>
    <p class="mt-3 mb-0">© 2025 YourDietBuddy. All rights reserved.</p>
</footer>