$(document).ready(function(){
    loadTrainersData();
});

$('#datepicker').datepicker({
    //    weekStart: 1,
    //    daysOfWeekHighlighted: "6,0",
    format: "mm-yyyy",
    startView: "months", 
    minViewMode: "months",       
    autoclose: true,
    //    todayHighlight: true,
});
$('#datepicker').datepicker("setDate", new Date());

function loadTrainersData() {
    let url = BaseUrl + "/attendance/all-trainers";
    $.ajax({
        type: "Get",
        headers: {
            email: email,
            password: passw,
        },
        data : {
            date:""
        },
        dataType: "json",
        url: url,
        success: function(data) {
            getAllTrainers(data);
        },
        error: function(jqxhr, eception) {
            if (jqxhr.status == 404) {
               
            }
        },
    });
}

const ChangeDateFormat = (oldDate) => {
    const date = new Date(oldDate);
    //extract the parts of the date
    let day = date.getDate();
    let month = date.getMonth() + 1;
    const year = date.getFullYear();
    if (day < 10) {
        day = `0${day}`;
    }
    if (month < 10) {
        month = "0" + month;
    }
    let finalDate = `${day + "-" + month + "-" + year}`;
    return finalDate;
};


//Load datatables data
function getAllTrainers(data) {
    let html = ``;
    var first = 0;
    var num = 0;  
    let table = $("#attandance").DataTable();  
    let dataSet = [];
    if (data.data) {
        var date = data.date;
        var data = data.data;
        
        data.forEach((e) => {
            if (first == 0) {
                first = e.id;
            }
            
            let f_date = "";
            if(e.created_at){
                c_date = ChangeDateFormat(e.created_at);
            }
            var days = getDayInCurrentMon(date);
            for(var d = 1 ; d<days; d++){
                if(d<10){
                    d= '_'+'0'+d;
                }
            }

            let row = '';
            if(days==31){
                row = [
                    ++num,
                    e.full_name,
                    e.day_01,
                    e.day_02,
                    e.day_03,
                    e.day_04,
                    e.day_05,
                    e.day_06,
                    e.day_07,
                    e.day_08,
                    e.day_09,
                    e.day_10,
                    e.day_11,
                    e.day_12,
                    e.day_13,
                    e.day_14,
                    e.day_15,
                    e.day_16,
                    e.day_17,
                    e.day_18,
                    e.day_19,
                    e.day_20,
                    e.day_21,
                    e.day_21,
                    e.day_22,
                    e.day_23,
                    e.day_24,
                    e.day_25,
                    e.day_26,
                    e.day_27,
                    e.day_28,
                    e.day_29,
                    e.day_30,
                    e.day_31,
                ];
            }else{
                row = [
                    ++num,
                    e.full_name,
                    e.type_name,
                ];
            }
        
            //let name = `<a href= "#" class="text-info"  onclick="leadDetails(${e.id}, this)">${e.Name}</a>`;
            dataSet.push(row);
        });
    }
    //$("#leads-table").destroy();
    table.destroy();
    var headerHtml = "<th>#ID</th>"+
                    "<th>Name</th>"+
                    "<th>1 Mon</th>"+
                    "<th>2 Tues</th>"+
                    "<th>3 wed</th>"+
                    "<th>4 thurs</th>"+
                    "<th>5 fri</th>"+
                    "<th>6 sat</th>"+
                    "<th>7 sun</th>"+
                    "<th>8 Mon</th>"+
                    "<th>9 Tues</th>"+
                    "<th>10 wed</th>"+
                    "<th>11 thurs</th>"+
                    "<th>12 fri</th>"+
                    "<th>13 sat</th>"+
                    "<th>14 sun</th>"+
                    "<th>15 Mon</th>"+
                    "<th>16 Tues</th>"+
                    "<th>17 wed</th>"+
                    "<th>18 thurs</th>"+
                    "<th>19 fri</th>"+
                    "<th>20 sat</th>"+
                    "<th>21 sun</th>"+
                    "<th>22 Mon</th>"+
                    "<th>23 Tues</th>"+
                    "<th>24 wed</th>"+
                    "<th>25 thurs</th>"+
                    "<th>26 fri</th>"+
                    "<th>27 sat</th>"+
                    "<th>28 sun</th>"+
                    "<th>29 Mon</th>"+
                    "<th>30 tues</th>"+
                    "<th>31 wed</th>";
    $("#attendance_tr").html(headerHtml);
    $('#attandance').DataTable({
        data: dataSet,
        responsive: true,
        pageLength: 10,
        paging: true,
        order:[1,"desc"],
        columnDefs: [
            {
                targets: [],
                visible: false,
                searchable: false,
            },
            {
                targets: [],
                visible: false,
            },
        ],
        scrollX: true,
    });
}


function getDayInCurrentMon(date) {
    console.log(date);
    
    var today = new Date();
    var month = today.getMonth();

    return daysInMonth(month + 1, today.getFullYear());
}
function daysInMonth(month,year) {
  return new Date(year, month, 0).getDate();
}

function getdata(){
    var date = $("#datepicker").val();
    let url = BaseUrl + "/attendance/all-trainers/";
    $.ajax({
        type: "Get",
        headers: {
            email: email,
            password: passw,
        },
        data: {
            date : date
        },
        dataType:"json",
        url: url,
        success: function(data) {
            getAllTrainers(data);
        },
        error: function(jqxhr, eception) {
            if (jqxhr.status == 404) {
               
            }
        },
    }); 
}



