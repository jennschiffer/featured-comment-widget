<?php
/*
Plugin Name: Featured Comment Widget
Plugin URI: http://github.com/jennschiffer/featured-comment-widget
Description: A widget that allows you to showcase any comment(s) that has been published on your site. All you need to do is enter the comment's ID (or multiple comma-delimited IDs) in the widget form.
Version: 1.7
Author: Jenn Schiffer
Author URI: http://jennmoney.biz

Copyright 2013  Jenn Schiffer  (http://jennmoney.biz)

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

add_action('widgets_init', 'featured_comment_widget_init', 1);
function featured_comment_widget_init() {
  register_widget('Featured_Comment_Widget');
  load_plugin_textdomain('featured-comment-widget', false, basename( dirname( __FILE__ ) ) . '/languages' );
}

add_action('wp_head', 'featured_comment_css');
function featured_comment_css() {
  echo '<style type="text/css">
    .featuredComment-comment { margin: 20px auto; }
    .featuredComment-comment-content { margin: 3px auto 5px;}
    .featuredComment-cite { display: block; text-align: left; line-height: 1em;}
    .featuredComment-cite:after { content: "."; display: block; height: 0; clear: both; visibility: hidden; }
      .featuredComment-gravatar {float: right; padding: 0px 5px;}
      .featuredComment-author {float: right;}
    .featuredComment-pager { }
    .featuredComment-next { padding: 5px; }
    .featuredComment-prev { padding: 5px; }
    </style>';
}

class Featured_Comment_Widget extends WP_Widget {

  public function __construct() {
    $widget_ops = array('classname' => 'featured_comment_widget', 'description' => __('Enter a comment\'s ID (or multiple comma-delimited IDs) to feature it on your sidebar.','featured-comment-widget'));
    parent::__construct('featuredComment', __('Featured Comment'), $widget_ops);
  }

  public function widget($args, $instance) {
    extract($args);
    $title = apply_filters('widget_title', $instance['title']);
    $commentID = apply_filters( 'widget_commentID', empty($instance['commentID']) ? '2' : $instance['commentID'], $instance, $this->id_base);
    $gravatarSize = apply_filters( 'widget_gravatarSize', empty($instance['gravatarSize']) ? '25' : $instance['gravatarSize'], $instance, $this->id_base);
    $excerptSize = apply_filters( 'widget_excerptSize', empty($instance['excerptSize']) ? '' : $instance['excerptSize'], $instance, $this->id_base);
    
    echo $before_widget;
    
    // title of widget
    if ( !empty( $title ) ) { 
      echo $before_title . $title . $after_title; 
    }
    else { 
      echo $before_title . '' . $after_title; 
    } 
    
    // create array of all comment IDs split by commas
    $commentIDArray = explode(",", $commentID);
 
    // for each item in comment array, display featured comment
    foreach ($commentIDArray as $singleCommentID) {
    
      $trimmedSingleCommentId = trim($singleCommentID);
      $featuredComment = get_comment($trimmedSingleCommentId);
      
      if ($featuredComment) {
  
        if ($featuredComment->comment_author) {
          $featuredCommentName = $featuredComment->comment_author;
        }
        else {
          $featuredCommentName = _e('Anonymous','featured-comment-widget');
        }
        
        $featuredCommentEmail = $featuredComment->comment_author_email;
        $featuredCommentContent = $featuredComment->comment_content;
        $featuredCommentPostID = $featuredComment->comment_post_ID;
        $featuredCommentURL = get_permalink($featuredCommentPostID).'#comment-'.$singleCommentID;
        $featuredCommentByline = __('Posted by') . '<br />' . $featuredCommentName;
        
        if ( function_exists('mb_strlen') && function_exists('mb_substr') ) {
          
          if ( $excerptSize != '' ) { 
              if (mb_strlen($featuredCommentContent) > $length) { 
                $featuredCommentContent = mb_substr($featuredCommentContent,0,$excerptSize).' [<a href="'.$featuredCommentURL.'">...</a>]';
              }  
          }
          
        }
        
        echo '<div class="featuredComment-comment">';
          echo '<div class="featuredComment-comment-content">'. $featuredCommentContent . '</div>';
    
          echo '<div class="featuredComment-cite">';
            echo '<span class="featuredComment-author"><a href="' . $featuredCommentURL . '">' . $featuredCommentByline . '</a></span>';
            echo '<span class="featuredComment-gravatar"><a href="' . $featuredCommentURL . '">' . get_avatar($featuredCommentEmail, $gravatarSize) . '</a></span>';
          echo '</div>';
          
        echo '</div>'; // end comment block
      
      }// end if comment exists
  
    }// end for each item in comment array
  
    echo $after_widget;
  }

  public function form( $instance ) {
    $instance = wp_parse_args( (array) $instance, array( 'commentID' => '', 'gravatarSize' => '', 'title' => '', 'excerptSize' => '') );
    $title = strip_tags($instance['title']);
    $commentID = strip_tags($instance['commentID']);
    $gravatarSize = strip_tags($instance['gravatarSize']);
    $excerptSize = strip_tags($instance['excerptSize']);
  ?>
    <p><label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Widget Title','featured-comment-widget'); ?>:</label>
    <input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo esc_attr($title); ?>" /></p>
    <p><label for="<?php echo $this->get_field_id('commentID'); ?>"><?php _e('Comment ID','featured-comment-widget') ?><br /><em>(<?php _e('or multiple comma-delimited IDs - eg: 522, 521, 7','featured-comment-widget'); ?>)</em>:</label>
    <input class="widefat" id="<?php echo $this->get_field_id('commentID'); ?>" name="<?php echo $this->get_field_name('commentID'); ?>" type="text" value="<?php echo esc_attr($commentID); ?>" /></p>
    <p><label for="<?php echo $this->get_field_id('gravatarSize'); ?>"><?php _e('Gravatar width in pixels','featured-comment-widget'); ?><br /><em>(<?php _e('leaving blank defaults to 25','featured-comment-widget'); ?>)</em>:</label>
    <input class="widefat" id="<?php echo $this->get_field_id('gravatarSize'); ?>" name="<?php echo $this->get_field_name('gravatarSize'); ?>" type="text" value="<?php echo esc_attr($gravatarSize); ?>" /></p>
    
    <?php if ( function_exists('mb_strlen') && function_exists('mb_substr') ) { ?>
        
      <p><label for="<?php echo $this->get_field_id('excerptSize'); ?>"><?php _e('Comment excerpt size in characters','featured-comment-widget'); ?><br /><em>(<?php _e('leave blank to NOT excerpt comment content','featured-comment-widget'); ?>)</em>:</label>
      <input class="widefat" id="<?php echo $this->get_field_id('excerptSize'); ?>" name="<?php echo $this->get_field_name('excerptSize'); ?>" type="text" value="<?php echo esc_attr($excerptSize); ?>" /></p>
    
    <?php }
        else {
          echo '<p>The functions required for excerpting comments do not exist on your site. Ask your host to enable <em>mbstring</em> on your server&apos;s PHP configuration.</p>';
        }
    ?>
    
  <?php
  }
  
  public function update( $new_instance, $old_instance ) {
    $instance = $old_instance;
    $instance['title'] = strip_tags($new_instance['title']);
    $instance['commentID'] = strip_tags($new_instance['commentID']);
    $instance['gravatarSize'] = strip_tags($new_instance['gravatarSize']);
    $instance['excerptSize'] = strip_tags($new_instance['excerptSize']);
    return $instance;
  }
  
}
?>