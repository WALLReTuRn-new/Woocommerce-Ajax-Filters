<?php
/*
 * WebSiteToYou License
 * Each line should be prefixed with  * 
 */

// The widget class

namespace wstyepaf\Includes\Classes\Widgets\Ep_ajax_filter;

class Ep_Ajax_Filters extends \WP_Widget {

    public $registry;

    // Main constructor
    public function __construct() {
        parent::__construct(
                'ep_ajax_filters',
                __('Ep Ajax Filters', 'wstyepaf'),
                array(
                    'customize_selective_refresh' => true,
                )
        );

        $settings = $this->getSettings('general_settings');

        if ($settings->status == 1):

            add_action($settings->positions, array($this, 'woocommerce_ajax_filters'), 10);
            add_action('wp_ajax_my_ajax_callback_function', array($this, 'my_ajax_callback_function'));    // If called from admin panel
            add_action('wp_ajax_nopriv_my_ajax_callback_function', array($this, 'my_ajax_callback_function'));
            add_action('wp_head', array($this, 'ajaxurl'));
            add_filter('loop_shop_per_page', [$this, 'new_loop_shop_per_page'], 20);

        endif;
    }

    public function getSettings($key) {
        global $wpdb;
        $table = $wpdb->prefix . 'ep_ajax_filter_general_settings';
        $settings = $wpdb->get_row("SELECT * FROM $table WHERE settings_name = '" . $key . "'");
        return $settings;
    }

    function new_loop_shop_per_page($cols) {

        if (isset($_GET['show'])):
            $cols = $_GET['show'];
        else:
            //get_option('posts_per_page')
            $cols = 15;
        endif;

        return $cols;
    }

    function ajaxurl() {
        ?>
        <script>
            var ajaxscript = {ajax_url: '<?php echo admin_url('admin-ajax.php'); ?>'};



            var CurrentPage = '<?php echo home_url($_SERVER['REQUEST_URI']); ?>';

        <?php
        $edno = $this->url();
        $dve = wc_get_page_permalink('shop');

        if ($edno == $dve):
            echo 'var defaultShopPage = {url: "' . wc_get_page_permalink('shop') . '"}';
        else:
            echo 'var defaultShopPage = {url: "' . $this->url() . '"}';
        endif;
        ?>




            var DefPerPage = '15';
        </script>
        <?php
    }

