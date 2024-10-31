<?php 
wp_head();


$order = sanitize_text_field($_GET['order']);
$mode = sanitize_text_field($_GET['mode']);
$column = sanitize_text_field($_GET['column']);
$style = sanitize_text_field($_GET['style']);
$search = '';
$category = sanitize_text_field($_GET['category']);
$upvote = '';

$list_id = sanitize_text_field($_GET['list_id']);

echo '<div class="clear">';

echo do_shortcode('[qcpnd-directory mode="' . $mode .  '" list_id="' . $list_id . '" style="' . $style . '" column="' . $column . '" search="' . $search . '" category="' . $category . '" upvote="' . $upvote . '" item_count="on" orderby="date" order="' . $order . '"]'); 

echo '</div>';
wp_footer();
?>





