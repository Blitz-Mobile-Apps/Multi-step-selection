<?php
function Dynamic_Form()
{

    require MAINPATH . 'backend/cs_form.php';

}

function cs_Types()
{

    require MAINPATH . 'backend/cs_types.php';

}

function Custom_Orders_function()
{

    require MAINPATH . 'backend/cs_entries.php';

}

add_action('admin_menu', 'wpse149688');
function wpse149688()
{

    add_menu_page('Dynamic Form', 'Dynamic Form', 'manage_options', 'Dynamic_Form', 'Dynamic_Form');
    add_submenu_page('Dynamic_Form', 'Types', 'Types', 'edit_theme_options', 'cs_Types', 'cs_Types');
    add_submenu_page('Dynamic_Form', 'Custom Orders', 'Custom Orders', 'edit_theme_options', 'Subscription', 'Custom_Orders_function');
    add_submenu_page('Dynamic_Form', 'Settings', 'Settings', 'edit_theme_options', 'settings_page', 'theme_settings_page');

}

// Styling and scripts
add_action('lms_scripts', 'lms_scripts_styles');
function lms_scripts_styles()
{

    echo '<link rel="stylesheet" href="' . MAINURL . '/assets/css/bootstrap.css">';
    echo '<link href="' . MAINURL . '/assets/vendor/featherlight/featherlight.min.css" type="text/css" rel="stylesheet" />';
    echo '<script src="' . MAINURL . '/assets/vendor/featherlight/featherlight.min.js" type="text/javascript" charset="utf-8"></script>';

}

function wpse_enqueue_datepicker()
{

    wp_enqueue_script('jquery-ui-datepicker');
    wp_register_style('jquery-ui', 'https://code.jquery.com/ui/1.11.2/themes/smoothness/jquery-ui.css');
    wp_enqueue_style('jquery-ui');


    global $wpdb;
    $tablename=$wpdb->prefix.'dynamic_type';
    $main = $data = $wpdb->get_row('SELECT COUNT(*) as count FROM '.$tablename.' ');
    wp_localize_script('jquery-ui-datepicker', 'cs_object',
        array(
            'step_count' => $main->count+1,
        )
    );

}

add_action('wp_enqueue_scripts', 'wpse_enqueue_datepicker');
function theme_settings_page()
{

    ?>

    <div class="wrap">
        <h1>Theme Panel</h1>
        <form method="post" action="options.php">
            <?php
            settings_fields("section");
            do_settings_sections("theme-options");
            submit_button();
            ?>
        </form>

    </div>

    <?php
}

function display_function_1()
{ ?>

    <input type="text" style="width: 300px" name="API_username" id="API_username"
           value="<?php echo get_option('API_username'); ?>"/>

    <?php
}

function display_function_2()
{ ?>

    <input type="text" style="width: 300px" name="API_password" id="API_password"
           value="<?php echo get_option('API_password'); ?>"/>

    <?php
}

function display_function_3()
{ ?>

    <input type="text" style="width: 300px" name="API_signature" id="API_signature"
           value="<?php echo get_option('API_signature'); ?>"/>

    <?php
}

function display_function_4()
{ ?>


    <select style="width: 300px" name="paypalstatus" id="paypalstatus">

        <option value="<?php echo get_option('paypalstatus'); ?>"><?php echo get_option('paypalstatus'); ?></option>

        <option value="false">false</option>

    </select>


    <?php
}

function display_theme_panel_fields()
{

    add_settings_section("section", "Paypal Setting", null, "theme-options");
    add_settings_field("paypalstatus", "Paypal Sandbox", "display_function_4", "theme-options", "section");
    add_settings_field("API_username", "API username", "display_function_1", "theme-options", "section");
    add_settings_field("API_password", "API password", "display_function_2", "theme-options", "section");
    add_settings_field("API_signature", "API signature", "display_function_3", "theme-options", "section");
    register_setting("section", "API_username");
    register_setting("section", "API_password");
    register_setting("section", "API_signature");
    register_setting("section", "paypalstatus");

}

add_action("admin_init", "display_theme_panel_fields");