<?php

$ExistWidgets = glob(EP_PLUGIN_DIR . 'includes/classes/widgets/*', GLOB_ONLYDIR);

foreach ($ExistWidgets as $ExistWidget):
    global $wpdb;

    $folder = substr($ExistWidget, strrpos($ExistWidget, '/') + 1);

    $filename = $ExistWidget . '/' . $folder . '.php';

    //$tableBlocks = $wpdb->prefix . 'wbsallinone_blocks';
    //$resultBlocks = $wpdb->get_row('SELECT block_status FROM ' . $tableBlocks . ' WHERE block_path = "' . $folder . '" ');


    if (file_exists($filename)):
        // if(isset($resultBlocks)):
        // if (!empty($resultBlocks->block_status == 1)):
        require 'widgets/' . $folder . '/' . $folder . '.php';


    else:
        echo "The Widget Folder Exist but file $filename does not exist";
    endif;

endforeach;

