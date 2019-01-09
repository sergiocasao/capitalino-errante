<?php
/** ==============================================================================================================
 *                                       Constantes y variables Globales
 *  ==============================================================================================================
 */
define( 'JSPATH', get_template_directory_uri() . '/assets/js/' );
define( 'CSSPATH', get_template_directory_uri() . '/assets/css/' ); // css para el adimin
define( 'BLOGURL', get_home_url('/') );
define( 'THEMEURL', get_bloginfo('template_url').'/' );

// $theme_info = wp_get_theme(); // inicializacion de la traduccion
// define( 'TRANSDOMAIN', $theme_info->template );


 // ---------------- paginas especiales
 // Hook que crea las paginas especificas o especiales de manera automatica

 include_once('functions/special_pages.php');

/** ==============================================================================================================
 *                                       Inluye los archivos generarles
 *  ==============================================================================================================
 */
// ---------------- scripts
// Contiene la llamada de los archivos functions.js y admin/functions.js asi como inclucion de valiables java

include_once('functions/general/scripts_js.php');

// ---------------- funciones cltvo
// Contiene las funciones generales del cultivo que son independeites de cada proyecto

include_once('functions/general/functions_cltvo.php');

// ---------------- flitros cltvo
// Contiene los filtros generales del cultivo que son independeites de cada proyecto

include_once('functions/general/filters_cltvo.php');




/** ==============================================================================================================
 *                                       Inluye los archivos de admin
 *  ==============================================================================================================
 */

// ---------------- personaizacion del menu
// Contiene las funciones para personalizar el menu del admin

include_once('functions/admin/menu.php');

// ---------------- imagenes de tamaños y opcciones personalizadas
// Contiene la funciones para personalizar los tamaños de la imagenes

include_once('functions/admin/images.php');

// ---------------- post type y taxonimias
// Contiene el registro de tipos de post persializados y configuracion del editor de los mismos

include_once('functions/admin/post_type.php');

// Contiene el registro de taxonomias personalizadas

include_once('functions/admin/taxonomies.php');

// ---------------- meta boxes y save post
// Contiene la inclucion de las metaboxes asi como las funciones del save post

include_once('functions/admin/metabox.php');

// ---------------- ajax del admin
// Contiene los funciones ajax  del admin

include_once('functions/admin/ajax.php');

/** ==============================================================================================================
 *                                         Inluye los archivos del tema
 *  ==============================================================================================================
 */

// ---------------- funciones del menu
// Contiene el menú del sitio y sus funciones

include_once('functions/theme/menu.php');

// ---------------- filtros del tema
// Contiene los filtros específicos del tema

include_once('functions/theme/filters.php');

// ---------------- funciones del tema
// Contiene los funciones específicas del tema

include_once('functions/theme/functions.php');

// ---------------- ajax del tema
// Contiene los funciones ajax especificas del tema

include_once('functions/theme/ajax.php');


function register_my_menus() {
  register_nav_menus(
    array(
      'header-menu' => __( 'Header Menu' ),
     )
   );
 }

add_action( 'init', 'register_my_menus' );

/**
* Create HTML list of nav menu items.
* Replacement for the native Walker, using the description.
*
* @see    http://wordpress.stackexchange.com/q/14037/
* @author toscho, http://toscho.de
*/
class Description_Walker extends Walker_Nav_Menu
{
/**
* Start the element output.
*
* @param  string $output Passed by reference. Used to append additional content.
* @param  object $item   Menu item data object.
* @param  int $depth     Depth of menu item. May be used for padding.
* @param  array|object $args    Additional strings. Actually always an instance of stdClass. But this is WordPress.
* @return void
*/
function start_el( &$output, $item, $depth = 0, $args = array(), $id = 0 )
{
//  $classes = empty( $item->classes ) ? array () : (array) $item->classes;
//
//  $class_names = join( ' ', apply_filters( 'nav_menu_css_class', array_filter( $classes ), $item ) );
//
//  !empty( $class_names )
//     and $class_names = ' class="'. esc_attr( $class_names ) . '"';
//
//  $output .= "<li>";

$attributes  = '';

! empty( $item->attr_title )
and $attributes .= ' title="'  . esc_attr( $item->attr_title ) .'"';
! empty( $item->target )
and $attributes .= ' target="' . esc_attr( $item->target     ) .'"';
! empty( $item->xfn )
and $attributes .= ' rel="'    . esc_attr( $item->xfn        ) .'"';
! empty( $item->url )
and $attributes .= ' href="'   . esc_attr( $item->url        ) .'"';

$title = apply_filters( 'the_title', $item->title, $item->ID );

$item_output = $args->before
. "<a class='nav-item' $attributes>"
. $args->link_before
. $title
. '</a> '
. $args->link_after
. $args->after;

// Since $output is called by reference we don't need to return anything.
$output .= apply_filters(
'walker_nav_menu_start_el'
,   $item_output
,   $item
,   $depth
,   $args
);
}
// function start_el( &$output, $item, $depth = 0, $args = array(), $id = 0 )
// {
//     parent::start_el( $output, $item, $depth, $args );
//     $output .= sprintf(
//         '<i>%s</i>',
//         esc_html( $item->description )
//     );
// }
}

add_filter('next_posts_link_attributes', 'next_link_attributes');
add_filter('previous_posts_link_attributes', 'previous_link_attributes');

function next_link_attributes() {
    return 'class="pagination-previous is-primary is-outlined button is-large"';
}

function previous_link_attributes() {
    return 'class="pagination-previous is-primary is-outlined button is-large"';
}

?>
