<?php
$stringUri = $_SERVER['REQUEST_URI'];
$arrayUri = explode('/', $stringUri);

add_action('init', 'portfolioInit');
add_action('after_setup_theme', 'portfolioSetupTheme');
add_action('wp_enqueue_scripts', 'portfolioScripts');
add_action('customize_register', 'portfolioCustomizeRegister');

add_filter( 'nav_menu_css_class', 'portfolioNavMenuCssClass', 10 ,4);
add_filter( 'nav_menu_link_attributes', 'portfolioNavMenuLinkAttributesFilter', 10, 4 );
add_filter( 'get_custom_logo_image_attributes', 'portfolioGetCustomLogoImageAttributesFilter', 10, 3 );

function portfolioInit() : void {
	register_post_type( 'service-cards', [
		'label'  => 'service-card',
		'labels' => [
			'name'               => 'service-cards',
			'singular_name'      => 'service',
			'add_new'            => 'add',
			'add_new_item'       => 'addition',
			'edit_item'          => 'edit',
			'new_item'           => 'new', // текст новой записи
			'view_item'          => 'view', // для просмотра записи этого типа.
			'search_items'       => 'search', // для поиска по этим типам записи
			'not_found'          => 'not found', // если в результате поиска ничего не было найдено
			'not_found_in_trash' => 'not found in trash', // если не было найдено в корзине
			'menu_name'          => 'Services', // название меню
		],
		'public'                 => true,
		 'show_in_rest'         => true,
		 'show_ui'             => true, // зависит от public
		'show_in_menu'           => true,
		 'show_in_admin_bar'   => true,
		'hierarchical'        => false,
		'supports'            => [ 'title', 'editor', 'thumbnail' , 'post-formats' ], // 'title','editor','author','thumbnail','excerpt','trackbacks','custom-fields','comments','revisions','page-attributes','post-formats'
		'taxonomies'          => [],
		'has_archive'         => false,
		'rewrite'             => true,
		'query_var'           => true,
	] );

	register_post_type( 'experience-cards', [
		'label'  => 'experience-card',
		'labels' => [
			'name'               => 'experience-cards',
			'singular_name'      => 'experience',
			'add_new'            => 'add',
			'add_new_item'       => 'addition',
			'edit_item'          => 'edit',
			'new_item'           => 'new',
			'view_item'          => 'view',
			'search_items'       => 'search',
			'not_found'          => 'not found',
			'not_found_in_trash' => 'not found in trash',
			'menu_name'          => 'Experiences',
		],
		'public'              => true,
		'show_in_rest'        => true,
		'show_ui'             => true,
		'show_in_menu'        => true,
		'show_in_admin_bar'   => true,
		'hierarchical'        => false,
		'supports'            => [ 'title', 'editor', 'thumbnail' , 'post-formats', 'custom-fields' ], // 'title','editor','author','thumbnail','excerpt','trackbacks','custom-fields','comments','revisions','page-attributes','post-formats'
		'taxonomies'          => [],
		'has_archive'         => false,
		'rewrite'             => true,
		'query_var'           => true,
	] );

	register_post_type( 'testimonial-cards', [
		'label'  => 'testimonial-card',
		'labels' => [
			'name'               => 'testimonial-cards',
			'singular_name'      => 'testimonial',
			'add_new'            => 'add',
			'add_new_item'       => 'addition',
			'edit_item'          => 'edit',
			'new_item'           => 'new',
			'view_item'          => 'view',
			'search_items'       => 'search',
			'not_found'          => 'not found',
			'not_found_in_trash' => 'not found in trash',
			'menu_name'          => 'Testimonials',
		],
		'public'              => true,
		'show_in_rest'        => true,
		'show_ui'             => true,
		'show_in_menu'        => true,
		'show_in_admin_bar'   => true,
		'hierarchical'        => false,
		'supports'            => [ 'title', 'editor', 'thumbnail' , 'post-formats', 'custom-fields' ], // 'title','editor','author','thumbnail','excerpt','trackbacks','custom-fields','comments','revisions','page-attributes','post-formats'
		'taxonomies'          => [],
		'has_archive'         => false,
		'rewrite'             => true,
		'query_var'           => true,
	] );

	register_post_type( 'question-cards', [
		'label'  => 'question-card',
		'labels' => [
			'name'               => 'Question-cards',
			'singular_name'      => 'question',
			'add_new'            => 'add',
			'add_new_item'       => 'addition',
			'edit_item'          => 'edit',
			'new_item'           => 'new',
			'view_item'          => 'view',
			'search_items'       => 'search',
			'not_found'          => 'not found',
			'not_found_in_trash' => 'not found in trash',
			'menu_name'          => 'Questions',
		],
		'public'              => true,
		'show_in_rest'        => true,
		'show_ui'             => true,
		'show_in_menu'        => true,
		'show_in_admin_bar'   => true,
		'hierarchical'        => false,
		'supports'            => [ 'title', 'editor', 'post-formats' ], // 'title','editor','author','thumbnail','excerpt','trackbacks','custom-fields','comments','revisions','page-attributes','post-formats'
		'taxonomies'          => [],
		'has_archive'         => false,
		'rewrite'             => true,
		'query_var'           => true,
	] );

}

