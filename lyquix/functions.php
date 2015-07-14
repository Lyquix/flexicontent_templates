<?php

defined('_JEXEC') or die('Restricted access');


class lyquixFlexicontentTmpl {
	
	function renderCatButtons() {

		// Buttons
		
		$html = '';
		
		if ($this -> params -> get('show_print_icon') || $this -> params -> get('show_email_icon') || JRequest::getCmd('print') || $this -> params -> get('show_feed_icon', 1) || $add_button) {
				
			$html .= '<div class="buttons">' . 
					$this -> params -> get('show_addbutton', 1) ? flexicontent_html::addbutton($this -> params, $this -> category) : '' . 
					flexicontent_html::printbutton($this -> print_link, $this -> params) . 
					flexicontent_html::mailbutton('category', $this -> params, $this -> category -> slug) . 
					flexicontent_html::feedbutton('category', $this -> params, $this -> category -> slug) . 
					'</div>';
					
		}
		
		return $html;
	}

	function renderCatTitle() {

		// Title
		
		$html = '';

		if ($this -> params -> get('show_cat_title', 1)) {

			// Use category title by default, or override if param not blank

			$cat_title = $this -> params -> get('cat_title_override', htmlspecialchars($this -> category -> title));

			// Limit max length of title of param > 0

			if ($this -> params -> get('title_cut_text', 120) > 0) {
					
				$cat_title = substr($cat_title, 0, $this -> params -> get('title_cut_text', 120));
				
			}

			$html .= '<h1>' . $cat_title . '</h1>';
			
		}
		
		return $html;
	}

	function renderCatFilters() {

		// Filters
		
		$html = '';

		if ($this -> params -> get('use_filters', 0)) {
			echo '<div class="cat-filters">' . $this -> params -> get('cat_filters_label', '');
			include(JPATH_SITE.DS.'components'.DS.'com_flexicontent'.DS.'templates'.DS.'lyquix'.DS.'filters.php');
			echo '</div>';
		}
		
		return $html;
	}

	function renderCatAlpha() {

		// Alpha index
		
		$html = '';
		
		if ($this -> params -> get('show_alpha', 1)) {
			echo '<div class="cat-alphaindex">' . $this -> params -> get('cat_alphaindex_label', '');
			include (JPATH_SITE . DS . 'components' . DS . 'com_flexicontent' . DS . 'tmpl_common' . DS . 'category_alpha_html5.php');

			echo '</div>';
		}
		
		return $html;
	}

	function renderCatImage() {

		// Category image
		
		$html = '';

		if ($this -> params -> get('show_description_image', 1) && $this -> params -> get('image')) {

			// get image from category parameters

			$src = $this -> params -> get('image');

			// prepare image url for resizing

			$w = '&amp;w=' . $this -> params -> get('cat_image_width', 80);
			$h = '&amp;h=' . $this -> params -> get('cat_image_height', 80);
			$aoe = '&amp;aoe=1';
			$q = '&amp;q=95';
			$zc = $this -> params -> get('cat_image_method', 1) ? '&amp;zc=' . $this -> params -> get('cat_image_method', 1) : '';
			$ext = pathinfo($src, PATHINFO_EXTENSION);
			$f = in_array($ext, array('png', 'ico', 'gif')) ? '&amp;f=' . $ext : '';
			$conf = $w . $h . $aoe . $q . $zc . $f;
			$base_url = (!preg_match("#^http|^https|^ftp#i", $src)) ? JURI::base(true) . '/' : '';
			$image_url = JURI::base(true) . '/components/com_flexicontent/librairies/phpthumb/phpThumb.php?src=' . $base_url . $src . $conf;
			
			$html .= '<div class="cat-image ' . $this -> params -> get('cat_img_align', '') . '"><img src="' . $image_url . '" /></div>';
		}
		
		return $html;
		
	}

	function renderCatDesc() {

		// Category description
		
		$html = '';

		if ($this -> params -> get('show_description', 1) && $this -> category -> description) {
				
			$html .= '<div class="cat-description">' . $this -> category -> description . '</div>';
			
		}
		
		return $html;
		
	}

