<?php
/*
Plugin Name: anp_popular_post
Plugin URI: http://www.anpstudio.com/blog/2012/04/02/cw-author-info-nuevo-plugin-para-mostrar-informacion-de-los-redactores-de-un-blog/ 
Description: 
Author: antocara
Version: 1.0
Author URI: http://www.anpstudio.com
*/
/*
Copyright 2012  Antonio Carabantes(Email : antocara@gmail.com)

This program is free software: you can redistribute it and/or modify

it under the terms of the GNU General Public License as published by

the Free Software Foundation, either version 3 of the License, or

(at your option) any later version.

This program is distributed in the hope that it will be useful,

but WITHOUT ANY WARRANTY; without even the implied warranty of

MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the

GNU General Public License for more details.

You should have received a copy of the GNU General Public License

along with this program.  If not, see <http://www.gnu.org/licenses/>.

*/
?>
<?php
/**
 * 
 * Creamos un widget
 *
 **/		
class anp_popular_post_widget extends WP_Widget {

	public function __construct() {
			parent::__construct(
		 		'anp_post_popular_post', // Base ID
				'anp Popular Post', // Name
				array( 'description' => __( 'Muestra un listado de post más comentados', 'anp_text_popular_post' ), ) // Args
			);
		}
	/**
	 * Front-end  widget.
	 *
	 */
	public function widget( $args, $instance ) {
			extract( $args );
			$title = apply_filters( 'widget_title', $instance['title'] );
			global $post, $wpdb;
	
			echo $before_widget;
			if ( ! empty( $title ) )
						echo $before_title . $title . $after_title;
			?>
				<ul class="num_post_list">
					<?php 
						$result = $wpdb->get_results("SELECT comment_count,ID,post_title FROM $wpdb->posts ORDER BY comment_count DESC LIMIT 0 , 5");
						$post_nu_clas=1;
					foreach ($result as $post) {
						setup_postdata($post);
						$postid = $post->ID;
						$title = $post->post_title;
						$commentcount = $post->comment_count;
						
						if ($commentcount != 0) { ?>
								
						   	 <li class="post <?php echo 'a'.$post_nu_clas;?>">
						   	 	 <div class="num_com"> <?php echo	$commentcount ?></div>
						   	 	<a href="<?php echo get_permalink($postid); ?>" title="<?php echo $title ?>"><?php echo $title ?></a>
						   	 </li>
						   	 
						<?php $post_nu_clas++;
						} 
					} ;?>
				</ul>
				<?php 
				
			echo $after_widget;
		}
	/**
     * Sanitize widget form values as they are saved.
	 *
	 */
	public function update($new_instance, $old_instance){
		$instance = array();
				$instance['title'] = strip_tags( $new_instance['title'] );
		
				return $instance;
		
	}
	/**
	 * backend widget
	 *
	 */ 
	public function form($instance){
		
				if ( isset( $instance[ 'title' ] ) ) {
						$title = $instance[ 'title' ];
					}else {
						$title = __( 'New title', 'anp_text_popular_post' );
				}
				?>
				<p>
				<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title:' ); ?></label> 
				<input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>" />
				</p>
				<?php 
			}

}


function registro_anp_popular_post()
{
	register_widget('anp_popular_post_widget');
}
add_action('widgets_init', 'registro_anp_popular_post');

/**
 *
 * Cargo hoja de stilos para el widget
 *
 */

function anp_popular_post_estilos() { 
	 // añado al head hoja de estilos para shortcode  
     wp_register_style( 'anp_estilos', plugins_url() . '/anp_popular_post/css/anp_popular_post.css' );  
     wp_enqueue_style( 'anp_estilos' ); 
       
 } 
 add_action('wp_head', 'anp_popular_post_estilos');
?>
