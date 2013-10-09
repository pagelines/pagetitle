<?php
/*
Section: PageTitle
Author: TourKick (Clifford P)
Author URI: http://tourkick.com/?utm_source=pagelines&utm_medium=section&utm_content=authoruri&utm_campaign=pagetitle_section
Description: Display PageLines DMS Page Titles automatically, with optional manual override per-page (global and per-page settings). Includes animation, font-size, and other customizations. Even has a subtitle area. Auto titles, manual titles, and subtitles all support shortcodes.
Demo: http://www.pagelinestheme.com/pagetitle-section?utm_source=pagelines&utm_medium=section&utm_content=demolink&utm_campaign=pagetitle_section
Version: 1.0
Class Name: DMSPageTitle
Filter: component
Cloning: true
v3: true
Loading: active
*/

class DMSPageTitle extends PageLinesSection {

/*
Possible to-do's:
- add how-to area to section's settings -- including saving over default template (or create a template and then select Set As Page Global Default)
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
						'default'		=> 'auto',
						'help' 	=> __( 'Manual Titles, if entered, always override Auto Titles.', $this->id ),
						'opts'			=> array(
							'auto'		=> array('name' => 'Auto Title (Default)'),
							'manual'		=> array('name' => 'Manual Input Only'),
						)
					),
					array(
						'type' 			=> 'text',
						'key'			=> 'pagetitle_global_class',
						'help' 	=> __( 'Insert a CSS Class (separate multiple with a space) for the entire title and subtitle div. A global alternative to using the Standard Options -> Styling Classes to add custom classes to every post individually, although that still works too and is applied at a higher-level (i.e. before this div class).', $this->id ),
						'label' 		=> __( 'PageTitle Global Class (Optional)', $this->id ),
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
						'default'		=> 'h1',
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
						'help' 	=> __( 'Insert a CSS Class (separate multiple with a space) just to the Heading HTML Tag (e.g. h1 class="..."). Use the Standard Options -> Styling Classes to add custom classes to the entire section.', $this->id ),
						'label' 		=> __( 'Page Title Heading Tag Class (Optional)', $this->id ),
					),
					array(
						'key'			=> 'pagetitle_font_size',
						'type'			=> 'count_select',
						'count_start'	=> 10,
						'count_number'	=> 60,
						'suffix'		=> 'px',
						'title'			=> __( 'Page Title Font Size', $this->id ),
						'default'		=> '',
					),
					array(
						'type' 			=> 'select',
						'key'			=> 'pagetitle_tag_subtitle',
						'label' 		=> 'Subtitle HTML Tag',
						'help' 			=> __( 'It is always recommended to only have one H1 tag per page.', $this->id ),
						'default'		=> 'p',
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
						'help' 	=> __( 'Insert a CSS Class (separate multiple with a space) just to the Subtitle HTML Tag (e.g. p class="...").', $this->id ),
						'label' 		=> __( 'Subtitle Heading Tag Class (Optional)', $this->id ),
					),
					array(
						'key'			=> 'pagetitle_font_size_subtitle',
						'type'			=> 'count_select',
						'count_start'	=> 10,
						'count_number'	=> 60,
						'suffix'		=> 'px',
						'title'			=> __( 'Subtitle Font Size', $this->id ),
						'default'		=> '',
					),
					array(
						'type' 			=> 'select',
						'key'			=> 'pagetitle_align',
						'label' 		=> 'Alignment',
						'default'		=> 'textleft',
						'opts'			=> array(
							'textleft'		=> array('name' => 'Align Left (Default)'),
							'textright'		=> array('name' => 'Align Right'),
							'textcenter'	=> array('name' => 'Center'),
							'textjustify'	=> array('name' => 'Justify'),
						)
					),
					array(
						'type' 			=> 'select_animation',
						'key'			=> 'pagetitle_animation',
						'label' 		=> __( 'Viewport Animation', $this->id ),
						'default'		=> 'no-anim',
						'help' 			=> __( 'Optionally animate the appearance of this section on view.', $this->id ),
					),
					array(
						'key'			=> 'pagetitle_pad',
						'type' 			=> 'text',
						'label' 	=> __( 'Padding (use CSS Shorthand)', $this->id ),
						'help'		=> __( 'This option uses CSS padding shorthand. For example, use "15px 30px" for 15px padding top/bottom, and 30 left/right.', $this->id ),

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
						'help' 	=> __( 'Manual Titles, if entered, always override Auto Titles.', $this->id ),
						'opts'			=> array(
							'auto'		=> array('name' => 'Auto Title (Default)'),
							'manual'		=> array('name' => 'Manual Input Only'),
						)
					),
					array(
						'type' 			=> 'text',
						'key'			=> 'pagetitle_title_manual',
						'help' 	=> __( 'If entered, will override Auto Title.<br/>If no Auto Title and nothing entered here, no title will be displayed. Shortcodes work too!', $this->id ),
						'label' 		=> __( 'Manual Title (Optional)', $this->id ),
					),
					array(
						'type' 			=> 'textarea',
						'key'			=> 'pagetitle_subtitle',
						'label' 		=> __( 'Subtitle (Optional)', $this->id ),
						'help' 	=> __( 'Smaller text displayed below the Page Title (never auto-generated). Shortcodes work too!', $this->id ),
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
						'help' 	=> __( 'Insert a CSS Class (separate multiple with a space) just to the Heading HTML Tag (e.g. h1 class="..."). Use the Standard Options -> Styling Classes to add custom classes to the entire section.', $this->id ),
						'label' 		=> __( 'Page Title Heading Tag Class (Optional)', $this->id ),
					),
					array(
						'key'			=> 'pagetitle_font_size',
						'type'			=> 'count_select',
						'count_start'	=> 10,
						'count_number'	=> 60,
						'suffix'		=> 'px',
						'title'			=> __( 'Page Title Font Size', $this->id ),
						'default'		=> '',
					),
					array(
						'type' 			=> 'select',
						'key'			=> 'pagetitle_tag_subtitle',
						'label' 		=> 'Subtitle HTML Tag',
						'help' 			=> __( 'It is always recommended to only have one H1 tag per page.', $this->id ),
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
						'help' 	=> __( 'Insert a CSS Class (separate multiple with a space) just to the Subtitle HTML Tag (e.g. p class="...").', $this->id ),
						'label' 		=> __( 'Subtitle Heading Tag Class (Optional)', $this->id ),
					),
					array(
						'key'			=> 'pagetitle_font_size_subtitle',
						'type'			=> 'count_select',
						'count_start'	=> 10,
						'count_number'	=> 60,
						'suffix'		=> 'px',
						'title'			=> __( 'Subtitle Font Size', $this->id ),
						'default'		=> '',
					),
					array(
						'type' 			=> 'select',
						'key'			=> 'pagetitle_align',
						'label' 		=> 'Alignment',
						'default'		=> '',
						'opts'			=> array(
							'textleft'		=> array('name' => 'Align Left (Default)'),
							'textright'		=> array('name' => 'Align Right'),
							'textcenter'	=> array('name' => 'Center'),
							'textjustify'	=> array('name' => 'Justify'),
						)
					),
					array(
						'type' 			=> 'select_animation',
						'key'			=> 'pagetitle_animation',
						'label' 		=> __( 'Viewport Animation', $this->id ),
						'default'		=> '',
						'help' 			=> __( 'Optionally animate the appearance of this section on view.', $this->id ),
					),
					array(
						'key'			=> 'pagetitle_pad',
						'type' 			=> 'text',
						'label' 	=> __( 'Padding (use CSS Shorthand)', $this->id ),
						'help'		=> __( 'This option uses CSS padding shorthand. For example, use "15px 30px" for 15px padding top/bottom, and 30 left/right.', $this->id ),

					),

				)
			),



		);

		return $opts;

	}

	function section_template() {

		// Check for PageLines DMS
		if(function_exists('pl_has_editor') && pl_has_editor()){} else { return; };

		// Get Page ID
		global $post;
		$postid = $post->ID;

		// PAGE TITLE
		if($this->opt('pagetitle_title') == 'manual'){
			$autotitle = false;
		} else {
			$autotitle = true;
		}

		$manualtext = $this->opt('pagetitle_title_manual') ? $this->opt('pagetitle_title_manual') : '';

		if($manualtext){
			$titletext = $manualtext;
		} elseif ($autotitle){
			$titletext = get_the_title($postid);
		} else {
			$titletext = '';
		}

		$titletext = $titletext ? do_shortcode($titletext) : '';

		// SUBTITLE
		$subtitletext = $this->opt('pagetitle_subtitle');
		$subtitletext = do_shortcode($subtitletext);

		// IF NO TITLES
		if(!$titletext && !$subtitletext){
			if(current_user_can('edit_post', $postid)){
				echo do_shortcode('[pl_alertbox type="info" closable="yes"]No Page Title. It will not display unless you edit this Page to add one or you manually enter one via PageLines DMS Section.<br/><span data-tab-link="settings" data-stab-link="pagetitle" class="btn btn-edit pagetitle-edit"><i class="icon-pencil"></i></span>[/pl_alertbox]');
			} else {
				return;
			}
		}


		// Global div class
		$globalclass = $this->opt('pagetitle_global_class') ? $this->opt('pagetitle_global_class') : '';


		// Page Title Setup
		$titletag = $this->opt('pagetitle_tag') ? $this->opt('pagetitle_tag') : 'h1';

		$titleclass = $this->opt('pagetitle_title_class') ? $this->opt('pagetitle_title_class') : '';

		$titlesize = $this->opt('pagetitle_font_size') ? sprintf('font-size: %spx;', $this->opt('pagetitle_font_size')) : '';

		// TITLE LINE
		$title = $titletext ? sprintf( '<%s class="%s" style="%s">%s</%s>', $titletag, $titleclass, $titlesize, $titletext, $titletag ) : '';


		// Subtitle Setup
		$subtitletag = $this->opt('pagetitle_tag_subtitle') ? $this->opt('pagetitle_tag_subtitle') : 'p';

		$subtitleclass = $this->opt('pagetitle_title_class_subtitle') ? $this->opt('pagetitle_title_class_subtitle') : '';

		$subtitlesize = $this->opt('pagetitle_font_size_subtitle') ? sprintf('font-size: %spx;', $this->opt('pagetitle_font_size_subtitle')) : '';


		// SUBTITLE LINE
		$subtitle = $subtitletext ? sprintf('<%s class="%s" style="%s">%s</%s>', $subtitletag, $subtitleclass, $subtitlesize, $subtitletext, $subtitletag) : '';


		// Section Style Options
		$animationclass = $this->opt('pagetitle_animation');

		$align = $this->opt('pagetitle_align');

		$pad = $this->opt('pagetitle_pad') ? sprintf('padding: %s;', $this->opt('pagetitle_pad')) : '';


		// SECTION OUTPUT
		printf('<div class="post-title fix pagetitle-wrap pl-animation %s %s %s" style="%s">', $globalclass, $align, $animationclass, $pad); //post-title and fix are from DMS Core -- https://github.com/pagelines/DMS/blob/Dev/includes/class.posts.php#L293

		echo $title;

		if($subtitletext){
			echo $subtitle;
		}

		echo '</div>';

	}
}