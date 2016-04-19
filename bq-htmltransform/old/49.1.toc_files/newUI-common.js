jQuery(function($){

	var renderBCM = function(form, element) {
		$(element).html("<img id='spinner' src='./alEJPStatic/img/spinner.gif'/>");
		
		var data = $(form).serializeArray();
		data.push({name: "ajax",   value: "true"});
		data.push({name: "newui",  value: "true"});
		
		for (var o in CustomTexts) {
			data.push({name: 'custom_texts['+o+']',   value: CustomTexts[o]});
		}
		
		var query = $.param(data);
		
		$.ajax({
			url:  './exportCitation', 
			type: 'POST', 
			data: query,
			timeout: 2000
			
		}).done(function (response) {
			
			if (response == "Unable to retrieve citation style."){
				$(element).html(CustomTexts.quickBibErrorMessage);
			} else {
				$(element).html(response.formattedOutput);
			}

            try {
                if (!(ArticleLinker === undefined)) {
                    ArticleLinker.QATool.log("Cite", "<strong>Raw Query</strong><br /><pre>"+response.rawInput+"</pre>");
                }
            } catch (e) {
                // Nothing to do!
            }
			
		}).fail( function () {
			$(element).html(CustomTexts.quickBibErrorMessage);
			
		});
	};

var language = $('.locale-menu').val();
if (language === "ar-sa" || language === "he") {
	$("body").attr("dir", "rtl");
}
	
$('.locale-menu').on('change', function() {
	replaceParamAndReload('paramdict', this.value);
});

$('.email-action').on('click', function(event) {
	event.preventDefault();
	if ($('.email-form').is(':visible')) {
		$('.email-cancel').click();
	} else {
		$('.email-form input[type="text"],textarea').val("");
		$('.email-form input[type="radio"]:first').click();
		$('.email-form select').prop('selectedIndex', 0);
		$('.export-form, .report-problem-form, .interlibrary-loan-form').hide();
		$('.email-form').show();
		$('.export-action').removeClass("active");
		$(this).addClass("active");
		$("#email-citation-style-render").html("");
		$("#email-citation-style-render").hide();
	}
});

$('#emailForm').on('submit', function (event) {
	if (!validateEmail()) {
		return false;
	}
	$("#browserURL").val(window.location);
	event.preventDefault();

    var data = $('#emailForm').serializeArray();
    data.push({name: "newui",  value: "true"});
    for (var o in CustomTexts) {
        data.push({name: 'custom_texts['+o+']',   value: CustomTexts[o]});
    }
    var query = $.param(data);


    $.ajax({
	    url: './exportCitation',
	    type: 'POST',
	    data: query
	}).done( function (response) {
		handleEmailConfirmation();
	}).fail( function () {
	    // console.log("There was an error sending email.");
	});
});

$('.email-cancel').on('click', function(event) {
	event.preventDefault();		
	$('.email-form').hide();
	$('.email-validation-message').hide();
	$('.email-action').removeClass("active");	
});

function validateEmail() {
	var name = $("#senderName").val();
	var email = $("#recipEmail").val();
	var subject = $("#mailSubject").val();
	if (name.length == 0 || email.length == 0 || subject.length == 0) {
		$('.email-validation-message').show();
		return false;
	} else {
		return true;
	}
}

function handleEmailConfirmation() {
	var regEx = new RegExp("\\%1", "g");
	var message = $("#emailSuccessMessage").val();
	var email = $("#recipEmail").val();
	var confirmationMessage = message.replace(regEx, email);
	$(".email-confirmation").text(confirmationMessage);	
	$('.email-cancel').click();
	$('.email-confirmation').show();
	setTimeout("jQuery('.email-confirmation').hide()", 2000);
}

$('.export-action').on('click', function(event) {
	event.preventDefault();
	if ($('.export-form').is(':visible')) {
		$('.export-cancel').click();
	} else {
		$('.export-form input[type="radio"]:first').click();
		$('.export-form select').prop('selectedIndex', 0);
		$("#export-citation-style-select").hide();
		$('.email-form, .report-problem-form, .interlibrary-loan-form').hide();
		$('.export-form').show();
		$('.email-action').removeClass("active");
		$(this).addClass("active");
	}
});

for (var o in CustomTexts) {
    var input = $("<input>")
        .attr("type", "hidden")
        .attr("name", 'custom_texts['+o+']').val(CustomTexts[o]);

    $('#exportForm').append($(input));
}

$('#exportForm').on('submit', function (event) {
	var exportType = $('input[name=itemExportType]:checked', '#exportForm').val();
	if (exportType != null && (exportType == "directlytoflow" || exportType == "refworks" || exportType == "endnoteweb")) {
		$("#exportForm").prop("target", "_blank");
		
	} else if (exportType != null && exportType == "saveasris"){
		// Nothing to do!
		
	} else { // validate style
		// var style = $("select[id='export-citation-style']").val();
		// if (typeof style ==  undefined || style === null || style === '') { return false; }
	}
	$('.export-cancel').click();
});

$('.export-cancel').on('click', function(event) {
	event.preventDefault();		
	$('.export-form').hide();
	$('.export-action').removeClass("active");
});

$('.export-citation-style').on('change', function() {
	var value = this.value;
	var style = $("select[id='export-citation-style']").val();
	
	if (value == 'refworks' || value == 'endnoteweb' || value == 'desktop' || value == 'saveasris' || value == 'directlytoflow') {
		$("#export-citation-style-select").hide();
		$("#export-citation-style-render").html("");
		$("#export-citation-style-render").hide();
	}
	else {
		$("#export-citation-style-render").html("");
		$("#export-citation-style-select").show();
		
		if (style && (value == 'saveasplaintext' || value == 'saveashtml' || value == 'saveascsv')) {
			renderBCM("form[name='exportCitationForm']","#export-citation-style-render");
			$("#export-citation-style-render").show();
		} else {
			$("#export-citation-style-render").html("...");
			$("#export-citation-style-render").hide();
		}
	}
});

$('#custom-links-control').on("click", function() {
	$(this).next().slideToggle("fast", function() {
		$('.custom-links-open').toggle();
		$('.custom-links-close').toggle();
	});
});

$(".custom-links-header").hover(
	function() {
		$(".custom-links-open, .custom-links-close").removeClass('caret-plain');
		$(".custom-links-open, .custom-links-close").addClass('caret-hover');
	}, function() {
		$(".custom-links-open, .custom-links-close").addClass('caret-plain');
		$(".custom-links-open, .custom-links-close").removeClass('caret-hover');
	}
);

// Start Ulrichs and Syndetics
//Replace 1px image on single result page on load
if ($("#syndetics-cover-image").length > 0 && $("#syndetics-cover-image").width() < 5) {
	$("#syndetics").hide();
	$("#replace-one-pixel-cover-image").show();
}

function replaceOnePixelCoverImageSidebar() {
	if ($("#syndetics-cover-image-sidebar").length > 0 && $("#syndetics-cover-image-sidebar").width() < 5) {
		$("#syndetics").hide();
		$("#replace-one-pixel-cover-image").show();
	}
}

var gotUlrichsData = false;

$('#ulrichs-control').on("click", function(event) {
	event.preventDefault();
	$('#ulrichs-spinner').show();
	if (gotUlrichsData) {
		toggleJournalDetails();
	} else {
		getUlrichsData();
	}
});

function getUlrichsData() {   
    $.ajax({
	    url: './ulrichJournalInfo',
	    type: 'POST',
	    data: $('#ulrichsForm').serialize()
	}).done( function (data) {	
		gotUlrichsData = true;
		setUlrichsData(data);
	}).fail( function () {
	    console.log("ERROR getting Ulrichs data");
	    $("#ulrichs-data-no").show();
	    toggleJournalDetails();
	});
}

function setUlrichsData(data) {
	if (data != null && data.status === "Success") {
		var yes = $("#yesLabel").val();
		var no = $("#noLabel").val();		
		if (data.results[0].refereed) {
			$("#ulrichsReviewed").text(yes);
		} else {
			$("#ulrichsReviewed").text(no);
		}			
		if (data.results[0].openAccess) {
			$("#ulrichsOpenAccess").text(yes);
		} else {
			$("#ulrichsOpenAccess").text(no);
		}
		var description = data.results[0].description != null ? data.results[0].description : "&nbsp;";
		var frequency = data.results[0].frequency != null ? data.results[0].frequency : "&nbsp;";
		var country = data.results[0].country != null ? data.results[0].country : "&nbsp;";
		$("#ulrichsDescription").html(description);
		$("#ulrichsFrequency").html(frequency);
		$("#ulrichsCountry").html(country);
		$("#ulrichsSubjects").html("&nbsp;");
		$("#ulrichsLanguages").html("&nbsp;");
		$("#ulrichsContentTypes").html("&nbsp;");
		var subjectLength = data.results[0].subject.length;
		$.each(data.results[0].subject, function( index, value ) {
			$("#ulrichsSubjects").append(value);
			if (index < subjectLength-1) {
				$("#ulrichsSubjects").append(", ");
			}
		});
		var languagesLength = data.results[0].languages.length;
		$.each(data.results[0].languages, function( index, value ) {
			$("#ulrichsLanguages").append(value);
			if (index < languagesLength-1) {
				$("#ulrichsLanguages").append(", ");
			}
		});
		var contentTypesLength = data.results[0].contentTypes.length;
		$.each(data.results[0].contentTypes, function( index, value ) {
			$("#ulrichsContentTypes").append(value);
			if (index < contentTypesLength-1) {
				$("#ulrichsContentTypes").append(", ");
			}
		});	
		$("#ulrichs-data-yes").show();
	} else {
		$("#ulrichs-data-no").show();
	}
	toggleJournalDetails();
}

function toggleJournalDetails() {
	$('#ulrichs-header').next().next().slideToggle("fast", function() {
		$('.ulrichs-open').toggle();
		$('.ulrichs-close').toggle();
	});
	replaceOnePixelCoverImageSidebar();
	$('#ulrichs-spinner').hide();
}
//End Ulrichs and Syndetics

//Start Interlibrary Loan functions
$('.interlibrary-loan').on('click', function(event) {
	event.preventDefault();	
	if ($('.interlibrary-loan-form').is(':visible')) {
		$('.interlibrary-loan-cancel').click();
		return false;
	}
	$('.email-action, .export-action').removeClass("active");
	$('.export-form, .email-form, .report-problem-form').hide();
	$("#interlibraryLoanName").val("");
	$("#interlibraryLoanEmail").val("");
	$("#interlibraryLoanPhone").val("");
	$("#interlibraryLoanMessage").val("");
	$(".interlibrary-loan-form").show();
});

$('.interlibrary-loan-cancel').on('click', function(event) {		
	$('.interlibrary-loan-form').hide();
	console.log("cancel from common");
});

$('.interlibrary-loan-send').on('click', function(event) {	
	$("#intLibLoanName").val($("#interlibraryLoanName").val());
	$("#intLibLoanEmail").val($("#interlibraryLoanEmail").val());
	$("#intLibLoanPhone").val($("#interlibraryLoanPhone").val());
	$("#intLibLoanMessage").val($("#interlibraryLoanMessage").val());
	$("#intLibLoanReferringURL").val(window.location);
	
	$.ajax({
	    url: './interlibraryLoan',
	    type: 'POST',
	    data: $('#interlibraryLoanForm').serialize()
	}).done( function (response) {
		showInterlibraryLoanConfirmation();
		// console.log("Interlibrary Loan request was sent.");	
	}).fail( function () {
	    // console.log("There was an error sending an Interlibrary Loan request.");
	});
	
	$('.interlibrary-loan-form').hide();
});

function showInterlibraryLoanConfirmation() {
	$('.interlibrary-loan-confirmation').show();
	setTimeout("jQuery('.interlibrary-loan-confirmation').hide()", 3000);
}
// End Interlibrary Loan functions

// BCM Events Export Form 
$("select[id='export-citation-style']").on('change', function (event) {
	var style = $("select[id='export-citation-style']").val();
	if (style) {
		$("#export-citation-style-render").show();
		renderBCM("form[name='exportCitationForm']","#export-citation-style-render");
	} else {
		$("#export-citation-style-render").html("");
		$("#export-citation-style-render").hide();
	}
});

// BCM Events Email Form
$("select[id='citation-style']").on('change', function (event) {
	var style = $("select[id='citation-style']").val();
	if (style) {
		$("#email-citation-style-render").show();
		renderBCM("form[name='emailCitationForm']","#email-citation-style-render");
	} else {
		$("#email-citation-style-render").html("");
		$("#email-citation-style-render").hide();
	}
});


});