	function renderCatMap() {

		// Map
		
		$html = '';

		if ($this -> params -> get('map_display', '') != '' && $this -> params -> get('map_addr_field', '') != '') {
			
			$html .= '<div class="cat-map ' . $this -> params -> get('map_css_class', '') . '">';	
			$html .= $this -> params -> get('map_label', '');
			$html .= $this -> params -> get('map_opentag', '');
			$html .= '<div id="cat-map" style="width:' . $this -> params -> get('map_width', '100%') . '; height:' . $this -> params -> get('map_height', '480px') . ';"></div>';
			$html .= $this -> params -> get('map_closetag', '');
			$html .= '</div>';
			$html .= '<script src="//maps.googleapis.com/maps/api/js' . ($this -> params -> get('map_google_api_key', '') ? '?key=' . $this -> params -> get('map_google_api_key', '') : '') . '"></script>';
			$html .= '<script>
					var lyquix = lyquix||{};
					lyquix.catMapOptions = {
						center: new google.maps.LatLng(0,0),
						mapTypeId: google.maps.MapTypeId.' . $this -> params -> get('map_type', 'ROADMAP') . ',
						scrollwheel: ' . ($this -> params -> get('map_zoom_scrollwheel', 0) ? 'true' : 'false') . ',
						mapTypeControl: ' . ($this -> params -> get('map_type_control', 0) ? 'true' : 'false') . ',
						panControl: ' . ($this -> params -> get('map_pan_control', 0) ? 'true' : 'false') . ',
						zoomControl: ' . ($this -> params -> get('map_zoom_control', 1) ? 'true' : 'false') . ',
						streetViewControl: false,
						zoom: 8
					};
					lyquix.catMapBounds = new google.maps.LatLngBounds();
					lyquix.catMapItems = ' . self::renderCatMapItems() . ';
					jQuery(document).ready(function(){
						lyquix.catMap = new google.maps.Map(document.getElementById(\'cat-map\'), lyquix.catMapOptions);
						google.maps.event.addListenerOnce(lyquix.catMap, \'bounds_changed\', function(event){
							lyquix.catMap.fitBounds(lyquix.catMapBounds);
							lyquix.catMap.panToBounds(lyquix.catMapBounds);
						});
						for (var i = 0; i < lyquix.catMapItems.length; i++) {
							if(lyquix.catMapItems[i].lat && lyquix.catMapItems[i].lon) {
								var itemLatLon = new google.maps.LatLng(lyquix.catMapItems[i].lat, lyquix.catMapItems[i].lon);
								lyquix.catMapBounds.extend(itemLatLon);
								var infowindow = new google.maps.InfoWindow({content: lyquix.catMapItems[i].html});
								var marker = new google.maps.Marker({
									position: itemLatLon,
									map: lyquix.catMap,
									title: lyquix.catMapItems[i].title,
									html: lyquix.catMapItems[i].html
								});
								google.maps.event.addListener(marker, \'click\', function() {
									infowindow.setContent(this.html);
									infowindow.open(lyquix.catMap,this);
								});
							}
						}
					});
				 </script>';
		}

		return $html;
		
	}

	function renderCatMapItems() {

		// json array

		$json = array();

		// generate json object of items

		foreach ($this->items as $i => $item) {

			// check if item has address field

			if (array_key_exists($this -> params -> get('map_addr_field', ''), $item -> fields)) {

				// check if field has lat/lon different than 0,0

				$addr = unserialize($item -> fields[$this -> params -> get('map_addr_field', '')] -> value[0]);
				
				if ((float)$addr['lat'] != 0 && (float)$addr['lon'] != 0) {
					
					$html = '';
					$html .= $this -> params -> get('map_pretext', '');
					
					for ($j = 1; $j <= 7; $j++) {
						
						if (isset($item -> positions['group_' . $j])) {
							
							$html .= '<div class="group_' . $j . ' ' . $this -> params -> get('css_group_' . $j, '') . '">';
							
							foreach ($item->positions['group_' . $j] as $field) {
								
								$html .= plgFlexicontentLyquix::renderItemField($item, $field, 'map');
							}

							$html .= '</div>';
						}
					}
					
					$html .= $this -> params -> get('map_posttext', '');
					array_push($json, array('title' => $item -> title, 'lat' => (float)$addr['lat'], 'lon' => (float)$addr['lon'], 'html' => $html));
				}
			}
		}

		// print json array

		return json_encode($json);
	}