function portfolioSetupTheme() : void {
	global $arrayUri;
	add_theme_support('menus');
	add_theme_support('custom-logo', [
		'width' => 40,
		'height' => 40,
		'class' => 'logo'
	]);

	add_theme_support( 'custom-header', [
		'width'         => 980,
		'height'        => 60,
		'default-image' => ($arrayUri[2] === '') ? get_template_directory_uri() . '/assets/img/Background-home.jpg' : get_template_directory_uri() . '/assets/img/bg-other-page.jpg'
	] );

	add_theme_support( 'post-formats', array( 'aside', 'gallery' ) );
	add_theme_support( 'title-tag' );
	add_theme_support( 'post-thumbnails' );
	register_nav_menu('header', 'menu location in header');
}

function portfolioScripts() : void {
	wp_enqueue_style('pf-common', get_template_directory_uri() . '/assets/css/common.css');
	if(is_front_page()) {
		wp_enqueue_style('home', get_template_directory_uri() . '/assets/css/home.css');
		wp_enqueue_script('card-hover', get_template_directory_uri() . '/assets/js/card-hover.js', [], '1.0', ['in-footer' => true, 'strategy' => 'async']);
		wp_enqueue_script('slider-portfolio', get_template_directory_uri() . '/assets/js/slide.js', [], '1.0', ['in-footer' => true, 'strategy' => 'async']);
		wp_enqueue_script('slider-testimonial', get_template_directory_uri() . '/assets/js/testimonial-slide.js', [], '1.0', ['in-footer' => true, 'strategy' => 'async']);
		wp_enqueue_script('pf-main-form', get_template_directory_uri() . '/assets/js/main-form.js', [], '1.0', ['in-footer' => true, 'strategy' => 'async']);
	}



	if(is_page('about')) {
		wp_enqueue_style('pf-about', get_template_directory_uri() . '/assets/css/about.css');
	}
	if(is_page('service')) {
		wp_enqueue_style('pf-service', get_template_directory_uri() . '/assets/css/service.css');
		wp_enqueue_script('pf-question', get_template_directory_uri() . '/assets/js/question-hover.js', [], '1.0', ['in-footer' => true, 'strategy' => 'async']);
		wp_enqueue_script('card-hover', get_template_directory_uri() . '/assets/js/card-hover.js', [], '1.0', ['in-footer' => true, 'strategy' => 'async']);
		wp_enqueue_script('slider-testimonial', get_template_directory_uri() . '/assets/js/testimonial-slide.js', [], '1.0', ['in-footer' => true, 'strategy' => 'async']);
	}
	if(is_page('portfolio')) {
		wp_enqueue_style('pf-portfolio', get_template_directory_uri() . '/assets/css/portfolio.css');
		wp_enqueue_script('pf-question', get_template_directory_uri() . '/assets/js/question-hover.js', [], '1.0', ['in-footer' => true]);
		wp_enqueue_script('slider-portfolio', get_template_directory_uri() . '/assets/js/slide.js', [], '1.0', ['in-footer' => true, 'strategy' => 'async']);
	}
	if(is_page('contact')) {
		wp_enqueue_style('pf-contacts', get_template_directory_uri() . '/assets/css/contacts.css');
	}

	wp_enqueue_script('burger-menu', get_template_directory_uri() . '/assets/js/burger-menu.js', [], '1.0', ['in-footer' => true, 'strategy' => 'async']);
}

