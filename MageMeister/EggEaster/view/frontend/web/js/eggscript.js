/**
 * MageMeister Inc.
 *
 * NOTICE OF LICENSE
 *
 * <!--LICENSETEXT-->
 *
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade Magento to newer
 * versions in the future. If you wish to customize Magento for your
 * needs please refer to http://magemeister.com for more information.
 *
 * @category    MageMeister
 * @package     MageMeister_EggEaster
 * @copyright   Copyright (c) 2013-2018 MageMeister Inc. (http://magemeister.com)
 * @author      Virang Jethva <virang.jethva@magemeister.com>
 * @info        MageMeister Inc. <hello@magemeister.com>
 */

define([
	"jquery",
	'jquery/jquery.cookie',
	"Magento_Ui/js/modal/modal",
	"prototype",
	"jquery/ui"
], function ($, $cookie,modal, prototype) {
	'use strict';
	$.widget('mage.eggJS', {
		options: {
			siteurl: '',
			succes_url: '',
			eggs: '',
			total_eggs: ''
		},
		_create: function() {
			this.cookieName = 'mm_ee';
			this.eggs = this.options.eggs;
			this.totalEggs = this.options.total_eggs;
			this.succesAction = 'redirect';
			this.succesURL = this.options.succes_url;
			this.foundEggs = [];
			this.pageEggs = [];
			this.foundEggs = this.getFoundEggs(); 	// get list of found ids from cookie
			this.pageEggs  = this.getPageEggs(); 	// get list of eggs on page
			this.hideFoundEggs(); 					// css hide found eggs on page


			// bind egg clicks
			$('span.eeh_egg').bind('click', {self:this}, this.eggClick);
			var options = {
				type: 'popup',
				responsive: true,
				innerScroll: true,
				title: 'Congratulations !!',
				buttons: [{
					text: $.mage.__('Close'),
					class: '',
					click: function () {
						this.closeModal();
					}
				}]
			};
			var popup = modal(options, $('#popup-modal'));
		},
		getFoundEggs: function() {
			var cookieData = $.cookie(this.cookieName);
			if(typeof cookieData != 'undefined' && cookieData != null) {
				// cookie found	
				return JSON.parse(cookieData).found_eggs;
			} else {
				// 'no cookie found, resetting cookie';
				return [];
			}
		},
		foundEgg: function(egg_id) {
			var eggs = this.options.eggs;
			// remove the egg
			$('#' + egg_id).remove();
			// add to egg list
			this.foundEggs.push(egg_id);
			// update cookie
			var cookieData = JSON.stringify({"found_eggs": this.foundEggs});
			$.cookie(this.cookieName, cookieData, {path: '/' });
			// message user
			var messageElement = $("<div><div class='eeh_found_eggs'></div></div>");
			$.each(this.foundEggs, function(index, value) {
				value = value.replace("eeh_egg_", "");
				messageElement.find('.eeh_found_eggs').append("<span class='eeh_egg'><img src='"+ eggs[value] +"' /></span>");	
			});
			// check for succes
			$("#popup-modal").html('');
			var successUrl = this.succesURL;
			if(this.foundEggs.length >= this.totalEggs) {
				// all eggs found!
				$("#popup-modal").html('');
				$("#popup-modal").html('<p>Congratulations, You have found all eggs</p>');
				$('#popup-modal').modal('openModal').on('modalclosed', function() {
				  	window.location.href = successUrl; 
				});
			} else {
				$("#popup-modal").html('<p>You have found '+this.foundEggs.length+' out of '+this.totalEggs+' eggs. Find them all to see the prize page.</p>');			
			}
			$("#popup-modal").modal("openModal");
		},
		hideFoundEggs: function() {
			$.each(this.foundEggs, function( index, value ) {
				$('#' + value).remove();
			});
		},
		resetCookie: function() {
			var cookieData = JSON.stringify({"found_eggs": []});
			$.cookie(this.cookieName, cookieData, {path: '/' });
			return cookieData;
		},
		getPageEggs: function() {
			var eggs = [];
			$('div.eeh_egg').each(function(){
				eggs.push(this.id); 
			});
			return eggs;
		},
		eggClick: function(event) {
			var self = event.data.self;
			self.foundEgg(this.id);
		}
	});
	return $.mage.eggJS;
});