    function url() {
        return sprintf(
                "%s://%s%s",
                isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] != 'off' ? 'https' : 'http',
                $_SERVER['SERVER_NAME'],
                $_SERVER['REQUEST_URI']
        );
    }

    // The widget form (for the backend )
    public function form($instance) {
        
    }

    // Update widget settings
    public function update($new_instance, $old_instance) {
        $instance = $old_instance;

        return $instance;
    }

    // Display the widget
    public function widget($args, $instance) {

        extract($args);
        // Check the widget options
        $title = isset($instance['title']) ? apply_filters('widget_title', $instance['title']) : '';
        $text = isset($instance['text']) ? $instance['text'] : '';
        $textarea = isset($instance['textarea']) ? $instance['textarea'] : '';
        $select = isset($instance['select']) ? $instance['select'] : '';
        $checkbox = !empty($instance['checkbox']) ? $instance['checkbox'] : false;

        // WordPress core before_widget hook (always include )
        echo $before_widget;

        echo '<div class="filter-base">
                <div class="filterclick-base open" style="background-position: -40px center;">
                    <div class="text-filterclick" style="padding-left: 0.5rem;font-weight: 900;color: #333333;">Filtry22</div>
                    <div class="iconsfilter rocket-lazyload lazyloaded" style="background-size: contain; background-image: url(&quot;https://www.bterm.cz/wp-content/uploads/2021/04/filter.webp&quot;);" data-ll-status="loaded"></div>
                </div>
            </div>';

        echo $after_widget;
    }

    public function woocommerce_ajax_filters() {

        if (!is_product()):


            $settings = $this->getSettings('general_settings');

            $user = wp_get_current_user();
            $allowed_roles = array('editor', 'administrator', 'author');
            if ($settings->visible == 1):
                if (array_intersect($allowed_roles, $user->roles)):
                    register_widget($this, 'Ep_Ajax_Filters');
                    wp_enqueue_style('ep-ajax-filters', EP_PLUGIN_URL . 'assets/front/css/style.css');
                    wp_enqueue_script('ep-ajax-filters-script', EP_PLUGIN_URL . 'assets/front/js/main.js');

                    if (is_woocommerce()):
                        //Remove Pagination
                        remove_action('woocommerce_after_shop_loop', 'woocommerce_pagination', 10);
                        //Show button More
                        add_action('woocommerce_after_shop_loop', [$this, 'ButtonShowMoreProducts'], 10);

                        // WooCommerce core output
                        remove_action('woocommerce_before_shop_loop', 'woocommerce_catalog_ordering', 30);
                        remove_action('woocommerce_before_shop_loop', 'woocommerce_result_count', 20);

                        // Storefront theme
                        remove_action('woocommerce_before_shop_loop', 'woocommerce_catalog_ordering', 10);
                        remove_action('woocommerce_after_shop_loop', 'woocommerce_catalog_ordering', 10);
                        remove_action('woocommerce_before_shop_loop', 'woocommerce_result_count', 10);

                        add_action($settings->positions, [$this, 'add_new_filter_and_order'], 30);
                        add_action($settings->positions, [$this, 'add_new_filter_and_order'], 10);
                    endif;
                endif;

            else:
                register_widget($this, 'Ep_Ajax_Filters');
                wp_enqueue_style('ep-ajax-filters', EP_PLUGIN_URL . 'assets/front/css/style.css');
                wp_enqueue_script('ep-ajax-filters-script', EP_PLUGIN_URL . 'assets/front/js/main.js');

                if (is_woocommerce()):
                    //Remove Pagination
                    remove_action('woocommerce_after_shop_loop', 'woocommerce_pagination', 10);
                    //Show button More
                    add_action('woocommerce_after_shop_loop', [$this, 'ButtonShowMoreProducts'], 10);

                    // WooCommerce core output
                    remove_action('woocommerce_before_shop_loop', 'woocommerce_catalog_ordering', 30);
                    remove_action('woocommerce_before_shop_loop', 'woocommerce_result_count', 20);

                    // Storefront theme
                    remove_action('woocommerce_before_shop_loop', 'woocommerce_catalog_ordering', 10);
                    remove_action('woocommerce_after_shop_loop', 'woocommerce_catalog_ordering', 10);
                    remove_action('woocommerce_before_shop_loop', 'woocommerce_result_count', 10);

                    add_action($settings->positions, [$this, 'add_new_filter_and_order'], 30);
                    add_action($settings->positions, [$this, 'add_new_filter_and_order'], 10);
                endif;

            endif;
        endif;
    }

    public function ButtonShowMoreProducts() {

        //If count of product per category is < get_option('posts_per_page'); no show button
        //get_option('posts_per_page')
        $showmorecount = 15;

        if (is_shop()):
            $counter = 0;
            $products = wc_get_products(array('status' => 'publish', 'limit' => -1));
            foreach ($products as $product):
                $counter++;
            endforeach;

            if ($counter > $showmorecount):

                echo '<div class="loading-more col-sm-12" ><button id="show-more-button" type="button" class="btn btn-success mr-md-3 mb-2 mb-md-0" data-current-show="' . $showmorecount . '" data-max="' . $counter . '"><span class="showmore-text">Další ' . $showmorecount . '</span><div class="waiting-loading-button"><svg fill="#FFFFFF" height="15px" width="20px" version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 472.576 472.576" xml:space="preserve"><g><g><circle cx="65.142" cy="236.288" r="65.142"/></g></g><g><g><circle cx="236.308" cy="236.288" r="65.142"/></g></g><g><g><circle cx="407.434" cy="236.288" r="65.142"/></g></g></svg></div></button></div>';

            endif;

        else:
            $term = get_term(get_queried_object_id(), 'product_cat'); // <--- tested in my system with this ID
            if ($term->count > $showmorecount):

                echo '<div class="loading-more col-sm-12" ><button id="show-more-button" type="button" class="btn btn-success mr-md-3 mb-2 mb-md-0" data-current-show="' . $showmorecount . '" data-max="' . $term->count . '"><span class="showmore-text">Další ' . $showmorecount . '</span><div class="waiting-loading-button"><svg fill="#FFFFFF" height="15px" width="20px" version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 472.576 472.576" xml:space="preserve"><g><g><circle cx="65.142" cy="236.288" r="65.142"/></g></g><g><g><circle cx="236.308" cy="236.288" r="65.142"/></g></g><g><g><circle cx="407.434" cy="236.288" r="65.142"/></g></g></svg></div></button></div>';

            endif;
        endif;
    }

    //Registret custom Widget witth settings
    //add_action('widgets_init', 'ajax_filter_widget');
    // Add widget area above Woocommerce products
    public function add_new_filter_and_order() {

        $settings = $this->getSettings('general_settings');

        global $wp;

        // WooCommerce textdomain used intentionally
        $options = [
            //'menu_order' => __('Výchozí', 'woocommerce'),
            'popularity' => __('Seřazeno podle Popularita', 'woocommerce'),
            'rating' => __('Seřazeno podle Hodnocení', 'woocommerce'),
            'date' => __('Seřazeno podle nejnovější', 'woocommerce'),
            'price' => __('Cenu: nízké až vysoké', 'woocommerce'),
            'price-desc' => __('Cenu: vysoká až nízká', 'woocommerce'),
        ];

        $getOrderby = (array) apply_filters('woocommerce_catalog_orderby', $options);
        $html = '';
        $html .= '<nav class="row toolbox toolbox-horizontal">';
        $html .= '<div class="col-sm-12 toolbox-right">';
        $html .= '<h5>Seřadit:</h5>';
        $html .= '<div class="toolbox-item toolbox-sort">';

        foreach ($getOrderby as $value => $name):
            $html .= '<a class="sorting select-menu-sorting"  data-sorting="' . $value . '">' . $name . '</a>';
        endforeach;
        $html .= '<input id="get-sorting" type="hidden" value="' . $default_option = get_option('woocommerce_default_catalog_orderby', 'menu_order') . '">';
        $html .= '</div>';
        $html .= '</div>';
        if (!is_shop()):
            if ($settings->filtertype == 1):
                $html .= $this->customFilters();
            else:
                $html .= $this->defaultFilters();
            endif;
        endif;

        $html .= '</nav>';
        $html .= '<div class="select-items" style="display: block;">';
        $html .= '<div class="select-items" style="display: none;">';
        $html .= '<a href="#" class="filter-clean text-primary">Clean All</a>';
        $html .= '</div>';
        $html .= '</div>';

        echo $html;

        dynamic_sidebar('show-ajax-filter');
    }

    public function defaultFilters() {
        global $wp;
        // Here define the product category SLUG
        $category_slug = substr($wp->request, strrpos($wp->request, '/') + 1);

        if (is_shop()):
            $query_args = array(
                'status' => 'publish',
                'post_type' => 'product',
                'order' => 'ASC',
                'orderby' => 'title',
                'meta_query' => array(
                    'key' => '_stock_status',
                    'value' => 'outofstock',
                    'compare' => '!='
                )
            );
        else:
            $query_args = array(
                'status' => 'publish',
                'order' => 'ASC',
                'orderby' => 'title',
                'limit' => -1,
                'category' => array($category_slug),
                'meta_query' => array(
                    'key' => '_stock_status',
                    'value' => 'outofstock',
                    'compare' => '!='
                )
            );
        endif;

        $attributes = [];
        foreach (wc_get_products($query_args) as $product) {
            foreach ($product->get_attributes() as $taxonomy => $attribute) {
                $attribute_name = wc_attribute_label($taxonomy); // Attribute name
                // Or: $attribute_name = get_taxonomy( $taxonomy )->labels->singular_name;
                foreach ($attribute->get_terms() as $term) {
                    $attributes[$taxonomy][$term->term_id] = $term->name;
                    // Or with the product attribute label name instead:
                    // $data[$attribute_name][$term->term_id] = $term->name;
                }
            }
        }



        $toolbox_item = [];

        foreach ($attributes as $key => $value):

            $status = $this->checkStatus($key);
            if ($status == '1'):
                $toolbox_item[str_replace("pa_", "filter_", $key)] = [
                    'title' => $this->attribute_slug_to_title($key),
                    'toolbox_value' => $this->toolbox_value($value, $key)
                ];
            endif;

        endforeach;

        $html = '';

        $html .= '<div class="col-sm-12 toolbox-left">';
        $html .= '<div class="d-none d-xl-block p-0">Filtr:</div>';
        $html .= '<aside class="sidebar sidebar-fixed shop-sidebar">';
        $html .= '<div class="sidebar-overlay">';
        $html .= '<a class="sidebar-close" href="#"><i class="fas fa-times"></i></a>';
        $html .= '</div>';
        $html .= '<a href="#" class="sidebar-toggle">Filters<i class="fas fa-chevron-right"></i></a>';
        $html .= '<div class="sidebar-content toolbox-left">';
        foreach ($toolbox_item as $keyToolBox => $toolBoxValue):
            if ($toolBoxValue['title']):
                $html .= '<div class="toolbox-item select-menu">';
                $html .= '<a class="select-menu-toggle" href="#">' . $toolBoxValue['title'] . '</a><ul class="filter-items">';
                foreach ($toolBoxValue['toolbox_value'] as $value):
                    $html .= '<li class="" data-filters-group="' . $keyToolBox . '" data-value="' . $value['slug'] . '"><a href="#">' . $value['name'] . '</a></li>';
                endforeach;
                $html .= '</ul>';
                $html .= '</div>';
            endif;
        endforeach;

        $html .= '</aside>';
        $html .= '</div>';

        return $html;
    }

    public function customFilters() {


        global $wp;
        // Here define the product category SLUG
        $category_slug = substr($wp->request, strrpos($wp->request, '/') + 1);

        if (is_shop()):
            $query_args = array(
                'status' => 'publish',
                'post_type' => 'product',
                'order' => 'ASC',
                'orderby' => 'title',
                'meta_query' => array(
                    'key' => '_stock_status',
                    'value' => 'outofstock',
                    'compare' => '!='
                )
            );
        else:
            $query_args = array(
                'status' => 'publish',
                'order' => 'ASC',
                'orderby' => 'title',
                'limit' => -1,
                'category' => array($category_slug),
                'meta_query' => array(
                    'key' => '_stock_status',
                    'value' => 'outofstock',
                    'compare' => '!='
                )
            );
        endif;

        $attributes = [];
        foreach (wc_get_products($query_args) as $product) {
            foreach ($product->get_attributes() as $taxonomy => $attribute) {
                $attribute_name = wc_attribute_label($taxonomy); // Attribute name
                // Or: $attribute_name = get_taxonomy( $taxonomy )->labels->singular_name;
                foreach ($attribute->get_terms() as $term) {
                    $attributes[$taxonomy][$term->term_id] = $term->name;
                    // Or with the product attribute label name instead:
                    // $data[$attribute_name][$term->term_id] = $term->name;
                }
            }
        }


        //print_r($attributes['pa_chladici-vykon']);

        $toolbox_item = [];

        foreach ($attributes as $key => $value):

            $status = $this->checkStatus($key);
            if ($status == '1'):
                $toolbox_item[str_replace("pa_", "filter_", $key)] = [
                    'title' => $this->attribute_slug_to_title($key),
                    'toolbox_value' => $this->custom_toolbox_value($key, $value)
                ];
            endif;

        endforeach;

        $html = '';

        $html .= '<div class="col-sm-12 toolbox-left">';
        $html .= '<div class="d-none d-xl-block p-0">Filtr:</div>';
        $html .= '<aside class="sidebar sidebar-fixed shop-sidebar">';
        $html .= '<div class="sidebar-overlay">';
        $html .= '<a class="sidebar-close" href="#"><i class="fas fa-times"></i></a>';
        $html .= '</div>';
        $html .= '<a href="#" class="sidebar-toggle">Filters<i class="fas fa-chevron-right"></i></a>';
        $html .= '<div class="sidebar-content toolbox-left">';

        foreach ($toolbox_item as $keyToolBox => $toolBoxValue):
            if ($toolBoxValue['title']):
                $html .= '<div class="toolbox-item select-menu">';
                $html .= '<a class="select-menu-toggle" href="#">' . $toolBoxValue['title'] . '</a><ul class="filter-items">';
                foreach ($toolBoxValue['toolbox_value'] as $value):
                    $html .= '<li class="" data-filters-group="' . $keyToolBox . '" data-value="' . $value['slug'] . '"><a href="#">' . $value['name'] . '</a></li>';
                endforeach;
                $html .= '</ul>';
                $html .= '</div>';
            endif;
        endforeach;

        $html .= '</aside>';
        $html .= '</div>';

        return $html;
    }

    function checkStatus($key) {
        global $wpdb;
        $tableBlocks = $wpdb->prefix . 'ep_ajax_default_filter_settings';
        $status = $wpdb->get_var("SELECT attribute_status FROM $tableBlocks WHERE attribute_name='" . $key . "'");
        return ($status);
    }

    function my_ajax_callback_function() {
        $json['error'] = 2222;
        echo wp_send_json($json);
    }

    function custom_toolbox_value($key, $values) {

        //print_r($values);

        global $wpdb;
        $table = $wpdb->prefix . 'ep_ajax_custom_filter_settings';
        $getToolBoxValue = $wpdb->get_results("SELECT * FROM $table WHERE type='" . $key . "' ORDER BY name ASC");

        $toolboxvalue = [];
        foreach ($getToolBoxValue as $keys => $value):

            $pizza = $value->default_name;
            $pieces = explode(",", $pizza);

            if (array_intersect($pieces, $values)) {
                $toolboxvalue[] = [
                    'name' => $value->name,
                    'slug' => $value->value
                ];
            } //when found



        endforeach;

        return $toolboxvalue;
    }

    function toolbox_value($values, $keys) {

        //print_r($values);

        $toolboxvalue = [];
        foreach ($values as $id => $value):

            $toolbox_value = get_term_by('id', $id, $keys);
            $toolboxvalue[] = [
                'name' => $toolbox_value->name,
                'slug' => $toolbox_value->slug
            ];

        endforeach;

        return $toolboxvalue;
    }

    function attribute_slug_to_title($slug) {



        $slug = str_replace("pa_", "", $slug);

        $name = null;
        $attribute_taxonomies = wc_get_attribute_taxonomies();
        foreach ($attribute_taxonomies as $key => $tax) {

            if ($slug == $tax->attribute_name) {
                $name = $tax->attribute_label;

                break;
            }
        }
        return $name;
    }

}

new Ep_Ajax_Filters();
