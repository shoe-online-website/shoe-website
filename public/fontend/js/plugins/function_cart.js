function checkPhoneVN(input) {
	var vnf_regex = /((09|03|07|08|05)+([0-9]{8})\b)/g;
    if(input!==''){
        if (vnf_regex.test(input) == false) {
           console.log('Số điện thoại của bạn không đúng định dạng!');
			return false
        }else{
           console.log('Số điện thoại của bạn hợp lệ!');
			return true;
        }
    }else{
        console.log('Bạn chưa điền số điện thoại!');
		return false
	}
}
/****************XMLHttpRequest******************/
function search_input(div_input, method, modulePage, divWrite, timer = 250) {
    var btndf = jQuery(div_input).next().html();
    jQuery(div_input).keyup(function(e) {
        if (jQuery(this).val().length > 1) {
            jQuery(divWrite).html('<div class="text-center"><i class="fal fa-circle-notch fa-spin"></i> Loading...</div>');
            jQuery(div_input).next().html('<i class="fal fa-circle-notch fa-spin"></i>');
            var divval = $(this);
            clearTimeout($.data(this, 'timer'));
            if (e.keyCode == 13) {
                searh(divval, method, modulePage, divWrite);
                jQuery(div_input).next().html(btndf);
            } else {
                $(this).data('timer', setTimeout(function() {
                    searh(divval, method, modulePage, divWrite);
                    jQuery(div_input).next().html(btndf);
                }, timer));
            }
        } else {
            setTimeout(function() {
                jQuery(divWrite).hide();
            }, timer);
        }
    });
}
//AJAX Funtion Search
function searh(id,method,modulePage,divWrite){	
		jQuery.ajax({
			type: method,
			url: modulePage, 
			dataType:"text",
			//Dữ liệu ajax tuyền đi
			data : {
				 id : jQuery(id).val()
			},
			success: function(data){
				var datajson = $.parseJSON(data);

					if(jQuery(id).val().length==0){
						jQuery(divWrite).fadeOut();
					}
					if(datajson.data != ''){
						jQuery(divWrite).fadeIn();
					}
					jQuery(divWrite).html(datajson.data);
				
			}
		});
}
/**********************************/
var colorButtom = "#2879fe";
var flag = true;
function addComment(t, n, o, e, r, u, i, a) {
    0 == e || 2 == e ? (jQuery("#khungnen").css("display", "block"), jQuery("#loadding").css("display", "block"), jQuery.post(n + "/", {
        maSanPham: t
    }, function() {
         Swal.fire({
            title: r,
            text: u,
            type: "success",
            showCancelButton: !0,
            confirmButtonColor: colorButtom,
            confirmButtonText: i,
            cancelButtonText: a,
			allowOutsideClick: false,
			allowEscapeKey: false,
			allowEnterKey: false
         }).then((result) => {
			 if (result.value) {
				 t && (window.location = n + "/")
			 }
        }).catch(swal.noop)
    })) : window.location = o + "/"
}
function updateGH(t, n, o,qtypro,sumthisPro,sumprotopdt) {
	var d = jQuery("#" + o).val(),
	y = parseInt(d);
	jQuery.post(n + "/", {
		qty: y,
		maSanPham: t
	}, function(data) {
		var getData = $.parseJSON(data);
		jQuery('.sumPrice').html(getData.tongtien);
		jQuery('.numberSumProduct').html(getData.countcart);
		jQuery(qtypro).html(getData.qtypro);
		jQuery(sumthisPro).html(getData.thanhtien);
		jQuery(sumprotopdt).html(getData.thanhtien);
	})
}

