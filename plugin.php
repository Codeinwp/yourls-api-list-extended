<?php
/*
Plugin Name: YOURLS API Action List Extended
Plugin URI: http://github.com/Codeinwp/yourls-api-list-extended
Description: YOURLS API List action with sorting, pagination, total count, and field selection
Version: 1.0.0
Author: Hardeep Asrani
Author URI: https://themeisle.com
*/

// No direct call.
if ( ! defined( 'YOURLS_ABSPATH' ) ) {
	die();
}

// Define custom action "list".
yourls_add_filter( 'api_action_list', 'ti_list_function' );

// List Function with Sorting, Pagination, Total Count, and Field Selection.
function ti_list_function() {
	$table = YOURLS_DB_TABLE_URL;

	// Set default values for sorting, offset, and per page limit
	$sort_by    = isset( $_REQUEST['sortby'] ) && in_array( $_REQUEST['sortby'], [ 'keyword', 'url', 'title', 'ip', 'timestamp', 'click' ] ) ? $_REQUEST['sortby'] : 'timestamp';
	$sort_order = isset( $_REQUEST['sortorder'] ) && in_array( strtoupper( $_REQUEST['sortorder'] ), [ 'ASC', 'DESC' ] ) ? strtoupper( $_REQUEST['sortorder'] ) : 'DESC';
	$offset     = isset( $_REQUEST['offset'] ) && is_numeric( $_REQUEST['offset'] ) ? (int)$_REQUEST['offset'] : 0;
	$perpage    = isset( $_REQUEST['perpage'] ) && is_numeric( $_REQUEST['perpage'] ) ? (int)$_REQUEST['perpage'] : 50;
	$fields     = isset( $_REQUEST['fields'] ) && is_array( $_REQUEST['fields'] ) ? $_REQUEST['fields'] : [ '*' ];

	// Validate fields to ensure the query won't break if an invalid field is requested.
	$valid_fields    = [ 'keyword', 'url', 'title', 'timestamp', 'ip', 'clicks' ];
	$selected_fields = array_intersect( $fields, $valid_fields );
	$selected_fields = ! empty( $selected_fields ) ? implode( ',', $selected_fields ) : '*';

	// Get total number of links.
	$total   = yourls_get_db()->fetchValue( "SELECT COUNT(*) FROM `$table`" );
	$query   = "SELECT $selected_fields FROM `$table` ORDER BY `$sort_by` $sort_order LIMIT $offset, $perpage";
	$results = yourls_get_db()->fetchObjects( $query );

	// Return the response with results and total count.
	return array(
		'statusCode' => 200,
		'message'    => 'success',
		'result'     => $results,
		'total'      => $total,
		'offset'     => $offset,
		'perpage'    => $perpage,
	);
}
