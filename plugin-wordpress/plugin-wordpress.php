<?php
/**
 * Plugin Name: Plugin Wordpress Plugin
 * Description: Ejemplo de como hacer un plugin
 */

    //Creando shortcode
    function plugin_example_function(){
        $information = "Esto es un texto del plugin";
        $information.= "<div>HOLA MUNDO  </div>";
        $information.= "<div>ADIOS MUNDO  </div>";
        return $information;
    }
    add_shortcode('example','plugin_example_function');

    //Creando el menu con el callback
    function plugin_menu_option(){

        add_menu_page('Header & Footer Scripts', 'Site scripts', 'manage_options', 'plugin-example-menu','plugin_script_page','',200);
    }
    add_action('admin_menu','plugin_menu_option');
    
    //Funcion encargada de crear la pagina del plugin cuando se muestrado
    function plugin_script_page(){

        if(array_key_exists('submit_scripts_update',$_POST)){
            update_option('plugin_header_scripts', $_POST['header_scripts']);
            update_option('plugin_footer_scripts', $_POST['footer_scripts']);
            ?>
                <div id="setting-error-settings-updated" class="updated_settings_error notice is-dismissible">
                    <strong>
                        Setting have seen changed 
                    </strong>
                </div>
            <?php

        }

        $header_scripts = get_option('plugin_header_scripts', 'none');
        $footer_scripts = get_option('plugin_footer_scripts', 'none');
        ?>
            <div class="wrap">
                <h2>Actualizar header y footer</h2>
                <form method="post" action="">
                    <label for="header_scripts">Header script</label>
                    <textarea name="header_scripts" class="large-text"> <?php print $header_scripts; ?></textarea>
                    <label for="footer_scripts">Footer script</label>
                    <textarea name="footer_scripts" class="large-text"> <?php print $footer_scripts; ?> </textarea>
                    <input type="submit" name="submit_scripts_update" class="button button-primary" value="Enviar">
                </form>
            </div>
        <?php
    }

    function plugin_display_header_scripts(){
        $header_scripts = get_option('plugin_header_scripts', 'none');
        print $header_scripts;
    }
    add_action('wp_head', 'plugin_display_header_scripts');

    //////Footer
    function plugin_display_footer_scripts(){
        $footer_scripts = get_option('plugin_footer_scripts', 'none');
        print $footer_scripts;
    }
    add_action('wp_footer', 'plugin_display_footer_scripts');

    //Creando formulario
    function plugin_form(){
        $content = '';
        $content .= '<form method="post" action="http://localhost:8080/?p=18" >';
        $content .= '<input type="text" name="full_name" placeholder="Nombre completo" />';
        $content .= '<br/>';
        $content .= '<br/>';

        $content .= '<input type="text" name="email_address" placeholder="Correo electrónico" />';
        $content .= '<br/>';
        $content .= '<br/>';

        $content .= '<input type="submit" name="submit_form_contact value="Enviar" />';
        $content .= '</form>';
        return $content;
    }
    add_shortcode('plugin_contact_form','plugin_form');

    //Capturando datos del formulario

    function set_html_content_type(){
        return 'text/html';
    }

    function plugin_form_capture(){
        if(array_key_exists('submit_form_contact',$_POST)){

            $to = 'jorgegonzalezw97@gmail.com';
            $subject = 'Prueba del formulario ';
            $body = '';
            $body .= 'Nombre:'.$_POST['full_name'].'<br/>';
            $body .= 'Correo:'.$_POST['email_address'].'<br/>';
            add_filter('wp_mail_content_type', 'set_html_content_type');
            wp_mail($to, $subject, $body);
            remove_filter('wp_mail_content_type','set_html_content_type');
        }
        return 'xxxxxxx';
    }
    add_action('wp_header', 'plugin_form_capture');
?>