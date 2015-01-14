<?php 
/*
Plugin Name: HC Facebook Like Widget
Description: Facebook like widget plugin
Plugin URI: http://jeweltheme.com/product/facebook-like-widget-plugin
Author: Liton Arefin
Version: 1.0.1
Author URI: http://www.jeweltheme.com
License: GPL2
http://www.gnu.org/licenses/gpl-2.0.html
*/
add_action('widgets_init','JewelTheme_Facebook_like_register');
function JewelTheme_Facebook_like_register(){
	register_widget( 'JewelTheme_Facebook_like' );
}
class JewelTheme_Facebook_like extends WP_Widget{

	/*
	* Register WordPress Widget
	*/

	private $widget_title = "Like Us";
	private $facebook_id = "244325275637598";
	private $facebook_username = "h2cweb.net";
	private $facebook_width = "240";
	private $facebook_show_faces = "true";
	private	$facebook_show_stream = "false";
	private	$facebook_show_header = "true";
	private $facebook_border_color = "#FFF";
 	

	public function __construct(){
		parent::__construct(
			'h2cweb_widget',
			'HC Facebook Like',
			array(
				'classname'   => __('h2cweb_widget'),
				'description' => __('Facebook Like Widget')
				)
			);
	}

	/*
	* Front end Display of widgets
	* @see WP_Widget::widget()
	*
	* @param array $args Widget arguments
	* @param array $instance Saved values from Database
	*/

	public function widget( $args, $instance ) {
		extract( $args );
		/* Variables from the widget settings */
		$this->widget_title = apply_filters( 'widget_title', $instance['title'] );

		$this->facebook_id = $instance['app_id'];
		$this->facebook_username = $instance['page_name'];
		$this->facebook_width = $instance['width'];
		$this->facebook_show_faces = ($instance['show_faces'] == "1"? "true" : "false");
		$this->facebook_show_stream = ($instance['show_stream'] == "1"? "true": "false");
		$this->facebook_show_header = ($instance['show_header'] == "1"? "true": "false");
		$this->facebook_border_color = $instance['border_color'];

		add_action( 'wp_footer', array(&$this, 'h2cweb_add_js') );
		
		/* Display the widget title if one was input (before and after defined by the theme) */
		echo $before_widget;

		if( $this->widget_title)
			echo $this->widget_title;

		/* Like Box */
		?>	
			<div class = "fb-like-box"
				data-href = "http://www.facebook.com/<?php echo $this->facebook_username;?>"
				data-width = "<?php echo $this->facebook_width;?>"
				data-show-faces = "<?php echo $this->facebook_show_faces;?>"
				data-stream = "<?php echo $this->facebook_show_stream;?>"
				data-header = "<?php echo $this->facebook_show_header;?>" 
				data-border-color="<?php echo $this->facebook_border_color; ?>"
				>
			</div>

		<?php
		echo $after_widget;
	}

	/* Add Facebook Javascripts */ 

