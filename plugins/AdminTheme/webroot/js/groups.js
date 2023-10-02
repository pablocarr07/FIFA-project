      $(document).ready(function() {
	  $(select2).on("change",function(){
		if($(this).attr("id")=="dependency-id"){
			getGroups($(this).val());
		}
	  });
	  
	  });
	  function getGroups(dependencyId){
	  $("#parent-id").html($("<option>", {
                                                value: "",
                                                text: "(choose group)"
                	                            }));
		 $.ajax({
                        type: "POST",
                        url: base_url+"getGroups/",
						data:{id:dependencyId},
                        success: function(datos){
                                $.each( datos.groups, function( key, value ) {
                                        $("#parent-id").append($("<option>", {
                                                value: value.id,
                                                text: value.name
                                            }));
                                      });
									  $("parent-id").trigger("change.select2");
                       }
                  });
				
				}
	  