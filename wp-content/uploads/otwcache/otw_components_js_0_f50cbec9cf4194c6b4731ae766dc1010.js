// Magnific Popup v0.9.9 by Dmitry Semenov
// http://bit.ly/magnific-popup#build=inline+ajax
(function(a){var b="Close",c="BeforeClose",d="AfterClose",e="BeforeAppend",f="MarkupParse",g="Open",h="Change",i="mfp",j="."+i,k="mfp-ready",l="mfp-removing",m="mfp-prevent-close",n,o=function(){},p=!!window.jQuery,q,r=a(window),s,t,u,v,w,x=function(a,b){n.ev.on(i+a+j,b)},y=function(b,c,d,e){var f=document.createElement("div");return f.className="mfp-"+b,d&&(f.innerHTML=d),e?c&&c.appendChild(f):(f=a(f),c&&f.appendTo(c)),f},z=function(b,c){n.ev.triggerHandler(i+b,c),n.st.callbacks&&(b=b.charAt(0).toLowerCase()+b.slice(1),n.st.callbacks[b]&&n.st.callbacks[b].apply(n,a.isArray(c)?c:[c]))},A=function(b){if(b!==w||!n.currTemplate.closeBtn)n.currTemplate.closeBtn=a(n.st.closeMarkup.replace("%title%",n.st.tClose)),w=b;return n.currTemplate.closeBtn},B=function(){a.magnificPopup.instance||(n=new o,n.init(),a.magnificPopup.instance=n)},C=function(){var a=document.createElement("p").style,b=["ms","O","Moz","Webkit"];if(a.transition!==undefined)return!0;while(b.length)if(b.pop()+"Transition"in a)return!0;return!1};o.prototype={constructor:o,init:function(){var b=navigator.appVersion;n.isIE7=b.indexOf("MSIE 7.")!==-1,n.isIE8=b.indexOf("MSIE 8.")!==-1,n.isLowIE=n.isIE7||n.isIE8,n.isAndroid=/android/gi.test(b),n.isIOS=/iphone|ipad|ipod/gi.test(b),n.supportsTransition=C(),n.probablyMobile=n.isAndroid||n.isIOS||/(Opera Mini)|Kindle|webOS|BlackBerry|(Opera Mobi)|(Windows Phone)|IEMobile/i.test(navigator.userAgent),t=a(document),n.popupsCache={}},open:function(b){s||(s=a(document.body));var c;if(b.isObj===!1){n.items=b.items.toArray(),n.index=0;var d=b.items,e;for(c=0;c<d.length;c++){e=d[c],e.parsed&&(e=e.el[0]);if(e===b.el[0]){n.index=c;break}}}else n.items=a.isArray(b.items)?b.items:[b.items],n.index=b.index||0;if(n.isOpen){n.updateItemHTML();return}n.types=[],v="",b.mainEl&&b.mainEl.length?n.ev=b.mainEl.eq(0):n.ev=t,b.key?(n.popupsCache[b.key]||(n.popupsCache[b.key]={}),n.currTemplate=n.popupsCache[b.key]):n.currTemplate={},n.st=a.extend(!0,{},a.magnificPopup.defaults,b),n.fixedContentPos=n.st.fixedContentPos==="auto"?!n.probablyMobile:n.st.fixedContentPos,n.st.modal&&(n.st.closeOnContentClick=!1,n.st.closeOnBgClick=!1,n.st.showCloseBtn=!1,n.st.enableEscapeKey=!1),n.bgOverlay||(n.bgOverlay=y("bg").on("click"+j,function(){n.close()}),n.wrap=y("wrap").attr("tabindex",-1).on("click"+j,function(a){n._checkIfClose(a.target)&&n.close()}),n.container=y("container",n.wrap)),n.contentContainer=y("content"),n.st.preloader&&(n.preloader=y("preloader",n.container,n.st.tLoading));var h=a.magnificPopup.modules;for(c=0;c<h.length;c++){var i=h[c];i=i.charAt(0).toUpperCase()+i.slice(1),n["init"+i].call(n)}z("BeforeOpen"),n.st.showCloseBtn&&(n.st.closeBtnInside?(x(f,function(a,b,c,d){c.close_replaceWith=A(d.type)}),v+=" mfp-close-btn-in"):n.wrap.append(A())),n.st.alignTop&&(v+=" mfp-align-top"),n.fixedContentPos?n.wrap.css({overflow:n.st.overflowY,overflowX:"hidden",overflowY:n.st.overflowY}):n.wrap.css({top:r.scrollTop(),position:"absolute"}),(n.st.fixedBgPos===!1||n.st.fixedBgPos==="auto"&&!n.fixedContentPos)&&n.bgOverlay.css({height:t.height(),position:"absolute"}),n.st.enableEscapeKey&&t.on("keyup"+j,function(a){a.keyCode===27&&n.close()}),r.on("resize"+j,function(){n.updateSize()}),n.st.closeOnContentClick||(v+=" mfp-auto-cursor"),v&&n.wrap.addClass(v);var l=n.wH=r.height(),m={};if(n.fixedContentPos&&n._hasScrollBar(l)){var o=n._getScrollbarSize();o&&(m.marginRight=o)}n.fixedContentPos&&(n.isIE7?a("body, html").css("overflow","hidden"):m.overflow="hidden");var p=n.st.mainClass;return n.isIE7&&(p+=" mfp-ie7"),p&&n._addClassToMFP(p),n.updateItemHTML(),z("BuildControls"),a("html").css(m),n.bgOverlay.add(n.wrap).prependTo(n.st.prependTo||s),n._lastFocusedEl=document.activeElement,setTimeout(function(){n.content?(n._addClassToMFP(k),n._setFocus()):n.bgOverlay.addClass(k),t.on("focusin"+j,n._onFocusIn)},16),n.isOpen=!0,n.updateSize(l),z(g),b},close:function(){if(!n.isOpen)return;z(c),n.isOpen=!1,n.st.removalDelay&&!n.isLowIE&&n.supportsTransition?(n._addClassToMFP(l),setTimeout(function(){n._close()},n.st.removalDelay)):n._close()},_close:function(){z(b);var c=l+" "+k+" ";n.bgOverlay.detach(),n.wrap.detach(),n.container.empty(),n.st.mainClass&&(c+=n.st.mainClass+" "),n._removeClassFromMFP(c);if(n.fixedContentPos){var e={marginRight:""};n.isIE7?a("body, html").css("overflow",""):e.overflow="",a("html").css(e)}t.off("keyup"+j+" focusin"+j),n.ev.off(j),n.wrap.attr("class","mfp-wrap").removeAttr("style"),n.bgOverlay.attr("class","mfp-bg"),n.container.attr("class","mfp-container"),n.st.showCloseBtn&&(!n.st.closeBtnInside||n.currTemplate[n.currItem.type]===!0)&&n.currTemplate.closeBtn&&n.currTemplate.closeBtn.detach(),n._lastFocusedEl&&a(n._lastFocusedEl).focus(),n.currItem=null,n.content=null,n.currTemplate=null,n.prevHeight=0,z(d)},updateSize:function(a){if(n.isIOS){var b=document.documentElement.clientWidth/window.innerWidth,c=window.innerHeight*b;n.wrap.css("height",c),n.wH=c}else n.wH=a||r.height();n.fixedContentPos||n.wrap.css("height",n.wH),z("Resize")},updateItemHTML:function(){var b=n.items[n.index];n.contentContainer.detach(),n.content&&n.content.detach(),b.parsed||(b=n.parseEl(n.index));var c=b.type;z("BeforeChange",[n.currItem?n.currItem.type:"",c]),n.currItem=b;if(!n.currTemplate[c]){var d=n.st[c]?n.st[c].markup:!1;z("FirstMarkupParse",d),d?n.currTemplate[c]=a(d):n.currTemplate[c]=!0}u&&u!==b.type&&n.container.removeClass("mfp-"+u+"-holder");var e=n["get"+c.charAt(0).toUpperCase()+c.slice(1)](b,n.currTemplate[c]);n.appendContent(e,c),b.preloaded=!0,z(h,b),u=b.type,n.container.prepend(n.contentContainer),z("AfterChange")},appendContent:function(a,b){n.content=a,a?n.st.showCloseBtn&&n.st.closeBtnInside&&n.currTemplate[b]===!0?n.content.find(".mfp-close").length||n.content.append(A()):n.content=a:n.content="",z(e),n.container.addClass("mfp-"+b+"-holder"),n.contentContainer.append(n.content)},parseEl:function(b){var c=n.items[b],d;c.tagName?c={el:a(c)}:(d=c.type,c={data:c,src:c.src});if(c.el){var e=n.types;for(var f=0;f<e.length;f++)if(c.el.hasClass("mfp-"+e[f])){d=e[f];break}c.src=c.el.attr("data-mfp-src"),c.src||(c.src=c.el.attr("href"))}return c.type=d||n.st.type||"inline",c.index=b,c.parsed=!0,n.items[b]=c,z("ElementParse",c),n.items[b]},addGroup:function(a,b){var c=function(c){c.mfpEl=this,n._openClick(c,a,b)};b||(b={});var d="click.magnificPopup";b.mainEl=a,b.items?(b.isObj=!0,a.off(d).on(d,c)):(b.isObj=!1,b.delegate?a.off(d).on(d,b.delegate,c):(b.items=a,a.off(d).on(d,c)))},_openClick:function(b,c,d){var e=d.midClick!==undefined?d.midClick:a.magnificPopup.defaults.midClick;if(!e&&(b.which===2||b.ctrlKey||b.metaKey))return;var f=d.disableOn!==undefined?d.disableOn:a.magnificPopup.defaults.disableOn;if(f)if(a.isFunction(f)){if(!f.call(n))return!0}else if(r.width()<f)return!0;b.type&&(b.preventDefault(),n.isOpen&&b.stopPropagation()),d.el=a(b.mfpEl),d.delegate&&(d.items=c.find(d.delegate)),n.open(d)},updateStatus:function(a,b){if(n.preloader){q!==a&&n.container.removeClass("mfp-s-"+q),!b&&a==="loading"&&(b=n.st.tLoading);var c={status:a,text:b};z("UpdateStatus",c),a=c.status,b=c.text,n.preloader.html(b),n.preloader.find("a").on("click",function(a){a.stopImmediatePropagation()}),n.container.addClass("mfp-s-"+a),q=a}},_checkIfClose:function(b){if(a(b).hasClass(m))return;var c=n.st.closeOnContentClick,d=n.st.closeOnBgClick;if(c&&d)return!0;if(!n.content||a(b).hasClass("mfp-close")||n.preloader&&b===n.preloader[0])return!0;if(b!==n.content[0]&&!a.contains(n.content[0],b)){if(d&&a.contains(document,b))return!0}else if(c)return!0;return!1},_addClassToMFP:function(a){n.bgOverlay.addClass(a),n.wrap.addClass(a)},_removeClassFromMFP:function(a){this.bgOverlay.removeClass(a),n.wrap.removeClass(a)},_hasScrollBar:function(a){return(n.isIE7?t.height():document.body.scrollHeight)>(a||r.height())},_setFocus:function(){(n.st.focus?n.content.find(n.st.focus).eq(0):n.wrap).focus()},_onFocusIn:function(b){if(b.target!==n.wrap[0]&&!a.contains(n.wrap[0],b.target))return n._setFocus(),!1},_parseMarkup:function(b,c,d){var e;d.data&&(c=a.extend(d.data,c)),z(f,[b,c,d]),a.each(c,function(a,c){if(c===undefined||c===!1)return!0;e=a.split("_");if(e.length>1){var d=b.find(j+"-"+e[0]);if(d.length>0){var f=e[1];f==="replaceWith"?d[0]!==c[0]&&d.replaceWith(c):f==="img"?d.is("img")?d.attr("src",c):d.replaceWith('<img src="'+c+'" class="'+d.attr("class")+'" />'):d.attr(e[1],c)}}else b.find(j+"-"+a).html(c)})},_getScrollbarSize:function(){if(n.scrollbarSize===undefined){var a=document.createElement("div");a.id="mfp-sbm",a.style.cssText="width: 99px; height: 99px; overflow: scroll; position: absolute; top: -9999px;",document.body.appendChild(a),n.scrollbarSize=a.offsetWidth-a.clientWidth,document.body.removeChild(a)}return n.scrollbarSize}},a.magnificPopup={instance:null,proto:o.prototype,modules:[],open:function(b,c){return B(),b?b=a.extend(!0,{},b):b={},b.isObj=!0,b.index=c||0,this.instance.open(b)},close:function(){return a.magnificPopup.instance&&a.magnificPopup.instance.close()},registerModule:function(b,c){c.options&&(a.magnificPopup.defaults[b]=c.options),a.extend(this.proto,c.proto),this.modules.push(b)},defaults:{disableOn:0,key:null,midClick:!1,mainClass:"",preloader:!0,focus:"",closeOnContentClick:!1,closeOnBgClick:!0,closeBtnInside:!0,showCloseBtn:!0,enableEscapeKey:!0,modal:!1,alignTop:!1,removalDelay:0,prependTo:null,fixedContentPos:"auto",fixedBgPos:"auto",overflowY:"auto",closeMarkup:'<button title="%title%" type="button" class="mfp-close">&times;</button>',tClose:"Close (Esc)",tLoading:"Loading..."}},a.fn.magnificPopup=function(b){B();var c=a(this);if(typeof b=="string")if(b==="open"){var d,e=p?c.data("magnificPopup"):c[0].magnificPopup,f=parseInt(arguments[1],10)||0;e.items?d=e.items[f]:(d=c,e.delegate&&(d=d.find(e.delegate)),d=d.eq(f)),n._openClick({mfpEl:d},c,e)}else n.isOpen&&n[b].apply(n,Array.prototype.slice.call(arguments,1));else b=a.extend(!0,{},b),p?c.data("magnificPopup",b):c[0].magnificPopup=b,n.addGroup(c,b);return c};var D="inline",E,F,G,H=function(){G&&(F.after(G.addClass(E)).detach(),G=null)};a.magnificPopup.registerModule(D,{options:{hiddenClass:"hide",markup:"",tNotFound:"Content not found"},proto:{initInline:function(){n.types.push(D),x(b+"."+D,function(){H()})},getInline:function(b,c){H();if(b.src){var d=n.st.inline,e=a(b.src);if(e.length){var f=e[0].parentNode;f&&f.tagName&&(F||(E=d.hiddenClass,F=y(E),E="mfp-"+E),G=e.after(F).detach().removeClass(E)),n.updateStatus("ready")}else n.updateStatus("error",d.tNotFound),e=a("<div>");return b.inlineElement=e,e}return n.updateStatus("ready"),n._parseMarkup(c,{},b),c}}});var I="ajax",J,K=function(){J&&s.removeClass(J)},L=function(){K(),n.req&&n.req.abort()};a.magnificPopup.registerModule(I,{options:{settings:null,cursor:"mfp-ajax-cur",tError:'<a href="%url%">The content</a> could not be loaded.'},proto:{initAjax:function(){n.types.push(I),J=n.st.ajax.cursor,x(b+"."+I,L),x("BeforeChange."+I,L)},getAjax:function(b){J&&s.addClass(J),n.updateStatus("loading");var c=a.extend({url:b.src,success:function(c,d,e){var f={data:c,xhr:e};z("ParseAjax",f),n.appendContent(a(f.data),I),b.finished=!0,K(),n._setFocus(),setTimeout(function(){n.wrap.addClass(k)},16),n.updateStatus("ready"),z("AjaxContentAdded")},error:function(){K(),b.finished=b.loadError=!0,n.updateStatus("error",n.st.ajax.tError.replace("%url%",b.src))}},n.st.ajax.settings);return n.req=a.ajax(c),""}}});var M,N=function(){return M===undefined&&(M=document.createElement("p").style.MozTransform!==undefined),M};a.magnificPopup.registerModule("zoom",{options:{enabled:!1,easing:"ease-in-out",duration:300,opener:function(a){return a.is("img")?a:a.find("img")}},proto:{initZoom:function(){var a=n.st.zoom,d=".zoom",e;if(!a.enabled||!n.supportsTransition)return;var f=a.duration,g=function(b){var c=b.clone().removeAttr("style").removeAttr("class").addClass("mfp-animated-image"),d="all "+a.duration/1e3+"s "+a.easing,e={position:"fixed",zIndex:9999,left:0,top:0,"-webkit-backface-visibility":"hidden"},f="transition";return e["-webkit-"+f]=e["-moz-"+f]=e["-o-"+f]=e[f]=d,c.css(e),c},h=function(){n.content.css("visibility","visible")},i,j;x("BuildControls"+d,function(){if(n._allowZoom()){clearTimeout(i),n.content.css("visibility","hidden"),e=n._getItemToZoom();if(!e){h();return}j=g(e),j.css(n._getOffset()),n.wrap.append(j),i=setTimeout(function(){j.css(n._getOffset(!0)),i=setTimeout(function(){h(),setTimeout(function(){j.remove(),e=j=null,z("ZoomAnimationEnded")},16)},f)},16)}}),x(c+d,function(){if(n._allowZoom()){clearTimeout(i),n.st.removalDelay=f;if(!e){e=n._getItemToZoom();if(!e)return;j=g(e)}j.css(n._getOffset(!0)),n.wrap.append(j),n.content.css("visibility","hidden"),setTimeout(function(){j.css(n._getOffset())},16)}}),x(b+d,function(){n._allowZoom()&&(h(),j&&j.remove(),e=null)})},_allowZoom:function(){return n.currItem.type==="image"},_getItemToZoom:function(){return n.currItem.hasSize?n.currItem.img:!1},_getOffset:function(b){var c;b?c=n.currItem.img:c=n.st.zoom.opener(n.currItem.el||n.currItem);var d=c.offset(),e=parseInt(c.css("padding-top"),10),f=parseInt(c.css("padding-bottom"),10);d.top-=a(window).scrollTop()-e;var g={width:c.width(),height:(p?c.innerHeight():c[0].offsetHeight)-f-e};return N()?g["-moz-transform"]=g.transform="translate("+d.left+"px,"+d.top+"px)":(g.left=d.left,g.top=d.top),g}}}),B()})(window.jQuery||window.Zepto);jQuery(document).ready(function(){
	
	otw_set_full_bar_height();
	
	otw_set_scrolling_content();
	
	otw_init_status_classes();
	
	otw_overlay_with_admin_bar();
	
	// Switch stickies
	jQuery('.otw-hide-label').click(function(){
	
		
		if( jQuery(this).parent().hasClass( 'otw-bottom-sticky' ) && jQuery(this).parent().hasClass( 'scrolling-position' ) ){
			var node = jQuery( this );
			
			node.parent().find( '.otw-show-label' ).hide();
			
			setTimeout( function(){
				node.parent().css( 'top', 'auto' );
				node.parent().css( 'position', 'fixed' );
				node.parent().find( '.otw-show-label' ).show();
				
				
			}, 1000 );
		}
		if( jQuery(this).parent().hasClass( 'otw-right-sticky' ) && jQuery(this).parent().hasClass( 'scrolling-position' ) ){
			var node = jQuery( this );
			node.parent().find( '.otw-show-label' ).hide();
			
			setTimeout( function(){
				node.parent().css( 'top', node.parent()[0].initial_top );
				/*node.parent().css( 'position', 'fixed' );*/
				node.parent().find( '.otw-show-label' ).show();
				node.parent().addClass( 'otw-right-sticky-closed' );
			}, 1000 );
		}
		jQuery(this).parent().toggleClass("otw-hide-sticky");
		jQuery(this).parent().toggleClass("otw-show-sticky");
		
		
		if( jQuery(this).parent().hasClass( 'otw-first-show-sticky') ){
			jQuery(this).parent().removeClass( 'otw-first-show-sticky');
		}
	});
	jQuery('.otw-show-label').click(function(){
		
		if( jQuery(this).parent().hasClass( 'otw-bottom-sticky' ) && jQuery(this).parent().hasClass( 'scrolling-position' ) ){
		
			var node = jQuery( this );
			
			node.parent().find( '.otw-show-label' ).slideDown({
				duration: 1000,
				easing: "easeInQuad",
				complete: function(){
					
				}
			});
			setTimeout( function(){
				node.parent().find( '.otw-show-label' ).hide();
				node.parent().css( 'top', jQuery(document).scrollTop() + jQuery( window ).height() - node.parent().height() );
				node.parent().css( 'position', 'absolute' );
				
			
			}, 1000 );
		}
		if( jQuery(this).parent().hasClass( 'otw-right-sticky' ) && jQuery(this).parent().hasClass( 'scrolling-position' ) ){
			
			var node = jQuery( this );
			
			node.parent().removeClass( 'otw-right-sticky-closed' );
			
			if( typeof( node.parent()[0].initial_top ) == 'undefined' ){
				node.parent()[0].initial_top = node.parent().position().top;
			}
			
			node.parent().css( 'top', node.parent().position().top );
			node.parent().css( 'position', 'absolute' );
			
			setTimeout( function(){
				node.parent().css( 'top', node.parent().position().top );
				node.parent().css( 'position', 'absolute' );
			
			}, 1000 );
			
		}
		
		jQuery(this).parent().toggleClass("otw-hide-sticky");
		jQuery(this).parent().toggleClass("otw-show-sticky");
	});
	 
	//open events
	if( jQuery( '.otw-first-show-sticky' ).size() ){
	
		jQuery( '.otw-first-show-sticky' ).each( function(){
			
			var node = jQuery( this );
			
			if( node.parents( '.otw-show-sticky-delay' ).size() ){
				
				setTimeout( function(){ 
					
					node.parents( '.otw-show-sticky-delay' ).removeClass( 'otw-show-sticky-delay' );
					node.find( '.otw-show-label' ).click();
					node.find( '.otw-hide-label' ).click( function(){
						jQuery( this ).parents( '.otw-first-show-sticky' ).first().removeClass( 'otw-first-show-sticky' );
					} );
				}, node.parents( '.otw-show-sticky-delay' ).attr( 'data-param' ) );
				
			}else if( node.parents( '.otw-show-sticky-loads' ).size() ){
				
				var parent_node = node.parents( '.otw-show-sticky-loads' ).first();
				
				jQuery.ajax({
					
					type: 'post',
					data: { 
						otw_overlay_action: 'otw-overlay-tracking',
						method: 'open_loads',
						overlay_id: parent_node.find( '.otw-sticky' ).attr( 'id' )
					},
					success: function( response ){
					
						if( response == 'open' ){
							node.find( '.otw-show-label' ).click();
							parent_node.removeClass( 'otw-show-sticky-loads' );
						}
					}
				});
			}else if( node.hasClass( 'otw-show-sticky-mouse' ) ){
				
				node.find( '.otw-hide-label' ).click( function(){
					jQuery( this ).parents( '.otw-first-show-sticky' ).first().removeClass( 'otw-first-show-sticky' );
					jQuery( this ).parents( '.otw-show-sticky-mouse' ).first().removeClass( 'otw-show-sticky-mouse' );
				} );
			}else if( node.hasClass( 'otw-show-sticky-link' ) ){
				node.find( '.otw-hide-label' ).click( function(){
					jQuery( this ).parents( '.otw-first-show-sticky' ).first().removeClass( 'otw-first-show-sticky' );
					jQuery( this ).parents( '.otw-show-sticky-link' ).first().removeClass( 'otw-show-sticky-link' );
				} );
			}else{
				node.find( '.otw-show-label' ).click();
				node.find( '.otw-hide-label' ).click( function(){
					jQuery( this ).parents( '.otw-first-show-sticky' ).first().removeClass( 'otw-first-show-sticky' );
				} );
			}
		} );
	}
	
	if( jQuery( '.otw-show-sticky-mouse' ).size() || jQuery( '.lh-otw-show-sticky-mouse' ).size() ){
		
		jQuery( document ).mouseout( function( e ){
			
			if( e.relatedTarget == null ){
				
				jQuery( '.otw-show-sticky-mouse' ).each( function(){
					
					if( !jQuery( this ).hasClass( 'otw-show-sticky') ){
						
						var node = jQuery( this );
						
						if( node.hasClass( 'otw-first-show-sticky' ) ){
							node.find( '.otw-show-label' ).click();
						}else{
							node.removeClass( 'otw-show-sticky-mouse' );
						}
						
						jQuery.ajax({
						
							type: 'post',
							data: { 
								otw_overlay_action: 'otw-overlay-tracking',
								method: 'open_mouse',
								overlay_id: jQuery( this ).attr( 'id' )
							}
						});
					};
				});
				
				jQuery( '.lh-otw-show-sticky-mouse' ).each( function(){
					
					if( jQuery( this ).hasClass( 'mfp-hide') ){
						
						otwOpenMagnificPopup( jQuery( this ) );
						
						jQuery.ajax({
						
							type: 'post',
							data: { 
								otw_overlay_action: 'otw-overlay-tracking',
								method: 'open_mouse',
								overlay_id: jQuery( this ).attr( 'id' )
							}
						});
						jQuery( this ).removeClass( 'lh-otw-show-sticky-mouse' );
						
					};
				});
			};
		} );
	};
	
	//close forever events
	if( jQuery( '.otw-close-forever' ).size() ){
	
		jQuery( '.otw-close-forever' ).each( function(){
		
			var node = jQuery( this );
			if( jQuery( this ).find( '.otw-hide-label' ).size() ){
				
				jQuery( this ).find( '.otw-hide-label' ).click( function(){
					
					node.find( '.otw-show-label' ).hide();
					
					jQuery.ajax({
							
						type: 'post',
						data: { 
							otw_overlay_action: 'otw-overlay-tracking',
							method: 'close_forever',
							overlay_id: node.attr( 'id' )
						}
					});
				} );
			};
		} );
	};
	
	//close for number of page loads
	if( jQuery( '.otw-close-loads' ).size() ){
	
		jQuery( '.otw-close-loads' ).each( function(){
		
			var node = jQuery( this );
			jQuery( this ).find( '.otw-hide-label' ).click( function(){
				
				node.find( '.otw-show-label' ).hide();
				
				jQuery.ajax({
						
					type: 'post',
					data: { 
						otw_overlay_action: 'otw-overlay-tracking',
						method: 'close_loads',
						overlay_id: node.attr( 'id' )
					}
				});
			} );
		} );
	};
	
	//close for number of days
	if( jQuery( '.otw-close-days' ).size() ){
	
		jQuery( '.otw-close-days' ).each( function(){
		
			var node = jQuery( this );
			jQuery( this ).find( '.otw-hide-label' ).click( function(){
				
				node.find( '.otw-show-label' ).hide();
				
				jQuery.ajax({
						
					type: 'post',
					data: { 
						otw_overlay_action: 'otw-overlay-tracking',
						method: 'close_days',
						overlay_id: node.attr( 'id' )
					}
				});
			} );
		} );
	};
	
	//decriment page loads session
	if( jQuery( '.otcl_track' ).size() ){
	
		jQuery( '.otcl_track' ).each( function(){
		
			var matches = false;
			
			if( matches = this.id.match( /^(ovcl|ovcf)_otw\-(.*)$/ ) ){
			
				var track_method = '';
				
				switch( matches[1] ){
					case 'ovcl':
							track_method = 'close_loaded';
						break;
					case 'ovcf':
							track_method = 'close_forever';
						break;
				}
				
				jQuery.ajax({
						
					type: 'post',
					data: { 
						otw_overlay_action: 'otw-overlay-tracking',
						method: track_method,
						overlay_id: 'otw-' + matches[2]
					}
				});
			}
		} );
	}
	
	//close until page reload
	if( jQuery( '.otw-close-page' ).size() ){
	
		jQuery( '.otw-close-page' ).each( function(){
		
			var node = jQuery( this );
			jQuery( this ).find( '.otw-hide-label' ).click( function(){
				
				node.find( '.otw-show-label' ).hide();
				
			} );
		} );
	};
	
	//open after click on link
	if( jQuery( '.otw-open-overlay' ).size() ){
	
		jQuery( '.otw-open-overlay' ).click( function(){
			
			var ov_id = jQuery( this ).attr( 'href' );
			
			var overlay = jQuery( ov_id );
			
			if( overlay.size() ){
				
				if( overlay.hasClass( 'otw-first-show-sticky' ) ){
					overlay.addClass( 'otw-link-opened' );
					overlay.find( '.otw-show-label' ).click();
				}else if( overlay.hasClass( 'otw-link-opened' ) ){
					overlay.find( '.otw-show-label' ).click();
				}else{
					overlay.addClass( 'otw-link-opened' );
					overlay.removeClass( 'otw-show-sticky-link' );
				}
			};
		} );
	}
	
	//open after page loads
	if( jQuery( '.otw-show-sticky-loads' ).size() ){
	
		jQuery( '.otw-show-sticky-loads' ).each( function(){
		
			var node = jQuery( this );
			
			if( node.find( '.otw-first-show-sticky' ).size() > 0 ){
				return;
			}
			
			jQuery.ajax({
				
				type: 'post',
				data: { 
					otw_overlay_action: 'otw-overlay-tracking',
					method: 'open_loads',
					overlay_id: node.find( '.otw-sticky' ).attr( 'id' )
				},
				success: function( response ){
				
					if( response == 'open' ){
						node.removeClass( 'otw-show-sticky-loads' );
					}
				}
			});
		} );
	};
	
	//open after page delay
	if( jQuery( '.otw-show-sticky-delay' ).size() ){
	
		jQuery( '.otw-show-sticky-delay' ).each( function(){
			
			var node = jQuery( this );
			setTimeout( function(){ node.removeClass( 'otw-show-sticky-delay' ); }, node.attr( 'data-param' ) );
		} );
	};
	
	//open light boxes
	if( jQuery( '.lh-otw-show-sticky-load' ).size() ){
	
		jQuery( '.lh-otw-show-sticky-load' ).each( function(){
			
			var node = jQuery( this );
			otwOpenMagnificPopup( node )
			
		} );
	};
	
	//lilght open after page delay
	if( jQuery( '.lh-otw-show-sticky-delay' ).size() ){
	
		jQuery( '.lh-otw-show-sticky-delay' ).each( function(){
			
			var node = jQuery( this );
			
			setTimeout( function(){ 
				node.removeClass( 'lh-otw-show-sticky-delay' );
				otwOpenMagnificPopup( node );
			}, node.attr( 'data-param' ) );
		} );
	};
	
	//open light box after page loads
	if( jQuery( '.lh-otw-show-sticky-loads' ).size() ){
	
		jQuery( '.lh-otw-show-sticky-loads' ).each( function(){
		
			var node = jQuery( this );
			jQuery.ajax({
				
				type: 'post',
				data: { 
					otw_overlay_action: 'otw-overlay-tracking',
					method: 'open_loads',
					overlay_id: node.attr( 'id' )
				},
				success: function( response ){
				
					if( response == 'open' ){
						otwOpenMagnificPopup( node );
					}
				}
			});
		} );
	};
	
	
	
	//open from links
	// Inline popups
	jQuery('.otw-display-overlay').click( function(){
		
		var ov_id = jQuery( this ).attr( 'href' ).replace( /^#/, '' );
		
		if( jQuery( '#' + ov_id ).size() == 0 ){
			
			jQuery.ajax({
				
				type: 'post',
				data: '&otwcalloverlay=' + ov_id,
				
				success: function( response ){
					
					jQuery( 'body' ).append( response );
					
					jQuery( '#' + ov_id ).find('.otw-hide-label').click(function(){
						jQuery(this).parent().toggleClass("otw-hide-sticky");
						jQuery(this).parent().toggleClass("otw-show-sticky");
					});
					jQuery( '#' + ov_id ).find('.otw-show-label').click(function(){
						jQuery(this).parent().toggleClass("otw-hide-sticky");
						jQuery(this).parent().toggleClass("otw-show-sticky");
					});
					
					otw_overlay_with_admin_bar();
					
					setTimeout( function(){
						jQuery( '#' + ov_id ).find('.otw-show-label').click();
					}, 100 );
				}
			});
		}else{
			jQuery( '#' + ov_id ).find( '.otw-show-label' ).click();
		}
	});
	
	jQuery('.otw-display-popup-link').each( function(){
	
		var ov_id = jQuery( this ).attr( 'href' ).replace( /^#/, '' );
		
		var effects = jQuery( this ).attr( 'data-effect' );
		
		if( jQuery( '#' + ov_id ).size() ){
			jQuery( this ).magnificPopup({
				callbacks: {
					beforeOpen: function() {
						this.st.mainClass = this.st.el.attr('data-effect');
					},
					open: function(){
						if( this.content.hasClass( 'hide-overlay-for-small' ) ){
							this.bgOverlay.addClass( 'hide-overlay-for-small' );
							this.container.addClass( 'hide-overlay-for-small' );
							this.container.parents('.mfp-wrap').addClass( 'hide-overlay-for-small' );
						}
					},
					close: function(){
						otwCloseMagnificPopup( this.content );
					}
				},
				removalDelay: 500, //delay removal by X to allow out-animation
				midClick: true
			});
		}else{
			jQuery( this ).magnificPopup({
				type: 'ajax',
				ajax: {
					settings: {
						method: 'post',
						data: '&otwcalloverlay=' + ov_id
					}
				},
				callbacks: {
					ajaxContentAdded: function(){
						
						if( jQuery( this.content[2] ).hasClass( 'hide-overlay-for-small' ) ){
							this.bgOverlay.addClass( 'hide-overlay-for-small' );
							this.container.addClass( 'hide-overlay-for-small' );
							this.container.parents('.mfp-wrap').addClass( 'hide-overlay-for-small' );
						}
					},
					close: function(){
						otwCloseMagnificPopup( jQuery( this.content[2] ) );
					}
				},
				mainClass: effects,
				removalDelay: 500, //delay removal by X to allow out-animation
				midClick: true
			});
		};
	} );
	
	jQuery('.otw-display-hinge').each( function(){
	
		var ov_id = jQuery( this ).attr( 'href' ).replace( /^#/, '' );
		
		var effects = 'mfp-with-fade';
		
		if( jQuery( this ).attr( 'data-effect' ).length ){
			effects = effects + ' '+ jQuery( this ).attr( 'data-effect' );
		}
		
		if( jQuery( '#' + ov_id ).size() ){
			jQuery( this ).magnificPopup({
				mainClass: 'mfp-with-fade',
				callbacks: {
					beforeOpen: function() {
						this.st.mainClass = this.st.el.attr('data-effect');
					},
					beforeClose: function() {
						this.content.addClass('hinge');
					},
					close: function() {
						this.content.removeClass('hinge');
						otwCloseMagnificPopup( this.content );
					},
					open: function(){
						if( this.content.hasClass( 'hide-overlay-for-small' ) ){
							this.bgOverlay.addClass( 'hide-overlay-for-small' );
							this.container.addClass( 'hide-overlay-for-small' );
							this.container.parents('.mfp-wrap').addClass( 'hide-overlay-for-small' );
						}
					}
				},
				removalDelay: 1000, //delay removal by X to allow out-animation
				midClick: true
			});
		}else{
			jQuery( this ).magnificPopup({
				type: 'ajax',
				ajax: {
					settings: {
						method: 'post',
						data: '&otwcalloverlay=' + ov_id
					}
				},
				mainClass: effects,
				removalDelay: 1000, //delay removal by X to allow out-animation
				callbacks: {
					ajaxContentAdded: function(){
						
						if( jQuery( this.content[2] ).hasClass( 'hide-overlay-for-small' ) ){
							this.bgOverlay.addClass( 'hide-overlay-for-small' );
							this.container.addClass( 'hide-overlay-for-small' );
							this.container.parents('.mfp-wrap').addClass( 'hide-overlay-for-small' );
						}
					},
					beforeClose: function() {
						this.content.addClass('hinge');
					},
					close: function() {
						this.content.removeClass('hinge');
						otwCloseMagnificPopup( jQuery( this.content[2] ) );
					}
				},
				midClick: true
			});
		}
	} );
	
	
	
	
	
} );

otw_set_scrolling_content = function(){

	jQuery( '.otw-small-csr.fixed-position' ).each( function(){
	
		
		var section = jQuery( this ).find( '.otw-sticky-content' );
		
		var section_height = jQuery( this ).outerHeight();
		var section_position = jQuery( this ).position();
		
		var window_height = jQuery( window ).height();
		
		var end_point = Number( section_position.top ) + Number( section_height );
		
		if( end_point > window_height ){
			
			section.css( 'height', ( section.height() - ( end_point - window_height ) - 20 ) + 'px' );
			
			section.css( 'overflow', 'auto' );
		}
	});
}


otw_set_full_bar_height = function(){
	
	jQuery( '.otw-full-bar' ).each( function(){
	
		var node = jQuery( this );
		
		if( node.hasClass( 'otw-left-sticky' ) ||  node.hasClass( 'otw-right-sticky' ) ){
			
			var new_height = jQuery( 'body' ).height();
			
			node.css( 'height', new_height + 'px' );
		};
	});
};

otw_overlay_with_admin_bar = function(){

	var admin_bar = jQuery( '#wpadminbar' );
	
	if( admin_bar.size() ){
		
		jQuery( '.otw-sticky.otw-top-sticky, .otw-sticky.otw-left-sticky, .otw-sticky.otw-right-sticky ' ).each( function(){
			
		//	if( jQuery( 'body' ).css( 'position') != 'relative' ){
				if( typeof( this.wpadminbar_fixed ) == 'undefined' ){
					jQuery( this ).css( 'top',  jQuery( this ).position().top + admin_bar.height() );
					
					this.wpadminbar_fixed = 1;
				}
		//	}
		} )
	
	}
}

otwCloseMagnificPopup = function( popup ){
	
	if( popup.hasClass( 'otw-close-forever' ) ){
		
		jQuery.ajax({
			type: 'post',
			data: { 
				otw_overlay_action: 'otw-overlay-tracking',
				method: 'close_forever',
				overlay_id: popup.attr( 'id' )
			}
		});
	}else if( popup.hasClass( 'otw-close-loads' ) ){
		
		jQuery.ajax({
			type: 'post',
			    data: {
				otw_overlay_action: 'otw-overlay-tracking',
				method: 'close_loads',
				overlay_id: popup.attr( 'id' )
			}
		});
	}else if( popup.hasClass( 'otw-close-days') ){
		
		jQuery.ajax({
			type: 'post',
			data: {
				otw_overlay_action: 'otw-overlay-tracking',
				method: 'close_days',
				overlay_id: popup.attr( 'id' )
			}
		});
	}
}

otwOpenMagnificPopup = function( node ){
	
	var is_hinge = false;
	var close_delay = 500;
	var main_class = '';
	
	if( node.attr( 'data-ceffect' ) && ( node.attr( 'data-ceffect' ) == 'hinge' ) ){
		is_hinge = true;
	}
	
	var ppCallbacks = {
		beforeOpen: function() {
			this.st.mainClass = node.attr('data-effect'); 
		},
		open: function(){
		
			otw_init_magnificPopup( this );
		},
		close: function(){
			otwCloseMagnificPopup( this.content );
		}
	};
	
	if( is_hinge ){
		
		ppCallbacks.beforeClose = function() {
			this.content.addClass('hinge');
		}
		ppCallbacks.close = function() {
			this.content.removeClass('hinge');
			otwCloseMagnificPopup( this.content );
		}
		close_delay = 1000;
		main_class = 'mfp-with-fade';
	};
	
	jQuery.magnificPopup.open({
		mainClass: main_class,
		removalDelay: close_delay,
		items: {
			src: node,
			type: 'inline'
		},
		callbacks: ppCallbacks,
		midClick: true
	});
}

otw_init_magnificPopup = function( popupObject ){
	
	if( popupObject.content.attr( 'data-index' ) && Number( popupObject.content.attr( 'data-index' ) ) > 0 ){
		
		popupObject.bgOverlay.zIndex( Number( popupObject.content.attr( 'data-index' ) ) );
		popupObject.container.parents( '.mfp-wrap' ).zIndex( Number( popupObject.content.attr( 'data-index' ) ) + 1 );
	}
	if( popupObject.content.hasClass( 'otw-close-forever' ) ){
	
		if( popupObject.content.find( '.mfp-close' ).size() ){
		
			popupObject.content.find( '.mfp-close' ).click( function(){
				jQuery.ajax({
					type: 'post',
					data: { 
						otw_overlay_action: 'otw-overlay-tracking',
						method: 'close_forever',
						overlay_id: popupObject.content.attr( 'id' )
					}
				});
			});
		}
	}else if( popupObject.content.hasClass( 'otw-close-loads' ) ){
		
		if( popupObject.content.find( '.mfp-close' ).size() ){
		
			popupObject.content.find( '.mfp-close' ).click( function(){
				jQuery.ajax({
					type: 'post',
					data: { 
						otw_overlay_action: 'otw-overlay-tracking',
						method: 'close_loads',
						overlay_id: popupObject.content.attr( 'id' )
					}
				});
			});
		}
	}else if( popupObject.content.hasClass( 'otw-close-days' ) ){
		
		if( popupObject.content.find( '.mfp-close' ).size() ){
		
			popupObject.content.find( '.mfp-close' ).click( function(){
				jQuery.ajax({
					type: 'post',
					data: { 
						otw_overlay_action: 'otw-overlay-tracking',
						method: 'close_days',
						overlay_id: popupObject.content.attr( 'id' )
					}
				});
			});
		}
	}
	if( popupObject.content.hasClass( 'hide-overlay-for-small' ) ){
		popupObject.bgOverlay.addClass( 'hide-overlay-for-small' );
		popupObject.container.addClass( 'hide-overlay-for-small' );
		popupObject.container.parents('.mfp-wrap').addClass( 'hide-overlay-for-small' );
	}
	
	if( popupObject.content.attr( 'data-style' ) && popupObject.content.attr( 'data-style' ).length ){
		popupObject.bgOverlay.css( 'cssText', popupObject.content.attr( 'data-style' ) );
	}
}

otw_init_status_classes = function(){
	
	jQuery( '.otw-right-sticky.scrolling-position.otw-hide-sticky' ).each( function(){
		
		if( !jQuery( this ).hasClass( 'otw-right-sticky-closed' ) ){
			jQuery( this ).addClass( 'otw-right-sticky-closed' );
		}
	});
};