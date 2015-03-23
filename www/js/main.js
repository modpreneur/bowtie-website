ZeroClipboard.config( { swfPath: "../src/js/ZeroClipboard.swf" } );


var client = new ZeroClipboard( $(".button-copy") );
client.on( "copy", function (event) {
    var button = $(event.target);
    var parent = button.parent(".copy-box");
    var copyText = parent.find(".copy-text");

    var clipboard = event.clipboardData;
    clipboard.setData( "text/plain", copyText.html()  );

});

function getYPositionOfElement(domElement){
    var pos = 0;
    while (domElement != null){
        pos += domElement.offsetTop;
        domElement = domElement.offsetParent;
    }
    return pos;
}

/** Sticky menu **/
var floatMenu = document.getElementById('left'),
    topBound = document.getElementById('top-bound'),
    bottomBound = document.getElementById('footer');
var topBoundY = getYPositionOfElement(topBound),
    bottomBoundY = getYPositionOfElement(bottomBound);

var marginCorrection = 40;

function stickyMenuHandler(e){
    var view = document.body.scrollTop + document.documentElement.scrollTop;
    if(window.innerWidth < 1024){
        // Mobile / tablet - 67 is height of main-menu bar
        scrollSpy.stop();
        floatMenu.style.top = view >= 67 ? '0px' : (67-view) + 'px';
    } else {
        // PC
        scrollSpy.start();
        if(view + floatMenu.offsetHeight + 60 >= bottomBoundY){
            floatMenu.style.position = 'absolute';
            floatMenu.style.top = '' + (document.body.scrollHeight - (bottomBound.offsetHeight + floatMenu.offsetHeight + topBoundY + marginCorrection)) + 'px';
            console.log(bottomBound.offsetHeight);
        }else if(view >= topBoundY){
            floatMenu.style.position = 'fixed';
            floatMenu.style.top = '0px';
        } else {
            floatMenu.style.position = '';
            floatMenu.style.top = '';
        }
    }
}

window.addEventListener('scroll', stickyMenuHandler);
// initialize
stickyMenuHandler();