	function renderCatSubcats() {
		
		$html = '';
		
		// Subcategories
		// should display subcategories?

		if ($this -> params -> get('map_display', '') != 'map' && $this -> params -> get('show_subcategories', 0) && count($this -> categories)) {

			// BASED ON THE CATEGORY SORTING BUT FORCING IT until parameter filed is finihed

			$cat_sections = $this -> params -> get('layout_ordering', array("buttons", "title", "filters", "alpha", "image", "desc", "map", "subcats", "items", "pagination"));
			
			$html .= '<div class="cat-subcats">';
			
			// sub categories heading

			if ($this -> params -> get('show_label_subcats', 1)) {
				
				$html .= $this -> params -> get('sub_cat_label', '');
			}

			$html .= $this -> params -> get('subcat_opentag', '');
			
			$html .= '<ul class="cat-subcats ' . $this -> params -> get('sub_cat_ul_class', '') . '">';
			
			foreach ($this->categories as $subcat) {
					
				$html .= '<li class="' . $this -> params -> get('sub_cat_li_class', '') . '">';
				
				$html .= $this -> params -> get('subcat_pretext', '');
				
				foreach ($cat_sections as $cat_section) {
						
					switch ($cat_section) {

						// sub-category title

						case "title" :
							$html .= '<' . $this -> params -> get('sub_cat_title_headding', 'h3') . '>';
							if ($this -> params -> get('sub_cat_link_title', 1)) {
								$html .= '<a href="' . JRoute::_(FlexicontentHelperRoute::getCategoryRoute($subcat -> slug)) . '">';
							}

							$html .= htmlspecialchars($subcat -> title);

							if ($this -> params -> get('sub_cat_link_title', 1)) {
								$html .= '</a>';
							}

							$html .= '</' . $this -> params -> get('sub_cat_title_headding', 'h3') . '>';
							break;

						// sub-category image

						case "image" :
							
							if ($this -> params -> get('show_description_image_subcat', 0) && $subcat -> params -> get('image')) {

								// get sub category image from its parameters

								$src = $subcat -> params -> get('image');

								// set the url parameters for resizing image

								$w = '&amp;w=' . $this -> params -> get('subcat_image_width', 80);
								$h = '&amp;h=' . $this -> params -> get('subcat_image_height', 80);
								$aoe = '&amp;aoe=1';
								$q = '&amp;q=95';
								$zc = $this -> params -> get('subcat_image_method', 1) ? '&amp;zc=' . $this -> params -> get('subcat_image_method', 1) : '';
								$ext = pathinfo($src, PATHINFO_EXTENSION);
								$f = in_array($ext, array('png', 'ico', 'gif')) ? '&amp;f=' . $ext : '';
								$conf = $w . $h . $aoe . $q . $zc . $f;
								$base_url = (!preg_match("#^http|^https|^ftp#i", $src)) ? JURI::base(true) . '/' : '';
								$image_url = JURI::base(true) . '/components/com_flexicontent/librairies/phpthumb/phpThumb.php?src=' . $base_url . $src . $conf;
								$html .= '<div class="subcat-image">';

								// add link to sub category?

								if ($this -> params -> get('subcat_link_image', 0)) {
									$html .= '<a href="' . JRoute::_(FlexicontentHelperRoute::getCategoryRoute($subcat -> slug)) . '">';
								}

								$html .= '<img src="' . $image_url . '" />';

								// close link tag

								if ($this -> params -> get('subcat_link_image', 0)) {
									$html .= '</a>';
								}

								$html .= '</div>';
							}

							break;

						// sub-category description stripped of HTML and cut to given length

						case "desc" :
							if ($this -> params -> get('show_description_subcat', 0) && $subcat -> description) {
								$html .= '<div class="subcat-description">' . flexicontent_html::striptagsandcut($subcat -> description, $this -> params -> get('description_cut_text_subcat', 120)) . '</div>';
							}

							break;

						// items: displays a list of the sub-category items if they were generated, and not shown in the main items list

						case "items" :
							if ($this -> params -> get('display_subcategories_items') && $this -> params -> get('sub_cat_items', 0)) {
								$html .= '<ul class="subcat-items">';
								foreach ($this->items as $item) {

									// check that the item is in this subcategory

									foreach ($item->categories as $cat) {
										if ($cat -> id == $subcat -> id) {
											$html .= '<li>';

											// add link if type of items list if linklist

											if ($this -> params -> get('sub_cat_items_style', 'linkslist') == 'linkslist') {
												$html .= '<a href="' . JRoute::_(FlexicontentHelperRoute::getItemRoute($item -> slug, $item -> categoryslug)) . '">';
											}

											$html .= htmlspecialchars($item -> title);

											// close link tag

											if ($this -> params -> get('sub_cat_items_style', 'linkslist') == 'linkslist') {
												$html .= '</a>';
											}

											$html .= '</li>';
										}
									}
								}

								$html .= '</ul>';
							}

							break;
					}
				}

				$html .= $this -> params -> get('subcat_posttext', '');
				$html .= '</li>';
			}

			$html .= '</ul>';
			$html .= $this -> params -> get('subcat_closetag', '');
			$html .= '</div>';
		}
		
		return $html;
		
	}

