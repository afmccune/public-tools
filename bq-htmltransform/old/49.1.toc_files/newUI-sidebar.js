jQuery(function($){

    $('#link-not-working').on('click', function(event) {
        event.preventDefault();
        if ($('.report-problem-form').is(':visible')) {
            $('.report-problem-cancel').click();
            return false;
        }
        $('.email-action, .export-action').removeClass("active");
        $('.custom-links, .locale, .additional-options, .actions, .email-form, .export-form, .interlibrary-loan-form').hide();
        if ($(".report-problem-form").length) {
            var link = $("#link-not-working").offset();
            $("#reportProblemName").val("");
            $("#reportProblemEmail").val("");
            $("#reportProblemMessage").val("");
            $(".report-problem-form").show();
            $(".report-problem-form").offset({top:link.top+20, left:link.left-10});
        } else {
            reportBadLink("Link Not Working");
            showReportProblemConfirmation();
        }
    });

    $('.report-problem-cancel').on('click', function(event) {
        $('.report-problem-form').hide();
        $('.custom-links, .locale, .additional-options, .actions').show();
    });

    $('.report-problem-send').on('click', function(event) {
        $("#patronName").val($("#reportProblemName").val());
        $("#patronEmail").val($("#reportProblemEmail").val());
        $("#patronMessage").val($("#reportProblemMessage").val());
        reportBadLink("Link Not Working");
        $('.report-problem-form').hide();
        showReportProblemConfirmation();
    });

    function showReportProblemConfirmation() {
        $('.bad-link-logging-confirmation').show();
        var linkText = $("#link-not-working").offset();
        $('.bad-link-logging-confirmation').offset({top:linkText.top+20, left:linkText.left-10});
        setTimeout("jQuery('.bad-link-logging-confirmation').hide()", 3000);
        setTimeout("jQuery('.custom-links, .locale, .additional-options, .actions').show()", 3000);
    }

    function reportBadLink(reportSource) {
        var badLink = $('.selected-resource').val();
        $("#badLink").val(badLink);
        $("#reportSource").val(reportSource);
        $("#linkType").val($('.selected-resource').data("link-type"));

        $("#resourceName").val($.trim($('#source').text()));
        $("#referringURL").val(window.location);
        $.ajax({
            url: './logBadLink',
            type: 'POST',
            data: $('#badLinkLoggingForm').serialize()
        }).done( function (response) {
            // console.log("Bad link was logged.");
        }).fail( function () {
            // console.log("There was an error logging a bad link.");
        });
    }
    
    //Start Interlibrary Loan functions. This is additional functionality for sidebar. Main functions are in newUI-common.js.
    $('.interlibrary-loan').on('click', function() {
    	$('.email-action, .export-action').removeClass("active");
        $('.custom-links, .locale, .additional-options, .actions, .email-form, .export-form').hide();
    });
    
    $('.interlibrary-loan-cancel').on('click', function() {
        /*$('.custom-links, .locale, .additional-options, .actions').show();*/
    	//Why do I need to use setTimeout to get the code to work? How did I figure this out?
        setTimeout("jQuery('.custom-links, .locale, .additional-options, .actions').show()", 1);
    });
    
    $('.interlibrary-loan-send').on('click', function() {
    	setTimeout("jQuery('.custom-links, .locale, .additional-options, .actions').show()", 3000);
    });
    //End Interlibrary Loan functions

    $('#linksToContent option').each(function(){
        var link = this.value;
        var $this = $(this);
        if (link !== '0' && link !== '-1') {
            var oneClickExclude = $this.data("go-to-full-text");
            if (oneClickExclude) {
                $('#iframeContainer').hide();
                $('#oneClickExclude').attr('href', link);
                $('#oneClickExcludeContainer').show();
            } else {
                $('#iframeContainer').show();
                $('#oneClickExcludeContainer').hide();
                $('#website').attr('src', link);
            }
            $this.addClass("selected-resource");
            setBrowseLink($this);
            setShowBrowseJournalMessage($this);
            if (hideResourceDetailsControls()) {
                activateResourceDetailsControls();
            }
            return false;
        }
    });

    $('#linksToContent').on('change', function() {
        var val = $('#linksToContent').val();
        if (val === "0" || val === "-1") {
            $('#linksToContent').val("0");
            return false;
        }
        $('#linksToContent option').removeClass("selected-resource");
        var $selectedOption = $('#linksToContent option:selected');
        $selectedOption.addClass("selected-resource");
        var link = $('#linksToContent').val();
        var oneClickExclude = $selectedOption.data("go-to-full-text");
        if (oneClickExclude) {
            $('#iframeContainer').hide();
            $('#oneClickExclude').attr('href', link);
            $('#oneClickExcludeContainer').show();
        } else {
            $('#iframeContainer').show();
            $('#oneClickExcludeContainer').hide();
            $('#website').attr('src', link);
        }
        var text = $selectedOption.text();
        $('#source').text(text);
        var range = $selectedOption.data("range");
        $('#coverage-range').text(range);

        // Notes
        var allTitleNote = $selectedOption.data("all-title-note");
        var publicNote = $selectedOption.data("public-note");
        var locationNote = $selectedOption.data("location-note");
        var holdingNote = $selectedOption.data("holding-note");

        $('#all-title-note').html(allTitleNote);
        $('#public-note').html(publicNote);
        $('#title-holding-note').html(locationNote);
        $('#title-location-note').html(holdingNote);


        $('#linksToContent').val("0");
        setBrowseLink($selectedOption);
        setShowBrowseJournalMessage($selectedOption);
        reportBadLink("Try a Different Source");
        if (hideResourceDetailsControls()) {
            activateResourceDetailsControls();
        }
    });

    function setBrowseLink(selectedOption) {
        var link;
        var linkText;
        var linkType = selectedOption.data("link-type");
        if (linkType === "Article") {
            link = selectedOption.data("journal-link");
            linkText = $("#browse-journal-text").text();
        } else if (linkType === "Chapter") {
            link = selectedOption.data("book-link");
            linkText = $("#link-to-book-text").text();
        } else {
            $('#browse-link').html('');
            return false;
        }
        if (link === "") {
            $('#browse-link').html('');
            return false;
        }
        $('#browse-link').html('<a href="#">' + linkText + '</a>');
        $('#browse-link').on('click', function(event) {
            event.preventDefault();
            var oneClickExclude = selectedOption.data("go-to-full-text");
            if (oneClickExclude) {
                $('#iframeContainer').hide();
                $('#oneClickExclude').attr('href', link);
                $('#oneClickExcludeContainer').show();
            } else {
                $('#iframeContainer').show();
                $('#oneClickExcludeContainer').hide();
                $('#website').attr('src', link);
            }
        });
    }

    function setShowBrowseJournalMessage(selectedOption) {
        if (selectedOption.data("link-type") === "Journal") {
            $("#browse-journal-message").show();
        } else {
            $("#browse-journal-message").hide();
        }
    }

    function hideResourceDetailsControls() {
        if ($('#browse-link').text() === "" &&
            $('#coverage-range').text() === "" &&
            $('#public-note').text() === "" &&
            $('#terms-of-use').text() === "") {
            $(".info, .source-open, .source-close").hide();
            $('#source').css("cursor", "default");
            return false;
        }
        return true;
    }

    function activateResourceDetailsControls() {
        $('#source-control').off("click");
        $('#source-control').on("click", function(event) {
        	event.preventDefault();
            $(this).next().slideToggle("fast", function() {
                $('.source-open').toggle();
                $('.source-close').toggle();
            });
        });

        $("#source, .info, .source-open, .source-close").off("hover");
        $("#source, .info, .source-open, .source-close").hover(
            function() {
                $(".source-open, .source-close").removeClass('caret-plain').addClass('caret-hover');
            }, function() {
                $(".source-open, .source-close").addClass('caret-plain').removeClass('caret-hover');
            }
        );
    }

    $('.breakout').on('click', function() {
        $('.sidebar').css('overflow-y', 'hidden');
        $(".content").animate({"margin-right": "0px"}, "fast");
        $(".sidebar").animate({"width": "0px"}, "fast");
        $('.inner, .header').hide();
    });

    $('.hide-sidebar, .sidebar-collapsed-image, .sidebar-collapsed-clickable').on('click', function() {
        if ('350px' === $('.content').css('margin-right')) {
            collapseSidebar();
        } else {
            expandSidebar();
        }
    });

    $('#go-back').on('click', function(event) {
        event.preventDefault();
        var linkToNewUI = $('#additionalOptionsLinkToNewUI').val();
        var paramsObject;
        if (linkToNewUI === "true") {
            paramsObject = {
                "newUI": "1clickoff"
            };
        } else {
            paramsObject = {
                "newUI": "false", "SS_PostParamDict": "disableOneClick"
            };
        };
        addParamsAndReload(paramsObject);
    });

    function addParamsAndReload(paramsObject) {
        var url = location.href;
        $.each( paramsObject, function( key, value ) {
            if (url.indexOf(key) > 0) {
                url = url.replace(new RegExp(key + "=[^&]+", ""), key + "=" + value);
            } else {
                if (url.indexOf("?") > 0) {
                    url = url + "&" + key + "=" + value;
                }
                else {
                    url = url + "?" + key + "=" + value;
                }
            }
        });
        window.open(url, "_blank");
    }

    $('#open-in-new-tab').on('click', function(event) {
        var selectedResource = $('.selected-resource').val();
        $('#open-in-new-tab').attr('href', selectedResource);
    });

    $(document).on("keydown", function(event) {
        if (event.ctrlKey && event.which == 190) {
            var dbName = $('.selected-resource').text();
            var url = $('.selected-resource').val();
            var linkType = $('.selected-resource').data("link-type");
            $('.show-link-data').html(dbName + "<br><br>Link Level: " + linkType + "<br><br>" + url + "<br><br>" + decodeURIComponent(url));
            $('.show-link').show();
        } else if (event.which == 27) {
            $('.show-link').hide();
        }
    });

    $('.show-link-close').on("click", function() {
        $('.show-link').hide();
    });

    $('#link-not-working, #linksToContent, .email-action, .export-action, .n, .breakout, .hide-sidebar, .locale-menu, #custom-links-control, #source-control').on("mousedown", function() {
        stopAutoCollapse = true;
    });

});

var stopAutoCollapse = false;

function autoCollapseSidebar() {
    if (!stopAutoCollapse) {
        collapseSidebar();
    }
}

function collapseSidebar() {
    jQuery('.sidebar').css('overflow-y', 'hidden');
    jQuery(".content").animate({"margin-right": "30px"}, "fast");
    jQuery(".sidebar").animate({"width": "30px"}, "fast");
    jQuery('.inner, .header').hide();
    jQuery('.controls').show();
}

function expandSidebar() {
    jQuery('.sidebar').css('overflow-y', 'auto');
    //bug fix: set overflow-y again in 500ms just in case
    setTimeout("jQuery('.sidebar').css('overflow-y', 'auto')", 500);
    jQuery(".content").animate({"margin-right": "350px"}, "fast");
    jQuery(".sidebar").animate({"width": "350px"}, "fast");
    jQuery('.inner, .header').show();
    jQuery('.controls').hide();
}
