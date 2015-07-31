(function(jQuery, $, window){
/*! Ajax Search pro 2.0 js */
(function ($) {
    var methods = {

        init: function (options, elem) {
            var $this = this;

            this.elem = elem;
            this.$elem = $(elem);


            $this.searching = false;
            $this.o = $.extend({}, options);
            $this.n = new Object();
            $this.n.container =  $(this.elem);
            $this.o.rid = $this.n.container.attr('id').match(/^ajaxsearchlite(.*)/)[1];
            $this.o.id = $this.n.container.attr('id').match(/^ajaxsearchlite(.*)/)[1];
            $this.n.probox = $('.probox', $this.n.container);
            $this.n.proinput = $('.proinput', $this.n.container);
            $this.n.text = $('.proinput input.orig', $this.n.container);
            $this.n.textAutocomplete = $('.proinput input.autocomplete', $this.n.container);
            $this.n.loading = $('.proinput .loading', $this.n.container);
            $this.n.proloading = $('.proloading', $this.n.container);
            $this.n.proclose = $('.proclose', $this.n.container);
            $this.n.promagnifier = $('.promagnifier', $this.n.container);
            $this.n.prosettings = $('.prosettings', $this.n.container);
            $this.n.searchsettings = $('#ajaxsearchlitesettings' + $this.o.rid);
            $this.n.resultsDiv = $('#ajaxsearchliteres' + $this.o.rid);
            $this.n.hiddenContainer = $('#asl_hidden_data');
            $this.n.aslItemOverlay = $('.asl_item_overlay', $this.n.hiddenContainer);

            $this.resizeTimeout = null;

            $this.n.showmore = $('.showmore a', $this.n.resultsDiv);
            $this.n.items = $('.item', $this.n.resultsDiv);
            $this.n.results = $('.results', $this.n.resultsDiv);
            $this.n.resdrg = $('.resdrg', $this.n.resultsDiv);

            // Isotopic Layout variables
            $this.il = {
                columns: 3,
                itemsPerPage: 6
            };

            $this.firstClick = true;
            $this.post = null;
            $this.postAuto = null;
            $this.cleanUp();
            $this.n.text.val($this.o.defaultsearchtext);
            $this.n.textAutocomplete.val('');
            $this.o.resultitemheight = parseInt($this.o.resultitemheight);
            $this.scroll = new Object();
            $this.settScroll = null;
            $this.n.resultsAppend = $('#wpdreams_asl_results_' + $this.o.id);
            $this.currentPage = 1;
            $this.isotopic = null;

            $this.animation = "bounceIn";
            switch ($this.o.resultstype) {
                case "vertical":
                    $this.animation = $this.o.vresultanimation;
                    break;
                case "isotopic":
                    $this.animation = $this.o.iianimation;
                    break;
                default:
                    $this.animation = $this.o.hresultanimation;
            }

            $this.filterFns = {
                number: function () {
                    var $parent = $(this).parent();
                    while (!$parent.hasClass('isotopic')) {
                        $parent = $parent.parent();
                    }
                    var number = $(this).attr('data-itemnum');
                    //var currentPage = parseInt($('nav>ul li.asl_active span', $parent).html(), 10);
                    var currentPage = $this.currentPage;
                    //var itemsPerPage = parseInt($parent.data("itemsperpage"));
                    var itemsPerPage = $this.il.itemsPerPage;

                    return (
                        (parseInt(number, 10) < itemsPerPage * currentPage) &&
                            (parseInt(number, 10) >= itemsPerPage * (currentPage - 1))
                        );
                },
            };

            $this.disableMobileScroll = false;


            $this.n.searchsettings.detach().appendTo("body");

            if ($this.o.resultsposition == 'hover') {
                $this.n.resultsDiv.detach().appendTo("body");
            } else if ($this.n.resultsAppend.length > 0) {
                $this.n.resultsDiv.detach().appendTo($this.n.resultsAppend);
            }

            if ($this.o.resultstype == 'horizontal') {
                $this.createHorizontalScroll();
            } else if ($this.o.resultstype == 'vertical') {
                $this.createVerticalScroll();
            }

            if ($this.o.resultstype == 'polaroid')
                $this.n.results.addClass('photostack');

            if (detectIE())
                $this.n.container.addClass('asl_msie');
            $this.initEvents();

            return this;
        },

        duplicateCheck: function() {
            var $this = this;
            var duplicateChk = {};

            $('div[id*=ajaxsearchlite]').each (function () {
                if (duplicateChk.hasOwnProperty(this.id)) {
                    $(this).remove();
                } else {
                    duplicateChk[this.id] = 'true';
                }
            });
        },

        analytics: function(term) {
            var $this = this;
            if ($this.o.analytics && $this.o.analyticsString != '' &&
                typeof ga == "function") {
                ga('send', 'pageview', {
                    'page': '/' + $this.o.analyticsString.replace("{asl_term}", term),
                    'title': 'Ajax Search'
                });
            }
        },

        createVerticalScroll: function () {
            var $this = this;
            $this.scroll = $this.n.results.mCustomScrollbar({
                contentTouchScroll: true,
                scrollButtons: {
                    enable: true,
                    scrollType: "pixels",
                    scrollSpeed: $this.o.resultitemheight,
                    scrollAmount: $this.o.resultitemheight
                },
                callbacks: {
                    onScroll: function () {
                        if (is_touch_device()) return;
                        var top = parseInt($('.mCSB_container', $this.n.results).position().top);
                        var children = $('.mCSB_container .resdrg').children();
                        var overall = 0;
                        var prev = 3000;
                        var diff = 4000;
                        var s_diff = 10000;
                        var s_overall = 10000;
                        var $last = null;
                        children.each(function () {
                            diff = Math.abs((Math.abs(top) - overall));
                            if (diff < prev) {
                                s_diff = diff;
                                s_overall = overall;
                                $last = $(this);
                            }
                            overall += $(this).outerHeight(true);
                            prev = diff;
                        });
                        if ($last.hasClass('group'))
                            s_overall = s_overall + ($last.outerHeight(true) - $last.outerHeight(false));
                        $(".mCSB_container", $this.n.resultsDiv).animate({
                            top: -s_overall
                        });
                    }
                }
            });

        },

        createHorizontalScroll: function () {
            var $this = this;

            $this.scroll = $this.n.results.mCustomScrollbar({
                horizontalScroll: true,
                contentTouchScroll: true,
                scrollButtons: {
                    enable: true,
                    scrollType: 'pixels',
                    scrollSpeed: 'auto',
                    scrollAmount: 100
                }
            });

        },

        initEvents: function () {
            var $this = this;

            $($this.n.text.parent()).submit(function (e) {
                e.preventDefault();
                $this.n.text.keyup();
            });
            $this.n.text.click(function () {
                if ($this.firstClick) {
                    $(this).val('');
                    $this.firstClick = false;
                }
            });
            $this.n.resultsDiv.css({
                opacity: 0
            });
            $(document).bind("click touchend", function () {
                $this.hideSettings();
                if ($this.opened == false || $this.o.closeOnDocClick != 1) return;
                $this.hideResults();
            });
            $this.n.proclose.bind("click touchend", function () {
                if ($this.opened == false) return;
                $this.n.text.val("");
                $this.n.textAutocomplete.val("");
                $this.hideResults();
            });
            $($this.elem).bind("click touchend", function (e) {
                e.stopImmediatePropagation();
            });
            $this.n.resultsDiv.bind("click touchend", function (e) {
                e.stopImmediatePropagation();
            });
            $this.n.searchsettings.bind("click touchend", function (e) {
                e.stopImmediatePropagation();
            });

            $this.n.prosettings.on("click", function () {
                if ($this.n.prosettings.attr('opened') == 0) {
                    $this.showSettings();
                } else {
                    $this.hideSettings();
                }
            });

            // jQuery bind not working!
            $(document).bind('touchmove', function (e) {
                if ($this.disableMobileScroll == true)
                    e.preventDefault();
            });

            var resizeTimer;
            $(window).on("resize", function () {
                clearTimeout(resizeTimer);
                resizeTimer = setTimeout(function() {
                    $this.resize();
                }, 250);
            });

            var scrollTimer;
            $(window).on("scroll", function () {
                clearTimeout(scrollTimer);
                scrollTimer = setTimeout(function() {
                    $this.scrolling(false);
                }, 250);
            });

            $this.initNavigationEvent();

            $(window).trigger('resize');
            $(window).trigger('scroll');

            $this.initMagnifierEvent();
            $this.initAutocompleteEvent();
            $this.initPagerEvent();
            $this.initOverlayEvent();
            $this.initFacetEvents();

        },

        initNavigationEvent: function () {
            var $this = this;

            $($this.n.resultsDiv).on('mouseenter', '.item',
                function () {
                    //alert("hover");
                    $('.item', $this.n.resultsDiv).removeClass('hovered');
                    $(this).addClass('hovered');
                }
            );
            $($this.n.resultsDiv).on('mouseleave', '.item',
                function () {
                    //alert("hover");
                    $('.item', $this.n.resultsDiv).removeClass('hovered');
                }
            );

            $(document).keydown(function (e) {

                if (window.event) {
                    var keycode = window.event.keyCode;
                    var ktype = window.event.type;
                } else if (e) {
                    var keycode = e.which;
                    var ktype = e.type;
                }
                //$('.item', $this.n.resultsDiv).hover();

                if ($('.item', $this.n.resultsDiv).length > 0 && $this.n.resultsDiv.css('display') != 'none') {
                    if (keycode == 40) {
                        e.stopPropagation();
                        e.preventDefault();
                        if ($this.post != null) $this.post.abort();
                        if ($('.item.hovered', $this.n.resultsDiv).length == 0) {
                            $('.item', $this.n.resultsDiv).first().addClass('hovered');
                            return;
                        }
                        $('.item.hovered', $this.n.resultsDiv).removeClass('hovered').next().addClass('hovered');
                        $this.scroll.mCustomScrollbar("scrollTo", ".resdrg .item.hovered");
                    }
                    if (keycode == 38) {
                        e.stopPropagation();
                        e.preventDefault();
                        if ($this.post != null) $this.post.abort();
                        if ($('.item.hovered', $this.n.resultsDiv).length == 0) {
                            $('.item', $this.n.resultsDiv).last().addClass('hovered');
                            return;
                        }
                        $('.item.hovered', $this.n.resultsDiv).removeClass('hovered').prev().addClass('hovered');
                        $this.scroll.mCustomScrollbar("scrollTo", ".resdrg .item.hovered");
                    }
                }
            });
        },

        initMagnifierEvent: function () {
           var $this = this;

            var t;
            $this.n.promagnifier.add($this.n.text).bind('click keyup', function (e) {
                if (window.event) {
                    $this.keycode = window.event.keyCode;
                    $this.ktype = window.event.type;
                } else if (e) {
                    $this.keycode = e.which;
                    $this.ktype = e.type;
                }                
                if ($this.keycode == 40 || $this.keycode == 38) return;
                if ($(this).hasClass('orig') && $this.ktype == 'click') return;
                if ($this.o.redirectonclick == 1 && $this.ktype == 'click') {
                    location.href = $this.o.homeurl + '?s=' + $this.n.text.val();
                    return;
                }
                if ($this.o.triggeronclick == 0 && $this.ktype == 'click') return;
                if ($this.o.triggerontype == 0 && $this.ktype == 'keyup') return;
                
                if ($this.post != null) $this.post.abort();
                clearTimeout(t);
                t = setTimeout(function () {
                    $this.search();
                }, 400);
            });
        },


        initAutocompleteEvent: function () {
            var $this = this;

            var tt;
            if ($this.o.autocomplete == 1 && !is_touch_device()) {
                $this.n.text.keydown(function (e) {
                    if (window.event) {
                        $this.keycode = window.event.keyCode;
                        $this.ktype = window.event.type;
                    } else if (e) {
                        $this.keycode = e.which;
                        $this.ktype = e.type;
                    }

                    if ($this.keycode == 39) {
                        $this.n.text.val($this.n.textAutocomplete.val());
                    } else {
                        clearTimeout(tt);
                        if ($this.postAuto != null) $this.postAuto.abort();
                        tt = setTimeout(function () {
                            $this.autocomplete();
                            tt = null;
                        }, 30);
                    }
                });
            }
        },

        initPagerEvent: function () {
            var $this = this;
            $this.n.resultsDiv.on('click', 'nav>a', function (e) {
                e.preventDefault();
                if ($(this).hasClass('asl_prev')) {
                    $this.currentPage = $this.currentPage == 1 ? Math.ceil($this.n.items.length / $this.il.itemsPerPage) : --$this.currentPage;
                } else {
                    $this.currentPage = $this.currentPage == Math.ceil($this.n.items.length / $this.il.itemsPerPage) ? 1 : ++$this.currentPage;
                }
                $('nav>ul li', $this.n.resultsDiv).removeClass('asl_active');
                $($('nav>ul li', $this.n.resultsDiv).get($this.currentPage - 1)).addClass('asl_active');
                $this.isotopic.arrange({filter: $this.filterFns['number']});
                $this.removeAnimation();
            });
            $this.n.resultsDiv.on('click', 'nav>ul li', function (e) {
                e.preventDefault();
                $this.currentPage = parseInt($('span', this).html(), 10);
                $('nav>ul li', $this.n.resultsDiv).removeClass('asl_active');
                $($('nav>ul li', $this.n.resultsDiv).get($this.currentPage - 1)).addClass('asl_active');
                $this.isotopic.arrange({filter: $this.filterFns['number']});
                $this.removeAnimation();
            });
        },

        initOverlayEvent: function () {
            var $this = this;

            if ($this.o.resultstype == "isotopic") {
                if ($this.o.iishowOverlay) {
                    $this.n.resultsDiv.on('mouseenter', 'div.item', function (e) {
                        $('.asl_item_overlay', this).fadeIn();
                        if ($(".asl_item_img", this).length>0) {
                            if ($this.o.iiblurOverlay)
                                $('.asl_item_overlay_img', this).fadeIn();
                            if ($this.o.iihideContent)
                                $('.content', this).slideUp(100);
                        }
                    });
                    $this.n.resultsDiv.on('mouseleave', 'div.item', function (e) {
                        $('.asl_item_overlay', this).fadeOut();
                        if ($(".asl_item_img", this).length>0) {
                            if ($this.o.iiblurOverlay)
                                $('.asl_item_overlay_img', this).fadeOut();
                            if ($this.o.iihideContent && $(".asl_item_img", this).length>0)
                                $('.content', this).slideDown(100);
                        }
                    });
                    $this.n.resultsDiv.on('mouseenter', 'div.asl_item_inner', function (e) {
                        $(this).addClass('animated pulse');
                    });
                    $this.n.resultsDiv.on('mouseleave', 'div.asl_item_inner', function (e) {
                        $(this).removeClass('animated pulse');
                    });

                    $this.n.resultsDiv.on('click', '.asl_item_overlay', function(){
                        var url = $('.content h3 a', $(this).parent()).attr('href');
                        window.location = url;
                    });
                }

                $(window).on('resize', function () {
                    if ($this.resizeTimeout != null) clearTimeout($this.resizeTimeout);
                    $this.resizeTimeout = setTimeout(function () {
                        $this.calculateIsotopeRows();
                        $this.showPagination();
                        $this.removeAnimation();
                        if ($this.isotopic != null)
                            $this.isotopic.arrange({filter: $this.filterFns['number']});
                    }, 200);
                });
            }

        },

        initFacetEvents: function() {
            var $this = this;

            $('input', $this.n.searchsettings).change(function(){
                if ($this.n.text.val().length < $this.o.charcount) return;
                if ($this.post != null) $this.post.abort();
                $this.search();
            });
        },

        destroy: function () {
            return this.each(function () {
                var $this = $.extend({}, this, methods);
                $(window).unbind($this);
            })
        },
        searchfor: function (phrase) {
            $(".proinput input", this).val(phrase).trigger("keyup");
        },
        autocomplete: function () {
            var $this = this;

            var val = $this.n.text.val();
            if ($this.n.text.val() == '') {
                $this.n.textAutocomplete.val('');
                return;
            }
            var autocompleteVal = $this.n.textAutocomplete.val();
            if (autocompleteVal != '' && autocompleteVal.indexOf(val) == 0) {
                return;
            } else {
                $this.n.textAutocomplete.val('');
            }
            var data = {
                action: 'ajaxsearchlite_autocomplete',
                asid: $this.o.id,
                sauto: $this.n.text.val()
            };
            $this.postAuto = $.post(ajaxsearchlite.ajaxurl, data, function (response) {
                if (response.length > 0) {
                    var part1 = val;
                    var part2 = response.substr(val.length);
                    response = part1 + part2;
                }
                $this.n.textAutocomplete.val(response);
            });
        },
        search: function () {
            var $this = this;

            if ($this.searching && 0) return;
            if ($this.n.text.val().length < $this.o.charcount) return;
            $this.searching = true;
            $this.n.proloading.css({
                display: "block"
            });
            $this.n.proclose.css({
                display: "none"
            });
            $this.hideSettings();
            $this.hideResults();
            var data = {
                action: 'ajaxsearchlite_search',
                aslp: $this.n.text.val(),
                asid: $this.o.id,
                options: $('form', $this.n.searchsettings).serialize()
            };
            $this.analytics($this.n.text.val());
            $this.post = $.post(ajaxsearchlite.ajaxurl, data, function (response) {
                response = response.replace(/^\s*[\r\n]/gm, "");
                response = response.match(/!!ASPSTART!!(.*[\s\S]*)!!ASPEND!!/)[1];
                response = JSON.parse(response);
                $this.n.resdrg.html("");
                if (response.error != null) {
                    $this.n.resdrg.append("<div class='nores error'>" + response.error + "</div>");
                } else if (response.nores != null && response.keywords != null) {
                    var str = $this.o.noresultstext + " " + $this.o.didyoumeantext + "<br>";
                    for (var i = 0; i < response.keywords.length; i++) {
                        str = str + "<span class='keyword'>" + response.keywords[i] + "</span>";
                    }
                    $this.n.resdrg.append("<div class='nores'>" + str + "</div>");
                    $(".keyword", $this.n.resdrg).bind('click', function () {
                        $this.n.text.val($(this).html());
                        $this.n.promagnifier.trigger('click');
                    });
                    if ($this.n.showmore != null) {
                        $this.n.showmore.css({
                            'display': 'none'
                        });
                    }
                } else if (response.length > 0 || response.grouped != null) {
                    if (response.grouped != null && $this.o.resultstype == 'vertical') {
                        $.each(response.items, function () {
                            group = $this.createGroup(this.name);
                            group = $(group);
                            $this.n.resdrg.append(group);
                            $.each(this.data, function () {
                                result = $this.createResult(this, 0);
                                if (result != null) {
                                    result = $(result);
                                    $this.n.resdrg.append(result);
                                }
                            });
                        });
                    } else {
                        var skipped = 0;
                        for (var i = 0; i < response.length; i++) {
                            result = $this.createResult(response[i], i-skipped);
                            if (result != null) {
                                result = $(result);
                                $this.n.resdrg.append(result);
                            } else {
                                skipped++;
                            }
                        }
                    }

                    if ($this.n.showmore != null) {
                        $this.n.showmore.css({
                            'display': 'inline-block'
                        });
                    }
                } 
                if ($this.n.resdrg.get(0).innerHTML == "") {
                    $this.n.resdrg.append("<div class='nores'>" + $this.o.noresultstext + "</div>");
                    if ($this.n.showmore != null) {
                        $this.n.showmore.css({
                            'display': 'none'
                        });
                    }
                }
                $this.n.items = $('.item', $this.n.resultsDiv);

                $this.showResults();
                $this.scrollToResults();

                if ($this.n.showmore != null) {
                    $this.n.showmore.attr('href', $this.o.homeurl + '?s=' + $this.n.text.val());
                }
            }, "text");
        },

        showResults: function( ) {
            var $this = this;
            switch ($this.o.resultstype) {
                case 'horizontal':
                    $this.showHorizontalResults();
                    break;
                case 'vertical':
                    $this.showVerticalResults();
                    break;
                case 'polaroid':
                    $this.showPolaroidResults();
                    $this.disableMobileScroll = true;
                    break;
                case 'isotopic':
                    $this.showIsotopicResults();
                    break;
                default:
                    $this.showHorizontalResults();
                    break;
            }
            $this.n.proloading.css({
                display: "none"
            });
            $this.n.proclose.css({
                display: "block"
            });
            if (is_touch_device())
                document.activeElement.blur();
        },

        hideResults: function( ) {
            var $this = this;
            switch ($this.o.resultstype) {
                case 'horizontal':
                    $this.hideHorizontalResults();
                    break;
                default:
                    $this.hideVerticalResults()
                    break;
            }
            $this.n.proclose.css({
                display: "none"
            });
        },

        /**
         * Chooses which creator to use: Vertical-Horizontal, Isotopic or Polaroid
         */
        createResult: function (r, i) {
            var $this = this;

            if ($this.o.resultstype == 'horizontal' || $this.o.resultstype == 'vertical')
                return $this.createVHResult(r);
            else if ($this.o.resultstype == 'isotopic')
                return $this.createIsotopicResult(r, i);
            else
                return $this.createPolaroidResult(r);

        },


        /**
         * Creates a result for Vertical and Horizontal types
         */
        createVHResult: function (r) {
            var $this = this;

            var imageDiv = "";
            var desc = "";
            var authorSpan = "";
            var dateSpan = "";
            var isImage = false;
            if (r.image != null && r.image != "") {
                imageDiv = "\
               <div class='image'>\
                <img src='" + r.image + "'> \
                <div class='void'></div>\
                </div>";
                isImage = true;
            }
            if ($this.o.showauthor == 1) {
                authorSpan = "<span class='author'>" + r.author + "</span>";
            }
            if ($this.o.showdate == 1) {
                dateSpan = "<span class='date'>" + r.date + "</span>";
            }
            if ($this.o.showdescription == 1) {
                desc = r.content;
            }
            if ($this.o.hresulthidedesc == 1 && $this.o.resultstype == 'horizontal' && isImage)
                desc = '';
            var id = 'item_' + $this.o.id;
            var clickable = ""
            if ($this.o.resultareaclickable == 1) {
                clickable = "<span class='overlap'></span>";
            }
            var result = "\
             <div class='item'> \
              " + imageDiv + " \
              <div class='content'> \
                <h3><a href='" + r.link + "'>" + r.title + clickable + "</a></h3>   \
                        <div class='etc'>" + authorSpan + " \
                        " + dateSpan + "</div> \
                <p class='desc'>" + desc + "</p>        \
              </div>     \
              <div class='clear'></div>   \
             </div>";
            return result;
        },

        /**
         * Creates a result for Isotopic types
         */
        createIsotopicResult: function (r, i) {
            var $this = this;

            //var imageStyle = "style='opacity:0;'";
            var image = "";
            var overlayImage = "";
            var desc = "";
            var authorSpan = "";
            var dateSpan = "";
            var overlay = "";

            if (r.image != null && r.image != "") {
                image = "<img class='asl_item_img' src=' " + r.image + "'>";
                if ($this.o.iiblurOverlay && !is_touch_device())
                    var filter = "aslblur";
                else
                    var filter = "no_aslblur";
                overlayImage = "<img filter='url(#" + filter + ")' style='filter: url(#" + filter + ");-webkit-filter: url(#" + filter + ");-moz-filter: url(#" + filter + ");-o-filter: url(#" + filter + ");-ms-filter: url(#" + filter + ");' class='asl_item_overlay_img' src=' " + r.image + "'>";
                //$this.n.aslItemOverlay.append(overlayImage);
            } else {
                switch ($this.o.iifNoImage) {
                    case "description":
                        desc = r.content;
                        break;
                    case "removeres":
                        return null;
                        break;
                    case "defaultimage":
                        if ($this.o.defaultImage != "") {
                            image = "<img class='asl_item_img' src=' " + $this.o.defaultImage + "'>";
                            if ($this.o.iiblurOverlay && !is_touch_device())
                                var filter = "aslblur";
                            else
                                var filter = "no_aslblur";
                            overlayImage = "<img filter='url(#" + filter + ")' style='filter: url(#" + filter + ");-webkit-filter: url(#" + filter + ");-moz-filter: url(#" + filter + ");-o-filter: url(#" + filter + ");-ms-filter: url(#" + filter + ");' class='asl_item_overlay_img' src=' " + $this.o.defaultImage + "'>";
                        }
                        break;
                }
            }
            if ($this.o.iishowOverlay)
                overlay = $this.n.aslItemOverlay[0].outerHTML;
            /*if (is_touch_device()) {
                overlay = "<span class='asl_item_overlay_m'></span>";
            }   */
            if ($this.o.showauthor == 1) {
                authorSpan = "<span class='author'>" + r.author + "</span>";
            }
            if ($this.o.showdate == 1) {
                dateSpan = "<span class='date'>" + r.date + "</span>";
            }
            if ($this.o.showdescription == 1) {
                desc = r.content;
            }

            var id = 'item_' + $this.o.id;
            var clickable = ""
            if ($this.o.resultareaclickable == 1) {
                clickable = "<span class='overlap'></span>";
            }
            var result = "\
             <div data-itemnum='" + i + "' class='item'> \
             " + overlayImage + "\
             " + overlay + "\
             " + image + "\
              <div class='content'> \
                <h3><a href='" + r.link + "'>" + r.title + clickable + "</a></h3>   \
                        <div class='etc'>" + authorSpan + " \
                        " + dateSpan + "</div> \
                <p class='desc'>" + desc + "</p>        \
              </div>     \
              <div class='clear'></div>   \
             </div>";
            return result;
        },

        /**
         * Creates a result for Polaroid types
         */

        createPolaroidResult: function (r) {
            var $this = this;

            if (r.image != null) {
                var image = "<img alt='img' src='" + r.image + "'>";
            } else {
                var image = r.content;
            }

            var clickable = "";
            var authorSpan = "";
            var dateSpan = "";
            var backDiv = "";
            if ($this.o.resultareaclickable == 1) {
                clickable = "<span class='overlap'></span>";
            }
            if ($this.o.pshowsubtitle == 1) {
                if ($this.o.showauthor == 1) {
                    authorSpan = "<span class='author'>" + r.author + "</span>";
                }
                if ($this.o.showdate == 1) {
                    dateSpan = "<span class='date'>" + r.date + "</span>";
                }
            }
            if ($this.o.pshowdesc == 1) {
                backDiv = "<div class='photostack-back'>" + r.content + "</div>";
            }
            var result = "\
          <figure class='photostack-flip photostack-current'> \
						<a class='photostack-img etc' href='" + r.link + "'>" + image + "</a> \
						<figcaption>  \
							<h2 class='photostack-title'><a href='" + r.link + "'>" + r.title + clickable + "</a></h2>  \
              <div class='etc'>" + authorSpan + " \
              " + dateSpan + "</div> " + backDiv + " \
						</figcaption>   \
					</figure>";

            return result;
        },

        scrollToResults: function( ) {
            $this = this;
            if (this.o.scrollToResults!=1) return;
            if (this.$elem.parent().hasClass("asl_preview_data")) return;
            if ($this.o.resultsposition == "hover")
              var stop = $this.n.probox.offset().top - 20;
            else
              var stop = $this.n.resultsDiv.offset().top - 20;
            if ($("#wpadminbar").length > 0)
                stop -= $("#wpadminbar").height();
            stop = stop < 0 ? 0 : stop;
            $('body, html').animate({
                "scrollTop": stop
            }, {
                duration: 500
            });
        },

        createGroup: function (r) {
            return "<div class='group'>" + r + "</div>";
        },

        showVerticalResults: function () {
            var $this = this;
            $this.n.resultsDiv.css({
                display: 'block',
                height: 'auto'
            });
            $this.scrolling(true);
            var top = $this.n.resultsDiv.position().top;
            $this.n.resultsDiv.css({
                "top": top - 100,
                opacity: 0,
                visibility: "visible"
            }).animate({
                    "top": top,
                    opacity: 1
                }, {
                    complete: function () {
                        $(".mCS_no_scrollbar", $this.n.resultsDiv).css({
                            "top": 0
                        });
                        $(".mCSB_container", $this.n.resultsDiv).css({
                            "top": 0
                        });
                    }
                });
            if ($this.n.items.length > 0) {
                var count = (($this.n.items.length < $this.o.itemscount) ? $this.n.items.length : $this.o.itemscount);
                var groups = $('.group', $this.n.resultsDiv);

                if ($this.n.items.length <= $this.o.itemscount) {
                    $this.n.results.css({
                        height: 'auto'
                    });
                } else {

                    // Set the height to a fictive value to refresh the scrollbar
                    $this.n.results.css({
                        height: 30
                    });
                    $this.scroll.mCustomScrollbar('update');
                    $this.resize();

                    var i = 0;
                    var h = 0;

                    $this.n.items.each(function () {
                        h += $(this).outerHeight(true);
                        i++;
                    });

                    // Count the average height * viewport size
                    i = i < 1 ? 1 : i;
                    h = h / i * count;
                    if (groups.length > 0) {
                        h += groups.outerHeight(true) * groups.length;
                    }

                    $this.n.results.css({
                        height: h + 3
                    });
                }

                $this.scroll.mCustomScrollbar('update');
                $this.resize();
                $this.scroll.mCustomScrollbar('scrollTo', 0);

                if ($this.o.highlight == 1) {
                    var wholew = (($this.o.highlightwholewords == 1) ? true : false);
                    $("div.item", $this.n.resultsDiv).highlight($this.n.text.val().split(" "), { element: 'span', className: 'highlighted', wordsOnly: wholew });
                }

            }
            $this.resize();
            if ($this.n.items.length == 0) {
                var h = ($('.nores', $this.n.results).outerHeight(true) > ($this.o.resultitemheight) ? ($this.o.resultitemheight) : $('.nores', $this.n.results).outerHeight(true));
                $this.n.results.css({
                    height: 11110
                });
                $this.scroll.mCustomScrollbar('update');
                $this.n.results.css({
                    height: 'auto'
                });
            }
            $this.addAnimation();
            $this.scrolling(true);
            $this.searching = false;


        },

        showHorizontalResults: function () {
            var $this = this;

            $this.n.resultsDiv.css('display', 'block');

            if ($('.nores', $this.n.results).size() > 0) {
                $(".mCSB_container", $this.n.resultsDiv).css({
                    width: 'auto',
                    left: 0
                });
            } else {
                $(".mCSB_container", $this.n.resultsDiv).css({
                    width: ($this.n.resdrg.children().size() * $($this.n.resdrg.children()[0]).outerWidth(true)),
                    left: 0
                });
            }
            if ($this.o.resultsposition == 'hover')
                $this.n.resultsDiv.css('width', $this.n.container.outerWidth(true));
            $this.scroll.data({
                "scrollButtons_scrollAmount": parseInt($this.n.items.outerWidth(true)),
                "mouseWheelPixels": parseInt($this.n.items.outerWidth(true))
            }).mCustomScrollbar("update");

            if ($this.n.resultsDiv.css('visibility') == 'visible') {
                var cssArgs = {
                    height: 'auto'
                };
                var animArgs = {
                    opacity: 1
                };
            } else {
                var autoHeight = $this.n.resultsDiv.css('height', 'auto').height();

                var cssArgs = {
                    opacity: 0,
                    visibility: "visible",
                    height: 0
                };

                var animArgs = {
                    opacity: 1,
                    height: autoHeight
                };
            }

            $this.addAnimation();

            $this.n.resultsDiv.css(cssArgs).animate(
                animArgs
                , {
                    complete: function () {
                        $this.scrolling(true);
                        $this.searching = false;
                    }
                });
        },

        showIsotopicResults: function () {
            var $this = this;
            var itemsPerPage = $this.o.iitemsPerPage;


            /*$this.n.items.each(function(){
             if (parseInt($(this).attr('data-itemnum')) < itemsPerPage)
             $(this).css({
             opacity: 1,
             display: "block"
             });
             });*/
            $this.n.resultsDiv.css({
                display: 'block',
                height: 'auto'
            });
            $this.scrolling(true);
            var top = $this.n.resultsDiv.position().top;
            $this.n.resultsDiv.css({
                "top": top - 100,
                opacity: 0,
                visibility: "visible"
            }).animate({
                    "top": top,
                    opacity: 1
                }, {

                });
            if ($this.n.items.length > 0) {
                $this.n.results.css({
                    height: "auto"
                });
                if ($this.o.highlight == 1) {
                    var wholew = (($this.o.highlightwholewords == 1) ? true : false);
                    $("div.item", $this.n.resultsDiv).highlight($this.n.text.val().split(" "), { element: 'span', className: 'highlighted', wordsOnly: wholew });
                }

            }
            //$this.resize();
            $this.calculateIsotopeRows();
            $this.showPagination();
            if ($this.n.items.length == 0) {
                var h = ($('.nores', $this.n.results).outerHeight(true) > ($this.o.resultitemheight) ? ($this.o.resultitemheight) : $('.nores', $this.n.results).outerHeight(true));
                $this.n.results.css({
                    height: 11110
                });
                $this.n.results.css({
                    height: 'auto'
                });
                $this.n.resdrg.css({
                    height: 'auto'
                });
            } else {
                $this.isotopic = new rpp_isotope('#ajaxsearchliteres' + $this.o.rid + " .resdrg", {
                    // options
                    itemSelector: 'div.item',
                    layoutMode: 'masonry',
                    filter: $this.filterFns['number']
                });
            }

            $this.addAnimation();
            //$this.removeAnimation();
            //$this.scrolling(true);
            $this.searching = false;

        },


        showPagination: function () {
            var $this = this;

            $('nav.asl_navigation ul li', $this.n.resultsDiv).remove();
            $('nav.asl_navigation', $this.n.resultsDiv).css('display', 'none');

            if ($this.n.items.length > 0) {
                var pages = Math.ceil($this.n.items.length / $this.il.itemsPerPage);
                if (pages > 1) {
                    for (var i = 1; i <= pages; i++) {
                        if (i == 1)
                            $('nav.asl_navigation ul', $this.n.resultsDiv).append("<li class='asl_active'><span>" + i + "</span></li>");
                        else
                            $('nav.asl_navigation ul', $this.n.resultsDiv).append("<li><span>" + i + "</span></li>");
                    }
                    $('nav.asl_navigation', $this.n.resultsDiv).css('display', 'block');
                }
            }
        },


        calculateIsotopeRows: function () {
            var $this = this;
            var containerWidth = parseFloat($this.n.results.innerWidth());
            var realColumnCount = containerWidth / $this.o.iitemsWidth;
            var floorColumnCount = Math.floor(realColumnCount);
            if (floorColumnCount <= 0)
                floorColumnCount = 1;
            /*if ((realColumnCount - floorColumnCount) > 0.8)
             floorColumnCount++;*/
            if (Math.abs(containerWidth / floorColumnCount - $this.o.iitemsWidth) >
                Math.abs(containerWidth / (floorColumnCount + 1) - $this.o.iitemsWidth)) {
                floorColumnCount++;
            }

            var newItemW = containerWidth / floorColumnCount - 2 * ($this.n.items.outerWidth(true) - $this.n.items.innerWidth());
            var newItemH = (newItemW / $this.o.iitemsWidth) * $this.o.iitemsHeight;

            $this.il.columns = floorColumnCount;
            $this.il.itemsPerPage = floorColumnCount * $this.o.iiRows;

            // This data needs do be written to the DOM, because the isotope arrange can't see the changes
            $this.n.resultsDiv.data({
                "colums": $this.il.columns,
                "itemsperpage": $this.il.itemsPerPage
            });

            $this.currentPage = 1;

            $this.n.items.css({
                width: Math.floor(newItemW),
                height: Math.floor(newItemH)
            });
        },

        showPolaroidResults: function () {
            var $this = this;

            $('.photostack>nav', $this.n.resultsDiv).remove();
            var figures = $('figure', $this.n.resultsDiv);
            $this.n.resultsDiv.css({
                display: 'block',
                height: 'auto'
            });
            $this.scrolling(true);
            var top = $this.n.resultsDiv.position().top;
            $this.n.resultsDiv.css({
                "top": top - 100,
                opacity: 0,
                visibility: "visible"
            }).animate({
                    "top": top,
                    opacity: 1
                }, {
                    complete: function () {

                    }
                });

            if (figures.length > 0) {
                $this.n.results.css({
                    height: $this.o.prescontainerheight
                });

                if ($this.o.highlight == 1) {
                    var wholew = (($this.o.highlightwholewords == 1) ? true : false);
                    //$("div.item", $this.n.resultsDiv).highlight($this.n.text.val().split(" "), { element: 'span', className: 'highlighted', wordsOnly: wholew });
                    //TODO
                }
                new Photostack($this.n.results.get(0), {
                    callback: function (item) {
                    }
                });
            }
            //$this.resize();
            if (figures.length == 0) {
                var h = ($('.nores', $this.n.results).outerHeight(true) > ($this.o.resultitemheight) ? ($this.o.resultitemheight) : $('.nores', $this.n.results).outerHeight(true));
                $this.n.results.css({
                    height: 11110
                });
                $this.n.results.css({
                    height: "auto"
                });
            }
            $this.addAnimation();
            $this.scrolling(true);
            $this.searching = false;
            $this.initPolaroidEvents(figures);


        },

        initPolaroidEvents: function (figures) {
            var $this = this;

            var i = 1;
            figures.each(function () {
                if (i > 1)
                    $(this).removeClass('photostack-current');
                $(this).attr('idx', i);
                i++;
            });

            figures.click(function (e) {
                if ($(this).hasClass("photostack-current")) return;
                e.preventDefault();
                var idx = $(this).attr('idx');
                $('.photostack>nav span:nth-child(' + idx + ')', $this.n.resultsDiv).click();
            });

            figures.bind('mousewheel', function (event, delta) {
                event.preventDefault();
                if (delta >= 1) {
                    if ($('.photostack>nav span.current', $this.n.resultsDiv).next().length > 0) {
                        $('.photostack>nav span.current', $this.n.resultsDiv).next().click();
                    } else {
                        $('.photostack>nav span:nth-child(1)', $this.n.resultsDiv).click();
                    }
                } else {
                    if ($('.photostack>nav span.current', $this.n.resultsDiv).prev().length > 0) {
                        $('.photostack>nav span.current', $this.n.resultsDiv).prev().click();
                    } else {
                        $('.photostack>nav span:nth-last-child(1)', $this.n.resultsDiv).click();
                    }
                }
            });

            figures.bind("swipeone", function (e, originalEvent) {
                e.preventDefault();
                e.stopPropagation();
                originalEvent.originalEvent.preventDefault();
                originalEvent.originalEvent.stopPropagation()
                if (originalEvent.delta != null && originalEvent.delta[0] != null && originalEvent.delta[0].lastX != null) {
                    if (originalEvent.delta[0].lastX >= 0) {
                        if ($('.photostack>nav span.current', $this.n.resultsDiv).next().length > 0) {
                            $('.photostack>nav span.current', $this.n.resultsDiv).next().click();
                        } else {
                            $('.photostack>nav span:nth-child(1)', $this.n.resultsDiv).click();
                        }
                    } else {
                        if ($('.photostack>nav span.current', $this.n.resultsDiv).prev().length > 0) {
                            $('.photostack>nav span.current', $this.n.resultsDiv).prev().click();
                        } else {
                            $('.photostack>nav span:nth-last-child(1)', $this.n.resultsDiv).click();
                        }
                    }
                }
            });
            $this.disableMobileScroll = true;
        },

        hideVerticalResults: function () {
            var $this = this;

            $this.disableMobileScroll = false;

            $this.n.resultsDiv
                .animate({
                    opacity: 0,
                    height: 0
                }, {
                    duration: 120,
                    complete: function () {
                        $(this).css({
                            visibility: "hidden",
                            display: "none"
                        });
                    }
                });
        },

        hideHorizontalResults: function (newSearch) {
            //var $this =  $.extend({}, this, methods);
            var $this = this;

            $this.disableMobileScroll = false;

            newSearch = typeof newSearch !== 'undefined' ? newSearch : false;
            if (!newSearch) {
                $this.n.resultsDiv
                    .animate({
                        opacity: 0,
                        height: 0
                    }, {
                        duration: 120,
                        complete: function () {
                            $(this).css({
                                visibility: "hidden",
                                display: "none"
                            });
                        }
                    });
            } else {
                $this.n.resultsDiv
                    .animate({
                        opacity: 0.3
                    }, {
                        complete: function () {
                            return;
                        }
                    });
            }
        },

        addAnimation: function () {
            var $this = this;
            var i = 0;
            var j = 1;
            $this.n.items.each(function () {
                if ($this.o.resultstype == 'isotopic' && j>$this.il.itemsPerPage)
                    return;
                var x = this;
                setTimeout(function () {
                    $(x).addClass($this.animation);
                }, i);
                i = i + 60;
                j++;
            });
        },

        removeAnimation: function () {
            var $this = this;
            $this.n.items.each(function () {
                var x = this;
                $(x).removeClass($this.animation);
            });
        },

        showSettings: function () {
            var $this = this;

            $this.scrolling(true);
            $this.n.searchsettings.css({
                opacity: 0,
                visibility: "visible",
                top: "-=50px"
            });
            $this.n.searchsettings.animate({
                opacity: 1,
                top: "+=50px"
            });
            $this.n.prosettings.attr('opened', 1);
            if ($this.settScroll == null) {
                $this.settScroll = $('.asl_sett_scroll', $this.n.searchsettings).mCustomScrollbar({
                    contentTouchScroll: true
                });
            }
        },
        hideSettings: function () {
            var $this = this;

            $this.n.searchsettings.animate({
                opacity: 0
            }, {
                complete: function () {
                    $(this).css({
                        visibility: "hidden"
                    });
                }
            });
            $this.n.prosettings.attr('opened', 0);
        },
        cleanUp: function () {
            var $this = this;

            if ($('.searchsettings', $this.n.container).length > 0) {
                $('body>#ajaxsearchlitesettings' + $this.o.rid).remove();
                $('body>#ajaxsearchliteres' + $this.o.rid).remove();
            }
        },
        resize: function () {
            var $this = this;

            if (detectIE()) {
                $this.n.proinput.css({
                    width: ($this.n.probox.width() - 8 - ($this.n.proinput.outerWidth(false) - $this.n.proinput.width()) - $this.n.proloading.outerWidth(true) - $this.n.prosettings.outerWidth(true) - $this.n.promagnifier.outerWidth(true) - 10)
                });
                $this.n.text.css({
                    width: $this.n.proinput.width() - 2 + $this.n.proloading.outerWidth(true),
                    position: 'absolute',
                    zIndex: 2
                });
                $this.n.textAutocomplete.css({
                    width: $this.n.proinput.width() - 2 + $this.n.proloading.outerWidth(true),
                    position: 'absolute',
                    top: $this.n.text.position().top,
                    left: $this.n.text.position().left,
                    opacity: 0.25,
                    zIndex: 1
                });
            }

            if ($this.n.prosettings.attr('opened') != 0) {

                if ($this.o.settingsimagepos == 'left') {
                    $this.n.searchsettings.css({
                        display: "block",
                        top: $this.n.prosettings.offset().top + $this.n.prosettings.height() - 2,
                        left: $this.n.prosettings.offset().left
                    });
                } else {
                    $this.n.searchsettings.css({
                        display: "block",
                        top: $this.n.prosettings.offset().top + $this.n.prosettings.height() - 2,
                        left: $this.n.prosettings.offset().left + $this.n.prosettings.width() - $this.n.searchsettings.width()
                    });
                }
            }
            if ($this.n.resultsDiv.css('visibility') != 'hidden') {

                if ($this.o.resultsposition != 'block') {
                    $this.n.resultsDiv.css({
                        width: $this.n.container.width() - ($this.n.resultsDiv.outerWidth(true) - $this.n.resultsDiv.width()),
                        top: $this.n.container.offset().top + $this.n.container.outerHeight(true) + 10,
                        left: $this.n.container.offset().left
                    });
                }

                if ($this.o.resultstype != 'isotopic') {
                    $('.content', $this.n.items).each(function () {
                        var imageWidth = (($(this).prev().css('display') == "none") ? 0 : $(this).prev().outerWidth(true));
                        $(this).css({
                            width: ($(this.parentNode).width() - $(this).prev().outerWidth(true) - $(this).outerWidth(false) + $(this).width()) - 3
                        });
                    });
                }

            }
        },
        scrolling: function (ignoreVisibility) {
            var $this = this;

            if (ignoreVisibility == true || $this.n.searchsettings.css('visibility') == 'visible') {

                if ($this.o.settingsimagepos == 'left') {
                    $this.n.searchsettings.css({
                        display: "block",
                        top: $this.n.prosettings.offset().top + $this.n.prosettings.height() - 2,
                        left: $this.n.prosettings.offset().left
                    });
                } else {
                    $this.n.searchsettings.css({
                        display: "block",
                        top: $this.n.prosettings.offset().top + $this.n.prosettings.height() - 2,
                        left: $this.n.prosettings.offset().left + $this.n.prosettings.width() - $this.n.searchsettings.width()
                    });
                }
            }

            if ((ignoreVisibility == true || $this.n.resultsDiv.css('visibility') == 'visible')) {
                var cwidth = $this.n.container.outerWidth(true);
                if ($this.o.resultsposition != 'hover' && $this.n.resultsAppend.length > 0)
                    cwidth = 'auto';
                else
                    cwidth = cwidth - (2 * parseInt($this.n.resultsDiv.css('paddingLeft')));
                $this.n.resultsDiv.css({
                    width: cwidth,
                    top: $this.n.container.offset().top + $this.n.container.outerHeight(true) + 10,
                    left: $this.n.container.offset().left
                });
                if ($this.o.resultstype != 'vertical') return;
                $('.content', $this.n.items).each(function () {
                    $(this).css({
                        width: ($(this.parentNode).width() - $(this).prev().outerWidth(true) - $(this).outerWidth(false) + $(this).width()) - 3
                    });
                    /*$(this).css({
                     width: ($(this.parentNode).width()-$(this).prev().outerWidth(true))
                     });*/
                });
            }
        }
    };

    function is_touch_device() {
        return !!("ontouchstart" in window) ? 1 : 0;
    }

    function detectIE() {
        var ua = window.navigator.userAgent;
        var msie = ua.indexOf('MSIE ');
        var trident = ua.indexOf('Trident/');

        if (msie > 0 || trident > 0)
            return true;

        // other browser
        return false;
    }

    // Object.create support test, and fallback for browsers without it
    if (typeof Object.create !== 'function') {
        Object.create = function (o) {
            function F() {
            }

            F.prototype = o;
            return new F();
        };
    }


    // Create a plugin based on a defined object
    $.plugin = function (name, object) {
        $.fn[name] = function (options) {
            return this.each(function () {
                if (!$.data(this, name)) {
                    $.data(this, name, Object.create(object).init(
                        options, this));
                }
            });
        };
    };

    $.plugin('ajaxsearchlite', methods);
})(jQuery);

})(asljQuery, asljQuery, window);