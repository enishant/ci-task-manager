$(document).ready(function(){
	$('#username,#password').on('keyup',function(event){
		if(event.keyCode == 13) {
			$('#login_button').trigger('click');
		}
	});

	$('#login_button').click(function(){
		var submit_button = '#login_button';
		var username = $('#username').val();
		var password = $('#password').val();
		console.log(username,password);
		appjs.submitLock(submit_button);
		if(username == undefined || username == '') {
			appjs.setNotification('#login_response','error','Please enter username',2000);
			appjs.submitUnlock(submit_button);
		} else if(password == undefined || password == '') {
			appjs.setNotification('#login_response','error','Please enter password',2000);
			appjs.submitUnlock(submit_button);
		} else {
			var form_data = {
				username : username,
				password : password,
			};
			var login_callback = function(response) {
				appjs.setNotification('#login_response',response.status,response.message,5000);
				appjs.submitUnlock(submit_button);
				if(response.status == 'success') {
					window.location = base_url + 'dashboard';
				}
			}
			appjs.api_service('users/auth',form_data,'POST',login_callback);
		}
	});

});