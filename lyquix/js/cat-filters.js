/**
 * cat-filters.js
 *
 * @version     2.3.0
 * @package     flexicontent_templates
 * @author      Lyquix
 * @copyright   Copyright (C) 2015 - 2018 Lyquix
 * @license     GNU General Public License version 2 or later
 * @link        https://github.com/Lyquix/flexicontent_templates
 */

if(typeof catFilters != 'undefined') {
	console.error('catFilters is already defined');
}
else {
	var catFilters = (function(){
		// Working variables
		var vars = {
			status: null,
			url: null,
			totalItems: null,
			itemsPerPage: null,
			totalPages: null,
			callback: null,
			filters: {},
			filterAliases: {},
			filterAliasesReverse: {},
			page: null,
			category: {},
			items: {},
			search: null,
			cache: {}
		};

		// Initialize function
		var init = function(opts){
			vars.status = 'init';

			// Merge options into vars
			jQuery.extend(true, vars, opts);

			// Process filterAliases and generate filterAliasesReverse
			Oject.keys(vars.filterAliases).forEach(function(alias){
				vars.filterAliasesReverse[vars.filterAliases[alias]] = alias;
			});

			// Parse hash for filters and page number
			parseHash();

			// Load page with initial filters and page
			load({
				filters: getFilters(),
				page: vars.page,
				search: vars.search
			});
		};

		// Get current active filters
		var getFilters = function() {
			var filters = {};
			Object.keys(vars.filters).forEach(function(filterName){
				if(vars.filters[filterName].value != '') filters[filterName] = vars.filters[filterName].value;
			});
			return filters;
		}

		// Parse hash string when page loads
		var parseHash = function(){
			/* Assumes hash will be structured as follows:
			 * #filtername:value|value/filtername:value/search:query/page-pagenumber
			 * Filter and page separator: '/'
			 * Filter name/value separator: ':'
			 * Filter values separator: '|'
			 * Search is the last or one to last in the format search:quert
			 * Page is always the last segment in the format page-N where N is the page number
			*/
			// Get hash
			var hash = window.location.hash.substr(1);

			// Split by /
			hash = hash.split('/');

			// Parse page number
			var page = hash[hash.length - 1].match(/page-(\d+)/);
			if(page != null) {
				page = page[1];
				hash.pop();
			}
			else page = 1;
			vars.page = page;

			// Parse search
			var search = hash[hash.length - 1].match(/search:(.+)/);
			if(search != null) {
				search = decodeURIComponent(search[1]);
				hash.pop();
			}
			else search = '';
			vars.search = search;

			// Parse filters
			if(hash.length) {
				hash.forEach(function(filterStr){
					filterNameVal = filterStr.match(/([A-Za-z0-9\-_]+):(.+)/);
					if(filterNameVal == null && filterStr in vars.filterAliases) filterNameVal = vars.filterAliases[filterStr];
					if(filterNameVal != null) {
						var filterName = filterNameVal[1];
						var filterValue = filterNameVal[2].split('|');
						if(filterValue.length == 1) filterValue = filterValue[0];
						if(filterName in vars.filters) {
							if(typeof filterValue == 'string') {
								filterValue = decodeURIComponent(filterValue);
								var validFilterValue = false;
								vars.filters[filterName].options.forEach(function(filterOpts){
									if(filterOpts.value == filterValue) validFilterValue = true;
								});
								if(validFilterValue) vars.filters[filterName].value = filterValue;
								else console.log('Invalid filter value from hash: ' + filterName + ':' + filterValue);
							}
							else {
								var filterValueArray = [];
								filterValue.forEach(function(filterValueElem){
									filterValueElem = decodeURIComponent(filterValueElem);
									var validFilterValue = false;
									vars.filters[filterName].options.forEach(function(filterOpts){
										if(filterOpts.value == filterValueElem) validFilterValue = true;
									});
									if(validFilterValue) filterValueArray.push(filterValueElem);
									else console.log('Invalid filter value from hash: ' + filterName + ':' + filterValueElem);
								});
								vars.filters[filterName].value = filterValueArray;
							}
						}
						else console.log('Invalid filter name from hash: ' + filterName);
					}
				});
			}
		};

		// Update hash string
		var updateHash = function(params) {
			var hash = '';

			// Filters
			Object.keys(params.filters).forEach(function(filterName){
				var segment = filterName + ':'
				if(typeof params.filters[filterName] == 'string') segment += encodeURIComponent(params.filters[filterName]);
				else segment += encodeURIComponent(params.filters[filterName].join('|'));
				// Attempt to replace filter with alias
				if(segment in vars.filterAliasesReverse) segment = vars.filterAliasesReverse[segment];
				hash += segment + '/';
			});

			// Search
			if(params.search) hash += 'search:' + encodeURIComponent(params.search) + '/';

			// Page
			if(params.page > 1) hash += 'page-' + params.page;
			else hash = hash.slice(0,-1);

			window.location.hash = hash;
		};

		// Loads new filters, keeps same search, and goes back to page 1
		// {filterName1: filterValue1, filterName2: filterValue2, ...}
		var filter = function(fltr, cb) {
			if(fltr instanceof Object) {
				var params = {
					filters: fltr,
					page: 1,
					search: vars.search
				};
				if(typeof cb != 'undefined') params.callback = cb;
				else params.callback = vars.callback;
				load(params);
			}
			else console.error('Passed filters must be an Object');
		};

		// Updates/changes passed filters while keeping other filters the same, search the same, and goes back to page 1
		// {filterName1: filterValue1, filterName2: filterValue2, ...}
		var filterUpdate = function(fltr, cb) {
			if(fltr instanceof Object) {
				var params = {
					filters: jQuery.extend(true, getFilters(), fltr),
					page: 1,
					search: vars.search
				};
				if(typeof cb != 'undefined') params.callback = cb;
				else params.callback = vars.callback;
				load(params);
			}
			else console.error('Passed filters must be an Object');
		};

		// Jumps page staying with the same filters and search
		var page = function(pg, cb) {
			if(['first', 'prev', 'next', 'last'].indexOf(pg) > -1 || !isNaN(parseInt(pg))) {
				var params = {
					filters: getFilters(),
					page: pg,
					search: vars.search
				};
				if(typeof cb != 'undefined') params.callback = cb;
				else params.callback = vars.callback;
				load(params);
			}
			else console.error('Passed page number must be an integer');
		};

		// Performs a new seearch, with same filters, and goes back to page 1
		var search = function(srch, cb) {
			if(typeof srch == 'string') {
				var params = {
					filters: getFilters(),
					page: 1,
					search: srch
				};
				if(typeof cb != 'undefined') params.callback = cb;
				else params.callback = vars.callback;
				load(params);
			}
			else console.error('Passed search must be a string');
		};

		var reset = function(cb) {
			load({
				filters: {},
				page: 1,
				search: '',
				callback: typeof cb == 'string' ? cb : vars.callback
			});
		};

		// Load new filter and/or page
		var load = function(params){
			// Set default params
			if(!('callback' in params)) params.callback = vars.callback;
			if(!('page' in params)) params.page = 1;
			if(!('filters' in params)) params.filters = {};
			if(!('search' in params)) params.search = '';

			if(vars.status == 'loading') {
				console.warn('Loading filters, please wait for status `ready` or callback to be triggered');
				if(typeof window[params.callback] == 'function') {
					window[params.callback]({error: 'Loading filters, please wait for status `ready`'});
				}
			}
			vars.status = 'loading';

			// Pagination
			params.lastPage = Math.ceil(vars.totalItems / vars.itemsPerPage);

			switch(params.page) {
				case 'first':
					params.page = 1;
					break;
				case 'prev':
					params.page = vars.page == 1 ? 1 : vars.page - 1;
					break;
				case 'next':
					params.page = vars.page == params.lastPage ? lastPage : vars.page + 1;
					break;
				case 'last':
					params.page = params.lastPage;
					break;
				default:
					params.page = parseInt(params.page);
					if(isNaN(params.page) || params.page < 1) params.page = 1
					if(params.page > params.lastPage) params.page = params.lastPage;
					break;
			}

			params.limitStart = (params.page - 1) * vars.itemsPerPage;

			// Prepare URL
			params.url = '&limitstart=' + params.limitStart;

			// Filters
			if(Object.keys(params.filters).length) {
				Object.keys(params.filters).forEach(function(filterName){
					if(filterName in vars.filters) {
						var filterId = vars.filters[filterName].id;
						var filterValue = params.filters[filterName];

						switch(vars.filters[filterName].display) {
							case 'select':
							case 'text':
							case 'radio':
							case 'slider':
								if(typeof filterValue == 'string') params.url += '&filter_' + filterId + '=' + encodeURIComponent(filterValue);
								else console.log('Filter ' + filterName + ' display as ' + vars.filters[filterName].display + ' requires value as string');
								break;

							case 'checkbox':
								if(typeof filterValue == 'string') params.url += '&filter_' + filterId + '[]=' + encodeURIComponent(filterValue);
								else console.log('Filter ' + filterName + ' display as checkbox requires value as string');
								break;

							case 'multiselect':
								if(filterValue instanceof Array && filterValue.length) {
									filterValue.forEach(function(value){
										params.url += '&filter_' + filterId + '[]=' + encodeURIComponent(value);
									});
								}
								else console.log('Filter ' + filterName + ' display as multiselect requires value as array');
								break;

							case 'select-range':
							case 'text-range':
								if(filterValue instanceof Array && filterValue.length == 2) {
									filterValue.forEach(function(value, index){
										params.url += '&filter_' + filterId + '[' + (index + 1) + ']=' + encodeURIComponent(value);
									});
								}
								else console.log('Filter ' + filterName + ' display as ' + vars.filters[filterName].display + ' requires value as array with 2 elements');
								break;
						}
					}
					else delete params.filters[filterName];
				});
			}

			// Search
			if(params.search) params.url += '&filter=' + encodeURIComponent(params.search);

			// Update hash
			updateHash({page: params.page, filters: params.filters, search: params.search});

			// Send ajax
			jQuery.ajax({
				data: {},
				dataType: 'json',
				error: function(xhr, status, error){
					console.error('There has been an error trying to fetch filters', status, error);
					if(typeof window[params.callback] == 'function') {
						window[params.callback]({error: 'There has been an error trying to fetch filters: ' + error});
					}
				},
				success: function(data){
					vars.page = params.page;
					vars.totalItems = data.category.total_items;
					Object.assign(vars.filters, data.filters);
					vars.items = data.category.items.slice();
					delete data.category.total_items;
					delete data.category.items;
					Object.assign(vars.category, data.category);
					vars.status = 'ready';
					if(typeof window[params.callback] == 'function') {
						window[params.callback](vars);
					}
					else console.error('Callback function ' + params.callback + ' not defined');
				},
				url: vars.url + params.url
			});
		};

		var renderFilter = function(filterName, customOpts) {
			var opts = {
				displayCount: false,
				countFormat: ' (%count%)',
				displayFirstOption: true,
				firstOptionText: ' — Please Select — ',
				displayFieldLabel: false,
				fieldLabelFormat: '<label>%label%</label>',
				displayDisabledOptions: true,
				idPrefix: 'catFilter_',
				namePrefix: '',
				actionHandler: 'catFilters.filterUpdate'
			};
			jQuery.extend(true, opts, customOpts);

			var html = opts.displayFieldLabel ? opts.fieldLabelFormat.replace(/%label%/, vars.filters[filterName].label) : '';

			if(filterName in vars.filters) {
				var id = opts.idPrefix + filterName;
				var name = opts.namePrefix + filterName;
				switch(vars.filters[filterName].display) {
					case 'text':
						// Simple text field
						var field = jQuery('<input>').attr({
							type: vars.filters[filterName].display,
							id: id,
							name: name,
							value: vars.filters[filterName].value,
							placeholder: vars.filters[filterName].label,
							oninput: opts.actionHandler + '({' + filterName + ': this.value})'
						});
						html += field[0].outerHTML;
						break;

					case 'select':
					case 'multiselect':
					case 'slider':
						// Select field
						var field = jQuery('<select>').attr({
							id: id,
							name: name,
							multiple: vars.filters[filterName].display == 'multiselect' ? true : false,
							onchange: opts.actionHandler + '({' + filterName + ': this.value})'
						});
						// First option (value = '')
						if(vars.filters[filterName].display == 'select' && opts.displayFirstOption) jQuery('<option>').text(opts.firstOptionText).appendTo(field);
						// Filter options
						vars.filters[filterName].options.forEach(function(option){
							if(!option.disabled || opts.displayDisabledOptions) {
								jQuery('<option>').attr({
									value: option.value,
									selected: option.checked,
									disabled: option.disabled,
									'data-count': option.count
								}).text(option.text + (opts.displayCount ? opts.countFormat.replace(/%count%/,option.count) : '')).appendTo(field);
							}
						});
						html += field[0].outerHTML;
						break;

					case 'radio':
					case 'checkbox':
						vars.filters[filterName].options.forEach(function(option, index){
							if(!option.disabled || opts.displayDisabledOptions) {
								var field = jQuery('<label>').attr({for: id + index});
								jQuery('<input>').attr({
									type: vars.filters[filterName].display,
									id: id + index,
									name: name,
									value: option.value,
									checked: option.checked,
									disabled: option.disabled,
									'data-count': option.count,
									onclick: opts.actionHandler + '({' + filterName + ': this.value})'
								}).appendTo(field);
								field.append(option.text + (opts.displayCount ? opts.countFormat.replace(/%count%/,option.count) : ''));
								html += field[0].outerHTML;
							}
						});
						break;

					case 'select-range':
					case 'text-range':
						// TO DO: render 2 fields with different names and ids
						break;
				}
			}
			return html;
		};

		var renderPagination = function(customOpts) {
			var html = '';
			if(vars.totalPages > 1) {
				var opts = {
					callback: vars.callback,
					displayOnClick: true
				};
				jQuery.extend(true, opts, customOpts);

				html += '<div class="pagination"><div class="pageslinks"><ul><li class="first' + (vars.page > 1 ? '' : ' inactive') + '"';
				if(opts.displayOnClick) html += ' onclick="' + (vars.page == 1 ? '' : 'catFilters.page(1,' + opts.callback + ');') + '"';
				html += '></li><li class="prev' + (vars.page > 1 ? '' : ' inactive') + '"';
				if(opts.displayOnClick) html += ' onclick="' + (vars.page == 1 ? '' : 'catFilters.page(' + (vars.page - 1) + ',' + opts.callback + ');') + '"';
				html += '></li>';
				for(var pg = 1; pg <= vars.totalPages; pg++) {
					html += '<li class="page' + (vars.page != pg ? '' : ' inactive') + '"';
					if(opts.displayOnClick) html += ' onclick="' + (vars.page != pg ? '' : 'catFilters.page(' + pg + ',' + opts.callback + ');') + '"';
					html += '></li>';
				}
				html += '<li class="next' + (vars.page < vars.totalPages ? '' : ' inactive') + '"';
				if(opts.displayOnClick) html += ' onclick="' + (vars.page == vars.totalPages ? '' : 'catFilters.page(' + (vars.page + 1) + ',' + opts.callback + ');') + '"';
				html += '></li><li class="last' + (vars.page < vars.totalPages ? '' : ' inactive') + '"';
				if(opts.displayOnClick) html += '  onclick="' + (vars.page == vars.totalPages ? '' : 'catFilters.page(' + vars.totalPages + ',' + opts.callback + ');') + '"';
				html += '></li></ul></div></div>';
			}
			return html;
		};

		return {
			filter: filter,
			filterUpdate: filterUpdate,
			init: init,
			page: page,
			renderFilter: renderFilter,
			renderPagination: renderPagination,
			reset: reset,
			search: search,
			vars: function(){return vars}
		};
	})();

	// Initialize catFilters
	if(typeof catFiltersOpts == 'object') catFilters.init(catFiltersOpts);
	else console.error('catFiltersOpts is not defined, catFilters not initialized');
}
