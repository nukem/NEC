var infoBox = $('#compare-items');

function compareInfoBox() {
	// Check to see if the information is being displayed
	// Create if it isn't, or update if it exists.
	if($('#compare-items').size() == 0) {
		$('#user_panel').after('<div id="compare-items" style="display: none"></div>');
	}

	updateProducts();

	return false;
	
}

function updateProducts() {
	var postData;
	postData = { 'ajax' : true };
	$.ajax({
		type: "POST",
		url: './compare/show_items',
		data: postData,
		success: function (data) {
			processResponse(data);
		},
		dataType: 'json'
	})
}

function processProduct(anchor) {
	var data;
	data = { 'ajax' : true };
	$.ajax({
		type: "POST",
		url: anchor.attr('href'),
		data: data,
		success: function(data) {
			if(data.message != '') {
				$.growlUI(data.message); 
			}
			toggleCompareStatus(anchor);
			prodId = anchor.attr('rel');
			console.log(anchor.hasClass('compare-cross'));
			if(anchor.hasClass('compare-cross') == false) {
				if(data.result == 'add') {
					anchor.attr('href', 'compare/remove_item/' + prodId);
					anchor.text('Remove from Comparison List');
				} else {
					anchor.attr('href', 'compare/add_item/' + prodId);
					anchor.text('Add to Comparison List');
				}
			}
			compareInfoBox();
		},
		dataType: 'json'
	});
	return false;
}

function addProduct(anchor) {
	var data;
	data = { 'ajax' : true };
	$.ajax({
		type: "POST",
		url: anchor.attr('href'),
		data: data,
		success: function(data) {
			if(data.message != '') {
				$.growlUI(data.message); 
			}
			toggleCompareStatus(anchor);
			prodId = anchor.attr('rel');
			anchor.attr('onclick', 'return removeProduct($(this));');
			anchor.attr('href', 'compare/remove_item/' + prodId);
			anchor.text('Remove from Comparison List');
			
			compareInfoBox();
		},
		dataType: 'json'
	});
	return false;
}

function removeProduct(anchor) {
	var data;
	data = { 'ajax' : true };
	$.ajax({
		type: "POST",
		url: anchor.attr('href'),
		data: data,
		success: function(data) {
			if(data.message != '') {
				$.growlUI(data.message); 
			}
			prodId = anchor.attr('rel');
			anchor.attr('onclick', 'return addProduct($(this));');
			anchor.attr('href', 'compare/add_iem/' + prodId);
			anchor.text('Add to Comparison List');
			compareInfoBox();
		},
		dataType: 'json'
	});
	return false;
}

function toggleCompareStatus(anchor) {
}

function processResponse(data) {
	if(data.error == true) {
		// create growl here.
	}

	var htmlData = '<div class="comparison-header"><a href="compare/products/">Product Comparison</a></div>';
	htmlData += '<span class="comparison-text">Saved Products:</span>';
	htmlData += '<span class="saved-products">';
		console.log(data.count);
	if(data.count > 0) {
		for (i in data.products) {
			htmlData += '<span>';
			htmlData += '<a href="products/detail/' + i + '">' + data.products[i] + '</a>';
			htmlData += '<a href="compare/remove_item/' + i + '" class="compare-cross" onclick="return processProduct($(this));"><img src="./includes/images/cross.gif" /></a>';
			htmlData += '</span>';
		}
	} else {
		htmlData += 'No products added to comparison list.';
	}
	htmlData += '</span>';
	$('#compare-items').html(htmlData);

	if(data.message != '') {
		$.growlUI(data.message); 
	}

	if($('#compare-items').is(':hidden')) {
		$('#compare-items').slideDown('slow');
	}
	
}
