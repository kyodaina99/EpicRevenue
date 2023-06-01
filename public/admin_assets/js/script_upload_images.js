			    function alertMessage(msg) {
				    $('#popup_alert_message').empty();
					$('#popup_alert_message').append(msg);
					$('#popup_alert').popup("open");
				}

			    //$('#addCamp').on('pageinit', function(){
					$("#chooseFile").click(function(e){
						e.preventDefault();
						$("input[name=feature_image]").trigger("click");
					});
					
					$("input[name=feature_image]").change(function(){
						var fileform = document.getElementById ("image_file_form").files;
						$info = $("#info");
						$info.empty();
						if (fileform.length>1){
							alertMessage("You are allowed to upload maximum 3 images");
							//$info.append("You are allowed to upload maximum 3 images");
							$("#image_file_form").val("");
							}
						else
						for(var i=0; i< fileform.length; i++)
						{     
							var file = fileform[i];      
							if (file && file.name) {
								var image_preview_li = document.createElement("preview_image_box"); 
								
								var image_preview_div = document.createElement("div"); 
								image_preview_div.className  = "image_preview";
								displayAsImage3(file, image_preview_div);
								image_preview_li.appendChild(image_preview_div);
								
								//var image_preview_des = document.createElement("div");
								//image_preview_des.className = "image_preview_des";
								//image_preview_des.innerHTML = file.name ;
								//image_preview_li.appendChild(image_preview_des);
								
								//$info.append("<div class='image_preview_description'>name:<span>" + file.name + "</span></div>");
								document.getElementById("info").appendChild(image_preview_li);
							}
	
							//$info.listview("refresh");
						}
					});
			    //});
			
			    function displayAsImage3(file, container) {
					if (typeof FileReader !== "undefined") {
						var img = document.createElement("img"),
						    reader;							
						container.appendChild(img);
						reader = new FileReader();
						reader.onload = (function (theImg) {
							return function (evt) {
								theImg.src = evt.target.result;
							};
						}(img));
						reader.readAsDataURL(file);
					}
				}
				
				//MOBILE ICON PANEL
				$("#mobile_icon_div").hide();
				
				$('#mobile_icon_check').change(function() {
					if($(this).is(":checked")) {
						$("#mobile_icon_div").show();
					}
					else
						$("#mobile_icon_div").hide();     
				});
				
				$("#chooseFileMobileIcon").click(function(e){
						e.preventDefault();
						$("input[name=mobile_icon]").trigger("click");
					});
					
				$("input[name=mobile_icon]").change(function(){
						var fileform = document.getElementById ("image_file_form2").files;
						$info = $("#info2");
						$info.empty();
						if (fileform.length>1){
							alertMessage("You are allowed to upload maximum 3 images");
							//$info.append("You are allowed to upload maximum 3 images");
							$("#image_file_form2").val("");
							}
						else
						for(var i=0; i< fileform.length; i++)
						{     
							var file = fileform[i];      
							if (file && file.name) {
								var image_preview_li = document.createElement("preview_image_box2"); 
								
								var image_preview_div = document.createElement("div"); 
								image_preview_div.className  = "image_preview";
								displayAsImage3(file, image_preview_div);
								image_preview_li.appendChild(image_preview_div);
								
								//var image_preview_des = document.createElement("div");
								//image_preview_des.className = "image_preview_des";
								//image_preview_des.innerHTML = file.name ;
								//image_preview_li.appendChild(image_preview_des);
								
								//$info.append("<div class='image_preview_description'>name:<span>" + file.name + "</span></div>");
								document.getElementById("info2").appendChild(image_preview_li);
							}
	
							//$info.listview("refresh");
						}
					});
			    //});
			
			    function displayAsImage3(file, container) {
					if (typeof FileReader !== "undefined") {
						var img = document.createElement("img"),
						    reader;							
						container.appendChild(img);
						reader = new FileReader();
						reader.onload = (function (theImg) {
							return function (evt) {
								theImg.src = evt.target.result;
							};
						}(img));
						reader.readAsDataURL(file);
					}
				}
