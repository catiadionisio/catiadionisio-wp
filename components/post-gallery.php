<?php
/**
 * Post gallery
 *
 */

add_filter('post_gallery', 'custom_post_gallery', 10, 2);
function custom_post_gallery($output, $attr) {
    global $post;

    if (isset($attr['orderby'])) {
        $attr['orderby'] = sanitize_sql_orderby($attr['orderby']);
        if (!$attr['orderby'])
            unset($attr['orderby']);
    }

    extract(shortcode_atts(array(
        'order' => 'ASC',
        'orderby' => 'menu_order ID',
        'id' => $post->ID,
        'itemtag' => 'dl',
        'icontag' => 'dt',
        'captiontag' => 'dd',
        'columns' => 4,
        'size' => 'thumbnail',
        'include' => '',
        'exclude' => ''
    ), $attr));

    $id = intval($id);
    if ('RAND' == $order) $orderby = 'none';

    if (!empty($include)) {
        $include = preg_replace('/[^0-9,]+/', '', $include);
        $_attachments = get_posts(array('include' => $include, 'post_status' => 'inherit', 'post_type' => 'attachment', 'post_mime_type' => 'image', 'order' => $order, 'orderby' => $orderby));

        $attachments = array();
        foreach ($_attachments as $key => $val) {
            $attachments[$val->ID] = $_attachments[$key];
        }
    }

    if (empty($attachments)) return '';

    $count_imgs = count($attachments);

    /*if ($count_imgs < 10) {
      $count_imgs = '0'.$count_imgs;
    }*/

    // Here's your actual output, you may customize it to your need
    $output = "<div class=\"gallery-container\">\n";

        // Now you loop through each attachment
        //start count
        $i = 0;
        foreach ($attachments as $id => $attachment) {
              // Fetch the thumbnail (or full image, it's up to you)
            $img = wp_get_attachment_image_src($id, 'large');

            $output .= "<div class=\"gallery-img-out\">\n";
                $output .= "<div class=\"gallery-img\" style=\"background-image: url({$img[0]});\" data-slideNum=\"{$i}\"></div>\n";
            $output .="</div>\n"; //gallery-img-out

            $i++;

        }

        $output .= "<div class=\"gallery-slider-container\">\n";
            $output .= "<div class=\"dt\">\n";
                $output .= "<div class=\"dtc middle\">\n";

                    $output .= "<div class=\"close-gallery\">fechar</div>\n";

                    $output .= "<div class=\"gallery-slider\">\n";

                        foreach ($attachments as $id => $attachment) {
                              // Fetch the thumbnail (or full image, it's up to you)
                            $img = wp_get_attachment_image_src($id, 'full');

                            $output .= "<div class=\"slide\">\n";

                                $output .= "<div class=\"inner-slide\">\n";
                                    $output .= "<div class=\"dtc middle\">\n";
                                        $output .= "<div class=\"container\">\n";
                                            $output .= "<img src=\"{$img[0]}\" alt=\"\" />\n";
                                        $output .= "</div>\n"; //container
                                    $output .= "</div>\n"; //dtc
                                $output .= "</div>\n"; //inner-slide

                                if (strlen($attachment->post_excerpt) > 0) {
                                  $img_description = $attachment->post_excerpt;
                                } else {
                                  $img_description = '-';
                                }

                                $output .= "<div class=\"img-description\">\n";
                                    $output .= "<div class=\"container\">\n";
                                      $output .= "<p> {$img_description} </p>\n";
                                    $output .= "</div>\n"; //container
                                $output .= "</div>\n"; //img-description

                            $output .= "</div>\n"; //slide
                        }

                    $output .= "</div>\n"; //gallery-slider

                    $output .="<div class=\"gallery-current-slide hidden\">\n";
                        $output .="<div class=\"container\">\n";
                          $output .="<span>1</span>/{$count_imgs}\n";
                        $output .= "</div>\n"; //container
                    $output .= "</div>\n"; //gallery-current-slide

                $output .= "</div>\n"; //dtc middle
            $output .= "</div>\n"; //dt
        $output .= "</div>\n"; //gallery-slider-container


    $output .= "</div>\n"; //gallery-container


    return $output;
}
