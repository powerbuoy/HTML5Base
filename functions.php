<?php
########
# Vendor
require __DIR__ . '/vendor/autoload.php';

###################
# Load translations
load_theme_textdomain('sleek', get_template_directory() . '/dist');

###############
# Theme support
add_theme_support('sleek-classic-editor');
add_theme_support('sleek-jquery-cdn');
add_theme_support('sleek-disable-jquery');
add_theme_support('sleek-disable-404-guessing');
add_theme_support('sleek-nice-email-from');
add_theme_support('sleek-comment-form-placeholders');
add_theme_support('sleek-tinymce-clean-paste');
add_theme_support('sleek-tinymce-no-colors');
add_theme_support('sleek-archive-meta');
add_theme_support('sleek-outdated-browser-warning');
add_theme_support('sleek-hide-acf-admin');
add_theme_support('sleek-disable-theme-editor');
# add_theme_support('sleek-notice');
# add_theme_support('sleek-oembed');
# add_theme_support('sleek-acf-redirect-url')
# add_theme_support('sleek-disable-comments');
# add_theme_support('sleek-cookie-consent');
# add_theme_support('sleek-archive-filter');
# add_theme_support('sleek-get-terms-post-type-arg');
# add_theme_support('sleek-require-login');

########
# Assets
/* add_action('wp_enqueue_scripts', function () {
	wp_enqueue_script('vue', 'https://cdn.jsdelivr.net/npm/vue@2.6.10', [], null, true);
}); */

#############
# Image sizes
Sleek\ImageSizes\register(1920, 1080, ['center', 'center']/*, [
	'portrait' => ['width' => 1080, 'height' => 1920, 'crop' => ['center', 'top']],
	'square' => ['width' => 1920, 'height' => 1920],
]*/);

##################
# Sidebars & menus
# register_sidebar(['name' => __('Header', 'sleek'), 'id' => 'header']);
# register_sidebar(['name' => __('Footer', 'sleek'), 'id' => 'footer']);
# register_sidebar(['name' => __('Sidebar', 'sleek'), 'id' => 'sidebar']);

register_nav_menus([
	'header_menu' => __('Header menu', 'sleek'),
	'footer_menu' => __('Footer menu', 'sleek')
]);

################
# Sleek settings
/* add_action('admin_init', function () {
	Sleek\Settings\add_setting('hubspot_portal_id', 'text', __('Hubspot Portal ID', 'sleek'));
	Sleek\Settings\add_setting('hubspot_api_key', 'text', __('Hubspot API Key', 'sleek'));
});

# ... use them
add_action('wp_head', function () {
	if ($portalId = Sleek\Settings\get_setting('hubspot_portal_id')) {
		echo '<script type="text/javascript" id="hs-script-loader" async defer src="//js.hs-scripts.com/' . $portalId . '.js"></script>';
	}
}); */

############
# ACF fields
add_action('acf/init', function () {
	# Site Settings
/*	acf_add_options_page([
		'page_title' => __('Site Settings', 'sleek'),
		'menu_slug' => 'site_settings',
		'post_id' => 'site_settings'
	]); */

	# Site Setting fields
/*	acf_add_local_field_group([
		'key' => 'site_settings',
		'title' => __('Site Settings', 'sleek'),
		'location' => [[['param' => 'options_page', 'operator' => '==', 'value' => 'site_settings']]],
		'menu_order' => 0,
		'fields' => [
			[
				'key' => 'site_settings_message',
				'name' => 'message',
				'type' => 'message',
				'label' => __('Nothing here', 'sleek'),
				'message' => __('Nothing here yet.', 'sleek')
			]
		]
	]); */

	# Sidebar modules
/*	acf_add_local_field_group([
		'key' => 'group_sidebar_modules',
		'title' => __('Sidebar Modules', 'sleek'),
		'location' => [[['param' => 'options_page', 'operator' => '==', 'value' => 'site_settings']]],
		'menu_order' => 1,
		'fields' => [
			[
				'key' => 'sidebar_modules',
				'name' => 'sidebar_modules',
				'type' => 'flexible_content',
				'label' => __('Nothing here', 'sleek'),
				'button_label' => __('Add a module', 'sleek'),
				'layouts' => Sleek\Acf\generate_keys(Sleek\Modules\get_module_fields([
					'text-block'
				], 'flexible'), 'sidebar_modules')
			]
		]
	]); */
});
