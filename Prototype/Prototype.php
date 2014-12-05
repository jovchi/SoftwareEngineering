<html>
<script src="//ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script> <!-- Includes Jquery into the project -->
<div id="info_popup" style="position:absolute; width:100px; height:100px; background-color:red;">
</div>
   <div id="main" class="container">
    <h1>Image Maps Canvas Drawing</h1>
    <form>
    <div class="row">
      <div class="span6">
      <h2> Image 1 </h2>
      <textarea id='newCords' rows=3 name="coords1" class="canvas-area input-xxlarge" disabled 
        placeholder="Shape Coordinates" 
        data-image-url="./img/mapExample.png"></textarea>
      </div>
    </div>
    </form>
	
	<div id='areaViewer'>
	</div>
    </div>
<button id="addCanvas">Add 2 Canvas</button>
<button id="getCanvas">Get Canvas</button>
	
<div style="float: left">
    <img id="ImageMap1" src="./img/mapExample.png" usemap="#ImageMapmapAreas" />
    <map id="ImageMapmapAreas" name="ImageMapmapAreas">
		<area alt="" title="" href="#Tree1" coords="210,100,210,88,217,87,219,74,216,65,205,51,198,53,188,52,190,42,189,29,192,17,199,11,215,10,227,10,234,14,247,31,246,44,241,56,227,64,224,85,230,88,230,102" shape="poly" data-maphilight='{"strokeColor":"0000ff","strokeWidth":1,"fillColor":"00ff00","fillOpacity":0.1}'/>      
	   <area alt="" title="" href="#Tree2" coords="208,221,208,202,198,199,201,191,218,176,229,155,221,132,196,117,169,131,157,158,163,172,177,164,173,180,190,185,192,199,187,201,185,222" shape="poly" data-maphilight='{"strokeColor":"0000ff","strokeWidth":1,"fillColor":"00ff00","fillOpacity":0.1}'/>
      
	  
	  </map>
</div>


 <script language="javascript" src="./jquery.canvasAreaDraw2.js"></script>
  <script language="javascript" src="./jquery.maphilight.js"></script>
<script>
// This is where the jQuery goes ... you hook to the object by using $( "nameOfObject" ).   You can use # to refer to an id or . to refer to a class of objects
$( "#testingDiv" ).hover(
  function() {
	alert("worked"); //popup alert on screen
  }
);
jQuery(function()
                            {
             jQuery('#ImageMap1').maphilight();
                            });
$(document).mousemove( function(e) {
   mouseX = e.pageX; 
   mouseY = e.pageY;
});  
	 $('.info').maphilight({
      fillColor: '008800'
 });

 $("#addCanvas").click(
	function(){
	var co_ordinates = $('#newCords').val().split(',');
	var canvas = document.getElementById('newCanvas');
	var context = canvas.getContext('2d');
	var i = 0;
	context.beginPath();
    context.moveTo(co_ordinates[i], co_ordinates[i+1]);
	i = 2;
	while ( (co_ordinates.length) != i)
		{
		context.lineTo(co_ordinates[i],co_ordinates[i+1]);
		i+=2;
		}
	
	
	
	  // complete custom shape
      context.closePath();
      context.lineWidth = 8;
      context.strokeStyle = 'blue';
      context.stroke();
	}
 );
 
 $("#getCanvas").click(
	function(){
	alert('getCanvas');
	var canvas = document.getElementById('newCanvas');
      var context = canvas.getContext('2d');

      // begin custom shape
      context.beginPath();
      context.moveTo(209, 98);
      context.lineTo(210,82);
      context.lineTo(232,83);
	  context.lineTo(232,98);

      // complete custom shape
      context.closePath();
      context.lineWidth = 2;
      context.strokeStyle = 'blue';
      context.stroke();
	}
 );
 
$(".info").mouseenter(
	function(){

		$('#info_popup').css({'display':'block'});
		 $('#info_popup').css({'top':mouseY,'left':mouseX});
	}
);
 $(".info").mouseleave(
	function(){
		 $('#info_popup').css({'display':'none'});
	}
);
</script>

</html>


