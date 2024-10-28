<?php settings_errors(); ?>
<div class="accestype-82816">
  <div class="accesstype-admin-wrapper">
    <div class="accesstype-admin-container">
      <h1 class='accesstype-title'>Accesstype Subscriptions</h1>
      <div class="accesstype-settings-container">
        <div class="accesstype-tab">
          <div class="accesstype-tablinks active" onclick="accesstypeChangeTab(event, 'accesstype-basic-settings')">Basic Settings</div>
          <div class="accesstype-tablinks" onclick="accesstypeChangeTab(event, 'accesstype-configure')">Configure</div>
          <div class="accesstype-tablinks" onclick="accesstypeChangeTab(event, 'accesstype-help')">Help</div>
        </div>
        <div id="accesstype-basic-settings" class="accesstype-tabcontent accesstype-basic-settings">
          <div class="accesstype-connect">
            <p class="accesstype-connect-message">To connect to your accesstype account just paste in the respective Account key and User JWT token key in the fields below and save. </p>
            <p class="accesstype-connect-message">Your keys are available in your accesstype dashboard under General Settings. </p>
          </div>
          <form method="post" action="options.php">
            <?php settings_fields( 'accesstype-settings' ); ?>
            <div class="accesstype-admin-container__input">
              <p class="input-label">Account Key</p>
              <input type="password" class="accesstype-settings-input" required name="accesstype-account-key" value="<?php echo get_option('accesstype-account-key'); ?>"/>
            </div>
            <div class="accesstype-admin-container__input">
              <p class="input-label">User JWT Secret Token</p>
              <input type="password" class="accesstype-settings-input" required name="accesstype-jwt-secret" value="<?php echo get_option('accesstype-jwt-secret'); ?>"/>
            </div>
            <div>
              <p class="accesstype-detail-documentation">For detailed instructions please check the <a href="javascript:void(0);" onclick="accesstypeChangeTab(event, 'accesstype-help')" class="accesstype-documentation-link">Accesstype Plugin Help section.</a></p>
            </div>
            <?php submit_button('Save', 'accesstype-submit-button'); ?>
          </form>
        </div>
        <div id="accesstype-configure" class="accesstype-tabcontent accesstype-configure">
          <form method="post" action="options.php">
            <?php settings_fields( 'accesstype-configure' ); ?>
            <table class='accesstype-configure-container'>
              <tr >
                <th>
                  Page for Subscription Plans listing *
                </th>
                <td>
                  <?php echo wp_dropdown_pages( array( 'name' => 'accesstype-subscription-plan-page', 'echo' => 0, 'show_option_none' => __( '&mdash; Select &mdash;' ), 'option_none_value' => '0', 'class' => 'accesstype-settings-input', 'selected' => get_option('accesstype-subscription-plan-page') ) ); ?>
                  <p class="description">Add this shortcode to your subscription plans page: [accesstype_display_subscription_plans]</p>
                </td>
              </tr>
              <tr >
                <th>
                  Page for Login
                </th>
                <td>
                  <?php echo wp_dropdown_pages( array( 'name' => 'accesstype-login-redirect-page', 'echo' => 0, 'show_option_none' => __( '&mdash; Select &mdash;' ), 'option_none_value' => '0', 'class' => 'accesstype-settings-input', 'selected' => get_option('accesstype-login-redirect-page') ) ); ?>
                  <p class="description">(Non logged in users will redirect to this page when they try to purchase subscription. Default redirect url will be '/login')</p>
                </td>
              </tr>
              <tr >
                <th>
                Page for My Subscriptions
                </th>
                <td>
                <p class="description">Add this shortcode to your my subscriptions page: [accesstype_display_subscriptions] </p>
                </td>
              </tr>
            </table>
            <div class='accesstype-additional-settings'>
              <div class='accesstype-additional-settings-text'>
                Additional Settings <div class='accesstype-arrows'><span class='accesstype-arrow accesstype-down' onclick="clickExpand()"></span> <span class='accesstype-arrow accesstype-up accesstype-hidden' onclick="clickCollapse()"></span></div>
              </div>

              <div class='accesstype-additional-settings-content accesstype-hidden'>
                <table class='accesstype-configure-container'>
                  <tr>
                    <th>Primary color</th>
                    <td>
                      <input type="text" name="accesstype-primary-color" value="<?php echo get_option('accesstype-primary-color') ?>" class="accesstype-color-field" />
                      <p class="description"v>
                        Change this if you want to customize the primary color. 
                      </p>
                    </td>
                  </tr>
                  <tr>
                    <th>Secondary color</th>
                    <td>
                      <input type="text" name="accesstype-secondary-color" value="<?php echo get_option('accesstype-secondary-color') ?>" class="accesstype-color-field" />
                      <p class="description">
                        Change this if you want to customize the secondary color. 
                      </p>
                    </td>
                  </tr>
                  <tr>
                    <th>Restriction Post Container</th>
                    <td>
                      <input type="text" class="accesstype-settings-input" required name="accesstype-post-restriction-selector" value="<?php echo get_option('accesstype-post-restriction-selector') ?>" />
                        <p class="description">CSS selector of the container that contains the content on a post and custom post type. Change this if the paywall banner is not appearing correctly.</p>
                    </td>
                  </tr>
                  <tr>
                    <th>Number of HTML Elements</th>
                    <td>
                      <input type="number" class="accesstype-settings-input" required name="accesstype-lead-in-elements" value="<?php echo get_option('accesstype-lead-in-elements') ?>" />
                        <p class="description">Number of HTML elements (paragraphs, images, etc.) to show before displaying the paywall banner to end user.</p>
                    </td>
                  </tr>
                  <tr>
                    <th>Subscription Plan Listing Heading</th>
                    <td>
                      <textarea class="accesstype-settings-input" name="accesstype-plan-heading" maxlength="100"><?php echo get_option('accesstype-plan-heading') ?> </textarea> 
                      <p class="description">
                        Change this if you want to change the heading of subscription plan component
                      </p>
                    </td>
                  </tr>
                  <tr>
                    <th>Subscription Plan Listing Sub Heading</th>
                    <td>
                      <textarea class="accesstype-settings-input" name="accesstype-plan-sub-heading" maxlength="500"><?php echo get_option('accesstype-plan-sub-heading') ?></textarea> 
                      <p class="description">
                        Change this if you want to change the sub heading of subscription plan component
                      </p>
                    </td>
                  </tr>
                </table>
              </div>
            </div>
            <div>
              <p class="accesstype-detail-documentation">For detailed instructions please check the <a href="javascript:void(0);" onclick="accesstypeChangeTab(event, 'accesstype-help')" class="accesstype-documentation-link">Accesstype Plugin Help section.</a></p>
            </div>
            <?php submit_button('Save', 'accesstype-submit-button'); ?>
          </form>
        </div>
        <div id="accesstype-help" class="accesstype-tabcontent accesstype-help">
          <p>Accesstype plugin allows you to accept payments from your users on your website. The subscription plans and amount shown will be the same as configured in your Accesstype account.</p>
          <h3><strong>Prerequisites for using the plugin:</strong></h3>
          <ol class="help-heading">
            <li>Have an active Accesstype account.</li>
            <li>If you do not have an Accesstype account write to <a href="mailto:​accesstype@quintype.com​">​accesstype@quintype.com​</a> and we will help you create one.</li>
            <li>Have a payment gateway account. If you do not have any payment gateway accounts please create one from the ones supported by Accesstype [RazorPay, Stripe, PayPal].</li>
            <li>Install plugin of your choice to manage user registration and login on your website.</li>
          </ol>
          <h3><strong>How to connect the Plugin​ with Accesstype account:</strong></h3>
          <ol class="help-heading">
            <li>Login to the your Accesstype account.</li>
            <li>Navigate to the <i>Settings → General</i>.</li>
            <li>Scroll down to the Authentication Keys section.</li>
            <li>Copy the Account key and User JWT secret token from the respective section.</li>
            <li>Enter them under the Basic settings in the Plugin and click the Save button.</li>
          </ol>
          <h3><strong>How to configure the paywall:</strong></h3>
          <ol class="help-heading">
            <li>Configure plans on Accesstype</li>
            <ol class="list-style-lower-alpha">
              <li>Login to the Accesstype account.</li>
              <li>Navigate to the <i>Groups and Plans → Manage → Create New Groups</i>.</li>
              <li>Create new plan by entering the plan amount & duration.</li>
              <li>Can make it either a one time or recurring plan.</li>
            </ol>
            <li>Configure payment gateway on Accesstype</li>
            <ol class="list-style-lower-alpha">
              <li>Login to your Accesstype account.</li>
              <li>Navigate to <i>Configure → Payment Gateways section</i>.</li>
              <li>Enter the details for the payment gateway of your choice and save.</li>
            </ol>
            <li>Create SubscriptionPlans page</li>
            <ol class="list-style-lower-alpha">
              <li>Create a page</li>
              <li>Add <i>[accesstype_display_subscription_plans]</i> shortcode to it and save.</li>
              <li>Navigate to Accesstype plugin settings, set the SubscriptionPlans page that you just created as <i>Page for Subscription Plans listing</i></li>
            </ol>
            <li>Mark posts as behind paywall</li>
            <ol class="list-style-lower-alpha">
              <li>Navigate to Posts from sidebar</li>
              <li>Go to the post that you want to put behind paywall and set accesstype-visibility to  subscription.</li>
              <li>You can also use bulk edit or quick edit for updating the accesstype-visibility for multiple posts.</li>
            </ol>
          </ol>
          <h3><strong>How to configure metering:</strong></h3>
          <ol class="help-heading">
            <li>Configure metering on Accesstype</li>
            <ol class="list-style-lower-alpha">
              <li>Login to your Accesstype account.</li>
              <li>Navigate to <i>Configure → Metered Paywall Setting</i> section.</li>
              <li>Enter the details in the configuration page and save.</li>
            </ol>
          </ol>
        </div>
      </div>
    </div>
  </div>
</div>