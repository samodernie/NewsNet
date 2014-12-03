
window.pic_id="";
window.last_news_id="";
window.news_array="";
window.user_votes_status="";
var validator = null;

$("#home" ).on("pageinit", function(){
	//alert();
	
	get_category_list();
	get_last_news();
	fetch_news();
	
	
	var validator=$("#user_reg").validate({
		rules: {
			f_name:{
				required: true
			},
			l_name:{
				required: true
			},
			username:{
				required: true,
				minlength: 5
			},
			pwd:{
				required: true,
				minlength: 5
			},
			rpwd:{
				required: true,
				minlength: 5,
				equalTo: "#pwd"
			},
			email: {
				required: true,
				email: true
			},
			file_upload: {
				required: true	
			}
	
		},
		messages: {
				f_name: "Please enter your firstname",
				l_name: "Please enter your lastname",
				username: {
					required: "Please enter a username",
					minlength: "Your username must consist of at least 5 characters"
				},
				pwd: {
					required: "Please provide a password",
					minlength: "Your password must be at least 5 characters long"
				},
				rpwd: {
					required: "Please provide a password",
					minlength: "Your password must be at least 5 characters long",
					equalTo: "Please enter the same password as above"
				},
				email: "Please enter a valid email address",
				file_upload: "Please Upload an Image"
		},
		
		errorPlacement: function( error, element ) {
			error.insertAfter( element.parent() );
		},
		submitHandler: function(form) {
            
			//save the data
			save_user_data();
			
			//reset form
			console.log("form reset");
            validator.resetForm(); 
            form.reset();
			
			$(".pro_pic").css("background","url(images/add_pro_pic.png) center center no-repeat ");
			$(".pro_pic").css("background-size","contain");
			$("#popupReg").popup("close");
			//$("#success_btn").show();
    	}
	});
	
	

});





function save_user_data(){

	//console.log(window.user_id+" "+$("#f_name").val()+" "+$("#l_name").val()+" "+$("#username").val()+" "+window.pic_id+" "+$("#pwd").val()+" "+$("#email").val());
	
	 var ajax_save_user_data = {
			f_name:$("#f_name").val(),
			l_name:$("#l_name").val(),
			username:$("#username").val(),
			picture:window.pic_id,
			pwd:$("#pwd").val(),
			email:$("#email").val(),
			ajax:'save_user'

	 }; 

		
	$.ajax({
		url: "php/user_data.php",
		type: 'POST',
		data: ajax_save_user_data,
		success: function($obj2){
			console.log($obj2);
			//window.user_id=$obj;
			//var json_data = JSON.parse($obj);
    		//console.log(json_data); //etc
			//window.user_id=json_data[0]['u_id'];
			//load_comments();
			
		}
	}); 
	

}


function login_check(){
	var ajax_login_data = {
		username:$("#u_name").val(),
		password:$("#passwd").val(),
		ajax:'login_data'
	}; 
	
	//post_button();
		
	$.ajax({
		url: "php/login_check.php",
		type: 'POST',
		data: ajax_login_data,
		success: function($obj){
			console.log($obj);
			var json_data = JSON.parse($obj);
    		console.log(json_data);
			
			if(json_data=="wrong"){
				alert("Check Username or Password");
				$("#u_name").val("");
				$("#passwd").val("");
				
			}else{
				window.user_id=json_data[0].u_id;
				show_user_login_details(json_data);
				//alert(window.user_id);
			}
			
			
			//var jsonString = JSON.stringify($obj);
			//console.log(jsonString);
			 
		}
	}); 
	
}


function show_user_login_details(json_data){
	var name=json_data[0].f_name+" "+json_data[0].l_name;
	$(".user_name_disp").text(name);
	
	if(json_data[0].login_method=='default'){
		$(".user_pro_pic").css("background","url(uploads/"+json_data[0].picture+") center center no-repeat ");
		$(".my_pro_pic_cmt").css("background","url(uploads/"+ json_data[0].picture +")center center no-repeat");//for comment
		$(".user_pro_pic").css("background-size","cover");	
		
		
	}else{
		
	}
	$("#popupLogin").popup("close");
	$(".my_comment").show();
	window.login_status=1;
}


