      function Editt(a) {
          $(".edit-btn").html(' <i class="fa fa-spinner fa-spin   fa-fw"></i> Edit'), $.ajax({
              type: "POST",
              url: a,
              data: "",
              success: function(a) {
                  $(".F_ram").hide(), $(".D_IS").show(), $(".D_IS").html(a), $("#datatable-example").dataTable(), $(".edit-btn").html('<i class="fa fa-pencil-square-o"></i> Edit')
              },
              error: function(a, b, c) {
                  $(".F_ram").hide(), $(".D_IS").show(), $(".D_IS").html(c), $(".edit-btn").html('<i class="fa fa-pencil-square-o"></i> Edit')
              }
          })
      }

      function Frm_Edit(a, b, c, d) {
          $(".D_IS").hide(), $(".F_ram").show(), $("#idv").val(a);
          var e = $("#Scs_url").val(),
              f = "idv=" + a + "&tab=" + b + "&idd=" + c;
          $.ajax({
              type: "POST",
              url: e + "index.php/Edit/EditVal",
              data: f,
              dataType: "json",
              success: function(a) {
                  $.each(a, function(a, b) {
                      $("#" + a).val(b)
                  }), $("#EXEC").val(d)
              }
          })
      }
	  function FrmTrans_Edit(a, b, c, d) {
		  var idd=a;
          $(".D_IS").hide(), $(".F_ram").show(), $("#idv").val(a);
          var e = $("#Scs_url").val(),
              f = "idv=" + a + "&tab=" + b + "&idd=" + c;
          $.ajax({
              type: "POST",
              url: e + "index.php/Edit/TPEditVal",
              data: f,
              dataType: "json",
              success: function(a) {
                  $.each(a, function(a, b) {
                      $("#" + a).val(b)
                  }), $("#EXEC").val(d);
				  
				  FrmTransPur_Edit(idd);
              }
			  
          })
      }
	   function FrmTransPur_Edit(a) {
         
          var e = $("#Scs_url").val(),
              f = "idv=" + a ;
          $.ajax({
              type: "POST",
              url: e + "index.php/Edit/TPD",
              data: f,
              
              success: function(a) {
                  
				  $(".Det").html(a);
				  $("#SubTotal").val(parseFloat($('#SAMT').val()).toFixed(2));
				  SubTot();
              }
          })
      }
	  
	  function FrmSales_Edit(a, b, c, d) {
		  var idd=a;
          $(".D_IS").hide(), $(".F_ram").show(), $("#idv").val(a);
          var e = $("#Scs_url").val(),
              f = "idv=" + a + "&tab=" + b + "&idd=" + c;
          $.ajax({
              type: "POST",
              url: e + "index.php/Edit/TSALEditVal",
              data: f,
              dataType: "json",
              success: function(a) {
                  $.each(a, function(a, b) {
                      $("#" + a).val(b)
                  }), $("#EXEC").val(d);
				  
				  FrmTransSal_Edit(idd);
              }
			  
          })
      }
	  
	  
	   function FrmTransSal_Edit(a) {
         
          var e = $("#Scs_url").val(),
              f = "idv=" + a ;
          $.ajax({
              type: "POST",
              url: e + "index.php/Edit/TSD",
              data: f,
              
              success: function(a) {
                  
				  $(".Det").html(a);
				  $("#SubTotal").val(parseFloat($('#SAMT').val()).toFixed(2));
				  SubTot();
              }
          })
      }
	  
	  
      $(document).ready(function(a) {
          function b(a) {
              var b = $("#Mname").val()  + "_Val",
                  d = $("#scsfrm").serialize(),
                  e = $("#Scs_index").val() + b + "?" + Math.random();
              $.ajax({
                  url: e,
                  type: "POST",
                  data: d,
                  dataType: "json",
                  success: function(b) {
                      $.each(b, function(a, b) {
                          $("." + a).html('<div class="errors" style="color:#FD0004 !important;">' + b + "</div>")
                      }), b.Success && c(a)
                  },
                  error: function(a, b, c) {
                      $(".ErrMsg").html(c)
                  }
              })
          }

          function c(a) {
              var b = $("#scsfrm").serialize() + "&BUT=" + a,
                  c = $("#Scs_index").val() + "MsSql?" + Math.random();
              $("#EXEC").hide(), $("#EXEC").before('<a  class="btn btn-success btn-sm btnspin" > <i class="fa fa-spinner fa-spin fa-2x fa-fw"></i></a>'), $.ajax({
                  url: c,
                  type: "POST",
                  data: b,
                  dataType: "json",
                  success: function(a) {
                      a.Success ? d(a.MSG) : ($(".ErrMsg").html(a.MSG), $("#EXEC").show(), $(".btnspin").remove())
                  },
                  error: function(a, b, c) {
                      $("#EXEC").show(), $(".btnspin").remove()
                  }
              })
          }

          function d(a) {
              $("#errorMessage").remove(), $("body").append('<div id="errorMessage"><span id="spanmsg">' + a + "</span></div>"), $("#errorMessage").slideDown(500).delay(1e3).slideUp(400, function() {
                  window.location.href = $("#Rload").attr("href")
              })
          }
          $("#EXEC").click(function() {
            // debugger;
              b(this.value)
          })
      });
	  
	  
	  function Mbox(a) {
              $("#errorMessage").remove(), $("body").append('<div id="errorMessage"><span id="spanmsg">' + a + "</span></div>"), $("#errorMessage").slideDown(500).delay(1e3).slideUp(400, function() {
                  
              })
          }
		  
		  
		  
		  
		   $(function () {
    $('#example1').DataTable()
    $('#example2').DataTable({
      'paging'      : true,
      'lengthChange': false,
      'searching'   : false,
      'ordering'    : true,
      'info'        : true,
      'autoWidth'   : false
    })
  })
	
	
	$(document).ready(function(e) {
        if($("#EXEC").val()=="DELETE")
		{
		    $("#EXEC").addClass('btn-danger');
			$('.scs-ctrl').attr('readonly','readonly');
            $('.scs-ctrl-select').attr('disabled','readonly');
		}
		if($("#EXEC").val()=="UPDATE")
		{
			$("#EXEC").addClass('btn-warning');
		}
		
		
		$('.Dat').datepicker({
			  autoclose: true,
			  format: 'dd-mm-yyyy',
			   startDate: '-0m'
			})
        $('.Dat1').datepicker({
            autoclose: true,
            format: 'dd-mm-yyyy',
                endDate: '-0m'
            })
            $('.Dat2').datepicker({
                autoclose: true,
                format: 'dd-mm-yyyy',
                    endDate: '-0m'
                })
    });	 
	
	
	
	
	$(document).ready(function(e) {
     
	 NumOnly();
 });
