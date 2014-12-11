<?php
/*
Plugin Name: Recent Pages Widget
Plugin URI: https://github.com/enricator/
Description: A very simple widget that shows recent pages as a list.
Version: 0.0.1
Author: Enrico Imbalzano
Author URI: http://www.enricator.it
License: GPLv2 or later
*/
/*  Copyright 2014  Enrico Imbalzano  (email : enrico.i69@gmail.com)

    This program is free software; you can redistribute it and/or modify
    it under the terms of the GNU General Public License, version 2, as 
    published by the Free Software Foundation.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program; if not, write to the Free Software
    Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
*/

/* Disallow direct access to the plugin file */
if (basename($_SERVER['PHP_SELF']) == basename (__FILE__)) {
	die('Spiacente, ma questa pagina non è accessibile.');
}

class eiRecentPagesWidget extends WP_Widget {
    function eiRecentPagesWidget() {
        parent::__construct( false, 'ei Recent Pages Widget' );
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
			   'showposts'=>5,
			   'post_type' => 'page',
			   'caller_get_posts'=>1
			   );
			$my_query = new WP_Query($args);
			if( $my_query->have_posts() ) { ?>
		  	  <ul> <?php
			  while ($my_query->have_posts()) : $my_query->the_post(); ?>
			    <li> <?php
				  if ($bShowDate) { ?>
				  	<small><?php the_time('d.m.y') ?></small> <?php
				  } ?>
				  <a href="<?php the_permalink() ?>" rel="bookmark" title="Permanent Link to <?php the_title_attribute(); ?>"><?php the_title(); ?></a></li>
			    <?php
			  endwhile;
				?> </ul> <?php
			}		  		 
		  ?>
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
 
add_action('widgets_init', create_function('', 'return register_widget("eiRecentPagesWidget");'));
?>