
<!-- HEADER -->
<div class="wrap">
  <div class="botonomics-logos">
    <table>
      <th>
        
        <td>
          <a href="https://teedee.io/" target="_blank">
          <img style="width: 286px;height:67px;padding-right:700px" src="https://teedee.io/static/images/logo_teedee.png" />
          </a>        
        </td>
        <td>
          <a href="https://botonomics.io/" target="_blank">
          <img style="position:relative;width: 163px;height: 75px;padding-top:10px;" src="https://botonomics.io/img/boto_logo.png" />
          </a>
        </td>
      </th>
    </table>
  </div>
<!-- CONTENT -->
  <hr/>
  <!-- LEFT COLUMN -->
    <div id="poststuff">
      <div id="post-body" class="metabox-holder columns-2">
        <div id="post-body-content">
          <div class="postbox" style="padding-top:5px;padding-left: 29px;background: rgba(255, 255, 255, 0.65);">
          
          <form name="dofollow" action="options.php" method="post" style="text-align:left;">

            <?php
            settings_fields('botonomics-settings-group');
            $settings = get_option('botonomics-plugin-settings');
            $script = (array_key_exists('script', $settings) ? $settings['script'] : '');
            $showOn = (array_key_exists('showOn', $settings) ? $settings['showOn'] : 'all');
            ?>
            <div id="botonomics-instructions">
            <h3 style="text-align:left;font-family: Sans-serif;font-style: normal;font-weight: 500;font-size:26px;"><b><?php _e('Follow these 3 easy steps to set up  ', 'botonomics'); ?></b></h3>
            <h3 style="text-align:left;font-family: Sans-serif;font-style: normal;font-weight: 500;font-size:26px;"><b><?php _e('TeeDee:', 'botonomics'); ?></b></h3>
            <?php
            $userEmail = '';
            if (wp_get_current_user() instanceof WP_User) $userEmail = wp_get_current_user()->user_email;
            ?>
            
            <p style="text-align:left;font-family: Roboto;font-style: normal;font-weight: normal;font-size: 17px;"><b>1.</b> <?php _e('<a href="https://teedee.io/secure/login" target="_blank" >Create an account</a> if you are not an existing user at TeeDee.', 'botonomics'); ?></p>

            <p style="text-align:left;font-family: Roboto;font-style: normal;font-weight: normal;font-size: 17px;"><b>2.</b> <?php _e('Design your Chatbot using Real Time Customization', 'botonomics'); ?></p>

            <p style="text-align:left;font-family: Roboto;font-style: normal;font-weight: normal;font-size: 17px;"><b>3.</b> <?php _e('Copy the code snippet from Settings >> Publish and paste it here', 'botonomics'); ?></p>
            
            </div>
            
            <h3 style="text-align:left;font-family: Sans-serif;font-style: normal;font-weight: 1000;font-size: 20px;" for="script"><b><?php _e('Chatbot Snippet:', 'botonomics'); ?></b></h3>
            
            <textarea style="position:relative;width: 75%;height: 200px;padding: 32px 20px;box-sizing: border-box;border: 2px solid #ccc;border-radius: 4px; resize: none;background: rgba(255, 255, 255, 0.65);" id="botonomics-plugin-snippet"  rows="5" cols="50" id="script" name="botonomics-plugin-settings[script]"><?php echo esc_html($script); ?></textarea>

            <p>
              
              <h3 style="text-align:left;font-family: Sans-serif;font-style: normal;font-weight: 500;font-size: 20px;color: #000000;"><b>Share Chatbot On:</b> </h3>
              <table>
                <th>
                  <td style="padding-right:50px;"><input style="position:relative;width: 15px;height: 15px;background: rgba(255, 255, 255, 0.75);border: 1px solid #000000;box-sizing: border-box; " type="radio" name="botonomics-plugin-settings[showOn]" value="all" id="all" <?php checked('all', $showOn); ?>> <label class="botonomics-radio-text" for="all"><?php _e('All Pages', 'botonomics'); ?></label></td>
                  <td style="padding-right:50px;"><input  style="position:relative;width:15px;height:15px;background: rgba(255, 255, 255, 0.75);border: 1px solid #000000;box-sizing: border-box; " type="radio" name="botonomics-plugin-settings[showOn]" value="home" id="home" <?php checked('home', $showOn); ?>> <label class="botonomics-radio-text" for="home"><?php _e('Homepage', 'botonomics'); ?></label></td>
                  <td style="padding-right:50px;"><input style="position:relative;width:15px;height:15px;background: rgba(255, 255, 255, 0.75);border: 1px solid #000000;box-sizing: border-box; " type="radio" name="botonomics-plugin-settings[showOn]" value="nothome" id="nothome" <?php checked('nothome', $showOn); ?>> <label class="botonomics-radio-text" for="nothome"><?php _e('Selected Page', 'botonomics'); ?></label></td>
                  <td style="padding-right:50px;"><input  style="position:relative;width:15px;height:15px;background: rgba(255, 255, 255, 0.75);border: 1px solid #000000;box-sizing: border-box; " type="radio" name="botonomics-plugin-settings[showOn]" value="none" id="none" <?php checked('none', $showOn); ?>> <label class="botonomics-radio-text" for="none"><?php _e('Nowhere', 'botonomics'); ?></label></td>
                </th>
              </table>
            </p>
            
            <p style="text-align:left;font-family: Sans-serif;font-weight: 500;font-size: 16px;line-height: 35px;padding-top:10px;color: #FFFFFF;">
              <input type="submit" name="Submit" value="<?php _e('Submit', 'botonomics'); ?>"  style=" width:100px;font-family:Sans-serif;font-style: normal;font-weight: 500;font-size: 17px;line-height: 35px;color: #FFFFFF;background: #0359A8;border-radius: 5px;"/>
            </p>
            </form>
          </div>
        </div>
      

   <?php require_once (TD_CHTBTS_PLUGIN_DIR . '/sidebar.php'); ?>
      </div>


  
  

  <style>
/* MAIN DIVISION AFTER HEADER */






/* LEFT COLUMN CSS */
  .botonomics-logos{
    display: flex;
    flex-wrap: wrap;
    padding: 0 4px;
  }
  

 
  .botonomics-radio-text{
    position:relative;
    font-family: Futura;
    font-style: normal;
    font-weight: 500;
    font-size: 18px;
    line-height: 29px;
    color: #000000;
  }

/* RIGHT COLUMN CSS */


.botonomics-watch-tutorial-button{

width: 165px;
height: 35px;
padding:5px 20px 5px 18px;
background: #E5E5E5;
border: 3px solid #288DEA;
box-sizing: border-box;

 }

.botonomics-read-instruction-button{

width: 165px;
height: 35px;
padding:5px 15px 5px 15px;
 
background: #E5E5E5;
border: 3px solid #288DEA;
box-sizing: border-box;



}

.botonomics-watch-tutorial-text{

text-align:center;
 
font-family: Roboto;

font-size: 18px;
color: #288DEA;
}
.botonomics-read-instruction-text{
 
text-align:center;

 
font-family: Roboto;
font-size: 18px;

 
color: #288DEA;
}

.botonomics-rateus{
    width: 250px;
    height: 225px;
    padding-top:15px;
  
    background: rgba(255, 255, 255, 0.65);
  }







</style>



<script>
  const snippetValue = document.getElementById("botonomics-plugin-snippet") && document.getElementById("botonomics-plugin-snippet").value
  console.log('hi',<?php wp_get_current_user() ?>);
  if(snippetValue.indexOf('<script') !== -1) {
    document.getElementById("botonomics-instructions").style.display = "none";
  }
</script>



  
