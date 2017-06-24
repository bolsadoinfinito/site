/**
 * @version	1.0.0
 * @package	 Theme4Press PageBuilder
 * @author	 Theme4Press
 */

(function($) {
	$.t4p_activity_log = {
		/**
		 * Activity stack.
		 * 
		 * @var  array
		 */
		stack: [],

		/**
		 * Current stack index.
		 * 
		 * @var  integer
		 */
		current: -1,

		/**
		 * Stack limitation.
		 * 
		 * @var  integer
		 */
		limit: 20,

		/**
		 * Initialize T4P Activity Log.
		 * 
		 * @return  void
		 */
		init: function() {
			var	self = this,
				toolBar = $('#t4p_page_builder .jsn-form-bar'),
				tab_switcher = $('a[href="#t4p_editor_tab2"]');

			// Create Undo/Redo buttons
			self.buttons = {
				undo: $('<button id="t4p-pb-activity-undo" title="Undo" class="btn btn-default" type="button" disabled="disabled" />').append('<i class="icon-undo" /> UNDO').click(function(event) {
					event.preventDefault();

					if (!$(this).attr('disabled')) {
						self.undo();
					}
				}),

				redo: $('<button id="t4p-pb-activity-redo" title="Redo" class="btn btn-default" type="button" disabled="disabled" />').append('REDO <i class="icon-redo" />').click(function(event) {
					event.preventDefault();

					if (!$(this).attr('disabled')) {
						self.redo();
					}
				}),
			};

			toolBar.after(
				$('<div id="t4p-pb-activity" style="position:relative" />').append(
					$('<div class="btn-group" />').append(
						self.buttons.undo
					).append(
						self.buttons.redo
					).hide()
				)
			);

			// Track scroll action
			var positionButtons = function(event) {
				if ((!event || event.target == window || event.target == document) && tab_switcher.parent().hasClass('active')) {
					var scrollTop = $(window).scrollTop(), toolTop = $('#t4p-pb-activity').offset().top, spacing = $('#wpadminbar').outerHeight(true);

					if (toolTop - scrollTop < spacing) {
						$('#t4p-pb-activity').children().css({
							position: 'fixed',
							top: spacing + 'px',
							left: '50%',
							'margin-left': '-' + ($('#t4p-pb-activity').children().width() / 2) + 'px',
							'z-index': 100000,
						}).show();
					} else {
						$('#t4p-pb-activity').children().css({
							position: 'absolute',
							top: '-' + toolBar.outerHeight(true) + 'px',
							left: '50%',
							'margin-left': '-' + ($('#t4p-pb-activity').children().width() / 2) + 'px',
							'z-index': '',
						}).show();
					}
				}
			};

			$(window).scroll(positionButtons).trigger('scroll');

			// Handle tab switching action
			tab_switcher.click(function() {
				positionButtons();
			});

			// Track add action
			$(document).on('t4p_pb_after_add_element', function(event, element, extra) {
				self.save('add', element, extra);
			});

			// Track edit action
			$(document).on('t4p_pb_after_edit_element', function(event, element, before) {
				self.save('edit', element, before);
			});

			// Track delete action
			$(document).on('t4p_pb_before_delete_element', function(event, element) {
				self.save('delete', element);
			});
		},

		/**
		 * Save an action to activity stack.
		 * 
		 * @param   string  type    Action type, e.g. add, delete,...
		 * @param   mixed   after   Data after change made.
		 * @param   mixed   before  Data before change made.
		 * 
		 * @return  void
		 */
		save: function(type, after, before) {
			if (this.current + 1 < this.stack.length) {
				// Truncate activity stack to current activity index
				this.stack = this.stack.slice(0, this.current + 1);

				// Disable redo button
				this.buttons.redo.attr('disabled', 'disabled');
			}

			// Prepare activity data
			var data = {before: [], after: []}, row, column, position;

			// Prepare data after change has been made
			if (!after.length) {
				after = $(after);
			}

			after.each(function(index, element) {
				// Detect element position
				row = column = position = -1;

				var this_row = $(element).hasClass('jsn-row-container') ? $(element) : $(element).closest('.jsn-row-container');

				$('#t4p_page_builder .jsn-row-container').each(function(i, e) {
					if (row > -1) {
						return;
					}

					if (e == this_row[0]) {
						row = i;
					}
				});
	
				if (!$(element).hasClass('jsn-row-container')) {
					var this_column = $(element).hasClass('jsn-column-container') ? $(element) : $(element).closest('.jsn-column-container');

					this_row.find('.jsn-column-container').each(function(i, e) {
						if (column > -1) {
							return;
						}
	
						if (e == this_column[0]) {
							column = i;
						}
					});

					if ($(element).hasClass('jsn-element')) {
						this_column.find('.jsn-element').each(function(i, e) {
							if (position > -1) {
								return;
							}
		
							if (e == element) {
								position = i;
							}
						});
					}
				}
	
				// Store activity data
				data.after.push({
					html: $(element).outerHTML().replace(/width\s*:\s*[\d\.]+(px|%)\s*;?/g, ''),
					position: {
						row: row,
						column: column,
						position: position,
					},
				});
			});

			// Prepare data before change has been made
			if (before) {
				if (typeof before == 'string') {
					before = [before];
				}

				$.each(before, function(index, element) {
					// Store original data
					data.before.push({
						html: element.replace(/width\s*:\s*[\d\.]+(px|%)\s*;?/g, ''),
					});
				});
			}

			// Set data-just-added flag for add action
			if (type == 'add' && before != 'cloned' && data.after[0].html.indexOf(' jsn-element ') > -1) {
				data.after[0].html = data.after[0].html.replace(/ class="/, ' data-just-added="1" class="');
			}

			// Verify activity chain
			if (this.stack[this.current] && this.stack[this.current].type == 'add' && this.stack[this.current].data.after[0].html.match(/ data-just-added="1"/)) {
				// Clear data-just-added flag
				this.stack[this.current].data.after[0].html = this.stack[this.current].data.after[0].html.replace(/ data-just-added="1"/, '');

				if (
					type == 'edit'
					&&
					data.after.length == this.stack[this.current].data.after.length
					&&
					data.after[0].position.row == this.stack[this.current].data.after[0].position.row
					&&
					data.after[0].position.column == this.stack[this.current].data.after[0].position.column
					&&
					data.after[0].position.position == this.stack[this.current].data.after[0].position.position
				) {
					// Update data for previous add action
					this.stack[this.current].data.after = data.after;

					// Stop processing further
					return;
				}
			}

			// Put last activity to stack
			this.stack.push({type: type, data: data});

			// Enable undo button
			this.buttons.undo.removeAttr('disabled');

			// Check if stack is over limitation
			if (this.stack.length > this.limit) {
				var shifted = this.stack.length - this.limit;

				// Shift activity stack
				this.stack = this.stack.slice(shifted, this.stack.length);

				// Update current activity index
				this.current -= shifted - 1;
			} else {
				// Update current activity index
				this.current++;
			}
		},

		/**
		 * Undo an action previously stored in activity stack.
		 * 
		 * @return  void
		 */
		undo: function() {
			if (this.stack.length && this.current > -1) {
				if (this.processing) {
					return;
				}

				// Mark processing flag
				delete this.timeout;

				this.processing = true;

				// Undo last activity
				var action = this.stack[this.current];

				if (typeof this['undo_' + action.type] == 'function') {
					this.finish(this['undo_' + action.type](action.data));
				}

				// Update current activity index
				this.current--;

				// Enable redo button
				this.buttons.redo.removeAttr('disabled');

				// Check if user can undo more
				if (this.current < 0) {
					// Disable undo button
					this.buttons.undo.attr('disabled', 'disabled');
				}
			}
		},

		/**
		 * Redo an action previously stored in activity stack.
		 * 
		 * @return  void
		 */
		redo: function() {
			if (this.stack.length && this.current + 1 < this.stack.length) {
				if (this.processing) {
					return;
				}

				// Mark processing flag
				delete this.timeout;

				this.processing = true;

				// Update current activity index
				this.current++;

				// Redo last undo-ed activity
				var action = this.stack[this.current];

				if (typeof this['redo_' + action.type] == 'function') {
					this.finish(this['redo_' + action.type](action.data));
				}

				// Enable undo button
				this.buttons.undo.removeAttr('disabled');

				// Check if user can redo more
				if (this.current + 1 == this.stack.length) {
					// Disable redo button
					this.buttons.redo.attr('disabled', 'disabled');
				}
			}
		},

		/**
		 * Finish undo / redo action.
		 * 
		 * @param   object  row  Affected row.
		 * 
		 * @return  void
		 */
		finish: function(row) {
			var self = this;

			if (row.length) {
				// Scroll to affected element if it is outside of current view
				var top = $(window).scrollTop(), height = $(window).height(), position = row.offset(), spacing = $('#wpadminbar').outerHeight(true);
	
				if (position.top - top < spacing || position.top > top + height) {
					// Scroll to affected row
					$('html, body').animate({
						scrollTop: position.top - spacing
					}, 200);
				}
			}

			// Allow 200ms for undo action to complete
			if (!self.timeout) {
				self.timeout = setTimeout(function() {
					// Clear processing flag
					self.processing = false;
				}, 200);
			}
		},

		/**
		 * Make given element flash.
		 * 
		 * @param   object  element  Element to be flashed.
		 * 
		 * @return  void
		 */
		flash: function(element) {
			var self = this;

			// Generate flashing element
			$('<div class="flashing_element" />').css({
				position: 'absolute',
				top: element.offset().top + 'px',
				left: element.offset().left + 'px',
				width: element.outerWidth() + 'px',
				height: element.outerHeight() + 'px',
				border: '2px solid #F5AF5D',
			}).appendTo(document.body);

			// Reset timeout
			self.timeout && clearTimeout(self.timeout);

			self.timeout = setTimeout(function() {
				var flashing_elements = $('body > .flashing_element');

				flashing_elements.fadeOut('slow', function() {
					// Remove flashing elements
					flashing_elements.remove();

					// Clear processing flag
					self.processing = false;
				});
			}, 1000);
		},

		/**
		 * Replace specified elements with another contents.
		 * 
		 * @param   array  from  Original elements.
		 * @param   array  to    New contents.
		 * 
		 * @return  object  Affected row.
		 */
		replace: function(from, to) {
			var self = this, affected_row = -1;

			$.each(from, function(i, e) {
				// Search element based on saved position
				var	row_index = e.position ? e.position.row : to[i].position.row,
					row = $('#t4p_page_builder .jsn-row-container').eq(row_index),
					column = row.find('.jsn-column-container').eq(e.position ? e.position.column : to[i].position.column),
					element = column.find('.jsn-element').eq(e.position ? e.position.position : to[i].position.position),
					flash_required, affected_element;

				// Replace element with original data
				if (e.html.match(/jsn-row-container/) || to[i].html.match(/jsn-row-container/)) {
					// Check if affected element should be flashed
					flash_required = row.hasClass('silent_action') || to[i].html.indexOf(' silent_action') > -1;

					// Replace content
					row.replaceWith(to[i].html);

					// Re-get row
					affected_element = $('#t4p_page_builder .jsn-row-container').eq(e.position ? e.position.row : to[i].position.row);

					// Remove junk element
					affected_element.find('.ui-state-highlight, .ui-sortable-placeholder').remove();

					// Check if re-initialization is required
					var countColumn = affected_element.find('.jsn-column-container').length;

					if (countColumn) {
						$.t4p_pb_layout.initResizable(countColumn);
						$.t4p_pb_layout.rebuildSortable();
					}
				} else if (e.html.match(/jsn-column-container/) || to[i].html.match(/jsn-column-container/)) {
					// Check if affected element should be flashed
					flash_required = column.hasClass('silent_action') || to[i].html.indexOf(' silent_action') > -1;

					// Replace content
					column.replaceWith(to[i].html);

					// Re-get column
					affected_element = row.find('.jsn-column-container').eq(e.position ? e.position.column : to[i].position.column);

					// Re-initialize
					var countColumn = row.find('.jsn-column-container').length;

					$.t4p_pb_layout.initResizable(countColumn);
					$.t4p_pb_layout.rebuildSortable();
				} else {
					// Check if affected element should be flashed
					flash_required = element.hasClass('silent_action') || to[i].html.indexOf(' silent_action') > -1;

					// Replace content
					element.replaceWith(to[i].html);

					// Re-get element
					affected_element = column.find('.jsn-element').eq(e.position ? e.position.position : to[i].position.position);

					// Remove junk element
					affected_element.find('.jsn-icon-loading').remove();
				}

				// Remove junk data
				affected_element.removeClass('active-shortcode');

				// Refresh element width
				$.t4p_pb_layout.updateSpanWidthPBDL($.t4p_pb_layout, $.t4p_pb_layout.wrapper, $.t4p_pb_layout.wrapper.width());

				// Detect row with lowest index
				if (affected_row < 0 || affected_row > row_index) {
					affected_row = row_index;
				}

				// Check if affected element should be flashed
				if (flash_required) {
					self.flash(affected_element.addClass('silent_action'));
				}
			});

			return $('#t4p_page_builder .jsn-row-container').eq(affected_row);
		},

		/**
		 * Undo an add action.
		 * 
		 * @param   object  data  Data associated with action.
		 * 
		 * @return  object  Affected row.
		 */
		undo_add: function(data) {
			return this.redo_delete(data);
		},

		/**
		 * Undo an edit action.
		 * 
		 * @param   object  data  Data associated with action.
		 * 
		 * @return  object  Affected row.
		 */
		undo_edit: function(data) {
			return this.replace(data.after, data.before);
		},

		/**
		 * Undo a delete action.
		 * 
		 * @param   object  data  Data associated with action.
		 * 
		 * @return  object  Affected row.
		 */
		undo_delete: function(data) {
			return this.redo_add(data);
		},

		/**
		 * Redo an add action.
		 * 
		 * @param   object  data  Data associated with action.
		 * 
		 * @return  object  Affected row.
		 */
		redo_add: function(data) {
			var affected_row = -1;

			$.each(data.after, function(i, e) {
				if (e.html.match(/jsn-row-container/)) {
					$.t4p_pb_layout._addRow(
						$.t4p_pb_layout.wrapper,
						null,
						e.html,
						e.position
					);

					// Search element based on saved position
					var	row = $('#t4p_page_builder .jsn-row-container').eq(e.position.row).removeClass('active-shortcode'),
						countColumn = row.find('.jsn-column-container').length;

					// Remove junk element
					row.find('.ui-state-highlight, .ui-sortable-placeholder').remove();

					// Check if re-initialization is required
					if (countColumn) {
						$.t4p_pb_layout.initResizable(countColumn);
					}
				} else if (e.html.match(/jsn-column-container/)) {
					$.t4p_pb_layout._addColumn(
						e.html,
						null,
						e.position
					);
				} else {
					$.HandleElement.appendToHolderFinish(
						null,
						e.html,
						null,
						null,
						null,
						null,
						e.position
					);

					// Search element based on saved position
					var	row = $('#t4p_page_builder .jsn-row-container').eq(e.position.row),
						column = row.find('.jsn-column-container').eq(e.position.column),
						element = column.find('.jsn-element').eq(e.position.position).removeClass('active-shortcode');
				}

				if (affected_row < 0 || affected_row > e.position.row) {
					affected_row = e.position.row;
				}
			});

			return $('#t4p_page_builder .jsn-row-container').eq(affected_row);
		},

		/**
		 * Redo an edit action.
		 * 
		 * @param   object  data  Data associated with action.
		 * 
		 * @return  object  Affected row.
		 */
		redo_edit: function(data) {
			return this.replace(data.before, data.after);
		},

		/**
		 * Redo a delete action.
		 * 
		 * @param   object  data  Data associated with action.
		 * 
		 * @return  object  Affected row.
		 */
		redo_delete: function(data) {
			var affected_row = -1;

			$.each(data.after, function(i, e) {
				// Search element based on saved position
				var	row = $('#t4p_page_builder .jsn-row-container').eq(e.position.row),
					column = row.find('.jsn-column-container').eq(e.position.column),
					element = column.find('.jsn-element').eq(e.position.position);
	
				if (e.html.match(/jsn-row-container/)) {
					$.t4p_pb_layout._removeItem(
						$.t4p_pb_layout.wrapper,
						row.find('a.item-delete.row'),
						true
					);
				} else if (e.html.match(/jsn-column-container/)) {
					$.t4p_pb_layout._removeItem(
						$.t4p_pb_layout.wrapper,
						column.find('a.item-delete.column'),
						true
					);
				} else {
					$.HandleElement._deleteElement(
						element.find('a.element-delete'),
						true
					);
				}

				if (affected_row < 0 || affected_row > e.position.row) {
					affected_row = e.position.row;
				}
			});

			return $('#t4p_page_builder .jsn-row-container').eq(affected_row);
		},
	};

	// Schedule to init T4P Activity Log on window load event
	$(window).load(function() {
		$.t4p_activity_log.init();
	});
})(jQuery);