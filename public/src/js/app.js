   
/*************On page load ******************************/
$(document).ready(function()
{
    $('#name').focus();
    $('#approxage').attr("disabled","disabled");
    $('#dob').removeAttr("disabled");
    //Datemask dd/mm/yyyy
    $("#datemask").inputmask("dd/mm/yyyy", {"placeholder": "dd/mm/yyyy"});
    //Datemask2 mm/dd/yyyy
    $("#datemask2").inputmask("mm/dd/yyyy", {"placeholder": "mm/dd/yyyy"});
    //Money Euro
    $("[data-mask]").inputmask();

    $('input[type="checkbox"].minimal, input[type="radio"].minimal').iCheck({
        checkboxClass: 'icheckbox_minimal-blue',
        radioClass: 'iradio_minimal-blue'
    });
    $('#slotdate').datepicker({
        autoclose: true,
        format: "dd/mm/yyyy",
        startDate: new Date(),
        todayHighlight: true
    });
});
/***********************End on page load**********************************/
$("#doc").click(function(){
    $('#name').focus();
    $("#speciality").attr("disabled",false);
    $("#speciality").val("22");
    $('#medicalcouncil').attr("disabled",false);
    $('#medicalcouncil').val(" ");
    $('#medico').show();
    $('#registrationyear').attr("disabled",false);
    $('#registrationyear').val(" ");
    $('#medico').show();
});

/*********************** end register.blade.php *****************/    

/******************** start create patient ***********************/
   
$("#cbage").click(function(){
    if($(this).prop('checked')==true){
        $("#approxage").removeAttr("disabled");
        $("#approxage").focus();
        $("#dob").val("");
        $("#dob").attr("disabled","disabled");
        $("#approxage").change(function(){
            $test = $('#approxage').val();
            $mom = moment().subtract($test,'years').format('01-01-YYYY');
            $("#approxdob").val($mom);
            console.log($mom);
        });
    }else{
        $("#approxage").attr("disabled","disabled");
        $("#dob").removeAttr("disabled");
        $("#approxage").val("");
        $("#dob").focus();
    }

});

$('#jobtype').on('change', function() {
    var jobtype = $("#jobtype option:selected").text();
    if(jobtype!='Doctor'){
        $("#rid").hide();
    }else{

        $("#rid").show();
    }

});

/*******************Show patient Ajax*********************/
function showpatient(p){

  url = url.replace(':id', p);
  window.location=url;

};  
/**********************************************************/
/*****************Pateint edit*****************************/



          $('#name').on('input',function(){
      $('#namemidsur').val('');
      $nameval = $('#name').val().trim();
      $midval = $('#midname').val().trim();
      $surname = $('#surname').val().trim();
      $nms = $nameval + $midval + $surname;
      $ns = $nameval + $surname; 
      $('#namemidsur').val($nms);
      $('#namesur').val($ns);
      console.log($nms);
      console.log($ns);
    });

    $('#midname').on('input',function(){
      $('#namemidsur').val('');
      $nameval = $('#name').val().trim();
      $midval = $('#midname').val().trim();
      $surname = $('#surname').val().trim();
      $nms = $nameval + $midval + $surname;
      $ns = $nameval + $surname;
      $('#namemidsur').val($nms);
      $('#namesur').val($ns);
      console.log($nms);
      console.log($ns);
    });

    $('#surname').on('input',function(){
      $('#namemidsur').val('');
      $nameval = $('#name').val().trim();
      $midval = $('#midname').val().trim();
      $surname = $('#surname').val().trim();
      $nms = $nameval + $midval + $surname;
      $ns = $nameval + $surname;
      $('#namemidsur').val($nms);
      $('#namesur').val($ns);
      console.log($nms);
      console.log($ns);
    });
/*************************End Patient edit*********************************/