function deteleSPGHPageName(id,Name,modulePost,modulePage,sumthisPro,sumprotopdt,divRemove) {
	/*Lobibox.confirm({
		msg: "Bạn có muốn xóa sản phẩm "+Name+" ?",
		rounded: true,
		sound: false,
		callback: function ($this, type, ev) {
			var btnType;
			if (type === 'no'){
				btnType = 'warning';
			}else if (type === 'yes'){
				btnType = 'success';
				if ($this){jQuery.post(modulePost + "/", {
						Page:modulePage,
						maSanPham: id
					}, function(data) {
							var getData = $.parseJSON(data);
							jQuery('.sumPrice').html(getData.tongtien);
							jQuery('.numberSumProduct').html(getData.countcart);
							jQuery(divRemove).remove();
							if(getData.countcart==0){
								jQuery("#reloaddiv").load(document.URL + " #reloaddiv>*", "");
								jQuery("#tabledivbox_contact").load(document.URL + " #tabledivbox_contact>*", "");
							}
							Lobibox.notify(btnType, {
								size: 'mini',
								sound: false,
								rounded: true,
								msg: "Sản phẩm "+Name+" đã xóa khỏi giỏ hàng"
							});
					});
				}
			}else if (type === 'ok'){
				btnType = 'info';
			}else if (type === 'cancel'){
				btnType = 'error';
			}
		}
	});*/
	Swal.fire({
		  title: "Bạn có muốn xóa sản phẩm "+Name+" ?",
		  type: 'warning',
		  showCancelButton: true,
		  confirmButtonColor: '#3085d6',
		  cancelButtonColor: '#d33',
		  confirmButtonText: 'Xóa',
		  cancelButtonText: 'Hủy',
		  confirmButtonClass: 'btn btn-success',
		  cancelButtonClass: 'btn btn-danger',
		  buttonsStyling: true,
		  allowOutsideClick: false,
		  allowEscapeKey: false,
		  allowEnterKey: false
	}).then(function (result) {
		 if (result.value){jQuery.post(modulePost + "/", {
				Page:modulePage,
				maSanPham: id
			}, function(data) {
					var getData = $.parseJSON(data);
					jQuery('.sumPrice').html(getData.tongtien);
					jQuery('.numberSumProduct').html(getData.countcart);
					jQuery(divRemove).remove();
					if(getData.countcart==0){
						jQuery("#reloaddiv").load(document.URL + " #reloaddiv>*", "");
						jQuery("#tabledivbox_contact").load(document.URL + " #tabledivbox_contact>*", "");
					}
			});
		}
	})
}
function lienHeNhanTin(t, n, o, e, r, u,em, tem,et,etm) {
	jQuery("#khungnen").css("display", "block"), jQuery("#loadding").css("display", "block");
	return jQuery.post(n + "/", jQuery(t).serialize(), function(t) {
		
        jQuery("#khungnen").css("display", "none");
		jQuery("#loadding").css("display", "none");
		switch(parseInt(t)) {
			case 1:
				Swal.fire({
					title: r,
					type: "error",
					showCancelButton: !1,
					confirmButtonColor: colorButtom,
					confirmButtonText: u,
					allowOutsideClick: false,
					allowEscapeKey: false,
					allowEnterKey: false
			   }).then((result) => {
					 if (result.value) {
						return t ? !1 : void 0
					 }
				})
				break;
			case 2:
				Swal.fire({
					title: em,
					text:tem,
					type: "warning",
					showCancelButton: !1,
					confirmButtonColor:colorButtom,
					confirmButtonText: u,
					allowOutsideClick: false,
					allowEscapeKey: false,
					allowEnterKey: false
				}).then((result) => {
					 if (result.value) {
						 return t ? !1 : void 0
					 }
				});
				break;
			case 3:
				Swal.fire({
					title: et,
					text: etm,
					type: "warning",
					showCancelButton: !1,
					confirmButtonColor:colorButtom,
					confirmButtonText: u,
					allowOutsideClick: false,
					allowEscapeKey: false,
					allowEnterKey: false
				}).then((result) => {
					 if (result.value) {
						 return t ? !1 : void 0
					 }
				});
				break;
			default:
				Swal.fire({
					title: o,
					text: e,
					type: "success",
					showCancelButton: !1,
					confirmButtonColor: colorButtom,
					confirmButtonText: u,
					allowOutsideClick: false,
					allowEscapeKey: false,
					allowEnterKey: false
				 }).then((result) => {
					 if (result.value) {
						t && (window.location)
					 }
				 });
		}
	}),!1;
}


