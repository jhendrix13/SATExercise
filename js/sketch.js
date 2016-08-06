/*
 *  I was being lazy, so I took some code from a tutorial as a base.
 *  modified it heavily
 *  
 *  CREDIT: http://www.williammalone.com/articles/create-html5-canvas-javascript-drawing-app/
 */

function sketchpad(){
    var canvas = document.getElementById('sketchpad');
    var context = canvas.getContext("2d");
    
    //resize canvas so its width is 100
    canvas.width = $('#sketchpad_container').innerWidth();
    
    //in-memory canvas, better performance!
    var memcan = document.createElement('canvas');
        memcan.width = canvas.width;
        memcan.height = canvas.height;
    var memctx = memcan.getContext("2d");

    /* CORE */
    var colors = {
        'eraser' : '#FFF',
        'blue' : '#0A3C57',
        'purple' : '#cb3594',
        'green' : '#659b41',
        'yellow' : '#ffcf33',
        'brown' : '#986928'
    };
    var curColor = colors['blue'];
    var curSize = 3;
    var path = [];
    var paint;

    function addPoint(x, y){
        path.push([x,y]);
    }

    function redraw(){
        context.clearRect(0, 0, context.canvas.width, context.canvas.height); // Clears the canvas

        //draw what is on memctx
        context.drawImage(memcan, 0, 0);
        context.strokeStyle = curColor;
        context.lineJoin = "round";
        context.lineWidth = curSize;
        context.beginPath();
        
        //draw what is on our current path
        var l = path.length;
        for(var i = 0; i < l; i++){
            var x = path[i][0];
            var y = path[i][1];
            
            if(i === 0)
                context.moveTo(x,y);
            else
                context.lineTo(x,y);
        }
        context.stroke();
    }

    $('#sketchpad').mousedown(function(e){
        //new path, lets start our points over
        path = [];
        
        var mouseX = e.pageX - this.offsetLeft;
        var mouseY = e.pageY - this.offsetTop;

        paint = true;
        addPoint(e.pageX - this.offsetLeft, e.pageY - this.offsetTop);
        redraw();
    });

    $('#sketchpad').mousemove(function(e){
        if(paint){
            addPoint(e.pageX - this.offsetLeft, e.pageY - this.offsetTop);
            redraw();
        }
    });

    $('#sketchpad').mouseup(function(e){
        paint = false;
        redraw();
        
        //save the new drawn data to the in-memory canvas
        memctx.clearRect(0, 0, memcan.width, memcan.height);
        memctx.drawImage(canvas, 0, 0);
    });

    $('#sketchpad').mouseleave(function(e){
        if(paint){
            addPoint(e.pageX - this.offsetLeft, e.pageY - this.offsetTop);
            redraw();
        }
        paint = false;
    });
    
    //clear canvas when "Clear" button clicked
    $(document).on('click', '#sketchpad_container button[name="clear"]', function(){
        path = [];
        memctx.clearRect(0, 0, memcan.width, memcan.height);
        context.clearRect(0, 0, canvas.width, canvas.height);
    });
    
    //change drawing color when a color button is clicked
    $(document).on('click', '#sketchpad_container button[name|="color"]', function(){
        var color = $(this).attr('name').split('-')[1];
        
        curColor = colors[color];
        
        if(color == 'eraser')
            curSize = 10;
        else
            curSize = 3;
    });
    
    //add clear button
    $('#sketchpad_container div[name="colors"]').append(
        '<button name="clear">clear</button>'
    );
    
    //add color buttons to canvas container element
    for(var color in colors){
        $('#sketchpad_container div[name="colors"]').append(
            '<button name="color-'+ color +'">'+ color +'</button>'
        );
    }
    
    $('#sketchpad_container div[name="pre-load"]').hide();
    $('#sketchpad_container div[name="loaded"]').show();
}
