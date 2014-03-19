<?php
/*
Section: PageTitle
Author: TourKick (Clifford P)
Author URI: http://tourkick.com/?utm_source=pagelines&utm_medium=section&utm_content=authoruri&utm_campaign=pagetitle_section
Description: Display PageLines DMS Page Titles automatically, with optional manual override per-page (global and per-page settings). Includes animation, font-size, and other customizations. Even has a subtitle area. Auto titles, manual titles, and subtitles all support shortcodes.
Demo: http://www.pagelinestheme.com/pagetitle-section?utm_source=pagelines&utm_medium=section&utm_content=demolink&utm_campaign=pagetitle_section
Version: 2.0
Class Name: DMSPageTitle
Filter: component
Cloning: true
v3: true
*/

class DMSPageTitle extends PageLinesSection {

/*
Possible to-do's:
- excerpt as auto-created subtitle
- separate alignment for title and subtitle
*/


	function section_persistent() {
		add_filter('pl_settings_array', array(&$this, 'options'));
	}

    function options( $settings ){

        $settings[ $this->id ] = array(
                'name'  => $this->name,
                'icon'  => 'icon-info-sign',
                'pos'   => 3,
                'opts'  => $this->global_opts()
        );

        return $settings;
    }

    function global_opts(){

        $global_opts = array(
			array(
				'type'		=> 'multi',
				'title'		=> 'Title Text',
				'key'		=> 'pagetitle_text',
				'opts'		=> array(
					array(
						'type' 			=> 'select',
						'key'			=> 'pagetitle_title',
						'label' 		=> 'Page Title Display',
						//'default'		=> 'auto',
						'help' 	=> __( 'Manual Titles, if entered, always override Auto Titles.', 'tk_pagetitle' ),
						'opts'			=> array(
							'auto'		=> array('name' => 'Auto Title (Default)'),
							'manual'		=> array('name' => 'Manual Input Only'),
						)
					),
					array(
						'type' 			=> 'text',
						'key'			=> 'pagetitle_global_class',
						'help' 	=> __( 'Insert a CSS Class (separate multiple with a space) for the entire title and subtitle div. A global alternative to using the Standard Options -> Styling Classes to add custom classes to every post individually, although that still works too and is applied at a higher-level (i.e. before this div class).', 'tk_pagetitle' ),
						'label' 		=> __( 'PageTitle Global Class (Optional)', 'tk_pagetitle' ),
					),
				)
			),
			array(
				'type'		=> 'multi',
				'title'		=> 'Customizations',
				'key'		=> 'pagetitle_config',
				'opts'		=> array(
					array(
						'type' 			=> 'select',
						'key'			=> 'pagetitle_tag',
						'label' 		=> 'Page Title HTML Tag',
						//'default'		=> 'h1',
						'opts'			=> array(
							'h1'		=> array('name' => 'H1 (Default)'),
							'h2'		=> array('name' => 'H2'),
							'h3'		=> array('name' => 'H3'),
							'h4'		=> array('name' => 'H4'),
							'h5'		=> array('name' => 'H5'),
							'h6'		=> array('name' => 'H6'),
							'p'			=> array('name' => 'P (i.e. none)'),
						)
					),
					array(
						'type' 			=> 'text',
						'key'			=> 'pagetitle_title_class',
						'help' 	=> __( 'Insert a CSS Class (separate multiple with a space) just to the Heading HTML Tag (e.g. h1 class="..."). Use the Standard Options -> Styling Classes to add custom classes to the entire section.', 'tk_pagetitle' ),
						'label' 		=> __( 'Page Title Heading Tag Class (Optional)', 'tk_pagetitle' ),
					),
					array(
						'key'			=> 'pagetitle_font_size',
						'type'			=> 'count_select',
						'count_start'	=> 10,
						'count_number'	=> 60,
						'suffix'		=> 'px',
						'title'			=> __( 'Page Title Font Size', 'tk_pagetitle' ),
						'default'		=> '',
					),
					array(
						'type' 			=> 'select',
						'key'			=> 'pagetitle_tag_subtitle',
						'label' 		=> 'Subtitle HTML Tag',
						'help' 			=> __( 'It is always recommended to only have one H1 tag per page.', 'tk_pagetitle' ),
						//'default'		=> 'p',
						'opts'			=> array(
							'h1'		=> array('name' => 'H1'),
							'h2'		=> array('name' => 'H2'),
							'h3'		=> array('name' => 'H3'),
							'h4'		=> array('name' => 'H4'),
							'h5'		=> array('name' => 'H5'),
							'h6'		=> array('name' => 'H6'),
							'p'			=> array('name' => 'P (Default)'),
						)
					),
					array(
						'type' 			=> 'text',
						'key'			=> 'pagetitle_title_class_subtitle',
						'help' 	=> __( 'Insert a CSS Class (separate multiple with a space) just to the Subtitle HTML Tag (e.g. p class="...").', 'tk_pagetitle' ),
						'label' 		=> __( 'Subtitle Heading Tag Class (Optional)', 'tk_pagetitle' ),
					),
					array(
						'key'			=> 'pagetitle_font_size_subtitle',
						'type'			=> 'count_select',
						'count_start'	=> 10,
						'count_number'	=> 60,
						'suffix'		=> 'px',
						'title'			=> __( 'Subtitle Font Size', 'tk_pagetitle' ),
						'default'		=> '',
					),
					array(
						'type' 			=> 'select',
						'key'			=> 'pagetitle_align',
						'label' 		=> 'Alignment / Float',
						//'default'		=> 'left',
						'opts'			=> array(
							// https://github.com/pagelines/DMS/blob/1.1/less/pl-objects.less#L449
							'left'			=> array('name' => 'Float Left'),
							'right'			=> array('name' => 'Float Right'),
							'center'		=> array('name' => 'Center'),
							'textjustify'	=> array('name' => 'Justify'),
						)
					),
					array(
						'type' 			=> 'select_animation',
						'key'			=> 'pagetitle_animation',
						'label' 		=> __( 'Viewport Animation', 'tk_pagetitle' ),
						//'default'		=> 'no-anim',
						'help' 			=> __( 'Optionally animate the appearance of this section on view.', 'tk_pagetitle' ),
					),
					array(
						'key'			=> 'pagetitle_pad',
						'type' 			=> 'text',
						'label' 	=> __( 'Padding (use CSS Shorthand)', 'tk_pagetitle' ),
						'help'		=> __( 'This option uses CSS padding shorthand. For example, use "15px 30px" for 15px padding top/bottom, and 30 left/right.', 'tk_pagetitle' ),

					),

				)
			),
			array(
				'type'		=> 'multi',
				'title'		=> 'Override: Special Pages\' Automatic Titles<br/><span style="color:darkred;">Blue text is what you can override</span>',
				'key'		=> 'pagetitle_text_special',
				'opts'		=> array(
					array(
						'type'	=> 'text',
						'key'	=> 'pagetitle_special_home',
						'label'	=> __( '<span style="color:blue;">Blog</span>', 'tk_pagetitle' ),
					),
					array(
						'type'	=> 'text',
						'key'	=> 'pagetitle_special_search',
						'label'	=> __( '<span style="color:blue;">Search Results</span>', 'tk_pagetitle' ),
					),
					array(
						'type'	=> 'text',
						'key'	=> 'pagetitle_special_archive_author',
						'label'	=> __( '<span style="color:blue;">Author Archive</span>', 'tk_pagetitle' ),
					),
					array(
						'type'	=> 'text',
						'key'	=> 'pagetitle_special_category',
						'label'	=> __( '<span style="color:blue;">Category Archive</span>', 'tk_pagetitle' ),
					),
					array(
						'type'	=> 'text',
						'key'	=> 'pagetitle_special_tag',
						'label'	=> __( '<span style="color:blue;">Tag Archive</span>', 'tk_pagetitle' ),
					),
					array(
						'type'	=> 'text',
						'key'	=> 'pagetitle_special_archive_daily',
						'label'	=> __( 'Daily Archive (Default: <span style="color:blue;">Archive:</span> <full date>)', 'tk_pagetitle' ),
					),
					array(
						'type'	=> 'text',
						'key'	=> 'pagetitle_special_archive_monthly',
						'label'	=> __( 'Monthly Archive (Default: <span style="color:blue;">Archive:</span> <month>)', 'tk_pagetitle' ),
					),
					array(
						'type'	=> 'text',
						'key'	=> 'pagetitle_special_archive_yearly',
						'label'	=> __( 'Yearly Archive (Default: <span style="color:blue;">Archive:</span> <year>)', 'tk_pagetitle' ),
					),
					array(
						'type'	=> 'text',
						'key'	=> 'pagetitle_special_archive_other',
						'label'	=> __( 'Other Archives (e.g. Custom Post Type Archives, Default: <post type archive title> <span style="color:blue;">Archive</span>)', 'tk_pagetitle' ),
					),
					array(
						'type'	=> 'text',
						'key'	=> 'pagetitle_special_404',
						'label'	=> __( '<span style="color:blue;">404 Error</span>', 'tk_pagetitle' ),
					),

				)
			),
			array(
				'type'		=> 'multi',
				'title'		=> 'Override: Special Pages\' Automatic SUB-Titles<br/><span style="color:darkred;">Blue text is what you can override</span>',
				'key'		=> 'pagetitle_text_special_subs',
				'opts'		=> array(
					array(
						'type'	=> 'text',
						'key'	=> 'pagetitle_special_home_sub',
						'label'	=> __( 'Blog (Default: #_of_posts post_type_label <span style="color:blue;">___</span>)', 'tk_pagetitle' ),
					),
					array(
						'type'	=> 'text',
						'key'	=> 'pagetitle_special_search_sub',
						'label'	=> __( '<span style="color:blue;">Showing search results for:</span> search_query', 'tk_pagetitle' ),
					),
					array(
						'type'	=> 'text',
						'key'	=> 'pagetitle_special_archive_author_sub',
						'label'	=> __( '#_of_posts post_type_label <span style="color:blue;">by</span> author_display_name', 'tk_pagetitle' ),
					),
					array(
						'type'	=> 'text',
						'key'	=> 'pagetitle_special_category_sub',
						'label'	=> __( '#_of_posts post_type_label <span style="color:blue;">in</span> single_category_title', 'tk_pagetitle' ),
					),
					array(
						'type'	=> 'text',
						'key'	=> 'pagetitle_special_tag_sub',
						'label'	=> __( '#_of_posts post_type_label <span style="color:blue;">tagged</span> single_tag_title', 'tk_pagetitle' ),
					),
					array(
						'type'	=> 'text',
						'key'	=> 'pagetitle_special_archive_daily_sub',
						'label'	=> __( '#_of_posts post_type_label <span style="color:blue;">Published</span>', 'tk_pagetitle' ),
					),
					array(
						'type'	=> 'text',
						'key'	=> 'pagetitle_special_archive_monthly_sub',
						'label'	=> __( '#_of_posts post_type_label <span style="color:blue;">Published</span>', 'tk_pagetitle' ),
					),
					array(
						'type'	=> 'text',
						'key'	=> 'pagetitle_special_archive_yearly_sub',
						'label'	=> __( '#_of_posts post_type_label <span style="color:blue;">Published</span>', 'tk_pagetitle' ),
					),
					array(
						'type'	=> 'text',
						'key'	=> 'pagetitle_special_archive_other_sub',
						'label'	=> __( '#_of_posts post_type_label <span style="color:blue;">___</span>', 'tk_pagetitle' ),
					),
					array(
						'type'	=> 'text',
						'key'	=> 'pagetitle_special_404_sub',
						'label'	=> __( '<span style="color:blue;">Sorry, Not Found</span>', 'tk_pagetitle' ),
					),

				)
			),
        );

        return array_merge($global_opts);
    }


