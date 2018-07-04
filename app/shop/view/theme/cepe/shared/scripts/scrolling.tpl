<script id="scrolling" async>
    var scroll = (function ($, window, undefined) {
        var $win = $(window);
        var winHeight = $win.height();
        var defaultOffetFactor = 0.2;

        var init = function (options) {
            var segments = buildSegments(options).sort(sortByOffsetTop);
            events.onScroll(segments);
            events.onResize();
        };

        var buildSegments = function (segments){
            var id = 0;
            return segments.map(function (segment) {
                var $ref = $(segment.target);
                if ($ref.length) {
                    var offsetTop = ~~$ref.offset().top;
                    var height = $ref.height();
                    return {
                        id: id++,
                        $ref: $ref,
                        height: height,
                        offsetTop: offsetTop,
                        bottom: offsetTop + height,
                        pointView: offsetTop + (height * (segment.factor || defaultOffetFactor)),
                        trigger: segment.trigger,
                    };
                }
            }).filter(Boolean);
        };

        var sortByOffsetTop = function (a, b) {
            return a.offsetTop > b.offsetTop;
        };

        var events = {
            onScroll: function (segments) {
                var scrolled = false;
                var current;
                $win.scroll(function () {
                    scrolled = true;
                });
                setInterval(function () {
                    if (scrolled) {
                        scrolled = false;
                        if (segments.length) {
                            current = isViewed(segments);
                            if (current) {
                                current.$ref.addClass(current.trigger);
                            }
                        }
                    }
                }, 60);
            },
            onResize: function () {
                var timeoutID;
                $win.resize(function () {
                    if (timeoutID) {
                        clearTimeout(timeoutID);
                        timeoutID = void 0;
                    }
                    timeoutID  = setTimeout(function () {
                        winHeight = $win.height();
                    }, 250);
                });
            }
        };

        var isViewed = function (segments) {
            var scrollOffsetTop = $win.scrollTop();
            var viewPos = scrollOffsetTop + winHeight;
            var viewed = segments.filter(function (segment) {
                return segment.pointView <= viewPos &&
                       segment.bottom >= scrollOffsetTop + (winHeight * defaultOffetFactor);

            })[0];
            return viewed;
        };

        return {
            init: init
        };
    })(jQuery, window, undefined);

    if (Modernizr.mq('only screen and (min-' + 'width: 62.3em)')) {
        scroll.init([
            {
                target: '.home-text',
                trigger: 'run'
            },
            {
                target: '.home-products',
                trigger: 'run',
            },
            {
                target: '.home-services',
                trigger: 'run',
            },
            {
                target: '.home-map',
                trigger: 'run',
            },
            {
                target: '.home-gallery',
                trigger: 'run',
            },
        ]);
    }
</script>
