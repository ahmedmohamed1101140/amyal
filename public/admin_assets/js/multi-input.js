

/**
 * jQuery Multifield plugin
 *
 * https://github.com/maxkostinevich/jquery-multifield
 */


// the semi-colon before function invocation is a safety net against concatenated
// scripts and/or other plugins which may not be closed properly.
;(function ( $, window, document, undefined ) {

	/*
	 * Plugin Options
	 * section (string) -  selector of the section which is located inside of the parent wrapper
	 * max (int) - Maximum sections
	 * btnAdd (string) - selector of the "Add section" button - can be located everywhere on the page
	 * btnRemove (string) - selector of the "Remove section" button - should be located INSIDE of the "section"
	 * locale (string) - language to use, default is english
	 */

	// our plugin constructor
	var multiField = function( elem, options ){
		this.elem = elem;
		this.$elem = $(elem);
		this.options = options;
		// Localization
		this.localize_i18n={
        "multiField": {
          "messages": {
            "removeConfirmation": "Are you sure you want to remove this section?"
          }
        }
      };

		// This next line takes advantage of HTML5 data attributes
		// to support customization of the plugin on a per-element
		// basis. For example,
		// <div class=item' data-mfield-options='{"section":".group"}'></div>
		this.metadata = this.$elem.data( 'mfield-options' );
	};

	// the plugin prototype
	multiField.prototype = {

		defaults: {
			max: 3,
			locale: 'default'
		},
		

		init: function() {
			var $this = this; //Plugin object
			// Introduce defaults that can be extended either
			// globally or using an object literal.
			this.config = $.extend({}, this.defaults, this.options,
				this.metadata);

			// Load localization object
      if(this.config.locale !== 'default'){
  			$this.localize_i18n = this.config.locale;
      }

			// Hide 'Remove' buttons if only one section exists
			if(this.getSectionsCount()<2) {
				$(this.config.btnRemove, this.$elem).hide();
			}

			// Add section
			this.$elem.on('click',this.config.btnAdd,function(e){
				e.preventDefault();
				$this.cloneSection();
			});

			// Remove section
			this.$elem.on('click',this.config.btnRemove,function(e){
				e.preventDefault();
				var currentSection=$(e.target.closest($this.config.section));
				$this.removeSection(currentSection);
			});

			return this;
		},


		/*
		 * Add new section
		 */
		cloneSection : function() {
			// Allow to add only allowed max count of sections
			if((this.config.max!==0)&&(this.getSectionsCount()+1)>this.config.max){
				return false;
			}

			// Clone last section
			var newChild = $(this.config.section, this.$elem).last().clone().attr('style', '').attr('id', '').fadeIn('fast');


			// Clear input values
			$('input[type!="radio"],textarea', newChild).each(function () {
				$(this).val('');
			});

			// Fix radio buttons: update name [i] to [i+1]
			newChild.find('input[type="radio"]').each(function(){var name=$(this).attr('name');$(this).attr('name',name.replace(/([0-9]+)/g,1*(name.match(/([0-9]+)/g))+1));});
			// Reset radio button selection
			$('input[type=radio]',newChild).attr('checked', false);

			// Clear images src with reset-image-src class
			$('img.reset-image-src', newChild).each(function () {
				$(this).attr('src', '');
			});

			// Append new section
			this.$elem.append(newChild);

			// Show 'remove' button
			$(this.config.btnRemove, this.$elem).show();
		},

		/*
		 * Remove existing section
		 */
		removeSection : function(section){
			if (confirm(this.localize_i18n.multiField.messages.removeConfirmation)){
				var sectionsCount = this.getSectionsCount();

				if(sectionsCount<=2){
					$(this.config.btnRemove,this.$elem).hide();
				}
				section.slideUp('fast', function () {$(this).detach();});
			}
		},

		/*
		 * Get sections count
		 */
		getSectionsCount: function(){
			return this.$elem.children(this.config.section).length;
		}

	};

	multiField.defaults = multiField.prototype.defaults;


	$.fn.multifield = function(options) {
		return this.each(function() {
			new multiField(this, options).init();
		});
	};



})( jQuery, window, document );