function portfolioNavMenuCssClass($classes, $menu_item, $args, $depth) : array {
	$classes = ['menu__item'];
	return $classes;
}

function portfolioNavMenuLinkAttributesFilter( $atts, $menu_item, $args, $depth ){
	$atts['class'] = 'menu__link ';
	if($atts['aria-current'] === 'page') {
		$atts['class'] .= 'menu__link--active';
	}
	return $atts;
}

function portfolioGetCustomLogoImageAttributesFilter($custom_logo_attr, $custom_logo_id, $blog_id) {
	$custom_logo_attr['class'] = 'logo';
	return $custom_logo_attr;
}

function portfolioCustomizeRegister($manager) : void {

	$manager->add_setting('instagram-social', [
		'default' => 'https://www.instagram.com',
		'transport' => 'refresh'
	]);

	$manager->add_setting('facebook-social', [
		'default' => 'https://www.facebook.com',
		'transport' => 'refresh'
	]);

	$manager->add_setting('linkedin-social', [
		'default' => 'https://www.linkedin.com',
		'transport' => 'refresh'
	]);

	$manager->add_setting('basket-social', [
		'default' => 'https://www.basket.com',
		'transport' => 'refresh'
	]);

	$manager->add_section('social-section', [
		'title' => 'Social Setting',
	]);

	$manager->add_control('Instagram social', [
		'label' => __( 'Instagram social', 'portfolio' ),
		'section'    => 'social-section',
		'settings'   => 'instagram-social',
		'type' => 'url'
		]);

	$manager->add_control('Facebook social', [
		'label' => __( 'Facebook social', 'portfolio' ),
		'section'    => 'social-section',
		'settings'   => 'facebook-social',
		'type' => 'url'
	]);

	$manager->add_control('Linkedin social', [
		'label' => __( 'Linkedin social', 'portfolio' ),
		'section'    => 'social-section',
		'settings'   => 'linkedin-social',
		'type' => 'url'
	]);

	$manager->add_control('Basket social', [
		'label' => __( 'Basket social', 'portfolio' ),
		'section'    => 'social-section',
		'settings'   => 'basket-social',
		'type' => 'url'
	]);

	$manager->add_setting('header-title', [
		'default' => 'robert fox',
		'transport' => 'refresh'
	]);

	$manager->add_setting('header-subtitle', [
		'default' => 'Professional Product Designer',
		'transport' => 'refresh'
	]);

	$manager->add_section('header-text', [
		'title' => 'Text header'
	]);

	$manager->add_control('Title Text', [
		'label' => __( 'Title Text', 'portfolio' ),
		'section' => 'header-text',
		'settings' => 'header-title',
		'type' => 'text'
	]);

	$manager->add_control('Sub Title Text', [
		'label' => __( 'Sub Title Text', 'portfolio' ),
		'section' => 'header-text',
		'settings' => 'header-subtitle',
		'type' => 'text'
	]);

	$manager->add_setting('about-experience', [
		'default' => '8',
		'transport' => 'refresh'
	]);

	$manager->add_setting('about-customer', [
		'default' => '25',
		'transport' => 'refresh'
	]);

	$manager->add_setting('about-description', [
		'default' => 'Amet minim mollit non deserunt ullamco est sit aliqua dolor do amet sint. Velit officia consequat duis enim velit mollit. Exercitation veniam consequat sunt nostrud amet.',
		'transport' => 'refresh'
	]);

	$manager->add_setting('about-description-secondary', [
		'default' => 'Amet minim mollit non deserunt ullamco est sit aliqua dolor do amet sint. Velit officia consequat duis enim velit mollit.',
		'transport' => 'refresh'
	]);

	$manager->add_setting('about-title', [
		'default' => "I'm Professional Designer and Front-End Web Developer That Solve Your Problems",
		'transport' => 'refresh'
	]);

	$manager->add_setting('about-img-experience', [
		'default' => "http://localhost/portfolio/wp-content/uploads/2023/08/photo-year2.png",
		'transport' => 'refresh'
	]);

	$manager->add_setting('about-img-customer', [
		'default' => "http://localhost/portfolio/wp-content/uploads/2023/08/photo-year1.png",
		'transport' => 'refresh'
	]);

	$manager->add_setting('about-img-page', [
		'default' => "http://localhost/portfolio/wp-content/uploads/2023/08/about-section-men-1-scaled.jpg",
		'transport' => 'refresh'
	]);

	$manager->add_section('about-section', [
		'title' => 'About section'
	]);

	$manager->add_control('about_experience', [
		'label' => __( 'About experience', 'portfolio' ),
		'section' => 'about-section',
		'settings' => 'about-experience',
		'type' => 'text'
	]);

	$manager->add_control('about_customers', [
		'label' => __( 'About customers', 'portfolio' ),
		'section' => 'about-section',
		'settings' => 'about-customer',
		'type' => 'text'
	]);

	$manager->add_control('about_description', [
		'label' => __( 'About description', 'portfolio' ),
		'section' => 'about-section',
		'settings' => 'about-description',
		'type' => 'text'
	]);

	$manager->add_control('about_description_secondary', [
		'label' => __( 'About description secondary', 'portfolio' ),
		'section' => 'about-section',
		'settings' => 'about-description-secondary',
		'type' => 'text'
	]);

	$manager->add_control('about_title', [
		'label' => __( 'About description secondary', 'portfolio' ),
		'section' => 'about-section',
		'settings' => 'about-title',
		'type' => 'text'
	]);

	$manager->add_control('about_img_customer', [
		'label' => __( 'About img customer', 'portfolio' ),
		'section' => 'about-section',
		'settings' => 'about-img-customer',
		'type' => 'url'
	]);

	$manager->add_control('about_img_experience', [
		'label' => __( 'About img experience', 'portfolio' ),
		'section' => 'about-section',
		'settings' => 'about-img-experience',
		'type' => 'url'
	]);

	$manager->add_control('about_img_page', [
		'label' => __( 'About img page', 'portfolio' ),
		'section' => 'about-section',
		'settings' => 'about-img-page',
		'type' => 'url'
	]);

	$manager->add_setting('contact-phone', [
		'default' => '(219) 555-0114',
		'transport' => 'refresh'
	]);

	$manager->add_setting('contact-email', [
		'default' => 'robertfox@example.com',
		'transport' => 'refresh'
	]);

	$manager->add_setting('contact-location', [
		'default' => '4517 Washington Ave. Manchester, Kentucky 39495',
		'transport' => 'refresh'
	]);

	$manager->add_section('contact-info', [
		'title' => 'Contact info'
	]);

	$manager->add_control('contact_phone', [
		'label' => __( 'Contact phone', 'portfolio' ),
		'section' => 'contact-info',
		'settings' => 'contact-phone',
		'type' => 'text'
	]);

	$manager->add_control('contact_email', [
		'label' => __( 'Contact email', 'portfolio' ),
		'section' => 'contact-info',
		'settings' => 'contact-email',
		'type' => 'text'
	]);

	$manager->add_control('contact_location', [
		'label' => __( 'Contact location', 'portfolio' ),
		'section' => 'contact-info',
		'settings' => 'contact-location',
		'type' => 'text'
	]);

	$manager->add_setting('skills-text', [
		'default' => 'Amet minim mollit non deserunt ullamco est sit aliqua dolor do amet sint. Velit officia consequat duis enim velit mollit. Exercitation veniam consequat sunt nostrud amet.',
		'transport' => 'refresh'
	]);

	$manager->add_setting('skills-first-title', [
		'default' => 'UI/UX Design',
		'transport' => 'refresh'
	]);

	$manager->add_setting('skills-first', [
		'default' => '90',
		'transport' => 'refresh'
	]);

	$manager->add_setting('skills-secondary-title', [
		'default' => 'Front End Developer',
		'transport' => 'refresh'
	]);

	$manager->add_setting('skills-secondary', [
		'default' => '95',
		'transport' => 'refresh'
	]);

	$manager->add_setting('skills-third-title', [
		'default' => 'Graphic Design',
		'transport' => 'refresh'
	]);

	$manager->add_setting('skills-third', [
		'default' => '90',
		'transport' => 'refresh'
	]);

	$manager->add_setting('skills-fourth-title', [
		'default' => 'Product Design',
		'transport' => 'refresh'
	]);

	$manager->add_setting('skills-fourth', [
		'default' => '85',
		'transport' => 'refresh'
	]);

	$manager->add_section('skills-section', [
		'title' => 'Skills section'
	]);

	$manager->add_control('skills_text', [
		'label' => __( 'Skills text', 'portfolio' ),
		'section' => 'skills-section',
		'settings' => 'skills-text',
		'type' => 'text'
	]);

	$manager->add_control('skills_first_title', [
		'label' => __( 'Skills first title', 'portfolio' ),
		'section' => 'skills-section',
		'settings' => 'skills-first-title',
		'type' => 'text'
	]);

	$manager->add_control('skills_first', [
		'label' => __( 'Skills first, %', 'portfolio' ),
		'section' => 'skills-section',
		'settings' => 'skills-first',
		'type' => 'text'
	]);



	$manager->add_control('skills_secondary_title', [
		'label' => __( 'Skills secondary title', 'portfolio' ),
		'section' => 'skills-section',
		'settings' => 'skills-secondary-title',
		'type' => 'text'
	]);

	$manager->add_control('skills_secondary', [
		'label' => __( 'Skills secondary, %', 'portfolio' ),
		'section' => 'skills-section',
		'settings' => 'skills-secondary',
		'type' => 'text'
	]);


	$manager->add_control('skills_third_title', [
		'label' => __( 'Skills third title', 'portfolio' ),
		'section' => 'skills-section',
		'settings' => 'skills-third-title',
		'type' => 'text'
	]);

	$manager->add_control('skills_third', [
		'label' => __( 'Skills third, %', 'portfolio' ),
		'section' => 'skills-section',
		'settings' => 'skills-third',
		'type' => 'text'
	]);





	$manager->add_control('skills_fourth_title', [
		'label' => __( 'Skills  title', 'portfolio' ),
		'section' => 'skills-section',
		'settings' => 'skills-fourth-title',
		'type' => 'text'
	]);

	$manager->add_control('skills_fourth', [
		'label' => __( 'Skills fourth, %', 'portfolio' ),
		'section' => 'skills-section',
		'settings' => 'skills-fourth',
		'type' => 'text'
	]);


	$manager->add_setting('footer-text', [
		'default' => "Copyright Shuly 2022 All Right Reserved",
		'transport' => 'refresh'
	]);

	$manager->add_section('footer-section', [
		'title' => 'Footer text'
	]);

	$manager->add_control('footer_text', [
		'label' => __( 'Footer text', 'portfolio' ),
		'section' => 'footer-section',
		'settings' => 'footer-text',
		'type' => 'text'
	]);

}

