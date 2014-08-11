<?php
class AjaxSearchLiteWidget extends WP_Widget
{
  function AjaxSearchLiteWidget()
  {
    $widget_ops = array('classname' => 'AjaxSearchLiteWidget', 'description' => 'Displays an Ajax Search Lite!' );
    $this->WP_Widget('AjaxSearchLiteWidget', 'Ajax Search Lite', $widget_ops);
  }
  function form($instance)
  {
  $title = empty($instance['title']) ? ' ' : apply_filters('widget_title', $instance['title']);
?>
  <p>
      <label for="<?php echo $this->get_field_id('title'); ?>">
          Title:
          <input class="widefat" id="<?php echo $this->get_field_id('title'); ?>"
                 name="<?php echo $this->get_field_name('title'); ?>" type="text"
                 value="<?php echo esc_attr($title); ?>" />
      </label>
  </p>
<?php
  }

  function update($new_instance, $old_instance)
  {
    $instance = $old_instance;
    $instance['title'] = $new_instance['title'];
    return $instance;
  }

  function widget($args, $instance)
  {
    extract($args, EXTR_SKIP);
    echo $before_widget;
    $title = empty($instance['title']) ? ' ' : apply_filters('widget_title', $instance['title']);
    if (!empty($title))
      echo $before_title . $title . $after_title;;
    // WIDGET CODE GOES HERE
    echo do_shortcode("[wpdreams_ajaxsearchlite]");
    echo $after_widget;
  }
}

add_action( 'widgets_init', create_function('', 'return register_widget("AjaxSearchLiteWidget");') );
?>