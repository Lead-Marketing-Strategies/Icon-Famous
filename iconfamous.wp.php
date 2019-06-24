<?
// WP Generator

require_once("../famousiconswp/wp-load.php");

$file = file_get_contents("iconfamous.nam");
$list = explode(PHP_EOL, $file);

wp_insert_term(
  'Web Application', // the term
  'icon_category'
);

$term = get_term_by('name', 'Web Application', 'icon_category');
//echo $term->term_id;

//clear old posts
/*
$allposts= get_posts( array(
  'post_type'=>'icon',
  'numberposts'=>-1,
  "post_status" => "draft"
) );
foreach ($allposts as $eachpost) {
wp_delete_post( $eachpost->ID, true );
}
die();
*/

//print_r($list);
foreach($list as $index => $line){
  $split = explode(" ", $line, 2);

  $shortname = $split[1];
  $fullname = ucwords(str_replace("-", " ", $shortname));
  $unicode = explode("x", $split[0])[1];

  $icons = get_posts( array(
            'post_type'         => 'icon',
            "post_status" => "publish",
            'meta_query' => array(
                array(
                    'key'    => 'unicode',
                    'value'    => $unicode,
                ),
            ),
        ));


    $icon = [
      "post_title" => $fullname,
      'post_type' => 'icon',
      "post_status" => "publish",
      "icon_category" => $term->term_id,
      "meta_input" => [
        [
          "class" => "if if-".$shortname,
          "unicode" => $unicode
        ]
      ]
    ];

      $icon_id = false;
      if(count($icons) > 0){
        $icon["ID"] = $icons[0]->ID;
      }

    $post_id = wp_insert_post($icon);
    wp_set_object_terms( $post_id, $term->term_id, 'icon_category' );
    update_post_meta( $post_id, 'class', "if if-".$shortname, true );
    update_post_meta( $post_id, 'unicode', $unicode, true );
    echo "Added: ".$fullname."<br>";

    // add function to clear non existing from WP

}
?>
