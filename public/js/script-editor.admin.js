/**
* Surrounds the currently selected text with the given tag name and attributes.
*
* @param {String} tagName The tag name (ie. span, div)
* @return {String} Returns The currently selected text without the tags
*/
function addTagToSelection(tagName) {
	try {
		var newElement = document.createElement(tagName);
		var selectedRange = getSelection().getRangeAt(0);

		var selectedText = selectedRange.toString();

		if (selectedText.trim().length == 0)
			return '';

		// Regular expressions to help trim whitespace from the selected ranges
		var startSpaces = /^(\s+)/g;
		var endSpaces = /(\s+)$/g;
		
		// Trim the beginning of the range
		var matches = selectedText.match(startSpaces);
		if (matches) {
			selectedRange.setStart(selectedRange.startContainer, selectedRange.startOffset + matches[0].length);
		}

		// Trim the end of the range
		matches = selectedText.match(endSpaces);
		if (matches) {
			selectedRange.setEnd(selectedRange.endContainer, selectedRange.endOffset - matches[0].length);
		}

		// The start and end of the range are equal
		if (selectedRange.collapsed)
			return '';

		selectedRange.surroundContents(newElement);
		
		return newElement;
	} catch (e) {
		// We hate errors, so just return an empty string
		return '';
	}
}

/**
* Removes the span from of the given selected element.
*
* @param {jQuery Object} $element A jQuery object representing the element to be unselected
*/
function undoSelectedText($element) {
	$('#' + $element.attr('aria-describedby')).remove();
	
	if ($element.contents().length > 0)
		$element.contents().unwrap();
	else
		$element.remove();
}

/**
* Sets the 'data-type' attribute to the given type.
*
* @param {String} type The type of content (ie. word, actor)
*/
function setTagType(type) {
	$('#script').data('modal-context').attr('data-type', type);	
	$('#script').data('modal-context').data('type', type);	
}

function saveButtonClick() {
	var $context = $('#script').data('modal-context');

	$context.text($('#selected-text').val());

	if ($('#selected-text').val().trim() != '') {
		if ($context.data('type') == 'word') {
			$context.data('meta', $('#word-definition textarea').val());
		} else if ($context.data('type') == 'actor') {
			$context.data('meta', $('#time-stamp input').val());
		} else {
			undoSelectedText($context);
		}
	} else {
		// If the user emptied the selected text text-box, then unwrap the element
		undoSelectedText($context);
	}
}

function removeButtonClick() {
	undoSelectedText($('#script').data('modal-context'));
}

function cancelButtonClick() {
	var $context = $('#script').data('modal-context');

	if ($('#remove-button').is(':hidden'))
		undoSelectedText($('#script').data('modal-context'));

	setTagType($context.data('old-type'));
	$context.data('meta', $context.data('old-meta'));
}

function noTagButtonClick() {
	$('#word-definition').hide();
	$('#time-stamp input').prop('required', false);
	$('#word-definition textarea').prop('required', false);
	$('#time-stamp').hide();

	setTagType('');
}

function wordButtonClick() {
	$('#word-definition').show();
	$('#time-stamp input').prop('required', false);
	$('#word-definition textarea').prop('required', true);
	$('#time-stamp').hide();

	// Meta in the tag is not need for definitions. Only timestamps need the data-meta attribute
	$('#script').data('modal-context').removeAttr('data-meta');

	setTagType('word');
}

function actorButtonClick() {
	$('#time-stamp').show();
	$('#word-definition').hide();
	$('#word-definition textarea').prop('required', false);
	$('#time-stamp input').prop('required', true);

	setTagType('actor');
}

/**
* Shows the modal form with the proper context because some form elements
* should only be visible in certain contexts.
*
* @param {jQuery Object} $context A jQuery object representing the form context (ie. the span that we want to edit)
*/
function showModalForm($context) {
	$('#selected-text').val($context.text());

	// Keep the original data before the user starts modifying stuff (just in case he wants to click cancel)
	$context.data('old-type', $context.data('type'));
	$context.data('old-meta', $context.data('meta'));

	$('#word-definition textarea').val('');
	$('#time-stamp input').val('');

	if ($context.data('type') == 'word') {
		$('#remove-button').show();
		$('#word-definition').show();
		$('#time-stamp').hide();
		$('#word-radio').prop('checked', true);
		$('#word-definition textarea').val($context.data('meta'));
		$('#word-definition textarea').prop('required', true);
		$('#time-stamp input').prop('required', false);
	} else if ($context.data('type') == 'actor') {
		$('#remove-button').show();
		$('#time-stamp').show();
		$('#word-definition').hide();
		$('#word-definition textarea').prop('required', false);
		$('#time-stamp input').prop('required', true);
		$('#actor-radio').prop('checked', true);
		$('#time-stamp input').val($context.data('meta'));
	} else {
		$('#no-tag-radio').prop('checked', true);
		$('#word-definition').hide();
		$('#word-definition textarea').prop('required', false);
		$('#time-stamp input').prop('required', false);
		$('#time-stamp').hide();
		$('#remove-button').hide();
	}

	$('#edit-modal').modal();
}

function refreshTooltips() {
	$('#script span').tooltip({
		'container': '#script',
		'placement': 'auto top',
		'title': 'Click to edit'
	});
}

