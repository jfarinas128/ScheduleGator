<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * CodeIgniter
 *
 * An open source application development framework for PHP 5.1.6 or newer
 *
 * @package		CodeIgniter
 * @author		ExpressionEngine Dev Team
 * @copyright	Copyright (c) 2008 - 2011, EllisLab, Inc.
 * @license		http://codeigniter.com/user_guide/license.html
 * @link		http://codeigniter.com
 * @since		Version 1.0
 * @filesource
*/

// ------------------------------------------------------------------------

/**
 * CodeIgniter Model Class
 *
 * @package		CodeIgniter
 * @subpackage	Libraries
 * @category	Libraries
 * @author		ExpressionEngine Dev Team
 * @link		http://codeigniter.com/user_guide/libraries/config.html
*/
class CI_Model {

	public $table_name = false;

	/**
	 * Constructor
	 *
	 * @access public
	 */
	function __construct()
	{
		log_message('debug', "Model Class Initialized");
	}

	/**
	 * __get
	 *
	 * Allows models to access CI's loaded classes using the same
	 * syntax as controllers.
	 *
	 * @param	string
	 * @access private
	 */
	function __get($key)
	{
		$CI =& get_instance();
		return $CI->$key;
	}

	function create($values, $columns = false) {
		if($this->table_name != false) {


			 
			$column_names = '';
			$values_str = '';
			if($columns !=false) {
				$column_names .= "(";
				foreach($columns as $name){
					$column_names .= $name.',';
				}
				$column_names = substr($column_names, 0, -1);
				$column_names .= ") ";
			
				foreach($values as $value){
					$values_str .= "'".$this->db->escape_str($value)."',";
				}
				$values_str = substr($values_str, 0, -1);
			}
			else {

				$column_names .= "(";
				foreach($values as $column => $value) {
					$column_names .= $column.',';
					$values_str .= "'".$this->db->escape_str($value)."',";

				}
				$column_names = substr($column_names, 0, -1);
				$column_names .= ") ";
				$values_str = substr($values_str, 0, -1);
			}
			$sql = 'INSERT INTO '.$this->table_name.' '.$column_names.' VALUES('.$values_str.');';
			
			$query = $this->db->query($sql);
			if($query) {
				return true;
			}
		}
		return false;
	}

	function exists($field, $value) {
		if($this->table_name != false) {
			$sql  = "select 1 from ".$this->table_name." where $field = ? ;";
			if($result = $this->db->query($sql, array($value))) {
				if($result->num_rows() > 0)
					return true;
			}
		}

		return false;
	}
}
// END Model Class

/* End of file Model.php */
/* Location: ./system/core/Model.php */