<?php
class home_post_two_columns_list extends AQ_Block {
	
	//set and create block
	function __construct() {
		$block_options = array(
      'name' => esc_attr__('Home post two columns list', 'jelly_text_main'),
			'size' => 'span12',
		);
		
		//create the block
		parent::__construct('home_post_two_columns_list', $block_options);
	}
	
	
	//create form
	function form($instance) {
        $titles = isset($instance['titles']) ? esc_attr($instance['titles']) : 'Home columns1';
        $title1 = isset($instance['title1']) ? esc_attr($instance['title1']) : 'Home columns2';
        $css_class_builder = isset($instance['css_class_builder']) ? esc_attr($instance['css_class_builder']) : 'color-1';
        $css_class_builder1 = isset($instance['css_class_builder1']) ? esc_attr($instance['css_class_builder1']) : 'color-12';
        $number_show = isset($instance['number_show']) ? absint($instance['number_show']) : 5;
		$number_offset = isset($instance['number_offset']) ? absint($instance['number_offset']) : 0;
		$number_offset1 = isset($instance['number_offset1']) ? absint($instance['number_offset1']) : 0;
        ?>
        
        <p><label for="<?php echo esc_attr($this->get_field_id('title')); ?>"><?php esc_attr_e('Title:', 'jelly_text_main'); ?></label>
            <input class="widefat" id="<?php echo esc_attr($this->get_field_id('titles')); ?>" name="<?php echo esc_attr($this->get_field_name('titles')); ?>" type="text" value="<?php echo esc_attr($titles); ?>" /></p>

        <p><label for="<?php echo esc_attr($this->get_field_id('title1')); ?>"><?php esc_attr_e('Title for right column:','jelly_text_main'); ?></label>
            <input class="widefat" id="<?php echo esc_attr($this->get_field_id('title1')); ?>" name="<?php echo esc_attr($this->get_field_name('title1')); ?>" type="text" value="<?php echo esc_attr($title1); ?>" /></p>

        <p><label for="<?php echo esc_attr($this->get_field_id('css_class_builder')); ?>"><?php esc_attr_e('CSS class columns1','jelly_text_main'); ?></label>
            <input class="widefat" id="<?php echo esc_attr($this->get_field_id('css_class_builder')); ?>" name="<?php echo esc_attr($this->get_field_name('css_class_builder')); ?>" type="text" value="<?php echo esc_attr($css_class_builder); ?>" /></p>

            <p><label for="<?php echo esc_attr($this->get_field_id('css_class_builder1')); ?>"><?php esc_attr_e('CSS class columns2','jelly_text_main'); ?></label>
            <input class="widefat" id="<?php echo esc_attr($this->get_field_id('css_class_builder1')); ?>" name="<?php echo esc_attr($this->get_field_name('css_class_builder1')); ?>" type="text" value="<?php echo esc_attr($css_class_builder1); ?>" /></p>

        <p><label for="<?php echo esc_attr($this->get_field_id('number_show')); ?>"><?php esc_attr_e('Number of posts to show:', 'jelly_text_main'); ?></label>
            <input id="<?php echo esc_attr($this->get_field_id('number_show')); ?>" name="<?php echo esc_attr($this->get_field_name('number_show')); ?>" type="text" value="<?php echo esc_attr($number_show); ?>" size="3" /></p>
            
         <p><label for="<?php echo esc_attr($this->get_field_id('number_offset')); ?>"><?php esc_attr_e('Offset col1 posts:', 'jelly_text_main'); ?></label>
            <input id="<?php echo esc_attr($this->get_field_id('number_offset')); ?>" name="<?php echo esc_attr($this->get_field_name('number_offset')); ?>" type="text" value="<?php echo esc_attr($number_offset); ?>" size="3" /></p>  
            
            <p><label for="<?php echo esc_attr($this->get_field_id('number_offset1')); ?>"><?php esc_attr_e('Offset col2 posts:', 'jelly_text_main'); ?></label>
            <input id="<?php echo esc_attr($this->get_field_id('number_offset1')); ?>" name="<?php echo esc_attr($this->get_field_name('number_offset1')); ?>" type="text" value="<?php echo esc_attr($number_offset); ?>" size="3" /></p>         

        <p>
            <label for="<?php echo $this->get_field_id('cats'); ?>"><?php esc_attr_e('Choose your category:', 'jelly_text_main'); ?> 

                <?php
                $categories = get_categories('hide_empty=0');
                echo "<br/>";
                foreach ($categories as $cat) {
                    $option = '<input type="checkbox" id="' . $this->get_field_id('cats') . '[]" name="' . $this->get_field_name('cats') . '[]"';
                    if (isset($instance['cats'])) {
                        foreach ($instance['cats'] as $cats) {
                            if ($cats == $cat->term_id) {
                                $option = $option . ' checked="checked"';
                            }
                        }
                    }
                    $option .= ' value="' . $cat->term_id . '" />';
                    $option .= '&nbsp;';
                    $option .= $cat->cat_name;
                    $option .= '<br />';
                    echo $option;
                }
                ?>
            </label>
        </p>

        <p>
            <label for="<?php echo esc_attr($this->get_field_id('cats1')); ?>"><?php esc_attr_e('Choose your category:', 'jelly_text_main'); ?> 

                <?php
                $categories = get_categories('hide_empty=0');
                echo "<br/>";
                foreach ($categories as $cat) {
                    $option = '<input type="checkbox" id="' . $this->get_field_id('cats1') . '[]" name="' . $this->get_field_name('cats1') . '[]"';
                    if (isset($instance['cats1'])) {
                        foreach ($instance['cats1'] as $cats) {
                            if ($cats == $cat->term_id) {
                                $option = $option . ' checked="checked"';
                            }
                        }
                    }
                    $option .= ' value="' . $cat->term_id . '" />';
                    $option .= '&nbsp;';
                    $option .= $cat->cat_name;
                    $option .= '<br />';
                    echo $option;
                }
                ?>
            </label>
        </p>
		<?php
		
	}
		
	
	//create block
	function block($instance) {		
		    extract($instance);
        $titles = apply_filters('widget_title', empty($instance['titles']) ? 'Recent Posts' : $instance['titles'], $instance, $this->id_base);
        $title1 = apply_filters('widget_title', empty($instance['title1']) ? 'Recent Posts' : $instance['title1'], $instance, $this->id_base);
        
        if (!$number_show = absint($instance['number_show'])){$number_show = 5;}
		if (isset($instance['number_offset'])==''){$number_offset = 0;}else{$number_offset = absint($instance['number_offset']);}
		if (isset($instance['number_offset1'])==''){$number_offset1 = 0;}else{$number_offset1 = absint($instance['number_offset1']);}
        if (!isset($instance["cats"])){$cats = '';}
		if (!isset($instance["cats1"])){$cats1 = '';}
     

        // array to call recent posts.

        $jellywp_args = array(
            'showposts' => $number_show,
            'category__in' => $cats,
			'ignore_sticky_posts' => 1,
			'offset' => $number_offset
        );

        $jellywp_args1 = array(
            'showposts' => $number_show,
            'category__in' => $cats1,
			'ignore_sticky_posts' => 1,
			'offset' => $number_offset1
			);

        $jellywp_widget = null;
        $jellywp_widget = new WP_Query($jellywp_args);
?>
        <div class="widget two_columns_post builder_two_cols">
        <div class="feature-two-column list-col1-home left-post-display-content margin-left-post <?php echo esc_attr($instance['css_class_builder']);?>">
        <?php if (!empty($instance['titles'])) {?><div class="widget-title"><h2><?php echo esc_attr($instance["titles"]);?></h2></div><?php }?>
        <div class="wrap_box_style_ul">
        <ul class="feature-post-list">

<?php
        $i = 0;
        while ($jellywp_widget->have_posts()) {
            $jellywp_widget->the_post();
            $i++;        
			$post_id = get_the_ID(); 
      //get all post categories
            $categories = get_the_category(get_the_ID());
	             ?>   
   <li class="<?php if(!of_get_option('disable_css_animation')==1){echo esc_attr("appear_animation");}?>">
   <a  href="<?php the_permalink(); ?>" class="feature-image-link image_post" title="<?php the_title_attribute(); ?>">              
<?php if ( has_post_thumbnail()) {the_post_thumbnail('small-feature');}
else{echo '<img class="no_feature_img" alt="" src="'.get_template_directory_uri().'/img/feature_img/small-feature.jpg'.'">';} ?>
<?php echo jelly_post_type(); ?>
</a>
<div class="item-details">
  <?php  if(of_get_option('disable_post_category') !=1){
          if ($categories) {
            echo '<span class="meta-category-small">';
            foreach( $categories as $tag) {
              $tag_link = get_category_link($tag->term_id);
              $titleColor = jelly_categorys_title_color($tag->term_id, "category", false);
             echo '<a class="post-category-color-text" style="color:'.esc_attr($titleColor).'" href="'.esc_url($tag_link).'">'.$tag->name.'</a>';          
            }
            echo "</span>";
            }
       }?>
<?php echo jelly_total_score_post_front_small_list(get_the_ID());?>
   <h3 class="feature-post-title"><a href="<?php the_permalink(); ?>"><?php the_title()?></a></h3>
  <?php echo jelly_post_meta(get_the_ID()); ?>
   </div>
   <div class="clearfix"></div>
   </li>

  

    <?php } echo " </ul>";?>
     </div>      
       
        </div>

        <?php
        wp_reset_query();

        // column right      

        $jellywp_widget1 = null;
        $jellywp_widget1 = new WP_Query($jellywp_args1); ?>
  <div class="feature-two-column right-post-display-content <?php echo esc_attr($instance['css_class_builder1']);?>">
  <?php if (!empty($instance['title1'])) {?><div class="widget-title"><h2><?php echo esc_attr($instance["title1"]);?></h2></div><?php }?>
  <div class="wrap_box_style_ul">
  <ul class="feature-post-list"> 

<?php
        $i = 0;
        while ($jellywp_widget1->have_posts()) {
            $jellywp_widget1->the_post();
            $i++;
			$post_id = get_the_ID();
      //get all post categories
            $categories = get_the_category(get_the_ID());
		            ?>   

   <li class="<?php if(!of_get_option('disable_css_animation')==1){echo esc_attr("appear_animation");}?>">
   <a  href="<?php the_permalink(); ?>" class="feature-image-link image_post" title="<?php the_title_attribute(); ?>">              
<?php if ( has_post_thumbnail()) {the_post_thumbnail('small-feature');}
else{echo '<img class="no_feature_img" alt="" src="'.get_template_directory_uri().'/img/feature_img/small-feature.jpg'.'">';} ?>
<?php echo jelly_post_type(); ?>
</a>
   <div class="item-details">
    <?php  if(of_get_option('disable_post_category') !=1){
          if ($categories) {
            echo '<span class="meta-category-small">';
            foreach( $categories as $tag) {
              $tag_link = get_category_link($tag->term_id);
              $titleColor = jelly_categorys_title_color($tag->term_id, "category", false);
             echo '<a class="post-category-color-text" style="color:'.esc_attr($titleColor).'" href="'.esc_url($tag_link).'">'.$tag->name.'</a>';          
            }
            echo "</span>";
            }
       }?>
<?php echo jelly_total_score_post_front_small_list(get_the_ID());?>
   <h3 class="feature-post-title"><a href="<?php the_permalink(); ?>"><?php the_title()?></a></h3>
   <?php echo jelly_post_meta(get_the_ID()); ?>
   </div>
   <div class="clearfix"></div>
   </li>
    <?php } echo " </ul>";?>
    </div>        
                    
            
        </div>
         </div>
      
        <?php
        wp_reset_query();

    }
	
	    function update($new_instance, $old_instance) {
        return $new_instance;
    }

	
}
