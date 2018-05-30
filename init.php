<?php

	$epfw_fields['general'] = array(
		'tab'    => __( 'General', 'epfw' ),
		'title'  => __( 'WordPress Optimisation', 'epfw' ),
		'fields' => array(
			'query_strings' => array(
				'label'       => __( 'Remove query strings from scripts', 'epfw' ),
				'description' => __( 'When turned ON, query strings will be removed from script URLs.', 'epfw' ),
				'tooltip'     => __( 'This option move all scripts to the footer while keeping stylesheets in the header to improve page loading speed and get a higher score on the major speed testing sites such as GTmetrix or other website speed testing tools.', 'epfw' ),
				'type'        => 'checkbox',
				'separator'   => true,
			),

			'font_awesome'  => array(
				'label'       => __( 'Removes extra Font Awesome styles', 'epfw' ),
				'description' => __( 'When turned ON, all extra Font Awesome styles will be removed.', 'epfw' ),
				'tooltip'     => __( 'Use this option only if your theme uses Font Awesome, to prevent other plugins that uses Font Awesome, to add their stylesheets to your theme. In other words, this option removes extra Font Awesome stylesheets added to your theme by certain plugins.', 'epfw' ),
				'type'        => 'checkbox',
				'separator'   => true,
			),

			/*
			array(
				'label'     => __( 'Requests', 'epfw' ),
				'type'      => 'slide-up-group',
				'id'        => 'remove_wp_bloat_requests',
				'separator' => true,
				'fields'    => array(

					array(
						'id'        => 'disable_embeds',
						'label'     => __( 'Disable WordPress oEmbed script', 'epfw' ),
						'type'      => 'checkbox',
						'separator' => true,
					),

					array(
						'id'        => 'disable_gmaps',
						'label'     => __( 'Disable Google Maps Scripts', 'epfw' ),
						'type'      => 'checkbox',
						'separator' => true,
					),

					array(
						'id'        => 'remove_jquery_migrate',
						'label'     => __( 'Disable Google Maps Scripts', 'epfw' ),
						'type'      => 'checkbox',
						'separator' => true,
					),


					array(
						'id'        => 'disable_referral_spam',
						'label'     => __( 'Disable Referral Spam', 'epfw' ),
						'type'      => 'checkbox',
						'separator' => true,
					),


					array(
						'id'        => 'disable_password_meter',
						'label'     => __( 'Disable WordPress password strength meter js on non related pages', 'epfw' ),
						'type'      => 'checkbox',
						'separator' => true,
					),


					array(
						'id'        => 'disable_dashicons',
						'label'     => __( 'Disable Dashicons when user disables admin toolbar when viewing site', 'epfw' ),
						'type'      => 'checkbox',
						'separator' => true,
					),


					array(
						'id'          => 'remove_emojis',
						'label'       => __( 'Disable WordPress Emoji scripts', 'epfw' ),
						'description' => __( 'WordPress Emojis were introduced with WordPress 4.4', 'epfw' ),
						'tooltip'     => __( 'Emojis are fun and all, but if you are aren’t using them they actually load a JavaScript file (wp-emoji-release.min.js) on every page of your website. For a lot of businesses, this is not needed and simply adds load time to your site. So we recommend disabling this.', 'epfw' ),
						'type'        => 'checkbox',
						'separator'   => true,
					),
				),
			),

			array(
				'label'  => __( 'Tags', 'epfw' ),
				'type'   => 'slide-up-group',
				'id'     => 'remove_wp_bloat_tags',
				'fields' => array(

					array(
						'id'    => 'remove_wsl',
						'label' => __( 'Remove WordPress shortlink', 'epfw' ),
						'type'  => 'checkbox',

					),

					array(
						'id'    => 'wp_generator',
						'label' => __( 'Remove WordPress version', 'epfw' ),
						'type'  => 'checkbox',

					),
					array(
						'id'    => 'rsd_link',
						'label' => __( 'Remove RSD(Really Simple Discovery) Link', 'epfw' ),
						'type'  => 'checkbox',

					),
					array(
						'id'    => 'wml_link',
						'label' => __( 'Remove Windows live writer link ', 'epfw' ),
						'type'  => 'checkbox',

					),
					array(
						'id'    => 'remove_adjacent',
						'label' => __( 'Remove adjacent posts links', 'epfw' ),
						'type'  => 'checkbox',

					),
					array(
						'id'    => 'remove_wp_api',
						'label' => __( 'Remove Wordpress API from header', 'epfw' ),
						'type'  => 'checkbox',

					),

				),
			),

			array(
				'label'  => __( 'Admin', 'epfw' ),
				'type'   => 'slide-up-group',
				'id'     => 'remove_wp_bloat_admin',
				'fields' => array(

					array(
						'id'    => 'disable_autosave',
						'label' => __( 'Disable autosave', 'epfw' ),
						'type'  => 'checkbox',
					),


					array(
						'id'    => 'disable_admin_notices',
						'label' => __( 'Disable admin notices', 'epfw' ),
						'type'  => 'checkbox',
					),

					array(
						'id'    => 'disable_author_pages',
						'label' => __( 'Disable author pages', 'epfw' ),
						'type'  => 'checkbox',
					),

					array(
						'id'    => 'disable_wp_coments',
						'label' => __( 'Disable all comments', 'epfw' ),
						'type'  => 'checkbox',
					),

					array(
						'id'    => 'remove_link_from_comments',
						'label' => __( 'Remove links from comments', 'epfw' ),
						'type'  => 'checkbox',
					),
					array(
						'id'      => 'post_revisions_number',
						'label'   => __( 'Posts revisions number', 'epfw' ),
						'type'    => 'select',
						'options' => array(
							'default' => __( 'WordPress default', 'epfw' ),
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
						'label'   => __( 'Heartbeat API frequency', 'epfw' ),
						'type'    => 'select',
						'options' => array(
							'default' => __( 'WordPress default', 'epfw' ),
							'15'      => 15 . __( 'seconds', 'epfw' ),
							'20'      => 20 . __( 'seconds', 'epfw' ),
							'25'      => 25 . __( 'seconds', 'epfw' ),
							'30'      => 30 . __( 'seconds', 'epfw' ),
							'35'      => 35 . __( 'seconds', 'epfw' ),
							'40'      => 40 . __( 'seconds', 'epfw' ),
							'45'      => 45 . __( 'seconds', 'epfw' ),
							'50'      => 50 . __( 'seconds', 'epfw' ),
							'55'      => 55 . __( 'seconds', 'epfw' ),
							'60'      => 60 . __( 'seconds', 'epfw' ),
						),
					),

					array(
						'id'      => 'hearbeat_locations',
						'label'   => __( 'Heartbeat API frequency', 'epfw' ),
						'type'    => 'select',
						'options' => array(
							'default'            => __( 'WordPress default', 'epfw' ),
							'disable_everywhere' => __( 'Disable everywhere', 'epfw' ),
							'disable_dashboard'  => __( 'Disable on Dashboard page', 'epfw' ),
							'allow_only_post'    => __( 'Allow only on post pages', 'epfw' ),
						),
					),

				),
			),

			array(
				'label'  => __( 'SEO', 'epfw' ),
				'type'   => 'slide-up-group',
				'id'     => 'remove_wp_bloat_seo',
				'fields' => array(

					array(
						'id'    => 'remove_yoast_comments',
						'label' => __( 'Remove Yoast SEO comment from head section', 'epfw' ),
						'type'  => 'checkbox',
					),
					array(
						'id'    => 'fix_yoast_breadcrumbs',
						'label' => __( 'Remove duplicate names in breadcrumbs WP SEO by Yoast', 'epfw' ),
						'type'  => 'checkbox',
					),


				),
			),

			array(
				'label'  => __( 'Others', 'epfw' ),
				'type'   => 'slide-up-group',
				'id'     => 'remove_wp_bloat_others',
				'fields' => array(

					array(
						'id'          => 'disable_xmlrpc',
						'label'       => __( 'Disable XML-RPC', 'epfw' ),
						'description' => __( 'XML-RPC was added in WordPress 3.5 and allows for remote connections', 'epfw' ),
						'tooltip'     => __( 'Unless you are using your mobile device to post to WordPress it does more bad than good. In fact, it can open your site up to a bunch of security risks. There are a few plugins that utilize this such as JetPack, but we don’t recommend using JetPack for performance reasons.', 'epfw' ),
						'type'        => 'checkbox',
					),

					array(
						'id'    => 'remove_all_feeds',
						'label' => __( 'Remove all rss feed links', 'epfw' ),
						'type'  => 'checkbox',

					),

					array(
						'id'    => 'disable_pingbacks_trackbacks',
						'label' => __( 'Disable pingbacks and trackbacks', 'epfw' ),
						'type'  => 'checkbox',

					),

					array(
						'id'    => 'disable_gravatars_in_comments',
						'label' => __( 'Disable Gravatars ONLY in comments', 'epfw' ),
						'type'  => 'checkbox',

					),
					array(
						'id'    => 'enable_spam_comments_cleaner',
						'label' => __( 'Enable spam comments cleaner', 'epfw' ),
						'type'  => 'checkbox',

					),


				),
			),

			array(
				'label'  => __( 'WooCommerce', 'epfw' ),
				'type'   => 'slide-up-group',
				'id'     => 'remove_wp_bloat_woo',
				'fields' => array(

					array(
						'id'          => 'disable_woo_scripts',
						'label'       => __( 'Disable WooCommerce CSS & JS', 'epfw' ),
						'description' => __( 'Disables WooCommerce scripts and styles except on product, cart, and checkout pages.', 'epfw' ),
						'type'        => 'checkbox',
					),

					array(
						'id'          => 'disable_woo_cart_fragments',
						'label'       => __( 'Disable Disable Cart Fragmentation', 'epfw' ),
						'description' => __( 'Completely disables WooCommerce cart fragmentation script.', 'epfw' ),
						'type'        => 'checkbox',
					),


					array(
						'id'          => 'disable_woo_status_meta_box',
						'label'       => __( 'Disable Status Meta Box', 'epfw' ),
						'description' => __( 'Disables WooCommerce status meta box from the WP Admin Dashboard.', 'epfw' ),
						'type'        => 'checkbox',
					),

					array(
						'id'          => 'disable_woo_widgets',
						'label'       => __( 'Disable WooCommerce Widgets', 'epfw' ),
						'description' => __( 'Disables all WooCommerce widgets.', 'epfw' ),
						'type'        => 'checkbox',
					),


				),
			),

			array(
				'label'  => __( 'WordPress Widgets', 'epfw' ),
				'type'   => 'slide-up-group',
				'id'     => 'remove_wp_bloat_widgets',
				'fields' => array(

					array(
						'id'    => 'disable_pages_widget',
						'label' => __( 'Disable the "Pages" widget', 'epfw' ),
						'type'  => 'checkbox',
					),

					array(
						'id'    => 'disable_calendar_widget',
						'label' => __( 'Disable the "Calendar" widget', 'epfw' ),
						'type'  => 'checkbox',
					),

					array(
						'id'    => 'disable_tag_cloud_widget',
						'label' => __( 'Disable the "Tag Cloud" widget', 'epfw' ),
						'type'  => 'checkbox',
					),

					array(
						'id'    => 'disable_archives_widget',
						'label' => __( 'Disable the "Archives" widget', 'epfw' ),
						'type'  => 'checkbox',
					),

					array(
						'id'    => 'disable_links_widget',
						'label' => __( 'Disable the "Links" widget', 'epfw' ),
						'type'  => 'checkbox',
					),

					array(
						'id'    => 'disable_meta_widget',
						'label' => __( 'Disable the "Meta" widget', 'epfw' ),
						'type'  => 'checkbox',
					),

					array(
						'id'    => 'disable_search_widget',
						'label' => __( 'Disable the "Search" widget', 'epfw' ),
						'type'  => 'checkbox',
					),

					array(
						'id'    => 'disable_text_widget',
						'label' => __( 'Disable the "Text" widget', 'epfw' ),
						'type'  => 'checkbox',
					),

					array(
						'id'    => 'disable_categories_widget',
						'label' => __( 'Disable the "Categories" widget', 'epfw' ),
						'type'  => 'checkbox',
					),

					array(
						'id'    => 'remove_recent_posts_widget',
						'label' => __( 'Disable the "Recent Posts" widget', 'epfw' ),
						'type'  => 'checkbox',
					),

					array(
						'id'    => 'remove_recent_comments_widget',
						'label' => __( 'Disable the "Recent Comments" widget', 'epfw' ),
						'type'  => 'checkbox',
					),

					array(
						'id'    => 'remove_rss_widget',
						'label' => __( 'Disable the "RSS" widget', 'epfw' ),
						'type'  => 'checkbox',
					),
					array(
						'id'    => 'remove_menu_widget',
						'label' => __( 'Disable the "Menu" widget', 'epfw' ),
						'type'  => 'checkbox',
					),


				),
			),
			*/
		),
	); // end general


	$epfw_menu_args = array(
		'page_title' => __( 'Welcome to EPFW', 'epfw' ),
		'menu_title' => __( 'Testing', 'epfw' ),
		'cap'        => 'manage_options',
		'slug'       => 'sbp_options',
	);


		$init = new EPFW_Plugin_Admin_Page( $epfw_fields, $epfw_menu_args );
