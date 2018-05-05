<?php


$fields = array(
	'general' => array(
		array(
			'title'  => __( 'WordPress Optimisation', 'sb-pack' ),
			'type'   => 'field-group',
			'fields' => array(
				array(
					'id'          => 'query_strings',
					'label'       => __( 'Remove query strings from scripts', 'sb-pack' ),
					'description' => __( 'When turned ON, query strings will be removed from script URLs.', 'sb-pack' ),
					'tooltip'     => __( 'This option move all scripts to the footer while keeping stylesheets in the header to improve page loading speed and get a higher score on the major speed testing sites such as GTmetrix or other website speed testing tools.', 'sb-pack' ),
					'type'        => 'checkbox',
					'separator'   => true,
				),

				array(
					'id'          => 'font_awesome',
					'label'       => __( 'Removes extra Font Awesome styles', 'sb-pack' ),
					'description' => __( 'When turned ON, all extra Font Awesome styles will be removed.', 'sb-pack' ),
					'tooltip'     => __( 'Use this option only if your theme uses Font Awesome, to prevent other plugins that uses Font Awesome, to add their stylesheets to your theme. In other words, this option removes extra Font Awesome stylesheets added to your theme by certain plugins.', 'sb-pack' ),
					'type'        => 'checkbox',
					'separator'   => true,
				),

				array(
					'label'     => __( 'Requests', 'sb-pack' ),
					'type'      => 'slide-up-group',
					'id'        => 'remove_wp_bloat_requests',
					'separator' => true,
					'fields'    => array(

						array(
							'id'        => 'disable_embeds',
							'label'     => __( 'Disable WordPress oEmbed script', 'sb-pack' ),
							'type'      => 'checkbox',
							'separator' => true,
						),

						array(
							'id'        => 'disable_gmaps',
							'label'     => __( 'Disable Google Maps Scripts', 'sb-pack' ),
							'type'      => 'checkbox',
							'separator' => true,
						),

						array(
							'id'        => 'remove_jquery_migrate',
							'label'     => __( 'Disable Google Maps Scripts', 'sb-pack' ),
							'type'      => 'checkbox',
							'separator' => true,
						),


						array(
							'id'        => 'disable_referral_spam',
							'label'     => __( 'Disable Referral Spam', 'sb-pack' ),
							'type'      => 'checkbox',
							'separator' => true,
						),


						array(
							'id'        => 'disable_password_meter',
							'label'     => __( 'Disable WordPress password strength meter js on non related pages', 'sb-pack' ),
							'type'      => 'checkbox',
							'separator' => true,
						),


						array(
							'id'        => 'disable_dashicons',
							'label'     => __( 'Disable Dashicons when user disables admin toolbar when viewing site', 'sb-pack' ),
							'type'      => 'checkbox',
							'separator' => true,
						),


						array(
							'id'          => 'remove_emojis',
							'label'       => __( 'Disable WordPress Emoji scripts', 'sb-pack' ),
							'description' => __( 'WordPress Emojis were introduced with WordPress 4.4', 'sb-pack' ),
							'tooltip'     => __( 'Emojis are fun and all, but if you are aren’t using them they actually load a JavaScript file (wp-emoji-release.min.js) on every page of your website. For a lot of businesses, this is not needed and simply adds load time to your site. So we recommend disabling this.', 'sb-pack' ),
							'type'        => 'checkbox',
							'separator'   => true,
						),


					),
				),
				array(
					'label'  => __( 'Tags', 'sb-pack' ),
					'type'   => 'slide-up-group',
					'id'     => 'remove_wp_bloat_tags',
					'fields' => array(

						array(
							'id'    => 'remove_wsl',
							'label' => __( 'Remove WordPress shortlink', 'sb-pack' ),
							'type'  => 'checkbox',

						),

						array(
							'id'    => 'wp_generator',
							'label' => __( 'Remove WordPress version', 'sb-pack' ),
							'type'  => 'checkbox',

						),
						array(
							'id'    => 'rsd_link',
							'label' => __( 'Remove RSD(Really Simple Discovery) Link', 'sb-pack' ),
							'type'  => 'checkbox',

						),
						array(
							'id'    => 'wml_link',
							'label' => __( 'Remove Windows live writer link ', 'sb-pack' ),
							'type'  => 'checkbox',

						),
						array(
							'id'    => 'remove_adjacent',
							'label' => __( 'Remove adjacent posts links', 'sb-pack' ),
							'type'  => 'checkbox',

						),
						array(
							'id'    => 'remove_wp_api',
							'label' => __( 'Remove Wordpress API from header', 'sb-pack' ),
							'type'  => 'checkbox',

						),

					),
				),
				array(
					'label'  => __( 'Admin', 'sb-pack' ),
					'type'   => 'slide-up-group',
					'id'     => 'remove_wp_bloat_admin',
					'fields' => array(

						array(
							'id'    => 'disable_autosave',
							'label' => __( 'Disable autosave', 'sb-pack' ),
							'type'  => 'checkbox',
						),


						array(
							'id'    => 'disable_admin_notices',
							'label' => __( 'Disable admin notices', 'sb-pack' ),
							'type'  => 'checkbox',
						),

						array(
							'id'    => 'disable_author_pages',
							'label' => __( 'Disable author pages', 'sb-pack' ),
							'type'  => 'checkbox',
						),

						array(
							'id'    => 'disable_wp_coments',
							'label' => __( 'Disable all comments', 'sb-pack' ),
							'type'  => 'checkbox',
						),

						array(
							'id'    => 'remove_link_from_comments',
							'label' => __( 'Remove links from comments', 'sb-pack' ),
							'type'  => 'checkbox',
						),
						array(
							'id'      => 'post_revisions_number',
							'label'   => __( 'Posts revisions number', 'sb-pack' ),
							'type'    => 'select',
							'options' => array(
								'default' => __( 'WordPress default', 'sb-pack' ),
								'0'       => 0,
								'1'       => 1,
								'2'       => 2,
								'3'       => 3,
								'4'       => 4,
								'5'       => 5,
								'10'      => 10,
								'15'      => 15,
								'20'      => 20,
								'25'      => 25,
								'30'      => 30,
							),
						),

						array(
							'id'      => 'hearbeat_frequency',
							'label'   => __( 'Heartbeat API frequency', 'sb-pack' ),
							'type'    => 'select',
							'options' => array(
								'default' => __( 'WordPress default', 'sb-pack' ),
								'15'      => 15 . __( 'seconds', 'sb-pack' ),
								'20'      => 20 . __( 'seconds', 'sb-pack' ),
								'25'      => 25 . __( 'seconds', 'sb-pack' ),
								'30'      => 30 . __( 'seconds', 'sb-pack' ),
								'35'      => 35 . __( 'seconds', 'sb-pack' ),
								'40'      => 40 . __( 'seconds', 'sb-pack' ),
								'45'      => 45 . __( 'seconds', 'sb-pack' ),
								'50'      => 50 . __( 'seconds', 'sb-pack' ),
								'55'      => 55 . __( 'seconds', 'sb-pack' ),
								'60'      => 60 . __( 'seconds', 'sb-pack' ),
							),
						),

						array(
							'id'      => 'hearbeat_locations',
							'label'   => __( 'Heartbeat API frequency', 'sb-pack' ),
							'type'    => 'select',
							'options' => array(
								'default'            => __( 'WordPress default', 'sb-pack' ),
								'disable_everywhere' => __( 'Disable everywhere', 'sb-pack' ),
								'disable_dashboard'  => __( 'Disable on Dashboard page', 'sb-pack' ),
								'allow_only_post'    => __( 'Allow only on post pages', 'sb-pack' ),
							),
						),

					),
				),
				array(
					'label'  => __( 'SEO', 'sb-pack' ),
					'type'   => 'slide-up-group',
					'id'     => 'remove_wp_bloat_seo',
					'fields' => array(

						array(
							'id'    => 'remove_yoast_comments',
							'label' => __( 'Remove Yoast SEO comment from head section', 'sb-pack' ),
							'type'  => 'checkbox',
						),
						array(
							'id'    => 'fix_yoast_breadcrumbs',
							'label' => __( 'Remove duplicate names in breadcrumbs WP SEO by Yoast', 'sb-pack' ),
							'type'  => 'checkbox',
						),


					),
				),
				array(
					'label'  => __( 'Others', 'sb-pack' ),
					'type'   => 'slide-up-group',
					'id'     => 'remove_wp_bloat_others',
					'fields' => array(

						array(
							'id'          => 'disable_xmlrpc',
							'label'       => __( 'Disable XML-RPC', 'sb-pack' ),
							'description' => __( 'XML-RPC was added in WordPress 3.5 and allows for remote connections', 'sb-pack' ),
							'tooltip'     => __( 'Unless you are using your mobile device to post to WordPress it does more bad than good. In fact, it can open your site up to a bunch of security risks. There are a few plugins that utilize this such as JetPack, but we don’t recommend using JetPack for performance reasons.', 'sb-pack' ),
							'type'        => 'checkbox',
						),

						array(
							'id'    => 'remove_all_feeds',
							'label' => __( 'Remove all rss feed links', 'sb-pack' ),
							'type'  => 'checkbox',

						),

						array(
							'id'    => 'disable_pingbacks_trackbacks',
							'label' => __( 'Disable pingbacks and trackbacks', 'sb-pack' ),
							'type'  => 'checkbox',

						),

						array(
							'id'    => 'disable_gravatars_in_comments',
							'label' => __( 'Disable Gravatars ONLY in comments', 'sb-pack' ),
							'type'  => 'checkbox',

						),
						array(
							'id'    => 'enable_spam_comments_cleaner',
							'label' => __( 'Enable spam comments cleaner', 'sb-pack' ),
							'type'  => 'checkbox',

						),


					),
				),

				array(
					'label'  => __( 'WooCommerce', 'sb-pack' ),
					'type'   => 'slide-up-group',
					'id'     => 'remove_wp_bloat_woo',
					'fields' => array(

						array(
							'id'          => 'disable_woo_scripts',
							'label'       => __( 'Disable WooCommerce CSS & JS', 'sb-pack' ),
							'description' => __( 'Disables WooCommerce scripts and styles except on product, cart, and checkout pages.', 'sb-pack' ),
							'type'        => 'checkbox',
						),

						array(
							'id'          => 'disable_woo_cart_fragments',
							'label'       => __( 'Disable Disable Cart Fragmentation', 'sb-pack' ),
							'description' => __( 'Completely disables WooCommerce cart fragmentation script.', 'sb-pack' ),
							'type'        => 'checkbox',
						),


						array(
							'id'          => 'disable_woo_status_meta_box',
							'label'       => __( 'Disable Status Meta Box', 'sb-pack' ),
							'description' => __( 'Disables WooCommerce status meta box from the WP Admin Dashboard.', 'sb-pack' ),
							'type'        => 'checkbox',
						),

						array(
							'id'          => 'disable_woo_widgets',
							'label'       => __( 'Disable WooCommerce Widgets', 'sb-pack' ),
							'description' => __( 'Disables all WooCommerce widgets.', 'sb-pack' ),
							'type'        => 'checkbox',
						),


					),
				),
				array(
					'label'  => __( 'WordPress Widgets', 'sb-pack' ),
					'type'   => 'slide-up-group',
					'id'     => 'remove_wp_bloat_widgets',
					'fields' => array(

						array(
							'id'    => 'disable_pages_widget',
							'label' => __( 'Disable the "Pages" widget', 'sb-pack' ),
							'type'  => 'checkbox',
						),

						array(
							'id'    => 'disable_calendar_widget',
							'label' => __( 'Disable the "Calendar" widget', 'sb-pack' ),
							'type'  => 'checkbox',
						),

						array(
							'id'    => 'disable_tag_cloud_widget',
							'label' => __( 'Disable the "Tag Cloud" widget', 'sb-pack' ),
							'type'  => 'checkbox',
						),

						array(
							'id'    => 'disable_archives_widget',
							'label' => __( 'Disable the "Archives" widget', 'sb-pack' ),
							'type'  => 'checkbox',
						),

						array(
							'id'    => 'disable_links_widget',
							'label' => __( 'Disable the "Links" widget', 'sb-pack' ),
							'type'  => 'checkbox',
						),

						array(
							'id'    => 'disable_meta_widget',
							'label' => __( 'Disable the "Meta" widget', 'sb-pack' ),
							'type'  => 'checkbox',
						),

						array(
							'id'    => 'disable_search_widget',
							'label' => __( 'Disable the "Search" widget', 'sb-pack' ),
							'type'  => 'checkbox',
						),

						array(
							'id'    => 'disable_text_widget',
							'label' => __( 'Disable the "Text" widget', 'sb-pack' ),
							'type'  => 'checkbox',
						),

						array(
							'id'    => 'disable_categories_widget',
							'label' => __( 'Disable the "Categories" widget', 'sb-pack' ),
							'type'  => 'checkbox',
						),

						array(
							'id'    => 'remove_recent_posts_widget',
							'label' => __( 'Disable the "Recent Posts" widget', 'sb-pack' ),
							'type'  => 'checkbox',
						),

						array(
							'id'    => 'remove_recent_comments_widget',
							'label' => __( 'Disable the "Recent Comments" widget', 'sb-pack' ),
							'type'  => 'checkbox',
						),

						array(
							'id'    => 'remove_rss_widget',
							'label' => __( 'Disable the "RSS" widget', 'sb-pack' ),
							'type'  => 'checkbox',
						),
						array(
							'id'    => 'remove_menu_widget',
							'label' => __( 'Disable the "Menu" widget', 'sb-pack' ),
							'type'  => 'checkbox',
						),


					),
				),
			),
		),
	), // end general tab
	'minify'  => array(
		array(
			'title'  => __( 'Minify Settings', 'sb-pack' ),
			'type'   => 'field-group',
			'fields' => array(
				array(
					'id'    => 'minify_html_js',
					'label' => __( 'Minify HTML and JS', 'sb-pack' ),
					'type'  => 'checkbox',
				),

				array(
					'id'    => 'sbp_css_minify',
					'label' => __( 'Minify all CSS styles', 'sb-pack' ),
					'type'  => 'checkbox',
				),

				array(
					'id'    => 'sbp_css_async',
					'label' => __( 'Load CSS asynchronously', 'sb-pack' ),
					'type'  => 'checkbox',

				),

				array(
					'id'    => 'sbp_footer_css',
					'label' => __( 'Insert all CSS styles inline to the footer', 'sb-pack' ),
					'type'  => 'checkbox',

				),

				array(
					'id'    => 'sbp_is_mobile',
					'label' => __( 'Disable all above CSS options on mobile devices', 'sb-pack' ),
					'type'  => 'checkbox',

				),
			),
		),
	),

	'database'        => array(
		array(
			'title'  => __( 'Database Optimisations', 'sb-pack' ),
			'type'   => 'field-group',
			'fields' => array(
				array(
					'id'    => 'clean_draft_posts',
					'label' => __( 'Clean draft posts', 'sb-pack' ),
					'type'  => 'checkbox',
				),

				array(
					'id'    => 'clean_auto_draft_posts',
					'label' => __( 'Clean auto draft posts', 'sb-pack' ),
					'type'  => 'checkbox',
				),

				array(
					'id'    => 'clean_trash_posts',
					'label' => __( 'Clean trash posts', 'sb-pack' ),
					'type'  => 'checkbox',
				),

				array(
					'id'    => 'clean_post_revisions',
					'label' => __( 'Clean post revisions', 'sb-pack' ),
					'type'  => 'checkbox',
				),

				array(
					'id'    => 'clean_post_meta_data',
					'label' => __( 'Clean post meta data', 'sb-pack' ),
					'type'  => 'checkbox',
				),

				array(
					'id'    => 'clean_transient_options',
					'label' => __( 'Clean transient options', 'sb-pack' ),
					'type'  => 'checkbox',
				),

				array(
					'id'    => 'clean_trash_comments',
					'label' => __( 'Clean trash comments', 'sb-pack' ),
					'type'  => 'checkbox',
				),

				array(
					'id'    => 'clean_spam_comments',
					'label' => __( 'Clean spam comments', 'sb-pack' ),
					'type'  => 'checkbox',
				),
			),
		),


	),
	'compress_images' => array(

		array(
			'title'  => __( 'Image Optimisation', 'sb-pack' ),
			'type'   => 'field-group',
			'fields' => array(

				array(
					'id'   => 'shortpixel_recommended',
					'type' => 'plugin-install',
				),
				array(
					'id'      => 'image_compression',
					'type'    => 'range-slider',
					'options' => array(
						'default' => __( 'WordPress default', 'sb-pack' ),
						'10'      => 10,
						'20'      => 20,
						'30'      => 30,
						'40'      => 40,
						'50'      => 50,
						'60'      => 60,
						'70'      => 70,
						'80'      => 80,
						'90'      => 90,
						'100'     => 100,
					),
				),


			),
		),

		array(
			'title'  => __( 'LazyLoad', 'sb-pack' ),
			'type'   => 'field-group',
			'fields' => array(

				array(
					'id'        => 'lazy_load',
					'label'     => __( 'Lazy load images to improve speed', 'sb-pack' ),
					'type'      => 'checkbox',
					'separator' => true,
				),

				array(
					'id'        => 'lazy_load_iframes',
					'label'     => __( 'Lazy load iframes to improve speed', 'sb-pack' ),
					'type'      => 'checkbox',
					'separator' => true,
				),

				array(
					'id'        => 'lazy_load_after_onload',
					'label'     => __( 'LazyLoad after onLoad() event', 'sb-pack' ),
					'type'      => 'checkbox',
					'separator' => true,
				),

			),
		),


	),

	'advanced' => array(


		array(
			'id'    => 'jquery_to_footer',
			'label' => __( 'Move JS scripts to the footer', 'sb-pack' ),
			'type'  => 'text',
			'group' => 'sbp_settings',
		),


		array(
			'id'    => 'defer_parsing',
			'label' => __( 'Defer parsing of javascript files', 'sb-pack' ),
			'type'  => 'text',
			'group' => 'sbp_settings',
		),
	),
);


$init = new EPFW_Settings_Page( $fields );