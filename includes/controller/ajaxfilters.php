<?php

/**
 * @author      WALLReTuRn - Plamen Petrov
 *
 * @copyright   WebSiteToYou websitetoyou.cz
 */

namespace wstyepaf\Includes\Controller;

class Ajaxfilters {

    public $registry;

    public function __construct(\wstyepaf\Includes\Classes\EpRegistry $registry) {
        $this->registry = $registry;
    }

    public function index() {

        $query_args = array(
            'status' => 'publish',
            'post_type' => 'product',
            'order' => 'ASC',
            'orderby' => 'title'
        );
        $attributes = [];
        foreach (wc_get_products($query_args) as $product) {
            foreach ($product->get_attributes() as $taxonomy => $attribute) {
                $attribute_name = wc_attribute_label($taxonomy); // Attribute name
                // Or: 
                // $attribute_name = get_taxonomy( $taxonomy )->labels->singular_name;
                foreach ($attribute->get_terms() as $term) {


                    $attributes[$taxonomy][$term->term_id] = $term->name;
                    // Or with the product attribute label name instead:
                    // $attributes[$attribute_name][$term->term_id] = $term->name;
                }
            }
        }





        $data['attributes'] = [];
        $count = 0;
        foreach ($attributes as $key => $value):

            $data['attributes'][] = [
                'id' => $count++,
                'attribute_name' => wc_attribute_label($key),
                'attributes_key' => $key,
                'attributes_status' => $this->getStatus($key),
                'avaliable_filters' => $this->getFilterByAttribute($key)
            ];

        endforeach;
        
        sort($data['attributes']);

        $data['availablePositions'] = $this->availablePosition();

        $settings = $this->getSettings('general_settings');
        $data['generalStatus'] = $settings->status;
        $data['generalPosition'] = $settings->positions;
        $data['generalVisible'] = $settings->visible;
        $data['generalFilterType'] = $settings->filtertype;

        foreach ($data['attributes'] as $valuesss):
            // print_r($valuesss['avaliable_filters']);
        endforeach;

        $data['filter_row'] = 0;

        $data['header'] = $this->registry->loading->Ep_Ajax_Filter_loadingController('controller/common/Header');
        $data['footer'] = $this->registry->loading->Ep_Ajax_Filter_loadingController('controller/common/Footer');

        echo $this->registry->template->render('Ajaxfilters', $data);
    }

    public function getFilterByAttribute($key) {
        global $wpdb;
        $table = $wpdb->prefix . 'ep_ajax_custom_filter_settings';
        $getFilterBytype = $wpdb->get_results("SELECT * FROM $table WHERE type = '" . $key . "' ORDER BY name ASC");

        return $getFilterBytype;
    }

    public function availablePosition() {

        $position = [];
        $position[] = [
            'id' => 1,
            'name' => 'Before Shop Loop',
            'position' => 'woocommerce_before_shop_loop',
        ];
        $position[] = [
            'id' => 2,
            'name' => 'After Shop Loop',
            'position' => 'woocommerce_after_shop_loop',
        ];
        $position[] = [
            'id' => 3,
            'name' => 'Custom Position',
            'position' => 'custom_position_of_ajax_filters',
        ];

        return $position;
    }

    public function getSettings($key) {
        global $wpdb;
        $table = $wpdb->prefix . 'ep_ajax_filter_general_settings';
        $settings = $wpdb->get_row("SELECT * FROM $table WHERE settings_name = '" . $key . "'");
        return $settings;
    }

    public function getStatus($key) {
        global $wpdb;
        $tableBlocks = $wpdb->prefix . 'ep_ajax_default_filter_settings';
        $status = $wpdb->get_var("SELECT attribute_status FROM $tableBlocks WHERE attribute_name='" . $key . "'");
        return ($status);
    }

}
