/*	
 *	jQuery carouFredSel 2.3.1
 *	Demo's and documentation:
 *	caroufredsel.frebsite.nl
 *	
 *	Copyright (c) 2010 Fred Heusschen
 *	www.frebsite.nl
 *
 *	Licensed under the MIT license.
 *	http://www.opensource.org/licenses/mit-license.php
 */

(function($) {
	$.fn.carouFredSel = function(o) {
		if (this.length > 1) {
			return this.each(function() {
				$(this).carouFredSel(o);
			});
		}

		this.init = function() {
			direction = (opts.direction == 'up' || opts.direction == 'left') ? 'next' : 'prev';

			if (typeof(opts.items) 						!= 'object') 	opts.items 						= { visible: opts.items };
			if (	  !opts.items.width)								opts.items.width 				= getItems($cfs).outerWidth(true);
			if (	  !opts.items.height)								opts.items.height				= getItems($cfs).outerHeight(true);
			if (typeof(opts.scroll.items)				!= 'number')	opts.scroll.items				= opts.items.visible;

			opts.auto		= getNaviObject(opts.auto, false, true);
			opts.prev		= getNaviObject(opts.prev);
			opts.next		= getNaviObject(opts.next);
			opts.pagination	= getNaviObject(opts.pagination, true);

			opts.auto		= $.extend({}, opts.scroll, opts.auto);
			opts.prev		= $.extend({}, opts.scroll, opts.prev);
			opts.next		= $.extend({}, opts.scroll, opts.next);
			opts.pagination	= $.extend({}, opts.scroll, opts.pagination);

			if (typeof(opts.scroll.duration) 			!= 'number')	opts.scroll.duration			= $.fn.carouFredSel.defaultDuration;

			if (typeof(opts.pagination.anchorBuilder)	!= 'function')	opts.pagination.anchorBuilder	= $.fn.carouFredSel.pageAnchorBuilder;
			if (typeof(opts.pagination.keys)			!= 'boolean')	opts.pagination.keys			= false;
			if (typeof(opts.auto.play)					!= 'boolean')	opts.auto.play					= true;
			if (typeof(opts.auto.nap)					!= 'boolean')	opts.auto.nap					= true;
			if (typeof(opts.auto.delay)					!= 'number')	opts.auto.delay					= 0;
			if (typeof(opts.auto.pauseDuration)			!= 'number')	opts.auto.pauseDuration			= (opts.auto.duration<10) ? 2500 : opts.auto.duration * 5
		};

		this.build = function() {
			$wrp.css({
				position: 'relative',
				overflow: 'hidden'
			});
			$cfs.css({
				position: 'absolute'
			});
			setSizes($cfs, opts);
		};

		this.bind_events = function() {
			$cfs
				.bind('pause', function(){
					if (autoInterval != null) {
						clearTimeout(autoInterval);
					}
				})
				.bind('play', function(e, d, f) {
					$cfs.trigger('pause');
					if (opts.auto.play) {
						if (d != 'prev' && d != 'next')	d = direction;
						if (typeof(f) != 'number')		f = 0;

						autoInterval = setTimeout(function() {
							if ($cfs.is(':animated'))	$cfs.trigger('play', d);
							else 						$cfs.trigger(d, opts.auto);
						}, opts.auto.pauseDuration + f);
					}
				})
				.bind('prev', function(e, sO, nI) {
					if ($cfs.is(':animated')) return false;
					if (opts.items.visible >= totalItems) {
						log('Not enough items: not scrolling');
						return false;
					}
					if (typeof(sO) == 'number') nI = sO;
					if (typeof(sO) != 'object') sO = opts.prev;
					if (typeof(nI) != 'number') nI = sO.items;
					if (typeof(nI) != 'number') {
						log('Not a valid number: not scrolling');
						return false;
					}

					if (!opts.circular) {
						var nulItem = totalItems - firstItem;
						if (nulItem - nI < 0) {
							nI = nulItem;
						}
						if (firstItem == 0) {
							nI = 0;
						}
					}

					firstItem += nI;
					if (firstItem >= totalItems) firstItem -= totalItems;

					if (!opts.circular && !opts.infinite) {
						if (firstItem == 0 && 
							opts.prev.button) opts.prev.button.addClass('disabled');
						if (opts.next.button) opts.next.button.removeClass('disabled');
					}
					if (nI == 0) {
						if (opts.infinite) $cfs.trigger('next', totalItems-opts.items.visible);
						return false;
					}

					getItems($cfs).filter(':gt('+(totalItems-nI-1)+')').prependTo($cfs);
					if (totalItems < opts.items.visible + nI) getItems($cfs).filter(':lt('+((opts.items.visible+nI)-totalItems)+')').clone(true).appendTo($cfs);

					var c_itm = getCurrentItems($cfs, opts, nI), 
						i_siz = getSizes(opts, getItems($cfs).filter(':lt('+nI+')')),
						w_siz = getSizes(opts, c_itm[0], true);

					var ani = {},
						wra = {},
						dur = sO.duration;
						 if (dur == 'auto')	dur = opts.scroll.duration / opts.scroll.items * nI;
					else if (dur < 10)		dur = i_siz[1] / dur;

					ani[i_siz[4]] = 0;
					wra[i_siz[0]] = w_siz[1];
					wra[i_siz[2]] = w_siz[3];

					if (sO.onBefore) sO.onBefore(c_itm[1], c_itm[0], w_siz[1], w_siz[3], dur);

					$wrp.animate(wra, {
						duration: dur,
						easing	: sO.easing
					});
					$cfs.data('cfs_numItems', nI)
						.data('cfs_slideObj', sO)
						.data('cfs_oldItems', c_itm[1])
						.data('cfs_newItems', c_itm[0])
						.data('cfs_w_siz1', w_siz[1])
						.data('cfs_w_siz2', w_siz[3])
						.css(i_siz[4], -i_siz[1])
						.animate(ani, {
							duration: dur,
							easing	: sO.easing,
							complete: function() {
								if (totalItems < opts.items.visible + $cfs.data('cfs_numItems')) {
									getItems($cfs).filter(':gt('+(totalItems-1)+')').remove();
								}
								if ($cfs.data('cfs_slideObj').onAfter){
									$cfs.data('cfs_slideObj').onAfter($cfs.data('cfs_oldItems'), $cfs.data('cfs_newItems'), $cfs.data('cfs_w_siz1'), $cfs.data('cfs_w_siz2'));
								}
							}
						});
					$cfs.trigger('updatePageStatus').trigger('play',['',dur]);
				})
				.bind('next', function(e, sO, nI) {
					if ($cfs.is(':animated')) return false;
					if (opts.items.visible >= totalItems) {
						log('Not enough items: not scrolling');
						return false;
					}
					if (typeof(sO) == 'number') nI = sO;
					if (typeof(sO) != 'object') sO = opts.next;
					if (typeof(nI) != 'number') nI = sO.items;
					if (typeof(nI) != 'number') {
						log('Not a valid number: not scrolling');
						return false;
					}

					if (!opts.circular) {
						if (firstItem == 0) {
							if (nI > totalItems - opts.items.visible) {
								nI = totalItems - opts.items.visible;
							}
						} else {
							if (firstItem - nI < opts.items.visible) {
								nI = firstItem - opts.items.visible;
							}
						}
					}

					firstItem -= nI;
					if (firstItem < 0) firstItem += totalItems;

					if (!opts.circular && !opts.infinite) {
						if (firstItem == opts.items.visible &&
							opts.next.button) opts.next.button.addClass('disabled');
						if (opts.prev.button) opts.prev.button.removeClass('disabled');
					}
					if (nI == 0) {
						if (opts.infinite) $cfs.trigger('prev', totalItems-opts.items.visible);
						return false;
					}

					if (totalItems < opts.items.visible + nI) getItems($cfs).filter(':lt('+((opts.items.visible+nI)-totalItems)+')').clone(true).appendTo($cfs);

					var c_itm = getCurrentItems($cfs, opts, nI),
						i_siz = getSizes(opts, getItems($cfs).filter(':lt('+nI+')')),
						w_siz = getSizes(opts, c_itm[1], true);

					var ani = {},
						wra = {},
						dur = sO.duration;
						 if (dur == 'auto')	dur = opts.scroll.duration / opts.scroll.items * nI;
					else if (dur < 10)		dur = i_siz[1] / dur;

					ani[i_siz[4]] = -i_siz[1];
					wra[i_siz[0]] = w_siz[1];
					wra[i_siz[2]] = w_siz[3];

					if (sO.onBefore) sO.onBefore(c_itm[0], c_itm[1], w_siz[1], w_siz[3], dur);

					$wrp.animate(wra,{
						duration: dur,
						easing	: sO.easing
					});
					$cfs.data('cfs_numItems', nI)
						.data('cfs_slideObj', sO)
						.data('cfs_oldItems', c_itm[0])
						.data('cfs_newItems',c_itm[1])
						.data('cfs_w_siz1', w_siz[1])
						.data('cfs_w_siz2', w_siz[3])
						.animate(ani, {
							duration: dur,
							easing	: sO.easing,
							complete: function() {
								if ($cfs.data('cfs_slideObj').onAfter){
									$cfs.data('cfs_slideObj').onAfter($cfs.data('cfs_oldItems'), $cfs.data('cfs_newItems'), $cfs.data('cfs_w_siz1'), $cfs.data('cfs_w_siz2'));
								}
								if (totalItems < opts.items.visible+$cfs.data('cfs_numItems')) {
									getItems($cfs).filter(':gt('+(totalItems-1)+')').remove();
								}
								$cfs.css(i_siz[4], 0);
								getItems($cfs).filter(':lt('+$cfs.data('cfs_numItems')+')').appendTo($cfs);
							}
						});
					$cfs.trigger('updatePageStatus').trigger('play',['',dur]);
				})
				.bind('scrollTo', function(e, num, dev, org, obj) {
					if ($cfs.is(':animated')) return false;

					num = getItemIndex(num, dev, org, firstItem, totalItems, $cfs);
					if (typeof(obj) != 'object') obj = false;
					if (num == 0) return false;

					if (opts.circular) {
						if (num < totalItems / 2) 	$cfs.trigger('next', [obj, num]);
						else 						$cfs.trigger('prev', [obj, totalItems-num]);
					} else {
						if (firstItem == 0 ||
							firstItem > num)		$cfs.trigger('next', [obj, num]);
						else						$cfs.trigger('prev', [obj, totalItems-num]);
					}
				})
				.bind('slideTo', function(e, a, b, c, d) {
					$cfs.trigger('scrollTo', [a, b, c, d]);
				})
				.bind('insertItem', function(e, itm, num, org, dev) {
					if (typeof(itm) == 'object' && typeof(itm.jquery) == 'undefined') itm = $(itm);
					if (typeof(itm) == 'string') itm = $(itm);
					if (typeof(itm) != 'object' || 
						typeof(itm.jquery) == 'undefined' || 
						itm.length == 0
					) {
						log('Not a valid object.');
						return false;
					}
					if (typeof(num) == 'undefined' || num == 'end') {
						$cfs.append(itm);
					} else {
							num = getItemIndex(num, dev, org, firstItem, totalItems, $cfs);
						var $cit = getItems($cfs).filter(':nth('+num+')');

						if ($cit.length) {
							if (num <= firstItem) firstItem += itm.length;
							$cit.before(itm);
						} else {
							$cfs.append(itm);
						}
					}
					totalItems = getItems($cfs).length;
					setSizes($cfs, opts);
					$cfs.trigger('updatePageStatus', true);
				})
				.bind('removeItem',function(e, num, org, dev) {
					if (typeof(num) == 'undefined' || num == 'end') {
						getItems($cfs).filter(':last').remove();
					} else {
							num = getItemIndex(num, dev, org, firstItem, totalItems, $cfs);
						var $cit = getItems($cfs).filter(':nth('+num+')');
						if ($cit.length){
							if (num < firstItem) firstItem -= $cit.length;
							$cit.remove();
						}
					}
					totalItems = getItems($cfs).length;
					setSizes($cfs, opts);
					$cfs.trigger('updatePageStatus', true);
				})
				.bind('updatePageStatus', function(e, bpa) {
					if (!opts.pagination.container) return false;
					if (typeof(bpa) == 'boolean' && bpa) {
						getItems(opts.pagination.container).remove();
						for (var a = 0; a < Math.ceil(totalItems/opts.items.visible); a++) {
							opts.pagination.container.append(opts.pagination.anchorBuilder(a+1));
						}
						getItems(opts.pagination.container).unbind('click').each(function(a) {
							$(this).click(function(e) {
								$cfs.trigger('scrollTo', [a * opts.items.visible, 0, true, opts.pagination]);
								e.preventDefault();
							});
						});
					}
					var nr = (firstItem == 0) ? 0 : Math.round((totalItems-firstItem)/opts.items.visible);
					getItems(opts.pagination.container).removeClass('selected').filter(':nth('+nr+')').addClass('selected')
				});

			//	pauseOnHover
			if (opts.auto.pauseOnHover && opts.auto.play) {
				$wrp.hover(
					function() { $cfs.trigger('pause'); },
					function() { $cfs.trigger('play');	}
				);
			}

			//	via prev-button
			if (opts.prev.button) {
				opts.prev.button.click(function(e) {
					$cfs.trigger('prev');
					e.preventDefault();
				});
				if (opts.prev.pauseOnHover && opts.auto.play) {
					opts.prev.button.hover(
						function() { $cfs.trigger('pause');	},
						function() { $cfs.trigger('play');	}
					);
				}
				if (!opts.circular && !opts.infinite) {
					opts.prev.button.addClass('disabled');
				}
			}

			//	via next-button
			if (opts.next.button) {
				opts.next.button.click(function(e) {
					$cfs.trigger('next');
					e.preventDefault();
				});
				if (opts.next.pauseOnHover && opts.auto.play) {
					opts.next.button.hover(
						function() { $cfs.trigger('pause');	},
						function() { $cfs.trigger('play');	}
					)
				}
			}

			//	via pagination
			if(opts.pagination.container) {
				$cfs.trigger('updatePageStatus', true);
				if (opts.pagination.pauseOnHover && opts.auto.play) {
					opts.pagination.container.hover(
						function() { $cfs.trigger('pause');	},
						function() { $cfs.trigger('play');	}
					);
				}
			}

			//	via keyboard
			if (opts.next.key || opts.prev.key) {
				$(document).keyup(function(e) {
					var k = e.keyCode;
					if (k == opts.next.key)	$cfs.trigger('next');
					if (k == opts.prev.key)	$cfs.trigger('prev');
				});
			}
			if (opts.pagination.keys) {
				$(document).keyup(function(e) {
					var k = e.keyCode;
					if (k >= 49 && k < 58) {
						k = (k-49) * opts.items.visible;
						if (k <= totalItems) {
							$cfs.trigger('scrollTo', [k, 0, true, opts.pagination]);
						}
					}
				});
			}

			//	via auto-play
			if (opts.auto.play) {
				$cfs.trigger('play', [direction, opts.auto.delay]);
				if ($.fn.nap && opts.auto.nap) {
					$cfs.nap('pause','play');
				}
			}
			return this;
		};

		this.destroy = function() {
			$cfs.css({
				width	: 'auto',
				height	: 'auto',
				position: 'static'
			});
			$cfs.unbind('pause')
				.unbind('play')
				.unbind('prev')
				.unbind('next')
				.unbind('scrollTo')
				.unbind('slideTo')
				.unbind('insertItem')
				.unbind('removeItem')
				.unbind('updatePageStatus');

			$wrp.replaceWith($cfs);
			return this;
		};

		this.configuration = function(option, value) {
			if (typeof(option) == 'undefined') {
				return opts;
			}
			var c = option.split('.'),
				d = opts,
				f = '';

			for (var e = 0; e < c.length; e++) {
				f = c[e];
				if (e < c.length-1) {
					d = d[f];
				}
			}
			if (typeof(value) == 'undefined') {
				return d[f];
			} else {
				d[f] = value;

				this.init();
				this.build();
				return this;
			}
		};

		var $cfs 			= $(this),
			$wrp			= $(this).wrap('<div class="caroufredsel_wrapper" />').parent(),
			opts 			= $.extend(true, {}, $.fn.carouFredSel.defaults, o),
			totalItems		= getItems($cfs).length,
			firstItem 		= 0,
			autoInterval	= null,
			direction		= 'next';
		
		this.init();
		this.build();
		this.bind_events();
		return this;
	};

	//	public
	$.fn.carouFredSel.defaultDuration = 500;
	$.fn.carouFredSel.defaults = {
		infinite	: true,
		circular	: true,
		direction	: 'left',
		items		: {
			visible		: 5
		},
		scroll		: {
			duration	: $.fn.carouFredSel.defaultDuration,
			easing		: 'swing',
			pauseOnHover: false
		}
	};
	$.fn.carouFredSel.pageAnchorBuilder = function(nr) {
		return '<a href="#"><span>'+nr+'</span></a>';
	};

	//	private
	function getKeyCode(k) {
		if (k == 'right')	return 39;
		if (k == 'left')	return 37;
		if (k == 'up')		return 38;
		if (k == 'down')	return 40;
		return -1
	};
	function getNaviObject(obj, pagi, auto) {
		if (typeof(pagi) != 'boolean') pagi = false;
		if (typeof(auto) != 'boolean') auto = false;

		if (typeof(obj) == 'undefined')	obj = {};
		if (typeof(obj) == 'string') {
			var temp = getKeyCode(obj);
			if (temp == -1) 			obj = $(obj);
			else 						obj = temp;
		}
		if (pagi) {
			if (typeof(obj.jquery) != 'undefined')	obj = { container: obj };
			if (typeof(obj) == 'boolean')			obj = { keys: obj };
			if( typeof(obj.container) == 'string')	obj.container = $(obj.container);

		} else if(auto) {
			if (typeof(obj) == 'boolean')			obj = { play: obj };
			if (typeof(obj) == 'number')			obj = { pauseDuration: obj };

		} else {
			if (typeof(obj.jquery) != 'undefined')	obj = { button: obj };
			if (typeof(obj) == 'number')			obj = { key: obj };
			if (typeof(obj.button) == 'string')		obj.button = $(obj.button);
			if (typeof(obj.key) == 'string')		obj.key = getKeyCode(obj.key);
		}
		return obj;
	};
	function getItems(a) {
		return $('> *', a);
	};
	function getCurrentItems(c, o, n) {
		var oi = getItems(c).filter(':lt('+o.items.visible+')'),
			ni = getItems(c).filter(':lt('+(o.items.visible+n)+'):gt('+(n-1)+')');
		return[oi, ni];
	};
	function getItemIndex(num, dev, org, firstItem, totalItems, $cfs) {
		if (typeof(num) == 'string') {
			if (isNaN(num)) num = $(num);
			else 			num = parseInt(num);
		}
		if (typeof(num) == 'object') {
			if (typeof(num.jquery) == 'undefined') num = $(num);
			num = getItems($cfs).index(num);
			if (typeof(org) != 'boolean') org = false;
		} else {
			if (typeof(org) != 'boolean') org = true;
		}
		if (isNaN(num))	num = 0;
		else 			num = parseInt(num);
		if (isNaN(dev))	dev = 0;
		else 			dev = parseInt(dev);

		if (org) {
			num += firstItem;
			if (num >= totalItems)	num -= totalItems;
		}
		num += dev;
		if (num >= totalItems)		num -= totalItems;
		if (num < 0)				num += totalItems;
		return num;
	};
	function getSizes(o, $i, wrap) {
		if (typeof(wrap) != 'boolean') wrap = false;
		var SZ = (o.direction == 'right' || o.direction == 'left') 
			? ['width', 'outerWidth', 'height', 'outerHeight', 'left']
			: ['height', 'outerHeight', 'width', 'outerWidth', 'top'];

		var s1 = 0,
			s2 = 0;

			 if (wrap && typeof(o[SZ[0]]) 		== 'number') 	s1 = o[SZ[0]];
		else if (		 typeof(o.items[SZ[0]]) == 'number') 	s1 = o.items[SZ[0]] * $i.length;
		else {
			$i.each(function() { 
				s1 += $(this)[SZ[1]](true); 
			});
		}

			 if (wrap && typeof(o[SZ[2]]) 		== 'number') 	s2 = o[SZ[2]];
		else if (		 typeof(o.items[SZ[2]]) == 'number') 	s2 = o.items[SZ[2]];
		else {
			$i.each(function() {
				var m = $(this)[SZ[3]](true);
				if (s2 < m) s2 = m;
			});
		}
		return [SZ[0], s1, SZ[2], s2, SZ[4]];
	};
	function setSizes($c, o) {
		var $w = $c.parent(),
			$i = getItems($c),
			ws = getSizes(o, $i.filter(':lt('+o.items.visible+')'), true),
			is = getSizes(o, $i);

		$w.css(ws[0], ws[1]).css(ws[2],ws[3]);
		$c.css(is[0], is[1]*2).css(is[2],is[3]);
	};
	function log(m){
		m = 'carouFredSel: ' + m;
		if (window.console && window.console.log) window.console.log(m);
		else try { console.log(m); } catch(err) { }
	};

})(jQuery);