	function section_opts(){
		$opts = array(
			array(
				'type'		=> 'multi',
				'title'		=> 'Title Text',
				'key'		=> 'pagetitle_text',
				'opts'		=> array(
					array(
						'type' 			=> 'select',
						'key'			=> 'pagetitle_title',
						'label' 		=> 'Page Title Display',
						'default'		=> '',
						'help' 	=> __( 'Manual Titles, if entered, always override Auto Titles.', 'tk_pagetitle' ),
						'opts'			=> array(
							'auto'		=> array('name' => 'Auto Title (Default)'),
							'manual'		=> array('name' => 'Manual Input Only'),
						)
					),
					array(
						'type' 			=> 'text',
						'key'			=> 'pagetitle_title_manual',
						'help' 	=> __( 'If entered, will override Auto Title.<br/>If no Auto Title and nothing entered here, no title will be displayed. Shortcodes work too!', 'tk_pagetitle' ),
						'label' 		=> __( 'Manual Title (Optional)', 'tk_pagetitle' ),
					),
					array(
						'type' 			=> 'textarea',
						'key'			=> 'pagetitle_subtitle',
						'label' 		=> __( 'Subtitle (Optional)', 'tk_pagetitle' ),
						'help' 	=> __( 'Smaller text displayed below the Page Title (never auto-generated). Shortcodes work too!', 'tk_pagetitle' ),
					),

				)
			),
			array(
				'type'		=> 'multi',
				'title'		=> 'Customizations',
				'key'		=> 'pagetitle_config',
				'opts'		=> array(
					array(
						'type' 			=> 'select',
						'key'			=> 'pagetitle_tag',
						'label' 		=> 'Page Title HTML Tag',
						'default'		=> '',
						'opts'			=> array(
							'h1'		=> array('name' => 'H1 (Default)'),
							'h2'		=> array('name' => 'H2'),
							'h3'		=> array('name' => 'H3'),
							'h4'		=> array('name' => 'H4'),
							'h5'		=> array('name' => 'H5'),
							'h6'		=> array('name' => 'H6'),
							'p'			=> array('name' => 'P (i.e. none)'),
						)
					),
					array(
						'type' 			=> 'text',
						'key'			=> 'pagetitle_title_class',
						'help' 	=> __( 'Insert a CSS Class (separate multiple with a space) just to the Heading HTML Tag (e.g. h1 class="..."). Use the Standard Options -> Styling Classes to add custom classes to the entire section.', 'tk_pagetitle' ),
						'label' 		=> __( 'Page Title Heading Tag Class (Optional)', 'tk_pagetitle' ),
					),
					array(
						'key'			=> 'pagetitle_font_size',
						'type'			=> 'count_select',
						'count_start'	=> 10,
						'count_number'	=> 60,
						'suffix'		=> 'px',
						'title'			=> __( 'Page Title Font Size', 'tk_pagetitle' ),
						'default'		=> '',
					),
					array(
						'type' 			=> 'select',
						'key'			=> 'pagetitle_tag_subtitle',
						'label' 		=> 'Subtitle HTML Tag',
						'help' 			=> __( 'It is always recommended to only have one H1 tag per page.', 'tk_pagetitle' ),
						'default'		=> '',
						'opts'			=> array(
							'h1'		=> array('name' => 'H1'),
							'h2'		=> array('name' => 'H2'),
							'h3'		=> array('name' => 'H3'),
							'h4'		=> array('name' => 'H4'),
							'h5'		=> array('name' => 'H5'),
							'h6'		=> array('name' => 'H6'),
							'p'			=> array('name' => 'P (Default)'),
						)
					),
					array(
						'type' 			=> 'text',
						'key'			=> 'pagetitle_title_class_subtitle',
						'help' 	=> __( 'Insert a CSS Class (separate multiple with a space) just to the Subtitle HTML Tag (e.g. p class="...").', 'tk_pagetitle' ),
						'label' 		=> __( 'Subtitle Heading Tag Class (Optional)', 'tk_pagetitle' ),
					),
					array(
						'key'			=> 'pagetitle_font_size_subtitle',
						'type'			=> 'count_select',
						'count_start'	=> 10,
						'count_number'	=> 60,
						'suffix'		=> 'px',
						'title'			=> __( 'Subtitle Font Size', 'tk_pagetitle' ),
						'default'		=> '',
					),
					array(
						'type' 			=> 'select',
						'key'			=> 'pagetitle_align',
						'label' 		=> 'Alignment / Float',
						//'default'		=> 'left',
						'opts'			=> array(
							'left'			=> array('name' => 'Float Left'),
							'right'			=> array('name' => 'Float Right'),
							'center'		=> array('name' => 'Center'),
							'textjustify'	=> array('name' => 'Justify'),
						)
					),
					array(
						'type' 			=> 'select_animation',
						'key'			=> 'pagetitle_animation',
						'label' 		=> __( 'Viewport Animation', 'tk_pagetitle' ),
						'default'		=> '',
						'help' 			=> __( 'Optionally animate the appearance of this section on view.', 'tk_pagetitle' ),
					),
					array(
						'key'			=> 'pagetitle_pad',
						'type' 			=> 'text',
						'label' 	=> __( 'Padding (use CSS Shorthand)', 'tk_pagetitle' ),
						'help'		=> __( 'This option uses CSS padding shorthand. For example, use "15px 30px" for 15px padding top/bottom, and 30 left/right.', 'tk_pagetitle' ),

					),

				)
			),



		);

		return $opts;

	}

