//Create a new canvas instance.  
var canvas = new Canvas('mycanvas', {  
    'injectInto': 'infovis',  
    'width': 1000,  
    'height': 400,  
    //Optional: Add a background canvas  
    //that draws some concentric circles.  
    'backgroundCanvas': {  
        'styles': {  
            'strokeStyle': '#444'  
        },  
        'impl': {  
            'init': function(){},  
            'plot': function(canvas, ctx){  
                var times = 6, d = 200;  
                var pi2 = Math.PI * 2;  
                for (var i = 1; i <= times; i++) {  
                    ctx.beginPath();  
                    ctx.arc(0, 0, i * d, 0, pi2, true);  
                    ctx.stroke();  
                    ctx.closePath();  
                }  
            }  
        }  
    }  
});  




var rgraph = new RGraph(canvas, {  
    //Nodes and Edges parameters  
    //can be overriden if defined in   
    //the JSON input data.  
  
    //This way we can define different node  
    //types individually.  
  
    Node: {  
        'overridable': true,  
         'color': '#cc0000'  
  
    },  
    Edge: {  
        'overridable': true,  
        'color': '#cccc00'  
    },  
  
    //Set polar interpolation.  
    //Default's linear.  
    interpolation: 'polar',  
      
    //Change the transition effect from linear  
    //to elastic.  
    transition: Trans.Elastic.easeOut,  
    //Change other animation parameters.  
    duration:3500,  
    fps: 30,  
    //Change father-child distance.  
    levelDistance: 200,  
      
    //This method is called right before plotting  
    //an edge. This method is useful to change edge styles  
    //individually.  
    onBeforePlotLine: function(adj){  
        //Add some random lineWidth to each edge.  
        if (!adj.data.$lineWidth)   
            adj.data.$lineWidth = Math.random() * 5 + 1;  
    },  
      
    onBeforeCompute: function(node){  
        Log.write("centering " + node.name + "...");  
          
        //Make right column relations list.  
        var html = "<h4>" + node.name + "</h4><b>Connections:</b>";  
        html += "<ul>";  
        Graph.Util.eachAdjacency(node, function(adj){  
            var child = adj.nodeTo;  
            html += "<li>" + child.name + "</li>";  
        });  
        html += "</ul>";  
        document.getElementById('inner-details').innerHTML = html;  
    },  
      
    //Add node click handler and some styles.  
    //This method is called only once for each node/label crated.  
    onCreateLabel: function(domElement, node){  
        domElement.innerHTML = node.name;  
        domElement.onclick = function () {  
            rgraph.onClick(node.id, { hideLabels: false });  
        };  
        var style = domElement.style;  
        style.cursor = 'pointer';  
        style.fontSize = "0.8em";  
        style.color = "#fff";  
    },  
    //This method is called when rendering/moving a label.  
    //This is method is useful to make some last minute changes  
    //to node labels like adding some position offset.  
    onPlaceLabel: function(domElement, node){  
        var style = domElement.style;  
        var left = parseInt(style.left);  
        var w = domElement.offsetWidth;  
        style.left = (left - w / 2) + 'px';  
    },  
      
    onAfterCompute: function(){  
        Log.write("done");  
    }  
      
});  
