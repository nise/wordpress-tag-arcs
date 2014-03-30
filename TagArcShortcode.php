<?php
/**
 * @package daily
 * @version 0.1
 */
/*
Plugin Name: nise81 tagarc
Plugin URI: http://wordpress.org/#
Description: ...
Author: Niels Seidel
Version: 0.1
Author URI: http://www.nise81.com/
*/

add_action('wp_print_scripts', 'WPWall_ScriptsAction');

function WPWall_ScriptsAction()
{
 $wp_wall_plugin_url = trailingslashit( get_bloginfo('wpurl') ).PLUGINDIR.'/'. dirname( plugin_basename(__FILE__) );
 
 if (!is_admin()){
	  	wp_enqueue_script('jquery');
	  	wp_enqueue_script('jquery-form');
	  	wp_enqueue_script('wp_wall_script', $wp_wall_plugin_url.'/protovis-r3.2.js', array('jquery', 'jquery-form'));
	  	wp_enqueue_script('wp_wall_script2', $wp_wall_plugin_url.'/jit-yc.js', array('jquery', 'jquery-form'));
			wp_enqueue_script('wp_wall_script3', $wp_wall_plugin_url.'/rGraph.js', array('jquery', 'jquery-form'));

	  wp_localize_script( 'wp_wall_script', 'WPWallSettings', array('refreshtime' => 5, 'mode' => "auto"));
	}
}


