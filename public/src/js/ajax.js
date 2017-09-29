  $("#genkey").click(function(e){
    e.preventDefault();
    var jobid =$('#jobtype option:selected').val();
   $.ajax({
       url: urlgenKey,
       method: 'GET',
       data: {_token:token,jobtype:jobid},
   })
   .done(function(data) {

        if(data)
        {
            $("#codenumber").val(data);
        }
   });
  });

 $("#otp").click(function(e){
    e.preventDefault();
    var patientid =$('#patientid').val();
    var userid = $('#userid').val();
    var event = $('#event').val();

   $.ajax({
       url: urlotp,
       method: 'GET',
       data: {_token:token,patientid:patientid,userid:userid,event:event},
   })
   .done(function(data) {
        alert('OTP Sent to the patient mobile');
        // if(data)
        // {
        //     $("#otpsuccess").html("OTP Successfuly sent!")
        // }
   });
  });

function getAToken(id) {
    var slotid =id;
   $.ajax({
       url: urlgetArrivalTime,
       method: 'GET',
       data: {_token:token,slotid:slotid},
   })
   .done(function(data) {
      $("td[t_alink=" + id + "]").html(data);
   });

}