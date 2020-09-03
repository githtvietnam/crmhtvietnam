(function($) {
	"use strict";
    var HT = {};

    var time = 100;
	/* MAIN VARIABLE */

    var $window            		= $(window),
		$document           	= $(document),
		saveCustomer        	= $(".saveCustomer");

	// Check if element exists
    $.fn.elExists = function() {
        return this.length > 0;
    };


    HT.addCustomer = () => {
 	 	if(saveCustomer.elExists){
 	 		$(saveCustomer).on('click', function(){
 	 			let fullname = $('input[name=fullname]').val()
 	 			let phone = $('input[name=phone]').val()
 	 			let email = $('input[name=email]').val()
 	 			let catalogueid = $('select[name=catalogueid]').val()
 	 			let email_original = $('input[name=email_original]').val()
 	 			let phone_original = $('input[name=phone_original]').val()
 	 			let id = $('input[name=id]').val()

 	 			let param = {
 	 				'address' : $('input[name=address]').val(),
 	 				'cityid' : $('select[name=cityid]').val(),
 	 				'birthday' : $('input[name=birthday]').val(),
 	 				'gender' : $('select[name=gender]').val(),
 	 				'company' : $('input[name=company]').val(),
 	 				'company_mst' : $('input[name=company_mst]').val(),
 	 				'company_address' : $('input[name=company_address]').val(),
 	 				'code': $('input[name=code]').val()
 	 			}

 	 			var formURL = 'ajax/customer/save';

				$('#customer-store .ibox-content').addClass('sk-loading');

				$.post(formURL, {
					post: param,fullname: fullname, phone: phone, email: email, catalogueid: catalogueid, email_original: email_original, phone_original: phone_original, id: id},
					function(data){
						$('#customer-store .ibox-content').removeClass('sk-loading');
						let response = JSON.parse(data);
						if(response.code == 10){
							toastr.success(response.message);
							$('.response-message').html('').hide();
							if(id == 0){
								$('#customer-store input').val('');
								$('#customer-store select').val(0);
							}
							if(id > 0){
								$('input[name=phone_original]').val(response.phone)
								$('input[name=email_original]').val(response.email)
							}

						}else{
							if(response.code == 22){
								$('.response-message').html('<div class="alert alert-danger">'+response.message+'</div>').show();
								toastr.error('Có lỗi xảy ra! Vui lòng thử lại');
							}else{
								toastr.error(response.message);
							}
						}


					});
 	 			return false;
 	 		});

 	 	}
    };

    $(document).ready(function() {
    	HT.addCustomer();

    });

})(jQuery);
