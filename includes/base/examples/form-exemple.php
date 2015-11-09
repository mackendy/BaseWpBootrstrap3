
<?php

$prefix = get_prefix();
global $post;
$lang = ICL_LANGUAGE_CODE;


wp_enqueue_script('recaptcha-api', '//www.google.com/recaptcha/api.js?hl='.$lang, array('jquery'), '1.0', false);


//$result  = file_get_contents('https://www.google.com/recaptcha/api/siteverify');

$errorVals = array(
    'recaptcha_passed' => array(
        'required' => ($form->lang == 'en' ? "Please prove that you are not a robot!" : "Please prove that you are not a robot!")
    ),
    'form_name'  => array(
        'required' => __('This field is required', 'Form', themeDomain())
    ),
    'form_main_name'  => array(
        'required' => __('This field is required', 'Form', themeDomain())
    ),
    'form_main_last_name'  => array(
        'required' => __('This field is required', 'Form', themeDomain())
    ),
    'form_main_email' => array(
        'required'  => __('This field is required', 'Form', themeDomain()),
        'valid' => __('Email not valid', 'Form', themeDomain()),
    ),
    'form_main_phone' => array(
        'required'  => __('This field is required', 'Form', themeDomain()),
        'max' => __('Please use less than 10 number ', 'Form', themeDomain()),
        'minlength' => __('Please use min than 10 number', 'Form', themeDomain()),
    ),
    'form_main_entreprise'  => array(
        'required' => __('This field is required', 'Form', themeDomain())
    ),
    'form_main_ville'  => array(
        'required' => __('This field is required', 'Form', themeDomain())
    ),
);

$placeholder = array(
    'form_main_name'  => __('First Name*', 'Form', themeDomain()),

    'form_main_last_name'  => __('Last Name*', 'Form', themeDomain()),
    'form_main_email' => __('Email*', 'Form', themeDomain()),
    'form_main_phone' => __('Phone*', 'Form', themeDomain()),
    'form_main_entreprise'  => __('Company*', 'Form', themeDomain()),
    'form_main_ville'  => __('City*', 'Form', themeDomain()),
    'form_main_subject' => __('Subject', 'Form', themeDomain()),
    'form_main_select' => __('Select our country', 'Form', themeDomain()),
    'form_main_message' => __('Your message', 'Form', themeDomain()),

    'form_email' => __('Email', 'Form', themeDomain()),
    'form_name'  => __('Full name', 'Form', themeDomain()),
);
if($form->staticVars['form_main_checkbox_secu_gratuit'] == 'on'){
    $pour = 'maravary@entreprisesls.com';
}else{
    $pour = 'reception@entreprisesls.com';
}

$emailSetting = array(
    'sendTo'=>$pour,
    'sendFromName'=>'LS',
    'emailSubject'=>'Contact lS',
);
$form = new form_builder(get_lang_active(),$errorVals,$placeholder,$emailSetting);

$hasEmailed = false;


if(!empty($form->request)):
    if($form->is_valid('form_main_submit')):

        if (!$form->is_valid('g-recaptcha-response')):
            $form->errors['recaptcha_passed'] = true;
            $form->proceed                    = false;
        else:
            $google_url = "https://www.google.com/recaptcha/api/siteverify";
            $secret     = $form->recaptcha['secret_key'];
            $ip         = $form->get_ip();
            $url        = $google_url . "?secret=" . $secret . "&response=" . $_POST['g-recaptcha-response'] . "&remoteip=" . $ip;
            $res = $form->getCurlData($url);
        endif;

        if(!$form->is_valid('form_main_email','email')):
            $form->errors['form_main_email'] = true;
            $form->proceed = false;
        endif;

        if(!$form->is_valid('form_main_name')):
            $form->errors['form_main_name'] = true;
            $form->proceed = false;
        endif;

        if(!$form->is_valid('form_main_last_name')):
            $form->errors['form_main_last_name'] = true;
            $form->proceed = false;
        endif;

        if(!$form->is_valid('form_main_phone','tel')):
            $form->errors['form_main_phone'] = true;
            $form->proceed = false;
        endif;

        if(!$form->is_valid('form_main_entreprise')):
            $form->errors['form_main_entreprise'] = true;
            $form->proceed = false;
        endif;

        if(!$form->is_valid('form_main_ville')):
            $form->errors['form_main_ville'] = true;
            $form->proceed = false;
        endif;

