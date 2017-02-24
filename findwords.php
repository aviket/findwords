<?php
/*
  Plugin Name: Findwords
  Description: Plugin for showing all occurances of a word in the blog
  Version: 1.0
  Author: Avinashk
  Author URI:
  License: GPLv2
 */

define('FindWordspluginPLUGIN_FILE', __FILE__);

if (function_exists('add_image_size')) {
    add_image_size('sliderimg', 200, 150, true);
}

function Findwordplugin_load_caroufredsel() {
    wp_enqueue_style('caroufredsel', plugin_dir_url(__FILE__) . 'css/wp-caroufredsel.css');
    wp_enqueue_script('mark_js', plugin_dir_url(__FILE__) . 'js/mark.js/mark.js', array('jquery'), '', true);
    wp_enqueue_script('caroufredsel_js', plugin_dir_url(__FILE__) . 'js/carouFredSel-jQuery/jquery.carouFredSel-6.2.1-packed.js', array('jquery'), '', true);
    wp_enqueue_script('url_js', plugin_dir_url(__FILE__) . 'js/urljs.js', array('jquery'), '', true);
    wp_enqueue_script('caroufredsel_js_wp', plugin_dir_url(__FILE__) . 'js/wp-caroufredsel.js', array('caroufredsel_js'), '', true);


    // Enqueue carouFredSel, note that we specify 'jquery' as a dependency, and we set 'true' for loading in the footer:
    // wp_register_script( 'caroufredsel', get_template_directory_uri() . '/js/jquery.carouFredSel-5.5.0-packed.js', array( 'jquery' ), '5.5.0', true );
    // For either a plugin or a theme, you can then enqueue the script:
    // wp_enqueue_script( 'wptuts-caroufredsel', get_template_directory_uri() . '/js/wptuts-caroufredsel.js', array( 'caroufredsel' ), '', true );
}

add_action('wp_enqueue_scripts', 'Findwordplugin_load_caroufredsel');

function findwordpluginfunc($atts, $content) {
    ?>
    <div style="height:100%">
	    Click on any button to view the post containing the word <?php echo $content ?>
        <div class="list_carousel">
            <ul id="foo2">
            </ul>
        </div>
        <script>

            var cnt = 1;

        </script>
        <?php
        // WP_Query arguments
        $args = array(
            's' => $content,
        );


        $carouselPosts = new WP_Query($args);
        //$carouselPosts->query('showposts=12');
        ?>
        <?php add_thickbox(); ?>
        <?php $cnt = 1; ?>
        <?php while ($carouselPosts->have_posts()) : $carouselPosts->the_post(); ?>




            <?php $cnt += 1; ?>
            <script "text/javascript">

                function create(htmlStr) {
                var frag = document.createDocumentFragment(),
                temp = document.createElement('div');
                temp.innerHTML = htmlStr;
                while (temp.firstChild) {
                frag.appendChild(temp.firstChild);
                }
                return frag;
                }
                var node = document.createElement("LI"); 
                document.getElementById("foo2").appendChild(node);
                var	div1 = document.createElement("DIV");
                node.appendChild(div1);
                div1.style.textAlign = "center";
                div1.style.padding = "20px 0";
                div1.style.width = "800";

                var node1 = document.createElement("INPUT");
                div1.appendChild(node1);
                node1.type = "BUTTON";
                node1.setAttribute("id", "baseli" + cnt);
                node1.setAttribute("alt", "#TB_inline?height=300&amp;width=775&amp;inlineId=Popup" + cnt);
                node1.setAttribute("title", "<?php the_title() ?>");
                node1.className = "thickbox";
                node1.value = "<?php the_title() ?>";


                var	div2 = document.createElement("DIV");
                node.appendChild(div2);
                div2.setAttribute("id", "Popup" + cnt);
                div2.style.display = "none";
                //var	h2 = document.createElement("H2");
                //h2.innerText = '<?php
                // $out = the_title();
                // $out = str_replace("'", "", $out);
                // echo $out; 
                ?>';
                //div2.appendChild(h2);
                var cdav = document.createElement("DIV");
                //cdav.className = "entry-content";
                cdav.innerHTML = "<?php echo str_replace('"', '', str_replace("\n", "<br/>", str_replace("\r", "", preg_replace('/\[[^\]]*\]/', '', get_the_content())))); ?>";
                div2.appendChild(cdav);





                cnt += 1;




        </script>
    <?php endwhile; ?>



    </div>
    <script type="text/javascript">


        jQuery(document).ready(function () {
            var options = {
                "element": "mark",
                "className": "mrkwrd",
                "exclude": [],
                "separateWordSearch": true,
                "accuracy": "partially",
                "diacritics": true,
                "synonyms": {},
                "iframes": false,
                "acrossElements": false,
                "caseSensitive": false,
                "ignoreJoiners": false,
                "each": function (node) {
                    // node is the marked DOM element
                },
                "filter": function (textNode, foundTerm, totalCounter, counter) {
                    // textNode is the text node which contains the found term
                    // foundTerm is the found search term
                    // totalCounter is a counter indicating the total number of all marks
                    //              at the time of the function call
                    // counter is a counter indicating the number of marks for the found term
                    return true; // must return either true or false
                },
                "noMatch": function (term) {
                    // term is the not found term
                },
                "done": function (counter) {
                    // counter is a counter indicating the total number of all marks
                },
                "debug": false,
                "log": window.console
            };
            var context = document.querySelector("div.entry-content");
            var instance = new Mark(context);
            instance.mark("<?php echo($content) ?>", options);
            var bkgrd = "<?php echo(get_option('FindWordsplugin-Settings')['backgroundFindWordsplugin']) ?>";
            var txtcol = "<?php echo(get_option('FindWordsplugin-Settings')['colorFindWordsplugin']) ?>";
            var y = document.getElementsByClassName("mrkwrd");

            for (var ixx = 0; ixx < y.length; ixx++)
            {
                y[ixx].style.background = bkgrd;
                y[ixx].style.color = txtcol;

            }




        });


    </script>
    <?php
}

add_shortcode('findwordsc', 'findwordpluginfunc');

function add_query_vars_filter_findwordsplugin($vars) {
    $vars[] .= 'hword';
    $vars[] .= 'bkgrd';
    $vars[] .= 'txtcol';
    return $vars;
}

add_filter('query_vars_findwordstipplugin', 'add_query_vars_filter_findwordsplugin');

require(dirname(__FILE__) . DIRECTORY_SEPARATOR . 'FindwordsSettings.php');

new FindWordspluginSettings();
?>