if ( !class_exists( "TagArcShortcode" ) ) {
    
    class TagArcShortcode {

        /**
         * Shortcode Function
         */
	function tagarc($atts){
		$out = '<div id="tagarc">';
		$out .= wp_tag_arc('number=100&echo=0&largest=16px'); 			//&format=array';
		$out .= '</div>';
		return $out;
	}


	
	/*
	*	
	*/
	function shortcode($args){
	//	function rGraph(){
	
	
	//If a node in this JSON structure  
//has the "$type" or "$dim" parameters  
//defined it will override the "type" and  
//"dim" parameters globally defined in the  
//RGraph constructor.  
	$out = '<div id="center"><div id="mycanvas"></div>    <script type="text/javascript+protovis">';
	
	$out .= "


    var infovis = document.getElementById('mycanvas');
    var w = infovis.offsetWidth, h = infovis.offsetHeight;


var canvas = new Canvas('mycanvas', {  
    'injectInto': document.getElementById('mycanvas'),  
    'width': 1000,  
    'height': 400,  
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

    Node: {  
        'overridable': true,  
         'color': '#cc0000'  
  
    },  
    Edge: {  
        'overridable': true,  
        'color': '#cccc00'  
    },  
  
    interpolation: 'polar',  
      
    transition: Trans.Elastic.easeOut,  
    duration:3500,  
    fps: 30,  
    levelDistance: 200,  
      
    onBeforePlotLine: function(adj){  
        //Add some random lineWidth to each edge.  
        if (!adj.data.$lineWidth)   
            adj.data.$lineWidth = Math.random() * 5 + 1;  
    },  ";
    
    $out .='
      
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
        document.getElementById("inner-details").innerHTML = html;  
    },  
      
    onCreateLabel: function(domElement, node){  
        domElement.innerHTML = node.name;  
        domElement.onclick = function () {  
            rgraph.onClick(node.id, { hideLabels: false });  
        };  
        var style = domElement.style;  
        style.cursor = "pointer";  
        style.fontSize = "0.8em";  
        style.color = "#fff";  
    },  

    onPlaceLabel: function(domElement, node){  
        var style = domElement.style;  
        var left = parseInt(style.left);  
        var w = domElement.offsetWidth;  
        style.left = (left - w / 2) + "px";  
    },  
      
    onAfterCompute: function(){  
        Log.write("done");  
    }  
      
});  

var json = [{  "id": "node0",  
    "name": "node0 name",  
    "data": {},  
    "adjacencies": 
    [{ "nodeTo": "node1",  "data": { "weight": 3 }}] 
    },{  "id": "node1",  
    "name": "node1 name",  
    "data": {},  
    "adjacencies": []}];  

	
rgraph.loadJSON(json, 1);  
rgraph.refresh();


</script>

';	
	
	return $out;
	
	
	}
	
	
	
		
	/**********************/
//	function shortcode($atts){
		
function ArcDiagram($atts){ //Force-Directed
	
////////////////////////////////////////////////////

$options = 'numberposts=500&order=DESC&orderby=date'; // change what ever you want here
$ii  = 0;
$arr = array();

	$postslist = get_posts($options);
	global $wpdb;
	foreach ($postslist as $post){
		setup_postdata($post);
		$name = split(' ', $post->post_date);
		$nodes .= '{nodeName:"' . $name[0] . '", group:2},';
		$arr[$post->ID] = $ii;
		$ii++;
	}
	
	$postslist = get_posts($options);
	global $wpdb;
	foreach ($postslist as $post){
		setup_postdata($post);

		foreach (get_the_tags(''.$post->ID) as $tag){
			$t = get_posts('tag='.$tag->name);
			foreach ($t as $relpost){
				if ($relpost->ID != $post_id){
					$a = $arr[$post->ID] != null ? $arr[$post->ID] : 0;
					$b = $arr[$relpost->ID] != null ? $arr[$relpost->ID] : 0;
					if($a > 0 && $b > 0)
						$links .= '{source:' . $a .' ,target:' . $b . ',value:1},';
				}
			}
		}
	}
		
		
  	$out = '<div id="center"><div id="fig">
    <script type="text/javascript+protovis">
    
    	var nodes = {nodes:[' . $nodes . ' ]};
  		var links = { links:[ '. $links.' ]};

      	var vis = new pv.Panel().width(800).height(400).margin(10).bottom(20);

      	var layout = vis.add(pv.Layout.Arc).nodes(nodes.nodes).links(links.links);

      	layout.link.add(pv.Line)	
      		.lineWidth(function(d) d.linkDegree*0.1);

      	layout.node.add(pv.Dot)
			.size(function(d) d.linkDegree + 2)
          	.fillStyle(pv.Colors.category20().by(function(d) d.group))
          	.strokeStyle(function() this.fillStyle().brighter());

      	//layout.label.add(pv.Label);

      	vis.render();
      
      
      //////////////////////////////////////
      
      var w = document.body.clientWidth,
    h = document.body.clientHeight,
    colors = pv.Colors.category19();

var vis = new pv.Panel()
    .width(w)
    .height(h)
    .fillStyle("white")
    .event("mousedown", pv.Behavior.pan())
    .event("mousewheel", pv.Behavior.zoom());

var force = vis.add(pv.Layout.Force)
    .nodes(nodes.nodes)
    .links(links.links);

force.link.add(pv.Line)    
	.lineWidth(function(d) d.linkDegree*0.2);

force.node.add(pv.Dot)
    .size(function(d) (d.linkDegree + 4) * Math.pow(this.scale, 5))
    .fillStyle(function(d) d.fix ? "brown" : colors(d.group))
    .strokeStyle(function() this.fillStyle().darker())
    .lineWidth(1)
    .title(function(d) d.nodeName)
    .event("mousedown", pv.Behavior.drag())
    .event("drag", force);

//vis.render();

////////////////////////////////////////////////////////


      

    </script>';
			           
	return $out;
	
} // end function
} // End Class TagArcShortcode
} // end if


/**
 * Initialize the admin panel function 
 */

if (class_exists("TagArcShortcode")) {

    $TagArcShortcodeInstance = new TagArcShortcode();
}


/**
  * Set Actions, Shortcodes and Filters
  */
// Shortcode events
if (isset($TagArcShortcodeInstance)) {
    add_shortcode('tagarc',array(&$TagArcShortcodeInstance, 'ArcDiagram'));
}
?>