//        if(!$form->is_valid('form_main_select')):
//            $form->errors['form_main_select'] = true;
//            $form->proceed = false;
//        endif;

        if($form->proceed):
            $form->staticVars = array(
                'form_main_email' => $form->sanitize('form_main_email'),
                'form_main_name' => $form->sanitize('form_main_name'),
                'form_main_radio_monsieur' => $form->sanitize('form_main_radio_monsieur'),
                'form_main_radio_madame' => $form->sanitize('form_main_radio_madame'),
                'form_main_last_name' => $form->sanitize('form_main_last_name'),
                'form_main_phone' => $form->sanitize('form_main_phone'),
                'form_main_entreprise' => $form->sanitize('form_main_entreprise'),
                'form_main_ville' => $form->sanitize('form_main_ville'),
                'form_main_checkbox_secu_gratuit' => $form->sanitize('form_main_checkbox_secu_gratuit'),
                //'form_main_subject' => $form->sanitize('form_main_subject'),
                'form_main_select' => $form->sanitize('form_main_select'),
                'form_main_message' => $form->sanitize('form_main_message'),
                'date' => date("Y-m-d H:i:s"),
                'ip' => $_SERVER['REMOTE_ADDR'],
            );

            //$emailSubject = $form->staticVars['form_main_subject'];
            $emailSubject = $form->emailSubject;

            $emailMessage = "";
            $emailMessage .= "<html><body>";
            $emailMessage .= "<table width='700' border='0' cellspacing='0' cellpadding='0' style='margin:0 auto;'>";


            $emailMessage .= "<tr>";
            $sex = ($form->staticVars['form_main_radio_monsieur'] == 'on'? "monsieur" : "madame");
            $emailMessage .= "<td width='250'><strong>Sex</strong></td>";
            $emailMessage .= "<td width='450'>{$sex}</td>";
            $emailMessage .= "</tr>";

            $emailMessage .= "<tr>";
            $emailMessage .= "<td width='250'><strong>{$form->placeholder['form_main_name']}</strong></td>";
            $emailMessage .= "<td width='450'>{$form->staticVars['form_main_name']}</td>";
            $emailMessage .= "</tr>";


            $emailMessage .= "<tr>";
            $emailMessage .= "<td width='250'><strong>{$form->placeholder['form_main_last_name']}</strong></td>";
            $emailMessage .= "<td width='450'>{$form->staticVars['form_main_last_name']}</td>";
            $emailMessage .= "</tr>";


            $emailMessage .= "<tr><td>&nbsp;</td><td>&nbsp;</td></tr>";
            $emailMessage .= "<tr>";
            $emailMessage .= "<td width='250'><strong>{$form->placeholder['form_main_email']}</strong></td>";
            $emailMessage .= "<td width='450'>{$form->staticVars['form_main_email']}</td>";
            $emailMessage .= "</tr>";


            $emailMessage .= "<tr><td>&nbsp;</td><td>&nbsp;</td></tr>";
            $emailMessage .= "<tr>";
            $emailMessage .= "<td width='250'><strong>{$form->placeholder['form_main_phone']}</strong></td>";
            $emailMessage .= "<td width='450'>{$form->staticVars['form_main_phone']}</td>";
            $emailMessage .= "</tr>";


            $emailMessage .= "<tr><td>&nbsp;</td><td>&nbsp;</td></tr>";
            $emailMessage .= "<tr>";
            $emailMessage .= "<td width='250'><strong>Entreprise</strong></td>";
            $emailMessage .= "<td width='450'>{$form->staticVars['form_main_entreprise']}</td>";
            $emailMessage .= "</tr>";


            $emailMessage .= "<tr><td>&nbsp;</td><td>&nbsp;</td></tr>";
            $emailMessage .= "<tr>";
            $emailMessage .= "<td width='250'><strong>Ville</strong></td>";
            $emailMessage .= "<td width='450'>{$form->staticVars['form_main_ville']}</td>";
            $emailMessage .= "</tr>";

            $emailMessage .= "<tr><td>&nbsp;</td><td>&nbsp;</td></tr>";
            $emailMessage .= "<tr>";
            $emailMessage .= "<td width='250'><strong>Sécurité gratuite</strong></td>";
            $emailMessage .= "<td width='450'>{$form->staticVars['form_main_checkbox_secu_gratuit']}</td>";
            $emailMessage .= "</tr>";


            $emailMessage .= "<tr><td>&nbsp;</td><td>&nbsp;</td></tr>";
            $emailMessage .= "<tr>";
            $emailMessage .= "<td width='250'><strong> Message </strong></td>";
            $emailMessage .= "<td width='450'>{$form->staticVars['form_main_message']}</td>";
            $emailMessage .= "</tr>";


            $emailMessage .= "</table>";
            $emailMessage .= "</html></body>";

            $headers = array();
            $headers[] = "From: {$form->sendFromName} <{$form->sendFromAddr}>";
            $headers[] = "Reply-To: {$form->staticVars['form_main_name']} <{$form->staticVars['form_main_email']}>";
            $headers[] = 'X-Mailer: PHP/' . phpversion();
            add_filter( 'wp_mail_content_type', 'set_html_content_type' );
            $hasEmailed = wp_mail( $form->sendTo, $emailSubject, $emailMessage, $headers);
            remove_filter( 'wp_mail_content_type', 'set_html_content_type' );

        endif;
    endif;
