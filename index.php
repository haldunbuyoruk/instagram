<?php
include 'Instagram.php';
if(isset($_POST['action'])&& $_POST['action']== 'getPhotos' && isset($_POST['username']) && $_POST['username'] != ""){
	$instagram = new Instagram($_POST['username'], $_POST['max_id']);
	//print_r($instagram); exit;
	print_r($instagram->userInfo);
	exit;
}
?>
<!DOCTYPE html>
<html>
<head>
	<title>Instagram Profiles</title>
	<meta charset="utf-8">
	<meta http-equiv="Content-Type" content="text/html;charset=UTF-8">
	<meta name="description" content="">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="icon" href="https://www.instagram.com/static/images/ico/apple-touch-icon-120x120-precomposed.png/004705c9353f.png" type="image/x-icon"/>
	<link rel="shortcut icon" href="https://www.instagram.com/static/images/ico/apple-touch-icon-120x120-precomposed.png/004705c9353f.png" type="image/x-icon"/>
	<link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">
	<link rel="stylesheet" href="//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">
	<script src="//ajax.googleapis.com/ajax/libs/jquery/1.12.0/jquery.min.js"></script>
	<script src="//maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
	 <script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>
<body>
	<div class="page-wrapper">
		<div class="container-fluid">
		    <div class="container" style="padding-top: 20px;">

					<form method="post"  class="form-inline" onsubmit="clearCanvas();getPhotos();return false;">
						
							<input type="hidden" id="max-id" value="">
							  <label class="sr-only" for="inlineFormInputGroup">Username</label>
							  <div class="input-group mb-2 mr-sm-2 mb-sm-0">
							    <div class="input-group-addon">@</div>
							    <input type="text" class="form-control" id="username" placeholder="Username">
							  </div>
							<input type="submit"  value="Search" class="btn btn-success">
						
					</form>
				<div class="row" id="userInfo" style="display: none;padding-top: 20px">
					<div class="col-md-6">
						<img src="" id="profile_picture"/>
					</div>
					<div class="col-md-6" id="fullname">
						
					</div>

				</div>
				<div class="row" style="padding-top: 20px">
				<hr />
				</div>

				<div class="row" style="padding-top: 20px">
					<div id="photos" class="col-md-12">
						
					</div>
				</div>
				<div class="row"  id="load-more"  style="display: none">
					<div class="col-md-12" style="text-align: center;">
						<button class='btn btn-primary' onclick="getPhotos()">Load More</button>
					</div>
					
				</div>
			</div>
		</div>
	</div>

<script >
	function clearCanvas(){
		$('#photos').html('');
		$('#load-more').hide();
		$('#max-id').val('');
		$('#userInfo').hide();
	}
	function getPhotos(){
		$.ajax({
		 type: 'POST',
		    data: {
		    	action:'getPhotos',
		        username :$('#username').val(),
		        max_id: $('#max-id').val()
		     },
	        dataType: "json",
	        success: function(data){
	        	if(data.items.length > 0){
	        		//if data.more_available == true show load more
	        		if(data.more_available == true){
	        			$('#load-more').show();
	        		}else{
	        			$('#load-more').hide();
	        		}
	        		var html = "";
	        		data.items.map(function(photo, key){
	        			if(key ==0){
	        				$('#profile_picture').attr('src', photo.user.profile_picture);
	        				$('#fullname').html ("<h2>"+ photo.user.full_name+"</h2>");
	        				$('#userInfo').show();
	        			}

	        			if((key+1)%3 == 0){
	        				html +="<div class='row' style='margin-top:10px'>";
	        			}
	        			html +='<div class="col-md-4">';
	        			html +='<div><img src="'+photo.images.thumbnail.url+'" height="'+photo.images.thumbnail.height+'"';
	        			html +='width="'+photo.images.thumbnail.width+'"/></div>';

	        			if(photo.caption != undefined){
	        				html += '<div style="padding:5px 0px"><u>'+photo.caption.text+'</u></div>';
	        			}
	        			html +='</div>';
	        			var id = photo.id.split('_');
	        			$('#max-id').val(id[0]);
	        			if((key+1)%3 == 0){
	        				html +="</div>";
	        			}
	        		});

	        		$('#photos').append(html);
	        	}else{
	        		$('#photos').html('<h2>Sorry, this account is private!</h2>');
	        	}
	     
	        },
	        error: function(){
	        	$('#photos').html('<h2>Sorry, this page isn\'t available.</h2>');
	        }
	    });
	}
</script>

</body>
</html>
