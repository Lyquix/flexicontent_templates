/**
 * cat-map.js
 *
 * @version     2.3.0
 * @package     flexicontent_templates
 * @author      Lyquix
 * @copyright   Copyright (C) 2015 - 2018 Lyquix
 * @license     GNU General Public License version 2 or later
 * @link        https://github.com/Lyquix/flexicontent_templates
 */

if(typeof catMap == 'undefined') var catMap = {};

catMap.options.center = new google.maps.LatLng(0,0);
catMap.options.mapTypeId = google.maps.MapTypeId[catMap.options.mapTypeId];
catMap.bounds = new google.maps.LatLngBounds();
catMap.map = new google.maps.Map(document.getElementById('cat-map'), catMap.options);

google.maps.event.addListenerOnce(catMap.map, 'bounds_changed', function(event){
	catMap.map.fitBounds(catMap.bounds);
	catMap.map.panToBounds(catMap.bounds);
});

// get catMap Item by Id, we want to get the original properties, such as id, html etc
catMap.getItem = function(id) {
	// context, this = catMap.items
	var tResults = this.items.filter(function(item){
		return (item.id == id);
	});

	// filter returns array, but we only want the result to be a single item, so we return the first item in the array
	if (tResults.length == 1)
		return tResults[0];
	else
		return {};
};

// get catMap group by id, most likely we want to count the number of items within the group, when we hide/show items on filter
catMap.getGroup = function(id) {
	var tResults = this.groupedItems.filter(function(items){
		var found = false;
		items.forEach(function(item){
			if (item.id == id)
				found = true;
		});
		return found;
	})

	if (tResults.length == 1)
		return tResults[0];
	else
		return {};
};

//group items to groupedItems as arrays.
for (var i = 0; i < catMap.items.length; i++) {
	// if empty, just push the item as array
	if (!catMap.groupedItems.length) {
		catMap.items[i].group = i;
		var newGroup = [catMap.items[i]]
		catMap.groupedItems.push(newGroup);
	} else {
		// if not empty, check the current item lat lon against all groups items
		var indexFound = -1;
		for(var j = 0; j < catMap.groupedItems.length; j++) {
			var found = false;
			for(var k = 0; k < catMap.groupedItems[j].length; k++) {
				// lat lon vicinity checker using the 4th decimal (0.0001000), meaning we check if the item is inside 7-11m radius
				var latPlus = catMap.groupedItems[j][k].lat + 0.0001000;
				var latMinus = catMap.groupedItems[j][k].lat - 0.0001000;

				var lonPlus = catMap.groupedItems[j][k].lon + 0.0001000;
				var lonMinus = catMap.groupedItems[j][k].lon - 0.0001000;
				if (latMinus < catMap.items[i].lat && catMap.items[i].lat < latPlus && lonMinus < catMap.items[i].lon && catMap.items[i].lon < lonPlus ) {
					found = true;
					break;
				}
			}

			if (found) {
				indexFound = j;
				break;
			}
		}

		// if the item is NOT inside the vicinity of other item in the groupedItems, push them in a new array group
		if (indexFound == -1) {
			catMap.items[i].group = catMap.groupedItems.length;
			var newGroup = [catMap.items[i]];
			catMap.groupedItems.push(newGroup);
		// if the item is inside the vicinity of other item in the groupedItems, push them in the same group array
		} else {
			catMap.items[i].group = indexFound;
			catMap.groupedItems[indexFound].push(catMap.items[i]);
		}
	}
}

for (var i = 0; i < catMap.items.length; i++) {
	if(catMap.items[i].lat && catMap.items[i].lon) {
		var itemLatLon = new google.maps.LatLng(catMap.items[i].lat, catMap.items[i].lon);
		catMap.bounds.extend(itemLatLon);
		var itemid = catMap.items[i].id;
		catMap.infoWindows[itemid] = new google.maps.InfoWindow({content: catMap.items[i].html});

		var labelString = '';
		var infoWindowHTML = catMap.items[i].html;
		if (catMap.groupedItems[catMap.items[i].group].length > 1) {
			labelString = catMap.groupedItems[catMap.items[i].group].length;
			infoWindowHTML = '';
			catMap.groupedItems[catMap.items[i].group].forEach(function(item){
				infoWindowHTML += item.html;
			})
		}
		var markerParams = {
			position: itemLatLon,
			map: catMap.map,
			title: catMap.items[i].title,
			html: infoWindowHTML,
			label: (labelString == '' ? '' : {text: labelString.toString(), color: "white"})
		}
		if(catMap.items[i].icon != '') markerParams.icon = catMap.items[i].icon;
		catMap.markers[itemid] = new google.maps.Marker(markerParams);
		google.maps.event.addListener(catMap.markers[itemid], 'click', function() {
			catMap.infoWindows[itemid].setContent(this.html);
			catMap.infoWindows[itemid].open(catMap.map,this);
		});
	}
}

jQuery(window).on("screensizechange", function() {
	catMap.map.fitBounds(catMap.bounds);
	catMap.map.panToBounds(catMap.bounds);
});
