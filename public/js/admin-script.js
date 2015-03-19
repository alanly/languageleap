/**
 * Surrounds the currently selected text with the given tag name and
 * attributes.
 *
 * @param  {String}  tagName  The tag name (ie. span, div)
 * @return {String}  Returns the currently selected text without the tags
 */
function addTagToSelection(tagName) {
	try {
		var newElement = document.createElement(tagName);
		var selectedRange = getSelection().getRangeAt(0);
		var selectedText = selectedRange.toString();

		if (selectedText.trim().length == 0) {
			return '';
		}

		// Regular expressions to help trim whitespace from the selected ranges
		var startSpaces = /^(\s+)/g;
		var endSpaces = /(\s+)$/g;
		
		// Trim the beginning of the range
		var matches = selectedText.match(startSpaces);
		if (matches) {
			selectedRange.setStart(
				selectedRange.startContainer,
				selectedRange.startOffset + matches[0].length
			);
		}

		// Trim the end of the range
		matches = selectedText.match(endSpaces);
		if (matches) {
			selectedRange.setEnd(
				selectedRange.endContainer,
				selectedRange.endOffset - matches[0].length
			);
		}

		// The start and end of the range are equal
		if (selectedRange.collapsed) {
			return '';
		}

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
 * @param {jQuery Object} $element A jQuery object representing the element to
 * be unselected
 */
function undoSelectedText($element) {
	$('#' + $element.attr('aria-describedby')).remove();
	
	if ($element.contents().length > 0) {
		$element.contents().unwrap();
	} else {
		$element.remove();
	}
}

/**
 * Sets the 'data-type' attribute to the given type.
 *
 * @param {jQuery Object} $context A jQuery object representing a context(ie. 
 * the span that we want to edit)
 * @param {String}        type    The type of content (ie. word, actor)
 */
function setTagType($context, type) {
	$context.attr('data-type', type);	
	$context.data('type', type);	
}

/**
 * Shows the modal form with the proper context because some form elements
 * should only be visible in certain contexts.
 *
 * @param {jQuery Object} $context A jQuery object representing the form 
 * context (ie. the span that we want to edit)
 */
function showModalForm($context) {
	$('#selected-text').val($context.text());

	// Keep the original data before the user starts modifying stuff (just in 
	// case he wants to click cancel)
	backupContextData($context);

	clearWordForm();
	clearActorForm();

	switch($context.data('type')) {
		case 'word':
			showWordForm();
			fillWordForm($context);
			hideActorForm();
			break;
		case 'actor':
			showActorForm();
			fillActorForm($context);
			hideWordForm();
			break;
		default:
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
	$('#full-definition textarea').prop('required', true);
	$('#pronunciation input').prop('required', true);
	$('#synonyms input').prop('required', true);
}

/**
 * Fills the form associated with a word using the data from the context.
 *
 * @param {jQuery Object} $context A jQuery object representing the form 
 * context (ie. the span that we want to edit)
 */
function fillWordForm($context) {
	$('#definition textarea').val($context.data('definition'));
	$('#full-definition textarea').val($context.data('full-definition'));
	$('#pronunciation input').val($context.data('pronunciation'));	
	$('#synonyms input').val($context.data('synonyms'));
}

/**
 * Hides the form associated with words.
 */
function hideWordForm() {
	$('#word-form').hide();
	$('#definition textarea').prop('required', false);
	$('#full-definition textarea').prop('required', false);
	$('#pronunciation input').prop('required', false);
	$('#synonyms input').prop('required', false);
}

/**
 * Clears the form associated with words.
 */
function clearWordForm() {
	$('#definition textarea').val('');
	$('#full-definition textarea').val('');
	$('#pronunciation input').val('');
	$('#synonyms input').val('');
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
 * @param {jQuery Object} $context A jQuery object representing the form 
 * context (ie. the span that we want to edit)
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
 * Saves the form values for the given context as data belonging to the 
 * context.
 *
 * @param {jQuery Object} $context A jQuery object representing the form 
 * context (ie. the span that we want to edit)
 */
function saveContextData($context) {
	$context.text($('#selected-text').val());

	if (
		$('#selected-text').val().trim() == '' 
		|| $context.data('type') == '' 
		|| typeof $context.data('type') == 'undefined'
	) {
		undoSelectedText($context);
	} else if ($context.data('type') == 'word') {
		$context.data('definition', $('#definition textarea').val());
		$context.data('full-definition', $('#full-definition textarea').val());
		$context.data('pronunciation', $('#pronunciation input').val());
		$context.data('synonyms', $('#synonyms input').val());
	} else if ($context.data('type') == 'actor') {
		$context.attr('data-timestamp', $('#timestamp input').val());
	}
}

/**
 * Backs-up the data stored on the given context so that it can later be 
 * restored if the user cancels the edit.
 *
 * @param {jQuery Object} $context A jQuery object representing the form 
 * context (ie. the span that we want to edit)
 */
function backupContextData($context) {
	$context.data('old-type', $context.data('type'));

	if ($context.data('type') == 'word') {
		$context.data('old-definition', $context.data('definition'));
		$context.data('old-full-definition', $context.data('full-definition'));
		$context.data('old-pronunciation', $context.data('pronunciation'));
		$context.data('old-synonyms', $context.data('synonyms'));
	} else if ($context.data('type') == 'actor') {
		$context.data('old-timestamp', $context.data('timestamp'));
	}
}

/**
 * Restores the given context to the data values that were backed-up.
 *
 * @param {jQuery Object} $context A jQuery object representing the form 
 * context (ie. the span that we want to edit)
 */
function restoreContextData($context) {
	setTagType($context, $context.data('old-type'));

	if ($context.data('old-type') == 'word') {
		$context.data('definition', $context.data('old-definition'));
		$context.data('full-definition', $context.data('old-full-definition'));
		$context.data('pronunciation', $context.data('old-pronunciation'));
		$context.data('synonyms', $context.data('old-synonyms'));
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
	$('.script-editor span').tooltip({
		'container': '.script-editor',
		'placement': 'auto top',
		'title'    : 'Click to edit'
	});
}

/**
 * This function is called when the user selects text in the script by double-
 * clicking or dragging.
 */
function textSelected() {
	var selectedText = addTagToSelection('span');
	if (! selectedText) return;

	$('.script-editor').data('modal-context', $(selectedText));

	window.getSelection().collapseToStart();

	// If there are nested elements, deselect the text that was just selected
	if ($('.script-editor').data('modal-context').children().length > 0) {
		undoSelectedText($('.script-editor').data('modal-context'));
	} else {
		window.getSelection().removeAllRanges();
		showModalForm($('.script-editor').data('modal-context'));
		refreshTooltips();
	}
}

/**
 * Removes tooltips from the script editor.
 */
function removeTooltips() {
	$('.script-editor span').removeAttr('data-original-title').removeAttr('title');
	$('.script-editor .tooltip').remove();
}

//////////////////////////////////////////////////////////////
// Button handlers                                          //
//////////////////////////////////////////////////////////////
function saveButtonClick() {
	saveContextData($('.script-editor').data('modal-context'));
}

function removeButtonClick() {
	undoSelectedText($('.script-editor').data('modal-context'));
}

function cancelButtonClick() {
	restoreContextData($('.script-editor').data('modal-context'));
}

function noTagButtonClick() {
	showNoTagForm();
	hideWordForm();
	hideActorForm();
	setTagType($('.script-editor').data('modal-context'), '');
}

function wordButtonClick() {
	showWordForm();
	hideActorForm();

	// data-timestamp in the tag is not needed for definitions. Only timestamps 
	// need the data-timestamp attribute
	$('.script-editor').data('modal-context').removeAttr('data-timestamp');

	setTagType($('.script-editor').data('modal-context'), 'word');
}

function actorButtonClick() {
	showActorForm();
	hideWordForm();
	setTagType($('.script-editor').data('modal-context'), 'actor');
}

/**
 * Inserts the given text at the current caret position.
 *
 * @param {String} text The text that will be inserted at the caret position
 */
function insertTextAtCursor(text) {
	var selection, range;

	if (window.getSelection) {
		selection = window.getSelection();

		if (selection.getRangeAt && selection.rangeCount) {
			range = selection.getRangeAt(0);
			range.deleteContents();
			var textNode = document.createTextNode(text);
			range.insertNode(textNode);
			range.setStartAfter(textNode);

			if (! isIE()) {
				selection.removeAllRanges();
				selection.addRange(range);
			}
		}
	} else if (document.selection && document.selection.createRange) {
		document.selection.createRange().text = text;
	}
}

/**
 * Checks if the user's browser is Internet Explorer.
 */
function isIE() {
	var ua = window.navigator.userAgent;

	if (ua.indexOf("MSIE ") > 0 || ua.match(/Trident.*rv\:11\./)) {
		return true;
	}

	return false;
}

/**
 * Gets the script text that is in the required format for storing in the
 * database.
 *
 * @return {String} The sanitized script text
 */
function getScriptText() {
	removeTooltips();
	return $('.script-editor').html();
}

//////////////////////////////////////////////////////////////
// JQuery's OnDocumentReady                                 //
//////////////////////////////////////////////////////////////
$(function() {
	// Load the script into the contenteditable div
	//loadScript(1);

	// Prevent pasting into the script contenteditable field
	$('.script-editor').on('paste', function(e){ 
		e.preventDefault();
	});

	// A fix for browsers that insert <div> for linebreaks. Instead they will
	// insert <br> tags that can easily be stripped later on
	$('.script-editor').on('keyup', function(){
		if (!isIE() && ($(this).children().length == 0 || $(this).children().last()[0].nodeName.toLowerCase() != 'br')) {
			$(this).append(document.createElement('br'));
		}
	}).on('keypress', function(e){
		if (e.which == 13) {
			if (window.getSelection) {
				var selection = window.getSelection(),
				range = selection.getRangeAt(0),
				br = document.createElement('br');
				range.deleteContents();
				range.insertNode(br);

				if (isIE()) {
					range.setStart(br, 1);
					range.setEnd(br, 1);
				} else {
					range.setStartAfter(br);
					range.setEndAfter(br);
				}		

				range.collapse(false);
				selection.removeAllRanges();
				selection.addRange(range);
				return false;
			}
		}
	});

	// A fix for IE. When deleting all of the content in the contenteditable div,
	// spans will sometimes remain.
	$('.script-editor').on('keyup', function(){
		if ($(this).text().trim().length == 0) {
			$(this).html('');
		}
	})

	// This is a fix for placing the cursor at the end of the contenteditable div
	// if a span is the last element.
	$('.script-editor').on('mousedown', function() {
		if (!this.lastChild || this.lastChild.nodeName.toLowerCase() == 'br') {
			if ($(this).text().slice(-1) != ' ') {
				$(this.lastChild).before(' ');
			}
		}
	});

	// All inputted text goes through here to prevent weird inconsistent behavior
	// across web browsers.
	$('.script-editor').on('keypress', function(e) {
		e.preventDefault();
		insertTextAtCursor(String.fromCharCode(e.which));
	});

	// Determine if the user is selecting text within the script contenteditable field by dragging
	var isDragging = false;
	$('.script-editor').mousedown(function(e) {
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
	$('.script-editor').dblclick(function() {
		textSelected();
	});

	// Edit the selected element
	$('.script-editor').on('click', 'span', function(e) {
		window.getSelection().removeAllRanges();
		
		$('.script-editor').data('modal-context', $(this));
		showModalForm($(this));
	});

	// A save was requested from the modal form
	$('#edit-form').submit(function(event) {
		$('#edit-modal').modal('hide');
		saveButtonClick();
		return false;
	});

	$('#no-tag-radio').on('click', noTagButtonClick);
	$('#word-radio').on('click', wordButtonClick);
	$('#actor-radio').on('click', actorButtonClick);
	$('#remove-button').on('click', removeButtonClick);
	$('#cancel-button').on('click', cancelButtonClick);
});

//////////////////////////////////////////////////////////////
// AJAX stuff                                               //
//////////////////////////////////////////////////////////////
function loadScript(scriptId) {
	$.getJSON('/api/scripts/' + scriptId, function(data) {
		if (data.status == 'success') {
			var scriptText = data.data.text;
			$('.script-editor').html(scriptText);

			// If a script is loaded that does not have a br tag
			// at the end, if the user places the cursor at the end of
			// the content, he will need to press enter twice to get a line-break.
			// This fixes that issue.
			$('.script-editor').append('<br>');

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
	removeTooltips();

	$.ajax({
		type: 'PUT',
		url: '/api/scripts/' + scriptId,
		data: JSON.stringify({ 
			'text': $('.script-editor').html()
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
	$('.script-editor span[data-type=word]').each(function() {
		var $this = $(this);
		var definitionId = $this.data('id');

		if (definitionId == undefined) return;

		$.getJSON('/api/metadata/definitions/' + definitionId, function(data) {
			if (data.status == 'success') {
				$this.data('definition', data.data.definition);
				$this.data('full-definition', data.data.full_definition);
				$this.data('pronunciation', data.data.pronunciation);
				$this.data('synonyms', data.data.synonym);
			} else {
				// Handle failure
			}
		});
	});
}

function saveDefinitions(scriptId) {
	var $wordSpans = $('.script-editor span[data-type=word]');
	
	// When this becomes 0, all definitions have been saved
	var ajaxRequestsRemaining = $wordSpans.length;

	$wordSpans.each(function() {
		var $this = $(this);
		var json = {
			'word': $this.text(),
			'definition': $this.data('definition'),
			'full_definition': $this.data('full-definition'),
			'pronunciation': $this.data('pronunciation'),
			'synonym': $this.data('synonyms')
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

	if (ajaxRequestsRemaining < 1) saveScript(scriptId);
}