	function renderCatItems() {
			
		$html = '';
		
		if ($this -> params -> get('map_display', '') != 'map') {
				
			$html .= '<div class="cat-items">';
			
			if (count($this -> items)) {
				
				// create arrays for items
				$featured_items = array();
				$leading_items = array();
				$intro_items = array();

				// display featured items in separate list?

				if ($this -> params -> get('featured_separate', 0)) {

					foreach ($this->items as $i => $item) {
						if ($item -> featured == 1) {

							// skip subcategory items if they are displayed under subcategories

							if ($this -> params -> get('sub_cat_items', 0)) {

								// include only if the item is in the main category

								foreach ($item->categories as $cat) {
									if ($cat -> id == $this -> category -> id) {
										array_push($featured_items, $i);
									}
								}
							}

							// else include all featured items

							else {
								array_push($featured_items, $i);
							}
						}
					}

					// cycle through all featured items

					$html .= self::renderCatItemsSection($featured_items, $group = 'featured');
				}

				// get number of leading items, leading items are shown only in first page

				if ($this -> limitstart != 0) {
					$leading_num = 0;
				} else {
					$leading_num = $this -> params -> get('leading_num', 0);
				}

				// display leading items

				if ($leading_num) {

					foreach ($this->items as $i => $item) {

						// skip subcategory items if they are displayed under subcategories

						if ($this -> params -> get('sub_cat_items', 0)) {

							// include only if the item is in the main category

							foreach ($item->categories as $cat) {
								if ($cat -> id == $this -> category -> id) {

									// and skip any featured items displayed above

									if (!in_array($i, $featured_items)) {
										array_push($leading_items, $i);
									}
								}
							}
						}

						// else include all items except featured items displayed above

						else {
							if (!in_array($i, $featured_items)) {
								array_push($leading_items, $i);
							}
						}

						// break this foreach cycle once we have enough items

						if (count($leading_items) == $leading_num) {
							break;
						}
					}

					// cycle through all leading items

					$html .= self::renderCatItemsSection($leading_items, $group = 'leading');
				}

				// display intro items if there are any left after displaying featured and leading items

				if ((count($this -> items) - count($featured_items) - count($leading_items)) > 0) {

					foreach ($this->items as $i => $item) {

						// skip subcategory items if they are displayed under subcategories

						if ($this -> params -> get('sub_cat_items', 0)) {

							// include only if the item is in the main category

							foreach ($item->categories as $cat) {
								if ($cat -> id == $this -> category -> id) {

									// and skip any featured items and leading items displayed above

									if (!in_array($i, $featured_items) && !in_array($i, $leading_items)) {
										array_push($intro_items, $i);
									}
								}
							}
						}

						// else include all items except featured items and leading items displayed above

						else {
							if (!in_array($i, $featured_items) && !in_array($i, $leading_items)) {
								array_push($intro_items, $i);
							}
						}
					}

					// cycle through all intro items

					$html .= self::renderCatItemsSection($intro_items, $group = 'introitems');
				}
			} else {

				// no items in this category
				if($this -> params -> get('items_no_items', 0)) {
						
					$html .= '<span class="no-items">' . $this -> params -> get('items_no_items_label', JText::_('FLEXI_NO_ITEMS_FOUND')) . '</span>';
					
				}
				
			}

			$html .= '</div>';
			
		}
		
		return $html;
	}