function get_category_list(){
	//alert();
	var ajax_get_cat_data = {
		ajax:'get_category'
	}; 
		
	$.ajax({
		url: "php/get_categories.php",
		type: 'POST',
		data: ajax_get_cat_data,
		success: function($obj){
			console.log($obj);
			var json_data = JSON.parse($obj);
			
			
			console.log(json_data);
			
			var data=[];
			/*for(var x in json_data.cat_name){
			  data.push(json_data[x].cat_name);
			}*/
			for(i=0;i<json_data.length;i++){
				 data.push(json_data[i].cat_name);
	
			 $(".sel_category").append("<option value="+json_data[i].cat_id+">"+json_data[i].cat_name+"</option>");
				 
			}
			
			$(".sel_category").append('<option value="" disabled selected>Select Country</option>');
			
			

			 $("#searchField").autocomplete({
				target: $('#suggestions'),
				source: data,
				response: function(event, ui) {
					// ui.content is the array that's about to be sent to the response callback.
					if (ui.content.length === 0) {
						//alert("No results found");
						$("#add_cat_btn").show();
					} else {
						//alert("got");
						$("#add_cat_btn").hide();
						
					}
				},
				minLength: 1
			});
	 
		}
	}); 	
	
}








function get_last_news(){
	var ajax_get_last_news = {
		ajax:'get_last_news'
	}; 
	
	$.ajax({
		url: "php/news.php",
		type: 'POST',
		data: ajax_get_last_news,
		success: function($obj){
			console.log("last news id="+$obj);
			var json_data = JSON.parse($obj);
    		console.log(json_data);
			window.last_news_id=json_data;
			$("#news_id").val(json_data);
		}
	}); 
}


function upload_news_data(){
	//alert($("#searchField").val());
	
	
	if(window.upload_news_data_status==1){	
		var ajax_news_data = {
			news_id:$("#news_id").val(),
			headline:$("#headline").val(),
			news_desc:$("#news_desc").val(),
			searchField:$("#searchField").val(),
			city:window.map_location_result.locality,
			country:window.map_location_result.country,
			u_id:window.user_id,
			ajax:'save_news_data'
		}; 
			
		$.ajax({
			url: "php/news.php",
			type: 'POST',
			data: ajax_news_data,
			success: function($obj){
				console.log($obj);
				window.upload_news_data_status=0;
				//var json_data = JSON.parse($obj);
				//console.log(json_data);
				 
			}
		});
	}else{
		alert("you clicked 2 times")	;
	}
	
}

function close_popup_upload_news(){
	 var percentVal = '0%';
	$("#news_upload_frm")[0].reset();
	$("#add_cat_btn").hide();
	 $(".bar").width(percentVal);
     $(".percent").html(percentVal);
	 $("#success_btn").hide();
	  $("#upload_btn").show();
}


function close_news_upload_form(){
	$("#success_btn").show();
	clear_news_form();
	setTimeout(function(){
		parent.location.hash = ''
		window.location.href=parent.location.hash;
	}, 800);
	
	//fetch_news();
	

}

function clear_news_form(){
	 var percentVal = '0%';
	$("#news_upload_frm")[0].reset();
	 $(".bar").width(percentVal)
     $(".percent").html(percentVal);
	  $("#success_btn").hide();
	  $("#upload_btn").show();
	  $("#popupUpload").popup("close");
	  
}



function fetch_news(){
	var ajax_get_news = {
		ajax:'get_news'
	}; 
	
	$.ajax({
		url: "php/news.php",
		type: 'POST',
		data: ajax_get_news,
		success: function($obj){
			//console.log("news="+$obj);
			var json_data = JSON.parse($obj);
    		console.log(json_data);
			window.news_array=json_data;
			window.news_array_size=json_data.length;
			console.log(json_data.length);
			//fetch news data into webpage
			
			
			if(json_data!='no news'){
				$("#news-summary").empty();
				for(i=0;i<json_data.length;i++){
					//console.log(json_data[i].headline);
					//console.log(json_data[i].image);
							//$("#news-summary").append('<li data-news-id='+i+' onClick="load_news_item('+i+')"><img class="news_thumb" src="uploads/'+json_data[i].image+'" /><h2>'+json_data[i].headline+'</h2><p>'+json_data[i].news_desc+'</p></li>');
					
				$("#news-summary").append('<li onClick="load_news_item('+i+')"><div class="img_container" style="background:url(uploads/'+json_data[i].image+') center center no-repeat;background-size:cover;"></div><div class="news_desc_short"><h2>'+json_data[i].headline+'</h2><p class="comment more" >'+json_data[i].news_desc+'</p></div></li>');
					
				letters();
				
				}
			load_news_item(0);//default load first news	
			}else{
				console.log("no news");	
			}
			
		}
	}); 	
}

