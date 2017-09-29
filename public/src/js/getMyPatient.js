  $(document).ready(function(){

 
     $.ajax({
         url: urlgetMyPatient,
         method: 'GET',
         data: {_token:token},
         async:false,

     })
     .done(function(data) {

          if(data.length>0)
          {

              var option="";
              for(i=0;i<data.length;i++){

              
              url = url.replace(':id', data[i]['id']);
         
              option +=   "<tr><td><a href='"+url+"'>"+data[i]['name']+data[i]['midname']+data[i]['surname']+"</a></td>";
              option +=  "<td>"+data[i]['phoneprimary']+"</td>";
              option +=  "<td>"+data[i]['phonealternate']+"</td>";
              option +=  "<td>"+data[i]['email']+"</td>";
              option +=  "<td>"+data[i]['patientcode']+"</td>";
              option +=  "<td>"+data[i]['created_at']+"</td></tr>";
             }
              $("#getMyPatient").show();
              $("#getMyPatient").html("");
              $("#getMyPatient").append(option);
          }
     });

  });