endif;
?>

<!--newsletter-->
<?php   $errorVals_newsletter = array(

    'form_name'  => array(
        'required' => __('This field is required', 'Form', themeDomain())
    ),
    'form_main_name'  => array(
        'required' => __('This field is required', 'Form', themeDomain())
    ),
    'form_main_select'  => array(
        'required' => __('This field is required', 'Form', themeDomain())
    ),
    'form_main_last_name'  => array(
        'required' => __('This field is required', 'Form', themeDomain())
    ),
    'form_main_email_newsletter' => array(
        'required'  => __('This field is required', 'Form', themeDomain()),
        'valid' => __('Email not valid', 'Form', themeDomain()),
    ),
);

$placeholder_newsletter = array(
    'form_main_name'  => __('First Name*', 'Form', themeDomain()),
    'form_main_last_name'  => __('Last Name*', 'Form', themeDomain()),
    'form_main_email_newsletter' => __('Your email*', 'Form', themeDomain()),
    'form_main_phone' => __('Phone*', 'Form', themeDomain()),
    'form_main_subject' => __('Subject', 'Form', themeDomain()),
    'form_main_select' => __('', 'Form', themeDomain()),
    'form_main_message' => __('Your message', 'Form', themeDomain()),

    'form_email' => __('Email', 'Form', themeDomain()),
    'form_name'  => __('Full name', 'Form', themeDomain()),
);
if($lang== 'en'){
    $infolettre= 'Newsletter';
}else{
    $infolettre= 'Infolettre';
}
$emailSetting_newsletter = array(
    'sendTo'=>'reception@entreprisesls.com',
    'sendFromName'=>'LS',
    'emailSubject'=> 'LS '.$infolettre,
);

$form_news= new form_builder(get_lang_active(),$errorVals_newsletter,$placeholder_newsletter,$emailSetting_newsletter);

$hasEmailed_news = false;
if(!empty($form_news->request)):


    if(isset($form_news->request['form_main_submit_news'])):


        if(!$form_news->is_valid('form_main_email_newsletter','email')):
            $form_news->errors['form_main_email_newsletter'] = true;
            $form_news->proceed = false;
        endif;


