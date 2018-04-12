@php
    $appID = '';
    $secret = '';
    if(isset($settings['connect'])){
        $data = getCmsConnectionByID($settings['connect']);
        if($data){
            $appID = $data->client_id;
            $secret = $data->client_secret;
        }
    }
@endphp

<script>
    window.fbAsyncInit = function() {
        // init the FB JS SDK
        FB.init({
            appId      : "{{ $appID }}",                        // App ID from the app dashboard
            status     : true,                                 // Check Facebook Login status
            xfbml      : true                                  // Look for social plugins on the page
        });
        // channelUrl : '//WWW.YOUR_DOMAIN.COM/channel.html', // Channel file for x-domain comms
        // Additional initialization code such as adding Event Listeners goes here
    };

    // Load the SDK asynchronously
    (function(d, s, id){
        var js, fjs = d.getElementsByTagName(s)[0];
        if (d.getElementById(id)) {return;}
        js = d.createElement(s); js.id = id;
        js.src = "//connect.facebook.net/en_US/all.js";
        fjs.parentNode.insertBefore(js, fjs);
    }(document, 'script', 'facebook-jssdk'));

    var globalFacebookShareObject = {
        name: 'TESTING SHARE',
        link: document.URL,
        caption: 'this is caption',
        picture: 'https://static.independent.co.uk/s3fs-public/styles/article_small/public/thumbnails/image/2017/09/12/11/naturo-monkey-selfie.jpg',
        description: 'some descrition here'
    }

    function shareOnFacebook(){
        FB.ui({
            method: 'feed',
            name: globalFacebookShareObject.name,
            link: globalFacebookShareObject.link,
            caption: 'R$ '+globalFacebookShareObject.caption,
            picture: globalFacebookShareObject.picture,
            description: globalFacebookShareObject.description
        }, function(response) {
            if(response && response.post_id){}
            else{}
        });
    }
</script>



<button class="btn btn-primary" onclick='shareOnFacebook()'>Share</button>