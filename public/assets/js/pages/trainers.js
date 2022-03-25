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
    if (data) {
        data.forEach((e) => {
            if (first == 0) {
                first = e.id;
            }
            
            let f_date = "";
            if(e.created_at){
                c_date = ChangeDateFormat(e.created_at);
            }
            var days = getDayInCurrentMon();
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

function fetchData(){
    
}

function getDayInCurrentMon() {
    var today = new Date();
    var month = today.getMonth();
    return daysInMonth(month + 1, today.getFullYear());
}

function daysInMonth(month,year) {
  return new Date(year, month, 0).getDate();
}


