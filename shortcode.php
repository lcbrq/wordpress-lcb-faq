<?php
function display_faq(){
	 $return_string = '<div class="">';
   query_posts(array('post_type' => 'faq', 'orderby' => 'date', 'order' => 'DESC'));
   if (have_posts()) :
      while (have_posts()) : the_post();
   $attr = array(
	'title' => get_the_title()
);
         $return_string .= '<div class="">'
                            .'<h3>'
                            .'<a href='.get_permalink().'>'
                            .get_the_title()
                            .'</a>'
                            .'</h3>'
                            .'<p>'
                            .get_the_excerpt()
                            .'</p>'
                            .'</div>';
      endwhile;
   endif;
   $return_string .= '</div>';

   wp_reset_query();
   return $return_string;
    }
add_shortcode( 'faq', 'display_faq' );
