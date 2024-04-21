<?php
/**
 * Theme storage manipulations
 *
 * @package WordPress
 * @subpackage SMART_CASA
 * @since SMART_CASA 1.0
 */

// Disable direct call
if ( ! defined( 'ABSPATH' ) ) { exit; }

// Get theme variable
if (!function_exists('smart_casa_storage_get')) {
	function smart_casa_storage_get($var_name, $default='') {
		global $SMART_CASA_STORAGE;
		return isset($SMART_CASA_STORAGE[$var_name]) ? $SMART_CASA_STORAGE[$var_name] : $default;
	}
}

// Set theme variable
if (!function_exists('smart_casa_storage_set')) {
	function smart_casa_storage_set($var_name, $value) {
		global $SMART_CASA_STORAGE;
		$SMART_CASA_STORAGE[$var_name] = $value;
	}
}

// Check if theme variable is empty
if (!function_exists('smart_casa_storage_empty')) {
	function smart_casa_storage_empty($var_name, $key='', $key2='') {
		global $SMART_CASA_STORAGE;
		if (!empty($key) && !empty($key2))
			return empty($SMART_CASA_STORAGE[$var_name][$key][$key2]);
		else if (!empty($key))
			return empty($SMART_CASA_STORAGE[$var_name][$key]);
		else
			return empty($SMART_CASA_STORAGE[$var_name]);
	}
}

// Check if theme variable is set
if (!function_exists('smart_casa_storage_isset')) {
	function smart_casa_storage_isset($var_name, $key='', $key2='') {
		global $SMART_CASA_STORAGE;
		if (!empty($key) && !empty($key2))
			return isset($SMART_CASA_STORAGE[$var_name][$key][$key2]);
		else if (!empty($key))
			return isset($SMART_CASA_STORAGE[$var_name][$key]);
		else
			return isset($SMART_CASA_STORAGE[$var_name]);
	}
}

// Inc/Dec theme variable with specified value
if (!function_exists('smart_casa_storage_inc')) {
	function smart_casa_storage_inc($var_name, $value=1) {
		global $SMART_CASA_STORAGE;
		if (empty($SMART_CASA_STORAGE[$var_name])) $SMART_CASA_STORAGE[$var_name] = 0;
		$SMART_CASA_STORAGE[$var_name] += $value;
	}
}

// Concatenate theme variable with specified value
if (!function_exists('smart_casa_storage_concat')) {
	function smart_casa_storage_concat($var_name, $value) {
		global $SMART_CASA_STORAGE;
		if (empty($SMART_CASA_STORAGE[$var_name])) $SMART_CASA_STORAGE[$var_name] = '';
		$SMART_CASA_STORAGE[$var_name] .= $value;
	}
}

// Get array (one or two dim) element
if (!function_exists('smart_casa_storage_get_array')) {
	function smart_casa_storage_get_array($var_name, $key, $key2='', $default='') {
		global $SMART_CASA_STORAGE;
		if ( '' === $key2 ) {
			return ! empty( $var_name ) && '' !== $key && isset( $SMART_CASA_STORAGE[ $var_name ][ $key ] ) ? $SMART_CASA_STORAGE[ $var_name ][ $key ] : $default;
		} else {
			return ! empty( $var_name ) && '' !== $key && isset( $SMART_CASA_STORAGE[ $var_name ][ $key ][ $key2 ] ) ? $SMART_CASA_STORAGE[ $var_name ][ $key ][ $key2 ] : $default;
		}
	}
}

// Set array element
if (!function_exists('smart_casa_storage_set_array')) {
	function smart_casa_storage_set_array($var_name, $key, $value) {
		global $SMART_CASA_STORAGE;
		if (!isset($SMART_CASA_STORAGE[$var_name])) $SMART_CASA_STORAGE[$var_name] = array();
		if ($key==='')
			$SMART_CASA_STORAGE[$var_name][] = $value;
		else
			$SMART_CASA_STORAGE[$var_name][$key] = $value;
	}
}

// Set two-dim array element
if (!function_exists('smart_casa_storage_set_array2')) {
	function smart_casa_storage_set_array2($var_name, $key, $key2, $value) {
		global $SMART_CASA_STORAGE;
		if (!isset($SMART_CASA_STORAGE[$var_name])) $SMART_CASA_STORAGE[$var_name] = array();
		if (!isset($SMART_CASA_STORAGE[$var_name][$key])) $SMART_CASA_STORAGE[$var_name][$key] = array();
		if ($key2==='')
			$SMART_CASA_STORAGE[$var_name][$key][] = $value;
		else
			$SMART_CASA_STORAGE[$var_name][$key][$key2] = $value;
	}
}

// Merge array elements
if (!function_exists('smart_casa_storage_merge_array')) {
	function smart_casa_storage_merge_array($var_name, $key, $value) {
		global $SMART_CASA_STORAGE;
		if (!isset($SMART_CASA_STORAGE[$var_name])) $SMART_CASA_STORAGE[$var_name] = array();
		if ($key==='')
			$SMART_CASA_STORAGE[$var_name] = array_merge($SMART_CASA_STORAGE[$var_name], $value);
		else
			$SMART_CASA_STORAGE[$var_name][$key] = array_merge($SMART_CASA_STORAGE[$var_name][$key], $value);
	}
}