//        if(!$form->is_valid('form_main_select')):
//            $form->errors['form_main_select'] = true;
//            var_dump('ef');
//            $form->proceed = false;
//        endif;

        if($form_news->proceed):
            $form_news->staticVars = array(
                'form_main_email_newsletter' => $form_news->sanitize('form_main_email_newsletter'),
                'form_main_name' => $form_news->sanitize('form_main_name'),
                'form_main_last_name' => $form_news->sanitize('form_main_last_name'),
                'form_main_phone' => $form_news->sanitize('form_main_phone'),
                //'form_main_subject' => $form->sanitize('form_main_subject'),
                'form_main_select' => $form_news->sanitize('form_main_select'),
                'form_main_message' => $form_news->sanitize('form_main_message'),
                'date' => date("Y-m-d H:i:s"),
                'ip' => $_SERVER['REMOTE_ADDR'],
            );

//            $emailSubject = $form->staticVars['form_main_subject'];
            $emailSubject = $form_news->emailSubject;

            $emailMessage = "";
            $emailMessage .= "<html><body>";
            $emailMessage .= "<table width='700' border='0' cellspacing='0' cellpadding='0' style='margin:0 auto;'>";


            $emailMessage .= "<tr><td>&nbsp;</td><td>&nbsp;</td></tr>";
            $emailMessage .= "<tr>";
            $emailMessage .= "<td width='250'><strong>Email</strong></td>";
            $emailMessage .= "<td width='450'>{$form_news->staticVars['form_main_email_newsletter']}</td>";
            $emailMessage .= "</tr>";




            $emailMessage .= "</table>";
            $emailMessage .= "</html></body>";

            $headers = array();
            $headers[] = "From: {$form_news->sendFromName} <{$form_news->sendFromAddr}>";
            $headers[] = "Reply-To: {$form_news->staticVars['form_main_name']} <{$form_news->staticVars['form_main_email']}>";
            $headers[] = 'X-Mailer: PHP/' . phpversion();
            add_filter( 'wp_mail_content_type', 'set_html_content_type' );
            $hasEmailed_news = wp_mail( $form_news->sendTo, $emailSubject, $emailMessage, $headers);
            remove_filter( 'wp_mail_content_type', 'set_html_content_type' );

        endif;
    endif;
endif; ?>


<!--FORM-->

