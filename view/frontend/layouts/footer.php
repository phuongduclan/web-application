<?php

require_once __DIR__ . '/_helpers.php';

$layoutExtraJs = isset($layoutExtraJs) ? $layoutExtraJs : array();

?>
</main>

<footer class="footer">
    <div class="container">
        <p>© <?php echo date('Y'); ?> Fashion Store</p>
    </div>
</footer>

<script src="<?php echo htmlspecialchars(app_asset('js/main.js')); ?>"></script>
<?php foreach ($layoutExtraJs as $js) { ?>
<script src="<?php echo htmlspecialchars(app_asset('js/' . ltrim((string) $js, '/'))); ?>"></script>
<?php } ?>
</body>
</html>