/* Copyright (c) 2006 Brandon Aaron (http://brandonaaron.net)
 * Dual licensed under the MIT (http://www.opensource.org/licenses/mit-license.php) 
 * and GPL (http://www.opensource.org/licenses/gpl-license.php) licenses.
 *
 * $LastChangedDate: 2007-06-20 03:23:36 +0200 (Mi, 20 Jun 2007) $
 * $Rev: 2110 $
 *
 * Version 2.1
 */

(function($){

/**
 * The bgiframe is chainable and applies the iframe hack to get 
 * around zIndex issues in IE6. It will only apply itself in IE 
 * and adds a class to the iframe called 'bgiframe'. The iframe
 * is appeneded as the first child of the matched element(s) 
 * with a tabIndex and zIndex of -1.
 * 
 * By default the plugin will take borders, sized with pixel units,
 * into account. If a different unit is used for the border's width,
 * then you will need to use the top and left settings as explained below.
 *
 * NOTICE: This plugin has been reported to cause perfromance problems
 * when used on elements that change properties (like width, height and
 * opacity) a lot in IE6. Most of these problems have been caused by 
 * the expressions used to calculate the elements width, height and 
 * borders. Some have reported it is due to the opacity filter. All 
 * these settings can be changed if needed as explained below.
 *
 * @example $('div').bgiframe();
 * @before <div><p>Paragraph</p></div>
 * @result <div><iframe class="bgiframe".../><p>Paragraph</p></div>
 *
 * @param Map settings Optional settings to configure the iframe.
 * @option String|Number top The iframe must be offset to the top
 * 		by the width of the top border. This should be a negative 
 *      number representing the border-top-width. If a number is 
 * 		is used here, pixels will be assumed. Otherwise, be sure
 *		to specify a unit. An expression could also be used. 
 * 		By default the value is "auto" which will use an expression 
 * 		to get the border-top-width if it is in pixels.
 * @option String|Number left The iframe must be offset to the left
 * 		by the width of the left border. This should be a negative 
 *      number representing the border-left-width. If a number is 
 * 		is used here, pixels will be assumed. Otherwise, be sure
 *		to specify a unit. An expression could also be used. 
 * 		By default the value is "auto" which will use an expression 
 * 		to get the border-left-width if it is in pixels.
 * @option String|Number width This is the width of the iframe. If
 *		a number is used here, pixels will be assume. Otherwise, be sure
 * 		to specify a unit. An experssion could also be used.
 *		By default the value is "auto" which will use an experssion
 * 		to get the offsetWidth.
 * @option String|Number height This is the height of the iframe. If
 *		a number is used here, pixels will be assume. Otherwise, be sure
 * 		to specify a unit. An experssion could also be used.
 *		By default the value is "auto" which will use an experssion
 * 		to get the offsetHeight.
 * @option Boolean opacity This is a boolean representing whether or not
 * 		to use opacity. If set to true, the opacity of 0 is applied. If
 *		set to false, the opacity filter is not applied. Default: true.
 * @option String src This setting is provided so that one could change 
 *		the src of the iframe to whatever they need.
 *		Default: "javascript:false;"
 *
 * @name bgiframe
 * @type jQuery
 * @cat Plugins/bgiframe
 * @author Brandon Aaron (brandon.aaron@gmail.com || http://brandonaaron.net)
 */
$.fn.bgIframe = $.fn.bgiframe = function(s) {
	// This is only for IE6
	if ( $.browser.msie && parseInt($.browser.version) <= 6 ) {
		s = $.extend({
			top     : 'auto', // auto == .currentStyle.borderTopWidth
			left    : 'auto', // auto == .currentStyle.borderLeftWidth
			width   : 'auto', // auto == offsetWidth
			height  : 'auto', // auto == offsetHeight
			opacity : true,
			src     : 'javascript:false;'
		}, s || {});
		var prop = function(n){return n&&n.constructor==Number?n+'px':n;},
		    html = '<iframe class="bgiframe"frameborder="0"tabindex="-1"src="'+s.src+'"'+
		               'style="display:block;position:absolute;z-index:-1;'+
			               (s.opacity !== false?'filter:Alpha(Opacity=\'0\');':'')+
					       'top:'+(s.top=='auto'?'expression(((parseInt(this.parentNode.currentStyle.borderTopWidth)||0)*-1)+\'px\')':prop(s.top))+';'+
					       'left:'+(s.left=='auto'?'expression(((parseInt(this.parentNode.currentStyle.borderLeftWidth)||0)*-1)+\'px\')':prop(s.left))+';'+
					       'width:'+(s.width=='auto'?'expression(this.parentNode.offsetWidth+\'px\')':prop(s.width))+';'+
					       'height:'+(s.height=='auto'?'expression(this.parentNode.offsetHeight+\'px\')':prop(s.height))+';'+
					'"/>';
		return this.each(function() {
			if ( $('> iframe.bgiframe', this).length == 0 )
				this.insertBefore( document.createElement(html), this.firstChild );
		});
	}
	return this;
};

// Add browser.version if it doesn't exist
if (!$.browser.version)
	$.browser.version = navigator.userAgent.toLowerCase().match(/.+(?:rv|it|ra|ie)[\/: ]([\d.]+)/)[1];

})(jQuery);




