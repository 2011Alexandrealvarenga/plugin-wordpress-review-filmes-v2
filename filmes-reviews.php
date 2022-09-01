<?php 

/*
Plugin Name: Filmes Reviews
Plugin URI: http://exemplo.com
Description: Plugin para reviewws de filmes
Version: 1.0
Author:
Text Domain: filmes-reviews
License: GPL2
*/

class Filmes_reviews{
    private static $instance;
    public static function getInstance(){
        if(self::$instance == NULL){
            self::$instance = new self();
        }
        return self::$instance;
    }

    private function __construct(){
        add_action('init', 'Filmes_reviews::register_post_type');
        add_action('init', 'Filmes_reviews::register_taxonomies');
    }
    public static function register_post_type(){
        register_post_type('filmes_reviews',array(
            'labels' => array(
                'name'          =>  'Filmes Reviews',
                'singular_name' =>  'Filme Revies',
            ),
            'description'       =>  'Post para cadastro de reviews',
            'supports'          => array(
                'title','editor','excerpt','author','revisions','thumbnail','custom-fields',
            ),
            'public'        =>  TRUE,
            'menu_icon'     =>  'dashicons-format-video',
            'menu_position' =>  4,
        ));
    }
    // taxonomias
    public static function register_taxonomies(){
        register_taxonomy('tipos_filmes', array('filmes_reviews'),
            array(
                'labels'            =>      array(
                    'name'          =>      __('Filmes Tipos'),
                    'singular_name' =>      __('Filme Tipo')
                ),
                'public'            =>      TRUE,
                'hieararchical'     =>      TRUE,
                'rewrite'           =>      array('slug'    =>  'tipos-filmes'),
                )
        );
    }
    public static function activate(){
        self::register_post_type();
        self::register_taxonomies();
        flush_rewrite_rules();
    }
}
Filmes_reviews::getInstance();

register_deactivation_hook(__FILE__, 'flush_rewrite_rules');
register_activation_hook(__FILE__, 'Filmes_reviews::activate');