	function renderCatItemsSection($idx, $group) {
		
		$html = '';
		
		if (count($idx) > 0) {
			
			$html .= '<div class="' . $group . '-items">';
			$html .= $this -> params -> get($group . '_label', '');
			$html .= $this -> params -> get($group . '_opentag', '');
			$html .= '<ul class="' . $group . '-items-list ' . $this -> params -> get($group . '_ul_class', '') . '">';
			
			foreach ($idx as $i) {
				
				$html .= '<li class="' . 
						$this -> params -> get($group . '_li_class', '') . 
						($this -> items[$i] -> featured ? ' featured' : '') . ' ' .  
						lyquixFlexicontentTmplCustom::customItemClass($this -> items[$i], $group) .
						'">';
				
				$html .= $this -> params -> get($group . '_pretext', '');
				
				for ($j = 1; $j <= 7; $j++) {
						
					if (isset($this -> items[$i] -> positions['group_' . $j])) {
							
						$html .= '<div class="group-' . $j . ' ' . $this -> params -> get('css_group_' . $j, '') . '">';
						
						foreach ($this->items[$i]->positions['group_' . $j] as $field) {
							
							$html .= self::renderCatItemsField($this -> items[$i], $field, $group);
							
						}

						$html .= '</div>';
					}
				}
				
				$html .= $this -> params -> get($group . '_posttext', '');
				$html .= '</li>';
			}

			$html .= '</ul>';
			$html .= $this -> params -> get($group . '_closetag', '');
			$html .= '</div>';
			
		}
		
		return $html;
	}