function KiemTraEmailAll(t, n, o, e) {
    var r = /^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,4}$/;
    var u = jQuery("#" + n).val();
    return u.match(r) ? (jQuery("#" + t).attr("type", "submit"), !0) : void Swal.fire({
        title: o,
        type: "error",
        showCancelButton: !1,
        confirmButtonColor: colorButtom,
        confirmButtonText: e,
		allowOutsideClick: false,
		allowEscapeKey: false,
		allowEnterKey: false
	}).then(function(o) {
		jQuery("#" + n).val("");
        return o ? (jQuery("#" + n).focus(), jQuery("#" + t).attr("type", "button"), !1) : void 0;
    }).catch(swal.noop);
}

function checkEmail(name, module, title, texts,buttons) {
		jQuery("#loadmk").css("display", "block");
		jQuery.ajax({
			type: "post",
			url: module, 
			dataType:"text",
			data : {
				namecheck : jQuery(name).val()
			},
			success: function(result){
				jQuery("#loadmk").css("display", "none");
				if(result==2){
					Swal.fire({
						title: title,
						text: texts,
						type: "warning",
						showCancelButton: !1,
						confirmButtonColor: colorButtom,
						confirmButtonText: buttons,
						allowOutsideClick: false,
					  allowEscapeKey: false,
					  allowEnterKey: false
					 }).then((result) => {
						if(result.value){
							jQuery(name).val("");
							jQuery(name).focus();
						}
					 });
				}
			}
		});
}

function addProCart(module,_form,_class_form='',_show_alert=true,_click_trigger_div=''){
	if(_class_form==undefined || _class_form===''){
		_class_form = 'addProCart';
	}
	var text_default = jQuery(_form).find('button[data-action="addCart"]').html();
	jQuery(_form).find('button[data-action="addCart"]').attr('disabled','disabled');
	jQuery(_form).find('button[data-action="addCart"]').html('<i class="fal fa-circle-notch fa-spin"></i>');
	
	jQuery.post(module,jQuery(_form).serialize(), function(data){
		var dadaJSON = jQuery.parseJSON(data);
		jQuery('.sumPrice').html(dadaJSON.tongtien);
		jQuery('.numberSumProduct').html(dadaJSON.countcart);
		jQuery("#reloaddiv").load(document.URL + " #reloaddiv>*", "");

		if(_click_trigger_div!==''){
			jQuery(_click_trigger_div).trigger('click');
			//jQuery('.CartNotification').removeClass('d-none');
			//jQuery('.CartNotification').fadeIn();
			/*setTimeout(function(){
				jQuery('.CartNotification').fadeOut();
			}, 3000);*/
		}else{
			Swal.fire({
			  title: dadaJSON._msg,
			  html: dadaJSON._text,
			  timer: 3000000,
			  customClass: {
				  container: _class_form,
				},
				showConfirmButton:false
			}).then((result) => {
				
			});
		}
		jQuery(_form).find('button[data-action="addCart"]').removeAttr('disabled');
		jQuery(_form).find('button[data-action="addCart"]').html(text_default);
	});
	return false;
}

