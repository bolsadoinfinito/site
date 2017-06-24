<?php
/**
 * @author         Theme4Press
 * @package        Theme4Press Page Builder
 * @version        1.0.0
 */

/**
 * Show thumbnail for default layouts
 */
echo '<div class="row-fluid t4p-layout-thumbs">';
$layouts = Row::$layouts;
foreach ( $layouts as $columns ) {
	$columns_name = implode( 'x', $columns );

	$icon_class = implode( '-', $columns );
	$icon_class = 't4p-layout-' . $icon_class;
	$icon = "<i class='{$icon_class}'></i>";

	printf( '<div class="thumb-wrapper" data-columns="%s" title="%s">%s</div>', implode( ',', $columns ), $columns_name, $icon );
}
echo '</div>';