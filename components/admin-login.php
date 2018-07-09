<?php
/**
 * Admin login style
 *
 */

 function cd_login_logo() { ?>
  <style type="text/css">
    body.login {
      height: 100%;
      width: 100%;
      display: flex;
      align-items: center;
      justify-content: center;
    }
    body.login div#login {
      padding: 80px 20px;
      margin: 0;
    }

    body.login div#login h1 {}

    body.login div#login h1 a {
      background-image: url(<?php echo get_bloginfo('template_url'); ?>/assets/images/main-logo.png);
      height:100px;
      width:100%;
      background-size: auto 100%;
      background-repeat: no-repeat;
      padding-bottom: 30px;
    }

    body.login div#login .message, body.login div#login #login_error {
      box-shadow: none;
    }

    body.login div#login form {
      box-shadow: none;
      padding: 20px;
      margin-bottom: 20px;
    }
    body.login div#login form#loginform p {}
    body.login div#login form p label {
      font-size: 12px;
      letter-spacing: 0.3px;
      line-height: 1.2;
      text-transform: uppercase;
    }
    body.login div#login form input {
      margin-top: 10px;
      font-size: 16px;
      padding: 8px 15px;
      box-shadow: none;
      border: 1px solid #f1f1f1;
    }
    body.login div#login form input[type="checkbox"] {
      margin-top: 0;
      font-size: 16px;
      padding: 0;
      box-shadow: none;
    }
    body.login div#login form input#user_login {}
    body.login div#login form input#user_pass {}

    body.login div#login form p.forgetmenot {
      padding-top: 15px;
    }

    body.login div#login form p.forgetmenot label {
      display: flex;
      align-items: center;
    }

    body.login div#login form p.forgetmenot input {
      margin-right: 8px;
    }

    body.login div#login form p.submit {
    }

    body.login div#login form p.submit input#wp-submit {
      background-color: #9ca66e;
      border: 1px solid #9ca66e;
      color: #ffffff;
      font-size: 12px;
      text-transform: uppercase;
      padding: 5px 15px;
      height: auto;
      border-radius: 0;
      text-shadow: none;
      font-weight: 400;
      letter-spacing: 1px;
      transition: all 0.5s ease;
    }

    body.login div#login form p.submit input#wp-submit:hover {
      background-color: transparent;
      color: #9ca66e;
    }

    body.login div#login p#nav, body.login div#login p#backtoblog {
      text-align: center;
      padding: 4px 20px;
      margin: 0;
    }

    body.login div#login p#nav a, body.login div#login p#backtoblog a {
      transition: all 0.5s ease;
    }

    body.login div#login p#nav a:hover, body.login div#login p#backtoblog a:hover {
      color: #9ca66e;
    }
  </style>
 <?php }
 add_action( 'login_enqueue_scripts', 'cd_login_logo' );
