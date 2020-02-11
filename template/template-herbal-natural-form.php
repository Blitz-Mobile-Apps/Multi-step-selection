<link rel="stylesheet" href="<?php echo MAINURL; ?>assets/css/custom.css">


<?php 
if (empty($_GET['submit'])): 
    require 'personalize.php'; 
else: 
    require 'cs_checkout.php'; 
endif; 
?>


<script src="<?php echo MAINURL; ?>assets/vendor/jquery.steps.min.js"></script>
<script type="text/javascript" src="<?php echo MAINURL; ?>assets/vendor/jquery.validate.min.js"></script>
<script type="text/javascript" src="<?php echo MAINURL; ?>assets/vendor/sweetalert.min.js"></script>

<script>
    jQuery(document).on('change', 'ul.list-select li input:not(.cs-submenu li input)', function(event) {
        event.preventDefault();
        jQuery('ul.cs-submenu').slideUp();
        jQuery(this).closest('li').find('ul.cs-submenu').slideDown();
    });


    jQuery(document).ready(function() {
        jQuery('.content section').each(function(index, el) {
            var title   = jQuery(this).find('ul.list-select li:first-child label span').text();
            var dis     = jQuery(this).find('ul.list-select li:first-child label span').data('dis');
            var benefit = jQuery(this).find('ul.list-select li:first-child label span').data('benefit');
            var img     = jQuery(this).find('ul.list-select li:first-child label span').data('img');

            jQuery(this).find('.col-md-9 .row .col-md-5 h4').text(title);
            jQuery(this).find('.col-md-9 .row .col-md-5 h5+p').text(dis);
            jQuery(this).find('.col-md-9 .row .col-md-5 h5+p+h5+p').text(benefit);
            jQuery(this).find('.col-md-9 .row .col-md-7 img').attr('src', img);
        });
        jQuery(document).on('mouseenter', 'ul.list-select li label', function(event) {
            event.preventDefault();
            var title = jQuery(this).find('span').text();
            var dis = jQuery(this).find('span').data('dis');
            var benefit = jQuery(this).find('span').data('benefit');
            var img = jQuery(this).find('span').data('img');
            jQuery(this).closest('li').find('label.error').remove();
            jQuery(this).closest('.row').find('.col-md-9 .row .col-md-5 h4').text(title);
            jQuery(this).closest('.row').find('.col-md-9 .row .col-md-5 h5+p').text(dis);
            jQuery(this).closest('.row').find('.col-md-9 .row .col-md-5 h5+p+h5+p').text(benefit);
            jQuery(this).closest('.row').find('.col-md-9 .row .col-md-7 img').attr('src', img);
        });

         jQuery("#delivery-date").datepicker({
        "minDate": 7,
    })
    });




/**
 * Custom validator for contains at least one lower-case letter
 */
 jQuery.validator.addMethod("atLeastOneLowercaseLetter", function (value, element) {
    return this.optional(element) || /[a-z]+/.test(value);
}, "Must have at least one lowercase letter");
 
/**
 * Custom validator for contains at least one upper-case letter.
 */
 jQuery.validator.addMethod("atLeastOneUppercaseLetter", function (value, element) {
    return this.optional(element) || /[A-Z]+/.test(value);
}, "Must have at least one uppercase letter");
 
/**
 * Custom validator for contains at least one number.
 */
 jQuery.validator.addMethod("atLeastOneNumber", function (value, element) {
    return this.optional(element) || /[0-9]+/.test(value);
}, "Must have at least one number");
 