function _form_send(_form,_module,class_form){
	jQuery("#khungnen").css("display", "block"), jQuery("#loadding").css("display", "block");
	return jQuery.post(_module, jQuery(_form).serialize(), function(data) {
        jQuery("#khungnen").css("display", "none");
		jQuery("#loadding").css("display", "none");
		var dadaJSON = $.parseJSON(data);
		if(jQuery('input[name="_token"]').length){
			if(dadaJSON._token!='' || dadaJSON._token!=null){
				jQuery('input[name="_token"]').val(dadaJSON._token);
			}
		}
		switch(parseInt(dadaJSON.error)) {
			case 0:
			
				/*Lobibox.notify('success',{
					size: 'mini',
					sound: false,
					rounded: true,
					title: dadaJSON._msg,
					msg: dadaJSON._text,
					delayIndicator: false,
				});
				jQuery(_form)[0].reset();
				jQuery(_form).find("select").trigger("change");*/
				
				Swal.fire({
					customClass: {
					  container: class_form,
					},
					title: dadaJSON._msg,
					text: dadaJSON._text,
					type: "success",
					showCancelButton: false,
					confirmButtonColor: colorButtom,
					allowOutsideClick: false,
					allowEscapeKey: false,
					allowEnterKey: false
				 }).then((result) => {
					jQuery(_form)[0].reset();
					jQuery(_form).find("select").trigger("change");
				 });
				break;
			default:
			
				/*Lobibox.notify('error',{
					size: 'mini',
					sound: false,
					rounded: true,
					title: dadaJSON._msg,
					delayIndicator: false,
					delay: 3000,
					msg: dadaJSON._text
				});*/
				Swal.fire({
					title: dadaJSON._msg,
					text: dadaJSON._text,
					type: "error",
					showCancelButton: false,
					confirmButtonColor: colorButtom,
					allowOutsideClick: false,
					allowEscapeKey: false,
					allowEnterKey: false
				 }).then((result) => {

				});
		}
	}),!1;
}


// function buyNow(module,thisForm,moduleRedirect){
// 	jQuery(thisForm).find('button[type="submit"]').html('Đang xứ lý');
// 	jQuery(thisForm).find('button[type="submit"]').attr('disabled','disabled');
// 	//document.dispatchEvent(new CustomEvent("theme:loading:start"));
// 	jQuery.post(module,jQuery(thisForm).serialize(), function(data){
// 		var dataJSon = jQuery.parseJSON(data);
// 		if(dataJSon && moduleRedirect!==''){
// 			window.location.href = moduleRedirect;
// 		}
// 		return false;
// 	});
// }

function _order(_id,_amount,_module,class_form){
	jQuery("#khungnen").css("display", "block"), jQuery("#loadding").css("display", "block");
	jQuery.post(_module,{
		 id: _id,
		 amount: _amount,
	},function(data) {
        jQuery("#khungnen").css("display", "none");
		jQuery("#loadding").css("display", "none");
		var dadaJSON = $.parseJSON(data);
		if(jQuery('input[name="_token"]').length){
			if(dadaJSON._token!='' || dadaJSON._token!=null){
				jQuery('input[name="_token"]').val(dadaJSON._token);
			}
		}
		switch(parseInt(dadaJSON.error)) {
			case 0:
				Swal.fire({
					customClass: {
					  container: class_form,
					},
					title: dadaJSON._msg,
					text: dadaJSON._text,
					type: "success",
					showCancelButton: false,
					confirmButtonColor: colorButtom,
					allowOutsideClick: false,
					allowEscapeKey: false,
					allowEnterKey: false
				 }).then((result) => {
					jQuery(_form)[0].reset();
					jQuery(_form).find("select").trigger("change");
				 });
				break;
			default:
				Swal.fire({
					title: dadaJSON._msg,
					text: dadaJSON._text,
					type: "error",
					showCancelButton: false,
					confirmButtonColor: colorButtom,
					allowOutsideClick: false,
					allowEscapeKey: false,
					allowEnterKey: false
				 }).then((result) => {
					 if(jQuery(".inforRecapchar").length){
						 jQuery(".inforRecapchar>a").trigger( "click");
					 }
				});
		}
	});
}

