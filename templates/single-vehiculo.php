<?php

get_header();

$terms = wp_get_object_terms( get_the_ID(), ['marca', 'modelo', 'color_exterior']);

?>

<div class="container">
    <h2 style="text-align: center;"><?php the_title(); ?></h2>
    <br />
    <div>
        <?php foreach ($terms as $term) : ?>
            <div style="text-align: center;"><strong><?= get_taxonomy($term->taxonomy)->labels->singular_name; ?>:</strong> <?= $term->name; ?></div>
        <?php endforeach; ?>
    </div>
    <br />
    <div>
        <div style="text-align: center;"><strong>Precio Contado:</strong> <?= $price = get_post_meta(get_the_ID(), 'precio_contado', true); ?>€</div>
        <div style="text-align: center;"><strong>Precio Financiado:</strong> <?= $financial = get_post_meta(get_the_ID(), 'precio_financiado', true); ?>€</div>
        <div style="text-align: center;"><strong>Potencia:</strong> <?= $power = get_post_meta(get_the_ID(), 'potencia', true); ?>€</div>
    </div>
    <br />
    <div>
        <div style="text-align: center;"><strong>Financiado con un <?= round((($price - $financial) / $price) * 100) ?>% de descuento</strong></div>
    </div>
</div>


<?php

get_footer();
