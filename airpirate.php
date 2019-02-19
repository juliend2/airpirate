<?php


function sequentially_list_records($api_key, $db_id, $table_name, $view_name, $offset = null) {
    $context = stream_context_create(array(
    'http' => array(
        'method' => 'GET',
        'header' => "Content-Type: type=application/json\r\n"
            . "Authorization: Bearer ".$api_key
        )
    )
    );

    $params = array(
        'view' => $view_name
    );
    if ($offset) {
        $params['offset'] = $offset;
    }
    $query_string = http_build_query($params);
    $json_response = file_get_contents("https://api.airtable.com/v0/$db_id/$table_name?$query_string", false, $context);
    return json_decode($json_response);
}

// Do things with $func, and return the cardinality of the results
function do_with_records($api_key, $db_id, $table_name, $view_name, $func) {
    $offset = null;
    $records = array();
    $count = 0;
    do {
        $response = sequentially_list_records($api_key, $db_id, $table_name, $view_name, $offset);
        $count += count($response->records);
        if (is_callable($func)) {
            $func($response->records);
        }
    } while(isset($response->offset) && $offset = $response->offset);
    return $count;
}