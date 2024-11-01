<?php

 // Die if file is called directly
 if ( ! defined( 'WPINC' ) ) {
	die;
}

// Default languages
$CubilisFastbooker_languages = array(
  'nl' => __('dutch', 'cubilis-fastbooker'),
  'fr' => __('french', 'cubilis-fastbooker'),
  'en' => __('english', 'cubilis-fastbooker'),
  'de' => __('deutch', 'cubilis-fastbooker'),
  'es' => __('spanish', 'cubilis-fastbooker'),
  'it' => __('italian', 'cubilis-fastbooker'),
  'ru' => __('russian', 'cubilis-fastbooker'),
  'zh' => __('chinese', 'cubilis-fastbooker'),
);

if (isset($_POST['cubilis-fastbooker-submit']) && wp_verify_nonce($_POST['cubilis-fastbooker-nonce'], 'cubilis_fastbooker_nonce')) {
  // Set setting values
  $CubilisFastbooker_active_entry = sanitize_text_field($_POST['cubilis-fastbooker-active']);
  $CubilisFastbooker_identifier_entry = sanitize_text_field($_POST['cubilis-fastbooker-identifier']);
  $CubilisFastbooker_lanugage_entry = sanitize_text_field($_POST['cubilis-fastbooker-language']);
  $CubilisFastbooker_discount_entry = sanitize_text_field($_POST['cubilis-fastbooker-discount']);
  $CubilisFastbooker_generalAvailability_entry = sanitize_text_field($_POST['cubilis-fastbooker-general-availability']);
  $CubilisFastbooker_icons_entry = sanitize_text_field($_POST['cubilis-fastbooker-icons']);
  
  if (isset($CubilisFastbooker_lanugage_entry) && $CubilisFastbooker_lanugage_entry != "") {
    if ( ! array_key_exists($CubilisFastbooker_lanugage_entry, $CubilisFastbooker_languages)) {
      $CubilisFastbooker_icons_entry = "en";
    }
  } else {
    $CubilisFastbooker_icons_entry = "en";
  }

  if (isset($CubilisFastbooker_active_entry) and $CubilisFastbooker_active_entry != "") {
    $CubilisFastbooker_active_entry = true;
  } else {
    $CubilisFastbooker_active_entry = false;
  }

  if (isset($CubilisFastbooker_discount_entry) and $CubilisFastbooker_discount_entry != "") {
    $CubilisFastbooker_discount_entry = true;
  } else {
    $CubilisFastbooker_discount_entry = false;
  }

  if (isset($CubilisFastbooker_generalAvailability_entry) and $CubilisFastbooker_generalAvailability_entry != "") {
    $CubilisFastbooker_generalAvailability_entry = true;
  } else {
    $CubilisFastbooker_generalAvailability_entry = false;
  }

  if (isset($CubilisFastbooker_icons_entry) and $CubilisFastbooker_icons_entry != "") {
    $CubilisFastbooker_icons_entry = true;
  } else {
    $CubilisFastbooker_icons_entry = false;
  }

  update_option('cubilis_fastbooker_active', $CubilisFastbooker_active_entry);
  update_option('cubilis_fastbooker_identifier', $CubilisFastbooker_identifier_entry);
  update_option('cubilis_fastbooker_lang', $CubilisFastbooker_lanugage_entry);
  update_option('cubilis_fastbooker_discount', $CubilisFastbooker_discount_entry);
  update_option('cubilis_fastbooker_general_overview', $CubilisFastbooker_generalAvailability_entry);
  update_option('cubilis_fastbooker_icons', $CubilisFastbooker_icons_entry);

?>

<div class="updated"><p><strong><?php _e('Your changes have been saved.', 'cubilis-fastbooker' ); ?></strong></p></div>

<?php

}

// Get setting values
$CubilisFastbooker_active = get_option('cubilis_fastbooker_active');
$CubilisFastbooker_identifier = get_option('cubilis_fastbooker_identifier');
$CubilisFastbooker_lanugage = get_option('cubilis_fastbooker_lang');
$CubilisFastbooker_discount = get_option('cubilis_fastbooker_discount');
$CubilisFastbooker_generalAvailability = get_option('cubilis_fastbooker_general_overview');
$CubilisFastbooker_icons = get_option('cubilis_fastbooker_icons');

?>

