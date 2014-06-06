    function UpdatePage() 
    {
      var selected = <?php echo json_encode($selected); ?>;
      for(var i=0;i<selected.length;i++)
            if(selected[i].section == "ALL SECTIONS")
              $("a[id*='"+selected[i].course_name+"']").remove();
            else
              $("a[id*='"+selected[i].section+"']").remove();
    }
    function openPage(name)
    {
        var url = "http://www.registrar.ufl.edu/cdesc?crs=" + name;
        var win = window.open(url, '_blank');
        win.focus();
    }
    $(document).ready(
        function () {
            $(".row").hide();
            $(".show").click(function () {
                var rowId = $(this).attr("id");
                $(".row" + rowId).toggle(400);
                return false;
            });
            $(".showAll").click(function () {
                for (var rowId = 0; rowId < <?php echo sizeof($courses) ?> ; rowId++) {
                    $(".row" + rowId).toggle(400);
                }
                return false;
            });
            $(".add").click(function () {
                var cdata = "";
                switch($(this).attr("type"))
                {
                  case "SECTION":
                      cdata ={section: $(this).attr("id")};
                      break;
                  case "ID":
                      cdata ={ID: $(this).attr("id")};
                      break;
                  case "COURSE":
                      cdata ={course: $(this).attr("id")};
                      break;
                  default:
                      cdata ={course: $(this).attr("id")};
                      break;
                }
                $("a[id*='"+$(this).attr("id")+"']").remove();
                $.ajax({
                    type: "POST",
                    url: "<?php echo base_url();?>courses/generateschedule",
                    data: cdata,
                    dataType: "text",
                    cache: false,
                    success: function (data) {
                        alert(data); //debug
                    }
                });
                return false;
            });
        });