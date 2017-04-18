// prepend plugins.js

(function(jQuery) {
	jQuery("#sidebar_content .widget:last-child").css('margin-bottom','20px');
	jQuery(".home #sidebar_content .widget:last-child").css('margin-bottom','0px');

	jQuery(".tabs_container").each(function(){
		var $history = jQuery(this).attr('data-history');
		if($history!==undefined && $history === 'true'){
			$history = true;
		}else {
			$history = false;
		}
		var $initialIndex = jQuery(this).attr('data-initialIndex');
		if($initialIndex===undefined){
			$initialIndex = 0;
		}
		jQuery("ul.tabs",this).tabs("div.panes > div", {tabs:'a', effect: 'fade', fadeOutSpeed: -400, history: $history, initialIndex: $initialIndex});
	});
	jQuery(".mini_tabs_container").each(function(){
		var $history = jQuery(this).attr('data-history');
		if($history!==undefined && $history === 'true'){
			$history = true;
		}else {
			$history = false;
		}
		var $initialIndex = jQuery(this).attr('data-initialIndex');
		if($initialIndex===undefined){
			$initialIndex = 0;
		}
		jQuery("ul.mini_tabs",this).tabs("div.panes > div", {tabs:'a', effect: 'fade', fadeOutSpeed: -400, history: $history, initialIndex: $initialIndex});
	});
	jQuery.tools.tabs.addEffect("slide", function(i, done) {
		this.getPanes().slideUp();
		this.getPanes().eq(i).slideDown(function()  {
			done.call();
		});
	});
	jQuery(".accordion").each(function(){
		var $initialIndex = jQuery(this).attr('data-initialIndex');
		if($initialIndex===undefined){
			$initialIndex = 0;
		}
		jQuery(this).tabs("div.pane", {tabs: '.tab', effect: 'slide',initialIndex: $initialIndex});
	});
	jQuery(".toggle_title").toggle(
		function(){
			jQuery(this).addClass('toggle_active');
			jQuery(this).siblings('.toggle_content').slideDown("fast");
		},
		function(){
			jQuery(this).removeClass('toggle_active');
			jQuery(this).siblings('.toggle_content').slideUp("fast");
		}
	);
	
	jQuery(".content,#content,#sidebar,#footer").preloader({
		delay:200,
		imgSelector:'.image_styled:not(.portfolio_image) .image_frame img',
		beforeShow:function(){
			jQuery(this).closest('.image_frame').addClass('preloading');
		},
		afterShow:function(){
			var image = jQuery(this).closest('.image_frame').removeClass('preloading').children("a");
			enable_image_hover(image);
		}
	});
	jQuery(".gallery").preloader({
		delay:100,
		imgSelector:'.gallery-image',
		beforeShow:function(){},
		afterShow:function(){
			jQuery(this).hover(function(){
				jQuery(this).animate({
					opacity: '0.8'
				},"fast");
			},function(){
				jQuery(this).animate({
					opacity: '1'
				},"fast");
			});
		}
	});
	
	
	jQuery(".contact_info_wrap .icon_email").each(function(){
		jQuery(this).attr('href',jQuery(this).attr('href').replace("*", "@"));
		jQuery(this).html(jQuery(this).html().replace("*", "@"));
	});
    if(jQuery.tools.validator !== undefined){
        jQuery.tools.validator.addEffect("contact_form", function(errors, event) {
            jQuery.each(errors, function(index, error) {
                var input = error.input;
				
                input.addClass('invalid');
            });
        }, function(inputs)  {
            inputs.removeClass('invalid');
        });
        /* contact form widget */
        jQuery('.widget_contact_form .contact_form').validator({effect:'contact_form'}).submit(function(e) {
			var form = jQuery(this);
            if (!e.isDefaultPrevented()) {
                jQuery.post(this.action,{
                    'to':jQuery('input[name="contact_to"]').val().replace("*", "@"),
                    'name':jQuery('input[name="contact_name"]').val(),
                    'email':jQuery('input[name="contact_email"]').val(),
                    'content':jQuery('textarea[name="contact_content"]').val()
                },function(data){
                    form.fadeOut('fast', function() {
                         jQuery(this).siblings('p').show();
                    });
                });
				e.preventDefault();
            }
        });
        /* contact page form */
        jQuery('.contact_form_wrap .contact_form').validator({effect:'contact_form'}).submit(function(e) {
            var form = jQuery(this);
            if (!e.isDefaultPrevented()) {
                var $id = form.find('input[name="contact_widget_id"]').val();
                jQuery.post(this.action,{
                    'to':jQuery('input[name="contact_'+$id+'_to"]').val().replace("*", "@"),
                    'name':jQuery('input[name="contact_'+$id+'_name"]').val(),
                    'email':jQuery('input[name="contact_'+$id+'_email"]').val(),
                    'content':jQuery('textarea[name="contact_'+$id+'_content"]').val()
                },function(data){
                    form.fadeOut('fast', function() {
                        jQuery(this).siblings('.success').show();
                    });
                });
                e.preventDefault();
            }
        });
    }
});

(function($) {	

	$.fn.preloader = function(options) {
		var settings = $.extend({}, $.fn.preloader.defaults, options);


		return this.each(function() {
			settings.beforeShowAll.call(this);
			var imageHolder = $(this);
			
			var images = imageHolder.find(settings.imgSelector).css({opacity:0, visibility:'hidden'});	
			var count = images.length;
			var showImage = function(image,imageHolder){
				if(image.data.source !== undefined){
					imageHolder = image.data.holder;
					image = image.data.source;	
				}
				
				count --;
				if(settings.delay <= 0){
					image.css('visibility','visible').animate({opacity:1}, settings.animSpeed, function(){settings.afterShow.call(this)});
				}
				if(count === 0){
					imageHolder.removeData('count');
					if(settings.delay <= 0){
						settings.afterShowAll.call(this);
					}else{
						if(settings.gradualDelay){
							images.each(function(i,e){
								var image = $(this);
								setTimeout(function(){
									image.css('visibility','visible').animate({opacity:1}, settings.animSpeed, function(){settings.afterShow.call(this)});
								},settings.delay*(i+1));
							});
							setTimeout(function(){settings.afterShowAll.call(imageHolder[0])}, settings.delay*images.length+settings.animSpeed);
						}else{
							setTimeout(function(){
								images.each(function(i,e){
									$(this).css('visibility','visible').animate({opacity:1}, settings.animSpeed, function(){settings.afterShow.call(this)});
								});
								setTimeout(function(){settings.afterShowAll.call(imageHolder[0])}, settings.animSpeed);
							}, settings.delay);
						}
					}
				}
			};
			
			if(count===0){
				settings.afterShowAll.call(this);
			}else{
				images.each(function(i){
					settings.beforeShow.call(this);
				
					image = $(this);
				
					if(this.complete===true){
						showImage(image,imageHolder);
					}else{
						image.bind('error load',{source:image,holder:imageHolder}, showImage);
						if($.browser.opera || ($.browser.msie && parseInt(jQuery.browser.version, 10) === 9 && document.documentMode === 9) ){
							image.trigger("load");//for hidden image
						}
					}
				});
			}
		});
	};


	//Default settings
	$.fn.preloader.defaults = {
		delay:1000,
		gradualDelay:true,
		imgSelector:'img',
		animSpeed:500,
		beforeShowAll: function(){},
		beforeShow: function(){},
		afterShow: function(){},
		afterShowAll: function(){}
	};
})(jQuery);