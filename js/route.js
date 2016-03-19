requirejs(['jquery', 'bootstrap', 'loginModule', 'nanoscroller', 'videojs'],
    function(jquery, bootstrap, LoginModule, Scroller, VideoJs) {

        //验证登录状态
        var userInfo = LoginModule.verifyLogin(),
            ifLogin = userInfo.ifLogin;       //@ATTENTION: 这里的ifLogin是字符串而不是boolean！


        //scroller srtup
        $('.nano').nanoScroller({
            preventPageScrolling: true
        });

        //video setup
        var videoSetup = (function(){
            var option = {
                    "controls": true,
                    "autoplay": false,
                    "preload": "none",
                    "width": "100%",
                };

                VideoJs('#js_video', option);
        }());
    });