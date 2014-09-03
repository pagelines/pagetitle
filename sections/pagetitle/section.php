<?php
/*
Section: PageTitle
Author: TourKick (Clifford P)
Author URI: http://tourkick.com/?utm_source=pagelines&utm_medium=section&utm_content=authoruri&utm_campaign=pagetitle_section
Description: Display PageLines DMS Page Titles automatically, with optional manual override per-page (global and per-page settings). Includes animation, font-size, and other customizations. Even has a subtitle area. Auto titles, manual titles, and subtitles all support shortcodes.
Demo: http://www.pagelinestheme.com/pagetitle-section?utm_source=pagelines&utm_medium=section&utm_content=demolink&utm_campaign=pagetitle_section
Class Name: DMSPageTitle
Filter: component
Cloning: true
v3: true
*/

class DMSPageTitle extends PageLinesSection {

/*
Notes/Ideas:

- 1 Posts ... (should be Post)

- separate alignment for title and subtitle

- is_tax options
- turn off for post formats
- # %%format_type%% %%post_type%% for archives of post formats

- shortcode or %% counts instead of hard-coded

- if a Special Page's individual scope is manual, it doesn't turn it off


- from PageHeader:
	pl-animation pl-slidedown

	function before_section_template( $location = '' ) {

		$this->wrapper_classes['special'] = 'pl-scroll-translate';

	}


*/


