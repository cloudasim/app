<!DOCTYPE html>
<!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7"> <![endif]-->
<!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8"> <![endif]-->
<!--[if IE 8]>         <html class="no-js lt-ie9"> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js"> <!--<![endif]-->
<html lang="en">
    <head>
        <meta charset="utf-8">
        <title>APP - Learning jquery AJAX</title>
        <meta name="description" content="ajax jquery">
        <meta name="author" content="cloudasim">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="icon" type="image/x-icon" href="assets_front/images/favicon.ico">
        <link rel="stylesheet" href="assets/dist/css/main.min.css" type="text/css">
        <link rel="stylesheet" href="http://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400|Merriweather:300,400,700">
    </head>
    <!--[if lt IE 7]>
        <p class="browsehappy">You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade your browser</a> to improve your experience.</p>
    <![endif]-->
    <body>
        <div id="main-wrapper">
            <div class="container">
                <div class="row">
                    <div class="col-sm-8 col-sm-offset-2">
                        <h1>Send Message &rarr;</h1>
                        <hr>
                        <div id="formMsg"></div>
                        <form action="add.php" method="post" id="contactForm">
                            <!-- FULL NAME  -->
                            <div class="form-group">
                                <label for="fullname"> Full Name *</label>
                                <input type="text" placeholder="fullname" id="fullname" name="fullname" class="form-control" />
                                <span id="fnHb" class="help-block"></span>
                            </div>
                            <!--  Email Address -->
                            <div class="form-group">
                                <label for="emailadd"> Email Address *</label>
                                <input type="email" placeholder="email" id="emailadd" name="emailadd" class="form-control" />
                                <span id="eaHb" class="help-block"></span>
                            </div>
                            <!-- Phone Number -->
                            <div class="form-group">
                                <label for="phonenum"> Phone Number *</label>
                                <input type="text" placeholder="phone Number" id="phonenum" name="phonenum" class="form-control" />
                                <span id="pnHb" class="help-block"></span>
                            </div>
                            <!-- Message -->
                            <div class="form-group">
                                <label for="message"> Message *</label>
                                <textarea placeholder="message" id="message" name="message" class="form-control"></textarea>
                                <span id="msgHb" class="help-block"></span>
                            </div>

                            <div class="form-group">
                                <input type="hidden" value="<?php echo date("Y-m-d h:i:s"); ?>" id="senton" name="senton">
                                <input type="submit" value="submit" class="btn btn-primary"/>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </body>
    <script src="assets/dist/js/script.min.js" type="text/javascript"></script>
    <script type="text/javascript">
        $(document).ready(function(){
            var nameip = $('#fullname'),
            emailip = $('#emailadd'),
            phoneip = $('#phonenum'),
            msgip = $('#message'),
            parent = $('#contactForm');

            var onlytext = /[A-z]/;
            var containsNumbers = /[0-9]/;
            var phonestarts = /^98.\d/;
            var emailregex = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;

            var validate = function( selector, isvalid, msg ){
                if(isvalid == true){
                    selector.parent().removeClass('has-error');
                    selector.parent().addClass('has-success');
                    selector.next().html(msg);
                }
                else if(isvalid == false){
                    selector.parent().removeClass('has-success');
                    selector.parent().addClass('has-error');
                    selector.next().html(msg);
                }
            }

            var validatename = function(){
                var value = nameip.val();
                // More than 3 characters
                if (value.length >= 3) {
                    validate(nameip, true, ' ' );
                    return true;
                } else {
                    validate(nameip, false, 'Name Should Be min. 3 Chars Long ' );
                    return false;
                }
            }

            var validatemail = function(){
                var value = emailip.val();
                if (emailregex.test(value)) {
                  validate(emailip, true, ' ' );
                } else {
                  validate(emailip, false, 'Its Not an Email Address. Please Check It!' );
                }
            }

            var validatephone = function(e) {
              var value = phoneip.val();
              if (phonestarts.test(value) && value.length === 10) {
                validate(phoneip, true, ' ' );
                phoneip.onkeypress = function(e) {
                  return true;
                }
              } else if (value.length > 10) {
                validate(phoneip, false, 'Oops! Phone Number is no longer than 10 chars!!' );
                phoneip.onkeypress = function(e) {
                  e.preventDefault();
                  return false;
                }
              } else {
                validate(phoneip, false, 'Oops! That\'s Not Your Phone Number!! Check it' );
                phoneip.onkeypress = function(e) {
                  return true;
                }
              }
            }

            var validatemsg = function(e) {
                var value = msgip.val();
                if (value.length >= 1 && value.length < 100) {
                    validate(msgip, true, ' ' );
                    msgip.onkeypress = function(e) {
                      return true;
                    }
                } else if (value.length >= 100) {
                    validate(msgip, false, 'Oops! We Dont read Long Message. Please limit it to 100 chars Please.' );
                    msgip.onkeypress = function(e) {
                      e.preventDefault();
                      return false;
                    }
                } else {
                    validate(msgip, false, 'We like to read your message. Please write something.' );
                    msgip.onkeypress = function(e) {
                      return true;
                    }
                }
            }

            nameip.on('input', validatename);

            emailip.on('input', validatemail);

            phoneip.on('input', validatephone);

            msgip.on('input', validatemsg);
            
            // news title
            var texts = [];
            $.ajax({
                type: "GET",
                url: 'https://newsapi.org/v1/articles?source=cnn&apiKey=ebd34b2e3d1a4c0f8fac60e1c78afa00',
                success: function(result){
                    for(var i=0; i<result.articles.length; i++){
                        texts.push(result.articles[i].title);
                    }
                    console.log(texts);
                }
            });

            $('#contactForm').on('submit', function(e) {
                e.preventDefault();
                var x = parent.find('.has-error').index();
                var z = [];
                parent.find(':input').each(function(){
                    var input = $(this).val().length;
                    if(input > 1){
                        z.push(input);
                    }
                });
                if(x == '-1' && z.length == '6'){
                    $.ajax({
                        type: "POST",
                        url: 'add.php',
                        data: $('#contactForm').serialize(),
                        success : function(text){
                            if (text == "success"){
                                $('#contactForm')[0].reset();
                                $('#contactForm').find('.form-group').removeClass('has-success has-error');
                                $('#formMsg').text('Message Successfully Sent').removeClass('text-danger').addClass('well text-primary');
                            }
                            else if (text == 'error'){
                                alert('nothing yet');
                            }
                        }
                    });
                }
                else{
                    $('#formMsg').text('First Fix The Errors').removeClass('text-primary').addClass('well text-danger');
                }
            });
        });
    </script>
</html>