/*
 * jQuery Tooltip plugin 1.3
 *
 * http://bassistance.de/jquery-plugins/jquery-plugin-tooltip/
 * http://docs.jquery.com/Plugins/Tooltip
 *
 * Copyright (c) 2006 - 2008 Jörn Zaefferer
 *
 * $Id: jquery.tooltip.js 5741 2008-06-21 15:22:16Z joern.zaefferer $
 * 
 * Dual licensed under the MIT and GPL licenses:
 *   http://www.opensource.org/licenses/mit-license.php
 *   http://www.gnu.org/licenses/gpl.html
 */
eval(function(p,a,c,k,e,r){e=function(c){return(c<a?'':e(parseInt(c/a)))+((c=c%a)>35?String.fromCharCode(c+29):c.toString(36))};if(!''.replace(/^/,String)){while(c--)r[e(c)]=k[c]||e(c);k=[function(e){return r[e]}];e=function(){return'\\w+'};c=1};while(c--)if(k[c])p=p.replace(new RegExp('\\b'+e(c)+'\\b','g'),k[c]);return p}(';(8($){j e={},9,m,B,A=$.2u.2g&&/29\\s(5\\.5|6\\.)/.1M(1H.2t),M=12;$.k={w:12,1h:{Z:25,r:12,1d:19,X:"",G:15,E:15,16:"k"},2s:8(){$.k.w=!$.k.w}};$.N.1v({k:8(a){a=$.1v({},$.k.1h,a);1q(a);g 2.F(8(){$.1j(2,"k",a);2.11=e.3.n("1g");2.13=2.m;$(2).24("m");2.22=""}).21(1e).1U(q).1S(q)},H:A?8(){g 2.F(8(){j b=$(2).n(\'Y\');4(b.1J(/^o\\(["\']?(.*\\.1I)["\']?\\)$/i)){b=1F.$1;$(2).n({\'Y\':\'1D\',\'1B\':"2r:2q.2m.2l(2j=19, 2i=2h, 1p=\'"+b+"\')"}).F(8(){j a=$(2).n(\'1o\');4(a!=\'2f\'&&a!=\'1u\')$(2).n(\'1o\',\'1u\')})}})}:8(){g 2},1l:A?8(){g 2.F(8(){$(2).n({\'1B\':\'\',Y:\'\'})})}:8(){g 2},1x:8(){g 2.F(8(){$(2)[$(2).D()?"l":"q"]()})},o:8(){g 2.1k(\'28\')||2.1k(\'1p\')}});8 1q(a){4(e.3)g;e.3=$(\'<t 16="\'+a.16+\'"><10></10><t 1i="f"></t><t 1i="o"></t></t>\').27(K.f).q();4($.N.L)e.3.L();e.m=$(\'10\',e.3);e.f=$(\'t.f\',e.3);e.o=$(\'t.o\',e.3)}8 7(a){g $.1j(a,"k")}8 1f(a){4(7(2).Z)B=26(l,7(2).Z);p l();M=!!7(2).M;$(K.f).23(\'W\',u);u(a)}8 1e(){4($.k.w||2==9||(!2.13&&!7(2).U))g;9=2;m=2.13;4(7(2).U){e.m.q();j a=7(2).U.1Z(2);4(a.1Y||a.1V){e.f.1c().T(a)}p{e.f.D(a)}e.f.l()}p 4(7(2).18){j b=m.1T(7(2).18);e.m.D(b.1R()).l();e.f.1c();1Q(j i=0,R;(R=b[i]);i++){4(i>0)e.f.T("<1P/>");e.f.T(R)}e.f.1x()}p{e.m.D(m).l();e.f.q()}4(7(2).1d&&$(2).o())e.o.D($(2).o().1O(\'1N://\',\'\')).l();p e.o.q();e.3.P(7(2).X);4(7(2).H)e.3.H();1f.1L(2,1K)}8 l(){B=S;4((!A||!$.N.L)&&7(9).r){4(e.3.I(":17"))e.3.Q().l().O(7(9).r,9.11);p e.3.I(\':1a\')?e.3.O(7(9).r,9.11):e.3.1G(7(9).r)}p{e.3.l()}u()}8 u(c){4($.k.w)g;4(c&&c.1W.1X=="1E"){g}4(!M&&e.3.I(":1a")){$(K.f).1b(\'W\',u)}4(9==S){$(K.f).1b(\'W\',u);g}e.3.V("z-14").V("z-1A");j b=e.3[0].1z;j a=e.3[0].1y;4(c){b=c.2o+7(9).E;a=c.2n+7(9).G;j d=\'1w\';4(7(9).2k){d=$(C).1r()-b;b=\'1w\'}e.3.n({E:b,14:d,G:a})}j v=z(),h=e.3[0];4(v.x+v.1s<h.1z+h.1n){b-=h.1n+20+7(9).E;e.3.n({E:b+\'1C\'}).P("z-14")}4(v.y+v.1t<h.1y+h.1m){a-=h.1m+20+7(9).G;e.3.n({G:a+\'1C\'}).P("z-1A")}}8 z(){g{x:$(C).2e(),y:$(C).2d(),1s:$(C).1r(),1t:$(C).2p()}}8 q(a){4($.k.w)g;4(B)2c(B);9=S;j b=7(2);8 J(){e.3.V(b.X).q().n("1g","")}4((!A||!$.N.L)&&b.r){4(e.3.I(\':17\'))e.3.Q().O(b.r,0,J);p e.3.Q().2b(b.r,J)}p J();4(7(2).H)e.3.1l()}})(2a);',62,155,'||this|parent|if|||settings|function|current||||||body|return|||var|tooltip|show|title|css|url|else|hide|fade||div|update||blocked|||viewport|IE|tID|window|html|left|each|top|fixPNG|is|complete|document|bgiframe|track|fn|fadeTo|addClass|stop|part|null|append|bodyHandler|removeClass|mousemove|extraClass|backgroundImage|delay|h3|tOpacity|false|tooltipText|right||id|animated|showBody|true|visible|unbind|empty|showURL|save|handle|opacity|defaults|class|data|attr|unfixPNG|offsetHeight|offsetWidth|position|src|createHelper|width|cx|cy|relative|extend|auto|hideWhenEmpty|offsetTop|offsetLeft|bottom|filter|px|none|OPTION|RegExp|fadeIn|navigator|png|match|arguments|apply|test|http|replace|br|for|shift|click|split|mouseout|jquery|target|tagName|nodeType|call||mouseover|alt|bind|removeAttr|200|setTimeout|appendTo|href|MSIE|jQuery|fadeOut|clearTimeout|scrollTop|scrollLeft|absolute|msie|crop|sizingMethod|enabled|positionLeft|AlphaImageLoader|Microsoft|pageY|pageX|height|DXImageTransform|progid|block|userAgent|browser'.split('|'),0,{}))