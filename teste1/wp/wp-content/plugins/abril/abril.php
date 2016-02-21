<?php
/**
 * @package Akismet
 */
/*
Plugin Name: Editora Abril
Plugin URI: http://akismet.com/
Description: Used by millions, Akismet is quite possibly the best way in the world to <strong>protect your blog from spam</strong>. It keeps your site protected even while you sleep. To get started: 1) Click the "Activate" link to the left of this description, 2) <a href="http://akismet.com/get/">Sign up for an Akismet plan</a> to get an API key, and 3) Go to your Akismet configuration page, and save your API key.
Version: 3.1.7
Author: Vitor Guimaraes
Author URI: http://automattic.com/wordpress-plugins/
License: GPLv2 or later
Text Domain: Abril
*/

/*
This program is free software; you can redistribute it and/or
modify it under the terms of the GNU General Public License
as published by the Free Software Foundation; either version 2
of the License, or (at your option) any later version.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with this program; if not, write to the Free Software
Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston, MA  02110-1301, USA.

Copyright 2005-2015 Automattic, Inc.
*/

// Make sure we don't expose any info if called directly
if ( !function_exists( 'add_action' ) ) {
	echo 'Hi there!  I\'m just a plugin, not much I can do when called directly.';
	exit;
}

function abril_add_produto(){
	$labels = array(
    'name'               => _x( 'Produtos', 'post type general name' ),
    'singular_name'      => _x( 'Produto', 'post type singular name' ),
    'add_new'            => _x( 'Adicionar Produto', 'book' ),
    'add_new_item'       => __( 'Adicionar novo Produto' ),
    'edit_item'          => __( 'Edit Product' ),
    'new_item'           => __( 'Novo Produto' ),
    'all_items'          => __( 'Todos os Produtos' ),
    'view_item'          => __( 'Ver Produto' ),
    'search_items'       => __( 'Pesquisar Produtos' ),
    'not_found'          => __( 'Produto não encontrado' ),
    'not_found_in_trash' => __( 'Produto não encontrado na lixeira' ), 
    'parent_item_colon'  => '',
    'menu_name'          => 'Produtos'
  );
  $args = array(
    'labels'        => $labels,
    'description'   => 'Lista de Produtos',
    'public'        => true,
    'menu_position' => 5,
    'supports'      => array( 'title'),
    'has_archive'   => true,
    'register_meta_box_cb'=>'abril_campos'
  );
  	register_post_type( 'product', $args ); 
}
add_action('init','abril_add_produto');

add_action('add_meta_boxes','abril_campos');
function abril_campos(){
    add_meta_box(
        'abril_fd_preco', 
        'Preço', 
        'abril_fd_preco', 
        'product', 
        'normal', 
        'default'
    );
}
function abril_fd_preco(){
    global $post;

    echo '<input type="hidden" name="preco" id="eventmeta_noncename" value="'.
    wp_create_nonce( plugin_basename(__FILE__) ).'" />';

    $campo = get_post_meta($post->ID, '_fb_preco', true);

    echo '<input type="text" name="_location" value="' . $campo  . '" class="widefat" />';
}
//register_taxonomy("Vendas", array("produtos"), array("hierarchical" => true, "label" => "Vendas", "singular_label" => "Venda", "rewrite" => true));



/*
define( 'AKISMET_VERSION', '3.1.7' );
define( 'AKISMET__MINIMUM_WP_VERSION', '3.2' );
define( 'AKISMET__PLUGIN_URL', plugin_dir_url( __FILE__ ) );
define( 'AKISMET__PLUGIN_DIR', plugin_dir_path( __FILE__ ) );
define( 'AKISMET_DELETE_LIMIT', 100000 );

register_activation_hook( __FILE__, array( 'Akismet', 'plugin_activation' ) );
register_deactivation_hook( __FILE__, array( 'Akismet', 'plugin_deactivation' ) );

require_once( AKISMET__PLUGIN_DIR . 'class.akismet.php' );
require_once( AKISMET__PLUGIN_DIR . 'class.akismet-widget.php' );

add_action( 'init', array( 'Akismet', 'init' ) );

if ( is_admin() ) {
	require_once( AKISMET__PLUGIN_DIR . 'class.akismet-admin.php' );
	add_action( 'init', array( 'Akismet_Admin', 'init' ) );
}

//add wrapper class around deprecated akismet functions that are referenced elsewhere
require_once( AKISMET__PLUGIN_DIR . 'wrapper.php' );

*/
