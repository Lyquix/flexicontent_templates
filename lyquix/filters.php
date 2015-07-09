<div class="fcfilter_form_outer fcfilter_form_component">

<form action="<?php echo $this -> action; ?>" method="post" id="adminForm" onsubmit="" class="group" style="<?php echo $form_style; ?>">			
<?php			

// Text search, Field Filters
$params  = & $this->params;
$form_id = $form_name = 'adminForm';
$filters = & $this->filters;
$text_search_val = $this->lists['filter'];

$document = JFactory::getDocument();

// Form (text search / filters) configuration
$show_search_go = $params->get('show_search_go', 1);
$show_search_reset = $params->get('show_search_reset', 1);
$filter_autosubmit = $params->get('filter_autosubmit', 0);
$filter_instructions = $params->get('filter_instructions', 1);
$filter_placement = $params->get( 'filter_placement', 1 );

$flexi_button_class_go =  ($params->get('flexi_button_class_go' ,'') != '-1')  ? 
    $params->get('flexi_button_class_go' , 'btn btn-success')   :
    $params->get('flexi_button_class_go_custom', (FLEXI_J30GE ? 'btn btn-success' : 'fc_button'))  ;
$flexi_button_class_reset =  ($params->get('flexi_button_class_reset','') != '-1')  ?
    $params->get('flexi_button_class_reset', 'btn')   :
    $params->get('flexi_button_class_reset_custom', (FLEXI_J30GE ? 'btn' : 'fc_button'))  ;

$filters_in_lines = $filter_placement==1 || $filter_placement==2;
$filters_in_tabs  = $filter_placement==3;
$filter_container_class  = $filters_in_lines ? 'fc_filter_line' : 'fc_filter';
$filter_container_class .= $filter_placement==2 ? ' fc_clear_label' : '';

// Get field group information
$fgInfo = FlexicontentFields::getFieldsPerGroup();

// Prepare for filters inside TABs
if ($filter_placement==3) {
	$document->addStyleSheet(JURI::root(true).'/components/com_flexicontent/assets/css/tabber.css');
	$document->addScript(JURI::root(true).'/components/com_flexicontent/assets/js/tabber-minimized.js');
	$document->addScriptDeclaration(' document.write(\'<style type="text/css">.fctabber{display:none;}<\/style>\'); ');
	static $_filter_TABsetCnt = null;
	if ($_filter_TABsetCnt === null) $_filter_TABsCnt = -1;
	$tabSetCnt = 0;
}

// Text Search configuration
$use_search  = $params->get('use_search', 1);
$show_search_label = $params->get('show_search_label', 1);
$search_autocomplete = $params->get( 'search_autocomplete', 1 );

// Filters configuration
$use_filters = $params->get('use_filters', 0) && $filters;
$show_filter_labels = $params->get('show_filter_labels', 1);

// a ZERO initial value of show_search_go ... is AUTO
$show_search_go = $show_search_go || !$filter_autosubmit;// || $use_search;

// Calculate needed flags
$filter_instructions = ($use_search || $use_filters) ? $filter_instructions : 0;

// Create instructions (tooltip or inline message)
$legend_class = 'fc_legend_text';
$legend_tip = '';
if ($filter_instructions == 1) {
	$legend_class .= FLEXI_J30GE ? ' hasTooltip' : ' hasTip';
	$legend_tip =
		 ($use_search ? '<b>'.JText::_('FLEXI_TEXT_SEARCH').'</b><br/>'.JText::_('FLEXI_TEXT_SEARCH_INFO') : '')
		.(($use_search || $use_filters) ? '<br/><br/>' : '')
		.($use_filters ? '<b>'.JText::_('FLEXI_FIELD_FILTERS').'</b><br/>'.JText::_('FLEXI_FIELD_FILTERS_INFO') : '')
		;
	$legend_tip = flexicontent_html::getToolTip(null, $legend_tip, 0, 1);
} else if ($filter_instructions == 2) {
	$legend_inline =
		 ($use_search ? '<strong>'.JText::_('FLEXI_TEXT_SEARCH').'</strong><br/>'.JText::_('FLEXI_TEXT_SEARCH_INFO') : '')
		.(($use_search || $use_filters) ? '<br/><br/>' : '')
		.($use_filters ? '<strong>'.JText::_('FLEXI_FIELD_FILTERS').'</strong><br/>'.JText::_('FLEXI_FIELD_FILTERS_INFO') : '')
		;
}

