<?php

use lib\Parser;

define('TM_DIR', get_template_directory(__FILE__));
define('TM_URL', get_template_directory_uri(__FILE__));

require_once TM_DIR . '/lib/Parser.php';

function add_style(){
    wp_enqueue_style( 'my-bootstrap-extension', get_template_directory_uri() . '/css/bootstrap.min.css', array(), '1');
    wp_enqueue_style( 'owl', get_template_directory_uri() . '/css/owl.carousel.css', array('my-bootstrap-extension'), '1');
    wp_enqueue_style( 'owl-theme', get_template_directory_uri() . '/css/owl.theme.css', array('my-bootstrap-extension'), '1');
    wp_enqueue_style( 'instalink', get_template_directory_uri() . '/css/instalink-1.6.6.min.css', array('my-bootstrap-extension'), '1');
    wp_enqueue_style( 'my-styles', get_template_directory_uri() . '/css/style.css', array('my-bootstrap-extension'), '1');
    wp_enqueue_style( 'font-ewesome', 'https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css', array('my-bootstrap-extension'), '1');
    wp_enqueue_style( 'video-js', 'http://vjs.zencdn.net/5.7.1/video-js.css', array('my-bootstrap-extension'), '1');
    wp_enqueue_style( 'my-sass', get_template_directory_uri() . '/sass/style.css', array('my-bootstrap-extension'), '1');
    wp_enqueue_style( 'fotorama', get_template_directory_uri() . '/css/fotorama.css', array('my-bootstrap-extension'), '1');
}

function add_script(){
    wp_enqueue_script( 'jquery', get_template_directory_uri() . '/js/jquery-2.1.3.min.js', array(), '1');
    wp_enqueue_script( 'jq', 'https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js', array(), '1');
    wp_enqueue_script( 'my-bootstrap-extension', get_template_directory_uri() . '/js/bootstrap.min.js', array(), '1');
    wp_enqueue_script( 'owl', get_template_directory_uri() . '/js/owl.carousel.min.js', array(), '1',1);
    wp_enqueue_script( 'instalink', get_template_directory_uri() . '/js/instalink-1.6.6.min.js', array(), '1',1);
    wp_enqueue_script( 'yndex-map', 'http://api-maps.yandex.ru/2.1/?lang=ru_RU', array(), '1');
    wp_enqueue_script( 'vide-js', get_template_directory_uri() . '/js/jquery.vide.min.js', array(), '1', 1);
    wp_enqueue_script( 'my-script', get_template_directory_uri() . '/js/script.min.js', array(), '1');
    wp_enqueue_script( 'fotorama-js', get_template_directory_uri() . '/js/fotorama.js', array(), '1');
    wp_localize_script( 'my-script', 'myajax',
        array(
            'url' => get_template_directory_uri().'/img/',
            'act' => admin_url('admin-ajax.php')
        ));
}

function add_admin_script(){
    wp_enqueue_script( 'jquery', get_template_directory_uri() . '/js/jquery-2.1.3.min.js', array(), '1');
    wp_enqueue_script('admin',get_template_directory_uri() . '/js/admin.js', array(), '1');
    wp_enqueue_style( 'my-bootstrap-extension-admin', get_template_directory_uri() . '/css/bootstrap.min.css', array(), '1');
    wp_enqueue_script( 'my-bootstrap-extension', get_template_directory_uri() . '/js/bootstrap.min.js', array(), '1');
    wp_enqueue_style( 'my-style-admin', get_template_directory_uri() . '/css/admin.css', array(), '1');
}

add_action('admin_enqueue_scripts', 'add_admin_script');
add_action( 'wp_enqueue_scripts', 'add_style' );
add_action( 'wp_enqueue_scripts', 'add_script' );

function prn($content) {
    echo '<pre style="background: lightgray; border: 1px solid black; padding: 2px">';
    print_r ( $content );
    echo '</pre>';
}

function my_pagenavi() {
    global $wp_query;

    $big = 999999999; // уникальное число для замены

    $args = array(
        'base' => str_replace( $big, '%#%', get_pagenum_link( $big ) )
    ,'format' => ''
    ,'current' => max( 1, get_query_var('paged') )
    ,'total' => $wp_query->max_num_pages
    );

    $result = paginate_links( $args );

    // удаляем добавку к пагинации для первой страницы
    $result = str_replace( '/page/1/', '', $result );

    echo $result;
}

