// JavaScript Document

function refreshformdesc(data){
	$.each(data, function(i, n){
		switch(i){
		case 'innerhtml':
			$.each(n, function(y, k){
			  var tmp = document.getElementById(y);
			  if (tmp)
			  	tmp.innerHTML = k
			  var tmp = false;
			});
			break;
		case 'disable':
			$.each(n, function(y, k){
				switch(k){
				case '':
				case 'false':
				  var tmp = document.getElementById(y);
				  if (tmp)
				  	tmp.disabled = false;
				  var tmp = '';
				  break;
				default:
				  var tmp = document.getElementById(y);
				  if (tmp)
				  	tmp.disabled = true;
				  var tmp = '';
				  break;
				}
			});
			break;			
		case 'checked':
			$.each(n, function(y, k){
				switch(k){
				case 'false':
				  var tmp = document.getElementById(y);
				  if (tmp) 
				  	tmp.checked  = false;
				  var tmp ='';
				  break;
				default:
				  var tmp = document.getElementById(y);
				  if (tmp) 
				  	tmp.checked  = true;
				  var tmp ='';
				  break;
				}
			});
			break;						
		case 'index':
			$.each(n, function(y, k){
				  var tmp = document.getElementById(y)
				  if (tmp) 
				  	tmp.selectedIndex  = false;
				  var tmp ='';
			});
			break;						
			
		}
	});
}

function setvalue(data){
	$.each(data, function(i, n){
		switch(i){
		default:
		case 'val':
			$.each(n, function(y, k){
			  $("#"+y).val(k);
			});
			break;		
		case 'text':
			$.each(n, function(y, k){
			  $("#"+y).text(k);
			});
			break;		
		case 'html':
			$.each(n, function(y, k){
			  $("#"+y).html(k);
			});
			break;		
		}
	});
}
