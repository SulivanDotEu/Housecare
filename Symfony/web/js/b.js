// JavaScript Document
$(function(){
	var widthColumn 		=	$('a.element').parent().width();
	var widthElem			=	$('a.element').width();
	var nameClassShadow		=	'boxshadow';
	
	var config				=	new Object();
	config.ajax				=	new Object();
	config.resizable		=	new Object();
	config.ajaxPosition		=	new Object();
	
	config.ajax.asynch		=	true;
	config.ajax.method		=	'get';
	config.ajax.dataType	=	'json';
	config.ajax.cache		=	false;
	config.ajax.crossDomain	=	false;
	config.ajax.success		=	function(response){successAjax(response);};
	config.ajax.error		=	function(xhr, error, exception){errorAjax(xhr, error, exception);};
	
	$.extend(config.ajaxPosition, config.ajax, config.ajaxPosition);
	
	config.ajaxPosition.success	=	function(response){successAjaxPosition(response);};
		
	config.resizable.grid		=	[widthColumn, 20];
	config.resizable.maxWidth	=	widthElem;
	config.resizable.minHeight	=	20,
	config.resizable.minWidth	=	widthElem;
	
	var element;
	var column;
	var defautPosition	=	new Object();
	
	$('a.element').resizable(config.resizable);
	
	$('td:not(.minute, .hour)').droppable({
		drop: function( event, ui ) {
			ui.draggable.appendTo(this);
		}
	});
	
	$('a.element').draggable({ 
		containment	: 	"tbody", 
		cursor		:	"move",
		grid		: 	[widthColumn, 20],
		start:function(event, ui){
			$("span.km").html('');
			element = 	$(this);
			column	=	element.parent('td');
			defautPosition	=	ui.originalPosition;
			element.addClass(nameClassShadow);
			config.ajax.url	=	element.attr('data-zipcode');
                        console.log('URL = '+config.ajax.url);
                        $.ajax(config.ajax.url);
                        //alert(config.ajax.url);
		},
		stop : function(event, ui){
			$.ajax(config.ajax);
			var id = element.attr('id');
			console.log('calendar/update/'+id+'/'+ui.originalPosition.top+'/'+column.attr('data-column-id')+'/');
			config.ajaxPosition.url	=	'calendar/update/'+id+'/'+ui.originalPosition.top+'/'+column.attr('data-column-id')+'/';
			$.ajax(config.ajaxPosition);
			removeKm();
		}
	});
		
	function removeKm(){
		$('span.km').html('');
	}
	
	function successAjax(response){		
		if(response.state	==	true) {
			for(obj in response.data){
				//$('td[data-km = "'+obj+'"]:not(.minute, .hour)').children('span.km').html(response.data[obj].km);
				$('td[data-cell-id = "'+obj+'"]').children('span.km').html(response.data[obj]);
			}
			removeShadow();
		}
		else{
			alert('Erreur: '+response.error);		
			returnOriginalPosition();
			removeShadow();
		}
	};
	
	function successAjaxPosition(response){
		if(response.state	==	true) {
			alert('Sauvegarde en BDD');
		}
		else{
			alert('Erreur : '+response.error);			
			returnOriginalPosition();
			removeShadow();
		}
	}
		
	function errorAjax(xhr, error, exception){
		alert('Error Ajax : '+error);			
		returnOriginalPosition();
		removeShadow();
	};
	
	function returnOriginalPosition(){
		element.animate({top:defautPosition.top, left:defautPosition.left});
	}
	
	function removeShadow(){
		element.removeClass(nameClassShadow);
	}
	
	function randData(){
		var retour	=	new Object();
		for(var i = 0; i<200; i++){
			var data = new Object();
			var r	=	Math.floor((Math.random()*255)+1);
			var g	=	Math.floor((Math.random()*255)+1);
			var b	=	Math.floor((Math.random()*255)+1);
			
			var randKm	=	Math.floor((Math.random()*100)+1);
			data.color	=	'('+r+','+g+','+b+')';
			data.km		=	randKm;
			
			retour['km'+i]	=	data;
		}
		return retour;
	}	
});