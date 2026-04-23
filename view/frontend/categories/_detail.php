<?php
foreach($products as $product){
    $pid=(int)($product['id'] ?? 0);
    ?>
    <h1><?php echo htmlspecialchars((string)($product['name'] ?? ''), ENT_QUOTES, 'UTF-8'); ?></h1>
    <p><a href="index.php?controller=product&amp;action=show&amp;product_id=<?php echo $pid; ?>">Chi tiết / biến thể</a></p>
    <h2>
        <?php
            if(!empty($product['description'])){
                echo htmlspecialchars((string)$product['description'], ENT_QUOTES, 'UTF-8');
            }
        ?>
    </h2>
    <?php
}
?>