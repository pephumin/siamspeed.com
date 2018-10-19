
<div id="fb-root"></div>
<script>
  window.fbAsyncInit = function() {
    FB.init({
      appId      : '326787037445447',
      status	 : true,
      cookie	 : true,
      xfbml      : true,
      version    : 'v2.5'
    });
    FB.Event.subscribe('ad.loaded', function(placementID) {      
      console.log('Audience Network ad loaded');
      document.getElementById('ad_root').style.display = 'block';
      }
    );
    FB.Event.subscribe('ad.error', function(errorCode, errorMessage, placementID) {
	  console.log('Audience Network error (' + errorCode + ') ' + errorMessage);
      }
    );
    FB.Event.subscribe('edge.create', like);
    FB.Event.subscribe('edge.remove', unlike);
    FB.Event.subscribe('edge.create', function(targetURL) {
        ga('send', 'social', 'Facebook', 'like', targetURL);});
    FB.Event.subscribe('edge.remove', function(targetURL) {
        ga('send', 'social', 'Facebook', 'unlike', targetURL);});
    FB.Event.subscribe('message.send', function(targetURL) {
    _gaq.push(['_trackSocial', 'facebook', 'send', targetURL]);});
    FB.Event.subscribe('comment.create', function(href) {
        ga('send', 'social', 'Facebook', 'comment added', href);});
    FB.Event.subscribe('comment.remove', function(loc) {
        ga('send', 'social', 'Facebook', 'comment deleted', loc);});
  };
  (function(d, s, id){
     var js, fjs = d.getElementsByTagName(s)[0];
     if (d.getElementById(id)) {return;}
     js = d.createElement(s); js.id = id;
     js.src = "//connect.facebook.net/en_US/sdk/debug.js";
     fjs.parentNode.insertBefore(js, fjs);
   }(document, 'script', 'facebook-jssdk'));
</script>
</script>

