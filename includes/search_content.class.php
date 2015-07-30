<?php
/* Prevent direct access */
defined( 'ABSPATH' ) or die( "You can't access this file directly." );

if ( ! class_exists( 'wpdreams_searchContent' ) ) {
	class wpdreams_searchContent extends wpdreams_search {

		protected function do_search() {
			global $wpdb;
			global $q_config;

			$options    = $this->options;
			$searchData = $this->searchData;

			$parts           = array();
			$relevance_parts = array();
			$types           = array();
			$post_types      = "";
			$term_query      = "(1)";
			$post_statuses   = "";
			$term_join       = "";
			$postmeta_join   = "";

			$s  = $this->s; // full keyword
			$_s = $this->_s;    // array of keywords

			$_si = implode( '|', $_s ); // imploded phrase for regexp
			$_si = $_si != '' ? $_si : $s;

			$q_config['language'] = $options['qtranslate_lang'];

			/*------------------------- Statuses ----------------------------*/
			$post_statuses = "( $wpdb->posts.post_status = 'publish')";
			/*---------------------------------------------------------------*/

			/*----------------------- Gather Types --------------------------*/
			//var_dump($options);
			if ($options['set_inposts'] == 1)
				$types[] = "post";
			if ($options['set_inpages'])
				$types[] = "page";
			if (isset($options['customset']) && count($options['customset']) > 0)
				$types = array_merge($types, $options['customset']);
			if (count($types) < 1) {
				return '';
			} else {
				$words = implode("','", $types);
				$post_types = "($wpdb->posts.post_type IN ('$words') )";
			}
			/*---------------------------------------------------------------*/

			/*----------------------- Title query ---------------------------*/
			if ( $options['set_intitle'] ) {
				$words = $options['set_exactonly'] == 1 ? array( $s ) : $_s;
				//$parts[] = "(lower($wpdb->posts.post_title) REGEXP '$words')";

				$op = 'OR';
				if ( count( $_s ) > 0 ) {
					$_like = implode( "%' " . $op . " $wpdb->posts.post_title LIKE '%", $words );
				} else {
					$_like = $s;
				}
				$parts[] = "( $wpdb->posts.post_title LIKE '%" . $_like . "%' )";

				$relevance_parts[] = "(case when
                ($wpdb->posts.post_title REGEXP '$s')
                 then 10 else 0 end)";
			}
			/*---------------------------------------------------------------*/

			/*---------------------- Content query --------------------------*/
			if ( $options['set_incontent'] ) {
				$words = $options['set_exactonly'] == 1 ? array( $s ) : $_s;
				//$parts[] = "(lower($wpdb->posts.post_content) REGEXP '$words')";

				$op = 'OR';
				if ( count( $_s ) > 0 ) {
					$_like = implode( "%' " . $op . " $wpdb->posts.post_content LIKE '%", $words );
				} else {
					$_like = $s;
				}
				$parts[] = "( $wpdb->posts.post_content LIKE '%" . $_like . "%' )";

				$relevance_parts[] = "(case when
                ($wpdb->posts.post_content REGEXP '$s')
                 then 7 else 0 end)";
			}
			/*---------------------------------------------------------------*/

			/*---------------------- Excerpt query --------------------------*/
			if ( $options['set_inexcerpt'] ) {
				$words = $options['set_exactonly'] == 1 ? array( $s ) : $_s;
				//$parts[] = "(lower($wpdb->posts.post_excerpt) REGEXP '$words')";

				$op = 'OR';
				if ( count( $_s ) > 0 ) {
					$_like = implode( "%' " . $op . " $wpdb->posts.post_excerpt LIKE '%", $words );
				} else {
					$_like = $s;
				}
				$parts[] = "( $wpdb->posts.post_excerpt LIKE '%" . $_like . "%' )";

				$relevance_parts[] = "(case when
                ($wpdb->posts.post_excerpt REGEXP '$s')
                 then 7 else 0 end)";
			}
			/*---------------------------------------------------------------*/

			/*------------------------ Term query ---------------------------*/
			if ( $options['searchinterms'] ) {
				$words = $options['set_exactonly'] == 1 ? array( $s ) : $_s;
				//$parts[] = "(lower($wpdb->terms.name) REGEXP '$words')";

				$op = 'OR';
				if ( count( $_s ) > 0 ) {
					$_like = implode( "%' " . $op . " $wpdb->terms.name LIKE '%", $words );
				} else {
					$_like = $s;
				}
				$parts[] = "( $wpdb->terms.name LIKE '%" . $_like . "%' )";

				$relevance_parts[] = "(case when
                ($wpdb->terms.name REGEXP '$s')
                 then 5 else 0 end)";
			}
			/*---------------------------------------------------------------*/

			/*---------------------- Custom Fields --------------------------*/
			if ( isset( $searchData['selected-customfields'] ) ) {
				$selected_customfields = $searchData['selected-customfields'];
				if ( is_array( $selected_customfields ) && count( $selected_customfields ) > 0 ) {
					$words = $options['set_exactonly'] == 1 ? $s : $_si;
					foreach ( $selected_customfields as $cfield ) {
						$parts[] = "($wpdb->postmeta.meta_key='$cfield' AND
                                   $wpdb->postmeta.meta_value REGEXP '$words')";
					}
					$postmeta_join = "LEFT JOIN $wpdb->postmeta ON $wpdb->postmeta.post_id = $wpdb->posts.ID";
				}
			}
			/*---------------------------------------------------------------*/


			// ------------------------ Categories/taxonomies ----------------------
			/*if (
				w_isset_def($searchData['showsearchincategories'], 0) == 1 &&
				w_isset_def($searchData['show_frontend_search_settings'], 1) == 1
			) {
			  if (!isset($options['categoryset']) || $options['categoryset'] == "")
				  $options['categoryset'] = array();
			  if (!isset($options['termset']) || $options['termset'] == "")
				  $options['termset'] = array();

			  $exclude_categories = array();
			  $searchData['selected-exsearchincategories'] = w_isset_def($searchData['selected-exsearchincategories'], array());
			  $searchData['selected-excludecategories'] = w_isset_def($searchData['selected-excludecategories'], array());
			  $_all_cat = get_all_category_ids();
			  $_needed_cat = array_diff($_all_cat, $searchData['selected-exsearchincategories']);
			  $_needed_cat = !is_array($_needed_cat)?array():$_needed_cat;
			  $exclude_categories = array_diff(array_merge($_needed_cat, $searchData['selected-excludecategories']), $options['categoryset']);

			  $exclude_terms = array();
			  $exclude_showterms = array();
			  $searchData['selected-showterms'] = w_isset_def($searchData['selected-showterms'], array());
			  $searchData['selected-excludeterms'] = w_isset_def($searchData['selected-excludeterms'], array());
			  foreach ($searchData['selected-excludeterms'] as $tax=>$terms) {
				  $exclude_terms = array_merge($exclude_terms, $terms);
			  }
			  foreach ($searchData['selected-showterms'] as $tax=>$terms) {
				  $exclude_showterms = array_merge($exclude_showterms, $terms);
			  }

			  $exclude_terms = array_diff(array_merge($exclude_terms, $exclude_showterms), $options['termset']);

			  $all_terms = array();
			  $all_terms = array_merge($exclude_categories, $exclude_terms);
			  if (count($all_terms) > 0) {
				  $words = '--'.implode('--|--', $all_terms).'--';
				  $term_query = "HAVING (ttid NOT REGEXP '$words')";
			  }
			} else {
			   $ex_cat = w_isset_def($searchData['selected-excludecategories'], array());
				if (count($ex_cat) > 0) {
					$words = '--'.implode('--|--', $ex_cat).'--';
					$term_query = "HAVING (ttid NOT REGEXP '$words')";
				}
			}*/
			// ---------------------------------------------------------------------


			// ------------------------ Categories/taxonomies ----------------------
			if ( ! isset( $options['categoryset'] ) || $options['categoryset'] == "" ) {
				$options['categoryset'] = array();
			}
			if ( ! isset( $options['termset'] ) || $options['termset'] == "" ) {
				$options['termset'] = array();
			}

			$term_logic = 'and';

			$exclude_categories                          = array();
			$searchData['selected-exsearchincategories'] = w_isset_def( $searchData['selected-exsearchincategories'], array() );
			$searchData['selected-excludecategories']    = w_isset_def( $searchData['selected-excludecategories'], array() );

			if ( count( $searchData['selected-exsearchincategories'] ) > 0 ||
			     count( $searchData['selected-excludecategories'] ) > 0 ||
			     count( $options['categoryset'] ) > 0
			) {
				// If the category settings are invisible, ignore the excluded frontend categories, reset to empty array
				if ( $searchData['showsearchincategories'] == 0 ) {
					$searchData['selected-exsearchincategories'] = array();
				}

				$_all_cat    = get_terms( 'category', array( 'fields' => 'ids' ) );
				$_needed_cat = array_diff( $_all_cat, $searchData['selected-exsearchincategories'] );
				$_needed_cat = ! is_array( $_needed_cat ) ? array() : $_needed_cat;

				if ( $term_logic == 'and' ) {
					$exclude_categories = array_diff( array_merge( $_needed_cat, $searchData['selected-excludecategories'] ), $options['categoryset'] );
				} else {
					$exclude_categories = $options['categoryset'];
				}

				// If every category is selected, then we don't need to filter anything out.
				if ( count( $exclude_categories ) == count( $_all_cat ) ) {
					$exclude_categories = array();
				}
			}

			$exclude_terms = array();

			if (w_isset_def($searchData['exclude_term_ids'], "") != "") {
				$exclude_terms = explode( ",", str_replace( array("\r", "\n"), '', $searchData['exclude_term_ids'] ) );
			}

			$all_terms = array();
			$all_terms = array_unique( array_merge( $exclude_categories, $exclude_terms ) );

			/**
			 *  New method
			 *
			 *  This is way more efficient, despite it looks more complicated.
			 *  Multiple sub-select is not an issue, since the query can use PRIMARY keys as indexes
			 */
			if ( count( $all_terms ) > 0 ) {
				$words = implode( ',', $all_terms );

				// Quick explanation for the AND
				// .. MAIN SELECT: selects all object_ids that are not in the array
				// .. SUBSELECT:   excludes all the object_ids that are part of the array
				// This is used because of multiple object_ids (posts in more than 1 category)
				if ( $term_logic == 'and' ) {
					$term_query = "(
						$wpdb->posts.ID IN (
							SELECT DISTINCT(tr.object_id)
								FROM $wpdb->term_relationships AS tr
								WHERE
									tr.term_taxonomy_id NOT IN ($words)
									AND tr.object_id NOT IN (
										SELECT DISTINCT(trs.object_id)
										FROM $wpdb->term_relationships AS trs
										WHERE trs.term_taxonomy_id IN ($words)
									)
						)
					)";
				} else {
					$term_query = "( $wpdb->posts.ID IN ( SELECT DISTINCT(tr.object_id) FROM wp_term_relationships AS tr WHERE tr.term_taxonomy_id IN ($words) ) )";
				}
			}


			/*------------ ttids in the main SELECT, we might not need it ---------*/
			// ttid is only used if grouping by category or filtering by category is active
			// LITE VERSION DOESNT NEED THESE
			// ---------------------------------------------------------------------


			/*------------------------ Exclude id's -------------------------*/
			if ( isset( $searchData['excludeposts'] ) && $searchData['excludeposts'] != "" ) {
				$exclude_posts = "($wpdb->posts.ID NOT IN (" . $searchData['excludeposts'] . "))";
			} else {
				$exclude_posts = "($wpdb->posts.ID NOT IN (-55))";
			}
			/*---------------------------------------------------------------*/

			/*------------------------ Term JOIN -------------------------*/
			// If the search in terms is not active, we don't need this unnecessary big join
			$term_join = "";
			if ( $options['searchinterms'] ) {
				$term_join = "
                LEFT JOIN $wpdb->term_relationships ON $wpdb->posts.ID = $wpdb->term_relationships.object_id
                LEFT JOIN $wpdb->term_taxonomy ON $wpdb->term_taxonomy.term_taxonomy_id = $wpdb->term_relationships.term_taxonomy_id
                LEFT JOIN $wpdb->terms ON $wpdb->term_taxonomy.term_id = $wpdb->terms.term_id";
			}
			/*---------------------------------------------------------------*/

			/*------------------------- Build like --------------------------*/
			$like_query = implode( ' OR ', $parts );
			if ( $like_query == "" ) {
				$like_query = "(1)";
			} else {
				$like_query = "($like_query)";
			}
			/*---------------------------------------------------------------*/

			/*---------------------- Build relevance ------------------------*/
			$relevance = implode( ' + ', $relevance_parts );
			if ( $relevance == "" ) {
				$relevance = "(1)";
			} else {
				$relevance = "($relevance)";
			}
			/*---------------------------------------------------------------*/


			/*------------------------- WPML filter -------------------------*/
			$wpml_query = "(1)";
			if ( isset($options['wpml_lang'])
			     && w_isset_def($searchData['wpml_compatibility'], 1) == 1
			)
				$wpml_query = "
				EXISTS (
					SELECT DISTINCT(wpml.element_id)
					FROM " . $wpdb->base_prefix . "icl_translations as wpml
					WHERE
	                    $wpdb->posts.ID = wpml.element_id AND
	                    wpml.language_code = '" . $this->escape($options['wpml_lang']) . "' AND
	                    wpml.element_type LIKE 'post_%'
                )";
			/*---------------------------------------------------------------*/


			$orderby  = ( ( isset( $searchData['selected-orderby'] ) && $searchData['selected-orderby'] != '' ) ? $searchData['selected-orderby'] : "post_date DESC" );
			$querystr = "
    		SELECT 
          $wpdb->posts.post_title as title,
          $wpdb->posts.ID as id,
          $wpdb->posts.post_date as date,               
          $wpdb->posts.post_content as content,
          $wpdb->posts.post_excerpt as excerpt,
	        (SELECT
	            $wpdb->users.display_name as author
	            FROM $wpdb->users
	            WHERE $wpdb->users.ID = $wpdb->posts.post_author
	        ) as author,
          '' as ttid,
          $wpdb->posts.post_type as post_type,
          $relevance as relevance
    		FROM $wpdb->posts
        $postmeta_join
        $term_join
    	WHERE
                $post_types
            AND $post_statuses
            AND $term_query
            AND $like_query
            AND $exclude_posts
            AND $wpml_query
        GROUP BY
          $wpdb->posts.ID
         ";
			$querystr .= " ORDER BY relevance DESC, " . $wpdb->posts . "." . $orderby . "
        LIMIT " . $searchData['maxresults'];

			$pageposts = $wpdb->get_results( $querystr, OBJECT );
			//var_dump($querystr);die("!!");
			//var_dump($pageposts);die("!!");

			$this->results = $pageposts;


			return $pageposts;

		}

		protected function post_process() {

			$pageposts  = is_array( $this->results ) ? $this->results : array();
			$options    = $this->options;
			$searchData = $this->searchData;
			$s          = $this->s;
			$_s         = $this->_s;


			if ( is_multisite() ) {
				$home_url = network_home_url();
			} else {
				$home_url = home_url();
			}

			foreach ( $pageposts as $k => $v ) {
				$r          = &$pageposts[ $k ];
				$r->title   = w_isset_def( $r->title, null );
				$r->content = w_isset_def( $r->content, null );
				$r->image   = w_isset_def( $r->image, null );
				$r->author  = w_isset_def( $r->author, null );
				$r->date    = w_isset_def( $r->date, null );
			}

			/* Images, title, desc */
			foreach ( $pageposts as $k => $v ) {

				// Let's simplify things
				$r = &$pageposts[ $k ];

				$r->title   = apply_filters( 'asl_result_title_before_prostproc', $r->title, $r->id );
				$r->content = apply_filters( 'asl_result_content_before_prostproc', $r->content, $r->id );
				$r->image   = apply_filters( 'asl_result_image_before_prostproc', $r->image, $r->id );
				$r->author  = apply_filters( 'asl_result_author_before_prostproc', $r->author, $r->id );
				$r->date    = apply_filters( 'asl_result_date_before_prostproc', $r->date, $r->id );

				$r->link = get_permalink( $v->id );

				$image_settings = $searchData['image_options'];

				if ( $image_settings['show_images'] != 0 ) {
					/*
					$im = $this->getTimThumbImage($r);
					if ($im != '' && strpos($im, "mshots/v1") === false)
						$r->image = $home_url . '/wp-content/plugins/ajax-search-lite/includes/timthumb.php' . '?ct=' . $image_settings['image_transparency'] . '&cc=' . str_replace('#', '', wpdreams_rgb2hex($image_settings['image_bg_color'])) . '&q=95&w=' . $image_settings['image_width'] . '&h=' . $image_settings['image_height']. '&a=' . $image_settings['image_crop_location'] . '&src=' . rawurlencode($im);
					else
						$r->image = $im;
					*/
					$im = $this->getBFIimage( $r );
					if ( $im != '' && strpos( $im, "mshots/v1" ) === false ) {
						if ( w_isset_def( $image_settings['image_transparency'], 1 ) == 1 ) {
							$bfi_params = array( 'width'  => $image_settings['image_width'],
							                     'height' => $image_settings['image_height'],
							                     'crop'   => true
							);
						} else {
							$bfi_params = array( 'width'  => $image_settings['image_width'],
							                     'height' => $image_settings['image_height'],
							                     'crop'   => true,
							                     'color'  => wpdreams_rgb2hex( $image_settings['image_bg_color'] )
							);
						}

						$r->image = bfi_thumb( $im, $bfi_params );
					} else {
						$r->image = $im;
					}
				}


				if ( ! isset( $searchData['titlefield'] ) || $searchData['titlefield'] == "0" || is_array( $searchData['titlefield'] ) ) {
					$r->title = get_the_title( $r->id );
				} else {
					if ( $searchData['titlefield'] == "1" ) {
						if ( strlen( $r->excerpt ) >= 200 ) {
							$r->title = wd_substr_at_word( $r->excerpt, 200 );
						} else {
							$r->title = $r->excerpt;
						}
					} else {
						$mykey_values = get_post_custom_values( $searchData['titlefield'], $r->id );
						if ( isset( $mykey_values[0] ) ) {
							$r->title = $mykey_values[0];
						} else {
							$r->title = get_the_title( $r->id );
						}
					}
				}

				//remove the search shortcodes properly
				add_shortcode('wpdreams_ajaxsearchpro', array($this, 'return_empty_string'));
				add_shortcode('wpdreams_ajaxsearchlite', array($this, 'return_empty_string'));

				if ( ! isset( $searchData['striptagsexclude'] ) ) {
					$searchData['striptagsexclude'] = "<a><span>";
				}

				if ( ! isset( $searchData['descriptionfield'] ) || $searchData['descriptionfield'] == "0" || is_array( $searchData['descriptionfield'] ) ) {
					if (w_isset_def($searchData['strip_shortcodes'], 0) == 1)
						$r->content = strip_shortcodes($r->content);
					if ( function_exists( 'qtrans_getLanguage' ) ) {
						$r->content = apply_filters( 'the_content', $r->content );
					}
					$_content = strip_tags($r->content);
				} else {
					if ( $searchData['descriptionfield'] == "1" ) {
						$_content = strip_tags( $r->excerpt );
					} else if ( $searchData['descriptionfield'] == "2" ) {
						$_content = strip_tags( get_the_title( $r->id ) );
					} else {
						$mykey_values = get_post_custom_values( $searchData['descriptionfield'], $r->id );
						if ( isset( $mykey_values[0] ) ) {
							$_content = strip_tags( $mykey_values[0] );
						} else {
							$_content = strip_tags( get_content_w( $r->content ) );
						}
					}
				}
				if ( $_content == "" && $r->content != '') {
					$_content = $r->content;
				}
				if ( $_content != "" ) {
					$_content = str_replace( '[wpdreams_ajaxsearchlite]', "", $_content );
				}

				if ( $_content != "" ) {
					$_content = apply_filters( 'the_content', $r->content );
				}
				if ( $_content != "" ) {
					$_content = preg_replace( '#<script(.*?)>(.*?)</script>#is', '', $_content );
				}

				$_content = strip_tags( $_content );

				if ( $_content != '' && ( strlen( $_content ) > $searchData['descriptionlength'] ) )
					$_content = wd_substr_at_word( $_content, $searchData['descriptionlength'] ) . "...";

				$r->content = $_content;

				// -------------------------- Woocommerce Fixes -----------------------------
				// Regexp fixing the title
				$r->title = preg_replace( "/(Variation) \#(\d+) (of)/si", '', $r->title );

				// A trick to fix the url
				if ( $r->post_type == 'product_variation' &&
				     class_exists( 'WC_Product_Variation' )
				) {
					$wc_prod_var_o = new WC_Product_Variation( $r->id );
					$r->link       = $wc_prod_var_o->get_permalink();
				}
				// --------------------------------------------------------------------------

				$r->title   = apply_filters( 'asl_result_title_after_prostproc', $r->title, $r->id );
				$r->content = apply_filters( 'asl_result_content_after_prostproc', $r->content, $r->id );
				$r->image   = apply_filters( 'asl_result_image_after_prostproc', $r->image, $r->id );
				$r->author  = apply_filters( 'asl_result_author_after_prostproc', $r->author, $r->id );
				$r->date    = apply_filters( 'asl_result_date_after_prostproc', $r->date, $r->id );

			}
			/* !Images, title, desc */
			//var_dump($pageposts); die();
			$this->results = $pageposts;

			return $pageposts;

		}

		protected function group() {
			return $this->results;
		}

		/**
		 * Fetches an image for BFI class
		 */
		function getBFIimage( $post ) {
			if ( ! isset( $post->image ) || $post->image == null ) {
				$home_url = network_home_url();
				$home_url = home_url();

				if ( ! isset( $post->id ) ) {
					return "";
				}
				$i  = 1;
				$im = "";
				for ( $i == 1; $i < 6; $i ++ ) {
					switch ( $this->imageSettings[ 'image_source' . $i ] ) {
						case "featured":
							$im = wp_get_attachment_url( get_post_thumbnail_id( $post->id ) );
							if ( is_multisite() ) {
								$im = str_replace( home_url(), network_home_url(), $im );
							}
							break;
						case "content":
							$im = wpdreams_get_image_from_content( $post->content, 1 );
							if ( is_multisite() ) {
								$im = str_replace( home_url(), network_home_url(), $im );
							}
							break;
						case "excerpt":
							$im = wpdreams_get_image_from_content( $post->excerpt, 1 );
							if ( is_multisite() ) {
								$im = str_replace( home_url(), network_home_url(), $im );
							}
							break;
						case "screenshot":
							$im = 'http://s.wordpress.com/mshots/v1/' . urlencode( get_permalink( $post->id ) ) .
							      '?w=' . $this->imageSettings['image_width'] . '&h=' . $this->imageSettings['image_height'];
							break;
						case "custom":
							if ( $this->imageSettings['image_custom_field'] != "" ) {
								$val = get_post_meta( $post->id, $this->imageSettings['image_custom_field'], true );
								if ( $val != null && $val != "" ) {
									$im = $val;
								}
							}
							break;
						case "default":
							if ( $this->imageSettings['image_default'] != "" ) {
								$im = $this->imageSettings['image_default'];
							}
							break;
						default:
							$im = "";
							break;
					}
					if ( $im != null && $im != '' ) {
						break;
					}
				}

				return $im;
			} else {
				return $post->image;
			}
		}

		/**
		 * An empty function to override individual shortcodes, this must be public
		 *
		 * @return string
		 */
		public function return_empty_string() {
			return "";
		}

	}
}
?>