function excerpt_readmore($more) {
    return '... <br><a href="'. get_permalink($post->ID) . '" class="readmore">' . 'Читать далее' . '</a>';
}
add_filter('excerpt_more', 'excerpt_readmore');


if ( function_exists( 'add_theme_support' ) )
    add_theme_support( 'post-thumbnails' );


/*----------------------------------------------— Наши партнеры —---------------------------------------------------------*/

add_action('init', 'myCustomInitPartners');

function myCustomInitPartners()
{
    $labels = array(
        'name' => 'Наши партнеры', // Основное название типа записи
        'singular_name' => 'Наш партнер', // отдельное название записи типа Book
        'add_new' => 'Добавить партнера',
        'add_new_item' => 'Добавить партнера',
        'edit_item' => 'Редактировать партнера',
        'new_item' => 'Новый партнер',
        'view_item' => 'Посмотреть партнера',
        'search_items' => 'Найти партнера',
        'not_found' => 'Не найдено',
        'not_found_in_trash' => 'В корзине партнеров не найдено',
        'parent_item_colon' => '',
        'menu_name' => 'Наши партнеры'

    );
    $args = array(
        'labels' => $labels,
        'public' => true,
        'publicly_queryable' => true,
        'show_ui' => true,
        'show_in_menu' => true,
        'query_var' => true,
        'rewrite' => true,
        'capability_type' => 'post',
        'has_archive' => true,
        'hierarchical' => false,
        'menu_position' => null,
        'supports' => array('title','thumbnail')
    );
    register_post_type('partners', $args);
}



function partnersShortcode()
{
    $args = array(
        'post_type' => 'partners',
        'post_status' => 'publish',
        'posts_per_page' => -1
    );

    $my_query = null;
    $my_query = new WP_Query($args);

    $parser = new \Parser();
    $parser->render(TM_DIR . '/views/partners.php', ['partners'=>$my_query]);

}

add_shortcode('partners', 'partnersShortcode');

/*---------------------------------------------— END Наши партнеры —------------------------------------------------------*/

// AJAX ACTION
add_action('wp_ajax_sendBC', 'sendBC');
add_action('wp_ajax_nopriv_sendBC', 'sendBC');

function sendBC(){
    add_filter( 'wp_mail_content_type', 'set_html_content_type' );
    $msg = "<b>Имя: </b>" . $_POST['name'] . "<br><b>Телефон: </b>" . $_POST['phone'];
    wp_mail( get_option('admin_email'), 'Заказ обратного звонка', $msg );
    remove_filter( 'wp_mail_content_type', 'set_html_content_type' );
    wp_die();
}

// AJAX ACTION
add_action('wp_ajax_sendOrder', 'sendOrder');
add_action('wp_ajax_nopriv_sendOrder', 'sendOrder');

function sendOrder(){
    add_filter( 'wp_mail_content_type', 'set_html_content_type' );
    $msg = "<b>Тарифный план:</b> " . $_POST['order_name'] . "<br><b>Имя: </b>" . $_POST['name'] . "<br><b>Телефон: </b>" . $_POST['phone'];
    wp_mail( get_option('admin_email'), $_POST['order_type'], $msg );
    remove_filter( 'wp_mail_content_type', 'set_html_content_type' );
    wp_die();
}

// AJAX ACTION
add_action('wp_ajax_sendPhone', 'sendPhone');
add_action('wp_ajax_nopriv_sendPhone', 'sendPhone');

function sendPhone(){
    add_filter( 'wp_mail_content_type', 'set_html_content_type' );
    $msg = "<br><b>Телефон: </b>" . $_POST['phone'];
    wp_mail( get_option('admin_email'), "Присоединился", $msg );
    remove_filter( 'wp_mail_content_type', 'set_html_content_type' );
    wp_die();
}

// AJAX ACTION
add_action('wp_ajax_sendFeedback', 'sendFeedback');
add_action('wp_ajax_nopriv_sendFeedback', 'sendFeedback');

function sendFeedback(){
    add_filter( 'wp_mail_content_type', 'set_html_content_type' );
    $msg = "<br><b>Имя: </b>" . $_POST['name'];
    $msg .= "<br><b>Email: </b>" . $_POST['email'];
    $msg .= "<br><b>Сообщение: </b>" . $_POST['text'];
    wp_mail( get_option('admin_email'), "Обратная связь", $msg );
    remove_filter( 'wp_mail_content_type', 'set_html_content_type' );
    wp_die();
}

function set_html_content_type() {
    return 'text/html';
}