// Add array element after the key
if (!function_exists('smart_casa_storage_set_array_after')) {
	function smart_casa_storage_set_array_after($var_name, $after, $key, $value='') {
		global $SMART_CASA_STORAGE;
		if (!isset($SMART_CASA_STORAGE[$var_name])) $SMART_CASA_STORAGE[$var_name] = array();
		if (is_array($key))
			smart_casa_array_insert_after($SMART_CASA_STORAGE[$var_name], $after, $key);
		else
			smart_casa_array_insert_after($SMART_CASA_STORAGE[$var_name], $after, array($key=>$value));
	}
}

// Add array element before the key
if (!function_exists('smart_casa_storage_set_array_before')) {
	function smart_casa_storage_set_array_before($var_name, $before, $key, $value='') {
		global $SMART_CASA_STORAGE;
		if (!isset($SMART_CASA_STORAGE[$var_name])) $SMART_CASA_STORAGE[$var_name] = array();
		if (is_array($key))
			smart_casa_array_insert_before($SMART_CASA_STORAGE[$var_name], $before, $key);
		else
			smart_casa_array_insert_before($SMART_CASA_STORAGE[$var_name], $before, array($key=>$value));
	}
}

// Push element into array
if (!function_exists('smart_casa_storage_push_array')) {
	function smart_casa_storage_push_array($var_name, $key, $value) {
		global $SMART_CASA_STORAGE;
		if (!isset($SMART_CASA_STORAGE[$var_name])) $SMART_CASA_STORAGE[$var_name] = array();
		if ($key==='')
			array_push($SMART_CASA_STORAGE[$var_name], $value);
		else {
			if (!isset($SMART_CASA_STORAGE[$var_name][$key])) $SMART_CASA_STORAGE[$var_name][$key] = array();
			array_push($SMART_CASA_STORAGE[$var_name][$key], $value);
		}
	}
}

// Pop element from array
if (!function_exists('smart_casa_storage_pop_array')) {
	function smart_casa_storage_pop_array($var_name, $key='', $defa='') {
		global $SMART_CASA_STORAGE;
		$rez = $defa;
		if ($key==='') {
			if (isset($SMART_CASA_STORAGE[$var_name]) && is_array($SMART_CASA_STORAGE[$var_name]) && count($SMART_CASA_STORAGE[$var_name]) > 0) 
				$rez = array_pop($SMART_CASA_STORAGE[$var_name]);
		} else {
			if (isset($SMART_CASA_STORAGE[$var_name][$key]) && is_array($SMART_CASA_STORAGE[$var_name][$key]) && count($SMART_CASA_STORAGE[$var_name][$key]) > 0) 
				$rez = array_pop($SMART_CASA_STORAGE[$var_name][$key]);
		}
		return $rez;
	}
}

// Inc/Dec array element with specified value
if (!function_exists('smart_casa_storage_inc_array')) {
	function smart_casa_storage_inc_array($var_name, $key, $value=1) {
		global $SMART_CASA_STORAGE;
		if (!isset($SMART_CASA_STORAGE[$var_name])) $SMART_CASA_STORAGE[$var_name] = array();
		if (empty($SMART_CASA_STORAGE[$var_name][$key])) $SMART_CASA_STORAGE[$var_name][$key] = 0;
		$SMART_CASA_STORAGE[$var_name][$key] += $value;
	}
}

// Concatenate array element with specified value
if (!function_exists('smart_casa_storage_concat_array')) {
	function smart_casa_storage_concat_array($var_name, $key, $value) {
		global $SMART_CASA_STORAGE;
		if (!isset($SMART_CASA_STORAGE[$var_name])) $SMART_CASA_STORAGE[$var_name] = array();
		if (empty($SMART_CASA_STORAGE[$var_name][$key])) $SMART_CASA_STORAGE[$var_name][$key] = '';
		$SMART_CASA_STORAGE[$var_name][$key] .= $value;
	}
}

// Call object's method
if (!function_exists('smart_casa_storage_call_obj_method')) {
	function smart_casa_storage_call_obj_method($var_name, $method, $param=null) {
		global $SMART_CASA_STORAGE;
		if ($param===null)
			return !empty($var_name) && !empty($method) && isset($SMART_CASA_STORAGE[$var_name]) ? $SMART_CASA_STORAGE[$var_name]->$method(): '';
		else
			return !empty($var_name) && !empty($method) && isset($SMART_CASA_STORAGE[$var_name]) ? $SMART_CASA_STORAGE[$var_name]->$method($param): '';
	}
}

// Get object's property
if (!function_exists('smart_casa_storage_get_obj_property')) {
	function smart_casa_storage_get_obj_property($var_name, $prop, $default='') {
		global $SMART_CASA_STORAGE;
		return !empty($var_name) && !empty($prop) && isset($SMART_CASA_STORAGE[$var_name]->$prop) ? $SMART_CASA_STORAGE[$var_name]->$prop : $default;
	}
}
?>