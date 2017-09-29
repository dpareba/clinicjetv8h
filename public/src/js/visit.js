var prescrip = [];
var prescriprowcount = 0;

$(document).ready(function(){

	$('#chiefcomplaints').focus();
	var repeatval = $('#repeatid').val();
	if(repeatval == 0){
		console.log('no repeat');
	}
	else{
		console.log('repeat');
		console.log(repeatval);
		$.ajax({
				type: "GET",
				url : "/repeatvisit",
				data : {rept : repeatval},
				success: function(response){
					console.log('Passed');
					console.log(JSON.stringify(response));
					console.log(response['chiefcomplaints']);
					$('#chiefcomplaints').val(response['visit']['chiefcomplaints']);
					$('#patienthistory').val(response['visit']['patienthistory']);
					$('#examinationfindings').val(response['visit']['examinationfindings']);
					$('#diagnosis').val(response['visit']['diagnosis']);
					$('#advise').val(response['visit']['advise']);
					$('#systolic').val(response['visit']['systolic']);
					$('#diastolic').val(response['visit']['diastolic']);
					$('#randombs').val(response['visit']['randombs']);
					$('#pulse').val(response['visit']['pulse']);
					$('#resprate').val(response['visit']['resprate']);
					$('#spo').val(response['visit']['spo']);
					$('#height').val(response['visit']['height']);
					$('#weight').val(response['visit']['weight']);
					$('#bmi').val(response['visit']['bmi']);
					if (response['visit']['isSOS']==0) {
						$("#followuptype").val("Days").change();
					   $dateval = moment(response['visit']['nextvisit']).format('DD-MM-YYYY');
						$('#nextvisit').val($dateval);
					}else{
						$("#followuptype").val("SOS").change();

						
					}
					console.log(response['pathology'].length);
					
					options = "";
					for (var i = 0; i < response['pathology'].length; i++) {

						options += "<option selected value='" + response['pathology'][i]['id'] + "'>" + response['pathology'][i]['name'] + "</option>";

					}
					console.log(options);
					$('#pathology').append(options);
					console.log(response['prescriprepeat'].length);

					prescripopt = "";
					meddisplayname = "";

					for (var i = 0; i < response['prescriprepeat'].length; i++) {
						if (response['prescriprepeat'][i]['medicinecomposition']!="") {
							meddisplayname = response['prescriprepeat'][i]['medicinename'] + ' (' + response['prescriprepeat'][i]['medicinecomposition'] + ')'
						}else{
							meddisplayname = response['prescriprepeat'][i]['medicinename']
						}
					prescripopt +='<li class="plist"><input type="hidden" name="medid[]" value="'+ response['prescriprepeat'][i]['medicine_id'] +'"><input type="hidden" name="mednameonly[]" value="'+ response['prescriprepeat'][i]['medicinename'] +'"><input type="hidden" name="medcomp[]" value="'+ response['prescriprepeat'][i]['medicinecomposition'] +'"><small class="label label-danger"><i class="fa fa-heartbeat"></i> Brand Name</small><span class="text">'+ meddisplayname +'</span><div class="pull-right"><a class="rem" style="color: crimson;"><i class="fa fa-trash"></i></a></div><br><input type="hidden" name="doseduration[]" value="'+ response['prescriprepeat'][i]['doseduration'] +'"><small class="label label-warning"><i class="fa fa-calendar-check-o"></i> Dose Duration</small><span class="text">'+ response['prescriprepeat'][i]['doseduration'] +'</span> |<input type="hidden" name="dosetimings[]" value="'+ response['prescriprepeat'][i]['dosetimings'] +'"><small class="label label-primary"><i class="fa fa-clock-o"></i> Dose Timings</small><span class="text">'+ response['prescriprepeat'][i]['dosetimings'] +'</span> |<input type="hidden" name="doseregime[]" value="'+ response['prescriprepeat'][i]['doseregime'] +'"><small class="label label-success"><i class="fa fa-asterisk "></i> Dose Regime</small><span class="text">'+ response['prescriprepeat'][i]['doseregime'] +'</span><br><input type="hidden" name="remarks[]" value="'+ response['prescriprepeat'][i]['remarks'] +'"><small class="label label-info"><i class="fa fa-comments "></i> Remarks</small><span class="text">'+ response['prescriprepeat'][i]['remarks'] +'</span></li>';
					}
				  	$('#scriplist').append(prescripopt);
				},
				error: function(data){
					console.log('Failed');
				}

			});//end
		};
							
		//Datemask dd/mm/yyyy
			$("#datemask").inputmask("dd/mm/yyyy", {"placeholder": "dd/mm/yyyy"});
    		//Datemask2 mm/dd/yyyy
    		$("#datemask2").inputmask("mm/dd/yyyy", {"placeholder": "mm/dd/yyyy"});
    		//Money Euro
    		$("[data-mask]").inputmask();
    		//console.log( "document loaded Dilip" );
    		$("#numdayslabel").hide();
    		$('#numdays').hide();
    		$("#nextvisitlabel").hide();
    		$("#nextvisit").hide();
			//$('#days').find('option[value="SOS"]').attr("selected", "selected");
			$("#followuptype").val("SOS").change();
			$("#doseregime1").val("M-A-N").change();
			$("#dosetime").val("bf").change();
			$("#doseduration").val("days").change();
			$('.doseregimespecial').hide();
			$('.dosetimespecial').hide();
			
			$('#dosemorning').empty();
			$('#doseafternoon').empty();
			$('#dosenight').empty();
			$('#dosemorning').append($('<option></option>').val('0').html('0'));
			$('#dosemorning').append($('<option></option>').val('1/4').html('1/4'));
			$('#dosemorning').append($('<option></option>').val('1/2').html('1/2'));
			$('#dosemorning').append($('<option></option>').val('1').html('1'));
			$('#dosemorning').append($('<option></option>').val('2').html('2'));
			$('#dosemorning').append($('<option></option>').val('3').html('3'));
			$('#dosemorning').append($('<option></option>').val('4').html('4'));
			$('#doseafternoon').append($('<option></option>').val('0').html('0'));
			$('#doseafternoon').append($('<option></option>').val('1/4').html('1/4'));
			$('#doseafternoon').append($('<option></option>').val('1/2').html('1/2'));
			$('#doseafternoon').append($('<option></option>').val('1').html('1'));
			$('#doseafternoon').append($('<option></option>').val('2').html('2'));
			$('#doseafternoon').append($('<option></option>').val('3').html('3'));
			$('#doseafternoon').append($('<option></option>').val('4').html('4'));
			$('#dosenight').append($('<option></option>').val('0').html('0'));
			$('#dosenight').append($('<option></option>').val('1/4').html('1/4'));
			$('#dosenight').append($('<option></option>').val('1/2').html('1/2'));
			$('#dosenight').append($('<option></option>').val('1').html('1'));
			$('#dosenight').append($('<option></option>').val('2').html('2'));
			$('#dosenight').append($('<option></option>').val('3').html('3'));
			$('#dosenight').append($('<option></option>').val('4').html('4'));

			$("#dosedurationdays").empty();
			$('.dosedurationdays').show();
			$("#dosedurationdayslabel").text("Days");
			$('#dosedurationdays').append($('<option></option>').val('1').html('1'));
			$('#dosedurationdays').append($('<option></option>').val('2').html('2'));
			$('#dosedurationdays').append($('<option></option>').val('3').html('3'));
			$('#dosedurationdays').append($('<option></option>').val('4').html('4'));
			$('#dosedurationdays').append($('<option></option>').val('5').html('5'));
			$('#dosedurationdays').append($('<option></option>').val('6').html('6'));
			$('#dosedurationdays').append($('<option></option>').val('7').html('7'));
			$('#dosedurationdays').append($('<option></option>').val('8').html('8'));
			$('#dosedurationdays').append($('<option></option>').val('9').html('9'));
			$('#dosedurationdays').append($('<option></option>').val('10').html('10'));
			$('#dosedurationdays').append($('<option></option>').val('11').html('11'));
			$('#dosedurationdays').append($('<option></option>').val('12').html('12'));
			$('#dosedurationdays').append($('<option></option>').val('13').html('13'));
			$('#dosedurationdays').append($('<option></option>').val('14').html('14'));
			$('#dosedurationdays').append($('<option></option>').val('15').html('15'));
			$('#dosedurationdays').append($('<option></option>').val('16').html('16'));
			$('#dosedurationdays').append($('<option></option>').val('17').html('17'));
			$('#dosedurationdays').append($('<option></option>').val('18').html('18'));
			$('#dosedurationdays').append($('<option></option>').val('19').html('19'));
			$('#dosedurationdays').append($('<option></option>').val('20').html('20'));
			$('#dosedurationdays').append($('<option></option>').val('21').html('21'));
			$('#dosedurationdays').append($('<option></option>').val('22').html('22'));
			$('#dosedurationdays').append($('<option></option>').val('23').html('23'));
			$('#dosedurationdays').append($('<option></option>').val('24').html('24'));
			$('#dosedurationdays').append($('<option></option>').val('25').html('25'));
			$('#dosedurationdays').append($('<option></option>').val('26').html('26'));
			$('#dosedurationdays').append($('<option></option>').val('27').html('27'));
			$('#dosedurationdays').append($('<option></option>').val('28').html('28'));
			$('#dosedurationdays').append($('<option></option>').val('29').html('29'));
			$('#dosedurationdays').append($('<option></option>').val('30').html('30'));
			$('#dosedurationdays').append($('<option></option>').val('31').html('31'));

			$('#doseduration').change(function(){
				$(this).find("option:selected").each(function(){
					var doseduropt = $(this).attr("value");
					if(doseduropt == "days"){
						$("#dosedurationdays").empty();
						$('.dosedurationdays').show();
						$("#dosedurationdayslabel").text("Days");
						$('#dosedurationdays').append($('<option></option>').val('1').html('1'));
						$('#dosedurationdays').append($('<option></option>').val('2').html('2'));
						$('#dosedurationdays').append($('<option></option>').val('3').html('3'));
						$('#dosedurationdays').append($('<option></option>').val('4').html('4'));
						$('#dosedurationdays').append($('<option></option>').val('5').html('5'));
						$('#dosedurationdays').append($('<option></option>').val('6').html('6'));
						$('#dosedurationdays').append($('<option></option>').val('7').html('7'));
						$('#dosedurationdays').append($('<option></option>').val('8').html('8'));
						$('#dosedurationdays').append($('<option></option>').val('9').html('9'));
						$('#dosedurationdays').append($('<option></option>').val('10').html('10'));
						$('#dosedurationdays').append($('<option></option>').val('11').html('11'));
						$('#dosedurationdays').append($('<option></option>').val('12').html('12'));
						$('#dosedurationdays').append($('<option></option>').val('13').html('13'));
						$('#dosedurationdays').append($('<option></option>').val('14').html('14'));
						$('#dosedurationdays').append($('<option></option>').val('15').html('15'));
						$('#dosedurationdays').append($('<option></option>').val('16').html('16'));
						$('#dosedurationdays').append($('<option></option>').val('17').html('17'));
						$('#dosedurationdays').append($('<option></option>').val('18').html('18'));
						$('#dosedurationdays').append($('<option></option>').val('19').html('19'));
						$('#dosedurationdays').append($('<option></option>').val('20').html('20'));
						$('#dosedurationdays').append($('<option></option>').val('21').html('21'));
						$('#dosedurationdays').append($('<option></option>').val('22').html('22'));
						$('#dosedurationdays').append($('<option></option>').val('23').html('23'));
						$('#dosedurationdays').append($('<option></option>').val('24').html('24'));
						$('#dosedurationdays').append($('<option></option>').val('25').html('25'));
						$('#dosedurationdays').append($('<option></option>').val('26').html('26'));
						$('#dosedurationdays').append($('<option></option>').val('27').html('27'));
						$('#dosedurationdays').append($('<option></option>').val('28').html('28'));
						$('#dosedurationdays').append($('<option></option>').val('29').html('29'));
						$('#dosedurationdays').append($('<option></option>').val('30').html('30'));
						$('#dosedurationdays').append($('<option></option>').val('31').html('31'));
					}else if(doseduropt == "weeks"){
						$("#dosedurationdays").empty();
						$('.dosedurationdays').show();
						$("#dosedurationdayslabel").text("Weeks");
						$('#dosedurationdays').append($('<option></option>').val('1').html('1'));
						$('#dosedurationdays').append($('<option></option>').val('2').html('2'));
						$('#dosedurationdays').append($('<option></option>').val('3').html('3'));
						$('#dosedurationdays').append($('<option></option>').val('4').html('4'));
						$('#dosedurationdays').append($('<option></option>').val('5').html('5'));
						$('#dosedurationdays').append($('<option></option>').val('6').html('6'));
					}else if(doseduropt == "months"){
						$("#dosedurationdays").empty();
						$('.dosedurationdays').show();
						$("#dosedurationdayslabel").text("Months");
						$('#dosedurationdays').append($('<option></option>').val('1').html('1'));
						$('#dosedurationdays').append($('<option></option>').val('2').html('2'));
						$('#dosedurationdays').append($('<option></option>').val('3').html('3'));
						$('#dosedurationdays').append($('<option></option>').val('4').html('4'));
						$('#dosedurationdays').append($('<option></option>').val('5').html('5'));
						$('#dosedurationdays').append($('<option></option>').val('6').html('6'));
						$('#dosedurationdays').append($('<option></option>').val('7').html('7'));
						$('#dosedurationdays').append($('<option></option>').val('8').html('8'));
						$('#dosedurationdays').append($('<option></option>').val('9').html('9'));
						$('#dosedurationdays').append($('<option></option>').val('10').html('10'));
						$('#dosedurationdays').append($('<option></option>').val('11').html('11'));
						$('#dosedurationdays').append($('<option></option>').val('12').html('12'));
					}else if(doseduropt == "years"){
						$("#dosedurationdays").empty();
						$('.dosedurationdays').show();
						$("#dosedurationdayslabel").text("Years");
						$('#dosedurationdays').append($('<option></option>').val('1').html('1'));
						$('#dosedurationdays').append($('<option></option>').val('2').html('2'));
						$('#dosedurationdays').append($('<option></option>').val('3').html('3'));
						$('#dosedurationdays').append($('<option></option>').val('4').html('4'));
						$('#dosedurationdays').append($('<option></option>').val('5').html('5'));
					}else if(doseduropt == "sos"){
						$('.dosedurationdays').hide();
					}else if(doseduropt == "lifetime"){
						$('.dosedurationdays').hide();
					}
				});
});

$('#dosetime').change(function(){
	$(this).find("option:selected").each(function(){
		var dtoption = $(this).attr("value");
		if(dtoption=="bf"){
			$('.dosetimespecial').hide();
		}else if(dtoption == "af"){
			$('.dosetimespecial').hide();
		}else if(dtoption == "wf"){
			$('.dosetimespecial').hide();
		}else if(dtoption == "oth"){
			$('.dosetimespecial').show();
		}
	});
});

$("#doseregime1").change(function(){
	$(this).find("option:selected").each(function(){
		var hell = $(this).attr("value");
		if(hell == "M-A-N"){
			$('.dosemorning').show();
			$('.doseafternoon').show();
			$('.dosenight').show();

			$('#dosemorninglabel').text("Morning");
			$('#doseafternoonlabel').text("Afternoon");
			$('#dosenightlabel').text("Night");

			$('#dosemorninglabel').show();
			$('#doseafternoonlabel').show();
			$('#dosenightlabel').show();

			$('.doseregimespecial').hide();

			$('#dosemorning').show();
			$('#dosemorning').empty();
			$('#dosemorning').append($('<option></option>').val('0').html('0'));
			$('#dosemorning').append($('<option></option>').val('1/4').html('1/4'));
			$('#dosemorning').append($('<option></option>').val('1/2').html('1/2'));
			$('#dosemorning').append($('<option></option>').val('1').html('1'));
			$('#dosemorning').append($('<option></option>').val('2').html('2'));
			$('#dosemorning').append($('<option></option>').val('3').html('3'));
			$('#dosemorning').append($('<option></option>').val('4').html('4'));

			$('#doseafternoon').show();
			$('#doseafternoon').empty();
			$('#doseafternoon').append($('<option></option>').val('0').html('0'));
			$('#doseafternoon').append($('<option></option>').val('1/4').html('1/4'));
			$('#doseafternoon').append($('<option></option>').val('1/2').html('1/2'));
			$('#doseafternoon').append($('<option></option>').val('1').html('1'));
			$('#doseafternoon').append($('<option></option>').val('2').html('2'));
			$('#doseafternoon').append($('<option></option>').val('3').html('3'));
			$('#doseafternoon').append($('<option></option>').val('4').html('4'));

			$('#dosenight').show();
			$('#dosenight').empty();
			$('#dosenight').append($('<option></option>').val('0').html('0'));
			$('#dosenight').append($('<option></option>').val('1/4').html('1/4'));
			$('#dosenight').append($('<option></option>').val('1/2').html('1/2'));
			$('#dosenight').append($('<option></option>').val('1').html('1'));
			$('#dosenight').append($('<option></option>').val('2').html('2'));
			$('#dosenight').append($('<option></option>').val('3').html('3'));
			$('#dosenight').append($('<option></option>').val('4').html('4'));

		}else if(hell == "SOS"){
			$('#dosemorninglabel').text("SOS");
			$('.dosemorning').show();

			$('#dosemorninglabel').show();
			$('#doseafternoonlabel').hide();
			$('#dosenightlabel').hide();

			$('#dosemorning').show();
			$('#dosemorning').empty();
			$('#dosemorning').append($('<option></option>').val('0').html('0'));
			$('#dosemorning').append($('<option></option>').val('1').html('1'));
			$('#dosemorning').append($('<option></option>').val('2').html('2'));
			$('#dosemorning').append($('<option></option>').val('3').html('3'));
			$('#dosemorning').append($('<option></option>').val('4').html('4'));

			$('#doseafternoon').empty();
			$('#doseafternoon').hide();

			$('#dosenight').empty();
			$('#dosenight').hide();

			$('.doseregimespecial').hide();
		}else if(hell == "Other"){
			$('.doseregimespecial').show();
			$('.dosemorning').hide();
			$('.doseafternoon').hide();
			$('.dosenight').hide();
		}
	});

});

$("#followuptype").change(function(){
	$(this).find("option:selected").each(function(){
		var optionValue = $(this).attr("value");
		console.log(optionValue);
		if(optionValue == "SOS"){
			$("#numdayslabel").hide();
			$("#numdays").hide();
			$("#nextvisitlabel").hide();
			$("#nextvisit").hide();
		} else if(optionValue == "Days"){
			$("#nextvisitlabel").show();
			$("#nextvisit").show();
			$("#numdayslabel").text("(Days)");
			$("#numdayslabel").show();
			$("#numdays").show();
			$("#numdays").empty();

			$('#numdays').append($('<option></option>').val('1').html('1'));
			$('#numdays').append($('<option></option>').val('2').html('2'));
			$('#numdays').append($('<option></option>').val('3').html('3'));
			$('#numdays').append($('<option></option>').val('4').html('4'));
			$('#numdays').append($('<option></option>').val('5').html('5'));
			$('#numdays').append($('<option></option>').val('6').html('6'));
			$('#numdays').append($('<option></option>').val('7').html('7'));
			$('#numdays').append($('<option></option>').val('8').html('8'));
			$('#numdays').append($('<option></option>').val('9').html('9'));
			$('#numdays').append($('<option></option>').val('10').html('10'));
			$('#numdays').append($('<option></option>').val('11').html('11'));
			$('#numdays').append($('<option></option>').val('12').html('12'));
			$('#numdays').append($('<option></option>').val('13').html('13'));
			$('#numdays').append($('<option></option>').val('14').html('14'));
			$('#numdays').append($('<option></option>').val('15').html('15'));
			$('#numdays').append($('<option></option>').val('16').html('16'));
			$('#numdays').append($('<option></option>').val('17').html('17'));
			$('#numdays').append($('<option></option>').val('18').html('18'));
			$('#numdays').append($('<option></option>').val('19').html('19'));
			$('#numdays').append($('<option></option>').val('20').html('20'));
			$('#numdays').append($('<option></option>').val('21').html('21'));
			$('#numdays').append($('<option></option>').val('22').html('22'));
			$('#numdays').append($('<option></option>').val('23').html('23'));
			$('#numdays').append($('<option></option>').val('24').html('24'));
			$('#numdays').append($('<option></option>').val('25').html('25'));
			$('#numdays').append($('<option></option>').val('26').html('26'));
			$('#numdays').append($('<option></option>').val('27').html('27'));
			$('#numdays').append($('<option></option>').val('28').html('28'));
			$('#numdays').append($('<option></option>').val('29').html('29'));
			$('#numdays').append($('<option></option>').val('30').html('30'));
			$('#numdays').append($('<option></option>').val('31').html('31'));

			$test =	$('#numdays').val();
			$("#numdays").change(function(){
				$test =	$('#numdays').val();
				$mom = moment().add($test,'days').format('DD-MM-YYYY');
				$('#nextvisit').val($mom);
			});
			$mom = moment().add($test,'days').format('DD-MM-YYYY');

			$('#dp').val($mom);
			$('#nextvisit').val($mom);

			console.log($mom);
		}else if(optionValue == "Months"){
			$("#nextvisitlabel").show();
			$("#nextvisit").show();
			$("#numdayslabel").text("(Months)");
			$("#numdayslabel").show();
			$("#numdays").show();
			$("#numdays").empty();
			$('#numdays').append($('<option></option>').val('1').html('1'));
			$('#numdays').append($('<option></option>').val('2').html('2'));
			$('#numdays').append($('<option></option>').val('3').html('3'));
			$('#numdays').append($('<option></option>').val('4').html('4'));
			$('#numdays').append($('<option></option>').val('5').html('5'));
			$('#numdays').append($('<option></option>').val('6').html('6'));
			$('#numdays').append($('<option></option>').val('7').html('7'));
			$('#numdays').append($('<option></option>').val('8').html('8'));
			$('#numdays').append($('<option></option>').val('9').html('9'));
			$('#numdays').append($('<option></option>').val('10').html('10'));
			$('#numdays').append($('<option></option>').val('11').html('11'));
			$('#numdays').append($('<option></option>').val('12').html('12'));
			$test =	$('#numdays').val();
			$("#numdays").change(function(){
				$test =	$('#numdays').val();
				$mom = moment().add($test,'months').format('DD-MM-YYYY');
				$('#nextvisit').val($mom);
			});
			$mom = moment().add($test,'months').format('DD-MM-YYYY');
			$('#dp').val($mom);
			$('#nextvisit').val($mom);
		}
	});
});



$("#pathology").select2({

	ajax: {
		multiple:true,
		url: urlPathology,
		type: 'GET',
		dataType: 'json',
		delay:250,
		data: function(params){
			return {
				q: params.term,
			};
		},
		processResults: function(data, params){
			return{
				results:data,

			};
		},
		cache:true,
	},
	minimumInputLength:3
	// ,initSelection:function(element,callback){
	// 	callback({id:101,text:'Lipid Profile'});
	// }
	
});


$(".medname").select2({
	
	ajax: {
		multiple: false,
		url:urlMedicine,
		type:'GET',
		dataType:'json',
		delay:250,
		data: function(params){
			return {
        q: params.term, // search term
        //page: params.page
    };
},
processResults: function (data, params) {
      // parse the results into the format expected by Select2
      // since we are using custom formatting functions we do not need to
      // alter the remote JSON data, except to indicate that infinite
      // scrolling can be used
      //params.page = params.page || 1;

      return {
      	results: data,
      	// pagination: {
      	// 	more: (params.page * 30) < data.total_count
      	// }
      };
  },
  cache: true
},
//escapeMarkup: function (markup) { return markup; }, // let our custom formatter work
minimumInputLength: 3,
  //templateResult: formatRepo, // omitted for brevity, see the source of this page
  //templateSelection: formatRepoSelection // omitted for brevity, see the source of this page
});

// $( function() {

// 	$( "#chiefcomplaints" ).autocomplete({

//       source: '{{route('templates.showcc')}}',
//       minLength: 3
//   });
// } );

$(function(){
	$("#examinationfindings").autocomplete({
		source: "{{route('templates.showef')}}",
		minLength: 3
	});
});

$(function(){
	$('#weight').val('');
	$('#height').val('');
	$('#bmi').val('');
});

$('#weight').on('input',function(){
	if(($('#weight').val() == '')||($('#height').val() == '')){
		$('#bmi').val('');
	}else{
		$w = $('#weight').val();
		$h = $('#height').val()/100;
		$h = $h * $h;
		//console.log($w);
		//console.log($h);
		$bmi = $w/$h;
		$bmidec = $bmi.toFixed(1);
		//console.log($bmi);
		//console.log($bmidec);
		$('#bmi').val($bmidec);
	}

});

$('#height').on('input',function(){
	if(($('#weight').val() == '')||($('#height').val() == '')){
		$('#bmi').val('');
	}else{
		$w = $('#weight').val();
		$h = $('#height').val()/100;
		$h = $h * $h;
		
		$bmi = $w/$h;
		$bmidec = $bmi.toFixed(1);

		$('#bmi').val($bmidec);
	}

});

$("#bbb").click(function(){
	$('#consult').validate({
		onsubmit: false,
		rules:{
			medname: {
				required: true
			}
		},
		messages:{
			medname:{
				required: "Brand Name is required"
			}
		},
		errorPlacement: function(error,element){
			console.log(element.attr("name"));
			if(element.attr("name") == "medname"){
				error.appendTo("#messagebox");
			}
		},
		success:function(label,element){
			//Array prescrip is declared as an empty array on page load
			prescrip = [];
			//Array prescriprowcount is declared and intialized to 0 on page load, incremented on ever prescription added
			prescriprowcount++;

			var medicinename = $('.medname').select2('data')[0]['text'];
			var medicinecomp = $('.medname').select2('data')[0]['composition'];
			var mednameonly = $('.medname').select2('data')[0]['mednameonly'];
			var medicineid = $('.medname').select2('data')[0]['id'];
			var doseregimetype = $('#doseregime1').val();
			var doseregime = '';
			var dosetime = '';
			var dosetimetype = $('#dosetime').val();
			var doseduration = '';
			var dosedurationtype = $('#doseduration').val();
			var docremarks = $('#remarks').val();

			if(doseregimetype=="M-A-N"){
				doseregime = $('#dosemorning').val() + '-' + $('#doseafternoon').val() + '-' + $('#dosenight').val();
			}else if(doseregimetype=="SOS"){
				doseregime = 'SOS - ' + $('#dosemorning').val();
			}else if(doseregimetype=="Other"){
				doseregime = $('#doseregimespecial').val();
			}

			if(dosetimetype == "bf"){
				dosetime = 'Before Food';
			}else if(dosetimetype == "af"){
				dosetime = 'After Food';
			}else if(dosetimetype == "wf"){
				dosetime = 'With Food';
			}else if(dosetimetype == "oth"){
				dosetime = $('#dosetimespecial').val();
			}

			if(dosedurationtype == "days"){
				if($('#dosedurationdays').val() == "1"){
					doseduration = "1 Day";
				}else{
					doseduration = $('#dosedurationdays').val() + " Days";
				}
			}else if(dosedurationtype == "weeks"){
				if($('#dosedurationdays').val() == "1"){
					doseduration = "1 Week";
				}else{
					doseduration = $('#dosedurationdays').val() + " Weeks";
				}
			}else if(dosedurationtype == "months"){
				if($('#dosedurationdays').val() == "1"){
					doseduration = "1 Month";
				}else{
					doseduration = $('#dosedurationdays').val() + " Months";
				}
			}else if(dosedurationtype == "years"){
				if($('#dosedurationdays').val() == "1"){
					doseduration = "1 Year";
				}else{
					doseduration = $('#dosedurationdays').val() + " Years";
				}
			}else if(dosedurationtype == "sos"){
				doseduration = "SOS";
			}else if(dosedurationtype == "lifetime"){
				doseduration = "Lifetime";
			}

			prescrip.push(medicinename,doseregime,dosetime,doseduration,docremarks);
			//var nameasd = prescrip[3];
			//console.log(bn);
			// $('#scriplist').append('<li class="plist"><input type="hidden" name="medid[]" value="'+ medicineid +'"><small class="label label-danger"><i class="fa fa-heartbeat"></i> Brand Name</small><span class="text">'+ medicinename +'</span><div class="pull-right"><a class="rem" style="color: crimson;"><i class="fa fa-trash"></i></a></div><br><input type="hidden" name="doseduration[]" value="'+ doseduration +'"><small class="label label-warning"><i class="fa fa-calendar-check-o"></i> Dose Duration</small><span class="text">'+ doseduration +'</span> |<input type="hidden" name="dosetimings[]" value="'+ dosetime +'"><small class="label label-primary"><i class="fa fa-clock-o"></i> Dose Timings</small><span class="text">'+ dosetime +'</span> |<input type="hidden" name="doseregime[]" value="'+ doseregime +'"><small class="label label-success"><i class="fa fa-asterisk "></i> Dose Regime</small><span class="text">'+ doseregime +'</span><br><input type="hidden" name="remarks[]" value="'+ docremarks +'"><small class="label label-info"><i class="fa fa-comments "></i> Remarks</small><span class="text">'+ docremarks +'</span></li>');
			// 
			// $('#scriplist').append('<li class="plist"><input type="hidden" name="medid[]" value="'+ medicineid + '"><small class="label label-danger"><i class="fa fa-heartbeat"></i> Brand Name</small><span class="text">'+ medicinename +'</span><div class="pull-right"><a class="rem" style="color: crimson;"><i class="fa fa-trash"></i></a></div><br><small class="label label-warning"><i class="fa fa-calendar-check-o"></i> Dose Duration</small><span class="text">'+ doseduration +'</span> |<small class="label label-primary"><i class="fa fa-clock-o"></i> Dose Timings</small><span class="text">Before Food</span> |<small class="label label-success"><i class="fa fa-asterisk "></i> Dose Regime</small><span class="text">1-1-2</span><br><small class="label label-info"><i class="fa fa-comments "></i> Remarks</small><span class="text">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Quisquam distinctio s </span></li>');
			// 
			$('#scriplist').append('<li class="plist"><input type="hidden" name="medid[]" value="'+ medicineid +'"><input type="hidden" name="mednameonly[]" value="'+ mednameonly +'"><input type="hidden" name="medcomp[]" value="'+ medicinecomp +'"><small class="label label-danger"><i class="fa fa-heartbeat"></i> Brand Name</small><span class="text">'+ medicinename +'</span><div class="pull-right"><a class="rem" style="color: crimson;"><i class="fa fa-trash"></i></a></div><br><input type="hidden" name="doseduration[]" value="'+ doseduration +'"><small class="label label-warning"><i class="fa fa-calendar-check-o"></i> Dose Duration</small><span class="text">'+ doseduration +'</span> |<input type="hidden" name="dosetimings[]" value="'+ dosetime +'"><small class="label label-primary"><i class="fa fa-clock-o"></i> Dose Timings</small><span class="text">'+ dosetime +'</span> |<input type="hidden" name="doseregime[]" value="'+ doseregime +'"><small class="label label-success"><i class="fa fa-asterisk "></i> Dose Regime</small><span class="text">'+ doseregime +'</span><br><input type="hidden" name="remarks[]" value="'+ docremarks +'"><small class="label label-info"><i class="fa fa-comments "></i> Remarks</small><span class="text">'+ docremarks +'</span></li>');
			
			$(".medname").select2("val", " ");
			$("#doseregime1").val("M-A-N").change();
			$("#dosetime").val("bf").change();
			$("#dosetimespecial").val('');
			$("#doseregimespecial").val('');
			$('#doseduration').val("days").change();
			$('#remarks').val('');
			console.log(prescrip,prescriprowcount);
		}

	});
$('#consult').valid();
	//$("[name='medname']").valid();


$("#clear").click(function(){
	$(".medname").select2("val", " ");

});

$("#addmedicine").click(function(e){
	e.preventDefault();
	$.ajax({
		type: "POST",
		url: "/medicines",
		
		data: $("form.formmed").serialize(),
		success: function(response){
			$('#medname').val('');
			$("#myModal").modal('hide');

		},
		error: function(data){
			console.log(data.responseText);
			var obj = jQuery.parseJSON( data.responseText );
			if(obj.medname){
				$("#medname-error-label").addClass("has-warning");
				$( '#medname-error1' ).html( obj.medname );
			}

		}
	});
	return false;
});

$('#addpathology').click(function(e){
	e.preventDefault();
	$.ajax({
		type: "POST",
		url : "/pathologies",
		data: $("form.formpath").serialize(),
		success:function(response){
			$("#myPathModal").modal('hide');
		},
		error: function(data){
			console.log(data.responseText);
			var obj = jQuery.parseJSON( data.responseText );
			if(obj.pathname){
				$("#pathname-error-label").addClass("has-warning");
				$('#pathname-error').html( obj.pathname );
			}
			//alert('error');
		}
	});
	//return false;
});

$('#addcctemplate').click(function(e){
	e.preventDefault();
	$.ajax({
		type: "POST",
		url : "/storecc",
		data: $("form.formcc").serialize(),
		success:function(response){
			$("#ccModal").modal('hide');
		},
		error:function(data){
			console.log(data.responseText);
			var obj = jQuery.parseJSON(data.responseText);
			if (obj.templatename) {
				$("#templatename-error-label").addClass("has-warning");
				$('#templatename-error').html(obj.templatename);
			}
			if (obj.template) {
				$("#template-error-label").addClass("has-warning");
				$('#template-error').html(obj.template);
			}
		}
	});
});

$('#addeftemplate').click(function(e){
	e.preventDefault();
	$.ajax({
		type: "POST",
		url: "/storeef",
		data: $("form.formef").serialize(),
		success: function(response){
			$("#efModal").modal('hide');
			//console.log(JSON.stringify(response));
			//var obj = jQuery.parseJSON(response.responseText);
			//console.log(obj);
			//$templates = JSON.stringify(response);
			//console.log($templates);
			//
			console.log(response.length);
			if (response.length > 0) {
				$('#templatename').empty();
				//$('#templatename1').hide();
				$('#templatename').append('<option value="None"  selected="">None</option>');
				for(i=0; i<response.length; i++){

					$('#templatename').append('<option value="'+response[i]['templatename']+'">'+response[i]['templatename']+'</option>');
			  		//console.log(response[i]['id']);
			  	}
			  }else{
			  	$('#templatename').empty();
			  	$('#templatename').append('<option value="None" selected="">else</option>');
			  }

			},
			error: function(data){
				//console.log(data.responseText);
				var obj = jQuery.parseJSON(data.responseText);
				if(obj.templatenameef){
					$("#templatenameef-error-label").addClass("has-warning");
					$('#templatenameef-error').html(obj.templatenameef);
				}
				if (obj.templateef) {
					$("#templateef-error-label").addClass("has-warning");
					$('#templateef-error').html(obj.templateef);
				}
			}
		});
});

$('#efModal').on('hidden.bs.modal',function(){
	//$(this).find("label").val('').end();
	
	$('#templatenameef').val('');
	$(this).find("textarea").val('').end();
});

$('#templatename').change(function(e){
	e.preventDefault();
	$(this).find("option:selected").each(function(){
		var optVal = $(this).attr("value");
		console.log(optVal);
		if(optVal == "None"){
			$('#examinationfindings').val("");
		}else{
			e.preventDefault();
			$.ajax({
				type: "GET",
				url : "/showef",
				data : {opt : optVal},
				
				success: function(response){
					console.log(JSON.stringify(response));
					console.log(response[0]['template']);
					$('#examinationfindings').val("");
					$('#examinationfindings').val(response[0]['template']);
				},
				error: function(data){

				}
			});
		}
	});
});

// $("#addpath").click(function(e){
// 	e.preventDefault();
// 	$.ajax({
// 		type: "POST",
// 		url:"/pathologies",
// 		data: $("form.formpath").serialize(),
// 		success: function(response){
// 			// $("#myPathModal").modal('hide');
// 		},
// 		error: function(data){
// 			console.log(data.responseText);
// 		}
// 	});
// 	return false;
// });

$("#addmed").click(function(){
	$(".medname").select2("val", " ");
});

$('#testme').click(function(){
	var rest = nums[3];
	console.log(rest);
});

$('.rem').click(function(){
	//console.log('Hello');
	//$(this).closest('.row').remove();
	$(this).closest('.plist').remove();
});

$(document).on('click', '.rem', function(){ 
	//console.log('Hello');
	//$(this).closest('.row').remove();
	$(this).closest('.plist').remove();
});
