/* start*/
/**
 * Function for load all Staus Call
 */

function loadAllSource() {
  let url = BaseUrl + "/sources/all";
  $.ajax({
    type: "Get",
    headers: {
      email: email,
      password: passw,
    },
    url: url,
    success: function (data) {
       getAllsources(data);
    },
    error: function (jqxhr, eception) {
      if (jqxhr.status == 404) {
        alert("No data found");
      }
    },
  });
}

function getAllsources(data) {
  var num = 0;
  if (data.length > 0) {
    let table = $("#sourceDatatables").DataTable();
    let dataSet = [];
    if (data == "No record found.") {
    } else {
      data.forEach((e) => {
        let action = `<i class="fas fa-edit text-info"  id="${e.id}" onClick="editsources(${e.id}, '${e.title}')"></i>
            <i class="fas fa-trash-alt text-danger" id="${e.id}"  onClick="deletesources(this.id)"></i>`;
        let row = [++num, e.title, action];
        dataSet.push(row);
      });
    }
    table.destroy();
    $("#sourceDatatables").DataTable({
      data: dataSet,
      responsive: true,
    });
  }
}

/**
 * Function for load Edit Status */

function editsources(id=null, title=null) {
  // let url = BaseUrl + "/sources/show/" + id;
  // $.ajax({
  //   type: "Get",
  //   headers: {
  //     email: email,
  //     password: passw,
  //   },
  //   url: url,
  //   success: function (data) {
      if (id && title) {
        $("#inputField").show();
        $("#inputField").addClass("d-flex");
        $("#sources_name").val(title);
        $("#sourcesid").val(id);
        $(".save-sources")
          .removeClass("save-sources")
          .addClass("update-sources");
        $(".add-new").removeClass("add-new").addClass("update-sources");
        $(".update-sources").html("");
        $(".update-sources").html('<i class="fas fa-edit mr-2"></i>Update');
      }
  //     } else {
  //       alert("No data found");
  //     }
  //   },
  //   error: function (jqxhr, eception) {
  //     if (jqxhr.status == 404) {
  //       alert("No data found");
  //     }
  //   },
  // });
}

/**
 * Function for load Delete Status */

function deletesources(id) {
  var proceed = confirm("Are you sure you want to proceed?");
  if (proceed) {
    let url = BaseUrl + "/sources/delete/" + id;
    console.log(url);
    $.ajax({
      type: "delete",
      headers: {
        email: email,
        password: passw,
      },
      url: url,
      success: function (data) {
        if (data.status === 200) {
          loadAllSource();
          Notiflix.Notify.success(data.messages.success);
          setTimeout(() => {
          }, 1000);
        }
      },
      error: function (jqxhr, eception) {
        if (jqxhr.status == 404) {
          Notiflix.Notify.error(data.messages.success);
          setTimeout(() => {
            loadAllSource();
          }, 1000);
        }
      },
    });
  } else {
  }
}

$(function () {
  loadAllSource();
  $(document).on("click", ".save-sources", function (e) {
    e.preventDefault();
    let url = BaseUrl + "/sources/insert";
    let formData = $("#sourcesForm").serialize();

    if ($("#sources_name").val() != "") {
      $.ajax({
        type: "POST",
        headers: {
          email: email,
          password: passw,
        },
        url: url,
        data: formData,
        success: function (data) {
          if (data.status === 200) {
            $("#sources_name").val("");
            loadAllSource();
            Notiflix.Notify.success(data.messages.success);
            hideAccountFeild();
            setTimeout(() => {
              
            }, 1000);
          }
        },
        error: function (jqxhr, eception) {
          Notiflix.Notify.warning(jqxhr.responseJSON.messages.source_name);
        },
      });
    } else {
    }
  });
});

$(function () {
  loadAllSource();
  $(document).on("click", ".update-sources", function (e) {
    e.preventDefault();
    var accountId = $("#sourcesid").val();
    if (accountId > 0 && accountId != "") {
      let urli = BaseUrl + "/sources/update/" + accountId;
      let formData = $("#sourcesForm").serialize();
      if (formData) {
        $.ajax({
          type: "put",
          headers: {
            email: email,
            password: passw,
          },
          url: urli,
          data: formData,
          success: function (data) {
            if (data.status === 200) {
              loadAllSource();
              $("#sources_name").val("");
              Notiflix.Notify.success(data.messages.success);
              hideAccountFeild();
              setTimeout(() => {
                
              }, 1000);
            }
          },
          error: function (jqxhr, eception) {
            if (jqxhr.status === 404) {
              Notiflix.Notify.error(data.messages);
              //setTimeout(() => { window.sources.reload()}, 1000);
            }
          },
        });
      }
    }
  });

  $(".add-new").click(function (e) {
    e.preventDefault();
    $("#inputField").show();
    $("#inputField").addClass("d-flex");
    $("#source_name").focus();
    $(".add-new").removeClass("add-new").addClass("save-sources");
    $(".save-sources").html("");
    $(".save-sources").html('<i class="far fa-save mr-2"></i>Save');
  });
});

function hideAccountFeild() {
  $("#source_name").val("");
  $("#inputField").removeClass("d-flex");
  $("#inputField").hide();
  $(".save-sources").removeClass("save-sources").addClass("add-new");
  $(".add-new").html("");
  $(".add-new").html('<i class="fas fa-plus mr-2"></i>Add New');
  $(".update-sources").removeClass("update-sources").addClass("add-new");
  $(".add-new").html("");
  $(".add-new").html('<i class="fas fa-plus mr-2"></i>Add New');
}
