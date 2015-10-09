$(document).ready(function() {
   
    $('#btnSave').click(function() {
        
        $('#frmEthnic').submit();
    });
    
    $('#ethnic').hide();
    
    $('#btnAdd').click(function() {
        $('#ethnic').show();
        $('.top').hide();
        $('#ethnic_name').val('');
        $('#ethnic_ethnicId').val('');
        $('#ethnicHeading').html(lang_addEthnic);
        $(".messageBalloon_success").remove();
    });
    
    $('#btnCancel').click(function() {
        $('#ethnic').hide();
        $('.top').show();
        $('#btnAdd').show();
        validator.resetForm();
    });
    
    
    $('a[href="javascript:"]').click(function(){
		var row = $(this).closest("tr");
		var jobId = row.find('input').val();
		var url = ethnicInfoUrl+jobId;
        $('#ethnicHeading').html(lang_editEthnic);
		getEthnicInfo(url);

	});
    
    $('#btnDelete').attr('disabled', 'disabled');

        
    $("#ohrmList_chkSelectAll").click(function() {
        if($(":checkbox").length == 1) {
            $('#btnDelete').attr('disabled','disabled');
        }
        else {
            if($("#ohrmList_chkSelectAll").is(':checked')) {
                $('#btnDelete').removeAttr('disabled');
            } else {
                $('#btnDelete').attr('disabled','disabled');
            }
        }
    });
    
    $(':checkbox[name*="chkSelectRow[]"]').click(function() {
        if($(':checkbox[name*="chkSelectRow[]"]').is(':checked')) {
            $('#btnDelete').removeAttr('disabled');
        } else {
            $('#btnDelete').attr('disabled','disabled');
        }
    });

    $('#btnDelete').click(function(){
        $('#frmList_ohrmListComponent').submit(function(){
            $('#deleteConfirmation').dialog('open');
            return false;
        });
    });

    $('#frmList_ohrmListComponent').attr('name','frmList_ohrmListComponent');
    $('#dialogDeleteBtn').click(function() {
        document.frmList_ohrmListComponent.submit();
    });
    $('#dialogCancelBtn').click(function() {
        $("#deleteConfirmation").dialog("close");
    });
    
    $.validator.addMethod("uniqueName", function(value, element, params) {
        var temp = true;
        var currentJobCat;
        var id = $('#ethnic_ethnicId').val();
        var vcCount = ethnicList.length;
        for (var j=0; j < vcCount; j++) {
            if(id == ethnicList[j].id){
                currentJobCat = j;
            }
        }
        var i;
        vcName = $.trim($('#ethnic_name').val()).toLowerCase();
        for (i=0; i < vcCount; i++) {

            arrayName = ethnicList[i].name.toLowerCase();
            if (vcName == arrayName) {
                temp = false
                break;
            }
        }
        if(currentJobCat != null){
            if(vcName == ethnicList[currentJobCat].name.toLowerCase()){
                temp = true;
            }
        }
		
        return temp;
    });
    
    var validator = $("#frmEthnic").validate({

        rules: {
            'ethnic[name]' : {
                required:true,
                maxlength: 50,
                uniqueName: true
            }
        },
        messages: {
            'ethnic[name]' : {
                required: lang_NameRequired,
                maxlength: lang_exceed50Charactors,
                uniqueName: lang_uniqueName
            }

        }

    });
});

function getEthnicInfo(url){
    
    $.getJSON(url, function(data) {
		$('#ethnic_ethnicId').val(data.id);
		$('#ethnic_name').val(data.name);
		$('#ethnic').show();
		$(".messageBalloon_success").remove();
        $('.top').hide();
	});
}