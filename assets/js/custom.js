function shareOnTwitter() {
    var currentPageUrl = window.location.href;
    var twitterShareUrl = "https://twitter.com/intent/tweet?text=Check%20out%20this%20product:&url=" + encodeURIComponent(currentPageUrl);
    window.open(twitterShareUrl, "_blank");
}

function shareOnFacebook() {
    var currentPageUrl = window.location.href;
    var facebookShareUrl = "https://www.facebook.com/sharer/sharer.php?u=" + encodeURIComponent(currentPageUrl);
    window.open(facebookShareUrl, "_blank");
}