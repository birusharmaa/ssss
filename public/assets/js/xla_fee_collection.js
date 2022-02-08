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
                        $('#total_fee').val(data.Course_Value);
                        $('#total_Paid').val(data.paid_amount);
                        $('#balance_amount').val(data.Course_Value - data.paid_amount);
                    }
                });
            }
         });


    $('#fee_collection').on('submit', function (e) {
        e.preventDefault();
        var total_fee = $('#total_fee').val();
        var paid_amount = $('#paid_amound').val();
  
        if ( parseFloat(paid_amount) > parseFloat(total_fee)){
            alert('You are not allowed to collect more than total fee.');
            window.location.reload();
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
                            message = `<div class="alert alert-success alert-dismissible fade show" role="alert">
                            <strong></strong> ${data.messages.success}
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>`;
                        $('#alertMessage').html(message); 
                            setTimeout(() => { window.location.reload()  }, 600);
                        } else {
                            message = `<div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <strong></strong> ${data.messages.success}
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>`;
                            $('#alertMessage').html(message);
                            setTimeout(() => { window.location.reload() }, 600);
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
                      html2 +=  `<div class="item-title"><strong>${val.subject}</strong></div>`
                      html2 +=  `<div class="item-detail">${val.comments}</div></li>`                                

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
    var total_fee = $('#total_fee').val();
    if(value == 1){
        document.getElementById("payment_type").value = 'Partially';           
    }else {
        document.getElementById("payment_type").value = 'Fully';     
    }    
}