	function section_template() {

		// Check for DMS
		if( function_exists('pl_has_editor') && pl_has_editor() ){} else { return; };

		// prep the title
		$manualtext = '';

		if( is_page() || is_single() ){
			if( pl_setting('pagetitle_title') == 'manual'
			  || $this->opt('pagetitle_title') == 'manual' ) {
				$autotitle = false;

				$manualtext = pl_setting('pagetitle_title_manual') ? pl_setting('pagetitle_title_manual') : '';
					$manualtext = $this->opt('pagetitle_title_manual') ? $this->opt('pagetitle_title_manual') : $manualtext;

			} else {
				$autotitle = true;
			}
		} else {
			$autotitle = true;
		}


		//build the title
		//is_paged, is_attachment
		if($manualtext){
			$titletext = $manualtext;
		} elseif ($autotitle){
			if( is_page() || is_single() ){
				global $post;
				$postid = $post->ID;

				$titletext = get_the_title($postid);

				$subtitletext = pl_setting('pagetitle_subtitle') ? pl_setting('pagetitle_subtitle') : '';
					$subtitletext = $this->opt('pagetitle_subtitle') ? $this->opt('pagetitle_subtitle') : $subtitletext;
			} elseif( is_home() ) {
				global $wp_query;
				$numposts = $wp_query->found_posts;
				$posttype = get_post_type();
				$posttypeobject = get_post_type_object($posttype);
				$nameofposts = $posttypeobject->label;

			 	$titletext = pl_setting('pagetitle_special_home') ? pl_setting('pagetitle_special_home') : 'Blog';

				$subtitletext = pl_setting('pagetitle_special_home_sub') ? pl_setting('pagetitle_special_home_sub') : '';
					$subtitletext = sprintf( '%s %s %s', $numposts, $nameofposts, $subtitletext );

			} elseif( is_search() ) {
			 	$titletext = pl_setting('pagetitle_special_search') ? pl_setting('pagetitle_special_search') : 'Search Results';

				$subtitletext = pl_setting('pagetitle_special_search_sub') ? pl_setting('pagetitle_special_search_sub') : 'Showing search results for:';
					$subtitletext = sprintf( '%s "%s"', $subtitletext, get_search_query() );

			} elseif( is_archive() ) {
				global $wp_query;
				$numposts = $wp_query->found_posts;
				$posttype = get_post_type();
				$posttypeobject = get_post_type_object($posttype);
				$nameofposts = $posttypeobject->label;

				if (is_author()) {
					global $author;
					global $author_name;

					$currentauthor = ( isset( $_GET['author_name'] ) ) ? get_user_by( 'slug', $author_name ) : get_userdata( intval( $author ) );

					$titletext = pl_setting('pagetitle_special_archive_author') ? pl_setting('pagetitle_special_archive_author') : 'Author Archive';

					$subtitletext = pl_setting('pagetitle_special_archive_author_sub') ? pl_setting('pagetitle_special_archive_author_sub') : 'by';
						$subtitletext = sprintf( '%s %s %s %s', $numposts, $nameofposts, $subtitletext, $currentauthor->display_name );

				} elseif( is_category() ) {
				 	$titletext = pl_setting('pagetitle_special_category') ? pl_setting('pagetitle_special_category') : 'Category Archive';

					$subtitletext = pl_setting('pagetitle_special_category_sub') ? pl_setting('pagetitle_special_category_sub') : 'in';
						$subtitletext = sprintf( '%s %s %s "%s"', $numposts, $nameofposts, $subtitletext, single_cat_title( false, false ) );

				} elseif( is_tag() ) {
				 	$titletext = pl_setting('pagetitle_special_tag') ? pl_setting('pagetitle_special_tag') : 'Tag Archive';

					$subtitletext = pl_setting('pagetitle_special_tag_sub') ? pl_setting('pagetitle_special_tag_sub') : 'tagged';
						$subtitletext = sprintf( '%s %s %s "%s"', $numposts, $nameofposts, $subtitletext, single_tag_title( false, false ) );

				}
				/*
				elseif( is_tax() ) {
				 	$titletext = pl_setting('pagetitle_special_tag') ? pl_setting('pagetitle_special_tag') : 'Tag';

				}
				*/
				elseif ( is_day() ) {
				 	$titletext = pl_setting('pagetitle_special_archive_daily') ? pl_setting('pagetitle_special_archive_daily') : 'Archive:';
					 	$titletext = sprintf( '%s %s', $titletext, get_the_time('l, F j, Y') );

					$subtitletext = pl_setting('pagetitle_special_archive_daily_sub') ? pl_setting('pagetitle_special_archive_daily_sub') : 'Published';
						$subtitletext = sprintf( '%s %s %s', $numposts, $nameofposts, $subtitletext );

				} elseif ( is_month() ) {
				 	$titletext = pl_setting('pagetitle_special_archive_monthly') ? pl_setting('pagetitle_special_archive_monthly') : 'Archive:';
					 	$titletext = sprintf( '%s %s', $titletext, get_the_time('F Y') );

					$subtitletext = pl_setting('pagetitle_special_archive_monthly_sub') ? pl_setting('pagetitle_special_archive_monthly_sub') : 'Published';
						$subtitletext = sprintf( '%s %s %s', $numposts, $nameofposts, $subtitletext );

				} elseif ( is_year() ) {
				 	$titletext = pl_setting('pagetitle_special_archive_yearly') ? pl_setting('pagetitle_special_archive_yearly') : 'Archive: Year';
					 	$titletext = sprintf( '%s %s', $titletext, get_the_time('Y') );

					$subtitletext = pl_setting('pagetitle_special_archive_yearly_sub') ? pl_setting('pagetitle_special_archive_yearly_sub') : 'Published';
						$subtitletext = sprintf( '%s %s %s', $numposts, $nameofposts, $subtitletext );

				} else {

					if ( is_post_type_archive() ) {
					 	$titletext = pl_setting('pagetitle_special_archive_other') ? pl_setting('pagetitle_special_archive_other') : 'Archive';
							$titletext = sprintf( '%s %s', post_type_archive_title( false, false ), $titletext );

						$subtitletext = pl_setting('pagetitle_special_archive_other_sub') ? pl_setting('pagetitle_special_archive_other_sub') : '';
						$subtitletext = sprintf( '%s %s %s', $numposts, $nameofposts, $subtitletext );
					}

					if ( ! isset( $titletext ) ) {
						$o = get_queried_object();
						if ( isset( $o->name ) ) {
							$titletext = $o->name;
								$titletext = sprintf( '%s "%s"', $titletext, post_type_archive_title( false, false ) );
							$subtitletext = pl_setting('pagetitle_special_archive_other_sub') ? pl_setting('pagetitle_special_archive_other_sub') : '';
						$subtitletext = sprintf( '%s %s %s', $numposts, $nameofposts, $subtitletext );
						}
					}

					if ( ! isset( $titletext ) ) {
					 	$titletext = pl_setting('pagetitle_special_archive_other') ? pl_setting('pagetitle_special_archive_other') : 'Archive';
							$titletext = sprintf( '%s %s', the_date(), $titletext );

						$subtitletext = pl_setting('pagetitle_special_archive_other_sub') ? pl_setting('pagetitle_special_archive_other_sub') : '';
						$subtitletext = sprintf( '%s %s %s', $numposts, $nameofposts, $subtitletext );
					}

				}

			} elseif( is_404() ) {
				$titletext = pl_setting('pagetitle_special_404') ? pl_setting('pagetitle_special_404') : '404 Error';
				$subtitletext = pl_setting('pagetitle_special_404_sub') ? pl_setting('pagetitle_special_404_sub') : 'Sorry, Not Found';
			} else {
				$titletext = '';
				$subtitletext = '';
			}
		} else {
			$titletext = '';
			$subtitletext = '';
		}

		$titletext = $titletext ? do_shortcode($titletext) : '';
		$subtitletext = $subtitletext ? do_shortcode($subtitletext) : '';

		// IF NO TITLES
		if(!$titletext && !$subtitletext){
			global $post;
			$postid = $post->ID;
			if(current_user_can('edit_post', $postid)){
				echo do_shortcode('[pl_alertbox type="info" closable="yes"]No Page Title. It will not display unless you edit this Page to add one or you manually enter one via PageLines DMS Section.[/pl_alertbox]');
			} else {
				return;
			}
		}


		// Global div class
		$globalclass = pl_setting('pagetitle_global_class') ? pl_setting('pagetitle_global_class') : '';
			//there is no local option

		// Page Title Setup
		$titletag = pl_setting('pagetitle_tag') ? pl_setting('pagetitle_tag') : 'h1';
			$titletag = $this->opt('pagetitle_tag') ? $this->opt('pagetitle_tag') : $titletag;

		$titleclass = pl_setting('pagetitle_title_class') ? pl_setting('pagetitle_title_class') : '';
			$titleclass = $this->opt('pagetitle_title_class') ? $this->opt('pagetitle_title_class') : $titleclass;

		$titlesize = pl_setting('pagetitle_font_size') ? sprintf('font-size: %spx;', pl_setting('pagetitle_font_size')) : '';
			$titlesize = $this->opt('pagetitle_font_size') ? sprintf('font-size: %spx;', $this->opt('pagetitle_font_size')) : $titlesize;

		// TITLE LINE
		$title = $titletext ? sprintf( '<%s class="%s" style="%s">%s</%s>', $titletag, $titleclass, $titlesize, $titletext, $titletag ) : '';


		// Subtitle Setup
		$subtitletag = pl_setting('pagetitle_tag_subtitle') ? pl_setting('pagetitle_tag_subtitle') : 'p';
			$subtitletag = $this->opt('pagetitle_tag_subtitle') ? $this->opt('pagetitle_tag_subtitle') : $subtitletag;

		$subtitleclass = pl_setting('pagetitle_title_class_subtitle') ? pl_setting('pagetitle_title_class_subtitle') : '';
			$subtitleclass = $this->opt('pagetitle_title_class_subtitle') ? $this->opt('pagetitle_title_class_subtitle') : $subtitleclass;

		$subtitlesize = pl_setting('pagetitle_font_size_subtitle') ? sprintf('font-size: %spx;', pl_setting('pagetitle_font_size_subtitle')) : '';
			$subtitlesize = $this->opt('pagetitle_font_size_subtitle') ? sprintf('font-size: %spx;', $this->opt('pagetitle_font_size_subtitle')) : $subtitlesize;


		// SUBTITLE LINE
		$subtitle = $subtitletext ? sprintf('<%s class="%s" style="%s">%s</%s>', $subtitletag, $subtitleclass, $subtitlesize, $subtitletext, $subtitletag) : '';


		// Section Style Options
		$align = pl_setting('pagetitle_align') ? pl_setting('pagetitle_align') : '';
			$align = $this->opt('pagetitle_align') ? $this->opt('pagetitle_align') : $align;

		$animationclass = pl_setting('pagetitle_animation') ? pl_setting('pagetitle_animation') : '';
			$animationclass = $this->opt('pagetitle_animation') ? $this->opt('pagetitle_animation') : $animationclass;

		$pad = pl_setting('pagetitle_pad') ? sprintf('padding: %s;', pl_setting('pagetitle_pad')) : '';
			$pad = $this->opt('pagetitle_pad') ? sprintf('padding: %s;', $this->opt('pagetitle_pad')) : $pad;


		// SECTION OUTPUT
		printf('<div class="post-title fix pagetitle-wrap pl-animation %s %s %s" style="%s">', $globalclass, $align, $animationclass, $pad); //post-title and fix are from DMS Core -- https://github.com/pagelines/DMS/blob/Dev/includes/class.posts.php#L293

		echo $title;

		if($subtitletext){
			echo $subtitle;
		}

		echo '</div>';

	}
}