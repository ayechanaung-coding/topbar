<?php
/*
 * Plugin Name:       Welcome Top Bar
 * Plugin URI:        https://ieatwebsites.com
 * Description:       Handle the basics with this plugin.
 * Version:           1.0
 * Author:            John Smith
 * Author URI:        https://ieatwebsites.com

 */

 

add_action('wp_body_open','tb_head');
function get_user_or_websitename(){
    if(!is_user_logged_in()){

        if(get_option('topbar_field')){
            return get_option('topbar_field');
        }else{
            return 'to '.get_bloginfo('name');
        }
       
    }else{
        $current_user=wp_get_current_user();
        return $current_user->user_login;
    }
}

function tb_head(){
    echo '<h3 class="tb" >Welcome '.get_user_or_websitename().'</h3>';
}
add_action('wp_print_styles','tb_css');
function tb_css(){
    echo '
    <style>
        h3.tb{ background-color: orange; color: white;margin:0;padding:30px;text-align:center}
    </style>';
}

//Top Bar Plugin Page Menu Add
function topbar_plugin_page(){
    $page_title='Top Bar Options';
    $menu_title='Top Bar';
    $capability='manage_options';//only admin can see this menu
    $slug='topbar-plugin';//unique identifier for this menu item.
    $callback='topbar_page_html';
    $icon='dashicons-schedule';
    $position=60;

    add_menu_page($page_title,$menu_title,$capability,$slug,$callback,$icon,$position);
}
 
add_action('admin_menu','topbar_plugin_page');


//creating a settings page in the WordPress 
function topbar_register_settings(){
    register_setting('topbar_option_group','topbar_field');// registers a setting named topbar_field in the topbar_option_group.topbar field that will be stored in the database.

}

add_action('admin_init','topbar_register_settings');//wordpress admin initialized

//Render the settings page
function topbar_page_html(){?>

<div class="wrap top-bar-wrapper">
  <form method="post" action="options.php">
         <?php settings_errors(); //display settings errors or messages?>
         <?php settings_fields('topbar_option_group');?>
         <label for="topbar_field_eat">Top Bar Text:</label>
         <input name="topbar_field" id="topbar_field_eat" type="text" 
         value="<?php echo get_option('topbar_field'); ?>">
         <?php submit_button();?>
         
 </form>
</div>

<?php 
}

add_action('admin_head','topbarstyle');

function topbarstyle(){
    echo '<style>
    .top-bar-wrapper {display: flex; align-items: center;justify-content: center;margin-top:35px}
	.top-bar-wrapper form {width: 100%; max-width: 800px;}
	.top-bar-wrapper label {font-size: 3em; display: block; line-height:normal; margin-bottom: 30px;font-weigth:bold}
	.top-bar-wrapper input {color:#666;width: 100%; padding: 30px; font-size: 3em}
	.top-bar-wrapper .button {font-size: 2em; text-transform: uppercase; background: rgba(59,173,227,1);
		background: linear-gradient(45deg, rgba(59,173,227,1) 0%, rgba(87,111,230,1) 25%, rgba(152,68,183,1) 51%, rgba(255,53,127,1) 100%);border:none}
    </style>';
}