<div class="wrap cubilis">
	<h1><?php _e( 'Cubilis Fastbooker Settings', 'cubilis-fastbooker' ) ?></h1>

	<article class="message">
		<p class="message__large"><b><?php _e( 'Fill in the settings below to configure the Cubilis Fastbooker', 'cubilis-fastbooker' ) ?></b></p>
		<p><?php _e( '<b>Need help?</b> One of the <a href="https://www.stardekk.com/en/">Stardekk</a> employees will kindly assist you in configuring your fastbooker.', 'cubilis-fastbooker' ) ?></p>
	</article>

  <form method="post" action="<?php echo str_replace( '%7E', '~', $_SERVER['REQUEST_URI']); ?>">
    <input type="hidden" name="cubilis-fastbooker-nonce" value="<?php echo wp_create_nonce('cubilis_fastbooker_nonce') ?>">
    <table class="form-table">
      <tbody>
        <tr>
          <th scope="row"><?php _e('Active', 'cubilis-fastbooker') ?></th>
          <td>
            <input name="cubilis-fastbooker-active" id="cubilis-fastbooker-active" type="checkbox" <?php if ($CubilisFastbooker_active): ?>checked="checked"<?php endif; ?> value="1">
            <p class="description"><?php _e('Enable/Disable all fastbookers', 'cubilis-fastbooker') ?></p>
          </td>
        </tr>
        <tr>
          <th scope="row"><?php _e('Cubilis identifier', 'cubilis-fastbooker') ?></th>
          <td>
            <input class="regular-text" name="cubilis-fastbooker-identifier" id="cubilis-fastbooker-identifier" type="text" value="<?php echo esc_attr($CubilisFastbooker_identifier) ?>">
            <p class="description"><?php _e('Not sure where to find? Ask an <a href="https://www.stardekk.com/en/">Stardekk</a> employee', 'cubilis-fastbooker') ?></p>
          </td>
        </tr>
        <tr>
          <th scope="row"><?php _e('Default language', 'cubilis-fastbooker') ?></th>
          <td>
            <select class="regular-text" name="cubilis-fastbooker-language" id="cubilis-fastbooker-language">
              <?php foreach($CubilisFastbooker_languages as $key => $lang): ?>
                <option value="<?php echo esc_attr($key); ?>" <?php if($key === $CubilisFastbooker_lanugage): ?>selected="selected"<?php endif; ?>>
                  <?php echo esc_html($lang); ?>
                </option>
              <?php endforeach; ?>
            </select>
            <p class="description"><?php _e('The default language will be used when a language is not supported by the fastbooker', 'cubilis-fastbooker') ?></p>
          </td>
        </tr>
        <tr>
          <th scope="row"><?php _e('Discount', 'cubilis-fastbooker') ?></th>
          <td>
            <input name="cubilis-fastbooker-discount" id="cubilis-fastbooker-discount" type="checkbox" <?php if ($CubilisFastbooker_discount): ?>checked="checked"<?php endif; ?> value="1">
            <p class="description"><?php _e('Enable/Disable discount code', 'cubilis-fastbooker') ?></p>
          </td>
        </tr>
        <tr>
          <th scope="row"><?php _e('General Availability', 'cubilis-fastbooker') ?></th>
          <td>
            <input name="cubilis-fastbooker-general-availability" id="cubilis-fastbooker-general-availability" type="checkbox" <?php if ($CubilisFastbooker_generalAvailability): ?>checked="checked"<?php endif; ?> value="1">
            <p class="description"><?php _e('Enable/Disable general availability link', 'cubilis-fastbooker') ?></p>
          </td>
        </tr>
        <tr>
          <th scope="row"><?php _e('Icons', 'cubilis-fastbooker') ?></th>
          <td>
            <input name="cubilis-fastbooker-icons" id="cubilis-fastbooker-icons" type="checkbox" <?php if ($CubilisFastbooker_icons): ?>checked="checked"<?php endif; ?> value="1">
            <p class="description"><?php _e('Enable/Disable icons', 'cubilis-fastbooker') ?></p>
          </td>
        </tr>
      </tbody>
    </table>
    <p class="submit"><input type="submit" name="cubilis-fastbooker-submit" id="cubilis-fastbooker-submit" class="button button-primary" value="<?php _e( 'Save Changes', 'cubilis-fastbooker') ?>"></p>
	</form>
</div>