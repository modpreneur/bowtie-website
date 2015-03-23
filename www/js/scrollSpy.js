var scrollSpy = {
    mainActive: null,
    subActive: null,
    running: false,

    getYPositionOfElement : function(domElement){
        var pos = 0;
        while (domElement != null){
            pos += domElement.offsetTop;
            domElement = domElement.offsetParent;
        }
        return pos;
    },

    setMainMenu: function(element){
        if(element === this.mainActive)
            return;
        if(this.mainActive !== null){
            this.mainActive.classList.remove('active-menu');
            this.mainActive.classList.remove('active-menu');
        }
        this.mainActive = element;
        this.mainActive.classList.add('active-menu');
    },

    setSubMenu: function(element){
        if(element === this.subActive)
            return;
        if(this.subActive !== null){
            this.subActive.classList.remove('active-menu');
        }
        this.subActive = element;
        this.subActive.classList.add('active-menu');
    },

    /**
     * Function used for getting anchors (can be overriden)
     * @returns {Array.<T>}
     */
    preLoad: function(){
        var sidebar = document.getElementById('sidebar');
        var aTagsArr = [].slice.call(sidebar.getElementsByTagName('a'));

        var anchors = aTagsArr.map(function(item){
            var menuItem = {
                id: item.href.split('#')[1],
                navDOM: item.parentElement,
                isSubmenu: item.href.indexOf('sub') > -1
            };
            if(menuItem.id.length < 1){
                return null
            }
            menuItem.sectionDOM = document.getElementById(menuItem.id);
            menuItem.offset = this.getYPositionOfElement(menuItem.sectionDOM);
            menuItem.groupHeaderDOM = menuItem.isSubmenu ? item.parentElement.parentElement.previousElementSibling : null;
            return menuItem;
        });

        // remove 'null'
        return anchors.filter(function(item){
            return !!item;
        });
    },



    /**
     * function handling scrollSpy onScroll event
     */
    handleScroll: function(){
        // scroll event
        var view = document.body.scrollTop + document.documentElement.scrollTop,
            correction = 300;
        var inView = scrollSpy.anchors.filter(function(item){
            return item.offset < (view + correction);
        });

        var last = inView.length < 1 ? scrollSpy.anchors[0] : inView[inView.length -1];
        if(last.isSubmenu){
            scrollSpy.setSubMenu(last.navDOM);
            scrollSpy.setMainMenu(last.groupHeaderDOM);
        } else{
            scrollSpy.setMainMenu(last.navDOM);
        }
    },

    stop: function(){
        if(this.running) {
            window.removeEventListener('scroll', this.handleScroll);
            this.running = false;
        }
    },

    /**
     * Turn on scrollSpy
     * @param anchors - array of anchor objects
     * anchorObject =
     * {
     *      id: string - id of topic anchor ("Buttons")
     *      navDOM: HTML element - <li></li>
     *      isSubmenu: boolean
     *      sectionDOM: HTML element - <h2 id="Buttons"><h2>
     *      offset: integer - getYPositionOfElement()
     *      groupHeaderDOM: HTML element - <ul></ul>
     * }
     */
    start: function(anchors){
        if(this.running){return;}
        if(!this.anchors) {
            this.anchors = !!anchors ? anchors : this.preLoad();
        }
        // attach scroll event
        window.addEventListener('scroll', this.handleScroll);
        this.running = true;
        //init
        this.handleScroll();
    }
};