if ( $use_search || $use_filters ) : /* BOF search and filters block */
	if (!$params->get('disablecss', '')) {
		JFactory::getDocument()->addStyleSheet(JURI::root(true).'/components/com_flexicontent/assets/css/flexi_filters.css');
	}
	$searchphrase_selector = flexicontent_html::searchphrase_selector($params, $form_name);
?>

<div id="<?php echo $form_id; ?>_filter_box" class="fc_filter_box floattext">
	
		
		<?php if ( $use_search ) : /* BOF search */ ?>
			<?php
			$ignoredwords = JRequest::getVar('ignoredwords');
			$shortwords = JRequest::getVar('shortwords');
			$min_word_len = JFactory::getApplication() -> getUserState(JRequest::getVar('option') . '.min_word_len', 0);
			$msg = '';
			$msg .= $ignoredwords ? JText::_('FLEXI_WORDS_IGNORED_MISSING_COMMON') . ': <b>' . $ignoredwords . '</b>' : '';
			$msg .= $ignoredwords && $shortwords ? ' <br/> ' : '';
			$msg .= $shortwords ? JText::sprintf('FLEXI_WORDS_IGNORED_TOO_SHORT', $min_word_len) . ': <b>' . $shortwords . '</b>' : '';
			?>
			
			<span class="<?php echo $filter_container_class; ?> fc_filter_text_search fc_odd">
				<?php
				$text_search_class = 'fc_text_filter';
				$text_search_class .= $search_autocomplete ? ($search_autocomplete == 2 ? ' fc_index_complete_tlike fc_basic_complete' : ' fc_index_complete_simple fc_basic_complete fc_label_internal') : ' fc_label_internal';
				$text_search_label = JText::_($show_search_label == 2 ? 'FLEXI_TEXT_SEARCH' : 'FLEXI_TYPE_TO_LIST');
				?>
				
				<?php if ($show_search_label==1) : ?>
					<span class="fc_filter_label"><?php echo JText::_('FLEXI_TEXT_SEARCH'); ?></span>
				<?php endif; ?>
				
				<span class="fc_filter_html">
					<input type="<?php echo $search_autocomplete == 2 ? 'hidden' : 'text'; ?>" class="<?php echo $text_search_class; ?>"
						data-fc_label_text="<?php echo $text_search_label; ?>" name="filter"
						id="<?php echo $form_id; ?>_filter" value="<?php echo htmlspecialchars($text_search_val, ENT_COMPAT, 'UTF-8'); ?>" />
					<?php echo $searchphrase_selector; ?>
					
					<?php if ( $filter_placement && ($show_search_go || $show_search_reset) ) : ?>
					<span class="fc_buttons">
						<?php if ($show_search_go) : ?>
						<button class="<?php echo $flexi_button_class_go; ?>" onclick="var form=document.getElementById('<?php echo $form_id; ?>'); adminFormPrepare(form, 2); return false;" title="<?php echo JText::_('FLEXI_APPLY_FILTERING'); ?>">
							<span class="icon-search"></span><?php echo JText::_('FLEXI_GO'); ?>
						</button>
						<?php endif; ?>
						
						<?php if ($show_search_reset) : ?>
						<button class="<?php echo $flexi_button_class_reset; ?>" onclick="var form=document.getElementById('<?php echo $form_id; ?>'); adminFormClearFilters(form); adminFormPrepare(form, 2); return false;" title="<?php echo JText::_('FLEXI_REMOVE_FILTERING'); ?>">
							<span class="icon-remove"></span><?php echo JText::_('FLEXI_RESET'); ?>
						</button>
						<?php endif; ?>
						
					</span>
					<span id="<?php echo $form_id; ?>_submitWarn" class="fc-mssg fc-note" style="display:none;"><?php echo JText::_('FLEXI_FILTERS_CHANGED_CLICK_TO_SUBMIT'); ?></span>
					<?php endif; ?>
				
					<?php if ( $msg ) : ?><span class="fc-mssg fc-note"><?php echo $msg; ?></span><?php endif; ?>
				</span>
				
			</span>
			
		<?php endif; /* EOF search */ ?>
		
		<?php
			$filter_messages = JRequest::getVar('filter_messages', array());
			$msg = '';
			$msg = implode(' <br/> ', $filter_messages);
			if ( $msg ) :
				?><div class="fcclear"></div><span class="fc-mssg fc-note"><?php echo $msg; ?></span><?php
				endif;
		?>
		
		<?php if ($use_filters): /* BOF filter */ ?>
			<?php
			// Prefix/Suffix texts
			$pretext = $params -> get('filter_pretext', '');
			$posttext = $params -> get('filter_posttext', '');

			// Open/Close tags
			$opentag = !$filters_in_tabs ? $params -> get('filter_opentag', '') : '<div class="fctabber fields_tabset" id="fcform_tabset_' . (++$_filter_TABsetCnt) . '" >';
			$closetag = !$filters_in_tabs ? $params -> get('filter_closetag', '') : '</div>';
			?>
			
			<?php
			$n = 0;
			$prepend_onchange = " adminFormPrepare(document.getElementById('" . $form_id . "'), 1); ";
			$filters_html = array();
			foreach ($filters as $filt) :
				if (empty($filt -> html))
					continue;

				$filt_lbl = $filt -> label;
				if (isset($fgInfo -> field_to_grp[$filt -> id])) {
					$fieldgrp_id = $fgInfo -> field_to_grp[$filt -> id];
					$filt_lbl = '<span class="label label-info">' . $fgInfo -> grps[$fieldgrp_id] -> label . '</span><br/>' . $filt_lbl;
				}

				// Support for old 3rd party filters, that include an auto-submit statement or include a fixed form name
				// These CUSTOM fields should be updated to have this auto-submit code removed fixed form name changed too

				// Compatibility HACK 1
				// These fields need to be have their onChange Event prepended with the FORM PREPARATION function call,
				// ... but if these filters change value after we 'prepare' form then we have an issue ...
				if (preg_match('/onchange[ ]*=[ ]*([\'"])/i', $filt -> html, $matches) && preg_match('/\.submit\(\)/', $filt -> html, $matches)) {
					$filt -> html = preg_replace('/onchange[ ]*=[ ]*([\'"])/i', 'onchange=${1}' . $prepend_onchange, $filt -> html);
				}

				// Compatibility HACK 2
				// These fields also need to have any 'adminForm' string present in their filter's HTML replaced with the name of our form
				$filt -> html = preg_replace('/([\'"])adminForm([\'"])/', '${1}' . $form_name . '${2}', $filt -> html);

				$label_outside = !$filters_in_tabs && ($show_filter_labels == 1 || ($show_filter_labels == 0 && $filt -> parameters -> get('display_label_filter') == 1));
				$even_odd_class = !$filters_in_tabs ? (($n++) % 2 ? ' fc_even' : ' fc_odd') : '';

				// Highlight active filter
				$filt_vals = JRequest::getVar('filter_' . $filt -> id, '', '');
				$has_filt_vals_array = is_array($filt_vals) && strlen(trim(implode('', $filt_vals)));
				$has_filt_vals_string = !is_array($filt_vals) && strlen(trim($filt_vals));
				$filter_label_class = ($has_filt_vals_array || $has_filt_vals_string) ? 'fc_filter_active' : 'fc_filter_inactive';

				$_filter_html =

				/* Optional TAB start and filter label as TAB title */
				($filters_in_tabs ? '
					<div class="tabbertab" id="fcform_tabset_' . $_filter_TABsetCnt . '_tab_' . ($tabSetCnt++) . '" >
						<h3 class="tabberheading ' . $filter_label_class . '">' . $filt_lbl . ($has_filt_vals_array || $has_filt_vals_string ? ' *' : '') . '</h3>' : '')

				/* External filter container */ . '
						<span class="' . $filter_container_class . $even_odd_class . ' fc_filter_id_' . $filt -> id . '" >' .

				/* Optional filter label before filter's HTML */
				($label_outside ? '
							<span class="fc_filter_label fc_label_field_' . $filt -> id . '">' . $filt_lbl . '</span>' : '')

				/* Internal filter container and filter 's HTML */ . '
							<span class="fc_filter_html fc_html_field_' . $filt -> id . '">' . $filt -> html . '
							</span>
							
						</span>
					' .

				/* Optional TAB end */
				($filters_in_tabs ? '
					</div>' : '') . '
				';

				$_filter_html = $filter_placement != 3 ? $pretext . $_filter_html . $posttext : $_filter_html;

				$filters_html[] = $_filter_html;
			endforeach;

			// (if) Using separator
			$separatorf = '';
			if ($filter_placement == 0) {
				$separatorf = $params -> get('filter_separatorf', 1);
				$separators_arr = array(0 => '&nbsp;', 1 => '<br />', 2 => '&nbsp;|&nbsp;', 3 => ',&nbsp;', 4 => $closetag . $opentag, 5 => '');
				$separatorf = isset($separators_arr[$separatorf]) ? $separators_arr[$separatorf] : '&nbsp;';
			}

			// Create HTML of filters
			echo $opentag . implode($separatorf, $filters_html) . $closetag;
			unset($filters_html);

			$buttons_added_already = $filter_placement && $use_search;
			?>
			
			<?php if ($show_search_go && !$buttons_added_already) : ?>
			<span class="fc_filter">
				<span class="fc_buttons">
					<button class="<?php echo $flexi_button_class_go; ?>" onclick="var form=document.getElementById('<?php echo $form_id; ?>'); adminFormPrepare(form, 2); return false;">
						<span title="<?php echo JText::_('FLEXI_APPLY_FILTERING'); ?>"><?php echo JText::_('FLEXI_GO'); ?></span>
					</button>
					
					<?php if ($show_search_reset && !$buttons_added_already) : ?>
					<button class="<?php echo $flexi_button_class_reset; ?>" onclick="var form=document.getElementById('<?php echo $form_id; ?>'); adminFormClearFilters(form); adminFormPrepare(form, 2); return false;">
						<span title="<?php echo JText::_('FLEXI_REMOVE_FILTERING'); ?>"><?php echo JText::_('FLEXI_RESET'); ?></span>
					</button>
					<?php endif; ?>
					
				</span>
				<span id="<?php echo $form_id; ?>_submitWarn" class="fc-mssg fc-note" style="display:none;"><?php echo JText::_('FLEXI_FILTERS_CHANGED_CLICK_TO_SUBMIT'); ?></span>
			</span>
			<?php endif; ?>
			
		<?php endif; /* EOF filter */ ?>
		
</div>

<?php endif; /* EOF search and filter block */

	// Automatic submission
	if ($filter_autosubmit) {
	$js = '
	jQuery(document).ready(function() {
	jQuery("#'.$form_id.' input:not(.fc_autosubmit_exclude), #'.$form_id.' select:not(.fc_autosubmit_exclude)").on("change", function() {
	var form=document.getElementById("'.$form_id.'");
	adminFormPrepare(form, 2);
	});
	});
	';
	} else {
	$js = '
	jQuery(document).ready(function() {
	jQuery("#'.$form_id.' input:not(.fc_autosubmit_exclude), #'.$form_id.' select:not(.fc_autosubmit_exclude)").on("change", function() {
	var form=document.getElementById("'.$form_id.'");
	adminFormPrepare(form, 1);
	});
	});
	';
	}

	// Notify select2 fields to clear their values when reseting the form
	$js .= '
	jQuery(document).ready(function() {
	jQuery("#'.$form_id.' .fc_button.button_reset").on("click", function() {
	jQuery("#'.$form_id.'_filter_box .use_select2_lib").select2("val", "");
	});
	});
	';
	$document->addScriptDeclaration($js);

	////////////////////////////////////////////////////////////////////////

	$limit_selector = flexicontent_html::limit_selector( $this->params, $formname='adminForm', $autosubmit=1 );
	$orderby_selector = flexicontent_html::ordery_selector( $this->params, $formname='adminForm', $autosubmit=1, $extra_order_types=array(), $sfx='');
	$orderby_selector_2nd = flexicontent_html::ordery_selector( $this->params, $formname='adminForm', $autosubmit=1, $extra_order_types=array(), $sfx='_2nd');
	$clayout_selector = flexicontent_html::layout_selector( $this->params, $formname='adminForm', $autosubmit=1, 'clayout');

	$tooltip_class = FLEXI_J30GE ? 'hasTooltip' : 'hasTip';
?>

<?php if (count($this->items) && ($this->params->get('show_item_total', 1) || $limit_selector || $orderby_selector || $orderby_selector_2nd || $clayout_selector)) : ?>

	<!-- BOF items total-->
	<div id="item_total" class="item_total group">
	
		<?php if ($this->params->get('show_item_total', 1)) : ?>
			<span class="fc_item_total_data">
				<?php echo @$this -> resultsCounter ? $this -> resultsCounter : $this -> pageNav -> getResultsCounter();
				// custom Results Counter
 ?>
			</span>
		<?php endif; ?>
		
		<?php if ($clayout_selector) : ?>
			<span class="fc_clayout_box <?php echo $tooltip_class; ?>" title="<?php echo flexicontent_html::getToolTip('FLEXI_LAYOUT', 'FLEXI_LAYOUT_INFO', 1, 1); ?>">
				<span class="fc_clayout_selector"><?php echo $clayout_selector; ?></span>
			</span>
		<?php endif; ?>
		
		<?php if ($limit_selector) : ?>
			<span class="fc_limit_box <?php echo $tooltip_class; ?>" title="<?php echo flexicontent_html::getToolTip('FLEXI_PAGINATION', 'FLEXI_PAGINATION_INFO', 1, 1); ?>">
				<span class="fc_limit_selector"><?php echo $limit_selector; ?></span>
			</span>
		<?php endif; ?>
		
		<?php if ($orderby_selector) : ?>
			<span class="fc_orderby_box <?php echo $tooltip_class; ?>" title="<?php echo flexicontent_html::getToolTip('FLEXI_ORDERBY', 'FLEXI_ORDERBY_INFO', 1, 1); ?>">
				<span class="fc_orderby_selector"><?php echo $orderby_selector; ?></span>
			</span>
		<?php endif; ?>
		
		<?php if ($orderby_selector_2nd) : ?>
			<span class="fc_orderby_box <?php echo $tooltip_class; ?>" title="<?php echo flexicontent_html::getToolTip('FLEXI_ORDERBY', 'FLEXI_ORDERBY_INFO', 1, 1); ?>">
				<span class="fc_orderby_selector"><?php echo $orderby_selector_2nd; ?></span>
			</span>
		<?php endif; ?>
		
		<span class="fc_pages_counter">
			<span class="label"><?php echo $this -> pageNav -> getPagesCounter(); ?></span>
		</span>
	
	</div>
	<!-- BOF items total-->
	
<?php endif; ?>

<?php if (!$clayout_selector) : ?>
	<input type="hidden" name="clayout" value="<?php JRequest::getVar('clayout'); ?>" />
<?php endif; ?>

</div>

	<input type="hidden" name="option" value="com_flexicontent" />
	<input type="hidden" name="filter_order" value="<?php echo $this -> lists['filter_order']; ?>" />
	<input type="hidden" name="filter_order_Dir" value="<?php echo $this -> lists['filter_order_Dir']; ?>" />
	<input type="hidden" name="view" value="category" />
	<input type="hidden" name="letter" value="<?php echo JRequest::getVar('letter'); ?>" id="alpha_index" />
	<input type="hidden" name="task" value="" />
	<input type="hidden" name="cid" value="<?php echo $this -> category -> id; ?>" />
	<input type="hidden" name="layout" value="<?php echo $this -> layout_vars['layout']; ?>" />
</form>

<?php
// FORM in slider
if ($ff_placement)
	echo JHtml::_('sliders.end');
?>

</div>			
			
