
<script>
(function( $ ){

  $.fn.canvasAreaDraw = function(options) {

    this.each(function(index, element) {
      init.apply(element, [index, element, options]);
    });

  }

  var init = function(index, input, options) {

	var Point = function(x, y) {
		this.x = x;
		this.y = y;
	};
			Point.prototype.setX = function(x){
				this.x = x;
			}
			Point.prototype.setY = function(y){
				this.y = y;
			}
			Point.prototype.getY = function(){
				return this.y;
			}
			
			Point.prototype.getX = function(){
				return this.x;
			}
	
	/*
	* A Shape is an object made up of an id that represents the id of the house in the database
	* Constructor takes a single int digit as an id
	*/
var Shape = function(id) {
		this.id = id;
		this.points = [];
	};
			
			Shape.prototype.getId = function(){
				return this.id;
			}
			
			Shape.prototype.getPoints = function(){
				return this.points;
			}
			
			Shape.prototype.resetPoints = function(){
				this.points = [];
			}
			
			Shape.prototype.addPoint = function(aPoint){
				this.points.push(aPoint);
			}
	
	var allShapes = [];
	var allPoints = [];
	
	/*This section is for retrieving the shapes collected from the database & converting them into jQuery objects */
	var shapesFromDB = <?php echo $json_shapes; ?>;
		$.each(shapesFromDB, function(i) {
		var thisShape_DB = shapesFromDB[i];
		var id = thisShape_DB['id'];
		
		var thisShape = new Shape(id); //TODO add id
		console.log('Added shape with id:' + id);
		allShapes.push(thisShape);
		
		var points_DB = thisShape_DB['points'];
			$.each(points_DB, function(j){
			var thisPoint_DB = points_DB[j];
			var x = thisPoint_DB['x'];
			var y = thisPoint_DB['y'];
			var thisPoint = new Point(x,y);
			thisShape.addPoint(thisPoint);
			console.log('Added point to shape with x:' + x + " and y: " + y);
			});
		
		});
	/***********************************************/
	
	
	var activePoint, settings, firstTime = true;
	var currentlyEditing = false;
    var $reset, $areaViewer, $clearCanvas,  $canvas, ctx, image;
    var draw, mousedown, stopdrag, move, resize, reset, rightclick, record;
	
	var currentShapeIndex = 0; //The index of the shape you are currently working with.
	var currentHouseId = 0;
	
	var map_id = $(this).attr('map_id');

    settings = $.extend({
      imageUrl: $(this).attr('data-image-url')
    }, options);

	
    $reset = $('<button type="button" class="btn"><i class="icon-trash"></i>Clear Current Points</button>');
	
    $canvas = $('<canvas id="newCanvas"></canvas>');
	$areaViewer = $('#areaViewer');
	
	
	
	//My buttons
	$clearCanvas = $('<button type="button" class="btn"><i class="icon-trash"></i>Clear All Shapes</button>');
	$nextArea_button = $('<button id="nextButton" type="button" class="btn"><i class="icon-trash"></i>Save & Next</button>');
	$saveToDatabase_button = $('<button id="saveToDatabaseButton" type="button" class="btn">Save to Database</button>');

	///////
    ctx = $canvas[0].getContext('2d');

    image = new Image();
    resize = function() {
      $canvas.attr('height', image.height).attr('width', image.width);
      draw();
    };
    $(image).load(resize);
    image.src = settings.imageUrl;
    if (image.loaded) resize();
    $canvas.css({background: 'url('+image.src+')'});

    $(document).ready( function() {
      $(input).after('<br>', $canvas, '<br>', $reset, $clearCanvas, $nextArea_button, $saveToDatabase_button);
      $reset.click(reset);
	  $clearCanvas.click(clear);
	  $nextArea_button.click(nextArea);
	  $saveToDatabase_button.click(saveToDatabase);

      $canvas.on('mousedown', mousedown);
      $canvas.on('contextmenu', rightclick);
      $canvas.on('mouseup', stopdrag);
    });

	saveToDatabase = function() {
	console.log("Save to database");

	$.post('./saveMapToDatabase.php', { jsonData: JSON.stringify(allShapes), map_id: map_id}, function(response){
   alert(response);
	});
	};
    reset = function() {
	//when reset button is pressed
	  allPoints = [];
      firstTime = true;
      draw();
    };
	
	clear = function() {
	   ctx.canvas.width = ctx.canvas.width; //erases everything on the canvas
	   allPoints = [];
	   allShapes = [];
	   currentlyEditing = false;
	   firstTime = true;
	}


	

	 
	editShape = function(id) {
	currentlyEditing = true;


	
	allPoints = [];
	firstTime = false;
	var currentShape = null;
	$.each(allShapes, function(i) {
		var thisShape = allShapes[i];
		if (thisShape.getId() == id)
			{
			currentShape = thisShape;
			currentShapeIndex = i;
			}
	});
	var currentShapePoints = currentShape.getPoints();
	for (var j = 0; j < currentShapePoints.length; j++) {
			var thisPoint = currentShapePoints[j];

				  allPoints.push( new Point(thisPoint.getX(), thisPoint.getY()));

				draw();
      }

	} 
	
	
	$('#houseOptions').change(function(){
		if (allPoints.length > 2)
		{
		saveSelection();
		}
		else
		{
		notEnoughPoints();
		}
		
	currentHouseId = $(this).find("option:selected").attr("value");
	
	editCurrentHouseId();
		console.log("currentHouseId" + currentHouseId);
		
		
	});
	
	notEnoughPoints = function(){
	removeShape(currentHouseId);
		allPoints = [];
		draw();
	}
	
	removeShape = function(houseId){
	var shapeToRemove = null;
	$.each(allShapes, function(i) {
		
		var thisShape = allShapes[i];
		if (thisShape.getId() == currentHouseId)
			{
			shapeToRemove = thisShape;
			return false; //break from each loop
			}
	});
	if (shapeToRemove != null)
		{allShapes.splice($.inArray(shapeToRemove, allShapes),1);
	console.log("Shape removed.");}
	
	}
	
	editCurrentHouseId = function(){
	
		$.each(allShapes, function(i) {
		var thisShape = allShapes[i];
		if (thisShape.getId() == currentHouseId)
			{
			console.log("FOUND HOUSE!!!");
			editShape(currentHouseId);
			}
	});
	}
	
	/*
	*	Method: nextArea
	*	This method will save the currently selected area to 'shapes'
	*	A shape must consist of 2 points.
	*/
	nextArea = function() {
if (allPoints.length > 2)
		{
		saveSelection();
		}
		else
		{
		notEnoughPoints();
		}
		
	 $('#houseOptions option:selected').next().attr('selected', 'selected');
		 	currentHouseId = $('#houseOptions option:selected').attr("value");
			console.log("currentHouseId: " + currentHouseId);
	
	editCurrentHouseId();
		
		
		
		

	}

	saveSelection = function() {
	
	if (currentlyEditing)
		{
		var thisShape = allShapes[currentShapeIndex];
		thisShape.resetPoints();
		$.each(allPoints, function(i) { 
			thisShape.addPoint(allPoints[i]);
		});
		currentShapeIndex = allShapes.length;
		}
		else
		{
		//add a new shape to the array
		var thisShape = new Shape(currentHouseId); //TODO add id
		console.log("new Shape(" + currentHouseId + ");");
		
		$.each(allPoints, function(i) { 
			thisShape.addPoint(allPoints[i]);
		});
		allShapes.push(thisShape);
		currentShapeIndex ++;
		}
		
		allPoints = [];
		currentlyEditing = false;
		firstTime = true;
		draw();
	}
	/*
	*	Method: move
	*	This method allows you to move a current point on the shape you are working with.
	*/
    move = function(e) {
      if(!e.offsetX) {
        e.offsetX = (e.pageX - $(e.target).offset().left);
        e.offsetY = (e.pageY - $(e.target).offset().top);
      }
	  
	  if ((allPoints.length == 4) && (firstTime == true))
	  {

	  allPoints[3].setX(Math.round(e.offsetX));
	  
	  allPoints[1].setY(Math.round(e.offsetY));
	  };

	  
      allPoints[activePoint].setX(Math.round(e.offsetX));
      allPoints[activePoint].setY(Math.round(e.offsetY));
      draw();

    }


    stopdrag = function() {
      $(this).off('mousemove');
      record();
      activePoint = null;

	  firstTime = false;
    };

    rightclick = function(e) {
      e.preventDefault();
      if(!e.offsetX) {
        e.offsetX = (e.pageX - $(e.target).offset().left);
        e.offsetY = (e.pageY - $(e.target).offset().top);
      }
      var x = e.offsetX, y = e.offsetY;
      for (var i = 0; i < allPoints.length; i++) {
		var thisPoint = allPoints[i];
        dis = Math.sqrt(Math.pow(x - thisPoint.getX(), 2) + Math.pow(y - thisPoint.getY(), 2));
        if ( dis < 6 ) {
          allPoints.splice(i, 1);
          draw();
          record();
          return false;
        }
      }
      return false;
    };

    mousedown = function(e) {
	
	if (currentHouseId != 0)
	{
      var x, y, dis, lineDis, insertAt = allPoints.length;

      if (e.which === 3) {
        return false;
      }

      e.preventDefault();
      if(!e.offsetX) {
        e.offsetX = (e.pageX - $(e.target).offset().left);
        e.offsetY = (e.pageY - $(e.target).offset().top);
      }
      x = e.offsetX; y = e.offsetY;
	  
	  //Create 3 other points to complete rectangle
	  if (allPoints.length == 0)
	  {
	  allPoints.push(new Point(x-7,y));
	  allPoints.push(new Point(x-7,y-7));
	 allPoints.push(new Point(x,y-7));
	 
	
	}

	for (var i = 0; i < allPoints.length; i++)
	{

        dis = Math.sqrt(Math.pow(x - allPoints[i].getX(), 2) + Math.pow(y - allPoints[i].getY(), 2));
        if ( dis < 6 ) {
          activePoint = i;
          $(this).on('mousemove', move);
          return false;
        }
      }
	  
	  for (var i = 0; i < allPoints.length; i++) {
        if (i > 0) {
          lineDis = dotLineLength(
            x, y,
            allPoints[i].getX(), allPoints[i].getY(),
            allPoints[i-1].getX(), allPoints[i-1].getY(),
            true
          );
          if (lineDis < 6) {
            insertAt = i;
          }
        }
      }
	  
	  allPoints.splice(insertAt, 0, new Point(Math.round(x), Math.round(y)));

      activePoint = insertAt;
      $(this).on('mousemove', move);

      draw();
      record();

      return false;
    }
	else
	{
	alert("Please select a house from the menu on the right.");
	}
	};

	 draw = function() {

      ctx.canvas.width = ctx.canvas.width; //erases everything on the canvas


	  $.each(allShapes, function(i) {  //for each shape
	  var thisShape = allShapes[i];
	  var thisShapesPoints = thisShape.getPoints();
	  
      record();

      ctx.globalCompositeOperation = 'destination-over';
      ctx.fillStyle = 'rgb(255,255,255)'
      ctx.strokeStyle = 'rgb(255,20,20)';
      ctx.lineWidth = 1;
	  
		ctx.beginPath();
		
		ctx.moveTo( thisShapesPoints[0].getX(), thisShapesPoints[0].getY() ); //Move to the first point

      
	  for (var j = 0; j < thisShapesPoints.length; j++) { //for every point of this shape
	  var thisPoint = thisShapesPoints[j];
	  
	  if ((currentlyEditing) && (i==currentShapeIndex))
	  {
	  console.log("Not drawing editing shape");
	  }
	  else
	  {
        //ctx.fillRect(shapes[i][j]-2, shapes[i][j+1]-2, 4, 4);
        //ctx.strokeRect(shapes[i][j]-2, shapes[i][j+1]-2, 4, 4);
        if (thisShapesPoints.length > 1 && j > 0) {
          ctx.lineTo(thisPoint.getX(), thisPoint.getY());
        }
		}
      }
      ctx.closePath();
      ctx.fillStyle = 'rgba(255,0,0,0.3)';
      ctx.fill();
      ctx.stroke();
			
		});
		
		
      record();
      if (allPoints.length < 1) {
        return false;
      }
	  
      ctx.globalCompositeOperation = 'destination-over';
      ctx.fillStyle = 'rgb(255,255,255)'
      ctx.strokeStyle = 'rgb(255,20,20)';
      ctx.lineWidth = 1;
		
      ctx.beginPath();
      ctx.moveTo(allPoints[0].getX(), allPoints[0].getY());
      for (var i = 0; i < allPoints.length; i++) {
		var thisPoint = allPoints[i];
	  
        ctx.fillRect(thisPoint.getX()-2,thisPoint.getY()-2, 4, 4);
        ctx.strokeRect(thisPoint.getX()-2, thisPoint.getY()-2, 4, 4);
        if (allPoints.length > 1 && i > 0) {
          ctx.lineTo(thisPoint.getX(), thisPoint.getY());
        }
      }
      ctx.closePath();
      ctx.fillStyle = 'rgba(255,255,0,0.3)';
      ctx.fill();
      ctx.stroke();
    };

    record = function() {
		var pointsString = "";
		 $.each(allPoints, function(i) {
			var thisPoint = allPoints[i];
			pointsString = pointsString + thisPoint.getX() + "," + thisPoint.getY() + ",";
		 })
      $(input).val(pointsString);
    };
	
	
	
	$(document).unbind('keypress').bind('keypress',function(e){
	
		console.log(e.keyCode);
		if (e.keyCode == 115) //letter S for save selection
		{
		$("#nextButton").click();
		}
		else if (e.keyCode == 99) //letter C for cancel selection
		{
		cancelSelection();
		}
	});
	
	cancelSelection = function() {
	console.log("cancelSelection function");
	allPoints = [];
	$("#houseOptions option:selected").removeAttr("selected");
	firstTime = true;
	currentlyEditing = false;
	currentHouseId = 0;
	draw();
	}
	
    $(input).on('change', function() {
      if ( $(this).val().length ) {
        points = $(this).val().split(',').map(function(point) {
          return parseInt(point, 10);
        });
      } else {
        points = [];
      }
      draw();
    });

	
	$(document).ready(function() {
		console.log("document.ready from canvasAreaDraw");
		$("#houseOptions").val($("#houseOptions option:first").val());
		currentHouseId = $("#houseOptions option:first").attr("value");
		editCurrentHouseId();
		console.log("currentHouseId: " + currentHouseId);
		});
  };

  $(document).ready(function() {
    $('.canvas-area[data-image-url]').canvasAreaDraw();

  });

  var dotLineLength = function(x, y, x0, y0, x1, y1, o) {
    function lineLength(x, y, x0, y0){
      return Math.sqrt((x -= x0) * x + (y -= y0) * y);
    }
    if(o && !(o = function(x, y, x0, y0, x1, y1){
      if(!(x1 - x0)) return {x: x0, y: y};
      else if(!(y1 - y0)) return {x: x, y: y0};
      var left, tg = -1 / ((y1 - y0) / (x1 - x0));
      return {x: left = (x1 * (x * tg - y + y0) + x0 * (x * - tg + y - y1)) / (tg * (x1 - x0) + y0 - y1), y: tg * left - tg * x + y};
    }(x, y, x0, y0, x1, y1), o.x >= Math.min(x0, x1) && o.x <= Math.max(x0, x1) && o.y >= Math.min(y0, y1) && o.y <= Math.max(y0, y1))){
      var l1 = lineLength(x, y, x0, y0), l2 = lineLength(x, y, x1, y1);
      return l1 > l2 ? l2 : l1;
    }
    else {
      var a = y0 - y1, b = x1 - x0, c = x0 * y1 - y0 * x1;
      return Math.abs(a * x + b * y + c) / Math.sqrt(a * a + b * b);
    }
  };
})( jQuery );
</script>