	public function h2cweb_add_js(){
		   echo '<div id="fb-root"></div> 
        <script>(function(d, s, id) { 
            var js, fjs = d.getElementsByTagName(s)[0]; 
            if (d.getElementById(id)) return; 
            js = d.createElement(s); js.id = id; 
            js.src = "//connect.facebook.net/en_GB/all.js#xfbml=1&appId='.$this->facebook_id.'"; 
            fjs.parentNode.insertBefore(js, fjs); 
        }(document, \'script\', \'facebook-jssdk\'));</script>';
	}



	/*
	* Sanitize data from values as they are saved
	* @see WP_Widget::update();
	*/

	public function update( $new_instance, $old_instance ){
		$instance = $old_instance;

		/* Strip tags for title and name to remove HTML (important for text inputs) */
		$instance['title'] = strip_tags( $new_instance['title'] );
		$instance['app_id'] = strip_tags( $new_instance['app_id'] );
		$instance['page_name'] = strip_tags( $new_instance['page_name'] );
		$instance['width'] = strip_tags( $new_instance['width'] );
		
		$instance['border_color'] = strip_tags( $new_instance['border_color'] );
		
		$instance['show_faces'] = (bool)$new_instance['show_faces'];
		$instance['show_stream'] = (bool)$new_instance['show_stream'];
		$instance['show_header'] = (bool)$new_instance['show_header'];

		return $instance;
	}

	/*
	* Back end widget Form
	*/

	public function form( $instance ){
			//$title = $instance['title'];
			$defaults = array(
			//	'title' => $this->widget_title,
				'app_id' => $this->facebook_id,
				'page_name' => $this->facebook_username,
				'width' => $this->facebook_width,
				'show_faces' => $this->facebook_show_faces,
				'show_stream' => $this->facebook_show_stream,
				'show_header' => $this->facebook_show_header
			);

		$instance = wp_parse_args( (array) $instance, $defaults ); ?>

		<!-- Widget Title: Text Input -->
		<p>
			<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e('Title:', 'h2cweb_fblike') ?></label>
			<input type="text" class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" value="<?php echo $instance['title']; ?>" />
		</p>

		<!-- App id: Text Input -->
		<p>
			<label for="<?php echo $this->get_field_id( 'app_id' ); ?>"><?php _e('App Id', 'h2cweb_fblike') ?></label>
			<input type="text" class="widefat" id="<?php echo $this->get_field_id( 'app_id' ); ?>" name="<?php echo $this->get_field_name( 'app_id' ); ?>" value="<?php echo $instance['app_id']; ?>" />
		</p>		

		<!-- Facebook id: Text Input -->
		<p>
			<label for="<?php echo $this->get_field_id( 'page_name' ); ?>"><?php _e('Facebook Id', 'h2cweb_fblike') ?></label>
			<input type="text" class="widefat" id="<?php echo $this->get_field_id( 'page_name' ); ?>" name="<?php echo $this->get_field_name( 'page_name' ); ?>" value="<?php echo $instance['page_name']; ?>" />
		</p>		

		<!-- width: Text Input -->
		<p>
			<label for="<?php echo $this->get_field_id( 'width' ); ?>"><?php _e('Width', 'h2cweb_fblike') ?></label>
			<input type="text" class="widefat" id="<?php echo $this->get_field_id( 'width' ); ?>" name="<?php echo $this->get_field_name( 'width' ); ?>" value="<?php echo $instance['width']; ?>" />
		</p>		

		<!-- Show Faces: Text Input -->
		<p>
			<label for="<?php echo $this->get_field_id( 'show_faces' ); ?>"><?php _e('Faces', 'h2cweb_fblike') ?></label>
			<input type="checkbox" class="widefat" id="<?php echo $this->get_field_id( 'show_faces' ); ?>" name="<?php echo $this->get_field_name( 'show_faces' ); ?>" value="1" <?php echo ($instance['show_faces'] == "true" ? "checked='checked'" : ""); ?> />
		</p>

		<!-- Show Stream: Text Input -->
		<p>
			<label for="<?php echo $this->get_field_id( 'show_stream' ); ?>"><?php _e('Stream', 'h2cweb_fblike') ?></label>
			<input type="checkbox" class="widefat" id="<?php echo $this->get_field_id( 'show_stream' ); ?>" name="<?php echo $this->get_field_name( 'show_stream' ); ?>" value="1" <?php echo ($instance['show_stream'] == "true" ? "checked='checked'" : ""); ?> />
		</p>


		<!-- Show Stream: Text Input -->
		<p>
			<label for="<?php echo $this->get_field_id( 'show_header' ); ?>"><?php _e('Header', 'h2cweb_fblike') ?></label>
			<input type="checkbox" class="widefat" id="<?php echo $this->get_field_id( 'show_header' ); ?>" name="<?php echo $this->get_field_name( 'show_header' ); ?>" value="1" <?php echo ($instance['show_header'] == "true" ? "checked='checked'" : ""); ?> />
		</p>


		<?php
	}
}