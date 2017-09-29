$('#addmember').on("show.bs.modal", function (e) { 
      var email = $("#email").val();
      $.ajax({
         url: urlgetmember,
         method: 'GET',
         data: {_token:token,email:email},
      })
      .done(function(data) {
          if(data)
          {
              if(data['email']=="Not Allowed!")
              {
                option =   "<tr><td></td><td></td><td>"+data['email']+"<td></td></tr>";    
              }
              else
              {
                option =   "<tr><td>"+data['name']+"</a></td>";
                option +=  "<td>"+data['phone']+"</td>";
                option +=  "<td>"+data['email']+"</td>";
                option +=  "<td>"+data['created_at']+"</td></tr>";
                option +=  "<input type='hidden' id='userid' name='userid' value='"+data['id']+"'>";
                option +=  "<input type='hidden' id='roleid' name='roleid' value='"+data['r_id']+"'>";
              }  
              $("#getMember").show();
              $("#getMember").html("");
              $("#getMember").append(option);
          }
      });
});        