/**
* This function is called when the user selects text in the script by double-clicking or dragging.
*/
function textSelected() {
	var selectedText = addTagToSelection('span');
	$('#script').data('modal-context', $(selectedText));

	window.getSelection().collapseToStart();

	if (selectedText) {
		// If there are nested elements, deselect the text that was just selected
		if ($('#script').data('modal-context').children().length > 0) {
			undoSelectedText($('#script').data('modal-context'));
		} else {
			window.getSelection().removeAllRanges();
			showModalForm($('#script').data('modal-context'));
			refreshTooltips();
		}
	}
}

/*
* This function should be run before saving the script to the database.
*/
function prepareSpans() {
	// Remove useless data
	$('#script span').removeAttr('data-original-title').removeAttr('title');

	// Add timestamps as data attributes so they are stored with the script in the database
	$('#script span').each(function () {
		$(this).attr('data-meta', $(this).data('meta'));
	});
}

$(function() {
	// Load the script into the contenteditable div
	loadScript(1);

	// Make sure that tooltips are added to existing spans
	refreshTooltips();

	// Prevent pasting into the script contenteditable field
	$('#script').on('paste', function(e){ 
		e.preventDefault();
	});

	// Prevent using the Enter key in the script contenteditable field
	$('#script').keydown(function(e) {
		if (e.keyCode === 13) {
			return false;
		}
	});

	// Determine if the user is selecting text within the script contenteditable field by dragging
	var isDragging = false;
	$('#script').mousedown(function(e) {
		if (e.target == this) {
			$(window).mousemove(function() {
				isDragging = true;
				$(window).unbind("mousemove");
			});
		}
	}).mouseup(function() {
		var wasDragging = isDragging;
		isDragging = false;
		$(window).unbind("mousemove");

		if (wasDragging) {
			textSelected();
		}
	});

	// Single word selection
	$('#script').dblclick(function() {
		textSelected();
	});

	// Edit the selected element
	$('#script').on('click', 'span', function(e) {
		window.getSelection().removeAllRanges();
		
		$('#script').data('modal-context', $(this));

		$('#edit-modal').modal();
		showModalForm($(this));
	});

	// A save was requested from the modal form
	$('#edit-form').submit(function() {
		$('#edit-modal').modal('hide');
		saveButtonClick();
		return false;
	});

	$('f')
})

//////////////////////////////////////////////////////////////
// AJAX stuff                                               //
//////////////////////////////////////////////////////////////
function loadScript(scriptId) {
	$.getJSON('/api/scripts/' + scriptId, function(data) {
		if (data.status == 'success') {
			var scriptText = data.data.text;
			$('#script').html(scriptText);

			loadDefinitions();
		} else {
			// Handle failure
		}
	});
}

function saveScript(scriptId) {
	// Some sanitization before saving to the database
	prepareSpans();

	$.ajax({
		type: 'PUT',
		url: '/api/scripts/' + scriptId,
		data: JSON.stringify({ 
			'text': $('#script').html()
		}),
		contentType: "application/json; charset=utf-8",
		dataType: "json",
		success: function(data) {
			if (data.status == 'success') {
				console.log('script saved');
				$('#save-success').fadeIn(500).delay(2000).fadeOut(500);
			}
		}
	});
}

function loadDefinitions() {
	$('#script span[data-type=word]').each(function() {
		var $this = $(this);
		var definitionId = $this.data('id');

		if (definitionId == undefined)
			return;

		$.getJSON('/api/metadata/definitions/' + definitionId, function(data) {
			if (data.status == 'success') {
				$this.data('meta', data.data.definition);
			} else {
				// Handle failure
			}
		});
	});
}

function saveDefinitions(scriptId) {
	var $wordSpans = $('#script span[data-type=word]');
	
	// When this becomes 0, all definitions have been saved
	var ajaxRequestsRemaining = $wordSpans.length;

	$wordSpans.each(function() {
		var $this = $(this);
		if ($this.data('id')) {
			$.ajax({
				type: 'PUT',
				url: '/api/metadata/definitions/' + $this.data('id'),
				data: JSON.stringify({ 
					'definition': $this.data('meta')
				}),
				contentType: "application/json; charset=utf-8",
				dataType: "json",
				success: function(data) {
					if (data.status == 'success') {
						console.log('definition updated');
					}
				},
				complete: function() {
					ajaxRequestsRemaining--;

					if (ajaxRequestsRemaining <= 0) {
						saveScript(scriptId);
					}
				}
			});
		} else {
			$.ajax({
				type: 'POST',
				url: '/api/metadata/definitions/',
				data: JSON.stringify({ 
					'definition': $this.data('meta')
				}),
				contentType: "application/json; charset=utf-8",
				dataType: "json",
				success: function(data) {
					if (data.status == 'success') {
						console.log('definition stored');
						$this.attr('data-id', data.data.id);
					}
				},
				complete: function() {
					ajaxRequestsRemaining--;

					if (ajaxRequestsRemaining <= 0) {
						saveScript(scriptId);
					}
				}
			});
		}
	});

	if (ajaxRequestsRemaining <= 0)
		saveScript(scriptId);
}