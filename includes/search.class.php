<?php
/* Prevent direct access */
defined('ABSPATH') or die("You can't access this file directly.");

if (!class_exists('wpdreams_search')) {
	/**
	 * Search class Abstract
	 *
	 * All search classes should be descendants to this abstract.
	 *
	 * @class       wpdreams_search
	 * @version     1.1
	 * @package     AjaxSearchPro/Abstracts
	 * @category    Class
	 * @author      Ernest Marcinko
	 */
	abstract class wpdreams_search {

		/**
		 * @var array of parameters
		 */
		protected $params;
		/**
		 * @var array of submitted options from the front end
		 */
		protected $options;
		/**
		 * @var int the ID of the current search instance
		 */
		protected $searchId;
		/**
		 * @var array of the current search options
		 */
		protected $searchData;
		/**
		 * @var array of results
		 */
		protected $results;
		/**
		 * @var string the search phrase
		 */
		protected $s;
		/**
		 * @var array of each search phrase
		 */
		protected $_s;

		/**
		 * Create the class
		 *
		 * @param $params
		 */
		function __construct($params) {

			$this->params = $params;

			// Pass the general options
			$options = w_isset_def($params['options'], array());

			// Set a few values for faster usage
			$options['set_exactonly'] = (isset($params['options']['set_exactonly'])?true:false);
			$options['set_intitle'] = (isset($params['options']['set_intitle'])?true:false);
			$options['set_incontent'] = (isset($params['options']['set_incontent'])?true:false);
			$options['set_incomments'] = (isset($params['options']['set_incomments'])?true:false);
			$options['set_inexcerpt'] = (isset($params['options']['set_inexcerpt'])?true:false);
			$options['set_inposts'] = (isset($params['options']['set_inposts'])?true:false);
			$options['set_inpages'] = (isset($params['options']['set_inpages'])?true:false);
			$options['searchinterms'] = (($params['data']['searchinterms']==1)?true:false);
			$options['set_inbpusers'] = (isset($params['options']['set_inbpusers'])?true:false);
			$options['set_inbpgroups'] = (isset($params['options']['set_inbpgroups'])?true:false);
			$options['set_inbpforums'] = (isset($params['options']['set_inbpforums'])?true:false);

			$options['maxresults'] = $params['data']['maxresults'];
			$options['do_group'] = ($params['data']['resultstype'] == 'vertical') ? true : false;

			$this->options = $options;
			$this->searchId = 1;
			$this->searchData = $params['data'];
			if (isset($this->searchData['image_options']))
				$this->imageSettings = $this->searchData['image_options'];

		}

		/**
		 * Initiates the search operation
		 *
		 * @param $keyword
		 * @return array
		 */
		public function search($keyword) {
			global $wpdb;

			$this->s = $this->escape( $keyword );

			$this->_s = $this->escape( array_unique( explode(" ", $this->s) ) );

			$this->do_search();
			$this->post_process();
			$this->group();

			return is_array($this->results) ? $this->results : array();
		}

		/**
		 * The search function
		 */
		protected function do_search() {
			global $wpdb;

			if (isset($wpdb->base_prefix)) {
				$_prefix = $wpdb->base_prefix;
			} else {
				$_prefix = $wpdb->prefix;
			}

			$options = $this->options;
			$searchData = $this->searchData;
			$s = $this->s;
			$_s = $this->_s;

		}

		/**
		 * Post processing abstract
		 */
		protected function post_process() {

			$commentsresults = $this->results;
			$options = $this->options;
			$searchData = $this->searchData;
			$s = $this->s;
			$_s = $this->_s;

			if (is_array($this->results) && count($this->results) > 0) {
				foreach ($this->results as $k => $v) {

					$r = & $this->results[$k];

					if (!is_object($r) || count($r) <= 0) continue;
					if (!isset($r->id)) $r->id = 0;
					$r->image = isset($r->image) ? $r->image : "";
					$r->title = apply_filters('asl_result_title_before_prostproc', $r->title, $r->id);
					$r->content = apply_filters('asl_result_content_before_prostproc', $r->content, $r->id);
					$r->image = apply_filters('asl_result_image_before_prostproc', $r->image, $r->id);
					$r->author = apply_filters('asl_result_author_before_prostproc', $r->author, $r->id);
					$r->date = apply_filters('asl_result_date_before_prostproc', $r->date, $r->id);


					$r->title = apply_filters('asl_result_title_after_prostproc', $r->title, $r->id);
					$r->content = apply_filters('asl_result_content_after_prostproc', $r->content, $r->id);
					$r->image = apply_filters('asl_result_image_after_prostproc', $r->image, $r->id);
					$r->author = apply_filters('asl_result_author_after_prostproc', $r->author, $r->id);
					$r->date = apply_filters('asl_result_date_after_prostproc', $r->date, $r->id);

				}
			}

		}

		/**
		 * Performs a full escape
		 *
		 * @uses wd_mysql_escape_mimic()
		 * @param $string
		 * @return array|mixed
		 */
		protected function escape( $string ) {
			global $wpdb;

			// recursively go through if it is an array
			if ( is_array($string) ) {
				foreach ($string as $k => $v) {
					$string[$k] = $this->escape($v);
				}
				return $string;
			}

			if ( is_float( $string ) )
				return $string;

			// Escape support for WP < 4.0
			if ( method_exists( $wpdb, 'esc_like' ) )
				return esc_sql( $wpdb->esc_like($string) );

			return esc_sql( wd_mysql_escape_mimic($string) );
		}

		/**
		 * Converts a string to number, array of strings to array of numbers
		 *
		 * Since esc_like() does not escape numeric values, casting them is the easiest way to go
		 *
		 * @param $number string or array of strings
		 * @return mixed number or array of numbers
		 */
		protected function force_numeric ( $number ) {
			if ( is_array($number) )
				foreach ($number as $k => $v)
					$number[$k] = $v + 0;
			else
				$number = $number + 0;

			return $number;
		}

		/**
		 * Grouping abstract
		 */
		protected function group() {

			$commentsresults = $this->results;
			$options = $this->options;
			$searchData = $this->searchData;
			$s = $this->s;
			$_s = $this->_s;

		}

	}
}