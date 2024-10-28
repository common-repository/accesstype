document.addEventListener("DOMContentLoaded", function() {
  let mainContainer = document.querySelector(accesstype_metering.selector);
  wrapStoryIntoPaywall(mainContainer);

  var config = {
    user: {
      accesstypeJwt: accesstype_metering.jwt,
      readerIdUrl: accesstype_metering.readerIdUrl,
    },
    asset: {
      id: accesstype_metering.postId,
      type: 'story'
    },
    custom: {
      styles: {
        "primary-clr": accesstype_metering.primaryColor,
        "secondary-clr": accesstype_metering.secondaryColor
      }
    },
    subscriptionPlansPageUrl: accesstype_metering.subscriptionPlansPageUrl + `?return-url=${window.location.href}`,
    loginPageUrl: accesstype_metering.loginPageUrl
  }

  let meteringElement = document.getElementById('accesstype-paywall');
  runAccesstypeUI(function() {
    accesstypeUI.displayMeteringAndPaywall(meteringElement, config);
  })

  function wrapStoryIntoPaywall( mainContainer ) {
    let children = mainContainer.children;
    let final = '';
    for( let i=0; i < children.length; i++ ) {
      if( i == accesstype_metering.noOfElements ) {
        final = final + `<div class='accesstype-paywall-metering' id='accesstype-paywall'>`
      }
      final = final + children[i].outerHTML;
      if( i == children.length - 1 ) {
        final = final + '</div>';
      }
    }
    mainContainer.innerHTML = final;
  }
});