<?php if(!$hasEmailed):;?>
    <div id ="contactFormSection">
        <form action="<?php the_permalink();?>" method="post" id="form_contact_main" role="form">
            <label class="radio-inline">
                <?php $form->create('form_main_radio_monsieur', array('type'=>'radio', 'placeholder'=> true, 'required'=> false,'class'=>''));?><?php $form->get_error_label('form_main_select'); ?> <?php _e('Mr.','ls') ; ?>
            </label>
            <label class="radio-inline">
                <?php $form->create('form_main_radio_madame', array('type'=>'radio', 'placeholder'=> true, 'required'=> false,'class'=>''));?><?php $form->get_error_label('form_main_select'); ?> <?php _e('Mme','ls') ; ?>
            </label>
            <div class="col-md-12 row top ">
                <div class="row">
                    <div class="form-group col-md-6"><?php $form->create('form_main_name', array('type'=>'text','placeholder'=> true, 'required'=> true,'class'=>'form-control'));?><?php $form->get_error_label('form_main_name'); ?></div>
                    <div class="form-group pull-md-right col-md-6"><?php $form->create('form_main_last_name', array('type'=>'text','placeholder'=> true, 'required'=> true,'class'=>'form-control'));?><?php $form->get_error_label('form_main_last_name'); ?></div>
                    <div class="form-group col-md-6"> <?php $form->create('form_main_entreprise', array('type'=>'text','placeholder'=> true, 'required'=> true,'class'=>'form-control '));?><?php $form->get_error_label('form_main_entreprise'); ?></div>
                    <div class="form-group col-md-6" id="conact_form_select"><?php $form->create('form_main_select', array('type'=>'select', 'placeholder'=> true, 'required'=> true,'class'=>'form-control','options'=>array('country'=>'en')));?><?php $form->get_error_label('form_main_select'); ?></div>
                    <div class="form-group  col-md-6 pull-md-right"><?php $form->create('form_main_ville', array('type'=>'text','placeholder'=> true, 'required'=> true,'class'=>'form-control'));?><?php $form->get_error_label('form_main_ville'); ?></div>
                    <div class="form-group col-md-6"><?php $form->create('form_main_phone', array('type'=>'tel', 'placeholder'=> true, 'required'=> true,'class'=>'form-control'));?><?php $form->get_error_label('form_main_phone'); ?></div>
                    <div class="form-group col-md-6 pull-md-right"><?php $form->create('form_main_email', array('type'=>'email', 'placeholder'=> true, 'required'=> true,'class'=>'form-control '));?><?php $form->get_error_label('form_main_email'); ?></div>
                </div>
            </div>
            <div class="col-md-12 row bottom">
                <?php $form->create('form_main_message', array('type'=>'textarea', 'placeholder'=> true, 'required'=> false,'class'=>'form-control'));?><?php $form->get_error_label('form_main_message'); ?>
            </div>
            <div class="checkbox">
                <label>
                    <?php $form->create('form_main_checkbox_secu_gratuit', array('type'=>'checkbox', 'placeholder'=> true, 'required'=> true,'class'=>''));?><?php $form->get_error_label('form_main_select'); ?>
                    <?php _e(' I wish to receive the free LS Secure inspection','ls') ; ?> <span class="logo"></span>
                </label>
            </div>

            <div style="margin-bottom: 10px;"><?php _e('* Request field','ls') ; ?></div>

            <div class="clearfix"></div>
            <div class="g-recaptcha col-md-12"
                 data-callback="fill_field"
                 data-sitekey="<?php echo $form->recaptcha['site_key']; ?>"></div>
            <input type="hidden" name="recaptcha_passed" id="recaptcha_passed_id"/>
            <?php $form->get_error_label('recaptcha_passed'); ?>
            <div class="clearfix"></div>

            <fieldset>
                <button type="submit" name="form_main_submit" value="Submit" class="btn ls-btn btn-large submit red " ><?php _e('submit','ls') ; ?></button>
            </fieldset>

            <?php //wp_nonce_field( 'submit_contact_form' , 'nonce_field_for_submit_contact_form'); ?>

        </form>
    </div>
<?php else: ?>
    <script type="text/javascript">
        //document.location.href="<?php //echo get_permalink(get_page_id('thanks')); ?>";
    </script>
    <div id="form_contact_main" class="input-wrapper contact-success margin-top">
        <div style="margin-top:130px"></div>
        <p class='padding-top padding-bottom color-black align-center margin-top'><strong><?php
                _e('Thank you for contacting us. A representative will get back to you shortly.', 'ls');
                ?></strong></p>
    </div>
