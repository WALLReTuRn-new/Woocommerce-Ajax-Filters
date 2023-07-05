<?php

/*
 * WebSiteToYou License
 * Each line should be prefixed with  * 
 */


add_action('wp_ajax_update_general_settings', 'update_general_settings');
add_action('wp_ajax_nopriv_update_general_settings', 'update_general_settings');

function update_general_settings() {
    global $wpdb;
    $json = [];
    $PostData = [];
    parse_str($_POST['data'], $PostData);
    $wpdb->show_errors(true);
    $table_name = $wpdb->prefix . 'ep_ajax_filter_general_settings';

    $data = array('positions' => $PostData['general']['position'], 'visible' => $PostData['general']['visible'], 'filtertype' => $PostData['general']['filtertype'], 'status' => $PostData['general']['status']);
    $format = array('%s', '%s', '%s', '%s');
    $where = ['settings_name' => 'general_settings'];

    //If nothing found to update, it will try and create the record.
    $Select = $wpdb->query($wpdb->prepare("SELECT * FROM " . $table_name . " WHERE settings_name = 'general_settings'"));

    if ($Select !== 1) {
        $wpdb->insert($table_name, $data, $format);
    } else {
        $wpdb->update($table_name, $data, $where);
    }
    $json['error'] = $wpdb->last_error;

    echo wp_send_json($json);
}

add_action('wp_ajax_Defaul_Filters_Settings', 'Defaul_Filters_Settings');
add_action('wp_ajax_nopriv_Defaul_Filters_Settings', 'Defaul_Filters_Settings');

function Defaul_Filters_Settings() {
    global $wpdb;
    //$wpdb->show_errors(true);
    $json = [];

    $PostData = [];
    parse_str($_POST['data'], $PostData);

    $wpdb->show_errors(true);
    $table_name = $wpdb->prefix . 'ep_ajax_default_filter_settings';

    foreach ($PostData['status'] as $key => $value):
        $data = array('attribute_name' => $key, 'attribute_slug' => $key, 'attribute_status' => $value);
        $format = array('%s', '%s', '%s');
        $where = ['attribute_name' => $key];

        //If nothing found to update, it will try and create the record.
        $Select = $wpdb->query($wpdb->prepare("SELECT * FROM " . $table_name . " WHERE attribute_name = '" . $key . "'"));

        if ($Select !== 1) {
            $wpdb->insert($table_name, $data, $format);
        } else {
            $wpdb->update($table_name, $data, $where);
        }
        $json['error'] = $wpdb->last_error;

    endforeach;
    $json['das'] = $PostData;
    echo wp_send_json($json);
}

add_action('wp_ajax_Custom_Filters_Settings', 'Custom_Filters_Settings');
add_action('wp_ajax_nopriv_Custom_Filters_Settings', 'Custom_Filters_Settings');

function Custom_Filters_Settings() {
    global $wpdb;
    //$wpdb->show_errors(true);
    $json = [];

    $PostData = [];
    parse_str($_POST['data'], $PostData);

    $wpdb->show_errors(true);
    $table_name = $wpdb->prefix . 'ep_ajax_default_filter_settings';

    foreach ($PostData['status'] as $key => $value):
        $data = array('attribute_name' => $key, 'attribute_slug' => $key, 'attribute_status' => $value);
        $format = array('%s', '%s', '%s');
        $where = ['attribute_name' => $key];

        //If nothing found to update, it will try and create the record.
        $Select = $wpdb->query($wpdb->prepare("SELECT * FROM " . $table_name . " WHERE attribute_name = '" . $key . "'"));

        if ($Select !== 1) {
              $wpdb->insert($table_name, $data, $format);
        } else {
               $wpdb->update($table_name, $data, $where);
        }
        $json['error'] = $wpdb->last_error;

    endforeach;

    $table_name2 = $wpdb->prefix . 'ep_ajax_custom_filter_settings';
    foreach ($PostData['filters'] as $key2 => $values):

        $where2 = ['type' => $key2];
        $wpdb->delete($table_name2, $where2);
        foreach ($values as $val):

            $newstr = str_replace(".", "-", $val['filter_value']);
            $newstr = str_replace(" ", "-", $newstr);
            $data2 = array('name' => $val['filter_name'], 'default_name' => $val['filter_value'], 'value' => $newstr, 'slug' => $newstr, 'type' => $key2);
            $format2 = array('%s', '%s', '%s', '%s', '%s');

            $wpdb->insert($table_name2, $data2, $format2);

        endforeach;

        $json['error'] = $wpdb->last_error;
    endforeach;

    // $newstr = str_replace(".", "-", $PostData['filters']['pa_chladici-vykon'][0]['filter_value']);
    // $newstr = str_replace(" ", "-", $newstr);
    $json['data'] = $PostData;
    echo wp_send_json($json);
}
