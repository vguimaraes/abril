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

if ( !function_exists( 'add_action' ) ) {
	echo 'A função add_ation não foi carregada...';
	exit;
}

include('class_produto.php');
include('class_cliente.php');

function abril_add_cliente(){
    $labels = array(
    'name'               => _x( 'Clientes', 'post type general name' ),
    'singular_name'      => _x( 'Cliente', 'post type singular name' ),
    'add_new'            => _x( 'Adicionar Cliente', 'book' ),
    'add_new_item'       => __( 'Adicionar novo Cliente' ),
    'edit_item'          => __( 'Editar Cliente' ),
    'new_item'           => __( 'Novo Cliente' ),
    'all_items'          => __( 'Todos os Cliente' ),
    'view_item'          => __( 'Ver Cliente' ),
    'search_items'       => __( 'Pesquisar Clientes' ),
    'not_found'          => __( 'Cliente não encontrado' ),
    'not_found_in_trash' => __( 'Cliente não encontrado na lixeira' ), 
    'parent_item_colon'  => '',
    'menu_name'          => 'Clientes'
  );
  $args = array(
    'labels'        => $labels,
    'description'   => 'Lista de Clientes',
    'public'        => true,
    'menu_position' => 6,
    'supports'      => array( 'title'),
    'has_archive'   => true,
    'register_meta_box_cb'=>'abril_campos_cliente'
  );
    register_post_type( 'custumer', $args ); 
}
add_action('init','abril_add_cliente');

//Adcionando campos
add_action('add_meta_boxes','abril_campos_cliente');
function abril_campos_cliente(){
    add_meta_box(
        'abril_fd_cliente', 
        'Dados', 
        'abril_fd_cliente', 
        'custumer', 
        'normal', 
        'default'
    );
}


function abril_fd_cliente(){
    global $post;

    $html = '<input type="hidden" name="eventmeta_noncename" id="eventmeta_noncename" value="' . 
    wp_create_nonce( plugin_basename(__FILE__) ) . '" />';
    
    $cliente = new Cliente();
    $res = $cliente->ler_cliente(array('wp_id'=>$post->ID));
    $dados = $res['retorno'][0];
    
    $html .= '<label>E-mail</label>';
    $html .= '<input type="text" name="email" value="' . $dados['email']  . '" class="widefat" />';

    $html .= '<label>Telefone</label>';
    $html .= '<input type="text" name="telefone" value="' . $dados['telefone']  . '" class="widefat" />';

    echo $html;
}




#############PRODUTO
//Criando POST TYPE
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
    'register_meta_box_cb'=>'abril_campos_produto'
  );
  	register_post_type( 'product', $args ); 
}
add_action('init','abril_add_produto');


//Adcionando campos
add_action('add_meta_boxes','abril_campos_produto');
function abril_campos_produto(){
    add_meta_box(
        'abril_fd_produto', 
        'Características', 
        'abril_fd_produto', 
        'product', 
        'normal', 
        'default'
    );
}

function abril_fd_produto(){
    global $post;

    $html = '<input type="hidden" name="eventmeta_noncename" id="eventmeta_noncename" value="' . 
    wp_create_nonce( plugin_basename(__FILE__) ) . '" />';
    
    $produto = new Produto();
    $res = $produto->ler_produto(array('wp_id'=>$post->ID));
    $valor = $res['retorno'][0]['preco'];
    $estoque = $res['retorno'][0]['estoque'];
    // Echo out the field
    $html .= '<label>Preço</label>';
    $html .= '<input type="number" name="preco" value="' . $valor  . '" class="widefat" />';
    $html .= '<label>Estoque</label>';
    $html .= '<input type="number" name="estoque" value="' . $estoque  . '" class="widefat" />';

    echo $html;
}

//Salvando dados
function abril_save(){

    if ( !current_user_can( 'edit_post', $post->ID ))
        return $post->ID;

    if($_POST['post_type']=='custumer'){
         $dados = array(
            'nome'=>$_POST['post_title'],
            'email'=>$_POST['email'],
            'telefone'=>$_POST['telefone'],
            'wp_id'=> $_POST['ID']
        );
        $cliente = new Cliente();
        $lista = $cliente->ler_cliente(array('wp_id'=>$_POST['ID']));
        if($lista['linhas']==0){
            $res = $cliente->novo_cliente($dados);
        }else{
             $res = $cliente->atualizar_cliente($dados);
             
        }
    }

    if($_POST['post_type']=='product'){
        $dados = array(
            'nome'=>$_POST['post_title'],
            'preco'=>$_POST['preco'],
            'estoque'=>$_POST['estoque'],
            'wp_id'=> $_POST['ID']
        );
        $produto = new Produto();
        $lista = $produto->ler_produto(array('wp_id'=>$_POST['ID']));
        if($lista['linhas']==0){
            $res = $produto->adicionar_produto($dados);
        }else{
             $res = $produto->atualizar_produto($dados);
        }
    }
}

add_action('save_post', 'abril_save', 1, 2);