<?php endif;?>
<script type="text/javascript">
    function fill_field() {
        $("#recaptcha_passed_id").val('1')
    }
    jQuery(document).ready(function(){
        <?php if((!$form->proceed || $hasEmailed) && isset($form->request['form_main_submit'])):?>
        functions.pageScroll("#form_contact_main");
        <?php endif;?>
        jQuery("#form_contact_main").validate({
            rules         : {
                form_main_name    : {
                    required : true,
                    minlength: 2 },
                form_main_entreprise    : {
                    required : true,
                    minlength: 2 },
                form_main_ville    : {
                    required : true,
                    minlength: 2 },
                form_main_last_name    : {
                    required : true,
                    minlength: 2 },
                form_main_email    : {
                    required : true,
                    email    : true,
                    minlength: 5 },
                form_main_phone: {
                    required : true,
                    number: true,
                    phonevalidation: true,
                    minlength: 10,
                    maxlength: 10,
                },
//                                        form_main_subject    : {
//                                            required : true,
//                                            minlength: 2
//                                         },
                recaptcha_passed: {
                    required: function() {
                        if(grecaptcha.getResponse() == '') {
                            return true;
                        } else {
                            return false;
                        }
                    }
                },
            },
            messages      : {
                form_main_email    : {
                    required: "<?php echo $form->errorVals['form_main_email']['required'];?>",
                    email   : "<?php echo $form->errorVals['form_main_email']['valid'];?>"
                },
                form_main_name    : {
                    required: "<?php echo $form->errorVals['form_main_name']['required'];?>",
                },
                form_main_entreprise    : {
                    required: "<?php echo $form->errorVals['form_main_entreprise']['required'];?>",
                },
                form_main_ville    : {
                    required: "<?php echo $form->errorVals['form_main_ville']['required'];?>",
                },
                form_main_last_name    : {
                    required: "<?php echo $form->errorVals['form_main_last_name']['required'];?>",
                },
                form_main_subject    : {
                    required: "<?php echo $form->errorVals['form_main_name']['required'];?>",
                },
                form_main_phone    : {
                    required: "<?php echo $form->errorVals['form_main_phone']['required'];?>",
                    minlength:"<?php echo $form->errorVals['form_main_phone']['minlength'];?>",
                    maxlength:"<?php echo $form->errorVals['form_main_phone']['max'];?>"

                },
                recaptcha_passed    : {
                    required: "<?php echo $form->errorVals['recaptcha_passed']['required'];?>",
                },

            },
            errorPlacement: function (error, element) {
                error.appendTo(element.closest('div'));
            }

        });
        $.validator.addMethod("phonevalidation",
            function(value, element) {
                return /^[A-Za-z\d=#$%@_ -]+$/.test(value);
            },
            "Please enter a valid phone number."
        );
    });
</script>





<!--Newsletter form-->


<?php if(!$hasEmailed_news):;?>
    <form action="<?php the_permalink();?>" method="get" id="form_contact_main_news">
        <?php  $form_news->create('form_main_email_newsletter', array('type'=>'email','field_id'=>'search', 'placeholder'=> true, 'required'=> true,));?>
        <button type="submit" name="form_main_submit_news" value="submit" class="icon send_news"><?php _e('Send','ls') ; ?></button>
        <?php $form_news->get_error_label('form_main_email_newsletter'); ?>
    </form>
<?php else: ?>
    <script type="text/javascript">
        //document.location.href="<?php //echo get_permalink(get_page_id('thanks')); ?>";
    </script>
    <div id="form_contact_main_news" class="input-wrapper contact-success">
        <p class=' color-white align-center text-center ' style="font-size: 11px;"><strong><?php
                _e('Thank you for contacting us. <br/>A representative will get back to you shortly.', 'ls');
                ?></strong></p>
    </div>
<?php endif;?>
<script type="text/javascript">

    jQuery(document).ready(function(){
        <?php if((!$form_news->proceed || $hasEmailed_news) && isset($form_news->request['form_main_submit_news'])):?>
        functions.pageScroll("#form_contact_main_news");
        <?php endif;?>
        jQuery("#form_contact_main_news").validate({
            rules         : {
//                                                    form_main_name    : {
//                                                        required : true,
//                                                        minlength: 2 },
//                                                    form_main_select    : {
//                                                        required : true,
//                                                        minlength: 2 },
//                                                    form_main_last_name    : {
//                                                        required : true,
//                                                        minlength: 2 },
                form_main_email_newsletter    : {
                    required : true,
                    email    : true,
                    minlength: 5 },
            },
            messages      : {
                form_main_email_newsletter    : {
                    required: "<?php echo $form_news->errorVals['form_main_email_newsletter']['required'];?>",
                    email   : "<?php echo $form_news->errorVals['form_main_email_newsletter']['valid'];?>"
                },
//                                                    form_main_name    : {
//                                                        required: "<?php //echo $form->errorVals['form_main_name']['required'];?>//",
//                                                    },
//                                                    form_main_last_name    : {
//                                                        required: "<?php //echo $form->errorVals['form_main_last_name']['required'];?>//",
//                                                    },
//                                                    form_main_select    : {
//                                                        required: "<?php //echo $form->errorVals['form_main_name']['required'];?>//",
//                                                    },

            },
            errorPlacement: function (error, element) {
                error.appendTo(element.closest('form'));
            }

        });
    });
</script>

