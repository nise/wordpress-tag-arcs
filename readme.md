
## Tag Arcs ##

Tag clouds are very use­ful to vi­sua­lize the most fre­quently used tags on a web­site, e.g. a blog. This is done by stee­ring at­ten­tion through em­pha­si­zed words whose font size, co­lor or po­si­tion stands out. But not­hing can be found out about tem­po­ral re­la­tion of a tag's posts. For me this be­came evi­dently on my own tag cloud (see left) which still ra­tes 'Lima' at the lea­ding po­si­tion whe­reas the re­la­ted ar­ti­cles are more then three years old.
More un­for­t­u­na­tely is the mis­sing re­la­tion to other tags. While one tag is re­ally high­ligh­ted the user can not fi­gure out anything about re­la­ted tags who may ap­pear con­cur­rently.
In or­der to push se­man­tic vi­sua­liza­tion I am go­ing to in­tro­duce Tag­Arcs as mea­ningful and eye catching way to out­line re­la­ti­onships bet­ween tags and posts.

The plugin gives users the oportunity to embed a Tag Arc for a site within any page.
When using the shortcode [tagarc] when writing in the content of any page, the user includes in the page, a 
Tag Arc for posts on that site. 

I am working on adding the ability to set options, such as sizes, etc...

## Installation ##

This section describes how to install the plugin and get it working.

1. Download the tag-arc-shortcode.zip file to a directory of your 
choice(preferably the wp-content/plugins folder)

2. Unzip the tag-arc-shortcode.zip file into the wordpress 
plugins directory: 'wp-content/plugins/' 

3. Activate the plugin through the 'Plugins' menu in WordPress

4. Include the [tagarc] shortcode in any page you wish to include the tag arc display.


## Frequently Asked Questions ##

>How do I use the plugin?
When you write or edit the content of a page, simply include 
[tagarc] (along with the brackets) whenever you want the tag arc to 
be displayed. Make sure you activate the plugin before you use the 
shortcode.

>Why is the tag cloud not displayed, even though I included the shorttag ?
The plugin probably has not yet been activated.

>Why does my posted content also show the shortcode [tagcloud]?
At the moment, the tag-cloud-shortcode plugin only works when used 
in pages. The content displayed by the plugin table probably 
malfunctioned if you used the shortcode in a post.

>How can I include the Arc into my theme?
You can put <?php $tcs = new TagCloudShortcode(); echo $tcs->ArcDiagram(); ?> in your header.

> Why is it so slow
The connections have to be estimated each time the page is loaded. It would be better to store the relations and update them as soon a post or a tag was added.