function _form_order(_form,_module,class_form){
	jQuery("#khungnen").css("display", "block"), jQuery("#loadding").css("display", "block");
	return jQuery.post(_module, jQuery(_form).serialize(), function(data) {
        jQuery("#khungnen").css("display", "none");
		jQuery("#loadding").css("display", "none");
		var dadaJSON = $.parseJSON(data);
		if(jQuery('input[name="_token"]').length){
			if(dadaJSON._token!='' || dadaJSON._token!=null){
				jQuery('input[name="_token"]').val(dadaJSON._token);
			}
		}
		if(dadaJSON.error===0){
			
			if(dadaJSON.module_redirect!==undefined || dadaJSON.module_redirect!==null ){
				window.location = dadaJSON.module_redirect;
			}else{
				Swal.fire({
					title: dadaJSON._msg,
					text: dadaJSON._text,
					type: "error",
					showCancelButton: false,
					confirmButtonColor: colorButtom,
					allowOutsideClick: false,
					allowEscapeKey: false,
					allowEnterKey: false
				 }).then((result) => {
					 if(jQuery(".inforRecapchar").length){
						 jQuery(".inforRecapchar>a").trigger( "click");
					 }
				});
			}
		}else{
			Swal.fire({
				title: dadaJSON._msg,
				text: dadaJSON._text,
				type: "error",
				showCancelButton: false,
				confirmButtonColor: colorButtom,
				allowOutsideClick: false,
				allowEscapeKey: false,
				allowEnterKey: false
			 }).then((result) => {
				
			});
		}
	}),!1;
}


function checkFile(idFile,file){
	var fileSize = $(idFile)[0].files[0];
    var sizeInMb = fileSize.size/1024;
    var sizeLimit= 1024*2;
	if (sizeInMb > sizeLimit) {
		alert('Chỉ cho phép tải file có dụng lưởng  < 2MB!');
		jQuery(idFile).val("");
    }
	var fileFull = $(idFile)[0].files[0];
	var ext = file.split(".");
    ext = ext[ext.length-1].toLowerCase();      
    var arrayExtensions = ["jpg" , "jpeg", "png","rar","zip","bmp", "gif"];
	if (arrayExtensions.lastIndexOf(ext) == -1) {
		alert('Sai định dạng file (jpg.jpeg,png,bmp,gif).');
		jQuery(idFile).val("");
    }else{
			jQuery("#statusFile").text("");
	}
}

function inputNumberInt(input) {
	jQuery(input).val($(input).val().replace(/[^\d].+/, ""));
	if ((event.which < 48 || event.which > 57)) {
		event.preventDefault();
	}
}

function inputNumberFloat(input) {
	$(input).val($(input).val().replace(/[^0-9\.]/g,''));
	if ((event.which != 46 || $(input).val().indexOf('.') != -1) && (event.which < 48 || event.which > 57)) {
		event.preventDefault();
	}
}

function enterCheckEmail(btn){
	jQuery(btn).keydown(function(e) {
		if(jQuery(btn).val()==''){
			if(e.keyCode == 13 ){
				return false;
			}
		}
	});
}

/************START addThis_listSharing button click show contact all fixed***********/
$(document).ready(function(){
	if (jQuery('.addThis_listSharing').length > 0) {
		jQuery('.addThis_iconContact,.addThis_listSharing .addThis_close').on('click', function(e) {
			console
			if (jQuery('.addThis_listSharing').hasClass('active')) {
				jQuery('.addThis_listSharing').removeClass('active');
				jQuery('.addThis_listSharing').fadeOut(150);
			} else {
				jQuery('.addThis_listSharing').fadeIn(100);
				jQuery('.addThis_listSharing').addClass('active');
			}
		});
		jQuery('.listSharing_overlay').on('click', function(e) {
			jQuery('.addThis_listSharing').removeClass('active');
			jQuery('.addThis_listSharing').fadeOut(150);
		})
	}
});
/************END addThis_listSharing button click show contact all fixed***********/