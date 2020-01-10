<!-- Load Facebook SDK for JavaScript -->
<!-- Load Facebook SDK for JavaScript -->
<div id="fb-root"></div>
<script>
window.fbAsyncInit = function() {
    FB.init({
		appId            : "{{ ENV('FACEBOOK_APP_ID') }}",
        xfbml            : true,
        autoLogAppEvents : true,
        version          : 'v2.12'
    });
};

(function(d, s, id) {
  var js, fjs = d.getElementsByTagName(s)[0];
  if (d.getElementById(id)) return;
  js = d.createElement(s); js.id = id;
  js.src = "https://connect.facebook.net/en_US/sdk/xfbml.customerchat.js";
  fjs.parentNode.insertBefore(js, fjs);
}(document, 'script', 'facebook-jssdk'));
</script>

<div class="fb-customerchat"
	attribution="Phsar24"
 	page_id="{{ ENV('FACEBOOK_PAGE_ID') }}"
 	theme_color="#459645"
 	logged_in_greeting="Hi! How can we help you?"
 	logged_out_greeting="GoodBye!... Hope to see you soon.">
</div>