function Get_City(a)
{
	
	var restypeid=document.getElementById("city"+a).value;  
	//alert(restypeid);
	document.getElementById("dialogcity").style.display = "none";
	document.getElementById("City").value = restypeid;
	$.ajax({url:$("#Scs_index").val() + "Auto_c/Gst_State?Cityid="+a, type: "POST",dataType: "html",success:function(result){
	var obj=$.parseJSON(result);
	var data = obj.split('-');
	document.getElementById("State").value = data[4];
	document.getElementById("Country").value = data[2];
	document.getElementById("City_id").value = data[0];
	document.getElementById("State_id").value = data[3];
	document.getElementById("Country_id").value = data[1];
		//alert (result);
			}	});
 $('.ui-icon-closethick').click();
}
function Get_checkinCity(a)
{
	
	var restypeid=document.getElementById("city"+a).value;  
	//alert(restypeid);
	document.getElementById("dialogcity").style.display = "none";
	document.getElementById("City").value = restypeid;
	$.ajax({url: "Gst_State?Cityid="+a, type: "POST",dataType: "html",success:function(result){
	var obj=$.parseJSON(result);
	var data = obj.split('-');
	document.getElementById("State").value = data[4];
	document.getElementById("Country").value = data[2];
	document.getElementById("City_id").value = data[0];
	document.getElementById("State_id").value = data[3];
	document.getElementById("Country_id").value = data[1];
		//alert (result);
			}	});
 $('.ui-icon-closethick').click();
}
function Pop_city(dd)
{
	 //c = $("#Scs_index").val() + "MsSql?" + Math.random();
	$.ajax({url:$("#Scs_index").val() + "Auto_c/Pop_city", type: "POST",dataType: "html",success:function(result){
		$("#City_View").html(result);
		//alert (result);
			}	});
	tree=dd;
	$( "#dialogcity" ).dialog(
	{
    width: 800,
    height: 400,
    minHeight: 400,
    maxHeight: 400,
    minWidth: 500,
    maxWidth: 900,
	close: function() {
	$("#City_View").html('');
	},
    modal: true
	}
	);
		

}
function Pop_checkincity()
{
	 //c = $("#Scs_index").val() + "MsSql?" + Math.random();
	$.ajax({url: "Pop_city", type: "POST",dataType: "html",success:function(result){
		$("#City_View").html(result);
		//alert (result);
			}	});
	//tree=dd;
	$( "#dialogcity" ).dialog(
	{
    width: 800,
    height: 400,
    minHeight: 400,
    maxHeight: 400,
    minWidth: 500,
    maxWidth: 900,
	close: function() {
	$("#City_View").html('');
	},
    modal: true
	}
	);
		
}
 function Pop_Designation(dd)
{
	 //c = $("#Scs_index").val() + "MsSql?" + Math.random();
	$.ajax({url:$("#Scs_index").val() + "Auto_c/Pop_Designation", type: "POST",dataType: "html",success:function(result){
		$("#Designation_View").html(result);
		//alert (result);
			}	});
	tree=dd;
	$( "#dialogDesignation" ).dialog(
	{
    width: 800,
    height: 400,
    minHeight: 400,
    maxHeight: 400,
    minWidth: 500,
    maxWidth: 900,
	close: function() {
	$("#Designation_View").html('');
	},
    modal: true
	}
	);
		
}
function Get_Designation(a)
{
	var restypeid=document.getElementById("city"+a).value;  
	document.getElementById("Designation").value = restypeid;

 $('.ui-icon-closethick').click();
}
function NumOnly() {
    $('[num=1]')
        .each(function(index) {
            if ($(this)
                .val() == '') {
                $(this)
                    .val(0);
            }
        });



    $('[num=1]').focus(function() {
        if ($(this)
            .val() == '0') {
            $(this)
                .val('');
        }
    })

    $('[num=1]').blur(function() {
        if ($(this)
            .val() == '') {
            $(this)
                .val(0);
        }
    })

    $("[num=1],[num=2]").keydown(function(e) {

        if ($.inArray(e.keyCode, [46, 8, 9, 27, 13, 110, 190]) !== -1 ||

            (e.keyCode == 65 && (e.ctrlKey === true || e.metaKey === true)) ||

            (e.keyCode >= 35 && e.keyCode <= 40)) {

            return;
        }

        if ((e.shiftKey || (e.keyCode < 48 || e.keyCode > 57)) && (e.keyCode < 96 || e.keyCode > 105)) {
			 
			 if(e.keyCode !=109){
				 
            e.preventDefault();
			 }
        }
    });
	
	
	$("[nums=1]").keydown(function(e) {

         if(e.keyCode ==9 || e.keyCode ==8 ){ return;  }

        if ((e.shiftKey || (e.keyCode < 48 || e.keyCode > 57)) && (e.keyCode < 96 || e.keyCode > 105)) {
			 
			 if(e.keyCode !=109   ){
				 
            e.preventDefault();
			 }
        }
    });

}