$(function(){ 
    $('#general-setting-form').on('submit',function(e){
        e.preventDefault();
        let empid = $('#employee_id').val();
        let url = BaseUrl + `/profile/update_general/${empid}`;
        let formData = $(this).serialize();
        if(formData){
            $.ajax
            ({
                type: "put",
                headers: {
                    'email':'demo@gmail.com',
                    'password':'12345',  
                },
                url: url,
                data: formData,
                success: function (data) {
                    message = `<div class="alert alert-success alert-dismissible fade show" role="alert">
                    <strong></strong> ${data.messages.success}
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>`;
                setTimeout(() => { $('#alertMessage').html(message); }, 600);
                },
                error: function (jqxhr, eception) {
                    if (jqxhr.status == 404) {
                        alert('No data found');
                    }
                }
            });
        }
    })

})