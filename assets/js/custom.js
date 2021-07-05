var appjs = {
	api_service: function(request,data,method,callBack) {
	  return $.ajax({
	    method: method,
	    url: api_url + "/" + request,
	    data: data,
	    success: callBack,
	    complete: this.api_service_always
	  });
	},
	api_service_always: function (response) {
		if(response != undefined && response.responseJSON != undefined && response.responseJSON.status != undefined  && response.responseJSON.message != undefined && response.responseJSON.status == 'error' && response.responseJSON.message == 'Unauthorised Access') {
			window.location = base_url;
		}
	},
	setNotification: function (element,status,message,timeout) {
		if(timeout == undefined || timeout == '') {
			timeout = 5000;
		}
		if($(element).length > 0) {
			if(message != undefined && message != '') {
				var notification_class;
				if(status != undefined && status == 'success') {
					notification_class = 'alert alert-success';
				} else {
					notification_class = 'alert alert-danger';
				}
				$(element).removeClass('alert').removeClass('white-text').removeClass('alert-danger').removeClass('alert-success');
				$(element).addClass(notification_class);
				$(element).html(message);
				$(element).slideDown(300);
				$([document.documentElement, document.body]).animate({
					scrollTop: $(element).offset().top - 100
				}, 500);
				setTimeout(function(){
					$(element).slideUp(300);
				},timeout);
			}
		}
	},
	submitLock: function(element) {
		if($(element).length > 0) {
			$(element).attr('disabled',true);
			$(element).css('pointer-events','none');
		}
	},
	submitUnlock: function(element,timeout) {
		if(timeout == undefined || timeout == '') {
			timeout = 5000;
		}
		if($(element).length > 0) {
			setTimeout(function(){
				$(element).attr('disabled',false);
				$(element).css('pointer-events','auto');
			},timeout);
		}
	}
};
