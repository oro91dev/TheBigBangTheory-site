$(function(){
	var langButton, langDropdown, lawl;
	
	
	langButton 		= $("#menuButton");
	langDropdown 	= $("#dropdownBox");
	
	langDropdown.css("display","none");
	lawl = langButton.position();
	langDropdown.offset({left:lawl.left,top:lawl.top+45});
	
	
	$(window).resize(function(){
		lawl = langButton.position();
		//langDropdown.offset({left:lawl.left,top:lawl.top+95});
		langDropdown.offset({left:lawl.left-10,top:lawl.top+40});
		
		}
	);
	
	langButton.click( function (){
		if (langDropdown.css("display")=="none"){
			langDropdown.fadeIn("fast");
			lawl = langButton.position();
			langDropdown.offset({left:lawl.left-10,top:lawl.top+40});
		}else{
			langDropdown.fadeOut("fast");
		}
	}
	);
			
});
