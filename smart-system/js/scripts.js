/* Template: Tivo - SaaS App HTML Landing Page Template
   Author: Inovatik
   Created: Sep 2019
   Description: Custom JS file
*/


(function($) {
    "use strict"; 
	
	/* Preloader */
	$(window).on('load', function() {
		var preloaderFadeOutTime = 500;
		function hidePreloader() {
			var preloader = $('.spinner-wrapper');
			setTimeout(function() {
				preloader.fadeOut(preloaderFadeOutTime);
			}, 500);
		}
		hidePreloader();
	});

	
	/* Navbar Scripts */
	// jQuery to collapse the navbar on scroll
    $(window).on('scroll load', function() {
		if ($(".navbar").offset().top > 60) {
			$(".fixed-top").addClass("top-nav-collapse");
		} else {
			$(".fixed-top").removeClass("top-nav-collapse");
		}
    });

	// jQuery for page scrolling feature - requires jQuery Easing plugin
	$(function() {
		$(document).on('click', 'a.page-scroll', function(event) {
			var $anchor = $(this);
			$('html, body').stop().animate({
				scrollTop: $($anchor.attr('href')).offset().top
			}, 600, 'easeInOutExpo');
			event.preventDefault();
		});
	});

    // closes the responsive menu on menu item click
    $(".navbar-nav li a").on("click", function(event) {
    if (!$(this).parent().hasClass('dropdown'))
        $(".navbar-collapse").collapse('hide');
    });


    /* Image Slider - Swiper */
    var imageSlider = new Swiper('.image-slider', {
        autoplay: {
            delay: 2000,
            disableOnInteraction: false
		},
        loop: true,
        spaceBetween: 30,
        slidesPerView: 5,
		breakpoints: {
            // when window is <= 580px
            580: {
                slidesPerView: 1,
                spaceBetween: 10
            },
            // when window is <= 768px
            768: {
                slidesPerView: 2,
                spaceBetween: 20
            },
            // when window is <= 992px
            992: {
                slidesPerView: 3,
                spaceBetween: 20
            },
            // when window is <= 1200px
            1200: {
                slidesPerView: 4,
                spaceBetween: 20
            },

        }
    });


    /* Text Slider - Swiper */
	var textSlider = new Swiper('.text-slider', {
        autoplay: {
            delay: 6000,
            disableOnInteraction: false
		},
        loop: true,
        navigation: {
			nextEl: '.swiper-button-next',
			prevEl: '.swiper-button-prev'
		}
    });


    /* Video Lightbox - Magnific Popup */
    $('.popup-youtube, .popup-vimeo').magnificPopup({
        disableOn: 700,
        type: 'iframe',
        mainClass: 'mfp-fade',
        removalDelay: 160,
        preloader: false,
        fixedContentPos: false,
        iframe: {
            patterns: {
                youtube: {
                    index: 'youtube.com/', 
                    id: function(url) {        
                        var m = url.match(/[\\?\\&]v=([^\\?\\&]+)/);
                        if ( !m || !m[1] ) return null;
                        return m[1];
                    },
                    src: 'https://www.youtube.com/embed/%id%?autoplay=1'
                },
                vimeo: {
                    index: 'vimeo.com/', 
                    id: function(url) {        
                        var m = url.match(/(https?:\/\/)?(www.)?(player.)?vimeo.com\/([a-z]*\/)*([0-9]{6,11})[?]?.*/);
                        if ( !m || !m[5] ) return null;
                        return m[5];
                    },
                    src: 'https://player.vimeo.com/video/%id%?autoplay=1'
                }
            }
        }
    });


    /* Details Lightbox - Magnific Popup */
	$('.popup-with-move-anim').magnificPopup({
		type: 'inline',
		fixedContentPos: false, /* keep it false to avoid html tag shift with margin-right: 17px */
		fixedBgPos: true,
		overflowY: 'auto',
		closeBtnInside: true,
		preloader: false,
		midClick: true,
		removalDelay: 300,
		mainClass: 'my-mfp-slide-bottom'
	});
    
    
    /* Move Form Fields Label When User Types */
    // for input and textarea fields
    $("input, textarea").keyup(function(){
		if ($(this).val() != '') {
			$(this).addClass('notEmpty');
		} else {
			$(this).removeClass('notEmpty');
		}
    });


    /* Sign Up Form */
    $("#signUpForm").validator().on("submit", function(event) {
    	if (event.isDefaultPrevented()) {
            // handle the invalid form...
            sformError();
            ssubmitMSG(false, "请完善内容！");
            $("#GoToLogin").hide();
        } else {
            // everything looks good!
            event.preventDefault();
            ssubmitForm();
            $("#GoToLogin").show();
        }
    });

    function ssubmitForm() {
        // initiate variables with form content
		//var email = $("#semail").val();
		var name = $("#sname").val();
		var password = $("#spassword").val();
        var terms = $("#sterms").val();
        
        $.ajax({
            type: "POST",
            url: "php/signupform-process.php",
            data: "&name=" + name + "&password=" + password + "&terms=" + terms, 
            success: function(text) {
                text = $.trim(text);
                if (text == "successful") {
                    sformSuccess();
                } else {
                    sformError();
                    ssubmitMSG(false, text);
                }
            }
        });
	}

    function sformSuccess() {
        $("#signUpForm")[0].reset();
        ssubmitMSG(true, "注册请求已提交");
        $("input").removeClass('notEmpty'); // resets the field label after submission
        var name = $("#sname").val();
        setLoginCookie(name);
    }

    // 设置登录cookie
    function setLoginCookie(name) {
    var date = new Date();
    date.setTime(date.getTime() + (24*60*60*1000)); // 设置cookie的过期时间为24小时
    var expires = "; expires=" + date.toGMTString();
    document.cookie = "username=" + name + expires + "; path=/";
    }


    function sformError() {
        $("#signUpForm").removeClass().addClass('shake animated').one('webkitAnimationEnd mozAnimationEnd MSAnimationEnd oanimationend animationend', function() {
            $(this).removeClass();
        });
	}

    function ssubmitMSG(valid, msg) {
        if (valid) {
            var msgClasses = "h3 text-center tada animated";
        } else {
            var msgClasses = "h3 text-center";
        }
        if (msg == "用户名已存在，请重新注册") {
            $("#signUpForm")[0].reset();
        }
        $("#smsgSubmit").removeClass().addClass(msgClasses).html(msg);
    }

    $('#goToDashboard').click(function() {
        window.location.href = 'Log-in.html';
    });


    /* Log In Form */
    $("#logInForm").validator().on("submit", function(event) {
    	if (event.isDefaultPrevented()) {
            // handle the invalid form...
            lformError();
            lsubmitMSG(false, "请完善内容！");
        } else {
            // everything looks good!
            event.preventDefault();
            lsubmitForm();
        }
    });

    function lsubmitForm() {
        // initiate variables with form content
		var name = $("#lname").val();
		var password = $("#lpassword").val();
        var captcha = $("#lcaptcha").val();
        
        $.ajax({
            type: "POST",
            url: "php/loginform-process.php",
            data: "name=" + name + "&password=" + password+ "&captcha=" + captcha, 
            success: function(text) {
                text = $.trim(text);
                if (text == "successful") {
                    lformSuccess();
                } else {
                    lformError();
                    lsubmitMSG(false, text);
                }
            }
        });
	}

    function lformSuccess() {
        $("#logInForm")[0].reset();
        
        lsubmitMSG(true, "验证成功，登录中……");
        $("input").removeClass('notEmpty'); // resets the field label after submission

        setTimeout(function() {
            window.location.href = "data-showing/data-visitile.html"; // 注意替换成可视化界面
        }, 1000);
    }

    function lformError() {
        $("#logInForm").removeClass().addClass('shake animated').one('webkitAnimationEnd mozAnimationEnd MSAnimationEnd oanimationend animationend', function() {
            $(this).removeClass();
        });
	}

    function lsubmitMSG(valid, msg) {
        if (valid) {
            var msgClasses = "h3 text-center tada animated";
        } else {
            var msgClasses = "h3 text-center";
        }
        if (msg == "用户名不存在，请注册") {
            $("#logInForm")[0].reset();
        }
        $("#lmsgSubmit").removeClass().addClass(msgClasses).text(msg);
    }

    /* adminLog In Form */
    $("#adminlogInForm").validator().on("submit", function(event) {
    	if (event.isDefaultPrevented()) {
            // handle the invalid form...
            alformError();
            alsubmitMSG(false, "请完善内容！");
        } else {
            // everything looks good!
            event.preventDefault();
            alsubmitForm();
        }
    });

    function alsubmitForm() {
        // initiate variables with form content
		var name = $("#lname").val();
		var password = $("#lpassword").val();
        var captcha = $("#lcaptcha").val();
        
        $.ajax({
            type: "POST",
            url: "php/adminloginform-process.php",
            data: "name=" + name + "&password=" + password+ "&captcha=" + captcha, 
            success: function(text) {
                text = $.trim(text);
                if (text == "successful") {
                    alformSuccess();
                } else {
                    alformError();
                    alsubmitMSG(false, text);
                }
            }
        });
	}

    function alformSuccess() {
        $("#adminlogInForm")[0].reset();
        
        alsubmitMSG(true, "验证成功，登录中……");
        $("input").removeClass('notEmpty'); // resets the field label after submission

        setTimeout(function() {
            window.location.href = "php_mysql_info/index.php"; // 注意替换成可视化界面
        }, 1000);
    }

    function alformError() {
        $("#adminlogInForm").removeClass().addClass('shake animated').one('webkitAnimationEnd mozAnimationEnd MSAnimationEnd oanimationend animationend', function() {
            $(this).removeClass();
        });
	}

    function alsubmitMSG(valid, msg) {
        if (valid) {
            var msgClasses = "h3 text-center tada animated";
        } else {
            var msgClasses = "h3 text-center";
        }
        if (msg == "信息错误") {
            $("#adminlogInForm")[0].reset();
        }
        $("#almsgSubmit").removeClass().addClass(msgClasses).text(msg);
    }

    /* Newsletter Form */
    $("#newsletterForm").validator().on("submit", function(event) {
    	if (event.isDefaultPrevented()) {
            // handle the invalid form...
            nformError();
            nsubmitMSG(false, "Please fill all fields!");
        } else {
            // everything looks good!
            event.preventDefault();
            nsubmitForm();
        }
    });

    function nsubmitForm() {
        // initiate variables with form content
		var email = $("#nemail").val();
        var terms = $("#nterms").val();
        $.ajax({
            type: "POST",
            url: "php/newsletterform-process.php",
            data: "email=" + email + "&terms=" + terms, 
            success: function(text) {
                text = $.trim(text);
                if (text == "successful") {
                    nformSuccess();
                } else {
                    nformError();
                    nsubmitMSG(false, text);
                }
            }
        });
	}

    function nformSuccess() {
        $("#newsletterForm")[0].reset();
        nsubmitMSG(true, "Subscribed!");
        $("input").removeClass('notEmpty'); // resets the field label after submission
    }

    function nformError() {
        $("#newsletterForm").removeClass().addClass('shake animated').one('webkitAnimationEnd mozAnimationEnd MSAnimationEnd oanimationend animationend', function() {
            $(this).removeClass();
        });
	}

    function nsubmitMSG(valid, msg) {
        if (valid) {
            var msgClasses = "h3 text-center tada animated";
        } else {
            var msgClasses = "h3 text-center";
        }
        $("#nmsgSubmit").removeClass().addClass(msgClasses).text(msg);
    }
    

    /* Privacy Form */
    $("#privacyForm").validator().on("submit", function(event) {
    	if (event.isDefaultPrevented()) {
            // handle the invalid form...
            pformError();
            psubmitMSG(false, "Please fill all fields!");
        } else {
            // everything looks good!
            event.preventDefault();
            psubmitForm();
        }
    });

    function psubmitForm() {
        // initiate variables with form content
		var name = $("#pname").val();
		var email = $("#pemail").val();
        var select = $("#pselect").val();
        var terms = $("#pterms").val();
        
        $.ajax({
            type: "POST",
            url: "php/privacyform-process.php",
            data: "name=" + name + "&email=" + email + "&select=" + select + "&terms=" + terms, 
            success: function(text) {
                if (text == "success") {
                    pformSuccess();
                } else {
                    pformError();
                    psubmitMSG(false, text);
                }
            }
        });
	}

    function pformSuccess() {
        $("#privacyForm")[0].reset();
        psubmitMSG(true, "Request Submitted!");
        $("input").removeClass('notEmpty'); // resets the field label after submission
    }

    function pformError() {
        $("#privacyForm").removeClass().addClass('shake animated').one('webkitAnimationEnd mozAnimationEnd MSAnimationEnd oanimationend animationend', function() {
            $(this).removeClass();
        });
	}

    function psubmitMSG(valid, msg) {
        if (valid) {
            var msgClasses = "h3 text-center tada animated";
        } else {
            var msgClasses = "h3 text-center";
        }
        $("#pmsgSubmit").removeClass().addClass(msgClasses).text(msg);
    }
    

    /* Back To Top Button */
    // create the back to top button
    $('body').prepend('<a href="body" class="back-to-top page-scroll">Back to Top</a>');
    var amountScrolled = 700;
    $(window).scroll(function() {
        if ($(window).scrollTop() > amountScrolled) {
            $('a.back-to-top').fadeIn('500');
        } else {
            $('a.back-to-top').fadeOut('500');
        }
    });


	/* Removes Long Focus On Buttons */
	$(".button, a, button").mouseup(function() {
		$(this).blur();
	});

})(jQuery);