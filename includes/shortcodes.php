<?php

  /**
  * fetch subscriptions of current logged in user
  *
  * @since 1.0
  */

  function accesstype_display_subscriptions() {
    $jwt_token = get_accesstype_jwt_token();
    $primary_color = get_option('accesstype-primary-color');
    $secondary_color = get_option('accesstype-secondary-color');

    $results = '';

    $results .= '<div id="accesstype-my-subscriptions"></div>';

    $results .=  "<script type='text/javascript'>
      const mySubscirptionElement = document.getElementById('accesstype-my-subscriptions');
      var jwt = '" . $jwt_token . "';
      var primaryColor = '" . $primary_color . "';
      var secondaryColor = '" . $secondary_color . "';
      const mySubscirptionConfig = {
        user: {
          accesstypeJwt: jwt || null,
        },
        custom: {
          styles: {
            'primary-clr': primaryColor,
            'secondary-clr': secondaryColor,
          }
        },
      }
      runAccesstypeUI(function () {
        accesstypeUI.displaySubscriptions(mySubscirptionElement, mySubscirptionConfig);
      });
    </script>";

    return $results;
  }
  add_shortcode( 'accesstype_display_subscriptions', 'accesstype_display_subscriptions' );


  /**
  * fetch subscription plans of account
  *
  * @since 1.0
  */

  function accesstype_display_subscription_plans() {
    $jwt_token = get_accesstype_jwt_token();
    $primary_color = get_option('accesstype-primary-color');
    $secondary_color = get_option('accesstype-secondary-color');
    $plan_heading = get_option('accesstype-plan-heading');
    $plan_sub_heading = get_option('accesstype-plan-sub-heading');
    $login_page_url = custom_login_url();

    $results = '';
    $results .= '<div id="accesstype-subscription-plans-list"></div>';
    $results .=  "<script type='text/javascript'>
      const subscriptionPlanElement = document.getElementById('accesstype-subscription-plans-list');
      var jwt = '" . $jwt_token . "';
      var primaryColor = '" . $primary_color . "';
      var secondaryColor = '" . $secondary_color . "';
      var planHeading = '" . $plan_heading . "';
      var planSubHeading = '" . $plan_sub_heading . "';
      var loginPageUrl = '" . $login_page_url . "';

      const urlParams = new URLSearchParams(window.location.search);
      const returnUrl = urlParams.get('return-url');

      const subsriptionPlanConfig = {
        user: {
          accesstypeJwt: jwt || null
        },
        returnUrl: returnUrl,
        loginPageUrl: loginPageUrl,
        custom: {
          styles: {
            'primary-clr': primaryColor,
            'secondary-clr': secondaryColor,
          },
          subscriptionsPlanPageDetails: {
            heading: planHeading,
            subHeading: planSubHeading
          }
        },
      };

      runAccesstypeUI(function () {
        accesstypeUI.displaySubscriptionPlansList(subscriptionPlanElement, subsriptionPlanConfig);
      });
    </script>";

    return $results;
  }
  add_shortcode( 'accesstype_display_subscription_plans', 'accesstype_display_subscription_plans' );

?>