	function section_persistent() {
		add_filter('pl_settings_array', array($this, 'options'));
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
				'title'		=> 'Customizations',
				'key'		=> 'pagetitle_config',
				'opts'		=> array(
					array(
						'type'		=> 'select',
						'key'		=> 'pagetitle_title',
						'label' 	=> __('Page Title Display', 'tk_pagetitle' ),
						//'default'	=> 'auto',
						'help' 		=> __( 'Manual Titles, if entered, will override Auto Titles even in auto mode.', 'tk_pagetitle' ),
						'opts'		=> array(
							'auto'		=> array('name' => 'Auto Title (Default)'),
							'manual'	=> array('name' => 'Manual Input Only but with Auto for Special Pages'),
							'manualnospecial'	=> array('name' => 'Manual WITHOUT Auto for Special Pages'),
						)
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
				'title'		=> 'Title Text Options',
				'key'		=> 'pagetitle_title_options',
				'opts'		=> array(
					array(
						'type' 			=> 'select',
						'key'			=> 'pagetitle_tag',
						'label' 		=> 'Title Text HTML Tag',
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
						'label' 		=> __( 'Title Text Heading Tag Class (Optional)', 'tk_pagetitle' ),
					),
					array(
						'key'			=> 'pagetitle_font_size',
						'type'			=> 'count_select',
						'count_start'	=> 10,
						'count_number'	=> 60,
						'suffix'		=> 'px',
						'title'			=> __( 'Title Text Font Size', 'tk_pagetitle' ),
						'default'		=> '',
					),
				)
			),
			array(
				'type'		=> 'multi',
				'title'		=> 'SUB-Title Text Options',
				'key'		=> 'pagetitle_subtitle_options',
				'opts'		=> array(
					array(
						'type'		=> 'select',
						'key'		=> 'pagetitle_subtitleauto',
						'label' 	=> __('Subtitle Text Display', 'tk_pagetitle' ),
						//'default'	=> 'auto',
						'help' 		=> __( 'Manual Subtitles, if entered, will override Auto Subtitles even in auto mode.<br/>Excerpts will not be displayed unless a custom excerpt is written.', 'tk_pagetitle' ),
						'opts'		=> array(
							'onlyspecial'	=> array('name' => 'Auto Subtitle on Special Pages Only (Default)'),
							'excerpt'		=> array('name' => 'Excerpt as Subtitle on Single + Auto Subtitle on Special Pages'),
							'off'			=> array('name' => 'NO Auto Subtitle on Special Pages'),
						)
					),
					array(
						'type'		=> 'select',
						'key'		=> 'pagetitle_pageexcerpts',
						'label' 	=> __('(Advanced) Display Excerpts on Pages too?', 'tk_pagetitle' ),
						//'default'	=> 'no',
						'help' 		=> __( 'Only applies if you have <a href="http://wordpress.org/plugins/page-excerpt/" target="_blank">enabled Excerpts for the Page post type</a> and selected to display Excerpts for the Page Subtitle setting above.', 'tk_pagetitle' ),
						'opts'		=> array(
							'no'	=> array('name' => 'DO NOT Display Excerpts on Pages (Default)'),
							'yes'	=> array('name' => 'DO Display Excerpts on Pages'),
						)
					),
					array(
						'type' 			=> 'select',
						'key'			=> 'pagetitle_tag_subtitle',
						'label' 		=> 'Subtitle Text HTML Tag',
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
						'label' 		=> __( 'Subtitle Text Heading Tag Class (Optional)', 'tk_pagetitle' ),
					),
					array(
						'key'			=> 'pagetitle_font_size_subtitle',
						'type'			=> 'count_select',
						'count_start'	=> 10,
						'count_number'	=> 60,
						'suffix'		=> 'px',
						'title'			=> __( 'Subtitle Text Font Size', 'tk_pagetitle' ),
						'default'		=> '',
					),
					array(
						'type'	=> 'text',
						'key'	=> 'pagetitle_special_before_sub',
						'label'	=> __( 'Before text for certain Special Pages\' subtitles (e.g. <span style="color:blue;">"</span> or <span style="color:blue;">\'</span> or <span style="color:blue;">-- </span>)', 'tk_pagetitle' ),
					),
					array(
						'type'	=> 'text',
						'key'	=> 'pagetitle_special_after_sub',
						'label'	=> __( 'After text for certain Special Pages\' subtitles (e.g. <span style="color:blue;">"</span> or <span style="color:blue;">\'</span>)', 'tk_pagetitle' ),
					),

				)
			),
			array(
				'type'		=> 'multi',
				'title'		=> 'Override: Special Pages\' Automatic Title Text<br/><span style="color:darkred;">Blue text is what you can override</span>',
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
						'key'	=> 'pagetitle_special_tax',
						'label'	=> __( 'taxonomy_name <span style="color:blue;">Archive</span>', 'tk_pagetitle' ),
					),
					array(
						'type'	=> 'text',
						'key'	=> 'pagetitle_special_archive_daily',
						'label'	=> __( '<span style="color:blue;">Daily Archive:</span> full_date)', 'tk_pagetitle' ),
					),
					array(
						'type'	=> 'text',
						'key'	=> 'pagetitle_special_archive_monthly',
						'label'	=> __( '<span style="color:blue;">Monthly Archive:</span> month)', 'tk_pagetitle' ),
					),
					array(
						'type'	=> 'text',
						'key'	=> 'pagetitle_special_archive_yearly',
						'label'	=> __( '<span style="color:blue;">Annual Archive:</span> year)', 'tk_pagetitle' ),
					),
					array(
						'type'	=> 'text',
						'key'	=> 'pagetitle_special_archive_other',
						'label'	=> __( 'Other Archives (e.g. Custom Post Type Archives, Default: post_type_archive_title <span style="color:blue;">Archive</span>)', 'tk_pagetitle' ),
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
				'title'		=> 'Override: Special Pages\' Automatic SUB-Title Text<br/><span style="color:darkred;">Blue text is what you can override</span>',
				'key'		=> 'pagetitle_text_special_subs',
				'opts'		=> array(
					array(
						'type'	=> 'text',
						'key'	=> 'pagetitle_special_home_sub',
						'label'	=> __( 'Blog: #_of_posts post_type_label <span style="color:blue;">___</span>', 'tk_pagetitle' ),
					),
					array(
						'type'	=> 'text',
						'key'	=> 'pagetitle_special_search_sub',
						'label'	=> __( 'Search: <span style="color:blue;">Showing search results for:</span> search_query', 'tk_pagetitle' ),
					),
					array(
						'type'	=> 'text',
						'key'	=> 'pagetitle_special_archive_author_sub',
						'label'	=> __( 'Author: #_of_posts post_type_label <span style="color:blue;">by</span> author_display_name', 'tk_pagetitle' ),
					),
					array(
						'type'	=> 'text',
						'key'	=> 'pagetitle_special_category_sub',
						'label'	=> __( 'Category: #_of_posts post_type_label <span style="color:blue;">in</span> single_category_title', 'tk_pagetitle' ),
					),
					array(
						'type'	=> 'text',
						'key'	=> 'pagetitle_special_tag_sub',
						'label'	=> __( 'Tag: #_of_posts post_type_label <span style="color:blue;">tagged</span> single_tag_title', 'tk_pagetitle' ),
					),
					array(
						'type'	=> 'text',
						'key'	=> 'pagetitle_special_tax_sub',
						'label'	=> __( 'Taxonomy: #_of_posts post_type_label <span style="color:blue;">___</span> single_tag_title', 'tk_pagetitle' ),
					),
					array(
						'type'	=> 'text',
						'key'	=> 'pagetitle_special_archive_daily_sub',
						'label'	=> __( 'Daily: #_of_posts post_type_label <span style="color:blue;">Published</span>', 'tk_pagetitle' ),
					),
					array(
						'type'	=> 'text',
						'key'	=> 'pagetitle_special_archive_monthly_sub',
						'label'	=> __( 'Monthly: #_of_posts post_type_label <span style="color:blue;">Published</span>', 'tk_pagetitle' ),
					),
					array(
						'type'	=> 'text',
						'key'	=> 'pagetitle_special_archive_yearly_sub',
						'label'	=> __( 'Yearly: #_of_posts post_type_label <span style="color:blue;">Published</span>', 'tk_pagetitle' ),
					),
					array(
						'type'	=> 'text',
						'key'	=> 'pagetitle_special_archive_other_sub',
						'label'	=> __( 'Other: #_of_posts post_type_label <span style="color:blue;">___</span>', 'tk_pagetitle' ),
					),
					array(
						'type'	=> 'text',
						'key'	=> 'pagetitle_special_404_sub',
						'label'	=> __( '404: <span style="color:blue;">Sorry, Not Found</span>', 'tk_pagetitle' ),
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
						'label' 		=> 'Page Title Display (Override)',
						'default'		=> '',
						'help' 	=> __( 'Manual Titles, if entered, always override Auto Titles.', 'tk_pagetitle' ),
						'opts'			=> array(
							'auto'		=> array('name' => 'Auto Title'),
							'manual'	=> array('name' => 'Manual Input Only'),
						)
					),
					array(
						'type'		=> 'select',
						'key'		=> 'pagetitle_subtitleauto',
						'label' 	=> __('Page Subtitle Display (Override)', 'tk_pagetitle' ),
						//'default'	=> 'auto',
						'help' 		=> __( 'Manual Subtitles, if entered, will override Auto Subtitles even in auto mode.<br/>Excerpts will not be displayed unless a custom excerpt is written.', 'tk_pagetitle' ),
						'opts'		=> array(
							'excerpt'		=> array('name' => 'Excerpt as Subtitle on Single'),
							'off'			=> array('name' => 'NO Auto Subtitle on Single (Override Global setting)'),
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

		//build the title
		$autotitle = $this->opt('pagetitle_title') ? $this->opt('pagetitle_title') : pl_setting('pagetitle_title'); //use local if set, else use global
		$autotitle = $autotitle ? $autotitle : 'auto'; //default if neither local nor global are set

		$autosubtitle = $this->opt('pagetitle_subtitleauto') ? $this->opt('pagetitle_subtitleauto') : pl_setting('pagetitle_subtitleauto'); //use local if set, else use global
		$autosubtitle = $autosubtitle ? $autosubtitle : 'onlyspecial'; //default if neither local nor global are set

		$pageexcerpts = pl_setting('pagetitle_pageexcerpts') ? pl_setting('pagetitle_pageexcerpts') : 'no';

		$subtitlebefore = pl_setting('pagetitle_special_before_sub') ? pl_setting('pagetitle_special_before_sub') : '';
		$subtitleafter = pl_setting('pagetitle_special_after_sub') ? pl_setting('pagetitle_special_after_sub') : '';

		$titletext = $this->opt('pagetitle_title_manual') ? $this->opt('pagetitle_title_manual') : '';
		$subtitletext = $this->opt('pagetitle_subtitle') ? $this->opt('pagetitle_subtitle') : '';

		//is_paged, is_attachment
		//is_tax


		if( $autotitle == 'manualnospecial' ){ //can only be set at global level
		} else {

			//set Special Pages' global defaults -- consider pulling from option defaults

			$ishome = 'Blog';
			$ishomesub = '';
			$issearch = 'Search Results';
			$issearchsub = 'Showing search results for:';
			$isauthor = 'Author Archive';
			$isauthorsub = 'by';
			$iscategory = 'Category Archive';
			$iscategorysub = 'in';
			$istag = 'Tag Archive';
			$istagsub = 'tagged';
			$istax = 'Archive';
			$istaxsub = '';
			$isday = 'Daily Archive:';
			$isdaysub = 'Published';
			$ismonth = 'Monthly Archive:';
			$ismonthsub = 'Published';
			$isyear = 'Annual Archive:';
			$isyearsub = 'Published';
			$isposttypearchive = 'Archive';
			$isposttypearchivesub = '';
			$other = 'Archive';//$isarchive = '';
			$othersub = '';//$isarchivesub = '';
			$is404 = '404 Error';
			$is404sub = 'Sorry, Not Found';


			if( is_page()
			  || is_single() ) {
				global $post;
				$postid = $post->ID;

				$titletext = $titletext ? $titletext : get_the_title($postid);

				if( $autosubtitle == 'excerpt' ){
					if( (is_page() && $pageexcerpts == 'yes')
					 || (is_single()) ){
						$subtitletext = $post->post_excerpt; //don't use get_the_excerpt() because that will create an excerpt if not entered
						// http://codex.wordpress.org/Function_Reference/get_the_excerpt
						// could also consider adding option to truncate if too long
					  }
				}
				//if manually entered, use that no matter what
				$subtitletext = $this->opt('pagetitle_subtitle') ? $this->opt('pagetitle_subtitle') : $subtitletext; //there is no global setting

			} elseif( is_home() ) {
				global $wp_query;
				$numposts = $wp_query->found_posts;
				$posttype = get_post_type();
				$posttypeobject = get_post_type_object($posttype);
				$nameofposts = $posttypeobject->label;

			 	$titletext = $titletext ? $titletext : ( pl_setting('pagetitle_special_home') ? pl_setting('pagetitle_special_home') : $ishome );
			 	if( $autosubtitle != 'off' ) {
					$subtitletext = pl_setting('pagetitle_special_home_sub') ? pl_setting('pagetitle_special_home_sub') : $ishomesub;
						$subtitletext = sprintf( '%s %s %s', $numposts, $nameofposts, $subtitletext );
				}
			} elseif( is_search() ) {
			 	$titletext = $titletext ? $titletext : ( pl_setting('pagetitle_special_search') ? pl_setting('pagetitle_special_search') : $issearch );

			 	if( $autosubtitle != 'off' ) {
					$subtitletext = pl_setting('pagetitle_special_search_sub') ? pl_setting('pagetitle_special_search_sub') : $issearchsub;
						$subtitletext = sprintf( '%s %s%s%s', $subtitletext, $subtitlebefore, get_search_query(), $subtitleafter );
				}
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

					$titletext = $titletext ? $titletext : ( pl_setting('pagetitle_special_archive_author') ? pl_setting('pagetitle_special_archive_author') : $isauthor );

					if( $autosubtitle != 'off' ) {
						$subtitletext = pl_setting('pagetitle_special_archive_author_sub') ? pl_setting('pagetitle_special_archive_author_sub') : $isauthorsub;
							$subtitletext = sprintf( '<span class="pagetitle-numposts">%s</span> <span class="pagetitle-nameofposts">%s</span> <span class="pagetitle-subtitlecustomizable">%s</span> <span class="pagetitle-currentauthor">%s</span>', $numposts, $nameofposts, $subtitletext, $currentauthor->display_name );
					}
				} elseif( is_category() ) {
				 	$titletext = $titletext ? $titletext : ( pl_setting('pagetitle_special_category') ? pl_setting('pagetitle_special_category') : $iscategory );

				 	if( $autosubtitle != 'off' ) {
						$subtitletext = pl_setting('pagetitle_special_category_sub') ? pl_setting('pagetitle_special_category_sub') : $iscategorysub;
							$subtitletext = sprintf( '<span class="pagetitle-numposts">%s</span> <span class="pagetitle-nameofposts">%s</span> <span class="pagetitle-subtitlecustomizable">%s</span> <span class="pagetitle-singlecat">%s%s%s</span>', $numposts, $nameofposts, $subtitletext, $subtitlebefore, single_cat_title( '', false ), $subtitleafter );
					}
				} elseif( is_tag() ) {
				 	$titletext = $titletext ? $titletext : ( pl_setting('pagetitle_special_tag') ? pl_setting('pagetitle_special_tag') : $istag );

				 	if( $autosubtitle != 'off' ) {
						$subtitletext = pl_setting('pagetitle_special_tag_sub') ? pl_setting('pagetitle_special_tag_sub') : $istagsub;
							$subtitletext = sprintf( '<span class="pagetitle-numposts">%s</span> <span class="pagetitle-nameofposts">%s</span> <span class="pagetitle-subtitlecustomizable">%s</span> <span class="pagetitle-singletag">%s%s%s</span>', $numposts, $nameofposts, $subtitletext, $subtitlebefore, single_tag_title( '', false ), $subtitleafter );
					}
				} elseif( is_tax() ) {
					global $post;
					$postid = $post->ID;

					// get post format
					$format = get_post_format($postid);
					if ( false === $format ) {
						$format = 'standard';
					}

					//http://justintadlock.com/archives/2009/06/04/using-custom-taxonomies-to-create-a-movie-database -- To get the proper name of the taxonomy term (usually the archive page title), use this code:
					$term = get_term_by( 'slug', get_query_var( 'term' ), get_query_var( 'taxonomy' ) );
					$tax = $term->name;

				 	if( ! $titletext ) {
				 		$titletext = pl_setting('pagetitle_special_tax') ? pl_setting('pagetitle_special_tax') : $istax;
					 		//if
						 	$titletext = $titletext ? sprintf( '%s %s', $tax, $titletext ): $titletext;
					}

					if( $autosubtitle != 'off' ) {
						$subtitletext = pl_setting('pagetitle_special_tax_sub') ? pl_setting('pagetitle_special_tax_sub') : $istaxsub;
							$subtitletext = sprintf( '<span class="pagetitle-numposts">%s</span> <span class="pagetitle-nameofposts">%s</span> <span class="pagetitle-subtitlecustomizable">%s</span>', $numposts, $nameofposts, $subtitletext );
					}



				 	$titletext = $titletext ? $titletext : ( pl_setting('pagetitle_special_tax') ? pl_setting('pagetitle_special_tax') : 'Tag' );

				}

				elseif ( is_day() ) {
				 	if( ! $titletext ) {
				 		$titletext = pl_setting('pagetitle_special_archive_daily') ? pl_setting('pagetitle_special_archive_daily') : $isday;
					 		//if
						 	$titletext = $titletext ? sprintf( '%s %s', $titletext, get_the_time('l, F j, Y') ): $titletext;
					}

					if( $autosubtitle != 'off' ) {
						$subtitletext = pl_setting('pagetitle_special_archive_daily_sub') ? pl_setting('pagetitle_special_archive_daily_sub') : $isdaysub;
							$subtitletext = sprintf( '<span class="pagetitle-numposts">%s</span> <span class="pagetitle-nameofposts">%s</span> <span class="pagetitle-subtitlecustomizable">%s</span>', $numposts, $nameofposts, $subtitletext );
					}
				} elseif ( is_month() ) {
				 	if( ! $titletext ) {
					 	$titletext = pl_setting('pagetitle_special_archive_monthly') ? pl_setting('pagetitle_special_archive_monthly') : $ismonth;
					 		//if
						 	$titletext = $titletext ? sprintf( '%s %s', $titletext, get_the_time('F Y') ) : $titletext;
					}

				 	if( $autosubtitle != 'off' ) {
						$subtitletext = pl_setting('pagetitle_special_archive_monthly_sub') ? pl_setting('pagetitle_special_archive_monthly_sub') : $ismonthsub;
							$subtitletext = sprintf( '<span class="pagetitle-numposts">%s</span> <span class="pagetitle-nameofposts">%s</span> <span class="pagetitle-subtitlecustomizable">%s</span>', $numposts, $nameofposts, $subtitletext );
					}
				} elseif ( is_year() ) {
				 	if( ! $titletext ) {
					 	$titletext = pl_setting('pagetitle_special_archive_yearly') ? pl_setting('pagetitle_special_archive_yearly') : $isyear;
					 		//if
						 	$titletext = $titletext ? sprintf( '%s %s', $titletext, get_the_time('Y') ) : $titletext;
					}

					if( $autosubtitle != 'off' ) {
						$subtitletext = pl_setting('pagetitle_special_archive_yearly_sub') ? pl_setting('pagetitle_special_archive_yearly_sub') : $isyearsub;
							$subtitletext = sprintf( '<span class="pagetitle-numposts">%s</span> <span class="pagetitle-nameofposts">%s</span> <span class="pagetitle-subtitlecustomizable">%s</span>', $numposts, $nameofposts, $subtitletext );
					}
				} else {

					if ( is_post_type_archive() ) {
					 	if( ! $titletext ) {
						 	$titletext = pl_setting('pagetitle_special_archive_other') ? pl_setting('pagetitle_special_archive_other') : $isposttypearchive;
								$titletext = sprintf( '%s %s', post_type_archive_title( '', false ), $titletext );
						}

						if( $autosubtitle != 'off' ) {
							$subtitletext = pl_setting('pagetitle_special_archive_other_sub') ? pl_setting('pagetitle_special_archive_other_sub') : $isposttypearchivesub;
							$subtitletext = sprintf( '<span class="pagetitle-numposts">%s</span> <span class="pagetitle-nameofposts">%s</span> <span class="pagetitle-subtitlecustomizable">%s</span>', $numposts, $nameofposts, $subtitletext );
						}
					}

					if( ! $titletext ) {
						$o = get_queried_object();
						if ( isset( $o->name ) ) {
							$titletext = $o->name;
								//$titletext = sprintf( '%s Archive', $titletext );

							if( $autosubtitle != 'off' ) {
									$subtitletext = pl_setting('pagetitle_special_archive_other_sub') ? pl_setting('pagetitle_special_archive_other_sub') : $othersub;
								$subtitletext = sprintf( '<span class="pagetitle-numposts">%s</span> <span class="pagetitle-nameofposts">%s</span> <span class="pagetitle-subtitlecustomizable">%s</span>', $numposts, $nameofposts, $subtitletext );
							}
						}
					}

				 	if( ! $titletext ) {
					 	$titletext = pl_setting('pagetitle_special_archive_other') ? pl_setting('pagetitle_special_archive_other') : $other;
							$titletext = sprintf( '%s %s', the_date(), $titletext );

						if( $autosubtitle != 'off' ) {
							$subtitletext = pl_setting('pagetitle_special_archive_other_sub') ? pl_setting('pagetitle_special_archive_other_sub') : $othersub;
							$subtitletext = sprintf( '<span class="pagetitle-numposts">%s</span> <span class="pagetitle-nameofposts">%s</span> <span class="pagetitle-subtitlecustomizable">%s</span>', $numposts, $nameofposts, $subtitletext );
						}
					}

				}

			} elseif( is_404() ) {
				$titletext = $titletext ? $titletext : ( pl_setting('pagetitle_special_404') ? pl_setting('pagetitle_special_404') : $is404 );

				if( $autosubtitle != 'off' ) {
					$subtitletext = pl_setting('pagetitle_special_404_sub') ? pl_setting('pagetitle_special_404_sub') : $is404sub;
				}
			} else {
				$titletext = '';
				$subtitletext = '';
			}
		}

		$titletext = $titletext ? do_shortcode($titletext) : '';
		$subtitletext = $subtitletext ? do_shortcode($subtitletext) : '';

		// IF NO TITLES
		if(!$titletext && !$subtitletext){
			$user = wp_get_current_user();
			if( user_can( $user, 'edit_posts') ){
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
		$title = $titletext ? sprintf( '<%s class="pagetitle-titleline %s" style="%s">%s</%s>', $titletag, $titleclass, $titlesize, $titletext, $titletag ) : '';


		// Subtitle Setup
		$subtitletag = pl_setting('pagetitle_tag_subtitle') ? pl_setting('pagetitle_tag_subtitle') : 'p';
			$subtitletag = $this->opt('pagetitle_tag_subtitle') ? $this->opt('pagetitle_tag_subtitle') : $subtitletag;

		$subtitleclass = pl_setting('pagetitle_title_class_subtitle') ? pl_setting('pagetitle_title_class_subtitle') : '';
			$subtitleclass = $this->opt('pagetitle_title_class_subtitle') ? $this->opt('pagetitle_title_class_subtitle') : $subtitleclass;

		$subtitlesize = pl_setting('pagetitle_font_size_subtitle') ? sprintf('font-size: %spx;', pl_setting('pagetitle_font_size_subtitle')) : '';
			$subtitlesize = $this->opt('pagetitle_font_size_subtitle') ? sprintf('font-size: %spx;', $this->opt('pagetitle_font_size_subtitle')) : $subtitlesize;


		// SUBTITLE LINE
		$subtitle = $subtitletext ? sprintf('<%s class="pagetitle-subtitleline %s" style="%s">%s</%s>', $subtitletag, $subtitleclass, $subtitlesize, $subtitletext, $subtitletag) : '';


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