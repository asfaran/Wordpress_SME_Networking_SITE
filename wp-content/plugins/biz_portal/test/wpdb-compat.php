<?php

/**
 * It is possible to replace wpdb with your own
 * by setting the $wpdb global variable in wp-content/db.php
 * file to your class.
 * Of course, wpdb methods and properties need to be supported.
 * This interface exists to assure the compatibility with wpdb.
 *
 * @package WordPress
 * @subpackage Database
 */
interface wpdb_compat {
    public $show_errors;
	public $suppress_errors;
	public $last_error;
	public $num_queries;
	public $num_rows;
	public $rows_affected;
	public $insert_id;
	public $last_query;
	public $last_result;
	public $col_info;
	public $queries;
	public $prefix;
	public $ready;
	public $blogid;
	public $siteid;
	public $tables;
	public $old_tables;
	public $global_tables;
	public $ms_global_tables;
	public $comments;
	public $commentmeta;
	public $links;
	public $options;
	public $postmeta;
	public $posts;
	public $terms;
	public $term_relationships;
	public $term_taxonomy;
	public $usermeta;
	public $users;
	public $blogs;
	public $blog_versions;
	public $registration_log;
	public $signups;
	public $site;
	public $sitecategories;
	public $sitemeta;
	public $field_types;
	public $charset;
	public $collate;
	public $real_escape;
	public $dbuser;
	public $func_call;
	public $is_mysql;
	
	public function __construct($dbuser, $dbpassword, $dbname, $dbhost);
	public function __destruct();
	public function init_charset();
	public function set_charset($dbh, $charset, $collate);
	public function set_prefix($prefix, $set_table_names);
	public function set_blog_id($blog_id, $site_id);
	public function get_blog_prefix($blog_id);
	public function tables($scope, $prefix, $blog_id);
	public function select($db, $dbh);
	public function _weak_escape($string);
	public function _real_escape($string);
	public function _escape($data);
	public function escape($data);
	public function escape_by_ref(&$string);
	public function prepare($query);
	public function print_error($str);
	public function show_errors($show);
	public function hide_errors();
	public function flush();
	public function db_connect();
	public function query($query);
	public function insert($table, $data, $format);
	public function replace($table, $data, $format);
	public function update($table, $data, $where, $format, $where_format);
	public function get_var($query, $x, $y);
	public function get_row($query, $output, $y);
	public function get_col($query, $x);
	public function get_results($query, $output);
	public function get_col_info($info_type, $col_offset);
	public function timer_start();
	public function timer_stop();
	public function bail($message, $error_code);
	public function check_database_version();
	public function supports_collation();
	public function has_cap($db_cap);
	public function get_caller();
	public function db_version();
}

?>