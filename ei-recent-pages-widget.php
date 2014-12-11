<?php
/*
Plugin Name: Recent Pages Widget
Plugin URI: https://github.com/enricator/ei-recent-pages-widget
Description: A very simple widget that shows recent pages as a list.
Version: 0.0.2
Author: Enrico Imbalzano
Author URI: http://www.enricator.it
License: GPLv2 or later
*/

/**  Copyright 2014  Enrico Imbalzano  (email : enrico.i69@gmail.com)
 *
 *  This simple widget shows a list of the most recent pages
 * 
 *  This program is free software; you can redistribute it and/or modify
 *  it under the terms of the GNU General Public License, version 2, as
 *  published by the Free Software Foundation.
 * 
 *  This program is distributed in the hope that it will be useful,
 *  but WITHOUT ANY WARRANTY; without even the implied warranty of
 *  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 *  GNU General Public License for more details.
 *  http://www.gnu.org/licenses/gpl.html
 */

/* Disallow direct access to the plugin file */
defined('ABSPATH') or die("Spiacente, ma questa pagina non è accessibile direttamente");

if ( ! class_exists( 'ei_Recent_Pages_Widget' ) ) {
	class ei_Recent_Pages_Widget extends WP_Widget {

		/**
		 * List of settings displayed on the admin settings page.
		 * @var array
		 */
		protected $settings = array(
			'numRecPages' => array(
				'description' => 'Numero di pagine recenti da visualizzare.',
				'validator' => 'numeric',
				'placeholder' => 5,
				'default' => 5
			)
		);
		
	    function ei_recent_pages_widget() {
	        parent::__construct( false, 'ei Recent Pages Widget' );
			
			//if ( is_admin() ) {
			//	add_action( 'admin_init', array( &$this, 'settings' ) );
			//}
	    }
	    
	    function widget( $args, $instance ) {
	        extract($args);
	        echo $before_widget;
	        echo $before_title.$instance['title'].$after_title;
	 
	        //DA QUI INIZIA IL WIDGET VERO E PROPRIO
		    $bShowDate = false;
			?>
			<div class="paginerecenti">
			  <?php 
				   $args=array(
				   'showposts'=> 5,
				   'post_type' => 'page',
				   'caller_get_posts'=> 1
				   );
				$my_query = new WP_Query($args);
				if( $my_query->have_posts() ) : ?>
			  	  <ul> <?php
					  while ($my_query->have_posts()) : $my_query->the_post(); ?>
					    <li> <?php
						  if ($bShowDate) { ?>
						  	<small><?php the_time('d.m.y') ?></small> <?php
						  } ?>
						  <a href="<?php the_permalink() ?>" rel="bookmark" title="Permanent Link to <?php the_title_attribute(); ?>"><?php the_title(); ?></a></li>
					    <?php
					  endwhile; ?>
				  </ul> 
				<?php endif; ?>
			</div>
			
		    <?php
			//FINE WIDGET
	 
	        echo $after_widget;
	    }
	    function update( $new_instance, $old_instance ) {
	        return $new_instance;
	    }
	    function form( $instance ) {
	        $title = esc_attr($instance['title']); ?>
	        <p><label for="<?php echo $this->get_field_id('title');?>">
	        Titolo: <input class="widefat" id="<?php echo $this->get_field_id('title');?>" name="<?php echo $this->get_field_name('title');?>" type="text" value="<?php echo $title; ?>" />
	        </label></p>
	        <?php
	    }
	}
}

if(class_exists('ei_Recent_Pages_Widget')) {
	add_action('widgets_init', create_function('', 'return register_widget("ei_Recent_Pages_Widget");'));
}
?>