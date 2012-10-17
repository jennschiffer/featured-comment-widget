<?php
/*
Plugin Name: Featured Comment Widget
Plugin URI: http://pancaketheorem.com/featured-comment-widget
Description: A widget that allows you to showcase any comment that has been published on your site. All you need to do is enter the comment's ID in the widget form.
Version: 1.4
Author: Jenn Schiffer
Author URI: http://jennschiffer.com

Copyright 2011  Jenn Schiffer  (http://jennschiffer.com)

This program is free software; you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation; either version 2 of the License, or
(at your option) any later version.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with this program; if not, write to the Free Software
Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307  USA
*/

function featuredCommentWidget_init() {
	register_widget('featuredCommentWidget');
	load_plugin_textdomain('featured-comment-widget', false, basename( dirname( __FILE__ ) ) . '/languages' );
}

add_action('init', 'featuredCommentWidget_init', 1);

function featuredCommentCSS() {
	echo '<style type="text/css">
			.featuredComment-comment { margin: 3px auto 5px;}
			.featuredComment-cite { display: block; text-align: left; line-height: 1em;}
			.featuredComment-cite:after { content: "."; display: block; height: 0; clear: both; visibility: hidden; }
				.featuredComment-gravatar {float: right; padding: 0px 5px;}
				.featuredComment-author {float: right;}
		  </style>';
}

add_action('wp_head', 'featuredCommentCSS');

class featuredCommentWidget extends WP_Widget {

	function featuredCommentWidget() {
		$widget_ops = array('classname' => 'featured_comment_widget', 'description' => __('Enter a comment\'s ID to feature it on your sidebar.','featured-comment-widget'));
		$this->WP_Widget('featuredComment', __('Featured Comment'), $widget_ops);
	}

	function widget( $args, $instance ) {
		extract($args);
		$title = apply_filters('widget_title', $instance['title']);
		$commentID = apply_filters( 'widget_commentID', empty($instance['commentID']) ? '2' : $instance['commentID'], $instance, $this->id_base);
		$gravatarSize = apply_filters( 'widget_gravatarSize', empty($instance['gravatarSize']) ? '25' : $instance['gravatarSize'], $instance, $this->id_base);
		$excerptSize = apply_filters( 'widget_excerptSize', empty($instance['excerptSize']) ? '' : $instance['excerptSize'], $instance, $this->id_base);
		
		echo $before_widget;
		
		if ( !empty( $title ) ) { echo $before_title . $title . $after_title; }
		else { echo $before_title . '' . $after_title; } 
 
				$featuredComment = get_comment($commentID);
				$featuredCommentName = $featuredComment->comment_author;
				$featuredCommentEmail = $featuredComment->comment_author_email;
				$featuredCommentContent = $featuredComment->comment_content;
				$featuredCommentPostID = $featuredComment->comment_post_ID;
				$featuredCommentURL = get_permalink($featuredCommentPostID).'#comment-'.$commentID;
				$featuredCommentByline = __('Posted by') . '<br />' . $featuredCommentName;
				
				if ( function_exists('mb_strlen') && function_exists('mb_substr') ) {
					
					if ( $excerptSize != '' ) { 
					    if (mb_strlen($featuredCommentContent) > $length) { 
					    	$featuredCommentContent = mb_substr($featuredCommentContent,0,$excerptSize).' [<a href="'.$featuredCommentURL.'">...</a>]';
					    }	
					}
					
				}
			
				echo '<div class="featuredComment-comment">'. $featuredCommentContent . '</div>';
			?>
			
				<div class="featuredComment-cite">
					<span class="featuredComment-author"><a href="<?php echo $featuredCommentURL; ?>"><?php echo $featuredCommentByline; ?></a></span>
					<span class="featuredComment-gravatar"><a href="<?php echo $featuredCommentURL; ?>"><?php echo get_avatar($featuredCommentEmail, $gravatarSize); ?></a></span>
				</div>
			
	<?php
		echo $after_widget;
	}

	function update( $new_instance, $old_instance ) {
		$instance = $old_instance;
		$instance['title'] = strip_tags($new_instance['title']);
		$instance['commentID'] = strip_tags($new_instance['commentID']);
		$instance['gravatarSize'] = strip_tags($new_instance['gravatarSize']);
		$instance['excerptSize'] = strip_tags($new_instance['excerptSize']);
		return $instance;
	}

	function form( $instance ) {
		$instance = wp_parse_args( (array) $instance, array( 'commentID' => '', 'gravatarSize' => '', 'title' => '') );
		$title = strip_tags($instance['title']);
		$commentID = strip_tags($instance['commentID']);
		$gravatarSize = strip_tags($instance['gravatarSize']);
		$excerptSize = strip_tags($instance['excerptSize']);
	?>
		<p><lable for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Widget Title','featured-comment-widget'); ?>:</label>
		<input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo esc_attr($title); ?>" /></p>
		<p><label for="<?php echo $this->get_field_id('commentID'); ?>"><?php _e('Comment ID','featured-comment-widget'); ?>:</label>
		<input class="widefat" id="<?php echo $this->get_field_id('commentID'); ?>" name="<?php echo $this->get_field_name('commentID'); ?>" type="text" value="<?php echo esc_attr($commentID); ?>" /></p>
		<p><label for="<?php echo $this->get_field_id('gravatarSize'); ?>"><?php _e('Gravatar width in pixels','featured-comment-widget'); ?><br />(<em><?php _e('leaving blank defaults to 25','featured-comment-widget'); ?></em>):</label>
		<input class="widefat" id="<?php echo $this->get_field_id('gravatarSize'); ?>" name="<?php echo $this->get_field_name('gravatarSize'); ?>" type="text" value="<?php echo esc_attr($gravatarSize); ?>" /></p>
		
		<?php if ( function_exists('mb_strlen') && function_exists('mb_substr') ) { ?>
				
			<p><label for="<?php echo $this->get_field_id('excerptSize'); ?>"><?php _e('Comment excerpt size in characters','featured-comment-widget'); ?><br />(<em><?php _e('leave blank to NOT excerpt comment content','featured-comment-widget'); ?></em>)</label>
			<input class="widefat" id="<?php echo $this->get_field_id('excerptSize'); ?>" name="<?php echo $this->get_field_name('excerptSize'); ?>" type="text" value="<?php echo esc_attr($excerptSize); ?>" /></p>
		
		<?php }
			  else {
				  echo '<p>The functions required for excerpting comments do not exist on your site. Ask your host to enable <em>mbstring</em> on your server&apos;s PHP configuration.</p>';
			  }
		?>
		
	<?php
	}
	
}
?>