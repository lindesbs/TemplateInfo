function SetCheck(selectAllCheckBox,checkState) 
{
	var checkListBox = document.TemplateInfo.getElementsByTagName("input");
	
	for (i=0;i<checkListBox.length; i++)
	{
		checkListBox[i].checked=checkState;		
	}	
}

  var indexLevel = 1;
  
  function dragContainerInit(el){
  
	var dragContainerOptions = {

		handle: el, 
		grid:4,
		onStart: function(){
			indexLevel++; 
			el.parentNode.style.zIndex = indexLevel;
		}.bind(this),
		 
		onComplete: function(){
			var windowPos = el.getParent();
			
			var windowSize=windowPos.getStyles('left','top');
			
			document.getElementById('TemplateInfo_X').value=windowSize['left'];
			document.getElementById('TemplateInfo_Y').value=windowSize['top'];
		
		}.bind(this)
	};
	
  	el.style.cursor = 'move';
		
	el.parentNode.makeDraggable(dragContainerOptions);
  
  }
  


  window.onload=function()
  {
	var draggables = document.getElementsBySelector('.dragger');
	draggables.each(function(el){dragContainerInit(el)});
	
  }
