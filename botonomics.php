<?php
/**
 * Plugin Name: TeeDee Chatbots
 * Version: 1.0.0
 * Plugin URI: https://www.teedee.io/
 * Description: Current Our ChatBots are conversational AI applications designed for messaging, lead generation, feedback, support, survey and appointment for all platforms via auditory or textual methods.
 * Author: Saumitra Jagdale (Botonomics Automations LLP)
 * Author URI: https://botonomics.io/
 * License: GPLv2 or later
 */

// exit if accessed directly
if (!defined('ABSPATH'))
{
    exit;
}

define('TD_CHTBTS_PLUGIN_DIR', str_replace('\\', '/', dirname(__FILE__)));

if (!class_exists('ScriptLoaderTeeDee'))
{

    class ScriptLoaderTeeDee
    {


        function __construct()
        {

            add_action('admin_init', array(&$this,'admin_init'));
			
            add_action('admin_menu', array(&$this,'admin_menu'));
			
            add_action('wp_head', array(&$this,'wp_head'));
			
            add_action('plugins_loaded', array(&$this,'register_embed'));

            $plugin = plugin_basename(__FILE__);
            add_filter("plugin_action_links_$plugin", array(&$this,'botonomics_settings_link'));

			// Toaster if not configured
            $settings = get_option('botonomics-plugin-settings');
            if (!(isset($settings) && !empty($settings['script'])) && !(isset($_GET['page']) && $_GET['page'] == 'botonomics'))
            {
                add_action('admin_notices', array($this,'botonomics_settings_message'));
			}
			
			// Activation page auto redirect
			add_action( 'activated_plugin', array(&$this,'botonomics_activation_redirect'));
            

            // Message to rate the plugin
            add_action('admin_notices', array($this, 'botonomics_rating_request'));
            add_action('admin_init', array($this, 'botonomics_ignore_notice'));

			// Deactivation feedback
			require_once dirname( __FILE__ ) . '/deactivation-feedback/register.php';
            botonomics_feedback_include_init( plugin_basename( __FILE__ ) );

			// Register oEmbed providers
			wp_oembed_add_provider('https://teedee.io/*', 'https://teedee.io/');

        }

        function register_embed()
        {
            //Register shortcode
            add_shortcode('Boto-nomics', array(&$this,'embed_bot'));
        }

        // oembed
        function embed_bot($atts)
        {
            if (isset($atts['id']))
            {
                if (!isset($atts['height']))
                {
                    $atts['height'] = "500";
                }
                return '<iframe src="https://teedee.io/' . $atts["id"] . '" width="100%" height="' . $atts["height"] . '" frameBorder="0" allowfullscreen></iframe>';
            }
            else
            {
                return 'Please enter a valid Botonomics bot id';
            }
		
		}


        function botonomics_activation_redirect($plugin)
        {
			if( $plugin == plugin_basename( __FILE__ ) ) {
				exit(wp_redirect(admin_url('admin.php?page=botonomics')));
			}
        }

        function botonomics_settings_link($links)
        {
            $settings_link = '<a href="options-general.php?page=botonomics">' . __('Settings') . '</a>';
            $support_link = '<a href="https://teedee.io/helpcenter/Wordpress_Support" target="_blank">' . __('Support') . '</a>';

            array_push($links, $settings_link);
            array_push($links, $support_link);

            return $links;
        }
        // If script tag is empty (conditions if (!(isset($settings) && !empty($settings['script'])) && !(isset($_GET['page']) && $_GET['page'] == 'botonomics'))
        function botonomics_settings_message()
        {
		?>
			<div class="notice notice-error" style="display: flex;">
					<a href="https://teedee.io" class="logo" style="margin: auto;"><img src="https://teedee.io/static/bot/images/teedee.ico" width="60px" height="60px"  alt="TeeDee"/></a>
					<div style="flex-grow: 1; margin: 15px 15px;">
						<h4 style="margin: 0;">Add chatbot snippet to continue</h4>
						<p><?php echo __('Oops!!! It appears that your Botonomics chatbot is not configured correctly.', 'botonomics'); ?></p>
					</div>
					    <a href="https://teedee.io/secure/login" target="_blank" class="button button-primary" style="margin: auto 15px; background-color: #208a46; border-color: #208a46; text-shadow: none; box-shadow: none;">Create a free account</a>
					    <a href="admin.php?page=botonomics" class="button button-primary" style="margin: auto 15px; background-color: #f16334; border-color: #f16334; text-shadow: none; box-shadow: none;">Add the bot snippet</a>
            </div>
		<?php
        }

        // Add admin notice to rate the plugin after 7 days
        function botonomics_rating_request(){
            $settings = get_option('botonomics-plugin-settings');
            if(!empty($settings['installedOn'])){
                $ignore_rating = empty($settings['ignore_rating']) ? "" : $settings['ignore_rating'];
                if($ignore_rating != "yes"){
                    $date1 = $settings['installedOn'];
                    $date2 = date("Y/m/d");
                    $diff = abs(strtotime($date2) - strtotime($date1));
                    $days = floor($diff / (60*60*24));
                    if($days >= 7){
                        $cc_new_URI = $_SERVER['REQUEST_URI'];
                        $cc_new_URI = add_query_arg('botonomics-ignore-notice', '0', $cc_new_URI);
                        echo '<div class="notice notice-success">';
                        echo '<div style="display:flex;"><a href="https://teedee.io" class="logo" style="margin: auto;"><img src="https://teedee.io/static/images/hello_anim.gif" width="60px" height="60px"  alt="TeeDee"/></a>';
                        printf(__('<div style="flex-grow:1;margin: 15px;"><h4 style="margin: 0;">Awesome! You have been using <a href="admin.php?page=botonomics">TeeDee Chatbots</a> chatbot plugin for more than 1 week 😎</h4>
                        <p>Would you mind taking a few seconds to give it a 5-star rating on WordPress?<br/>Thank you in advance :)</p></div></div>'));
                        printf(__('<a href="%2$s" class="button button-primary" style="margin-bottom: 10px; background-color: #208a46; border-color: #208a46;" target="_blank">Ok, you deserved it</a>
                        <a class="button button-primary" style="margin-bottom: 10px;" href="%1$s">I already did</a>
                        <a class="button button-error" style="margin-bottom: 10px;" href="%1$s">No, not good enough</a>', 'advanced-database-cleaner'), $cc_new_URI,
                        '');
                        echo "</div>";
                    }
                }
            }
        }
        
        function botonomics_ignore_notice(){
            if(isset($_GET['botonomics-ignore-notice']) && $_GET['botonomics-ignore-notice'] == "0"){
                $settings = get_option('botonomics-plugin-settings');
                $settings['ignore_rating'] = "yes";
                update_option('botonomics-plugin-settings', $settings, "no");
            }
        }
        function admin_init()
        {

            // register settings for sitewide script
            register_setting('botonomics-settings-group', 'botonomics-plugin-settings');

            add_settings_field('script', 'Script', 'trim', 'botonomics');
            add_settings_field('showOn', 'Show On', 'trim', 'botonomics');
            add_settings_field('installedOn', 'Show On', 'trim', 'botonomics');

            // default value for settings
            $initialSettings = get_option('botonomics-plugin-settings');
            if ($initialSettings === false)
            {
                $initialSettings['showOn'] = 'all';
                $initialSettings['installedOn'] = date("Y/m/d");
                update_option('botonomics-plugin-settings', $initialSettings);
            } 
            if($initialSettings === true && !$initialSettings['showOn']) {
                $initialSettings['showOn'] = 'all';
                update_option('botonomics-plugin-settings', $initialSettings);
            } 
            if($initialSettings === true && !$initialSettings['installedOn']) {
                $initialSettings['installedOn'] = date("Y/m/d");
                update_option('botonomics-plugin-settings', $initialSettings);
            }
            
            // add meta box to all post types
            add_meta_box('cc_all_post_meta', esc_html__('Botonomics Snippet:', 'botonomics-settings') , 'botonomics_meta_setup', array('post','page') , 'normal', 'default');

			add_action('save_post', 'botonomics_post_meta_save');
			
 
			
        }

        // adds menu item to wordpress admin dashboard
        function admin_menu()
        {
            add_menu_page(__('TeeDee', 'botonomics-settings') , __('TeeDee', 'botonomics-settings') , 'manage_options', 'botonomics', array(&$this,
                'botonomics_options_panel'));

        }

        function wp_head()
        {

            $settings = get_option('botonomics-plugin-settings');

            if (is_array($settings) && array_key_exists('script', $settings))
            {
                $script = $settings['script'];
                $showOn = $settings['showOn'];

                // main bot
                if ($script != '')
                {
                    if (($showOn === 'all') || ($showOn === 'home' && (is_home() || is_front_page())) || ($showOn === 'nothome' && !is_home() && !is_front_page()) || !$showOn === 'none')
                    {
                        echo $script, '<script type="text/javascript">var botonomicsWordpress = true;</script>', "\n";
                    }
                }
            }

            // post and page bots
            $cc_post_meta = get_post_meta(get_the_ID() , '_inpost_head_script', true);
            if ($cc_post_meta != '' && !is_home() && !is_front_page())
            {
                echo $cc_post_meta['synth_header_script'], '<script type="text/javascript">var botonomicsWordpress = true;</script>', "\n";
            }

        }

        function botonomics_options_panel()
        {
            // Load options page
            require_once (TD_CHTBTS_PLUGIN_DIR . '/options.php');
        }
    }

    function botonomics_meta_setup()
    {
        global $post;

        // using an underscore, prevents the meta variable
        // from showing up in the custom fields section
        $meta = get_post_meta($post->ID, '_inpost_head_script', true);

        // instead of writing HTML here, lets do an include
        include_once (TD_CHTBTS_PLUGIN_DIR . '/meta.php');

        // create a custom nonce for submit verification later
        echo '<input type="hidden" name="cc_post_meta_noncename" value="' . wp_create_nonce(__FILE__) . '" />';
    }

    function botonomics_post_meta_save($post_id)
    {

        // make sure data came from our meta box
        if (!isset($_POST['cc_post_meta_noncename']) || !wp_verify_nonce($_POST['cc_post_meta_noncename'], __FILE__)) return $post_id;

        // check user permissions
        if ($_POST['post_type'] == 'page')
        {
            if (!current_user_can('edit_page', $post_id)) return $post_id;

        }
        else
        {

            if (!current_user_can('edit_post', $post_id)) return $post_id;

        }

        $current_data = get_post_meta($post_id, '_inpost_head_script', true);

        $new_data = sanitize_text_field($_POST['_inpost_head_script']);

        botonomics_post_meta_clean($new_data);

        if ($current_data)
        {

            if (is_null($new_data)) delete_post_meta($post_id, '_inpost_head_script');

            else update_post_meta($post_id, '_inpost_head_script', $new_data);

        }
        elseif (!is_null($new_data))
        {

            add_post_meta($post_id, '_inpost_head_script', $new_data, true);

        }

        return $post_id;
    }

    function botonomics_post_meta_clean(&$arr)
    {

        if (is_array($arr))
        {

            foreach ($arr as $i => $v)
            {

                if (is_array($arr[$i]))
                {
                    botonomics_post_meta_clean($arr[$i]);

                    if (!count($arr[$i]))
                    {
                        unset($arr[$i]);
                    }

                }
                else
                {

                    if (trim($arr[$i]) == '')
                    {
                        unset($arr[$i]);
                    }
                }
            }

            if (!count($arr))
            {
                $arr = NULL;
            }
        }
    }

    $scripts = new ScriptLoaderTeeDee();

}
?>