	function renderCatItemsField(&$item, &$field, $group) {
		
		$html = '';
		
		// link to item

		$item_link = JRoute::_(FlexicontentHelperRoute::getItemRoute($item -> slug, $item -> categoryslug));
		
		// try custom rendering first
		
		$html = lyquixFlexicontentTmplCustom::customFieldRendering($item, $field, $group);
		
		if(!$html) {
			
			switch ($field->name) {
	
				// if title or the title override field
	
				case "title" :
				case $this->params->get($group . '_title_field', 0) :
	
					// format title
	
					if (($field -> name == 'title' && !$this -> params -> get($group . '_title_field', 0)) || $field -> name == $this -> params -> get($group . '_title_field', 0)) {
	
						// show item title?
	
						if ($this -> params -> get('show_title', 1)) {
							$html .= '<' . $this -> params -> get($group . '_title_headding', 'h3') . '>';
	
							// make title clickable?
	
							if ($this -> params -> get('link_titles', 0)) {
								$html .= '<a href="' . $item_link . '">';
							}
	
							$html .= htmlspecialchars($item -> fields[$field -> name] -> value[0]);
	
							// make title clickable?
	
							if ($this -> params -> get('link_titles', 0)) {
								$html .= '</a>';
							}
	
							$html .= '</' . $this -> params -> get($group . '_title_headding', 'h3') . '>';
						}
					} else {
						$html .= '<div class="field field_' . $field -> name . '">';
						if ($field -> label) {
							$html .= '<div class="label">' . $field -> label . '</div>';
						}
	
						$html .= $field -> display . '</div>';
					}
	
					break;
	
				// set date format for reated and modified dates
	
				case "created" :
				case "modified" :
					$html .= '<div class="date ' . $field -> name . '">';
					if ($field -> label) {
						$html .= '<div class="label">' . $field -> label . '</div>';
					}
	
					$html .= JHTML::_('date', $item -> fields[$field -> name] -> value[0], $this -> params -> get($group . '_date_format', "l, F jS, Y")) . '</div>';
					break;
	
				// designated image field
	
				case $this->params->get($group . '_img', '') :
	
					// get image source, use selected size or get large
	
					$img_size_map = array('l' => 'large', 'm' => 'medium', 's' => 'small');
					$img_field_size = $img_size_map[$this -> params -> get($group . '_img_size', 'l')];
					$src = str_replace(JURI::root(), '', $item -> fields[$field -> name] -> thumbs_src[$img_field_size][0]);
	
					// if custom size generate url with phpthumb
	
					if (!$this -> params -> get($group . '_img_size')) {
						$w = '&amp;w=' . $this -> params -> get($group . '_img_width', 160);
						$h = '&amp;h=' . $this -> params -> get($group . '_img_height', 90);
						$aoe = '&amp;aoe=1';
						$q = '&amp;q=95';
						$zc = $this -> params -> get($group . '_img_method', '0') ? '&amp;zc=' . $this -> params -> get($group . '_img_method', '0') : '';
						$ext = pathinfo($src, PATHINFO_EXTENSION);
						$f = in_array($ext, array('png', 'ico', 'gif')) ? '&amp;f=' . $ext : '';
						$conf = $w . $h . $aoe . $q . $zc . $f;
						$base_url = (!preg_match("#^http|^https|^ftp#i", $src)) ? JURI::base(true) . '/' : '';
						$img_url = JURI::base(true) . '/components/com_flexicontent/librairies/phpthumb/phpThumb.php?src=' . $base_url . $src . $conf;
					} else {
						$img_url = $src;
					}
	
					// set wrapping div
	
					$group_img_class = $this -> params -> get($group . '_img_class', '');
					$group_img_align = $this -> params -> get($group . '_img_align', '');
					$html .= '<div class="image field_' . $field -> name . ($group_img_align ? ' ' . $group_img_align : '') . ($group_img_class ? ' ' . $group_img_class : '') . '">';
					if ($field -> label) {
						$html .= '<div class="label">' . $field -> label . '</div>';
					}
	
					// image clickable?
	
					if ($this -> params -> get($group . '_img_link', '1')) {
						$html .= '<a href="' . $item_link . '">';
					}
	
					$html .= '<img src="' . $img_url . '" alt="' . htmlspecialchars($item -> title) . '" />';
	
					// image clickable?
	
					if ($this -> params -> get($group . '_img_link', '1')) {
						$html .= '</a>';
					}
	
					$html .= '</div>';
					break;
	
				// item description field or override field
	
				case "text" :
				case $this->params->get($group . '_desc_field', '') :
					if (($field -> name == 'text' && !$this -> params -> get($group . '_desc_field', '')) || $field -> name == $this -> params -> get($group . '_desc_field', '')) {
						if ($field -> name == 'text') {
	
							// get item description, and strip & cut html
	
							$item -> fields[$field -> name] -> value[0] = FlexicontentFields::getFieldDisplay($item, $field -> name, $values = null, $method = 'display');
							$text = substr(flexicontent_html::striptagsandcut($item -> fields[$field -> name] -> value[0], $this -> params -> get($group . '_desc_cut', 200)), 0, $this -> params -> get($group . '_desc_cut', 200));
						} else {
	
							// get plain text and cut to max length
	
							$text = htmlspecialchars($item -> fields[$field -> name] -> value[0]);
							if ($this -> params -> get($group . '_desc_cut', 200) >= 0 && $this -> params -> get($group . '_desc_cut', 200) < strlen($text)) {
								$text = substr($text, 0, $this -> params -> get($group . '_desc_cut', 200));
							}
						}
	
						$html .= '<div class="description">';
	
						// add label?
	
						if ($field -> label) {
							$html .= '<div class="label">' . $field -> label . '</div>';
						}
	
						$html .= '<p>' . $text . '</p>';
	
						$html .= '</div>';
						
					} else {
							
						$html .= '<div class="field field_' . $field -> name . '">';
						
						if ($field -> label) {
							$html .= '<div class="label">' . $field -> label . '</div>';
						}
	
						$html .= $field -> display . '</div>';
					}
	
					break;
				
				case 'created_by':
					
					$html .= '<div class="author ' . $field -> name . '">';
					if ($field -> label) {
						$html .= '<div class="label">' . $field -> label . '</div>';
					}
	
					$html .= $this -> params -> get($group . '_writtenby_label', '') . $field -> display . '</div>';
					
					break;
					
				// display any other field
	
				default :
					$html .= '<div class="field field_' . $field -> name . '">';
					
					if ($field -> label) {
						$html .= '<div class="label">' . $field -> label . '</div>';
					}
	
					$html .= $field -> display . '</div>';
					break;
			}

		}


		// add readmore link?
		if ($this -> params -> get('show_readmore') && $this -> params -> get($group . '_readmore_after', 'text') == $field -> name) {
			$html .= '<a class="readmore" href="' . $item_link . '">' . $this -> params -> get($group . '_readmore_label', 'Read More') . '</a>';
		}

		// add addthis toolbar for this item?
		// to do: we need to add some parameters that indicate the configuration of the addthis bar
		if ($this -> params -> get('items_addthis', 0) && $this -> params -> get($group . '_addthis_after', 'text') == $field -> name) {
			$html .= '<div class="addthis_toolbox addthis_default_style " addthis:url="' . JURI::root() . substr($item_link, 1) . '"><a class="addthis_button_facebook_like" fb:like:layout="button_count"></a><a class="addthis_button_tweet"></a><a class="addthis_counter addthis_pill_style"></a></div>';
		}

		// add disqus link?
		if ($this -> params -> get('items_disqus', 0) && $this -> params -> get($group . '_disqus_after', 'text') == $field -> name) {
			$html .= '<div class="disqus_comments"><a href="' . JURI::root() . substr($item_link, 1) . '#disqus_thread">Comments</a></div>';
		}

		return $html;
	}

