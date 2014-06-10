(function($) {	
	function validateForm(){ alert('test');
		var err = false;
		if($('#dbprefix_old_dbprefix').val()==''){
			$('.error').val('Please enter value.');
			err = true;
		}
		if($('#dbprefix_new').val()==''){
			$('.error').val('Please enter value.');
			err = true;
		}
		if(err==true){
			return false;
		}
		else
			return true;
	}
})(jQuery);

