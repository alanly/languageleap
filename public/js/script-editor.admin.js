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
* @param {jQuery Object} $context A jQuery object representing a context(ie. the span that we want to edit)
* @param {String} type The type of content (ie. word, actor)
*/
function setTagType($context, type) {
	$context.attr('data-type', type);	
	$context.data('type', type);	
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
	backupContextData($context);

	clearWordForm();
	clearActorForm();

	if ($context.data('type') == 'word') {
		showWordForm();
		fillWordForm($context);
		hideActorForm();
	} else if ($context.data('type') == 'actor') {
		showActorForm();
		fillActorForm($context);
		hideWordForm();
	} else {
		showNoTagForm();
		hideWordForm();
		hideActorForm();
	}

	// Make the modal pop up
	$('#edit-modal').modal();
}

/**
* Shows the form associated with words.
*/
function showWordForm() {
	$('#word-form').show();
	$('#word-radio').prop('checked', true);
	$('#definition textarea').prop('required', true);
}

/**
* Fills the form associated with a word using the data from the context.
*
* @param {jQuery Object} $context A jQuery object representing the form context (ie. the span that we want to edit)
*/
function fillWordForm($context) {
	$('#definition textarea').val($context.data('definition'));
	$('#full-definition textarea').val($context.data('full-definition'));
	$('#pronunciation input').val($context.data('pronunciation'));	
}

/**
* Hides the form associated with words.
*/
function hideWordForm() {
	$('#word-form').hide();
	$('#definition textarea').prop('required', false);
}

/**
* Clears the form associated with words.
*/
function clearWordForm() {
	$('#definition textarea').val('');
	$('#full-definition textarea').val('');
	$('#pronunciation input').val('');
}

/**
* Shows the form associated with actors.
*/
function showActorForm() {
	$('#actor-form').show();
	$('#actor-radio').prop('checked', true);
	$('#timestamp input').prop('required', true);
}

/**
* Fills the form associated with an actor using the data from the context.
*
* @param {jQuery Object} $context A jQuery object representing the form context (ie. the span that we want to edit)
*/
function fillActorForm($context) {
	$('#timestamp input').val($context.data('timestamp'));
}

/**
* Hides the form associated with actors.
*/
function hideActorForm() {
	$('#actor-form').hide();
	$('#timestamp input').prop('required', false);
}

/**
* Clears the form associated with actors.
*/
function clearActorForm() {
	$('#timestamp input').val('');
}

/**
* Shows the form associated with no tags.
*/
function showNoTagForm() {
	$('#no-tag-radio').prop('checked', true);
}

/**
* Saves the form values for the given context as data belonging to the context
*
* @param {jQuery Object} $context A jQuery object representing the form context (ie. the span that we want to edit)
*/
function saveContextData($context) {
	$context.text($('#selected-text').val());

	if ($('#selected-text').val().trim() == '' || $context.data('type') == '' || typeof $context.data('type') == 'undefined') {
		undoSelectedText($context);
	} else if ($context.data('type') == 'word') {
		$context.data('definition', $('#definition textarea').val());
		$context.data('full-definition', $('#full-definition textarea').val());
		$context.data('pronunciation', $('#pronunciation input').val());
	} else if ($context.data('type') == 'actor') {
		$context.attr('data-timestamp', $('#timestamp input').val());
	}
}

/**
* Backs-up the data stored on the given context so that it can later be restored if the user cancels the edit.
*
* @param {jQuery Object} $context A jQuery object representing the form context (ie. the span that we want to edit)
*/
function backupContextData($context) {
	$context.data('old-type', $context.data('type'));

	if ($context.data('type') == 'word') {
		$context.data('old-definition', $context.data('definition'));
		$context.data('old-full-definition', $context.data('full-definition'));
		$context.data('old-pronunciation', $context.data('pronunciation'));
	} else if ($context.data('type') == 'actor') {
		$context.data('old-timestamp', $context.data('timestamp'));
	}
}

/**
* Restores the given context to the data values that were backed-up.
*
* @param {jQuery Object} $context A jQuery object representing the form context (ie. the span that we want to edit)
*/
function restoreContextData($context) {
	setTagType($context, $context.data('old-type'));

	if ($context.data('old-type') == 'word') {
		$context.data('definition', $context.data('old-definition'));
		$context.data('full-definition', $context.data('old-full-definition'));
		$context.data('pronunciation', $context.data('old-pronunciation'));
	} else if ($context.data('old-type') == 'actor') {
		$context.attr('data-timestamp', $context.data('old-timestamp'));
	} else {
		undoSelectedText($context);
	}
}