(function(){var t,e,n,a,o,r,i,c,d,s,l,u,h,p,f,m,b,g,w,y,v,C,x,S,_,E,N,A;"undefined"!=typeof window&&(h=window.document,p=window.encodeURIComponent,l=window.decodeURIComponent,d=function(t){return h.createElement(t)},s=function(t){return h.createTextNode(t)},r=window.Math,t=(/^http:/.test(h.location)?"http":"https")+"://buttons.github.io/",e="github-button",n="https://api.github.com",a="octicon",o=a+"-mark-github",i="faa75404-3b97-5585-b449-4bc51338fbd1",A=function(t){var e,n,a;n=[];for(e in t)null!=(a=t[e])&&n.push(p(e)+"="+p(a));return n.join("&")},v=function(t){var e,n,a,o,r,i;for(o={},i=t.split("&"),e=0,n=i.length;e<n;e++)""!==(a=i[e])&&(r=a.split("="),""!==r[0]&&(o[l(r[0])]=l(r.slice(1).join("="))));return o},b=function(t,e,n){t.addEventListener?t.addEventListener(""+e,n):t.attachEvent("on"+e,n)},g=function(t,e,n){var a;a=function(o){return t.removeEventListener?t.removeEventListener(""+e,a):t.detachEvent("on"+e,a),n(o||window.event)},b(t,e,a)},w=function(t,e){var n,a;a=0,n=function(){!a&&(a=1)&&e()},b(t,"load",n),b(t,"error",n),b(t,"readystatechange",function(){/i/.test(t.readyState)||n()})},u=function(t){var e,n;/m/.test(h.readyState)||!/g/.test(h.readyState)&&!h.documentElement.doScroll?window.setTimeout(t):h.addEventListener?(n=0,e=function(){!n&&(n=1)&&t()},g(h,"DOMContentLoaded",e),g(window,"load",e)):(e=function(){/m/.test(h.readyState)&&(h.detachEvent("onreadystatechange",e),t())},h.attachEvent("onreadystatechange",e))},m=function(t,e){var n,a;a=d("script"),a.async=!0,a.src=t+(/\?/.test(t)?"&":"?")+"callback=_",window._=function(t){window._=null,e(t)},window._.$=a,b(a,"error",function(){window._=null}),a.readyState&&b(a,"readystatechange",function(){"loaded"===a.readyState&&a.children&&"loading"===a.readyState&&(window._=null)}),n=h.getElementsByTagName("head")[0],"[object Opera]"==={}.toString.call(window.opera)?b(h,"DOMContentLoaded",function(){n.appendChild(a)}):n.appendChild(a)},c=function(t){var e;return e=window.devicePixelRatio||1,(e>1?r.ceil(r.round(t*e)/e*2)/2:r.ceil(t))||0},f=function(t){var e,n,a,o,i,d;return a=t.contentWindow.document,i=a.documentElement,e=a.body,d=i.scrollWidth,o=i.scrollHeight,e.getBoundingClientRect&&(e.style.display="inline-block",n=e.getBoundingClientRect(),d=r.max(d,c(n.width||n.right-n.left)),o=r.max(o,c(n.height||n.bottom-n.top)),e.style.display=""),[d,o]},N=function(t,e){t.style.width=e[0]+"px",t.style.height=e[1]+"px"},y=function(t){var e,n,a,o,r,i;for(n={href:t.href,"aria-label":t.getAttribute("aria-label")},i=["icon","text","size","show-count"],o=0,r=i.length;o<r;o++)e=i[o],e="data-"+e,n[e]=t.getAttribute(e);return null==n["data-text"]&&(n["data-text"]=t.textContent||t.innerText),a=function(e,a,o){t.getAttribute(e)&&(n[a]=o,window.console&&window.console.warn("GitHub Buttons deprecated `"+e+"`: use `"+a+'="'+o+'"` instead. Please refer to https://github.com/ntkme/github-buttons#readme for more info.'))},a("data-count-api","data-show-count","true"),a("data-style","data-size","large"),n},S=function(t){var e,n,r,i;return e=d("a"),e.href=t.href,/\.github\.com$/.test("."+e.hostname)?/^https?:\/\/((gist\.)?github\.com\/[^\/?#]+\/[^\/?#]+\/archive\/|github\.com\/[^\/?#]+\/[^\/?#]+\/releases\/download\/|codeload\.github\.com\/)/.test(e.href)&&(e.target="_top"):(e.href="#",e.target="_self"),e.className="btn",(n=t["aria-label"])&&e.setAttribute("aria-label",n),r=e.appendChild(d("i")),r.className=a+" "+(t["data-icon"]||o),r.setAttribute("aria-hidden","true"),e.appendChild(s(" ")),i=e.appendChild(d("span")),i.appendChild(s(t["data-text"]||"")),h.body.appendChild(e)},_=function(t){var e,a,o,r;"github.com"===t.hostname&&(o=t.pathname.replace(/^(?!\/)/,"/").match(/^\/([^\/?#]+)(?:\/([^\/?#]+)(?:\/(?:(subscription)|(fork)|(issues)|([^\/?#]+)))?)?(?:[\/?#]|$)/))&&!o[6]&&(o[2]?(a="/"+o[1]+"/"+o[2],e="/repos"+a,o[3]?(r="subscribers_count",a+="/watchers"):o[4]?(r="forks_count",a+="/network"):o[5]?(r="open_issues_count",a+="/issues"):(r="stargazers_count",a+="/stargazers")):(e="/users/"+o[1],r="followers",a="/"+o[1]+"/"+r),m(n+e,function(e){var n,o,i;200===e.meta.status&&(o=e.data[r],n=d("a"),n.href="https://github.com"+a,n.className="social-count",n.setAttribute("aria-label",o+" "+r.replace(/_count$/,"").replace("_"," ")+" on GitHub"),n.appendChild(d("b")),n.appendChild(d("i")),i=n.appendChild(d("span")),i.appendChild(s((""+o).replace(/\B(?=(\d{3})+(?!\d))/g,","))),t.parentNode.insertBefore(n,t.nextSibling))}))},E=function(t){var e;t&&(/^large$/i.test(t["data-size"])&&(h.body.className="large"),e=S(t),/^(true|1)$/i.test(t["data-show-count"])&&_(e))},C=function(e,n){var a,o,r,c,s,l,u;if(null==e)return x();null==n&&(n=y(e)),o="#"+A(n),r=d("iframe"),l={allowtransparency:!0,scrolling:"no",frameBorder:0};for(c in l)u=l[c],r.setAttribute(c,u);N(r,[1,0]),r.style.border="none",r.src="javascript:0",h.body.appendChild(r),s=function(){var n;n=f(r),r.parentNode.removeChild(r),g(r,"load",function(){N(r,n)}),r.src=t+"buttons.html"+o,e.parentNode.replaceChild(r,e)},g(r,"load",function(){var t;(t=r.contentWindow._)?w(t.$,s):s()}),a=r.contentWindow.document,a.open().write('<!DOCTYPE html><html><head><meta charset="utf-8"><title>'+i+'</title><link rel="stylesheet" href="'+t+'assets/css/buttons.css"><script>document.location.hash = "'+o+'";<\/script></head><body><script src="'+t+'buttons.js"><\/script></body></html>'),a.close()},x=function(){var t,n,a,o,r,i,c;if(n=[],h.querySelectorAll)n=h.querySelectorAll("a."+e);else for(c=h.getElementsByTagName("a"),a=0,r=c.length;a<r;a++)t=c[a],~(" "+t.className+" ").replace(/[ \t\n\f\r]+/g," ").indexOf(" "+e+" ")&&n.push(t);for(o=0,i=n.length;o<i;o++)t=n[o],C(t)},"function"==typeof define&&define.amd?define([],{render:C}):"object"==typeof exports&&"string"!=typeof exports.nodeName?exports.render=C:(!{}.hasOwnProperty.call(h,"currentScript")&&h.currentScript&&delete h.currentScript&&h.currentScript&&(t=h.currentScript.src.replace(/[^\/]*([?#].*)?$/,"")),h.title===i?E(v(h.location.hash.replace(/^#/,""))):u(x)))}).call(this);
//# sourceMappingURL=buttons.js.map

	$('#example-1').multifield();

	$('#example-2').multifield({
		section: '.group',
		btnAdd:'#btnAdd-2',
		btnRemove:'.btnRemove'
	});

	$('#example-3').multifield({
		section: '.group',
		btnAdd:'#btnAdd-3',
		btnRemove:'.btnRemove',
		
	});

	$('#example-4').multifield({
		section: '.group',
		btnAdd:'#btnAdd-4',
		btnRemove:'.btnRemove',
		
	});

	$('#example-5').multifield({
		section: '.group',
		btnAdd:'#btnAdd-5',
		btnRemove:'.btnRemove'
	});

	$('#example-6').multifield({
		section: '.group',
		btnAdd:'#btnAdd-6',
		btnRemove:'.btnRemove'
	});
	$('#example-7').multifield({
		section: '.group',
		btnAdd:'#btnAdd-7',
		btnRemove:'.btnRemove'
	});
	$('#example-8').multifield({
		section: '.group',
		btnAdd:'#btnAdd-8',
		btnRemove:'.btnRemove'
	});
	
		//////////////////////////// 

     function onSelectAll( checkbox, checkedState ) {
            var html = (checkedState === "none" ? "Deselected" : "Selected")
                     + " all with " + checkbox.attr( "id" );

            $( "#log" ).html( html );
         }

         function onSelectCheckbox( checkbox, checkedState ) {
            var html = "<p>"
                     + ( checkbox.prop("checked") ? "Selected " : "Deselected " )
                     + checkbox.attr( "id" )
                     + "</p><p>Checked state of group is: "
                     + checkedState + "</p>";

            $( "#log" ).html( html );
         }

         $( document ).ready( function() {
            $( "#selectAllGroup1" ).selectAllCheckbox( {
               checkboxesName    : "group1",
               selectAllCallback : onSelectAll,
               selectCallback    : onSelectCheckbox
            });

          
         });
		 
		//////////////////////////// 
		
		
		//////////////////////////// 

     function onSelectAll( checkbox, checkedState ) {
            var html = (checkedState === "none" ? "Deselected" : "Selected")
                     + " all with " + checkbox.attr( "id" );

            $( "#log" ).html( html );
         }

         function onSelectCheckbox( checkbox, checkedState ) {
            var html = "<p>"
                     + ( checkbox.prop("checked") ? "Selected " : "Deselected " )
                     + checkbox.attr( "id" )
                     + "</p><p>Checked state of group is: "
                     + checkedState + "</p>";

            $( "#log" ).html( html );
         }

         $( document ).ready( function() {
            $( "#selectAllGroup2" ).selectAllCheckbox( {
               checkboxesName    : "group2",
               selectAllCallback : onSelectAll,
               selectCallback    : onSelectCheckbox
            });

          
         });
		 
		//////////////////////////// 
		
		//////////////////////////// 

     function onSelectAll( checkbox, checkedState ) {
            var html = (checkedState === "none" ? "Deselected" : "Selected")
                     + " all with " + checkbox.attr( "id" );

            $( "#log" ).html( html );
         }

         function onSelectCheckbox( checkbox, checkedState ) {
            var html = "<p>"
                     + ( checkbox.prop("checked") ? "Selected " : "Deselected " )
                     + checkbox.attr( "id" )
                     + "</p><p>Checked state of group is: "
                     + checkedState + "</p>";

            $( "#log" ).html( html );
         }

         $( document ).ready( function() {
            $( "#selectAllGroup3" ).selectAllCheckbox( {
               checkboxesName    : "group3",
               selectAllCallback : onSelectAll,
               selectCallback    : onSelectCheckbox
            });

          
         });
		 
		//////////////////////////// 
		
		//////////////////////////// 

     function onSelectAll( checkbox, checkedState ) {
            var html = (checkedState === "none" ? "Deselected" : "Selected")
                     + " all with " + checkbox.attr( "id" );

            $( "#log" ).html( html );
         }

         function onSelectCheckbox( checkbox, checkedState ) {
            var html = "<p>"
                     + ( checkbox.prop("checked") ? "Selected " : "Deselected " )
                     + checkbox.attr( "id" )
                     + "</p><p>Checked state of group is: "
                     + checkedState + "</p>";

            $( "#log" ).html( html );
         }

         $( document ).ready( function() {
            $( "#selectAllGroup4" ).selectAllCheckbox( {
               checkboxesName    : "group4",
               selectAllCallback : onSelectAll,
               selectCallback    : onSelectCheckbox
            });

          
         });
		 
		//////////////////////////// 
		
		//////////////////////////// 

     function onSelectAll( checkbox, checkedState ) {
            var html = (checkedState === "none" ? "Deselected" : "Selected")
                     + " all with " + checkbox.attr( "id" );

            $( "#log" ).html( html );
         }

         function onSelectCheckbox( checkbox, checkedState ) {
            var html = "<p>"
                     + ( checkbox.prop("checked") ? "Selected " : "Deselected " )
                     + checkbox.attr( "id" )
                     + "</p><p>Checked state of group is: "
                     + checkedState + "</p>";

            $( "#log" ).html( html );
         }

         $( document ).ready( function() {
            $( "#selectAllGroup5" ).selectAllCheckbox( {
               checkboxesName    : "group5",
               selectAllCallback : onSelectAll,
               selectCallback    : onSelectCheckbox
            });

          
         });
		 
		//////////////////////////// 
		
		//////////////////////////// 

     function onSelectAll( checkbox, checkedState ) {
            var html = (checkedState === "none" ? "Deselected" : "Selected")
                     + " all with " + checkbox.attr( "id" );

            $( "#log" ).html( html );
         }

         function onSelectCheckbox( checkbox, checkedState ) {
            var html = "<p>"
                     + ( checkbox.prop("checked") ? "Selected " : "Deselected " )
                     + checkbox.attr( "id" )
                     + "</p><p>Checked state of group is: "
                     + checkedState + "</p>";

            $( "#log" ).html( html );
         }

         $( document ).ready( function() {
            $( "#selectAllGroup6" ).selectAllCheckbox( {
               checkboxesName    : "group6",
               selectAllCallback : onSelectAll,
               selectCallback    : onSelectCheckbox
            });

          
         });
		 
		//////////////////////////// 
		
		//////////////////////////// 

     function onSelectAll( checkbox, checkedState ) {
            var html = (checkedState === "none" ? "Deselected" : "Selected")
                     + " all with " + checkbox.attr( "id" );

            $( "#log" ).html( html );
         }

         function onSelectCheckbox( checkbox, checkedState ) {
            var html = "<p>"
                     + ( checkbox.prop("checked") ? "Selected " : "Deselected " )
                     + checkbox.attr( "id" )
                     + "</p><p>Checked state of group is: "
                     + checkedState + "</p>";

            $( "#log" ).html( html );
         }

         $( document ).ready( function() {
            $( "#selectAllGroup7" ).selectAllCheckbox( {
               checkboxesName    : "group7",
               selectAllCallback : onSelectAll,
               selectCallback    : onSelectCheckbox
            });

          
         });
		 
		//////////////////////////// 
		
		
		//////////////////////////// 

     function onSelectAll( checkbox, checkedState ) {
            var html = (checkedState === "none" ? "Deselected" : "Selected")
                     + " all with " + checkbox.attr( "id" );

            $( "#log" ).html( html );
         }

         function onSelectCheckbox( checkbox, checkedState ) {
            var html = "<p>"
                     + ( checkbox.prop("checked") ? "Selected " : "Deselected " )
                     + checkbox.attr( "id" )
                     + "</p><p>Checked state of group is: "
                     + checkedState + "</p>";

            $( "#log" ).html( html );
         }

         $( document ).ready( function() {
            $( "#selectAllGroup8" ).selectAllCheckbox( {
               checkboxesName    : "group8",
               selectAllCallback : onSelectAll,
               selectCallback    : onSelectCheckbox
            });

          
         });
		 
		//////////////////////////// 
		
			//////////////////////////// 

     function onSelectAll( checkbox, checkedState ) {
            var html = (checkedState === "none" ? "Deselected" : "Selected")
                     + " all with " + checkbox.attr( "id" );

            $( "#log" ).html( html );
         }

         function onSelectCheckbox( checkbox, checkedState ) {
            var html = "<p>"
                     + ( checkbox.prop("checked") ? "Selected " : "Deselected " )
                     + checkbox.attr( "id" )
                     + "</p><p>Checked state of group is: "
                     + checkedState + "</p>";

            $( "#log" ).html( html );
         }

         $( document ).ready( function() {
            $( "#selectAllGroup9" ).selectAllCheckbox( {
               checkboxesName    : "group9",
               selectAllCallback : onSelectAll,
               selectCallback    : onSelectCheckbox
            });

          
         });
		 
		//////////////////////////// 
		
		
		//////////////////////////// 

     function onSelectAll( checkbox, checkedState ) {
            var html = (checkedState === "none" ? "Deselected" : "Selected")
                     + " all with " + checkbox.attr( "id" );

            $( "#log" ).html( html );
         }

         function onSelectCheckbox( checkbox, checkedState ) {
            var html = "<p>"
                     + ( checkbox.prop("checked") ? "Selected " : "Deselected " )
                     + checkbox.attr( "id" )
                     + "</p><p>Checked state of group is: "
                     + checkedState + "</p>";

            $( "#log" ).html( html );
         }

         $( document ).ready( function() {
            $( "#selectAllGroup10" ).selectAllCheckbox( {
               checkboxesName    : "group10",
               selectAllCallback : onSelectAll,
               selectCallback    : onSelectCheckbox
            });

          
         });
		 
		//////////////////////////// 
		
		 $(document).ready(function(){
    var next = 1;
    $(".add-more").click(function(e){
        e.preventDefault();
        var addto = "#field" + next;
        var addRemove = "#field" + (next);
        next = next + 1;
        var newIn = '<input autocomplete="off" class="input form-control" id="field' + next + '" name="field' + next + '" type="text">';
        var newInput = $(newIn);
        var removeBtn = '<button id="remove' + (next - 1) + '" class="btn btn-danger remove-me" >-</button></div><div id="field">';
        var removeButton = $(removeBtn);
        $(addto).after(newInput);
        $(addRemove).after(removeButton);
        $("#field" + next).attr('data-source',$(addto).attr('data-source'));
        $("#count").val(next);  
        
            $('.remove-me').click(function(e){
                e.preventDefault();
                var fieldNum = this.id.charAt(this.id.length-1);
                var fieldID = "#field" + fieldNum;
                $(this).remove();
                $(fieldID).remove();
            });
    });
    

    
});



$(document).ready(function(){$(".responsive-accordion").each(function(){$(".responsive-accordion-minus",this).hide(),$(".responsive-accordion-panel",this).hide(),$(".responsive-accordion-head",this).click(function(){var i=$(this).parent().parent(),s=$(this),e=s.find(".responsive-accordion-plus"),n=s.find(".responsive-accordion-minus"),o=s.siblings(".responsive-accordion-panel");i.find(".responsive-accordion-plus").show(),i.find(".responsive-accordion-minus").hide(),i.find(".responsive-accordion-head").not(this).removeClass("active"),i.find(".responsive-accordion-panel").not(this).removeClass("active").slideUp(),s.hasClass("active")?(s.removeClass("active"),e.show(),n.hide(),o.removeClass("active").slideUp()):(s.addClass("active"),e.hide(),n.show(),o.addClass("active").slideDown())})})});







$(document).ready(function() {
    $('#example').DataTable( {
    "bLengthChange": false,
    "bFilter": true,
    "bInfo": false,
        "ordering": false,
        "info":     false,
		"bSort" : false
    } );
} );

$(document).ready(function() {
    $('#example1').DataTable( {
    "bLengthChange": false,
    "bFilter": true,
    "bInfo": false,
        "ordering": false,
        "info":     false,
		"bSort" : false
    } );
} );

$(document).ready(function() {
    $('#example2').DataTable( {
    "bLengthChange": false,
    "bFilter": true,
    "bInfo": false,
        "ordering": false,
        "info":     false,
		"bSort" : false
    } );
} );

$(document).ready(function() {
    $('#example3').DataTable( {
    "bLengthChange": false,
    "bFilter": true,
    "bInfo": false,
        "ordering": false,
        "info":     false,
		"bSort" : false
    } );
} );

$(document).ready(function() {
    $('#example4').DataTable( {
    "bLengthChange": false,
    "bFilter": true,
    "bInfo": false,
        "ordering": false,
        "info":     false,
		"bSort" : false
    } );
} );

$(document).ready(function() {
    $('#example5').DataTable( {
    "bLengthChange": false,
    "bFilter": true,
    "bInfo": false,
        "ordering": false,
        "info":     false,
		"bSort" : false
    } );
} );

$(document).ready(function() {
    $('#example6').DataTable( {
    "bLengthChange": false,
    "bFilter": true,
    "bInfo": false,
        "ordering": false,
        "info":     false,
		"bSort" : false
    } );
} );

$(document).ready(function() {
    $('#example7').DataTable( {
    "bLengthChange": false,
    "bFilter": true,
    "bInfo": false,
        "ordering": false,
        "info":     false,
		"bSort" : false
    } );
} );

$(document).ready(function() {
    $('#example8').DataTable( {
    "bLengthChange": false,
    "bFilter": true,
    "bInfo": false,
        "ordering": false,
        "info":     false,
		"bSort" : false
    } );
} );

$(document).ready(function() {
    $('#example9').DataTable( {
    "bLengthChange": false,
    "bFilter": true,
    "bInfo": false,
        "ordering": false,
        "info":     false,
		"bSort" : false
    } );
} );

$(document).ready(function() {
    $('#example10').DataTable( {
    "bLengthChange": false,
    "bFilter": true,
    "bInfo": false,
        "ordering": false,
        "info":     false,
		"bSort" : false
    } );
} );