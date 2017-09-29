  $(document).ready(function(){

     $.ajax({
         url: urlgetAllPatient,
         method: 'GET',
         data: {_token:token},
         async:false,

     })
     .done(function(data) {

          if(data.length>0)
          {

              var option="";
              for(i=0;i<data.length;i++){

              option +=   "<tr><td><a href='#' onclick='showpatient("+data[i]['id']+")'>"+data[i]['name']+data[i]['midname']+data[i]['surname']+"</a></td>";
              option +=  "<td>"+data[i]['phoneprimary']+"</td>";
              option +=  "<td>"+data[i]['phonealternate']+"</td>";
              option +=  "<td>"+data[i]['email']+"</td>";
              option +=  "<td>"+data[i]['patientcode']+"</td>";
              option +=  "<td>"+data[i]['created_at']+"</td></tr>";
             }
              $("#getAllPatient").show();
              $("#getAllPatient").html("");
              $("#getAllPatient").append(option);
          }
     });

  });