function portfolioRenderingSocial(string $classUl, string $color) : string {
	$instagram = get_theme_mod('instagram-social');
	$facebook = get_theme_mod('facebook-social');
	$linkedin = get_theme_mod('linkedin-social');
	$basket = get_theme_mod('basket-social');
	$html = '<ul class="' . $classUl . '">';
	if(get_theme_mod('instagram-social') != '') {
;
		$html .= '<li class="social-media__list"><a href="' . $instagram . '">
<svg class="social-media__svg" width="42" height="42"fill="none" xmlns="http://www.w3.org/2000/svg">
				<circle cx="21" cy="21" r="21" fill="white" fill-opacity="0.1" />
				<path
					d="M21.199 16.8854C20.0544 16.8854 18.9567 17.3401 18.1474 18.1494C17.338 18.9588 16.8833 20.0565 16.8833 21.2011C16.8833 22.3457 17.338 23.4434 18.1474 24.2528C18.9567 25.0622 20.0544 25.5168 21.199 25.5168C22.3436 25.5168 23.4414 25.0622 24.2507 24.2528C25.0601 23.4434 25.5148 22.3457 25.5148 21.2011C25.5148 20.0565 25.0601 18.9588 24.2507 18.1494C23.4414 17.3401 22.3436 16.8854 21.199 16.8854ZM21.199 24.0039C20.4554 24.0039 19.7423 23.7085 19.2165 23.1827C18.6907 22.6569 18.3953 21.9438 18.3953 21.2002C18.3953 20.4566 18.6907 19.7434 19.2165 19.2176C19.7423 18.6918 20.4554 18.3964 21.199 18.3964C21.9426 18.3964 22.6558 18.6918 23.1816 19.2176C23.7074 19.7434 24.0028 20.4566 24.0028 21.2002C24.0028 21.9438 23.7074 22.6569 23.1816 23.1827C22.6558 23.7085 21.9426 24.0039 21.199 24.0039Z"
					fill="' . $color . '" />
				<path
					d="M25.6856 17.7327C26.2413 17.7327 26.6918 17.2823 26.6918 16.7266C26.6918 16.1709 26.2413 15.7205 25.6856 15.7205C25.13 15.7205 24.6795 16.1709 24.6795 16.7266C24.6795 17.2823 25.13 17.7327 25.6856 17.7327Z"
					fill="' . $color . '" />
				<path
					d="M29.1641 15.7037C28.948 15.1458 28.6178 14.6391 28.1947 14.2161C27.7715 13.7931 27.2647 13.4631 26.7066 13.2472C26.0536 13.0021 25.3637 12.8695 24.6664 12.8552C23.7676 12.816 23.4829 12.8048 21.2037 12.8048C18.9245 12.8048 18.6324 12.8048 17.741 12.8552C17.0442 12.8688 16.3548 13.0014 15.7026 13.2472C15.1444 13.4628 14.6375 13.7927 14.2143 14.2158C13.7911 14.6388 13.461 15.1456 13.2452 15.7037C13 16.3567 12.8677 17.0467 12.8541 17.744C12.814 18.6419 12.8018 18.9265 12.8018 21.2067C12.8018 23.4859 12.8018 23.7761 12.8541 24.6693C12.8681 25.3675 12.9997 26.0563 13.2452 26.7105C13.4616 27.2685 13.792 27.7751 14.2153 28.1981C14.6386 28.621 15.1455 28.9511 15.7036 29.1671C16.3545 29.4221 17.0442 29.5641 17.7429 29.5871C18.6417 29.6263 18.9264 29.6384 21.2056 29.6384C23.4848 29.6384 23.7769 29.6384 24.6682 29.5871C25.3655 29.5729 26.0554 29.4407 26.7085 29.196C27.2664 28.9797 27.7731 28.6494 28.1962 28.2263C28.6193 27.8031 28.9496 27.2964 29.166 26.7385C29.4114 26.0852 29.543 25.3964 29.557 24.6983C29.5972 23.8004 29.6093 23.5157 29.6093 21.2356C29.6093 18.9555 29.6093 18.6661 29.557 17.7729C29.5462 17.0657 29.4132 16.3657 29.1641 15.7037ZM28.0273 24.6003C28.0213 25.1382 27.9231 25.671 27.737 26.1757C27.5969 26.5387 27.3823 26.8683 27.1071 27.1433C26.8319 27.4183 26.5022 27.6327 26.1392 27.7727C25.64 27.9579 25.1128 28.0561 24.5805 28.0629C23.6938 28.104 23.4437 28.1143 21.1701 28.1143C18.8946 28.1143 18.6622 28.1143 17.7588 28.0629C17.2267 28.0564 16.6997 27.9582 16.201 27.7727C15.8367 27.6336 15.5057 27.4196 15.2293 27.1445C14.9529 26.8694 14.7374 26.5394 14.5966 26.1757C14.4132 25.6765 14.315 25.1499 14.3064 24.618C14.2662 23.7313 14.2569 23.4812 14.2569 21.2076C14.2569 18.9331 14.2569 18.7007 14.3064 17.7963C14.3124 17.2587 14.4106 16.7261 14.5966 16.2217C14.8813 15.4853 15.4646 14.9057 16.201 14.6239C16.7 14.4392 17.2268 14.341 17.7588 14.3336C18.6464 14.2935 18.8956 14.2823 21.1701 14.2823C23.4446 14.2823 23.678 14.2823 24.5805 14.3336C25.1129 14.34 25.6402 14.4382 26.1392 14.6239C26.5022 14.7641 26.8318 14.9787 27.107 15.2539C27.3822 15.5291 27.5968 15.8587 27.737 16.2217C27.9205 16.721 28.0186 17.2476 28.0273 17.7795C28.0674 18.6671 28.0777 18.9163 28.0777 21.1908C28.0777 23.4644 28.0777 23.7089 28.0376 24.6012H28.0273V24.6003Z"
					fill="' . $color . '" />
			</svg></a></li>';
	}
	if(get_theme_mod('facebook-social') != '') {
		$html .= '<li class="social-media__list"><a href="' . $facebook . '">
			<svg class="social-media__svg" width="42" height="42"
	                                               fill="none" xmlns="http://www.w3.org/2000/svg">
				<circle cx="21" cy="21" r="21" fill="white" fill-opacity="0.1" />
				<path
					d="M22.5039 29.5973V21.9477H25.0845L25.4681 18.9526H22.5039V17.0449C22.5039 16.1806 22.7447 15.5889 23.9851 15.5889H25.5568V12.9186C24.7921 12.8367 24.0234 12.7971 23.2543 12.8001C20.9732 12.8001 19.4071 14.1926 19.4071 16.749V18.947H16.8432V21.9421H19.4127V29.5973H22.5039Z"
					fill="' . $color . '" />
			</svg></a></li>';

	}
	if(get_theme_mod('linkedin-social') != '') {
	    $html .= '<li class="social-media__list"><a href="' . $linkedin . '"><svg class="social-media__svg" width="42" height="42"
	                                               fill="none" xmlns="http://www.w3.org/2000/svg">
				<circle cx="21" cy="21" r="21" fill="white" fill-opacity="0.1" />
				<path
					d="M14.6508 16.7173C15.7786 16.7173 16.6929 15.803 16.6929 14.6752C16.6929 13.5474 15.7786 12.6331 14.6508 12.6331C13.5229 12.6331 12.6086 13.5474 12.6086 14.6752C12.6086 15.803 13.5229 16.7173 14.6508 16.7173Z"
					fill="white" />
				<path
					d="M18.6212 18.2647V29.5945H22.1389V23.9917C22.1389 22.5133 22.4171 21.0815 24.2501 21.0815C26.058 21.0815 26.0804 22.7718 26.0804 24.085V29.5954H29.6V23.3822C29.6 20.3302 28.9429 17.9847 25.3757 17.9847C23.6631 17.9847 22.5151 18.9246 22.0456 19.8141H21.998V18.2647H18.6212ZM12.8887 18.2647H16.412V29.5945H12.8887V18.2647Z"
					fill="' . $color . '" />
			</svg></a></li>';
	}
	if(get_theme_mod('basket-social') != '') {
		$html .= '<li class="social-media__list"><a href="' . $basket . '"><svg class="social-media__svg" width="42" height="42"
	                                               fill="none" xmlns="http://www.w3.org/2000/svg">
				<circle cx="21" cy="21" r="21" fill="white" fill-opacity="0.1" />
				<path
					d="M29.2827 16.5148C28.4682 15.1034 27.2961 13.9316 25.8844 13.1175C24.4536 12.284 22.8922 11.8668 21.2 11.8668C19.5079 11.8668 17.9464 12.284 16.5147 13.1175C15.0839 13.951 13.9508 15.084 13.1174 16.5148C12.2839 17.9456 11.8667 19.508 11.8667 21.2002C11.8667 22.8923 12.283 24.4547 13.1174 25.8855C13.9315 27.2972 15.1037 28.469 16.5156 29.2828C17.9464 30.1163 19.5079 30.5335 21.2 30.5335C22.8922 30.5335 24.4536 30.1163 25.8854 29.2828C27.297 28.4688 28.4692 27.2969 29.2836 25.8855C30.1171 24.4547 30.5334 22.8923 30.5334 21.2002C30.5334 19.508 30.1171 17.9456 29.2827 16.5148ZM21.2 13.4162C23.0667 13.4162 24.7206 14.0135 26.1654 15.2072C25.3067 16.303 24.0318 17.2046 22.3387 17.9139C21.4035 16.2218 20.3899 14.8087 19.2951 13.6766C19.9156 13.505 20.5563 13.4174 21.2 13.4162ZM15.1427 16.3468C15.8252 15.4802 16.6887 14.773 17.673 14.2748C18.8042 15.3958 19.843 16.7948 20.7903 18.4748C18.9236 19.0348 16.9506 19.3148 14.872 19.3148C14.3372 19.3148 13.9331 19.3027 13.6587 19.2775C13.9447 18.2082 14.4501 17.2102 15.1427 16.3468ZM13.416 21.2002C13.416 21.1498 13.4188 21.0882 13.4254 21.0135C13.4319 20.9388 13.4347 20.8772 13.4347 20.8268C13.6718 20.8399 14.033 20.8455 14.5183 20.8455C17.0066 20.8455 19.3212 20.503 21.4614 19.8188C21.6359 20.167 21.817 20.559 22.0027 20.9948C20.7707 21.2683 19.507 21.9338 18.2124 22.9922C16.9179 24.0506 15.9734 25.164 15.376 26.3335C14.0694 24.8523 13.416 23.1415 13.416 21.2002ZM21.2 28.9842C19.4323 28.9842 17.8456 28.4363 16.4391 27.3424C17 26.2346 17.8615 25.1752 19.0254 24.1682C20.1883 23.1602 21.3428 22.532 22.488 22.2828C23.2104 24.2792 23.699 26.3526 23.944 28.4615C23.0694 28.8033 22.1391 28.9805 21.2 28.9842ZM27.808 25.2882C27.1971 26.2724 26.3745 27.1081 25.4 27.7344C25.176 25.7931 24.7467 23.9012 24.113 22.0588C24.9828 21.9972 25.7603 21.9655 26.4463 21.9655C27.192 21.9655 28.0199 21.9972 28.928 22.0588C28.8062 23.2067 28.4231 24.3114 27.808 25.2882ZM26.6507 20.6215C25.568 20.6215 24.5666 20.6654 23.6454 20.7522C23.4502 20.2414 23.2386 19.7372 23.0107 19.2402C24.939 18.3946 26.3072 17.3679 27.1164 16.1602C28.2364 17.4799 28.8468 18.9854 28.9458 20.6775C28.1879 20.6402 27.4226 20.6215 26.6507 20.6215Z"
					fill="' . $color . '" />
			</svg></a></li>';
	}
	$html .= '</ul>';
	return $html;
}