function load_news_item(news_id){  

	//alert(n_id);//n_post_time news_desc
	//alert(window.news_array[n_id].image);
	//console.log(window.news_array);
	//n_id=news_id-1;
	n=news_id;
	$("#load_news_area").empty();
	$("#comment_con").empty();
	//$("#load_news_area").append('<h1 id="news-header-title">'+window.news_array[n_id].headline+'</h1><p class="user_name">By <span id="news-user-name">'+window.news_array[n_id].f_name+' '+window.news_array[n_id].l_name+'</span></p><p class="news_time">'+window.news_array[n_id].n_post_time+'</p> <img src="uploads/'+window.news_array[n_id].image+'" id="news-img1" /><img src="uploads/'+window.news_array[n_id].image+'" id="news-img2" /><p id="news-description">'+window.news_array[n_id].news_desc+' </p>');
	
	$("#load_news_area").append('<h1 id="news-header-title">'+window.news_array[n].headline+'</h1><p class="user_name">By <span id="news-user-name">'+window.news_array[n].f_name+' '+window.news_array[n].l_name+'</span></p><p class="news_time">'+window.news_array[n].n_post_time+'</p><div style="background:url(uploads/'+window.news_array[n].image+') center center no-repeat; background-size:cover"  id="news-img1" ></div><div style="background:url(uploads/'+window.news_array[n].image+') center center no-repeat; background-size:cover" id="news-img2" ><img src="images/click_to_play.png"  id="click_to_play_btn"/></div><p id="news-description">'+window.news_array[n].news_desc+' </p>');	
	
	
	//window.n_id=news_id;
	//window.n_id=window.news_array[n_id].n_id;
	//news_id=window.news_array[n_id].n_id;
	//alert(window.news_array[n].n_id);
	
	news_id=window.news_array[n].n_id;
	window.n_id=news_id;
	
	if(window.login_status==1){
		
	}
	load_votes(news_id);
	load_comments(news_id);
	
}

function load_votes(news_id){
	
	if(window.user_id==""){
		var ajax_get_votes_only = {
			n_id:news_id,
			ajax:'get_votes'
		}; 
		
		$.ajax({
			url: "php/votes.php",
			type: 'POST',
			data: ajax_get_votes_only,
			success: function($obj_votes){
				//console.log($obj_votes);
				var json_get_votes = JSON.parse($obj_votes);
				console.log(json_get_votes);
				//console.log(json_get_votes.total_votes);
				$("#qty1").val(json_get_votes.total_votes);

				
				
			}
		});
		
	}else{
		var ajax_get_votes = {
			u_id:window.user_id,
			n_id:news_id,
			ajax:'get_votes_with_user'
		}; 
		$.ajax({
			url: "php/votes.php",
			type: 'POST',
			data: ajax_get_votes,
			success: function($obj_votes){
				//console.log($obj_votes);
				var json_get_votes = JSON.parse($obj_votes);
				console.log(json_get_votes);
				//console.log(json_get_votes.total_votes);
				$("#qty1").val(json_get_votes.total_votes);

				window.user_votes_status=json_get_votes.user_votes_status;
				
				
			}
		});
		
		
		
	}
	
	//post_button();
		

	
}

/*
    $('.add').on('click',function(){
        var $qty=$(this).closest('p').find('.qty');
        var currentVal = parseInt($qty.val());
        if (!isNaN(currentVal)) {
            $qty.val(currentVal + 1);
        }
    });
    $('.minus').on('click',function(){
        var $qty=$(this).closest('p').find('.qty');
        var currentVal = parseInt($qty.val());
        if (!isNaN(currentVal) && currentVal > 0) {
            $qty.val(currentVal - 1);
        }
    });
	
*/	
function add_one(){
	if(window.login_status==1){
		if(window.user_votes_status==0){
			window.user_votes_status=1;
			var $qty=$("#qty1");
			var currentVal = parseInt($qty.val());
			if (!isNaN(currentVal)) {
				$qty.val(currentVal + 1);
				
			}	
			save_votes(window.user_votes_status);
		}	
	}else{
			alert("please login first");	
	}
}
function minus_one(){
	if(window.login_status==1){
		if(window.user_votes_status==1  ){
			window.user_votes_status=0;
			var $qty=$("#qty1");
			var currentVal = parseInt($qty.val());
			if (!isNaN(currentVal) && currentVal > 0) {
				$qty.val(currentVal - 1);
				
			}
			save_votes(window.user_votes_status);
		}
	}else{
			alert("please login first");	
	}
}


