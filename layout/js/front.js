$(function () {

	'use strict';
	//switch-between-login-And-signup
	$(".login-page h1 span").click(function () {
		$(this).addClass("selected").siblings().removeClass("selected");
		$(".login-page form").hide();
		$('.'+ $(this).data("class")).fadeIn(500);
	})
	//selectBoxIt

	$("select").selectBoxIt({
		autoWidth:false
	});


	//hide placeholder on form focus

	$('[placeholder]').focus(function () {
		$(this).attr('data-text',$(this).attr('placeholder'));
		$(this).attr('placeholder','');
	}).blur(function () {
		$(this).attr("placeholder",$(this).attr('data-text'));
	});


	//confirmation message on delete button

	$(".confirm").click(function () {
		return confirm("Are You Sure?");
	});

	
	//add astrisk in requird field
	$('input').each(function () {
		if ($(this).attr('required')==='required') {
			$(this).after('<span class="astrisk">*</span>')
		}
	}); 

	function openNav() {
    document.getElementById("mySidenav").style.width = "250px";
    document.getElementById("main").style.marginLeft = "250px";
	}

	/* Set the width of the side navigation to 0 and the left margin of the page content to 0 */
	function closeNav() {
	    document.getElementById("mySidenav").style.width = "0";
	    document.getElementById("main").style.marginLeft = "0";
	}

	$(".live").keyup(function () {
		$($(this).data("class")).text($(this).val());
	});
	

 });
	