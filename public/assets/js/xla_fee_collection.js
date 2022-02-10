$(function () {

    var first_id = $("#first_id").val();    
    loadTimeline(first_id);
     $('.fee_btn').click(function (e) {        
        e.preventDefault();
        var id = $(this).val();        
        let urli = BaseUrl + `/leadsapi/lead_fee/${id}`;      
        if (id) {
            $.ajax
                ({
                    type: "get",
                    headers: {
                        'email': email,
                        'password': passw,
                    },
                    url: urli,                   
                    success: function (data) {                    
                        $("#lead_id").val(data.id);
                        $('#total_fee').text(data.Course_Value);
                        $('#total_Paid').text(data.paid_amount);
                        $('#balance_amount').text(data.Course_Value - data.paid_amount);
                    }
                });
            }
         });


    $('#fee_collection').on('submit', function (e) {
        e.preventDefault();
        var total_fee = $('#total_fee').html();    // total fee of the course 
        var total_Paid = $('#total_Paid').html();  // fee paid by lead
        var balance_amount = $('#balance_amount').html();  // balance amount 
        var paid_amount = $('#paid_amound').val();  // current amount paying by lead.
        
        if ( parseFloat(paid_amount) > parseFloat(total_fee) || parseFloat(paid_amount) > parseFloat(balance_amount)){
            alert('You are not allowed to collect more than total fee.');         
        }else if(parseFloat(total_Paid) == parseFloat(total_fee)){
            alert('No Due Amount.');           
        }else{
            
        let urli = BaseUrl + `/fee/collect`;
        let formData = $(this).serialize();
        if (formData) {
            $.ajax
                ({
                    type: "post",
                    headers: {
                        'email': email,
                        'password': passw,
                    },
                    url: urli,
                    data: formData,
                    success: function (data) {                                           
                        if (data.status===200) {
                            document.getElementById("fee_collection").reset();
                            $('#exampleModal').modal('hide');                          
                            Notiflix.Notify.success(data.messages.success);                         
                            setTimeout(() => { window.location.reload()}, 1000);
                        } else {                            
                            Notiflix.Notify.error(data.messages.success);                         
                            setTimeout(() => { window.location.reload()}, 1000);
                        }
                    }
                });
            }
        }

    });
});

function loadTimeline(id){
  
    let urli = BaseUrl + `/fee/comments/${id}`;  
    var num =1; 
    let html2='';   
    if (id) {
        $.ajax
            ({
                type: "get",
                headers: {
                    'email': email,
                    'password': passw,
                },
                url: urli,                   
                success: function (data) {  
                   $.each(data, function( index, val ) {
                      html2 += `<li class="tl-item" ng-repeat="item in retailer_history">`
                      html2 += `<div class="timestamp"><strong>${val.created_at}</strong></div>`                              
                      html2 += `<div class="item-title"><strong>${val.subject}</strong></div>`
                      html2 += `<div class="item-detail">${val.comments}</div></li>`                                

                    });
                   $('#dy_timeline').html(html2);                        
                }
            });
        }
}

function View_Change(){
    document.getElementById("View_card").style.display = "none";
    document.getElementById("Update_card").style.display = "block";   
}

function payment(value){ 
    if(value == 1){
        document.getElementById("payment_type").value = 'Partially';           
    }else {
        document.getElementById("payment_type").value = 'Fully';     
    }    
}


function changeStatus(value){ 
    var total_fee = $('#total_fee').html();   
    var balance_amount = $('#balance_amount').html();
    if( parseFloat(value) > parseFloat(total_fee) || parseFloat(value) > parseFloat(balance_amount) ){        
        $('#note').html('You are not allowed to collect more fee than total fee.');         
    }else {
        $('#note').html('');           
    } 
   
}
