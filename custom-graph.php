<?php
/*
 * Plugin Name:       Krishna Graph Plugin
 * Plugin URI:        https://thegoodlifemoneycoach.com/
 * Description:       Handle the custom graph form LMS
 * Version:           1.0
 * Requires at least: 5.2
 * Requires PHP:      7.2
 * Author:            Krishna Singh
 * Author URI:        https://author.example.com/
 * License:           GPL v2 or later
 * License URI:       https://www.gnu.org/licenses/gpl-2.0.html
 * Update URI:        https://example.com/my-plugin/
 */
function enqueue_chart_library() {
  wp_enqueue_script('chart-js', 'https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.4/Chart.min.js', array('jquery'), '2.9.4', true);
}
add_action('wp_enqueue_scripts', 'enqueue_chart_library');

 if(!defined('ABSPATH'))
 {
  header("Location: /thegoodlife");
  die('');
 }
 function my_plugin_activation()
 {

 }
 register_activation_hook(__FILE__, 'my_plugin_activation');

 function my_plugin_deactivation()
 {

 }
 register_deactivation_hook(__FILE__, 'my_plugin_deactivation');

 function my_plugin_uninstall()
 {

//   / if uninstall.php is not called by WordPress, die
// if ( ! defined( 'WP_UNINSTALL_PLUGIN' ) ) {
//     die;
// }

// $option_name = 'wporg_option';

// delete_option( $option_name );

// // for site options in Multisite
// delete_site_option( $option_name );

// // drop a custom database table
// global $wpdb;
// $wpdb->query( "DROP TABLE IF EXISTS {$wpdb->prefix}mytable" );
 }
 register_uninstall_hook(__FILE__, 'my_plugin_uninstall');



 
function custom_graph_lms_data()
{
  
        global $wpdb;
        //$table_name = $wpdb->. prefix $posts;
        $results = $wpdb->get_results( "SELECT * FROM wpsc_mepr_transactions"); // Query to fetch data from database table and storing in $results
         $postname = [];
         $postdate = [];
         foreach ( $results as $result ) { 
         // echo $result->post_title;
          $postname[] = $result->product_id;
          $postdate[] = $result->amount;
        }

        include 'my_charts.php';
      }
      add_shortcode('myshortcode', 'custom_graph_lms_data');

       // foreach($results as $data)
        // {
        //   echo '<table>';
        //   echo '<thead><th>Post Title</th><th>Post Date</th></tr></thead>';
        //   echo '<tbody>';
        //   echo '<tr>';
        //   echo "<td>" . $data->post_title ."</td>";
        //   echo "<td>" . $data->post_date . "</td>";
        //   echo '</tr>';
        //   echo '</tbody>';
        // echo '</table>';
        // }
        // if (!empty($results)) {
        //   echo '<table>';
        //   echo '<thead><tr><th>ID</th><th>Post Title</th><th>Post Date</th></tr></thead>';
        //   echo '<tbody>';
        //   foreach ($results as $row) {
        //       echo '<tr>';
        //       //echo '<td>' . $row[''] . '</td>';
        //       echo '<td>' . $row['post_title'] . '</td>';
        //       echo '<td>' . $row['post_date'] . '</td>';
        //       echo '</tr>';
        //    }
        //   echo '</tbody>';
        //   echo '</table>';
        // } 
        // else 
        // {
        //   echo 'No data found.';
        // }
function my_post()
{
$args = array(
'post_type' => 'post',
);

$query = new WP_Query($args);
ob_start();
if($query->have_post());
{
?>
<div class="card" style="width: 18rem;">
<div class="card-body" style="border: 1px solid red;">
<?php
while($query->have_posts())
{
$query->the_post();

 //echo the_post_thumbnail();

echo  '<a href=" '.get_the_permalink().' ">' .'<img src=" '. the_post_thumbnail().' ">'.'<h3>'.get_the_title(). '</h3> ' . '<p>' .get_the_content(). '</p>';

}  
?>
</div>
</div>
<?php
//endif;
}
wp_reset_postdata();
$html = ob_get_clean();
return $html;
}

add_shortcode('my-posts', 'my_post');