	function renderCatPagination() {

		// Pagination
		$html = '';
		
		if ($this -> params -> get('show_pagination', 0)) {
			if (FLEXI_J16GE) {
				$html .= '<div class="pagination">';
			}

			$html .= '<div class="pageslinks">' . $this -> pageNav -> getPagesLinks() . '</div>';
			if ($this -> params -> get('show_pagination_results', 1)) {
				$html .= '<div class="pagescounter">' . $this -> pageNav -> getPagesCounter() . '</div>';
			}

			if (FLEXI_J16GE) {
				$html .= '</div>';
			}
		}
		
		return $html;
		
	}

	function renderItemField(&$item, &$field) {
		
		$html = '';
		
		// try custom rendering first
		
		$html = lyquixFlexicontentTmplCustom::customFieldRendering($item, $field);
		
		if(!$html) {
			
			switch ($field->name) {
	
				// if title or the title override field
	
				case "title" :
	
					// show item title?
	
					if ($this -> params -> get('show_title', 1)) {
						$html .= '<h1>' . htmlspecialchars($field -> display) . '</h1>';
					}
	
					break;
	
				// set date format for reated and modified dates
	
				case "created" :
				case "modified" :
					$html .= '<div class="date ' . $field -> name . '">';
					if ($field -> label) {
						$html .= '<div class="label">' . $field -> label . '</div>';
					}
	
					$html .= JHTML::_('date', $item -> fields[$field -> name] -> value[0], $this -> params -> get('item_date_format', "l, F jS, Y")) . '</div>';
					break;
	
				// item description field or override field
	
				case "text" :
					$html .= '<div class="description">';
	
					// add label?
	
					if ($field -> label) {
						$html .= '<div class="label">' . $field -> label . '</div>';
					}
	
					$html .= $item -> text . '</div>';
					break;
	
				case 'created_by':
					
					$html .= '<div class="author ' . $field -> name . '">';
					if ($field -> label) {
						$html .= '<div class="label">' . $field -> label . '</div>';
					}
	
					$html .= $this -> params -> get('item_writtenby_label', '') . $field -> display . '</div>';
					
					break;
					
				// display any other field
	
				default :
					$html .= '<div class="field field_' . $field -> name . '">';
					if ($field -> label) {
						$html .= '<div class="label">' . $field -> label . '</div>';
					}
	
					$html .= $field -> display . '</div>';
					break;
			}

		}

		// add addthis toolbar for this item?
		// to do: we need to add some parameters that indicate the configuration of the addthis bar
		if ($this -> params -> get('item_addthis_after', 'text') == $field -> name) {
			$html .= '<div class="addthis_toolbox addthis_default_style "><a class="addthis_button_facebook_like" fb:like:layout="button_count"></a><a class="addthis_button_tweet"></a><a class="addthis_counter addthis_pill_style"></a></div>';
		}
		
		return $html;
	}

}