/**
* Adds tooltips to the current spans.
*/
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
}

//////////////////////////////////////////////////////////////
// Button handlers                                          //
//////////////////////////////////////////////////////////////
function saveButtonClick() {
	saveContextData($('#script').data('modal-context'));
}

function removeButtonClick() {
	undoSelectedText($('#script').data('modal-context'));
}

function cancelButtonClick() {
	restoreContextData($('#script').data('modal-context'));
}

function noTagButtonClick() {
	showNoTagForm();
	hideWordForm();
	hideActorForm();
	setTagType($('#script').data('modal-context'), '');
}

function wordButtonClick() {
	showWordForm();
	hideActorForm();

	// data-timestamp in the tag is not needed for definitions. Only timestamps need the data-timestamp attribute
	$('#script').data('modal-context').removeAttr('data-timestamp');

	setTagType($('#script').data('modal-context'), 'word');
}

function actorButtonClick() {
	showActorForm();
	hideWordForm();
	setTagType($('#script').data('modal-context'), 'actor');
}

//////////////////////////////////////////////////////////////
// JQuery's OnDocumentReady                                 //
//////////////////////////////////////////////////////////////
$(function() {
	// Load the script into the contenteditable div
	loadScript(1);

	// Prevent pasting into the script contenteditable field
	$('#script').on('paste', function(e){ 
		e.preventDefault();
	});

	// A fix for browsers that insert <div> for linebreaks. Instead they will
	// insert <br> tags that can easily be stripped later on
	$('#script').on('keyup', function(){
		if (!this.lastChild || this.lastChild.nodeName.toLowerCase() != 'br') {
			this.appendChild(document.createElement('br'));
		}
	}).on('keypress', function(e){
		if (e.which == 13) {
			if (window.getSelection) {
				var selection = window.getSelection(),
				range = selection.getRangeAt(0),
				br = document.createElement('br');
				range.deleteContents();
				range.insertNode(br);
				range.setStartAfter(br);
				range.setEndAfter(br);
				range.collapse(false);
				selection.removeAllRanges();
				selection.addRange(range);
				return false;
			}
		}
	});

	// This is a fix for placing the cursor at the end of the contenteditable div
	// if a span is the last element.
	$('#script').on('click keyup', function() {
		if (this.lastChild.nodeName.toLowerCase() == 'br') {
			$(this.lastChild).before(' ');
		}
	});

	// Determine if the user is selecting text within the script contenteditable field by dragging
	var isDragging = false;
	$('#script').mousedown(function(e) {
		if (e.target == this) {
			$(window).mousemove(function() {
				isDragging = true;
				$(window).unbind('mousemove');
			});
		}
	}).mouseup(function(e) {
		var wasDragging = isDragging;
		isDragging = false;
		$(window).unbind('mousemove');

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
		showModalForm($(this));
	});

	// A save was requested from the modal form
	$('#edit-form').submit(function() {
		$('#edit-modal').modal('hide');
		saveButtonClick();
		return false;
	});
});

//////////////////////////////////////////////////////////////
// AJAX stuff                                               //
//////////////////////////////////////////////////////////////
function loadScript(scriptId) {
	$.getJSON('/api/scripts/' + scriptId, function(data) {
		if (data.status == 'success') {
			var scriptText = data.data.text;
			$('#script').html(scriptText);

			// Make sure that tooltips are added to existing spans
			refreshTooltips();

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
				$this.data('definition', data.data.definition);
				$this.data('full-definition', data.data.full_definition);
				$this.data('pronunciation', data.data.pronunciation);
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
		var json = {
			'word': $this.text(),
			'definition': $this.data('definition'),
			'full_definition': $this.data('full-definition'),
			'pronunciation': $this.data('pronunciation')
		};

		if ($this.data('id')) {
			$.ajax({
				type: 'PUT',
				url: '/api/metadata/definitions/' + $this.data('id'),
				data: JSON.stringify(json),
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
				data: JSON.stringify(json),
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