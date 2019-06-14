
$(function() {
	
	var year = new Date().getFullYear();
	var month = new Date().getMonth()+1;
	var date = new Date().getDate();

    $( "#datepicker" ).datetimepicker({ 
            yearRange: '2019:c+3' ,
            dateFormat: 'yy-mm-dd',
            changeYear: true,
            minDate: new Date(year, month - 1, date),
            maxDate: '+30Y',
     });
});

$(document).ready(function() {
	 if(jQuery().fancybox) {
     $(".various").fancybox({
		maxWidth	: 500,
		maxHeight	: 300,
		fitToView	: false,
		width		: '70%',
		height		: '70%',
		autoSize	: false,
		closeClick	: false,
		openEffect	: 'none',
		closeEffect	: 'none'
	});
 } 

 $('.rmd').click(function(){
 	var rmd_id = $(this).attr('data-rmd-id');
 	$.ajax({
 		url: "send_reminder.php",
		method: "POST",
		data:{
			rmd_id:rmd_id
		},
		success:function(data){
			alert(data);
		},
		error:function(error){
			alert(error);
		}
 	})
 })

});