function save_votes(){
	
	
	var ajax_set_vote_status = {
		u_id:window.user_id,
		n_id:window.n_id,
		vote_status:window.user_votes_status,
		ajax:'set_vote_status'
	}; 
	
	//post_button();
		
	$.ajax({
		url: "php/votes.php",
		type: 'POST',
		data: ajax_set_vote_status,
		success: function($obj_vote_status){
			console.log($obj_vote_status);
			//load_votes(window.n_id);
			
		}
	});
}


function save_comment(){
	var user_img="";
	//alert(window.login_method);
	var comment=$(".comment_desc").val();
	if(window.login_method=="facebook"){
		//alert("fb id"+window.fb_id);
		 $("#comment_con").prepend('<li class="comment_user" ><div class="user_pro_pic_after" style="background:url(https://graph.facebook.com/' +window.fb_id+ '/picture?width=50&height=50)center center no-repeat"></div><div class="comment_description"><h3><span>'+window.user_fb_full_name+'</span></h3><p>'+comment+'</p></div></li>');
	}else{
		 user_img=window.user_img;
		 $("#comment_con").prepend('<li class="comment_user" ><div class="user_pro_pic_after" style="background:url(uploads/'+ user_img +')center center no-repeat"></div><div class="comment_description"><h3><span>'+window.user_default_full_name+'</span></h3><p>'+comment+'</p></div></li>');
	}
	
	$(".comment_desc").val("");
	//alert("user_id="+window.user_id);
	//alert("n_id="+window.n_id);
	var ajax_save_comment = {
		comment:comment,
		u_id:window.user_id,
		n_id:window.n_id,
		ajax:'save_comment'
	}; 
	
	//post_button();
		
	$.ajax({
		url: "php/save_comment.php",
		type: 'POST',
		data: ajax_save_comment,
		success: function($obj){
			console.log($obj);
			load_comments(window.n_id);//refresh comment list
		}
	});

}

function load_comments(news_id){
	//alert(news_id)
	var ajax_load_comments = {
		news_id:n_id,
		ajax:'get_comments'
	}; 
		
	$.ajax({
		url: "php/get_comments.php",
		type: 'POST',
		data: ajax_load_comments,
		success: function($obj){
			console.log("get_comments_list="+$obj);
			var json_get_comments = JSON.parse($obj);
    		//console.log(json_get_comments);
			if(json_get_comments!="empty"){
				
			
			$("#comment_con").empty();
			var no_of_comments=json_get_comments.length;
			
			for ( var i=0; i<no_of_comments; i++ )
			{
				var user_pic=json_get_comments[i]['picture'];
				var social_id=json_get_comments[i]['social_id'];
				var f_name=json_get_comments[i]['f_name'];
				var l_name=json_get_comments[i]['l_name'];
				var comment=json_get_comments[i]['cmt_desc'];
				var comment_id=json_get_comments[i]['c_id'];
				var c_post_time=json_get_comments[i]['c_post_time'];
				if(social_id==""){
				$("#comment_con").append('<li class="comment_user" data-cmt-id="'+comment_id+'"><div class="user_pro_pic_after" style="background:url(uploads/'+ user_pic +')center center no-repeat"></div><div class="comment_description"><h3><span>'+f_name+'</span> <span>'+l_name+'</span></h3><p>'+comment+'</p></div><p class="comment_time">Posted at:-'+c_post_time+'</p></li>');
				
				}else{
					
				$("#comment_con").append('<li class="comment_user" data-cmt-id="'+comment_id+'"><div class="user_pro_pic_after" style="background:url(https://graph.facebook.com/' +social_id+ '/picture?width=50&height=50)center center no-repeat"></div><div class="comment_description"><h3><span>'+f_name+'</span> <span>'+l_name+'</span></h3><p>'+comment+'</p></div><p class="comment_time">Posted at:-'+c_post_time+'</p></li>');
				}

			}//for
			
			
			}//if
			 
	    }//success
	}); 
}


function filter_news(){
	
	
}

