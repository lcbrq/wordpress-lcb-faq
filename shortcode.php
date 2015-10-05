<?php

function lcb_faq_display($atts)
{
    $lcb_faq_atts = shortcode_atts(array(
        'category' => false,
            ), $atts, 'faq');
    $return_string = '<div class="">';
    if ($lcb_faq_atts['category']) {
        $tax_query = array(
            array(
                'taxonomy' => 'faq-category',
                'field' => 'id',
                'terms' => array($lcb_faq_atts['category'])
            )
        );
    } else {
        $tax_query = null;
    }

    query_posts(array('post_type' => 'faq', 'tax_query' => $tax_query, 'orderby' => 'date', 'order' => 'DESC'));
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
add_shortcode( 'faq', 'lcb_faq_display' );