/**
 * Custom validator for contains at least one symbol. 
 */
 jQuery.validator.addMethod("atLeastOneSymbol", function (value, element) {
    return this.optional(element) || /[!@#$%^&*()]+/.test(value);
}, "Must have at least one symbol");


jQuery.validator.addMethod("valueNotEquals", function(value, element, arg){
  return arg !== value;
 }, "This field is required.");


var form = jQuery("#example-form");
form.validate({
    errorPlacement: function errorPlacement(error, element) { element.after(error); },
    rules: {
        future_camp: { valueNotEquals: "0" },
        services: { valueNotEquals: "0" },
        number_of_persons: { valueNotEquals: "0" },
        userName: {
            required: true,
            atLeastOneLowercaseLetter: true,
            minlength: 4,
            maxlength: 40,
            remote: {
                url: "<?php echo site_url(); ?>/wp-admin/admin-ajax.php?action=cms_checkusername",
                type: "post"
            }
        },
        kvk_number: {
            required: true,
            remote: {
                url: "<?php echo site_url(); ?>/wp-admin/admin-ajax.php?action=cms_kvk_number",
                type: "post"
            }
        },
        userEmail: {
            required: true,
            email: true,
            remote: {
                url: "<?php echo site_url(); ?>/wp-admin/admin-ajax.php?action=cms_checkemail",
                type: "post"
            }
        },          
        confirm: {
            equalTo: "#password"
        }
    },
    messages: {
        // future_camp: { valueNotEquals: "Please select a month" },
        userName: {
            required: "Please enter your Username",
            remote: "Username is already in use!"
        },
        userEmail: {
            required: "Please enter your Email address.",
            remote: "Email is already in use!"
        },
        kvk_number: {
            required: "Please enter your Kvk Number",
            remote: "Your KVK is'nt verified!"
        }
    },
});
form.children("div").steps({
    headerTag: "h3",
    labels: {
        finish: "Checkout",
    },
    bodyTag: "section",
        // transitionEffect: "slideLeft",
        // autoFocus: true,
        onStepChanging: function (event, currentIndex, newIndex){
            if (newIndex==cs_object.step_count) {
                console.log('done');
                var dataa = form.serializeArray();
                console.log(dataa);
                jQuery('ul.personalized_data').html('');
                var priceA = 0;
                var name = 0;
                jQuery.each(dataa, function(index, val) {
                    price = jQuery('input[name="'+val.name+'"]:checked').data('price');
                    name = jQuery('input[name="'+val.name+'"]:checked').data('name');
                    if (typeof name !== 'undefined') {
                        jQuery('ul.personalized_data').append('<li><label><strong>'+name+':</strong><span>'+val.value+'</span></label></li>');
                        if (price != '') {
                            console.log(1);
                            priceA += parseInt(price);
                        }
                    }
                });
                jQuery('#amountcal').html('£'+priceA+'<input type="hidden" name="amount" value="'+priceA+'">');
                console.log(priceA);
            }
            form.validate().settings.ignore = ":disabled,:hidden";
            return form.valid();
        },
        onFinishing: function (event, currentIndex){
            form.validate().settings.ignore = ":disabled";
            return form.valid();
        },
        onFinished: function (event, currentIndex){
            form.submit();
        }
    });


jQuery(document).on('submit', '#cms_formsubmit', function(event) {
    event.preventDefault();
    jQuery('#ajax-loading-screen').css({'opacity':'1', 'display':'block'});
    jQuery('#ajax-loading-screen .loading-icon').animate({'opacity':1},400);
    var formData = new FormData(jQuery(this)[0]);
    jQuery.ajax({
        type: 'post',
        url: '<?php echo site_url(); ?>/wp-admin/admin-ajax.php?action=cms_formsubmit',
        dataType: 'json',
        contentType: false,
        processData: false,
        data: formData,
    })
    .done(function(value) {
        jQuery('#ajax-loading-screen').css({'opacity':'0', 'display':'none'});
        if (value.status) {
             jQuery('#cms_formsubmit').trigger('reset');
             swal('Thank You!', value.msg ,'success');
        }else{
            swal({
                type: 'error',
                title: 'Oops...',
                text: value.msg2.L_LONGMESSAGE0,
            });
        }
        console.log(value);
        })
        .fail(function() {
        jQuery('#ajax-loading-screen').css({'opacity':'0', 'display':'none'});
        // jQuery('.loader-css').hide();
        console.log("error");
        });
});
</script>
