/*
 * angular-ui-bootstrap
 * http://angular-ui.github.io/bootstrap/

 * Version: 0.14.3 - 2015-10-23
 * License: MIT
 */
angular.module("ui.bootstrap",["ui.bootstrap.tpls","ui.bootstrap.collapse","ui.bootstrap.accordion","ui.bootstrap.alert","ui.bootstrap.buttons","ui.bootstrap.carousel","ui.bootstrap.dateparser","ui.bootstrap.position","ui.bootstrap.datepicker","ui.bootstrap.dropdown","ui.bootstrap.stackedMap","ui.bootstrap.modal","ui.bootstrap.pagination","ui.bootstrap.tooltip","ui.bootstrap.popover","ui.bootstrap.progressbar","ui.bootstrap.rating","ui.bootstrap.tabs","ui.bootstrap.timepicker","ui.bootstrap.typeahead"]),angular.module("ui.bootstrap.tpls",["template/accordion/accordion-group.html","template/accordion/accordion.html","template/alert/alert.html","template/carousel/carousel.html","template/carousel/slide.html","template/datepicker/datepicker.html","template/datepicker/day.html","template/datepicker/month.html","template/datepicker/popup.html","template/datepicker/year.html","template/modal/backdrop.html","template/modal/window.html","template/pagination/pager.html","template/pagination/pagination.html","template/tooltip/tooltip-html-popup.html","template/tooltip/tooltip-popup.html","template/tooltip/tooltip-template-popup.html","template/popover/popover-html.html","template/popover/popover-template.html","template/popover/popover.html","template/progressbar/bar.html","template/progressbar/progress.html","template/progressbar/progressbar.html","template/rating/rating.html","template/tabs/tab.html","template/tabs/tabset.html","template/timepicker/timepicker.html","template/typeahead/typeahead-match.html","template/typeahead/typeahead-popup.html"]),angular.module("ui.bootstrap.collapse",[]).directive("uibCollapse",["$animate","$injector",function(a,b){var c=b.has("$animateCss")?b.get("$animateCss"):null;return{link:function(b,d,e){function f(){d.removeClass("collapse").addClass("collapsing").attr("aria-expanded",!0).attr("aria-hidden",!1),c?c(d,{addClass:"in",easing:"ease",to:{height:d[0].scrollHeight+"px"}}).start()["finally"](g):a.addClass(d,"in",{to:{height:d[0].scrollHeight+"px"}}).then(g)}function g(){d.removeClass("collapsing").addClass("collapse").css({height:"auto"})}function h(){return d.hasClass("collapse")||d.hasClass("in")?(d.css({height:d[0].scrollHeight+"px"}).removeClass("collapse").addClass("collapsing").attr("aria-expanded",!1).attr("aria-hidden",!0),void(c?c(d,{removeClass:"in",to:{height:"0"}}).start()["finally"](i):a.removeClass(d,"in",{to:{height:"0"}}).then(i))):i()}function i(){d.css({height:"0"}),d.removeClass("collapsing").addClass("collapse")}b.$watch(e.uibCollapse,function(a){a?h():f()})}}}]),angular.module("ui.bootstrap.collapse").value("$collapseSuppressWarning",!1).directive("collapse",["$animate","$injector","$log","$collapseSuppressWarning",function(a,b,c,d){var e=b.has("$animateCss")?b.get("$animateCss"):null;return{link:function(b,f,g){function h(){f.removeClass("collapse").addClass("collapsing").attr("aria-expanded",!0).attr("aria-hidden",!1),e?e(f,{easing:"ease",to:{height:f[0].scrollHeight+"px"}}).start().done(i):a.animate(f,{},{height:f[0].scrollHeight+"px"}).then(i)}function i(){f.removeClass("collapsing").addClass("collapse in").css({height:"auto"})}function j(){return f.hasClass("collapse")||f.hasClass("in")?(f.css({height:f[0].scrollHeight+"px"}).removeClass("collapse in").addClass("collapsing").attr("aria-expanded",!1).attr("aria-hidden",!0),void(e?e(f,{to:{height:"0"}}).start().done(k):a.animate(f,{},{height:"0"}).then(k))):k()}function k(){f.css({height:"0"}),f.removeClass("collapsing").addClass("collapse")}d||c.warn("collapse is now deprecated. Use uib-collapse instead."),b.$watch(g.collapse,function(a){a?j():h()})}}}]),angular.module("ui.bootstrap.accordion",["ui.bootstrap.collapse"]).constant("uibAccordionConfig",{closeOthers:!0}).controller("UibAccordionController",["$scope","$attrs","uibAccordionConfig",function(a,b,c){this.groups=[],this.closeOthers=function(d){var e=angular.isDefined(b.closeOthers)?a.$eval(b.closeOthers):c.closeOthers;e&&angular.forEach(this.groups,function(a){a!==d&&(a.isOpen=!1)})},this.addGroup=function(a){var b=this;this.groups.push(a),a.$on("$destroy",function(c){b.removeGroup(a)})},this.removeGroup=function(a){var b=this.groups.indexOf(a);-1!==b&&this.groups.splice(b,1)}}]).directive("uibAccordion",function(){return{controller:"UibAccordionController",controllerAs:"accordion",transclude:!0,templateUrl:function(a,b){return b.templateUrl||"template/accordion/accordion.html"}}}).directive("uibAccordionGroup",function(){return{require:"^uibAccordion",transclude:!0,replace:!0,templateUrl:function(a,b){return b.templateUrl||"template/accordion/accordion-group.html"},scope:{heading:"@",isOpen:"=?",isDisabled:"=?"},controller:function(){this.setHeading=function(a){this.heading=a}},link:function(a,b,c,d){d.addGroup(a),a.openClass=c.openClass||"panel-open",a.panelClass=c.panelClass,a.$watch("isOpen",function(c){b.toggleClass(a.openClass,!!c),c&&d.closeOthers(a)}),a.toggleOpen=function(b){a.isDisabled||b&&32!==b.which||(a.isOpen=!a.isOpen)}}}}).directive("uibAccordionHeading",function(){return{transclude:!0,template:"",replace:!0,require:"^uibAccordionGroup",link:function(a,b,c,d,e){d.setHeading(e(a,angular.noop))}}}).directive("uibAccordionTransclude",function(){return{require:["?^uibAccordionGroup","?^accordionGroup"],link:function(a,b,c,d){d=d[0]?d[0]:d[1],a.$watch(function(){return d[c.uibAccordionTransclude]},function(a){a&&(b.find("span").html(""),b.find("span").append(a))})}}}),angular.module("ui.bootstrap.accordion").value("$accordionSuppressWarning",!1).controller("AccordionController",["$scope","$attrs","$controller","$log","$accordionSuppressWarning",function(a,b,c,d,e){e||d.warn("AccordionController is now deprecated. Use UibAccordionController instead."),angular.extend(this,c("UibAccordionController",{$scope:a,$attrs:b}))}]).directive("accordion",["$log","$accordionSuppressWarning",function(a,b){return{restrict:"EA",controller:"AccordionController",controllerAs:"accordion",transclude:!0,replace:!1,templateUrl:function(a,b){return b.templateUrl||"template/accordion/accordion.html"},link:function(){b||a.warn("accordion is now deprecated. Use uib-accordion instead.")}}}]).directive("accordionGroup",["$log","$accordionSuppressWarning",function(a,b){return{require:"^accordion",restrict:"EA",transclude:!0,replace:!0,templateUrl:function(a,b){return b.templateUrl||"template/accordion/accordion-group.html"},scope:{heading:"@",isOpen:"=?",isDisabled:"=?"},controller:function(){this.setHeading=function(a){this.heading=a}},link:function(c,d,e,f){b||a.warn("accordion-group is now deprecated. Use uib-accordion-group instead."),f.addGroup(c),c.openClass=e.openClass||"panel-open",c.panelClass=e.panelClass,c.$watch("isOpen",function(a){d.toggleClass(c.openClass,!!a),a&&f.closeOthers(c)}),c.toggleOpen=function(a){c.isDisabled||a&&32!==a.which||(c.isOpen=!c.isOpen)}}}}]).directive("accordionHeading",["$log","$accordionSuppressWarning",function(a,b){return{restrict:"EA",transclude:!0,template:"",replace:!0,require:"^accordionGroup",link:function(c,d,e,f,g){b||a.warn("accordion-heading is now deprecated. Use uib-accordion-heading instead."),f.setHeading(g(c,angular.noop))}}}]).directive("accordionTransclude",["$log","$accordionSuppressWarning",function(a,b){return{require:"^accordionGroup",link:function(c,d,e,f){b||a.warn("accordion-transclude is now deprecated. Use uib-accordion-transclude instead."),c.$watch(function(){return f[e.accordionTransclude]},function(a){a&&(d.find("span").html(""),d.find("span").append(a))})}}}]),angular.module("ui.bootstrap.alert",[]).controller("UibAlertController",["$scope","$attrs","$interpolate","$timeout",function(a,b,c,d){a.closeable=!!b.close;var e=angular.isDefined(b.dismissOnTimeout)?c(b.dismissOnTimeout)(a.$parent):null;e&&d(function(){a.close()},parseInt(e,10))}]).directive("uibAlert",function(){return{controller:"UibAlertController",controllerAs:"alert",templateUrl:function(a,b){return b.templateUrl||"template/alert/alert.html"},transclude:!0,replace:!0,scope:{type:"@",close:"&"}}}),angular.module("ui.bootstrap.alert").value("$alertSuppressWarning",!1).controller("AlertController",["$scope","$attrs","$controller","$log","$alertSuppressWarning",function(a,b,c,d,e){e||d.warn("AlertController is now deprecated. Use UibAlertController instead."),angular.extend(this,c("UibAlertController",{$scope:a,$attrs:b}))}]).directive("alert",["$log","$alertSuppressWarning",function(a,b){return{controller:"AlertController",controllerAs:"alert",templateUrl:function(a,b){return b.templateUrl||"template/alert/alert.html"},transclude:!0,replace:!0,scope:{type:"@",close:"&"},link:function(){b||a.warn("alert is now deprecated. Use uib-alert instead.")}}}]),angular.module("ui.bootstrap.buttons",[]).constant("uibButtonConfig",{activeClass:"active",toggleEvent:"click"}).controller("UibButtonsController",["uibButtonConfig",function(a){this.activeClass=a.activeClass||"active",this.toggleEvent=a.toggleEvent||"click"}]).directive("uibBtnRadio",function(){return{require:["uibBtnRadio","ngModel"],controller:"UibButtonsController",controllerAs:"buttons",link:function(a,b,c,d){var e=d[0],f=d[1];b.find("input").css({display:"none"}),f.$render=function(){b.toggleClass(e.activeClass,angular.equals(f.$modelValue,a.$eval(c.uibBtnRadio)))},b.on(e.toggleEvent,function(){if(!c.disabled){var d=b.hasClass(e.activeClass);(!d||angular.isDefined(c.uncheckable))&&a.$apply(function(){f.$setViewValue(d?null:a.$eval(c.uibBtnRadio)),f.$render()})}})}}}).directive("uibBtnCheckbox",function(){return{require:["uibBtnCheckbox","ngModel"],controller:"UibButtonsController",controllerAs:"button",link:function(a,b,c,d){function e(){return g(c.btnCheckboxTrue,!0)}function f(){return g(c.btnCheckboxFalse,!1)}function g(b,c){return angular.isDefined(b)?a.$eval(b):c}var h=d[0],i=d[1];b.find("input").css({display:"none"}),i.$render=function(){b.toggleClass(h.activeClass,angular.equals(i.$modelValue,e()))},b.on(h.toggleEvent,function(){c.disabled||a.$apply(function(){i.$setViewValue(b.hasClass(h.activeClass)?f():e()),i.$render()})})}}}),angular.module("ui.bootstrap.buttons").value("$buttonsSuppressWarning",!1).controller("ButtonsController",["$controller","$log","$buttonsSuppressWarning",function(a,b,c){c||b.warn("ButtonsController is now deprecated. Use UibButtonsController instead."),angular.extend(this,a("UibButtonsController"))}]).directive("btnRadio",["$log","$buttonsSuppressWarning",function(a,b){return{require:["btnRadio","ngModel"],controller:"ButtonsController",controllerAs:"buttons",link:function(c,d,e,f){b||a.warn("btn-radio is now deprecated. Use uib-btn-radio instead.");var g=f[0],h=f[1];d.find("input").css({display:"none"}),h.$render=function(){d.toggleClass(g.activeClass,angular.equals(h.$modelValue,c.$eval(e.btnRadio)))},d.bind(g.toggleEvent,function(){if(!e.disabled){var a=d.hasClass(g.activeClass);(!a||angular.isDefined(e.uncheckable))&&c.$apply(function(){h.$setViewValue(a?null:c.$eval(e.btnRadio)),h.$render()})}})}}}]).directive("btnCheckbox",["$document","$log","$buttonsSuppressWarning",function(a,b,c){return{require:["btnCheckbox","ngModel"],controller:"ButtonsController",controllerAs:"button",link:function(d,e,f,g){function h(){return j(f.btnCheckboxTrue,!0)}function i(){return j(f.btnCheckboxFalse,!1)}function j(a,b){var c=d.$eval(a);return angular.isDefined(c)?c:b}c||b.warn("btn-checkbox is now deprecated. Use uib-btn-checkbox instead.");var k=g[0],l=g[1];e.find("input").css({display:"none"}),l.$render=function(){e.toggleClass(k.activeClass,angular.equals(l.$modelValue,h()))},e.bind(k.toggleEvent,function(){f.disabled||d.$apply(function(){l.$setViewValue(e.hasClass(k.activeClass)?i():h()),l.$render()})}),e.on("keypress",function(b){f.disabled||32!==b.which||a[0].activeElement!==e[0]||d.$apply(function(){l.$setViewValue(e.hasClass(k.activeClass)?i():h()),l.$render()})})}}}]),angular.module("ui.bootstrap.carousel",[]).controller("UibCarouselController",["$scope","$element","$interval","$animate",function(a,b,c,d){function e(b,c,e){s||(angular.extend(b,{direction:e,active:!0}),angular.extend(m.currentSlide||{},{direction:e,active:!1}),d.enabled()&&!a.noTransition&&!a.$currentTransition&&b.$element&&m.slides.length>1&&(b.$element.data(q,b.direction),m.currentSlide&&m.currentSlide.$element&&m.currentSlide.$element.data(q,b.direction),a.$currentTransition=!0,o?d.on("addClass",b.$element,function(b,c){"close"===c&&(a.$currentTransition=null,d.off("addClass",b))}):b.$element.one("$animate:close",function(){a.$currentTransition=null})),m.currentSlide=b,r=c,g())}function f(a){if(angular.isUndefined(n[a].index))return n[a];var b;n.length;for(b=0;b<n.length;++b)if(n[b].index==a)return n[b]}function g(){h();var b=+a.interval;!isNaN(b)&&b>0&&(k=c(i,b))}function h(){k&&(c.cancel(k),k=null)}function i(){var b=+a.interval;l&&!isNaN(b)&&b>0&&n.length?a.next():a.pause()}function j(b){b.length||(a.$currentTransition=null)}var k,l,m=this,n=m.slides=a.slides=[],o=angular.version.minor>=4,p="uib-noTransition",q="uib-slideDirection",r=-1;m.currentSlide=null;var s=!1;m.select=a.select=function(b,c){var d=a.indexOfSlide(b);void 0===c&&(c=d>m.getCurrentIndex()?"next":"prev"),b&&b!==m.currentSlide&&!a.$currentTransition&&e(b,d,c)},a.$on("$destroy",function(){s=!0}),m.getCurrentIndex=function(){return m.currentSlide&&angular.isDefined(m.currentSlide.index)?+m.currentSlide.index:r},a.indexOfSlide=function(a){return angular.isDefined(a.index)?+a.index:n.indexOf(a)},a.next=function(){var b=(m.getCurrentIndex()+1)%n.length;return 0===b&&a.noWrap()?void a.pause():m.select(f(b),"next")},a.prev=function(){var b=m.getCurrentIndex()-1<0?n.length-1:m.getCurrentIndex()-1;return a.noWrap()&&b===n.length-1?void a.pause():m.select(f(b),"prev")},a.isActive=function(a){return m.currentSlide===a},a.$watch("interval",g),a.$watchCollection("slides",j),a.$on("$destroy",h),a.play=function(){l||(l=!0,g())},a.pause=function(){a.noPause||(l=!1,h())},m.addSlide=function(b,c){b.$element=c,n.push(b),1===n.length||b.active?(m.select(n[n.length-1]),1===n.length&&a.play()):b.active=!1},m.removeSlide=function(a){angular.isDefined(a.index)&&n.sort(function(a,b){return+a.index>+b.index});var b=n.indexOf(a);n.splice(b,1),n.length>0&&a.active?b>=n.length?m.select(n[b-1]):m.select(n[b]):r>b&&r--,0===n.length&&(m.currentSlide=null)},a.$watch("noTransition",function(a){b.data(p,a)})}]).directive("uibCarousel",[function(){return{transclude:!0,replace:!0,controller:"UibCarouselController",controllerAs:"carousel",require:"carousel",templateUrl:function(a,b){return b.templateUrl||"template/carousel/carousel.html"},scope:{interval:"=",noTransition:"=",noPause:"=",noWrap:"&"}}}]).directive("uibSlide",function(){return{require:"^uibCarousel",restrict:"EA",transclude:!0,replace:!0,templateUrl:function(a,b){return b.templateUrl||"template/carousel/slide.html"},scope:{active:"=?",actual:"=?",index:"=?"},link:function(a,b,c,d){d.addSlide(a,b),a.$on("$destroy",function(){d.removeSlide(a)}),a.$watch("active",function(b){b&&d.select(a)})}}}).animation(".item",["$injector","$animate",function(a,b){function c(a,b,c){a.removeClass(b),c&&c()}var d="uib-noTransition",e="uib-slideDirection",f=null;return a.has("$animateCss")&&(f=a.get("$animateCss")),{beforeAddClass:function(a,g,h){if("active"==g&&a.parent()&&a.parent().parent()&&!a.parent().parent().data(d)){var i=!1,j=a.data(e),k="next"==j?"left":"right",l=c.bind(this,a,k+" "+j,h);return a.addClass(j),f?f(a,{addClass:k}).start().done(l):b.addClass(a,k).then(function(){i||l(),h()}),function(){i=!0}}h()},beforeRemoveClass:function(a,g,h){if("active"===g&&a.parent()&&a.parent().parent()&&!a.parent().parent().data(d)){var i=!1,j=a.data(e),k="next"==j?"left":"right",l=c.bind(this,a,k,h);return f?f(a,{addClass:k}).start().done(l):b.addClass(a,k).then(function(){i||l(),h()}),function(){i=!0}}h()}}}]),angular.module("ui.bootstrap.carousel").value("$carouselSuppressWarning",!1).controller("CarouselController",["$scope","$element","$controller","$log","$carouselSuppressWarning",function(a,b,c,d,e){e||d.warn("CarouselController is now deprecated. Use UibCarouselController instead."),angular.extend(this,c("UibCarouselController",{$scope:a,$element:b}))}]).directive("carousel",["$log","$carouselSuppressWarning",function(a,b){return{transclude:!0,replace:!0,controller:"CarouselController",controllerAs:"carousel",require:"carousel",templateUrl:function(a,b){return b.templateUrl||"template/carousel/carousel.html"},scope:{interval:"=",noTransition:"=",noPause:"=",noWrap:"&"},link:function(){b||a.warn("carousel is now deprecated. Use uib-carousel instead.")}}}]).directive("slide",["$log","$carouselSuppressWarning",function(a,b){return{require:"^carousel",transclude:!0,replace:!0,templateUrl:function(a,b){return b.templateUrl||"template/carousel/slide.html"},scope:{active:"=?",actual:"=?",index:"=?"},link:function(c,d,e,f){b||a.warn("slide is now deprecated. Use uib-slide instead."),f.addSlide(c,d),c.$on("$destroy",function(){f.removeSlide(c)}),c.$watch("active",function(a){a&&f.select(c)})}}}]),angular.module("ui.bootstrap.dateparser",[]).service("uibDateParser",["$log","$locale","orderByFilter",function(a,b,c){function d(a){var b=[],d=a.split("");return angular.forEach(g,function(c,e){var f=a.indexOf(e);if(f>-1){a=a.split(""),d[f]="("+c.regex+")",a[f]="$";for(var g=f+1,h=f+e.length;h>g;g++)d[g]="",a[g]="$";a=a.join(""),b.push({index:f,apply:c.apply})}}),{regex:new RegExp("^"+d.join("")+"$"),map:c(b,"index")}}function e(a,b,c){return 1>c?!1:1===b&&c>28?29===c&&(a%4===0&&a%100!==0||a%400===0):3===b||5===b||8===b||10===b?31>c:!0}var f,g,h=/[\\\^\$\*\+\?\|\[\]\(\)\.\{\}]/g;this.init=function(){f=b.id,this.parsers={},g={yyyy:{regex:"\\d{4}",apply:function(a){this.year=+a}},yy:{regex:"\\d{2}",apply:function(a){this.year=+a+2e3}},y:{regex:"\\d{1,4}",apply:function(a){this.year=+a}},MMMM:{regex:b.DATETIME_FORMATS.MONTH.join("|"),apply:function(a){this.month=b.DATETIME_FORMATS.MONTH.indexOf(a)}},MMM:{regex:b.DATETIME_FORMATS.SHORTMONTH.join("|"),apply:function(a){this.month=b.DATETIME_FORMATS.SHORTMONTH.indexOf(a)}},MM:{regex:"0[1-9]|1[0-2]",apply:function(a){this.month=a-1}},M:{regex:"[1-9]|1[0-2]",apply:function(a){this.month=a-1}},dd:{regex:"[0-2][0-9]{1}|3[0-1]{1}",apply:function(a){this.date=+a}},d:{regex:"[1-2]?[0-9]{1}|3[0-1]{1}",apply:function(a){this.date=+a}},EEEE:{regex:b.DATETIME_FORMATS.DAY.join("|")},EEE:{regex:b.DATETIME_FORMATS.SHORTDAY.join("|")},HH:{regex:"(?:0|1)[0-9]|2[0-3]",apply:function(a){this.hours=+a}},hh:{regex:"0[0-9]|1[0-2]",apply:function(a){this.hours=+a}},H:{regex:"1?[0-9]|2[0-3]",apply:function(a){this.hours=+a}},h:{regex:"[0-9]|1[0-2]",apply:function(a){this.hours=+a}},mm:{regex:"[0-5][0-9]",apply:function(a){this.minutes=+a}},m:{regex:"[0-9]|[1-5][0-9]",apply:function(a){this.minutes=+a}},sss:{regex:"[0-9][0-9][0-9]",apply:function(a){this.milliseconds=+a}},ss:{regex:"[0-5][0-9]",apply:function(a){this.seconds=+a}},s:{regex:"[0-9]|[1-5][0-9]",apply:function(a){this.seconds=+a}},a:{regex:b.DATETIME_FORMATS.AMPMS.join("|"),apply:function(a){12===this.hours&&(this.hours=0),"PM"===a&&(this.hours+=12)}}}},this.init(),this.parse=function(c,g,i){if(!angular.isString(c)||!g)return c;g=b.DATETIME_FORMATS[g]||g,g=g.replace(h,"\\$&"),b.id!==f&&this.init(),this.parsers[g]||(this.parsers[g]=d(g));var j=this.parsers[g],k=j.regex,l=j.map,m=c.match(k);if(m&&m.length){var n,o;angular.isDate(i)&&!isNaN(i.getTime())?n={year:i.getFullYear(),month:i.getMonth(),date:i.getDate(),hours:i.getHours(),minutes:i.getMinutes(),seconds:i.getSeconds(),milliseconds:i.getMilliseconds()}:(i&&a.warn("dateparser:","baseDate is not a valid date"),n={year:1900,month:0,date:1,hours:0,minutes:0,seconds:0,milliseconds:0});for(var p=1,q=m.length;q>p;p++){var r=l[p-1];r.apply&&r.apply.call(n,m[p])}return e(n.year,n.month,n.date)&&(angular.isDate(i)&&!isNaN(i.getTime())?(o=new Date(i),o.setFullYear(n.year,n.month,n.date,n.hours,n.minutes,n.seconds,n.milliseconds||0)):o=new Date(n.year,n.month,n.date,n.hours,n.minutes,n.seconds,n.milliseconds||0)),o}}}]),angular.module("ui.bootstrap.dateparser").value("$dateParserSuppressWarning",!1).service("dateParser",["$log","$dateParserSuppressWarning","uibDateParser",function(a,b,c){b||a.warn("dateParser is now deprecated. Use uibDateParser instead."),angular.extend(this,c)}]),angular.module("ui.bootstrap.position",[]).factory("$uibPosition",["$document","$window",function(a,b){function c(a,c){return a.currentStyle?a.currentStyle[c]:b.getComputedStyle?b.getComputedStyle(a)[c]:a.style[c]}function d(a){return"static"===(c(a,"position")||"static")}var e=function(b){for(var c=a[0],e=b.offsetParent||c;e&&e!==c&&d(e);)e=e.offsetParent;return e||c};return{position:function(b){var c=this.offset(b),d={top:0,left:0},f=e(b[0]);f!=a[0]&&(d=this.offset(angular.element(f)),d.top+=f.clientTop-f.scrollTop,d.left+=f.clientLeft-f.scrollLeft);var g=b[0].getBoundingClientRect();return{width:g.width||b.prop("offsetWidth"),height:g.height||b.prop("offsetHeight"),top:c.top-d.top,left:c.left-d.left}},offset:function(c){var d=c[0].getBoundingClientRect();return{width:d.width||c.prop("offsetWidth"),height:d.height||c.prop("offsetHeight"),top:d.top+(b.pageYOffset||a[0].documentElement.scrollTop),left:d.left+(b.pageXOffset||a[0].documentElement.scrollLeft)}},positionElements:function(a,b,c,d){var e,f,g,h,i=c.split("-"),j=i[0],k=i[1]||"center";e=d?this.offset(a):this.position(a),f=b.prop("offsetWidth"),g=b.prop("offsetHeight");var l={center:function(){return e.left+e.width/2-f/2},left:function(){return e.left},right:function(){return e.left+e.width}},m={center:function(){return e.top+e.height/2-g/2},top:function(){return e.top},bottom:function(){return e.top+e.height}};switch(j){case"right":h={top:m[k](),left:l[j]()};break;case"left":h={top:m[k](),left:e.left-f};break;case"bottom":h={top:m[j](),left:l[k]()};break;default:h={top:e.top-g,left:l[k]()}}return h}}}]),angular.module("ui.bootstrap.position").value("$positionSuppressWarning",!1).service("$position",["$log","$positionSuppressWarning","$uibPosition",function(a,b,c){b||a.warn("$position is now deprecated. Use $uibPosition instead."),angular.extend(this,c)}]),angular.module("ui.bootstrap.datepicker",["ui.bootstrap.dateparser","ui.bootstrap.position"]).value("$datepickerSuppressError",!1).constant("uibDatepickerConfig",{formatDay:"dd",formatMonth:"MMMM",formatYear:"yyyy",formatDayHeader:"EEE",formatDayTitle:"MMMM yyyy",formatMonthTitle:"yyyy",datepickerMode:"day",minMode:"day",maxMode:"year",showWeeks:!0,startingDay:0,yearRange:20,minDate:null,maxDate:null,shortcutPropagation:!1}).controller("UibDatepickerController",["$scope","$attrs","$parse","$interpolate","$log","dateFilter","uibDatepickerConfig","$datepickerSuppressError",function(a,b,c,d,e,f,g,h){var i=this,j={$setViewValue:angular.noop};this.modes=["day","month","year"],angular.forEach(["formatDay","formatMonth","formatYear","formatDayHeader","formatDayTitle","formatMonthTitle","showWeeks","startingDay","yearRange","shortcutPropagation"],function(c,e){i[c]=angular.isDefined(b[c])?6>e?d(b[c])(a.$parent):a.$parent.$eval(b[c]):g[c]}),angular.forEach(["minDate","maxDate"],function(d){b[d]?a.$parent.$watch(c(b[d]),function(a){i[d]=a?new Date(a):null,i.refreshView()}):i[d]=g[d]?new Date(g[d]):null}),angular.forEach(["minMode","maxMode"],function(d){b[d]?a.$parent.$watch(c(b[d]),function(c){i[d]=angular.isDefined(c)?c:b[d],a[d]=i[d],("minMode"==d&&i.modes.indexOf(a.datepickerMode)<i.modes.indexOf(i[d])||"maxMode"==d&&i.modes.indexOf(a.datepickerMode)>i.modes.indexOf(i[d]))&&(a.datepickerMode=i[d])}):(i[d]=g[d]||null,a[d]=i[d])}),a.datepickerMode=a.datepickerMode||g.datepickerMode,a.uniqueId="datepicker-"+a.$id+"-"+Math.floor(1e4*Math.random()),angular.isDefined(b.initDate)?(this.activeDate=a.$parent.$eval(b.initDate)||new Date,a.$parent.$watch(b.initDate,function(a){a&&(j.$isEmpty(j.$modelValue)||j.$invalid)&&(i.activeDate=a,i.refreshView())})):this.activeDate=new Date,a.isActive=function(b){return 0===i.compare(b.date,i.activeDate)?(a.activeDateId=b.uid,!0):!1},this.init=function(a){j=a,j.$render=function(){i.render()}},this.render=function(){if(j.$viewValue){var a=new Date(j.$viewValue),b=!isNaN(a);b?this.activeDate=a:h||e.error('Datepicker directive: "ng-model" value must be a Date object, a number of milliseconds since 01.01.1970 or a string representing an RFC2822 or ISO 8601 date.')}this.refreshView()},this.refreshView=function(){if(this.element){this._refreshView();var a=j.$viewValue?new Date(j.$viewValue):null;j.$setValidity("dateDisabled",!a||this.element&&!this.isDisabled(a))}},this.createDateObject=function(a,b){var c=j.$viewValue?new Date(j.$viewValue):null;return{date:a,label:f(a,b),selected:c&&0===this.compare(a,c),disabled:this.isDisabled(a),current:0===this.compare(a,new Date),customClass:this.customClass(a)}},this.isDisabled=function(c){return this.minDate&&this.compare(c,this.minDate)<0||this.maxDate&&this.compare(c,this.maxDate)>0||b.dateDisabled&&a.dateDisabled({date:c,mode:a.datepickerMode})},this.customClass=function(b){return a.customClass({date:b,mode:a.datepickerMode})},this.split=function(a,b){for(var c=[];a.length>0;)c.push(a.splice(0,b));return c},a.select=function(b){if(a.datepickerMode===i.minMode){var c=j.$viewValue?new Date(j.$viewValue):new Date(0,0,0,0,0,0,0);c.setFullYear(b.getFullYear(),b.getMonth(),b.getDate()),j.$setViewValue(c),j.$render()}else i.activeDate=b,a.datepickerMode=i.modes[i.modes.indexOf(a.datepickerMode)-1]},a.move=function(a){var b=i.activeDate.getFullYear()+a*(i.step.years||0),c=i.activeDate.getMonth()+a*(i.step.months||0);i.activeDate.setFullYear(b,c,1),i.refreshView()},a.toggleMode=function(b){b=b||1,a.datepickerMode===i.maxMode&&1===b||a.datepickerMode===i.minMode&&-1===b||(a.datepickerMode=i.modes[i.modes.indexOf(a.datepickerMode)+b])},a.keys={13:"enter",32:"space",33:"pageup",34:"pagedown",35:"end",36:"home",37:"left",38:"up",39:"right",40:"down"};var k=function(){i.element[0].focus()};a.$on("uib:datepicker.focus",k),a.keydown=function(b){var c=a.keys[b.which];if(c&&!b.shiftKey&&!b.altKey)if(b.preventDefault(),i.shortcutPropagation||b.stopPropagation(),"enter"===c||"space"===c){if(i.isDisabled(i.activeDate))return;a.select(i.activeDate)}else!b.ctrlKey||"up"!==c&&"down"!==c?(i.handleKeyDown(c,b),i.refreshView()):a.toggleMode("up"===c?1:-1)}}]).controller("UibDaypickerController",["$scope","$element","dateFilter",function(a,b,c){function d(a,b){return 1!==b||a%4!==0||a%100===0&&a%400!==0?f[b]:29}function e(a){var b=new Date(a);b.setDate(b.getDate()+4-(b.getDay()||7));var c=b.getTime();return b.setMonth(0),b.setDate(1),Math.floor(Math.round((c-b)/864e5)/7)+1}var f=[31,28,31,30,31,30,31,31,30,31,30,31];this.step={months:1},this.element=b,this.init=function(b){angular.extend(b,this),a.showWeeks=b.showWeeks,b.refreshView()},this.getDates=function(a,b){for(var c,d=new Array(b),e=new Date(a),f=0;b>f;)c=new Date(e),d[f++]=c,e.setDate(e.getDate()+1);return d},this._refreshView=function(){var b=this.activeDate.getFullYear(),d=this.activeDate.getMonth(),f=new Date(this.activeDate);f.setFullYear(b,d,1);var g=this.startingDay-f.getDay(),h=g>0?7-g:-g,i=new Date(f);h>0&&i.setDate(-h+1);for(var j=this.getDates(i,42),k=0;42>k;k++)j[k]=angular.extend(this.createDateObject(j[k],this.formatDay),{secondary:j[k].getMonth()!==d,uid:a.uniqueId+"-"+k});a.labels=new Array(7);for(var l=0;7>l;l++)a.labels[l]={abbr:c(j[l].date,this.formatDayHeader),full:c(j[l].date,"EEEE")};if(a.title=c(this.activeDate,this.formatDayTitle),a.rows=this.split(j,7),a.showWeeks){a.weekNumbers=[];for(var m=(11-this.startingDay)%7,n=a.rows.length,o=0;n>o;o++)a.weekNumbers.push(e(a.rows[o][m].date))}},this.compare=function(a,b){return new Date(a.getFullYear(),a.getMonth(),a.getDate())-new Date(b.getFullYear(),b.getMonth(),b.getDate())},this.handleKeyDown=function(a,b){var c=this.activeDate.getDate();if("left"===a)c-=1;else if("up"===a)c-=7;else if("right"===a)c+=1;else if("down"===a)c+=7;else if("pageup"===a||"pagedown"===a){var e=this.activeDate.getMonth()+("pageup"===a?-1:1);this.activeDate.setMonth(e,1),c=Math.min(d(this.activeDate.getFullYear(),this.activeDate.getMonth()),c)}else"home"===a?c=1:"end"===a&&(c=d(this.activeDate.getFullYear(),this.activeDate.getMonth()));this.activeDate.setDate(c)}}]).controller("UibMonthpickerController",["$scope","$element","dateFilter",function(a,b,c){this.step={years:1},this.element=b,this.init=function(a){angular.extend(a,this),a.refreshView()},this._refreshView=function(){for(var b,d=new Array(12),e=this.activeDate.getFullYear(),f=0;12>f;f++)b=new Date(this.activeDate),b.setFullYear(e,f,1),d[f]=angular.extend(this.createDateObject(b,this.formatMonth),{uid:a.uniqueId+"-"+f});a.title=c(this.activeDate,this.formatMonthTitle),a.rows=this.split(d,3)},this.compare=function(a,b){return new Date(a.getFullYear(),a.getMonth())-new Date(b.getFullYear(),b.getMonth())},this.handleKeyDown=function(a,b){var c=this.activeDate.getMonth();if("left"===a)c-=1;else if("up"===a)c-=3;else if("right"===a)c+=1;else if("down"===a)c+=3;else if("pageup"===a||"pagedown"===a){var d=this.activeDate.getFullYear()+("pageup"===a?-1:1);this.activeDate.setFullYear(d)}else"home"===a?c=0:"end"===a&&(c=11);this.activeDate.setMonth(c)}}]).controller("UibYearpickerController",["$scope","$element","dateFilter",function(a,b,c){function d(a){return parseInt((a-1)/e,10)*e+1}var e;this.element=b,this.yearpickerInit=function(){e=this.yearRange,this.step={years:e}},this._refreshView=function(){for(var b,c=new Array(e),f=0,g=d(this.activeDate.getFullYear());e>f;f++)b=new Date(this.activeDate),b.setFullYear(g+f,0,1),c[f]=angular.extend(this.createDateObject(b,this.formatYear),{uid:a.uniqueId+"-"+f});a.title=[c[0].label,c[e-1].label].join(" - "),a.rows=this.split(c,5)},this.compare=function(a,b){return a.getFullYear()-b.getFullYear()},this.handleKeyDown=function(a,b){var c=this.activeDate.getFullYear();"left"===a?c-=1:"up"===a?c-=5:"right"===a?c+=1:"down"===a?c+=5:"pageup"===a||"pagedown"===a?c+=("pageup"===a?-1:1)*this.step.years:"home"===a?c=d(this.activeDate.getFullYear()):"end"===a&&(c=d(this.activeDate.getFullYear())+e-1),this.activeDate.setFullYear(c)}}]).directive("uibDatepicker",function(){return{replace:!0,templateUrl:function(a,b){return b.templateUrl||"template/datepicker/datepicker.html"},scope:{datepickerMode:"=?",dateDisabled:"&",customClass:"&",shortcutPropagation:"&?"},require:["uibDatepicker","^ngModel"],controller:"UibDatepickerController",controllerAs:"datepicker",link:function(a,b,c,d){var e=d[0],f=d[1];e.init(f)}}}).directive("uibDaypicker",function(){return{replace:!0,templateUrl:function(a,b){return b.templateUrl||"template/datepicker/day.html"},require:["^?uibDatepicker","uibDaypicker","^?datepicker"],controller:"UibDaypickerController",link:function(a,b,c,d){var e=d[0]||d[2],f=d[1];f.init(e)}}}).directive("uibMonthpicker",function(){return{replace:!0,templateUrl:function(a,b){return b.templateUrl||"template/datepicker/month.html"},require:["^?uibDatepicker","uibMonthpicker","^?datepicker"],controller:"UibMonthpickerController",link:function(a,b,c,d){var e=d[0]||d[2],f=d[1];f.init(e)}}}).directive("uibYearpicker",function(){return{replace:!0,templateUrl:function(a,b){return b.templateUrl||"template/datepicker/year.html"},require:["^?uibDatepicker","uibYearpicker","^?datepicker"],controller:"UibYearpickerController",link:function(a,b,c,d){var e=d[0]||d[2];angular.extend(e,d[1]),e.yearpickerInit(),e.refreshView()}}}).constant("uibDatepickerPopupConfig",{datepickerPopup:"yyyy-MM-dd",datepickerPopupTemplateUrl:"template/datepicker/popup.html",datepickerTemplateUrl:"template/datepicker/datepicker.html",html5Types:{date:"yyyy-MM-dd","datetime-local":"yyyy-MM-ddTHH:mm:ss.sss",month:"yyyy-MM"},currentText:"Today",clearText:"Clear",closeText:"Done",closeOnDateSelection:!0,appendToBody:!1,showButtonBar:!0,onOpenFocus:!0}).controller("UibDatepickerPopupController",["$scope","$element","$attrs","$compile","$parse","$document","$rootScope","$uibPosition","dateFilter","uibDateParser","uibDatepickerPopupConfig","$timeout",function(a,b,c,d,e,f,g,h,i,j,k,l){
function m(a){return a.replace(/([A-Z])/g,function(a){return"-"+a.toLowerCase()})}function n(b){if(angular.isNumber(b)&&(b=new Date(b)),b){if(angular.isDate(b)&&!isNaN(b))return b;if(angular.isString(b)){var c=j.parse(b,r,a.date);return isNaN(c)?void 0:c}return void 0}return null}function o(a,b){var d=a||b;if(!c.ngRequired&&!d)return!0;if(angular.isNumber(d)&&(d=new Date(d)),d){if(angular.isDate(d)&&!isNaN(d))return!0;if(angular.isString(d)){var e=j.parse(d,r);return!isNaN(e)}return!1}return!0}function p(c){var d=A[0],e=b[0].contains(c.target),f=void 0!==d.contains&&d.contains(c.target);!a.isOpen||e||f||a.$apply(function(){a.isOpen=!1})}function q(c){27===c.which&&a.isOpen?(c.preventDefault(),c.stopPropagation(),a.$apply(function(){a.isOpen=!1}),b[0].focus()):40!==c.which||a.isOpen||(c.preventDefault(),c.stopPropagation(),a.$apply(function(){a.isOpen=!0}))}var r,s,t,u,v,w,x,y,z,A,B={},C=!1;a.watchData={},this.init=function(h){if(z=h,s=angular.isDefined(c.closeOnDateSelection)?a.$parent.$eval(c.closeOnDateSelection):k.closeOnDateSelection,t=angular.isDefined(c.datepickerAppendToBody)?a.$parent.$eval(c.datepickerAppendToBody):k.appendToBody,u=angular.isDefined(c.onOpenFocus)?a.$parent.$eval(c.onOpenFocus):k.onOpenFocus,v=angular.isDefined(c.datepickerPopupTemplateUrl)?c.datepickerPopupTemplateUrl:k.datepickerPopupTemplateUrl,w=angular.isDefined(c.datepickerTemplateUrl)?c.datepickerTemplateUrl:k.datepickerTemplateUrl,a.showButtonBar=angular.isDefined(c.showButtonBar)?a.$parent.$eval(c.showButtonBar):k.showButtonBar,k.html5Types[c.type]?(r=k.html5Types[c.type],C=!0):(r=c.datepickerPopup||c.uibDatepickerPopup||k.datepickerPopup,c.$observe("uibDatepickerPopup",function(a,b){var c=a||k.datepickerPopup;if(c!==r&&(r=c,z.$modelValue=null,!r))throw new Error("uibDatepickerPopup must have a date format specified.")})),!r)throw new Error("uibDatepickerPopup must have a date format specified.");if(C&&c.datepickerPopup)throw new Error("HTML5 date input types do not support custom formats.");if(x=angular.element("<div uib-datepicker-popup-wrap><div uib-datepicker></div></div>"),x.attr({"ng-model":"date","ng-change":"dateSelection(date)","template-url":v}),y=angular.element(x.children()[0]),y.attr("template-url",w),C&&"month"===c.type&&(y.attr("datepicker-mode",'"month"'),y.attr("min-mode","month")),c.datepickerOptions){var l=a.$parent.$eval(c.datepickerOptions);l&&l.initDate&&(a.initDate=l.initDate,y.attr("init-date","initDate"),delete l.initDate),angular.forEach(l,function(a,b){y.attr(m(b),a)})}angular.forEach(["minMode","maxMode","minDate","maxDate","datepickerMode","initDate","shortcutPropagation"],function(b){if(c[b]){var d=e(c[b]);if(a.$parent.$watch(d,function(c){a.watchData[b]=c,("minDate"===b||"maxDate"===b)&&(B[b]=new Date(c))}),y.attr(m(b),"watchData."+b),"datepickerMode"===b){var f=d.assign;a.$watch("watchData."+b,function(b,c){angular.isFunction(f)&&b!==c&&f(a.$parent,b)})}}}),c.dateDisabled&&y.attr("date-disabled","dateDisabled({ date: date, mode: mode })"),c.showWeeks&&y.attr("show-weeks",c.showWeeks),c.customClass&&y.attr("custom-class","customClass({ date: date, mode: mode })"),C?z.$formatters.push(function(b){return a.date=b,b}):(z.$$parserName="date",z.$validators.date=o,z.$parsers.unshift(n),z.$formatters.push(function(b){return a.date=b,z.$isEmpty(b)?b:i(b,r)})),z.$viewChangeListeners.push(function(){a.date=j.parse(z.$viewValue,r,a.date)}),b.bind("keydown",q),A=d(x)(a),x.remove(),t?f.find("body").append(A):b.after(A),a.$on("$destroy",function(){a.isOpen===!0&&(g.$$phase||a.$apply(function(){a.isOpen=!1})),A.remove(),b.unbind("keydown",q),f.unbind("click",p)})},a.getText=function(b){return a[b+"Text"]||k[b+"Text"]},a.isDisabled=function(b){return"today"===b&&(b=new Date),a.watchData.minDate&&a.compare(b,B.minDate)<0||a.watchData.maxDate&&a.compare(b,B.maxDate)>0},a.compare=function(a,b){return new Date(a.getFullYear(),a.getMonth(),a.getDate())-new Date(b.getFullYear(),b.getMonth(),b.getDate())},a.dateSelection=function(c){angular.isDefined(c)&&(a.date=c);var d=a.date?i(a.date,r):null;b.val(d),z.$setViewValue(d),s&&(a.isOpen=!1,b[0].focus())},a.keydown=function(c){27===c.which&&(a.isOpen=!1,b[0].focus())},a.select=function(b){if("today"===b){var c=new Date;angular.isDate(a.date)?(b=new Date(a.date),b.setFullYear(c.getFullYear(),c.getMonth(),c.getDate())):b=new Date(c.setHours(0,0,0,0))}a.dateSelection(b)},a.close=function(){a.isOpen=!1,b[0].focus()},a.$watch("isOpen",function(c){c?(a.position=t?h.offset(b):h.position(b),a.position.top=a.position.top+b.prop("offsetHeight"),l(function(){u&&a.$broadcast("uib:datepicker.focus"),f.bind("click",p)},0,!1)):f.unbind("click",p)})}]).directive("uibDatepickerPopup",function(){return{require:["ngModel","uibDatepickerPopup"],controller:"UibDatepickerPopupController",scope:{isOpen:"=?",currentText:"@",clearText:"@",closeText:"@",dateDisabled:"&",customClass:"&"},link:function(a,b,c,d){var e=d[0],f=d[1];f.init(e)}}}).directive("uibDatepickerPopupWrap",function(){return{replace:!0,transclude:!0,templateUrl:function(a,b){return b.templateUrl||"template/datepicker/popup.html"}}}),angular.module("ui.bootstrap.datepicker").value("$datepickerSuppressWarning",!1).controller("DatepickerController",["$scope","$attrs","$parse","$interpolate","$log","dateFilter","uibDatepickerConfig","$datepickerSuppressError","$datepickerSuppressWarning",function(a,b,c,d,e,f,g,h,i){i||e.warn("DatepickerController is now deprecated. Use UibDatepickerController instead.");var j=this,k={$setViewValue:angular.noop};this.modes=["day","month","year"],angular.forEach(["formatDay","formatMonth","formatYear","formatDayHeader","formatDayTitle","formatMonthTitle","showWeeks","startingDay","yearRange","shortcutPropagation"],function(c,e){j[c]=angular.isDefined(b[c])?6>e?d(b[c])(a.$parent):a.$parent.$eval(b[c]):g[c]}),angular.forEach(["minDate","maxDate"],function(d){b[d]?a.$parent.$watch(c(b[d]),function(a){j[d]=a?new Date(a):null,j.refreshView()}):j[d]=g[d]?new Date(g[d]):null}),angular.forEach(["minMode","maxMode"],function(d){b[d]?a.$parent.$watch(c(b[d]),function(c){j[d]=angular.isDefined(c)?c:b[d],a[d]=j[d],("minMode"==d&&j.modes.indexOf(a.datepickerMode)<j.modes.indexOf(j[d])||"maxMode"==d&&j.modes.indexOf(a.datepickerMode)>j.modes.indexOf(j[d]))&&(a.datepickerMode=j[d])}):(j[d]=g[d]||null,a[d]=j[d])}),a.datepickerMode=a.datepickerMode||g.datepickerMode,a.uniqueId="datepicker-"+a.$id+"-"+Math.floor(1e4*Math.random()),angular.isDefined(b.initDate)?(this.activeDate=a.$parent.$eval(b.initDate)||new Date,a.$parent.$watch(b.initDate,function(a){a&&(k.$isEmpty(k.$modelValue)||k.$invalid)&&(j.activeDate=a,j.refreshView())})):this.activeDate=new Date,a.isActive=function(b){return 0===j.compare(b.date,j.activeDate)?(a.activeDateId=b.uid,!0):!1},this.init=function(a){k=a,k.$render=function(){j.render()}},this.render=function(){if(k.$viewValue){var a=new Date(k.$viewValue),b=!isNaN(a);b?this.activeDate=a:h||e.error('Datepicker directive: "ng-model" value must be a Date object, a number of milliseconds since 01.01.1970 or a string representing an RFC2822 or ISO 8601 date.')}this.refreshView()},this.refreshView=function(){if(this.element){this._refreshView();var a=k.$viewValue?new Date(k.$viewValue):null;k.$setValidity("dateDisabled",!a||this.element&&!this.isDisabled(a))}},this.createDateObject=function(a,b){var c=k.$viewValue?new Date(k.$viewValue):null;return{date:a,label:f(a,b),selected:c&&0===this.compare(a,c),disabled:this.isDisabled(a),current:0===this.compare(a,new Date),customClass:this.customClass(a)}},this.isDisabled=function(c){return this.minDate&&this.compare(c,this.minDate)<0||this.maxDate&&this.compare(c,this.maxDate)>0||b.dateDisabled&&a.dateDisabled({date:c,mode:a.datepickerMode})},this.customClass=function(b){return a.customClass({date:b,mode:a.datepickerMode})},this.split=function(a,b){for(var c=[];a.length>0;)c.push(a.splice(0,b));return c},this.fixTimeZone=function(a){var b=a.getHours();a.setHours(23===b?b+2:0)},a.select=function(b){if(a.datepickerMode===j.minMode){var c=k.$viewValue?new Date(k.$viewValue):new Date(0,0,0,0,0,0,0);c.setFullYear(b.getFullYear(),b.getMonth(),b.getDate()),k.$setViewValue(c),k.$render()}else j.activeDate=b,a.datepickerMode=j.modes[j.modes.indexOf(a.datepickerMode)-1]},a.move=function(a){var b=j.activeDate.getFullYear()+a*(j.step.years||0),c=j.activeDate.getMonth()+a*(j.step.months||0);j.activeDate.setFullYear(b,c,1),j.refreshView()},a.toggleMode=function(b){b=b||1,a.datepickerMode===j.maxMode&&1===b||a.datepickerMode===j.minMode&&-1===b||(a.datepickerMode=j.modes[j.modes.indexOf(a.datepickerMode)+b])},a.keys={13:"enter",32:"space",33:"pageup",34:"pagedown",35:"end",36:"home",37:"left",38:"up",39:"right",40:"down"};var l=function(){j.element[0].focus()};a.$on("uib:datepicker.focus",l),a.keydown=function(b){var c=a.keys[b.which];if(c&&!b.shiftKey&&!b.altKey)if(b.preventDefault(),j.shortcutPropagation||b.stopPropagation(),"enter"===c||"space"===c){if(j.isDisabled(j.activeDate))return;a.select(j.activeDate)}else!b.ctrlKey||"up"!==c&&"down"!==c?(j.handleKeyDown(c,b),j.refreshView()):a.toggleMode("up"===c?1:-1)}}]).directive("datepicker",["$log","$datepickerSuppressWarning",function(a,b){return{replace:!0,templateUrl:function(a,b){return b.templateUrl||"template/datepicker/datepicker.html"},scope:{datepickerMode:"=?",dateDisabled:"&",customClass:"&",shortcutPropagation:"&?"},require:["datepicker","^ngModel"],controller:"DatepickerController",controllerAs:"datepicker",link:function(c,d,e,f){b||a.warn("datepicker is now deprecated. Use uib-datepicker instead.");var g=f[0],h=f[1];g.init(h)}}}]).directive("daypicker",["$log","$datepickerSuppressWarning",function(a,b){return{replace:!0,templateUrl:"template/datepicker/day.html",require:["^datepicker","daypicker"],controller:"UibDaypickerController",link:function(c,d,e,f){b||a.warn("daypicker is now deprecated. Use uib-daypicker instead.");var g=f[0],h=f[1];h.init(g)}}}]).directive("monthpicker",["$log","$datepickerSuppressWarning",function(a,b){return{replace:!0,templateUrl:"template/datepicker/month.html",require:["^datepicker","monthpicker"],controller:"UibMonthpickerController",link:function(c,d,e,f){b||a.warn("monthpicker is now deprecated. Use uib-monthpicker instead.");var g=f[0],h=f[1];h.init(g)}}}]).directive("yearpicker",["$log","$datepickerSuppressWarning",function(a,b){return{replace:!0,templateUrl:"template/datepicker/year.html",require:["^datepicker","yearpicker"],controller:"UibYearpickerController",link:function(c,d,e,f){b||a.warn("yearpicker is now deprecated. Use uib-yearpicker instead.");var g=f[0];angular.extend(g,f[1]),g.yearpickerInit(),g.refreshView()}}}]).directive("datepickerPopup",["$log","$datepickerSuppressWarning",function(a,b){return{require:["ngModel","datepickerPopup"],controller:"UibDatepickerPopupController",scope:{isOpen:"=?",currentText:"@",clearText:"@",closeText:"@",dateDisabled:"&",customClass:"&"},link:function(c,d,e,f){b||a.warn("datepicker-popup is now deprecated. Use uib-datepicker-popup instead.");var g=f[0],h=f[1];h.init(g)}}}]).directive("datepickerPopupWrap",["$log","$datepickerSuppressWarning",function(a,b){return{replace:!0,transclude:!0,templateUrl:function(a,b){return b.templateUrl||"template/datepicker/popup.html"},link:function(){b||a.warn("datepicker-popup-wrap is now deprecated. Use uib-datepicker-popup-wrap instead.")}}}]),angular.module("ui.bootstrap.dropdown",["ui.bootstrap.position"]).constant("uibDropdownConfig",{openClass:"open"}).service("uibDropdownService",["$document","$rootScope",function(a,b){var c=null;this.open=function(b){c||(a.bind("click",d),a.bind("keydown",e)),c&&c!==b&&(c.isOpen=!1),c=b},this.close=function(b){c===b&&(c=null,a.unbind("click",d),a.unbind("keydown",e))};var d=function(a){if(c&&(!a||"disabled"!==c.getAutoClose())){var d=c.getToggleElement();if(!(a&&d&&d[0].contains(a.target))){var e=c.getDropdownElement();a&&"outsideClick"===c.getAutoClose()&&e&&e[0].contains(a.target)||(c.isOpen=!1,b.$$phase||c.$apply())}}},e=function(a){27===a.which?(c.focusToggleElement(),d()):c.isKeynavEnabled()&&/(38|40)/.test(a.which)&&c.isOpen&&(a.preventDefault(),a.stopPropagation(),c.focusDropdownEntry(a.which))}}]).controller("UibDropdownController",["$scope","$element","$attrs","$parse","uibDropdownConfig","uibDropdownService","$animate","$uibPosition","$document","$compile","$templateRequest",function(a,b,c,d,e,f,g,h,i,j,k){var l,m,n=this,o=a.$new(),p=e.openClass,q=angular.noop,r=c.onToggle?d(c.onToggle):angular.noop,s=!1,t=!1;b.addClass("dropdown"),this.init=function(){c.isOpen&&(m=d(c.isOpen),q=m.assign,a.$watch(m,function(a){o.isOpen=!!a})),s=angular.isDefined(c.dropdownAppendToBody),t=angular.isDefined(c.uibKeyboardNav),s&&n.dropdownMenu&&(i.find("body").append(n.dropdownMenu),b.on("$destroy",function(){n.dropdownMenu.remove()}))},this.toggle=function(a){return o.isOpen=arguments.length?!!a:!o.isOpen},this.isOpen=function(){return o.isOpen},o.getToggleElement=function(){return n.toggleElement},o.getAutoClose=function(){return c.autoClose||"always"},o.getElement=function(){return b},o.isKeynavEnabled=function(){return t},o.focusDropdownEntry=function(a){var c=n.dropdownMenu?angular.element(n.dropdownMenu).find("a"):angular.element(b).find("ul").eq(0).find("a");switch(a){case 40:angular.isNumber(n.selectedOption)?n.selectedOption=n.selectedOption===c.length-1?n.selectedOption:n.selectedOption+1:n.selectedOption=0;break;case 38:angular.isNumber(n.selectedOption)?n.selectedOption=0===n.selectedOption?0:n.selectedOption-1:n.selectedOption=c.length-1}c[n.selectedOption].focus()},o.getDropdownElement=function(){return n.dropdownMenu},o.focusToggleElement=function(){n.toggleElement&&n.toggleElement[0].focus()},o.$watch("isOpen",function(c,d){if(s&&n.dropdownMenu){var e=h.positionElements(b,n.dropdownMenu,"bottom-left",!0),i={top:e.top+"px",display:c?"block":"none"},m=n.dropdownMenu.hasClass("dropdown-menu-right");m?(i.left="auto",i.right=window.innerWidth-(e.left+b.prop("offsetWidth"))+"px"):(i.left=e.left+"px",i.right="auto"),n.dropdownMenu.css(i)}if(g[c?"addClass":"removeClass"](b,p).then(function(){angular.isDefined(c)&&c!==d&&r(a,{open:!!c})}),c)n.dropdownMenuTemplateUrl&&k(n.dropdownMenuTemplateUrl).then(function(a){l=o.$new(),j(a.trim())(l,function(a){var b=a;n.dropdownMenu.replaceWith(b),n.dropdownMenu=b})}),o.focusToggleElement(),f.open(o);else{if(n.dropdownMenuTemplateUrl){l&&l.$destroy();var t=angular.element('<ul class="dropdown-menu"></ul>');n.dropdownMenu.replaceWith(t),n.dropdownMenu=t}f.close(o),n.selectedOption=null}angular.isFunction(q)&&q(a,c)}),a.$on("$locationChangeSuccess",function(){"disabled"!==o.getAutoClose()&&(o.isOpen=!1)});var u=a.$on("$destroy",function(){o.$destroy()});o.$on("$destroy",u)}]).directive("uibDropdown",function(){return{controller:"UibDropdownController",link:function(a,b,c,d){d.init()}}}).directive("uibDropdownMenu",function(){return{restrict:"AC",require:"?^uibDropdown",link:function(a,b,c,d){if(d&&!angular.isDefined(c.dropdownNested)){b.addClass("dropdown-menu");var e=c.templateUrl;e&&(d.dropdownMenuTemplateUrl=e),d.dropdownMenu||(d.dropdownMenu=b)}}}}).directive("uibKeyboardNav",function(){return{restrict:"A",require:"?^uibDropdown",link:function(a,b,c,d){b.bind("keydown",function(a){if(-1!==[38,40].indexOf(a.which)){a.preventDefault(),a.stopPropagation();var b=d.dropdownMenu.find("a");switch(a.which){case 40:angular.isNumber(d.selectedOption)?d.selectedOption=d.selectedOption===b.length-1?d.selectedOption:d.selectedOption+1:d.selectedOption=0;break;case 38:angular.isNumber(d.selectedOption)?d.selectedOption=0===d.selectedOption?0:d.selectedOption-1:d.selectedOption=b.length-1}b[d.selectedOption].focus()}})}}}).directive("uibDropdownToggle",function(){return{require:"?^uibDropdown",link:function(a,b,c,d){if(d){b.addClass("dropdown-toggle"),d.toggleElement=b;var e=function(e){e.preventDefault(),b.hasClass("disabled")||c.disabled||a.$apply(function(){d.toggle()})};b.bind("click",e),b.attr({"aria-haspopup":!0,"aria-expanded":!1}),a.$watch(d.isOpen,function(a){b.attr("aria-expanded",!!a)}),a.$on("$destroy",function(){b.unbind("click",e)})}}}}),angular.module("ui.bootstrap.dropdown").value("$dropdownSuppressWarning",!1).service("dropdownService",["$log","$dropdownSuppressWarning","uibDropdownService",function(a,b,c){b||a.warn("dropdownService is now deprecated. Use uibDropdownService instead."),angular.extend(this,c)}]).controller("DropdownController",["$scope","$element","$attrs","$parse","uibDropdownConfig","uibDropdownService","$animate","$uibPosition","$document","$compile","$templateRequest","$log","$dropdownSuppressWarning",function(a,b,c,d,e,f,g,h,i,j,k,l,m){m||l.warn("DropdownController is now deprecated. Use UibDropdownController instead.");var n,o,p=this,q=a.$new(),r=e.openClass,s=angular.noop,t=c.onToggle?d(c.onToggle):angular.noop,u=!1,v=!1;b.addClass("dropdown"),this.init=function(){c.isOpen&&(o=d(c.isOpen),s=o.assign,a.$watch(o,function(a){q.isOpen=!!a})),u=angular.isDefined(c.dropdownAppendToBody),v=angular.isDefined(c.uibKeyboardNav),u&&p.dropdownMenu&&(i.find("body").append(p.dropdownMenu),b.on("$destroy",function(){p.dropdownMenu.remove()}))},this.toggle=function(a){return q.isOpen=arguments.length?!!a:!q.isOpen},this.isOpen=function(){return q.isOpen},q.getToggleElement=function(){return p.toggleElement},q.getAutoClose=function(){return c.autoClose||"always"},q.getElement=function(){return b},q.isKeynavEnabled=function(){return v},q.focusDropdownEntry=function(a){var c=p.dropdownMenu?angular.element(p.dropdownMenu).find("a"):angular.element(b).find("ul").eq(0).find("a");switch(a){case 40:angular.isNumber(p.selectedOption)?p.selectedOption=p.selectedOption===c.length-1?p.selectedOption:p.selectedOption+1:p.selectedOption=0;break;case 38:angular.isNumber(p.selectedOption)?p.selectedOption=0===p.selectedOption?0:p.selectedOption-1:p.selectedOption=c.length-1}c[p.selectedOption].focus()},q.getDropdownElement=function(){return p.dropdownMenu},q.focusToggleElement=function(){p.toggleElement&&p.toggleElement[0].focus()},q.$watch("isOpen",function(c,d){if(u&&p.dropdownMenu){var e=h.positionElements(b,p.dropdownMenu,"bottom-left",!0),i={top:e.top+"px",display:c?"block":"none"},l=p.dropdownMenu.hasClass("dropdown-menu-right");l?(i.left="auto",i.right=window.innerWidth-(e.left+b.prop("offsetWidth"))+"px"):(i.left=e.left+"px",i.right="auto"),p.dropdownMenu.css(i)}if(g[c?"addClass":"removeClass"](b,r).then(function(){angular.isDefined(c)&&c!==d&&t(a,{open:!!c})}),c)p.dropdownMenuTemplateUrl&&k(p.dropdownMenuTemplateUrl).then(function(a){n=q.$new(),j(a.trim())(n,function(a){var b=a;p.dropdownMenu.replaceWith(b),p.dropdownMenu=b})}),q.focusToggleElement(),f.open(q);else{if(p.dropdownMenuTemplateUrl){n&&n.$destroy();var m=angular.element('<ul class="dropdown-menu"></ul>');p.dropdownMenu.replaceWith(m),p.dropdownMenu=m}f.close(q),p.selectedOption=null}angular.isFunction(s)&&s(a,c)}),a.$on("$locationChangeSuccess",function(){"disabled"!==q.getAutoClose()&&(q.isOpen=!1)});var w=a.$on("$destroy",function(){q.$destroy()});q.$on("$destroy",w)}]).directive("dropdown",["$log","$dropdownSuppressWarning",function(a,b){return{controller:"DropdownController",link:function(c,d,e,f){b||a.warn("dropdown is now deprecated. Use uib-dropdown instead."),f.init()}}}]).directive("dropdownMenu",["$log","$dropdownSuppressWarning",function(a,b){return{restrict:"AC",require:"?^dropdown",link:function(c,d,e,f){if(f&&!angular.isDefined(e.dropdownNested)){b||a.warn("dropdown-menu is now deprecated. Use uib-dropdown-menu instead."),d.addClass("dropdown-menu");var g=e.templateUrl;g&&(f.dropdownMenuTemplateUrl=g),f.dropdownMenu||(f.dropdownMenu=d)}}}}]).directive("keyboardNav",["$log","$dropdownSuppressWarning",function(a,b){return{restrict:"A",require:"?^dropdown",link:function(c,d,e,f){b||a.warn("keyboard-nav is now deprecated. Use uib-keyboard-nav instead."),d.bind("keydown",function(a){if(-1!==[38,40].indexOf(a.which)){a.preventDefault(),a.stopPropagation();var b=f.dropdownMenu.find("a");switch(a.which){case 40:angular.isNumber(f.selectedOption)?f.selectedOption=f.selectedOption===b.length-1?f.selectedOption:f.selectedOption+1:f.selectedOption=0;break;case 38:angular.isNumber(f.selectedOption)?f.selectedOption=0===f.selectedOption?0:f.selectedOption-1:f.selectedOption=b.length-1}b[f.selectedOption].focus()}})}}}]).directive("dropdownToggle",["$log","$dropdownSuppressWarning",function(a,b){return{require:"?^dropdown",link:function(c,d,e,f){if(b||a.warn("dropdown-toggle is now deprecated. Use uib-dropdown-toggle instead."),f){d.addClass("dropdown-toggle"),f.toggleElement=d;var g=function(a){a.preventDefault(),d.hasClass("disabled")||e.disabled||c.$apply(function(){f.toggle()})};d.bind("click",g),d.attr({"aria-haspopup":!0,"aria-expanded":!1}),c.$watch(f.isOpen,function(a){d.attr("aria-expanded",!!a)}),c.$on("$destroy",function(){d.unbind("click",g)})}}}}]),angular.module("ui.bootstrap.stackedMap",[]).factory("$$stackedMap",function(){return{createNew:function(){var a=[];return{add:function(b,c){a.push({key:b,value:c})},get:function(b){for(var c=0;c<a.length;c++)if(b==a[c].key)return a[c]},keys:function(){for(var b=[],c=0;c<a.length;c++)b.push(a[c].key);return b},top:function(){return a[a.length-1]},remove:function(b){for(var c=-1,d=0;d<a.length;d++)if(b==a[d].key){c=d;break}return a.splice(c,1)[0]},removeTop:function(){return a.splice(a.length-1,1)[0]},length:function(){return a.length}}}}}),angular.module("ui.bootstrap.modal",["ui.bootstrap.stackedMap"]).factory("$$multiMap",function(){return{createNew:function(){var a={};return{entries:function(){return Object.keys(a).map(function(b){return{key:b,value:a[b]}})},get:function(b){return a[b]},hasKey:function(b){return!!a[b]},keys:function(){return Object.keys(a)},put:function(b,c){a[b]||(a[b]=[]),a[b].push(c)},remove:function(b,c){var d=a[b];if(d){var e=d.indexOf(c);-1!==e&&d.splice(e,1),d.length||delete a[b]}}}}}}).directive("uibModalBackdrop",["$animate","$injector","$uibModalStack",function(a,b,c){function d(b,d,f){d.addClass("modal-backdrop"),f.modalInClass&&(e?e(d,{addClass:f.modalInClass}).start():a.addClass(d,f.modalInClass),b.$on(c.NOW_CLOSING_EVENT,function(b,c){var g=c();e?e(d,{removeClass:f.modalInClass}).start().then(g):a.removeClass(d,f.modalInClass).then(g)}))}var e=null;return b.has("$animateCss")&&(e=b.get("$animateCss")),{replace:!0,templateUrl:"template/modal/backdrop.html",compile:function(a,b){return a.addClass(b.backdropClass),d}}}]).directive("uibModalWindow",["$uibModalStack","$q","$animate","$injector",function(a,b,c,d){var e=null;return d.has("$animateCss")&&(e=d.get("$animateCss")),{scope:{index:"@"},replace:!0,transclude:!0,templateUrl:function(a,b){return b.templateUrl||"template/modal/window.html"},link:function(d,f,g){f.addClass(g.windowClass||""),f.addClass(g.windowTopClass||""),d.size=g.size,d.close=function(b){var c=a.getTop();c&&c.value.backdrop&&"static"!==c.value.backdrop&&b.target===b.currentTarget&&(b.preventDefault(),b.stopPropagation(),a.dismiss(c.key,"backdrop click"))},f.on("click",d.close),d.$isRendered=!0;var h=b.defer();g.$observe("modalRender",function(a){"true"==a&&h.resolve()}),h.promise.then(function(){var h=null;g.modalInClass&&(h=e?e(f,{addClass:g.modalInClass}).start():c.addClass(f,g.modalInClass),d.$on(a.NOW_CLOSING_EVENT,function(a,b){var d=b();e?e(f,{removeClass:g.modalInClass}).start().then(d):c.removeClass(f,g.modalInClass).then(d)})),b.when(h).then(function(){var a=f[0].querySelector("[autofocus]");a?a.focus():f[0].focus()});var i=a.getTop();i&&a.modalRendered(i.key)})}}}]).directive("uibModalAnimationClass",function(){return{compile:function(a,b){b.modalAnimation&&a.addClass(b.uibModalAnimationClass)}}}).directive("uibModalTransclude",function(){return{link:function(a,b,c,d,e){e(a.$parent,function(a){b.empty(),b.append(a)})}}}).factory("$uibModalStack",["$animate","$timeout","$document","$compile","$rootScope","$q","$injector","$$multiMap","$$stackedMap",function(a,b,c,d,e,f,g,h,i){function j(){for(var a=-1,b=u.keys(),c=0;c<b.length;c++)u.get(b[c]).value.backdrop&&(a=c);return a}function k(a,b){var d=c.find("body").eq(0),e=u.get(a).value;u.remove(a),n(e.modalDomEl,e.modalScope,function(){var b=e.openedClass||t;v.remove(b,a),d.toggleClass(b,v.hasKey(b)),l(!0)}),m(),b&&b.focus?b.focus():d.focus()}function l(a){var b;u.length()>0&&(b=u.top().value,b.modalDomEl.toggleClass(b.windowTopClass||"",a))}function m(){if(q&&-1==j()){var a=r;n(q,r,function(){a=null}),q=void 0,r=void 0}}function n(b,c,d){function e(){e.done||(e.done=!0,p?p(b,{event:"leave"}).start().then(function(){b.remove()}):a.leave(b),c.$destroy(),d&&d())}var g,h=null,i=function(){return g||(g=f.defer(),h=g.promise),function(){g.resolve()}};return c.$broadcast(w.NOW_CLOSING_EVENT,i),f.when(h).then(e)}function o(a,b,c){return!a.value.modalScope.$broadcast("modal.closing",b,c).defaultPrevented}var p=null;g.has("$animateCss")&&(p=g.get("$animateCss"));var q,r,s,t="modal-open",u=i.createNew(),v=h.createNew(),w={NOW_CLOSING_EVENT:"modal.stack.now-closing"},x=0,y="a[href], area[href], input:not([disabled]), button:not([disabled]),select:not([disabled]), textarea:not([disabled]), iframe, object, embed, *[tabindex], *[contenteditable=true]";return e.$watch(j,function(a){r&&(r.index=a)}),c.bind("keydown",function(a){if(a.isDefaultPrevented())return a;var b=u.top();if(b&&b.value.keyboard)switch(a.which){case 27:a.preventDefault(),e.$apply(function(){w.dismiss(b.key,"escape key press")});break;case 9:w.loadFocusElementList(b);var c=!1;a.shiftKey?w.isFocusInFirstItem(a)&&(c=w.focusLastFocusableElement()):w.isFocusInLastItem(a)&&(c=w.focusFirstFocusableElement()),c&&(a.preventDefault(),a.stopPropagation())}}),w.open=function(a,b){var f=c[0].activeElement,g=b.openedClass||t;l(!1),u.add(a,{deferred:b.deferred,renderDeferred:b.renderDeferred,modalScope:b.scope,backdrop:b.backdrop,keyboard:b.keyboard,openedClass:b.openedClass,windowTopClass:b.windowTopClass}),v.put(g,a);var h=c.find("body").eq(0),i=j();if(i>=0&&!q){r=e.$new(!0),r.index=i;var k=angular.element('<div uib-modal-backdrop="modal-backdrop"></div>');k.attr("backdrop-class",b.backdropClass),b.animation&&k.attr("modal-animation","true"),q=d(k)(r),h.append(q)}var m=angular.element('<div uib-modal-window="modal-window"></div>');m.attr({"template-url":b.windowTemplateUrl,"window-class":b.windowClass,"window-top-class":b.windowTopClass,size:b.size,index:u.length()-1,animate:"animate"}).html(b.content),b.animation&&m.attr("modal-animation","true");var n=d(m)(b.scope);u.top().value.modalDomEl=n,u.top().value.modalOpener=f,h.append(n),h.addClass(g),w.clearFocusListCache()},w.close=function(a,b){var c=u.get(a);return c&&o(c,b,!0)?(c.value.modalScope.$$uibDestructionScheduled=!0,c.value.deferred.resolve(b),k(a,c.value.modalOpener),!0):!c},w.dismiss=function(a,b){var c=u.get(a);return c&&o(c,b,!1)?(c.value.modalScope.$$uibDestructionScheduled=!0,c.value.deferred.reject(b),k(a,c.value.modalOpener),!0):!c},w.dismissAll=function(a){for(var b=this.getTop();b&&this.dismiss(b.key,a);)b=this.getTop()},w.getTop=function(){return u.top()},w.modalRendered=function(a){var b=u.get(a);b&&b.value.renderDeferred.resolve()},w.focusFirstFocusableElement=function(){return s.length>0?(s[0].focus(),!0):!1},w.focusLastFocusableElement=function(){return s.length>0?(s[s.length-1].focus(),!0):!1},w.isFocusInFirstItem=function(a){return s.length>0?(a.target||a.srcElement)==s[0]:!1},w.isFocusInLastItem=function(a){return s.length>0?(a.target||a.srcElement)==s[s.length-1]:!1},w.clearFocusListCache=function(){s=[],x=0},w.loadFocusElementList=function(a){if((void 0===s||!s.length)&&a){var b=a.value.modalDomEl;b&&b.length&&(s=b[0].querySelectorAll(y))}},w}]).provider("$uibModal",function(){var a={options:{animation:!0,backdrop:!0,keyboard:!0},$get:["$injector","$rootScope","$q","$templateRequest","$controller","$uibModalStack","$modalSuppressWarning","$log",function(b,c,d,e,f,g,h,i){function j(a){return a.template?d.when(a.template):e(angular.isFunction(a.templateUrl)?a.templateUrl():a.templateUrl)}function k(a){var c=[];return angular.forEach(a,function(a){angular.isFunction(a)||angular.isArray(a)?c.push(d.when(b.invoke(a))):angular.isString(a)?c.push(d.when(b.get(a))):c.push(d.when(a))}),c}var l={},m=null;return l.getPromiseChain=function(){return m},l.open=function(b){function e(){return r}var l=d.defer(),n=d.defer(),o=d.defer(),p={result:l.promise,opened:n.promise,rendered:o.promise,close:function(a){return g.close(p,a)},dismiss:function(a){return g.dismiss(p,a)}};if(b=angular.extend({},a.options,b),b.resolve=b.resolve||{},!b.template&&!b.templateUrl)throw new Error("One of template or templateUrl options is required.");var q,r=d.all([j(b)].concat(k(b.resolve)));return q=m=d.all([m]).then(e,e).then(function(a){var d=(b.scope||c).$new();d.$close=p.close,d.$dismiss=p.dismiss,d.$on("$destroy",function(){d.$$uibDestructionScheduled||d.$dismiss("$uibUnscheduledDestruction")});var e,j={},k=1;b.controller&&(j.$scope=d,j.$uibModalInstance=p,Object.defineProperty(j,"$modalInstance",{get:function(){return h||i.warn("$modalInstance is now deprecated. Use $uibModalInstance instead."),p}}),angular.forEach(b.resolve,function(b,c){j[c]=a[k++]}),e=f(b.controller,j),b.controllerAs&&(b.bindToController&&angular.extend(e,d),d[b.controllerAs]=e)),g.open(p,{scope:d,deferred:l,renderDeferred:o,content:a[0],animation:b.animation,backdrop:b.backdrop,keyboard:b.keyboard,backdropClass:b.backdropClass,windowTopClass:b.windowTopClass,windowClass:b.windowClass,windowTemplateUrl:b.windowTemplateUrl,size:b.size,openedClass:b.openedClass}),n.resolve(!0)},function(a){n.reject(a),l.reject(a)})["finally"](function(){m===q&&(m=null)}),p},l}]};return a}),angular.module("ui.bootstrap.modal").value("$modalSuppressWarning",!1).directive("modalBackdrop",["$animate","$injector","$modalStack","$log","$modalSuppressWarning",function(a,b,c,d,e){function f(b,f,h){e||d.warn("modal-backdrop is now deprecated. Use uib-modal-backdrop instead."),f.addClass("modal-backdrop"),h.modalInClass&&(g?g(f,{addClass:h.modalInClass}).start():a.addClass(f,h.modalInClass),b.$on(c.NOW_CLOSING_EVENT,function(b,c){var d=c();g?g(f,{removeClass:h.modalInClass}).start().then(d):a.removeClass(f,h.modalInClass).then(d)}))}var g=null;return b.has("$animateCss")&&(g=b.get("$animateCss")),{replace:!0,templateUrl:"template/modal/backdrop.html",compile:function(a,b){return a.addClass(b.backdropClass),f}}}]).directive("modalWindow",["$modalStack","$q","$animate","$injector","$log","$modalSuppressWarning",function(a,b,c,d,e,f){var g=null;return d.has("$animateCss")&&(g=d.get("$animateCss")),{scope:{index:"@"},replace:!0,transclude:!0,templateUrl:function(a,b){return b.templateUrl||"template/modal/window.html"},link:function(d,h,i){f||e.warn("modal-window is now deprecated. Use uib-modal-window instead."),h.addClass(i.windowClass||""),h.addClass(i.windowTopClass||""),d.size=i.size,d.close=function(b){var c=a.getTop();c&&c.value.backdrop&&"static"!==c.value.backdrop&&b.target===b.currentTarget&&(b.preventDefault(),b.stopPropagation(),a.dismiss(c.key,"backdrop click"))},h.on("click",d.close),d.$isRendered=!0;var j=b.defer();i.$observe("modalRender",function(a){"true"==a&&j.resolve()}),j.promise.then(function(){var e=null;i.modalInClass&&(e=g?g(h,{addClass:i.modalInClass}).start():c.addClass(h,i.modalInClass),d.$on(a.NOW_CLOSING_EVENT,function(a,b){var d=b();g?g(h,{removeClass:i.modalInClass}).start().then(d):c.removeClass(h,i.modalInClass).then(d)})),b.when(e).then(function(){var a=h[0].querySelector("[autofocus]");a?a.focus():h[0].focus()});var f=a.getTop();f&&a.modalRendered(f.key)})}}}]).directive("modalAnimationClass",["$log","$modalSuppressWarning",function(a,b){return{compile:function(c,d){b||a.warn("modal-animation-class is now deprecated. Use uib-modal-animation-class instead."),d.modalAnimation&&c.addClass(d.modalAnimationClass)}}}]).directive("modalTransclude",["$log","$modalSuppressWarning",function(a,b){return{link:function(c,d,e,f,g){
b||a.warn("modal-transclude is now deprecated. Use uib-modal-transclude instead."),g(c.$parent,function(a){d.empty(),d.append(a)})}}}]).service("$modalStack",["$animate","$timeout","$document","$compile","$rootScope","$q","$injector","$$multiMap","$$stackedMap","$uibModalStack","$log","$modalSuppressWarning",function(a,b,c,d,e,f,g,h,i,j,k,l){l||k.warn("$modalStack is now deprecated. Use $uibModalStack instead."),angular.extend(this,j)}]).provider("$modal",["$uibModalProvider",function(a){angular.extend(this,a),this.$get=["$injector","$log","$modalSuppressWarning",function(b,c,d){return d||c.warn("$modal is now deprecated. Use $uibModal instead."),b.invoke(a.$get)}]}]),angular.module("ui.bootstrap.pagination",[]).controller("UibPaginationController",["$scope","$attrs","$parse",function(a,b,c){var d=this,e={$setViewValue:angular.noop},f=b.numPages?c(b.numPages).assign:angular.noop;this.init=function(g,h){e=g,this.config=h,e.$render=function(){d.render()},b.itemsPerPage?a.$parent.$watch(c(b.itemsPerPage),function(b){d.itemsPerPage=parseInt(b,10),a.totalPages=d.calculateTotalPages()}):this.itemsPerPage=h.itemsPerPage,a.$watch("totalItems",function(){a.totalPages=d.calculateTotalPages()}),a.$watch("totalPages",function(b){f(a.$parent,b),a.page>b?a.selectPage(b):e.$render()})},this.calculateTotalPages=function(){var b=this.itemsPerPage<1?1:Math.ceil(a.totalItems/this.itemsPerPage);return Math.max(b||0,1)},this.render=function(){a.page=parseInt(e.$viewValue,10)||1},a.selectPage=function(b,c){c&&c.preventDefault();var d=!a.ngDisabled||!c;d&&a.page!==b&&b>0&&b<=a.totalPages&&(c&&c.target&&c.target.blur(),e.$setViewValue(b),e.$render())},a.getText=function(b){return a[b+"Text"]||d.config[b+"Text"]},a.noPrevious=function(){return 1===a.page},a.noNext=function(){return a.page===a.totalPages}}]).constant("uibPaginationConfig",{itemsPerPage:10,boundaryLinks:!1,directionLinks:!0,firstText:"First",previousText:"Previous",nextText:"Next",lastText:"Last",rotate:!0}).directive("uibPagination",["$parse","uibPaginationConfig",function(a,b){return{restrict:"EA",scope:{totalItems:"=",firstText:"@",previousText:"@",nextText:"@",lastText:"@",ngDisabled:"="},require:["uibPagination","?ngModel"],controller:"UibPaginationController",controllerAs:"pagination",templateUrl:function(a,b){return b.templateUrl||"template/pagination/pagination.html"},replace:!0,link:function(c,d,e,f){function g(a,b,c){return{number:a,text:b,active:c}}function h(a,b){var c=[],d=1,e=b,f=angular.isDefined(k)&&b>k;f&&(l?(d=Math.max(a-Math.floor(k/2),1),e=d+k-1,e>b&&(e=b,d=e-k+1)):(d=(Math.ceil(a/k)-1)*k+1,e=Math.min(d+k-1,b)));for(var h=d;e>=h;h++){var i=g(h,h,h===a);c.push(i)}if(f&&!l){if(d>1){var j=g(d-1,"...",!1);c.unshift(j)}if(b>e){var m=g(e+1,"...",!1);c.push(m)}}return c}var i=f[0],j=f[1];if(j){var k=angular.isDefined(e.maxSize)?c.$parent.$eval(e.maxSize):b.maxSize,l=angular.isDefined(e.rotate)?c.$parent.$eval(e.rotate):b.rotate;c.boundaryLinks=angular.isDefined(e.boundaryLinks)?c.$parent.$eval(e.boundaryLinks):b.boundaryLinks,c.directionLinks=angular.isDefined(e.directionLinks)?c.$parent.$eval(e.directionLinks):b.directionLinks,i.init(j,b),e.maxSize&&c.$parent.$watch(a(e.maxSize),function(a){k=parseInt(a,10),i.render()});var m=i.render;i.render=function(){m(),c.page>0&&c.page<=c.totalPages&&(c.pages=h(c.page,c.totalPages))}}}}}]).constant("uibPagerConfig",{itemsPerPage:10,previousText:"« Previous",nextText:"Next »",align:!0}).directive("uibPager",["uibPagerConfig",function(a){return{restrict:"EA",scope:{totalItems:"=",previousText:"@",nextText:"@",ngDisabled:"="},require:["uibPager","?ngModel"],controller:"UibPaginationController",controllerAs:"pagination",templateUrl:function(a,b){return b.templateUrl||"template/pagination/pager.html"},replace:!0,link:function(b,c,d,e){var f=e[0],g=e[1];g&&(b.align=angular.isDefined(d.align)?b.$parent.$eval(d.align):a.align,f.init(g,a))}}}]),angular.module("ui.bootstrap.pagination").value("$paginationSuppressWarning",!1).controller("PaginationController",["$scope","$attrs","$parse","$log","$paginationSuppressWarning",function(a,b,c,d,e){e||d.warn("PaginationController is now deprecated. Use UibPaginationController instead.");var f=this,g={$setViewValue:angular.noop},h=b.numPages?c(b.numPages).assign:angular.noop;this.init=function(d,e){g=d,this.config=e,g.$render=function(){f.render()},b.itemsPerPage?a.$parent.$watch(c(b.itemsPerPage),function(b){f.itemsPerPage=parseInt(b,10),a.totalPages=f.calculateTotalPages()}):this.itemsPerPage=e.itemsPerPage,a.$watch("totalItems",function(){a.totalPages=f.calculateTotalPages()}),a.$watch("totalPages",function(b){h(a.$parent,b),a.page>b?a.selectPage(b):g.$render()})},this.calculateTotalPages=function(){var b=this.itemsPerPage<1?1:Math.ceil(a.totalItems/this.itemsPerPage);return Math.max(b||0,1)},this.render=function(){a.page=parseInt(g.$viewValue,10)||1},a.selectPage=function(b,c){c&&c.preventDefault();var d=!a.ngDisabled||!c;d&&a.page!==b&&b>0&&b<=a.totalPages&&(c&&c.target&&c.target.blur(),g.$setViewValue(b),g.$render())},a.getText=function(b){return a[b+"Text"]||f.config[b+"Text"]},a.noPrevious=function(){return 1===a.page},a.noNext=function(){return a.page===a.totalPages}}]).directive("pagination",["$parse","uibPaginationConfig","$log","$paginationSuppressWarning",function(a,b,c,d){return{restrict:"EA",scope:{totalItems:"=",firstText:"@",previousText:"@",nextText:"@",lastText:"@",ngDisabled:"="},require:["pagination","?ngModel"],controller:"PaginationController",controllerAs:"pagination",templateUrl:function(a,b){return b.templateUrl||"template/pagination/pagination.html"},replace:!0,link:function(e,f,g,h){function i(a,b,c){return{number:a,text:b,active:c}}function j(a,b){var c=[],d=1,e=b,f=angular.isDefined(m)&&b>m;f&&(n?(d=Math.max(a-Math.floor(m/2),1),e=d+m-1,e>b&&(e=b,d=e-m+1)):(d=(Math.ceil(a/m)-1)*m+1,e=Math.min(d+m-1,b)));for(var g=d;e>=g;g++){var h=i(g,g,g===a);c.push(h)}if(f&&!n){if(d>1){var j=i(d-1,"...",!1);c.unshift(j)}if(b>e){var k=i(e+1,"...",!1);c.push(k)}}return c}d||c.warn("pagination is now deprecated. Use uib-pagination instead.");var k=h[0],l=h[1];if(l){var m=angular.isDefined(g.maxSize)?e.$parent.$eval(g.maxSize):b.maxSize,n=angular.isDefined(g.rotate)?e.$parent.$eval(g.rotate):b.rotate;e.boundaryLinks=angular.isDefined(g.boundaryLinks)?e.$parent.$eval(g.boundaryLinks):b.boundaryLinks,e.directionLinks=angular.isDefined(g.directionLinks)?e.$parent.$eval(g.directionLinks):b.directionLinks,k.init(l,b),g.maxSize&&e.$parent.$watch(a(g.maxSize),function(a){m=parseInt(a,10),k.render()});var o=k.render;k.render=function(){o(),e.page>0&&e.page<=e.totalPages&&(e.pages=j(e.page,e.totalPages))}}}}}]).directive("pager",["uibPagerConfig","$log","$paginationSuppressWarning",function(a,b,c){return{restrict:"EA",scope:{totalItems:"=",previousText:"@",nextText:"@",ngDisabled:"="},require:["pager","?ngModel"],controller:"PaginationController",controllerAs:"pagination",templateUrl:function(a,b){return b.templateUrl||"template/pagination/pager.html"},replace:!0,link:function(d,e,f,g){c||b.warn("pager is now deprecated. Use uib-pager instead.");var h=g[0],i=g[1];i&&(d.align=angular.isDefined(f.align)?d.$parent.$eval(f.align):a.align,h.init(i,a))}}}]),angular.module("ui.bootstrap.tooltip",["ui.bootstrap.position","ui.bootstrap.stackedMap"]).provider("$uibTooltip",function(){function a(a){var b=/[A-Z]/g,c="-";return a.replace(b,function(a,b){return(b?c:"")+a.toLowerCase()})}var b={placement:"top",animation:!0,popupDelay:0,popupCloseDelay:0,useContentExp:!1},c={mouseenter:"mouseleave",click:"click",focus:"blur",none:""},d={};this.options=function(a){angular.extend(d,a)},this.setTriggers=function(a){angular.extend(c,a)},this.$get=["$window","$compile","$timeout","$document","$uibPosition","$interpolate","$rootScope","$parse","$$stackedMap",function(e,f,g,h,i,j,k,l,m){var n=m.createNew();return h.on("keypress",function(a){if(27===a.which){var b=n.top();b&&(b.value.close(),n.removeTop(),b=null)}}),function(e,k,m,o){function p(a){var b=(a||o.trigger||m).split(" "),d=b.map(function(a){return c[a]||a});return{show:b,hide:d}}o=angular.extend({},b,d,o);var q=a(e),r=j.startSymbol(),s=j.endSymbol(),t="<div "+q+'-popup title="'+r+"title"+s+'" '+(o.useContentExp?'content-exp="contentExp()" ':'content="'+r+"content"+s+'" ')+'placement="'+r+"placement"+s+'" popup-class="'+r+"popupClass"+s+'" animation="animation" is-open="isOpen"origin-scope="origScope" style="visibility: hidden; display: block; top: -9999px; left: -9999px;"></div>';return{compile:function(a,b){var c=f(t);return function(a,b,d,f){function j(){L.isOpen?q():m()}function m(){(!K||a.$eval(d[k+"Enable"]))&&(u(),x(),L.popupDelay?F||(F=g(r,L.popupDelay,!1)):r())}function q(){s(),L.popupCloseDelay?G||(G=g(t,L.popupCloseDelay,!1)):t()}function r(){return s(),u(),L.content?(v(),void L.$evalAsync(function(){L.isOpen=!0,y(!0),Q()})):angular.noop}function s(){F&&(g.cancel(F),F=null),H&&(g.cancel(H),H=null)}function t(){s(),u(),L&&L.$evalAsync(function(){L.isOpen=!1,y(!1),L.animation?E||(E=g(w,150,!1)):w()})}function u(){G&&(g.cancel(G),G=null),E&&(g.cancel(E),E=null)}function v(){C||(D=L.$new(),C=c(D,function(a){I?h.find("body").append(a):b.after(a)}),z())}function w(){A(),E=null,C&&(C.remove(),C=null),D&&(D.$destroy(),D=null)}function x(){L.title=d[k+"Title"],O?L.content=O(a):L.content=d[e],L.popupClass=d[k+"Class"],L.placement=angular.isDefined(d[k+"Placement"])?d[k+"Placement"]:o.placement;var b=parseInt(d[k+"PopupDelay"],10),c=parseInt(d[k+"PopupCloseDelay"],10);L.popupDelay=isNaN(b)?o.popupDelay:b,L.popupCloseDelay=isNaN(c)?o.popupCloseDelay:c}function y(b){N&&angular.isFunction(N.assign)&&N.assign(a,b)}function z(){P.length=0,O?(P.push(a.$watch(O,function(a){L.content=a,!a&&L.isOpen&&t()})),P.push(D.$watch(function(){M||(M=!0,D.$$postDigest(function(){M=!1,L&&L.isOpen&&Q()}))}))):P.push(d.$observe(e,function(a){L.content=a,!a&&L.isOpen?t():Q()})),P.push(d.$observe(k+"Title",function(a){L.title=a,L.isOpen&&Q()})),P.push(d.$observe(k+"Placement",function(a){L.placement=a?a:o.placement,L.isOpen&&Q()}))}function A(){P.length&&(angular.forEach(P,function(a){a()}),P.length=0)}function B(){var a=d[k+"Trigger"];R(),J=p(a),"none"!==J.show&&J.show.forEach(function(a,c){a===J.hide[c]?b[0].addEventListener(a,j):a&&(b[0].addEventListener(a,m),J.hide[c].split(" ").forEach(function(a){b[0].addEventListener(a,q)})),b.on("keypress",function(a){27===a.which&&q()})})}var C,D,E,F,G,H,I=angular.isDefined(o.appendToBody)?o.appendToBody:!1,J=p(void 0),K=angular.isDefined(d[k+"Enable"]),L=a.$new(!0),M=!1,N=angular.isDefined(d[k+"IsOpen"])?l(d[k+"IsOpen"]):!1,O=o.useContentExp?l(d[e]):!1,P=[],Q=function(){C&&C.html()&&(H||(H=g(function(){C.css({top:0,left:0});var a=i.positionElements(b,C,L.placement,I);a.top+="px",a.left+="px",a.visibility="visible",C.css(a),H=null},0,!1)))};L.origScope=a,L.isOpen=!1,n.add(L,{close:t}),L.contentExp=function(){return L.content},d.$observe("disabled",function(a){a&&s(),a&&L.isOpen&&t()}),N&&a.$watch(N,function(a){L&&!a===L.isOpen&&j()});var R=function(){J.show.forEach(function(a){b.unbind(a,m)}),J.hide.forEach(function(a){a.split(" ").forEach(function(a){b[0].removeEventListener(a,q)})})};B();var S=a.$eval(d[k+"Animation"]);L.animation=angular.isDefined(S)?!!S:o.animation;var T=a.$eval(d[k+"AppendToBody"]);I=angular.isDefined(T)?T:I,I&&a.$on("$locationChangeSuccess",function(){L.isOpen&&t()}),a.$on("$destroy",function(){s(),u(),R(),w(),n.remove(L),L=null})}}}}}]}).directive("uibTooltipTemplateTransclude",["$animate","$sce","$compile","$templateRequest",function(a,b,c,d){return{link:function(e,f,g){var h,i,j,k=e.$eval(g.tooltipTemplateTranscludeScope),l=0,m=function(){i&&(i.remove(),i=null),h&&(h.$destroy(),h=null),j&&(a.leave(j).then(function(){i=null}),i=j,j=null)};e.$watch(b.parseAsResourceUrl(g.uibTooltipTemplateTransclude),function(b){var g=++l;b?(d(b,!0).then(function(d){if(g===l){var e=k.$new(),i=d,n=c(i)(e,function(b){m(),a.enter(b,f)});h=e,j=n,h.$emit("$includeContentLoaded",b)}},function(){g===l&&(m(),e.$emit("$includeContentError",b))}),e.$emit("$includeContentRequested",b)):m()}),e.$on("$destroy",m)}}}]).directive("uibTooltipClasses",function(){return{restrict:"A",link:function(a,b,c){a.placement&&b.addClass(a.placement),a.popupClass&&b.addClass(a.popupClass),a.animation()&&b.addClass(c.tooltipAnimationClass)}}}).directive("uibTooltipPopup",function(){return{replace:!0,scope:{content:"@",placement:"@",popupClass:"@",animation:"&",isOpen:"&"},templateUrl:"template/tooltip/tooltip-popup.html",link:function(a,b){b.addClass("tooltip")}}}).directive("uibTooltip",["$uibTooltip",function(a){return a("uibTooltip","tooltip","mouseenter")}]).directive("uibTooltipTemplatePopup",function(){return{replace:!0,scope:{contentExp:"&",placement:"@",popupClass:"@",animation:"&",isOpen:"&",originScope:"&"},templateUrl:"template/tooltip/tooltip-template-popup.html",link:function(a,b){b.addClass("tooltip")}}}).directive("uibTooltipTemplate",["$uibTooltip",function(a){return a("uibTooltipTemplate","tooltip","mouseenter",{useContentExp:!0})}]).directive("uibTooltipHtmlPopup",function(){return{replace:!0,scope:{contentExp:"&",placement:"@",popupClass:"@",animation:"&",isOpen:"&"},templateUrl:"template/tooltip/tooltip-html-popup.html",link:function(a,b){b.addClass("tooltip")}}}).directive("uibTooltipHtml",["$uibTooltip",function(a){return a("uibTooltipHtml","tooltip","mouseenter",{useContentExp:!0})}]),angular.module("ui.bootstrap.tooltip").value("$tooltipSuppressWarning",!1).provider("$tooltip",["$uibTooltipProvider",function(a){angular.extend(this,a),this.$get=["$log","$tooltipSuppressWarning","$injector",function(b,c,d){return c||b.warn("$tooltip is now deprecated. Use $uibTooltip instead."),d.invoke(a.$get)}]}]).directive("tooltipTemplateTransclude",["$animate","$sce","$compile","$templateRequest","$log","$tooltipSuppressWarning",function(a,b,c,d,e,f){return{link:function(g,h,i){f||e.warn("tooltip-template-transclude is now deprecated. Use uib-tooltip-template-transclude instead.");var j,k,l,m=g.$eval(i.tooltipTemplateTranscludeScope),n=0,o=function(){k&&(k.remove(),k=null),j&&(j.$destroy(),j=null),l&&(a.leave(l).then(function(){k=null}),k=l,l=null)};g.$watch(b.parseAsResourceUrl(i.tooltipTemplateTransclude),function(b){var e=++n;b?(d(b,!0).then(function(d){if(e===n){var f=m.$new(),g=d,i=c(g)(f,function(b){o(),a.enter(b,h)});j=f,l=i,j.$emit("$includeContentLoaded",b)}},function(){e===n&&(o(),g.$emit("$includeContentError",b))}),g.$emit("$includeContentRequested",b)):o()}),g.$on("$destroy",o)}}}]).directive("tooltipClasses",["$log","$tooltipSuppressWarning",function(a,b){return{restrict:"A",link:function(c,d,e){b||a.warn("tooltip-classes is now deprecated. Use uib-tooltip-classes instead."),c.placement&&d.addClass(c.placement),c.popupClass&&d.addClass(c.popupClass),c.animation()&&d.addClass(e.tooltipAnimationClass)}}}]).directive("tooltipPopup",["$log","$tooltipSuppressWarning",function(a,b){return{replace:!0,scope:{content:"@",placement:"@",popupClass:"@",animation:"&",isOpen:"&"},templateUrl:"template/tooltip/tooltip-popup.html",link:function(c,d){b||a.warn("tooltip-popup is now deprecated. Use uib-tooltip-popup instead."),d.addClass("tooltip")}}}]).directive("tooltip",["$tooltip",function(a){return a("tooltip","tooltip","mouseenter")}]).directive("tooltipTemplatePopup",["$log","$tooltipSuppressWarning",function(a,b){return{replace:!0,scope:{contentExp:"&",placement:"@",popupClass:"@",animation:"&",isOpen:"&",originScope:"&"},templateUrl:"template/tooltip/tooltip-template-popup.html",link:function(c,d){b||a.warn("tooltip-template-popup is now deprecated. Use uib-tooltip-template-popup instead."),d.addClass("tooltip")}}}]).directive("tooltipTemplate",["$tooltip",function(a){return a("tooltipTemplate","tooltip","mouseenter",{useContentExp:!0})}]).directive("tooltipHtmlPopup",["$log","$tooltipSuppressWarning",function(a,b){return{replace:!0,scope:{contentExp:"&",placement:"@",popupClass:"@",animation:"&",isOpen:"&"},templateUrl:"template/tooltip/tooltip-html-popup.html",link:function(c,d){b||a.warn("tooltip-html-popup is now deprecated. Use uib-tooltip-html-popup instead."),d.addClass("tooltip")}}}]).directive("tooltipHtml",["$tooltip",function(a){return a("tooltipHtml","tooltip","mouseenter",{useContentExp:!0})}]),angular.module("ui.bootstrap.popover",["ui.bootstrap.tooltip"]).directive("uibPopoverTemplatePopup",function(){return{replace:!0,scope:{title:"@",contentExp:"&",placement:"@",popupClass:"@",animation:"&",isOpen:"&",originScope:"&"},templateUrl:"template/popover/popover-template.html",link:function(a,b){b.addClass("popover")}}}).directive("uibPopoverTemplate",["$uibTooltip",function(a){return a("uibPopoverTemplate","popover","click",{useContentExp:!0})}]).directive("uibPopoverHtmlPopup",function(){return{replace:!0,scope:{contentExp:"&",title:"@",placement:"@",popupClass:"@",animation:"&",isOpen:"&"},templateUrl:"template/popover/popover-html.html",link:function(a,b){b.addClass("popover")}}}).directive("uibPopoverHtml",["$uibTooltip",function(a){return a("uibPopoverHtml","popover","click",{useContentExp:!0})}]).directive("uibPopoverPopup",function(){return{replace:!0,scope:{title:"@",content:"@",placement:"@",popupClass:"@",animation:"&",isOpen:"&"},templateUrl:"template/popover/popover.html",link:function(a,b){b.addClass("popover")}}}).directive("uibPopover",["$uibTooltip",function(a){return a("uibPopover","popover","click")}]),angular.module("ui.bootstrap.popover").value("$popoverSuppressWarning",!1).directive("popoverTemplatePopup",["$log","$popoverSuppressWarning",function(a,b){return{replace:!0,scope:{title:"@",contentExp:"&",placement:"@",popupClass:"@",animation:"&",isOpen:"&",originScope:"&"},templateUrl:"template/popover/popover-template.html",link:function(c,d){b||a.warn("popover-template-popup is now deprecated. Use uib-popover-template-popup instead."),d.addClass("popover")}}}]).directive("popoverTemplate",["$tooltip",function(a){return a("popoverTemplate","popover","click",{useContentExp:!0})}]).directive("popoverHtmlPopup",["$log","$popoverSuppressWarning",function(a,b){return{replace:!0,scope:{contentExp:"&",title:"@",placement:"@",popupClass:"@",animation:"&",isOpen:"&"},templateUrl:"template/popover/popover-html.html",link:function(c,d){b||a.warn("popover-html-popup is now deprecated. Use uib-popover-html-popup instead."),d.addClass("popover")}}}]).directive("popoverHtml",["$tooltip",function(a){return a("popoverHtml","popover","click",{useContentExp:!0})}]).directive("popoverPopup",["$log","$popoverSuppressWarning",function(a,b){return{replace:!0,scope:{title:"@",content:"@",placement:"@",popupClass:"@",animation:"&",isOpen:"&"},templateUrl:"template/popover/popover.html",link:function(c,d){b||a.warn("popover-popup is now deprecated. Use uib-popover-popup instead."),d.addClass("popover")}}}]).directive("popover",["$tooltip",function(a){return a("popover","popover","click")}]),angular.module("ui.bootstrap.progressbar",[]).constant("uibProgressConfig",{animate:!0,max:100}).controller("UibProgressController",["$scope","$attrs","uibProgressConfig",function(a,b,c){var d=this,e=angular.isDefined(b.animate)?a.$parent.$eval(b.animate):c.animate;this.bars=[],a.max=angular.isDefined(a.max)?a.max:c.max,this.addBar=function(b,c,f){e||c.css({transition:"none"}),this.bars.push(b),b.max=a.max,b.title=f&&angular.isDefined(f.title)?f.title:"progressbar",b.$watch("value",function(a){b.recalculatePercentage()}),b.recalculatePercentage=function(){var a=d.bars.reduce(function(a,b){return b.percent=+(100*b.value/b.max).toFixed(2),a+b.percent},0);a>100&&(b.percent-=a-100)},b.$on("$destroy",function(){c=null,d.removeBar(b)})},this.removeBar=function(a){this.bars.splice(this.bars.indexOf(a),1),this.bars.forEach(function(a){a.recalculatePercentage()})},a.$watch("max",function(b){d.bars.forEach(function(b){b.max=a.max,b.recalculatePercentage()})})}]).directive("uibProgress",function(){return{replace:!0,transclude:!0,controller:"UibProgressController",require:"uibProgress",scope:{max:"=?"},templateUrl:"template/progressbar/progress.html"}}).directive("uibBar",function(){return{replace:!0,transclude:!0,require:"^uibProgress",scope:{value:"=",type:"@"},templateUrl:"template/progressbar/bar.html",link:function(a,b,c,d){d.addBar(a,b,c)}}}).directive("uibProgressbar",function(){return{replace:!0,transclude:!0,controller:"UibProgressController",scope:{value:"=",max:"=?",type:"@"},templateUrl:"template/progressbar/progressbar.html",link:function(a,b,c,d){d.addBar(a,angular.element(b.children()[0]),{title:c.title})}}}),angular.module("ui.bootstrap.progressbar").value("$progressSuppressWarning",!1).controller("ProgressController",["$scope","$attrs","uibProgressConfig","$log","$progressSuppressWarning",function(a,b,c,d,e){e||d.warn("ProgressController is now deprecated. Use UibProgressController instead.");var f=this,g=angular.isDefined(b.animate)?a.$parent.$eval(b.animate):c.animate;this.bars=[],a.max=angular.isDefined(a.max)?a.max:c.max,this.addBar=function(b,c,d){g||c.css({transition:"none"}),this.bars.push(b),b.max=a.max,b.title=d&&angular.isDefined(d.title)?d.title:"progressbar",b.$watch("value",function(a){b.recalculatePercentage()}),b.recalculatePercentage=function(){b.percent=+(100*b.value/b.max).toFixed(2);var a=f.bars.reduce(function(a,b){return a+b.percent},0);a>100&&(b.percent-=a-100)},b.$on("$destroy",function(){c=null,f.removeBar(b)})},this.removeBar=function(a){this.bars.splice(this.bars.indexOf(a),1)},a.$watch("max",function(b){f.bars.forEach(function(b){b.max=a.max,b.recalculatePercentage()})})}]).directive("progress",["$log","$progressSuppressWarning",function(a,b){return{replace:!0,transclude:!0,controller:"ProgressController",require:"progress",scope:{max:"=?",title:"@?"},templateUrl:"template/progressbar/progress.html",link:function(){b||a.warn("progress is now deprecated. Use uib-progress instead.")}}}]).directive("bar",["$log","$progressSuppressWarning",function(a,b){return{replace:!0,transclude:!0,require:"^progress",scope:{value:"=",type:"@"},templateUrl:"template/progressbar/bar.html",link:function(c,d,e,f){b||a.warn("bar is now deprecated. Use uib-bar instead."),f.addBar(c,d)}}}]).directive("progressbar",["$log","$progressSuppressWarning",function(a,b){return{replace:!0,transclude:!0,controller:"ProgressController",scope:{value:"=",max:"=?",type:"@"},templateUrl:"template/progressbar/progressbar.html",link:function(c,d,e,f){b||a.warn("progressbar is now deprecated. Use uib-progressbar instead."),f.addBar(c,angular.element(d.children()[0]),{title:e.title})}}}]),angular.module("ui.bootstrap.rating",[]).constant("uibRatingConfig",{max:5,stateOn:null,stateOff:null,titles:["one","two","three","four","five"]}).controller("UibRatingController",["$scope","$attrs","uibRatingConfig",function(a,b,c){var d={$setViewValue:angular.noop};this.init=function(e){d=e,d.$render=this.render,d.$formatters.push(function(a){return angular.isNumber(a)&&a<<0!==a&&(a=Math.round(a)),a}),this.stateOn=angular.isDefined(b.stateOn)?a.$parent.$eval(b.stateOn):c.stateOn,this.stateOff=angular.isDefined(b.stateOff)?a.$parent.$eval(b.stateOff):c.stateOff;var f=angular.isDefined(b.titles)?a.$parent.$eval(b.titles):c.titles;this.titles=angular.isArray(f)&&f.length>0?f:c.titles;var g=angular.isDefined(b.ratingStates)?a.$parent.$eval(b.ratingStates):new Array(angular.isDefined(b.max)?a.$parent.$eval(b.max):c.max);a.range=this.buildTemplateObjects(g)},this.buildTemplateObjects=function(a){for(var b=0,c=a.length;c>b;b++)a[b]=angular.extend({index:b},{stateOn:this.stateOn,stateOff:this.stateOff,title:this.getTitle(b)},a[b]);return a},this.getTitle=function(a){return a>=this.titles.length?a+1:this.titles[a]},a.rate=function(b){!a.readonly&&b>=0&&b<=a.range.length&&(d.$setViewValue(d.$viewValue===b?0:b),d.$render())},a.enter=function(b){a.readonly||(a.value=b),a.onHover({value:b})},a.reset=function(){a.value=d.$viewValue,a.onLeave()},a.onKeydown=function(b){/(37|38|39|40)/.test(b.which)&&(b.preventDefault(),b.stopPropagation(),a.rate(a.value+(38===b.which||39===b.which?1:-1)))},this.render=function(){a.value=d.$viewValue}}]).directive("uibRating",function(){return{require:["uibRating","ngModel"],scope:{readonly:"=?",onHover:"&",onLeave:"&"},controller:"UibRatingController",templateUrl:"template/rating/rating.html",replace:!0,link:function(a,b,c,d){var e=d[0],f=d[1];e.init(f)}}}),angular.module("ui.bootstrap.rating").value("$ratingSuppressWarning",!1).controller("RatingController",["$scope","$attrs","$controller","$log","$ratingSuppressWarning",function(a,b,c,d,e){e||d.warn("RatingController is now deprecated. Use UibRatingController instead."),angular.extend(this,c("UibRatingController",{$scope:a,$attrs:b}))}]).directive("rating",["$log","$ratingSuppressWarning",function(a,b){return{require:["rating","ngModel"],scope:{readonly:"=?",onHover:"&",onLeave:"&"},controller:"RatingController",templateUrl:"template/rating/rating.html",replace:!0,link:function(c,d,e,f){b||a.warn("rating is now deprecated. Use uib-rating instead.");var g=f[0],h=f[1];g.init(h)}}}]),angular.module("ui.bootstrap.tabs",[]).controller("UibTabsetController",["$scope",function(a){var b=this,c=b.tabs=a.tabs=[];b.select=function(a){angular.forEach(c,function(b){b.active&&b!==a&&(b.active=!1,b.onDeselect(),a.selectCalled=!1)}),a.active=!0,a.selectCalled||(a.onSelect(),a.selectCalled=!0)},b.addTab=function(a){c.push(a),1===c.length&&a.active!==!1?a.active=!0:a.active?b.select(a):a.active=!1},b.removeTab=function(a){var e=c.indexOf(a);if(a.active&&c.length>1&&!d){var f=e==c.length-1?e-1:e+1;b.select(c[f])}c.splice(e,1)};var d;a.$on("$destroy",function(){d=!0})}]).directive("uibTabset",function(){return{restrict:"EA",transclude:!0,replace:!0,scope:{type:"@"},controller:"UibTabsetController",templateUrl:"template/tabs/tabset.html",link:function(a,b,c){a.vertical=angular.isDefined(c.vertical)?a.$parent.$eval(c.vertical):!1,a.justified=angular.isDefined(c.justified)?a.$parent.$eval(c.justified):!1}}}).directive("uibTab",["$parse",function(a){return{require:"^uibTabset",restrict:"EA",replace:!0,templateUrl:"template/tabs/tab.html",transclude:!0,scope:{active:"=?",heading:"@",onSelect:"&select",onDeselect:"&deselect"},controller:function(){},link:function(b,c,d,e,f){b.$watch("active",function(a){a&&e.select(b)}),b.disabled=!1,d.disable&&b.$parent.$watch(a(d.disable),function(a){b.disabled=!!a}),b.select=function(){b.disabled||(b.active=!0)},e.addTab(b),b.$on("$destroy",function(){e.removeTab(b)}),b.$transcludeFn=f}}}]).directive("uibTabHeadingTransclude",function(){return{restrict:"A",require:["?^uibTab","?^tab"],link:function(a,b){a.$watch("headingElement",function(a){a&&(b.html(""),b.append(a))})}}}).directive("uibTabContentTransclude",function(){function a(a){return a.tagName&&(a.hasAttribute("tab-heading")||a.hasAttribute("data-tab-heading")||a.hasAttribute("x-tab-heading")||a.hasAttribute("uib-tab-heading")||a.hasAttribute("data-uib-tab-heading")||a.hasAttribute("x-uib-tab-heading")||"tab-heading"===a.tagName.toLowerCase()||"data-tab-heading"===a.tagName.toLowerCase()||"x-tab-heading"===a.tagName.toLowerCase()||"uib-tab-heading"===a.tagName.toLowerCase()||"data-uib-tab-heading"===a.tagName.toLowerCase()||"x-uib-tab-heading"===a.tagName.toLowerCase())}return{restrict:"A",require:["?^uibTabset","?^tabset"],link:function(b,c,d){var e=b.$eval(d.uibTabContentTransclude);e.$transcludeFn(e.$parent,function(b){angular.forEach(b,function(b){a(b)?e.headingElement=b:c.append(b)})})}}}),angular.module("ui.bootstrap.tabs").value("$tabsSuppressWarning",!1).controller("TabsetController",["$scope","$controller","$log","$tabsSuppressWarning",function(a,b,c,d){d||c.warn("TabsetController is now deprecated. Use UibTabsetController instead."),angular.extend(this,b("UibTabsetController",{$scope:a}))}]).directive("tabset",["$log","$tabsSuppressWarning",function(a,b){return{restrict:"EA",transclude:!0,replace:!0,scope:{type:"@"},controller:"TabsetController",templateUrl:"template/tabs/tabset.html",link:function(c,d,e){b||a.warn("tabset is now deprecated. Use uib-tabset instead."),c.vertical=angular.isDefined(e.vertical)?c.$parent.$eval(e.vertical):!1,c.justified=angular.isDefined(e.justified)?c.$parent.$eval(e.justified):!1}}}]).directive("tab",["$parse","$log","$tabsSuppressWarning",function(a,b,c){return{require:"^tabset",restrict:"EA",replace:!0,templateUrl:"template/tabs/tab.html",transclude:!0,scope:{active:"=?",heading:"@",onSelect:"&select",onDeselect:"&deselect"},controller:function(){},link:function(d,e,f,g,h){c||b.warn("tab is now deprecated. Use uib-tab instead."),d.$watch("active",function(a){a&&g.select(d)}),d.disabled=!1,f.disable&&d.$parent.$watch(a(f.disable),function(a){d.disabled=!!a}),d.select=function(){d.disabled||(d.active=!0)},g.addTab(d),d.$on("$destroy",function(){g.removeTab(d)}),d.$transcludeFn=h}}}]).directive("tabHeadingTransclude",["$log","$tabsSuppressWarning",function(a,b){return{restrict:"A",require:"^tab",link:function(c,d){b||a.warn("tab-heading-transclude is now deprecated. Use uib-tab-heading-transclude instead."),c.$watch("headingElement",function(a){a&&(d.html(""),d.append(a))})}}}]).directive("tabContentTransclude",["$log","$tabsSuppressWarning",function(a,b){function c(a){return a.tagName&&(a.hasAttribute("tab-heading")||a.hasAttribute("data-tab-heading")||a.hasAttribute("x-tab-heading")||"tab-heading"===a.tagName.toLowerCase()||"data-tab-heading"===a.tagName.toLowerCase()||"x-tab-heading"===a.tagName.toLowerCase())}return{restrict:"A",require:"^tabset",link:function(d,e,f){b||a.warn("tab-content-transclude is now deprecated. Use uib-tab-content-transclude instead.");var g=d.$eval(f.tabContentTransclude);g.$transcludeFn(g.$parent,function(a){angular.forEach(a,function(a){c(a)?g.headingElement=a:e.append(a)})})}}}]),angular.module("ui.bootstrap.timepicker",[]).constant("uibTimepickerConfig",{hourStep:1,minuteStep:1,showMeridian:!0,meridians:null,readonlyInput:!1,mousewheel:!0,arrowkeys:!0,showSpinners:!0}).controller("UibTimepickerController",["$scope","$element","$attrs","$parse","$log","$locale","uibTimepickerConfig",function(a,b,c,d,e,f,g){function h(){var b=parseInt(a.hours,10),c=a.showMeridian?b>0&&13>b:b>=0&&24>b;return c?(a.showMeridian&&(12===b&&(b=0),a.meridian===r[1]&&(b+=12)),b):void 0}function i(){var b=parseInt(a.minutes,10);return b>=0&&60>b?b:void 0}function j(a){return angular.isDefined(a)&&a.toString().length<2?"0"+a:a.toString()}function k(a){l(),q.$setViewValue(new Date(p)),m(a)}function l(){q.$setValidity("time",!0),a.invalidHours=!1,a.invalidMinutes=!1}function m(b){var c=p.getHours(),d=p.getMinutes();a.showMeridian&&(c=0===c||12===c?12:c%12),a.hours="h"===b?c:j(c),"m"!==b&&(a.minutes=j(d)),a.meridian=p.getHours()<12?r[0]:r[1]}function n(a,b){var c=new Date(a.getTime()+6e4*b),d=new Date(a);return d.setHours(c.getHours(),c.getMinutes()),d}function o(a){p=n(p,a),k()}var p=new Date,q={$setViewValue:angular.noop},r=angular.isDefined(c.meridians)?a.$parent.$eval(c.meridians):g.meridians||f.DATETIME_FORMATS.AMPMS;a.tabindex=angular.isDefined(c.tabindex)?c.tabindex:0,b.removeAttr("tabindex"),this.init=function(b,d){q=b,q.$render=this.render,q.$formatters.unshift(function(a){return a?new Date(a):null});var e=d.eq(0),f=d.eq(1),h=angular.isDefined(c.mousewheel)?a.$parent.$eval(c.mousewheel):g.mousewheel;h&&this.setupMousewheelEvents(e,f);var i=angular.isDefined(c.arrowkeys)?a.$parent.$eval(c.arrowkeys):g.arrowkeys;i&&this.setupArrowkeyEvents(e,f),a.readonlyInput=angular.isDefined(c.readonlyInput)?a.$parent.$eval(c.readonlyInput):g.readonlyInput,this.setupInputEvents(e,f)};var s=g.hourStep;c.hourStep&&a.$parent.$watch(d(c.hourStep),function(a){s=parseInt(a,10)});var t=g.minuteStep;c.minuteStep&&a.$parent.$watch(d(c.minuteStep),function(a){t=parseInt(a,10)});var u;a.$parent.$watch(d(c.min),function(a){var b=new Date(a);u=isNaN(b)?void 0:b});var v;a.$parent.$watch(d(c.max),function(a){var b=new Date(a);v=isNaN(b)?void 0:b}),a.noIncrementHours=function(){var a=n(p,60*s);
return a>v||p>a&&u>a},a.noDecrementHours=function(){var a=n(p,60*-s);return u>a||a>p&&a>v},a.noIncrementMinutes=function(){var a=n(p,t);return a>v||p>a&&u>a},a.noDecrementMinutes=function(){var a=n(p,-t);return u>a||a>p&&a>v},a.noToggleMeridian=function(){return p.getHours()<13?n(p,720)>v:n(p,-720)<u},a.showMeridian=g.showMeridian,c.showMeridian&&a.$parent.$watch(d(c.showMeridian),function(b){if(a.showMeridian=!!b,q.$error.time){var c=h(),d=i();angular.isDefined(c)&&angular.isDefined(d)&&(p.setHours(c),k())}else m()}),this.setupMousewheelEvents=function(b,c){var d=function(a){a.originalEvent&&(a=a.originalEvent);var b=a.wheelDelta?a.wheelDelta:-a.deltaY;return a.detail||b>0};b.bind("mousewheel wheel",function(b){a.$apply(d(b)?a.incrementHours():a.decrementHours()),b.preventDefault()}),c.bind("mousewheel wheel",function(b){a.$apply(d(b)?a.incrementMinutes():a.decrementMinutes()),b.preventDefault()})},this.setupArrowkeyEvents=function(b,c){b.bind("keydown",function(b){38===b.which?(b.preventDefault(),a.incrementHours(),a.$apply()):40===b.which&&(b.preventDefault(),a.decrementHours(),a.$apply())}),c.bind("keydown",function(b){38===b.which?(b.preventDefault(),a.incrementMinutes(),a.$apply()):40===b.which&&(b.preventDefault(),a.decrementMinutes(),a.$apply())})},this.setupInputEvents=function(b,c){if(a.readonlyInput)return a.updateHours=angular.noop,void(a.updateMinutes=angular.noop);var d=function(b,c){q.$setViewValue(null),q.$setValidity("time",!1),angular.isDefined(b)&&(a.invalidHours=b),angular.isDefined(c)&&(a.invalidMinutes=c)};a.updateHours=function(){var a=h(),b=i();angular.isDefined(a)&&angular.isDefined(b)?(p.setHours(a),u>p||p>v?d(!0):k("h")):d(!0)},b.bind("blur",function(b){!a.invalidHours&&a.hours<10&&a.$apply(function(){a.hours=j(a.hours)})}),a.updateMinutes=function(){var a=i(),b=h();angular.isDefined(a)&&angular.isDefined(b)?(p.setMinutes(a),u>p||p>v?d(void 0,!0):k("m")):d(void 0,!0)},c.bind("blur",function(b){!a.invalidMinutes&&a.minutes<10&&a.$apply(function(){a.minutes=j(a.minutes)})})},this.render=function(){var b=q.$viewValue;isNaN(b)?(q.$setValidity("time",!1),e.error('Timepicker directive: "ng-model" value must be a Date object, a number of milliseconds since 01.01.1970 or a string representing an RFC2822 or ISO 8601 date.')):(b&&(p=b),u>p||p>v?(q.$setValidity("time",!1),a.invalidHours=!0,a.invalidMinutes=!0):l(),m())},a.showSpinners=angular.isDefined(c.showSpinners)?a.$parent.$eval(c.showSpinners):g.showSpinners,a.incrementHours=function(){a.noIncrementHours()||o(60*s)},a.decrementHours=function(){a.noDecrementHours()||o(60*-s)},a.incrementMinutes=function(){a.noIncrementMinutes()||o(t)},a.decrementMinutes=function(){a.noDecrementMinutes()||o(-t)},a.toggleMeridian=function(){a.noToggleMeridian()||o(720*(p.getHours()<12?1:-1))}}]).directive("uibTimepicker",function(){return{restrict:"EA",require:["uibTimepicker","?^ngModel"],controller:"UibTimepickerController",controllerAs:"timepicker",replace:!0,scope:{},templateUrl:function(a,b){return b.templateUrl||"template/timepicker/timepicker.html"},link:function(a,b,c,d){var e=d[0],f=d[1];f&&e.init(f,b.find("input"))}}}),angular.module("ui.bootstrap.timepicker").value("$timepickerSuppressWarning",!1).controller("TimepickerController",["$scope","$element","$attrs","$controller","$log","$timepickerSuppressWarning",function(a,b,c,d,e,f){f||e.warn("TimepickerController is now deprecated. Use UibTimepickerController instead."),angular.extend(this,d("UibTimepickerController",{$scope:a,$element:b,$attrs:c}))}]).directive("timepicker",["$log","$timepickerSuppressWarning",function(a,b){return{restrict:"EA",require:["timepicker","?^ngModel"],controller:"TimepickerController",controllerAs:"timepicker",replace:!0,scope:{},templateUrl:function(a,b){return b.templateUrl||"template/timepicker/timepicker.html"},link:function(c,d,e,f){b||a.warn("timepicker is now deprecated. Use uib-timepicker instead.");var g=f[0],h=f[1];h&&g.init(h,d.find("input"))}}}]),angular.module("ui.bootstrap.typeahead",["ui.bootstrap.position"]).factory("uibTypeaheadParser",["$parse",function(a){var b=/^\s*([\s\S]+?)(?:\s+as\s+([\s\S]+?))?\s+for\s+(?:([\$\w][\$\w\d]*))\s+in\s+([\s\S]+?)$/;return{parse:function(c){var d=c.match(b);if(!d)throw new Error('Expected typeahead specification in form of "_modelValue_ (as _label_)? for _item_ in _collection_" but got "'+c+'".');return{itemName:d[3],source:a(d[4]),viewMapper:a(d[2]||d[1]),modelMapper:a(d[1])}}}}]).controller("UibTypeaheadController",["$scope","$element","$attrs","$compile","$parse","$q","$timeout","$document","$window","$rootScope","$uibPosition","uibTypeaheadParser",function(a,b,c,d,e,f,g,h,i,j,k,l){function m(){K.moveInProgress||(K.moveInProgress=!0,K.$digest()),S&&g.cancel(S),S=g(function(){K.matches.length&&n(),K.moveInProgress=!1},r)}function n(){K.position=C?k.offset(b):k.position(b),K.position.top+=b.prop("offsetHeight")}var o,p,q=[9,13,27,38,40],r=200,s=a.$eval(c.typeaheadMinLength);s||0===s||(s=1);var t,u,v=a.$eval(c.typeaheadWaitMs)||0,w=a.$eval(c.typeaheadEditable)!==!1,x=e(c.typeaheadLoading).assign||angular.noop,y=e(c.typeaheadOnSelect),z=angular.isDefined(c.typeaheadSelectOnBlur)?a.$eval(c.typeaheadSelectOnBlur):!1,A=e(c.typeaheadNoResults).assign||angular.noop,B=c.typeaheadInputFormatter?e(c.typeaheadInputFormatter):void 0,C=c.typeaheadAppendToBody?a.$eval(c.typeaheadAppendToBody):!1,D=c.typeaheadAppendToElementId||!1,E=a.$eval(c.typeaheadFocusFirst)!==!1,F=c.typeaheadSelectOnExact?a.$eval(c.typeaheadSelectOnExact):!1,G=e(c.ngModel),H=e(c.ngModel+"($$$p)"),I=function(b,c){return angular.isFunction(G(a))&&p&&p.$options&&p.$options.getterSetter?H(b,{$$$p:c}):G.assign(b,c)},J=l.parse(c.uibTypeahead),K=a.$new(),L=a.$on("$destroy",function(){K.$destroy()});K.$on("$destroy",L);var M="typeahead-"+K.$id+"-"+Math.floor(1e4*Math.random());b.attr({"aria-autocomplete":"list","aria-expanded":!1,"aria-owns":M});var N=angular.element("<div uib-typeahead-popup></div>");N.attr({id:M,matches:"matches",active:"activeIdx",select:"select(activeIdx)","move-in-progress":"moveInProgress",query:"query",position:"position"}),angular.isDefined(c.typeaheadTemplateUrl)&&N.attr("template-url",c.typeaheadTemplateUrl),angular.isDefined(c.typeaheadPopupTemplateUrl)&&N.attr("popup-template-url",c.typeaheadPopupTemplateUrl);var O=function(){K.matches=[],K.activeIdx=-1,b.attr("aria-expanded",!1)},P=function(a){return M+"-option-"+a};K.$watch("activeIdx",function(a){0>a?b.removeAttr("aria-activedescendant"):b.attr("aria-activedescendant",P(a))});var Q=function(a,b){return K.matches.length>b&&a?a.toUpperCase()===K.matches[b].label.toUpperCase():!1},R=function(c){var d={$viewValue:c};x(a,!0),A(a,!1),f.when(J.source(a,d)).then(function(e){var f=c===o.$viewValue;if(f&&t)if(e&&e.length>0){K.activeIdx=E?0:-1,A(a,!1),K.matches.length=0;for(var g=0;g<e.length;g++)d[J.itemName]=e[g],K.matches.push({id:P(g),label:J.viewMapper(K,d),model:e[g]});K.query=c,n(),b.attr("aria-expanded",!0),F&&1===K.matches.length&&Q(c,0)&&K.select(0)}else O(),A(a,!0);f&&x(a,!1)},function(){O(),x(a,!1),A(a,!0)})};C&&(angular.element(i).bind("resize",m),h.find("body").bind("scroll",m));var S;K.moveInProgress=!1,K.query=void 0;var T,U=function(a){T=g(function(){R(a)},v)},V=function(){T&&g.cancel(T)};O(),K.select=function(d){var e,f,h={};u=!0,h[J.itemName]=f=K.matches[d].model,e=J.modelMapper(a,h),I(a,e),o.$setValidity("editable",!0),o.$setValidity("parse",!0),y(a,{$item:f,$model:e,$label:J.viewMapper(a,h)}),O(),K.$eval(c.typeaheadFocusOnSelect)!==!1&&g(function(){b[0].focus()},0,!1)},b.bind("keydown",function(a){if(0!==K.matches.length&&-1!==q.indexOf(a.which)){if(-1===K.activeIdx&&(9===a.which||13===a.which))return O(),void K.$digest();a.preventDefault(),40===a.which?(K.activeIdx=(K.activeIdx+1)%K.matches.length,K.$digest()):38===a.which?(K.activeIdx=(K.activeIdx>0?K.activeIdx:K.matches.length)-1,K.$digest()):13===a.which||9===a.which?K.$apply(function(){K.select(K.activeIdx)}):27===a.which&&(a.stopPropagation(),O(),K.$digest())}}),b.bind("blur",function(){z&&K.matches.length&&-1!==K.activeIdx&&!u&&(u=!0,K.$apply(function(){K.select(K.activeIdx)})),t=!1,u=!1});var W=function(a){b[0]!==a.target&&3!==a.which&&0!==K.matches.length&&(O(),j.$$phase||K.$digest())};h.bind("click",W),a.$on("$destroy",function(){h.unbind("click",W),(C||D)&&X.remove(),C&&(angular.element(i).unbind("resize",m),h.find("body").unbind("scroll",m)),N.remove()});var X=d(N)(K);C?h.find("body").append(X):D!==!1?angular.element(h[0].getElementById(D)).append(X):b.after(X),this.init=function(b,c){o=b,p=c,o.$parsers.unshift(function(b){return t=!0,0===s||b&&b.length>=s?v>0?(V(),U(b)):R(b):(x(a,!1),V(),O()),w?b:b?void o.$setValidity("editable",!1):(o.$setValidity("editable",!0),null)}),o.$formatters.push(function(b){var c,d,e={};return w||o.$setValidity("editable",!0),B?(e.$model=b,B(a,e)):(e[J.itemName]=b,c=J.viewMapper(a,e),e[J.itemName]=void 0,d=J.viewMapper(a,e),c!==d?c:b)})}}]).directive("uibTypeahead",function(){return{controller:"UibTypeaheadController",require:["ngModel","^?ngModelOptions","uibTypeahead"],link:function(a,b,c,d){d[2].init(d[0],d[1])}}}).directive("uibTypeaheadPopup",function(){return{scope:{matches:"=",query:"=",active:"=",position:"&",moveInProgress:"=",select:"&"},replace:!0,templateUrl:function(a,b){return b.popupTemplateUrl||"template/typeahead/typeahead-popup.html"},link:function(a,b,c){a.templateUrl=c.templateUrl,a.isOpen=function(){return a.matches.length>0},a.isActive=function(b){return a.active==b},a.selectActive=function(b){a.active=b},a.selectMatch=function(b){a.select({activeIdx:b})}}}}).directive("uibTypeaheadMatch",["$templateRequest","$compile","$parse",function(a,b,c){return{scope:{index:"=",match:"=",query:"="},link:function(d,e,f){var g=c(f.templateUrl)(d.$parent)||"template/typeahead/typeahead-match.html";a(g).then(function(a){b(a.trim())(d,function(a){e.replaceWith(a)})})}}}]).filter("uibTypeaheadHighlight",["$sce","$injector","$log",function(a,b,c){function d(a){return a.replace(/([.?*+^$[\]\\(){}|-])/g,"\\$1")}function e(a){return/<.*>/g.test(a)}var f;return f=b.has("$sanitize"),function(b,g){return!f&&e(b)&&c.warn("Unsafe use of typeahead please use ngSanitize"),b=g?(""+b).replace(new RegExp(d(g),"gi"),"<strong>$&</strong>"):b,f||(b=a.trustAsHtml(b)),b}}]),angular.module("ui.bootstrap.typeahead").value("$typeaheadSuppressWarning",!1).service("typeaheadParser",["$parse","uibTypeaheadParser","$log","$typeaheadSuppressWarning",function(a,b,c,d){return d||c.warn("typeaheadParser is now deprecated. Use uibTypeaheadParser instead."),b}]).directive("typeahead",["$compile","$parse","$q","$timeout","$document","$window","$rootScope","$uibPosition","typeaheadParser","$log","$typeaheadSuppressWarning",function(a,b,c,d,e,f,g,h,i,j,k){var l=[9,13,27,38,40],m=200;return{require:["ngModel","^?ngModelOptions"],link:function(n,o,p,q){function r(){N.moveInProgress||(N.moveInProgress=!0,N.$digest()),V&&d.cancel(V),V=d(function(){N.matches.length&&s(),N.moveInProgress=!1},m)}function s(){N.position=F?h.offset(o):h.position(o),N.position.top+=o.prop("offsetHeight")}k||j.warn("typeahead is now deprecated. Use uib-typeahead instead.");var t=q[0],u=q[1],v=n.$eval(p.typeaheadMinLength);v||0===v||(v=1);var w,x,y=n.$eval(p.typeaheadWaitMs)||0,z=n.$eval(p.typeaheadEditable)!==!1,A=b(p.typeaheadLoading).assign||angular.noop,B=b(p.typeaheadOnSelect),C=angular.isDefined(p.typeaheadSelectOnBlur)?n.$eval(p.typeaheadSelectOnBlur):!1,D=b(p.typeaheadNoResults).assign||angular.noop,E=p.typeaheadInputFormatter?b(p.typeaheadInputFormatter):void 0,F=p.typeaheadAppendToBody?n.$eval(p.typeaheadAppendToBody):!1,G=p.typeaheadAppendToElementId||!1,H=n.$eval(p.typeaheadFocusFirst)!==!1,I=p.typeaheadSelectOnExact?n.$eval(p.typeaheadSelectOnExact):!1,J=b(p.ngModel),K=b(p.ngModel+"($$$p)"),L=function(a,b){return angular.isFunction(J(n))&&u&&u.$options&&u.$options.getterSetter?K(a,{$$$p:b}):J.assign(a,b)},M=i.parse(p.typeahead),N=n.$new(),O=n.$on("$destroy",function(){N.$destroy()});N.$on("$destroy",O);var P="typeahead-"+N.$id+"-"+Math.floor(1e4*Math.random());o.attr({"aria-autocomplete":"list","aria-expanded":!1,"aria-owns":P});var Q=angular.element("<div typeahead-popup></div>");Q.attr({id:P,matches:"matches",active:"activeIdx",select:"select(activeIdx)","move-in-progress":"moveInProgress",query:"query",position:"position"}),angular.isDefined(p.typeaheadTemplateUrl)&&Q.attr("template-url",p.typeaheadTemplateUrl),angular.isDefined(p.typeaheadPopupTemplateUrl)&&Q.attr("popup-template-url",p.typeaheadPopupTemplateUrl);var R=function(){N.matches=[],N.activeIdx=-1,o.attr("aria-expanded",!1)},S=function(a){return P+"-option-"+a};N.$watch("activeIdx",function(a){0>a?o.removeAttr("aria-activedescendant"):o.attr("aria-activedescendant",S(a))});var T=function(a,b){return N.matches.length>b&&a?a.toUpperCase()===N.matches[b].label.toUpperCase():!1},U=function(a){var b={$viewValue:a};A(n,!0),D(n,!1),c.when(M.source(n,b)).then(function(c){var d=a===t.$viewValue;if(d&&w)if(c&&c.length>0){N.activeIdx=H?0:-1,D(n,!1),N.matches.length=0;for(var e=0;e<c.length;e++)b[M.itemName]=c[e],N.matches.push({id:S(e),label:M.viewMapper(N,b),model:c[e]});N.query=a,s(),o.attr("aria-expanded",!0),I&&1===N.matches.length&&T(a,0)&&N.select(0)}else R(),D(n,!0);d&&A(n,!1)},function(){R(),A(n,!1),D(n,!0)})};F&&(angular.element(f).bind("resize",r),e.find("body").bind("scroll",r));var V;N.moveInProgress=!1,R(),N.query=void 0;var W,X=function(a){W=d(function(){U(a)},y)},Y=function(){W&&d.cancel(W)};t.$parsers.unshift(function(a){return w=!0,0===v||a&&a.length>=v?y>0?(Y(),X(a)):U(a):(A(n,!1),Y(),R()),z?a:a?void t.$setValidity("editable",!1):(t.$setValidity("editable",!0),null)}),t.$formatters.push(function(a){var b,c,d={};return z||t.$setValidity("editable",!0),E?(d.$model=a,E(n,d)):(d[M.itemName]=a,b=M.viewMapper(n,d),d[M.itemName]=void 0,c=M.viewMapper(n,d),b!==c?b:a)}),N.select=function(a){var b,c,e={};x=!0,e[M.itemName]=c=N.matches[a].model,b=M.modelMapper(n,e),L(n,b),t.$setValidity("editable",!0),t.$setValidity("parse",!0),B(n,{$item:c,$model:b,$label:M.viewMapper(n,e)}),R(),N.$eval(p.typeaheadFocusOnSelect)!==!1&&d(function(){o[0].focus()},0,!1)},o.bind("keydown",function(a){if(0!==N.matches.length&&-1!==l.indexOf(a.which)){if(-1===N.activeIdx&&(9===a.which||13===a.which))return R(),void N.$digest();a.preventDefault(),40===a.which?(N.activeIdx=(N.activeIdx+1)%N.matches.length,N.$digest()):38===a.which?(N.activeIdx=(N.activeIdx>0?N.activeIdx:N.matches.length)-1,N.$digest()):13===a.which||9===a.which?N.$apply(function(){N.select(N.activeIdx)}):27===a.which&&(a.stopPropagation(),R(),N.$digest())}}),o.bind("blur",function(){C&&N.matches.length&&-1!==N.activeIdx&&!x&&(x=!0,N.$apply(function(){N.select(N.activeIdx)})),w=!1,x=!1});var Z=function(a){o[0]!==a.target&&3!==a.which&&0!==N.matches.length&&(R(),g.$$phase||N.$digest())};e.bind("click",Z),n.$on("$destroy",function(){e.unbind("click",Z),(F||G)&&$.remove(),F&&(angular.element(f).unbind("resize",r),e.find("body").unbind("scroll",r)),Q.remove()});var $=a(Q)(N);F?e.find("body").append($):G!==!1?angular.element(e[0].getElementById(G)).append($):o.after($)}}}]).directive("typeaheadPopup",["$typeaheadSuppressWarning","$log",function(a,b){return{scope:{matches:"=",query:"=",active:"=",position:"&",moveInProgress:"=",select:"&"},replace:!0,templateUrl:function(a,b){return b.popupTemplateUrl||"template/typeahead/typeahead-popup.html"},link:function(c,d,e){a||b.warn("typeahead-popup is now deprecated. Use uib-typeahead-popup instead."),c.templateUrl=e.templateUrl,c.isOpen=function(){return c.matches.length>0},c.isActive=function(a){return c.active==a},c.selectActive=function(a){c.active=a},c.selectMatch=function(a){c.select({activeIdx:a})}}}}]).directive("typeaheadMatch",["$templateRequest","$compile","$parse","$typeaheadSuppressWarning","$log",function(a,b,c,d,e){return{restrict:"EA",scope:{index:"=",match:"=",query:"="},link:function(f,g,h){d||e.warn("typeahead-match is now deprecated. Use uib-typeahead-match instead.");var i=c(h.templateUrl)(f.$parent)||"template/typeahead/typeahead-match.html";a(i).then(function(a){b(a.trim())(f,function(a){g.replaceWith(a)})})}}}]).filter("typeaheadHighlight",["$sce","$injector","$log","$typeaheadSuppressWarning",function(a,b,c,d){function e(a){return a.replace(/([.?*+^$[\]\\(){}|-])/g,"\\$1")}function f(a){return/<.*>/g.test(a)}var g;return g=b.has("$sanitize"),function(b,h){return d||c.warn("typeaheadHighlight is now deprecated. Use uibTypeaheadHighlight instead."),!g&&f(b)&&c.warn("Unsafe use of typeahead please use ngSanitize"),b=h?(""+b).replace(new RegExp(e(h),"gi"),"<strong>$&</strong>"):b,g||(b=a.trustAsHtml(b)),b}}]),angular.module("template/accordion/accordion-group.html",[]).run(["$templateCache",function(a){a.put("template/accordion/accordion-group.html",'<div class="panel {{panelClass || \'panel-default\'}}">\n  <div class="panel-heading" ng-keypress="toggleOpen($event)">\n    <h4 class="panel-title">\n      <a href tabindex="0" class="accordion-toggle" ng-click="toggleOpen()" uib-accordion-transclude="heading"><span ng-class="{\'text-muted\': isDisabled}">{{heading}}</span></a>\n    </h4>\n  </div>\n  <div class="panel-collapse collapse" uib-collapse="!isOpen">\n	  <div class="panel-body" ng-transclude></div>\n  </div>\n</div>\n')}]),angular.module("template/accordion/accordion.html",[]).run(["$templateCache",function(a){a.put("template/accordion/accordion.html",'<div class="panel-group" ng-transclude></div>')}]),angular.module("template/alert/alert.html",[]).run(["$templateCache",function(a){a.put("template/alert/alert.html",'<div class="alert" ng-class="[\'alert-\' + (type || \'warning\'), closeable ? \'alert-dismissible\' : null]" role="alert">\n    <button ng-show="closeable" type="button" class="close" ng-click="close({$event: $event})">\n        <span aria-hidden="true">&times;</span>\n        <span class="sr-only">Close</span>\n    </button>\n    <div ng-transclude></div>\n</div>\n')}]),angular.module("template/carousel/carousel.html",[]).run(["$templateCache",function(a){a.put("template/carousel/carousel.html",'<div ng-mouseenter="pause()" ng-mouseleave="play()" class="carousel" ng-swipe-right="prev()" ng-swipe-left="next()">\n  <div class="carousel-inner" ng-transclude></div>\n  <a role="button" href class="left carousel-control" ng-click="prev()" ng-show="slides.length > 1">\n    <span aria-hidden="true" class="glyphicon glyphicon-chevron-left"></span>\n    <span class="sr-only">previous</span>\n  </a>\n  <a role="button" href class="right carousel-control" ng-click="next()" ng-show="slides.length > 1">\n    <span aria-hidden="true" class="glyphicon glyphicon-chevron-right"></span>\n    <span class="sr-only">next</span>\n  </a>\n  <ol class="carousel-indicators" ng-show="slides.length > 1">\n    <li ng-repeat="slide in slides | orderBy:indexOfSlide track by $index" ng-class="{ active: isActive(slide) }" ng-click="select(slide)">\n      <span class="sr-only">slide {{ $index + 1 }} of {{ slides.length }}<span ng-if="isActive(slide)">, currently active</span></span>\n    </li>\n  </ol>\n</div>')}]),angular.module("template/carousel/slide.html",[]).run(["$templateCache",function(a){a.put("template/carousel/slide.html",'<div ng-class="{\n    \'active\': active\n  }" class="item text-center" ng-transclude></div>\n')}]),angular.module("template/datepicker/datepicker.html",[]).run(["$templateCache",function(a){a.put("template/datepicker/datepicker.html",'<div ng-switch="datepickerMode" role="application" ng-keydown="keydown($event)">\n  <uib-daypicker ng-switch-when="day" tabindex="0"></uib-daypicker>\n  <uib-monthpicker ng-switch-when="month" tabindex="0"></uib-monthpicker>\n  <uib-yearpicker ng-switch-when="year" tabindex="0"></uib-yearpicker>\n</div>')}]),angular.module("template/datepicker/day.html",[]).run(["$templateCache",function(a){a.put("template/datepicker/day.html",'<table role="grid" aria-labelledby="{{::uniqueId}}-title" aria-activedescendant="{{activeDateId}}">\n  <thead>\n    <tr>\n      <th><button type="button" class="btn btn-default btn-sm pull-left" ng-click="move(-1)" tabindex="-1"><i class="glyphicon glyphicon-chevron-left"></i></button></th>\n      <th colspan="{{::5 + showWeeks}}"><button id="{{::uniqueId}}-title" role="heading" aria-live="assertive" aria-atomic="true" type="button" class="btn btn-default btn-sm" ng-click="toggleMode()" ng-disabled="datepickerMode === maxMode" tabindex="-1" style="width:100%;"><strong>{{title}}</strong></button></th>\n      <th><button type="button" class="btn btn-default btn-sm pull-right" ng-click="move(1)" tabindex="-1"><i class="glyphicon glyphicon-chevron-right"></i></button></th>\n    </tr>\n    <tr>\n      <th ng-if="showWeeks" class="text-center"></th>\n      <th ng-repeat="label in ::labels track by $index" class="text-center"><small aria-label="{{::label.full}}">{{::label.abbr}}</small></th>\n    </tr>\n  </thead>\n  <tbody>\n    <tr ng-repeat="row in rows track by $index">\n      <td ng-if="showWeeks" class="text-center h6"><em>{{ weekNumbers[$index] }}</em></td>\n      <td ng-repeat="dt in row track by dt.date" class="text-center" role="gridcell" id="{{::dt.uid}}" ng-class="::dt.customClass">\n        <button type="button" style="min-width:100%;" class="btn btn-default btn-sm" ng-class="{\'btn-info\': dt.selected, active: isActive(dt)}" ng-click="select(dt.date)" ng-disabled="dt.disabled" tabindex="-1"><span ng-class="::{\'text-muted\': dt.secondary, \'text-info\': dt.current}">{{::dt.label}}</span></button>\n      </td>\n    </tr>\n  </tbody>\n</table>\n')}]),angular.module("template/datepicker/month.html",[]).run(["$templateCache",function(a){a.put("template/datepicker/month.html",'<table role="grid" aria-labelledby="{{::uniqueId}}-title" aria-activedescendant="{{activeDateId}}">\n  <thead>\n    <tr>\n      <th><button type="button" class="btn btn-default btn-sm pull-left" ng-click="move(-1)" tabindex="-1"><i class="glyphicon glyphicon-chevron-left"></i></button></th>\n      <th><button id="{{::uniqueId}}-title" role="heading" aria-live="assertive" aria-atomic="true" type="button" class="btn btn-default btn-sm" ng-click="toggleMode()" ng-disabled="datepickerMode === maxMode" tabindex="-1" style="width:100%;"><strong>{{title}}</strong></button></th>\n      <th><button type="button" class="btn btn-default btn-sm pull-right" ng-click="move(1)" tabindex="-1"><i class="glyphicon glyphicon-chevron-right"></i></button></th>\n    </tr>\n  </thead>\n  <tbody>\n    <tr ng-repeat="row in rows track by $index">\n      <td ng-repeat="dt in row track by dt.date" class="text-center" role="gridcell" id="{{::dt.uid}}" ng-class="::dt.customClass">\n        <button type="button" style="min-width:100%;" class="btn btn-default" ng-class="{\'btn-info\': dt.selected, active: isActive(dt)}" ng-click="select(dt.date)" ng-disabled="dt.disabled" tabindex="-1"><span ng-class="::{\'text-info\': dt.current}">{{::dt.label}}</span></button>\n      </td>\n    </tr>\n  </tbody>\n</table>\n')}]),angular.module("template/datepicker/popup.html",[]).run(["$templateCache",function(a){a.put("template/datepicker/popup.html",'<ul class="dropdown-menu" dropdown-nested ng-if="isOpen" style="display: block" ng-style="{top: position.top+\'px\', left: position.left+\'px\'}" ng-keydown="keydown($event)" ng-click="$event.stopPropagation()">\n	<li ng-transclude></li>\n	<li ng-if="showButtonBar" style="padding:10px 9px 2px">\n		<span class="btn-group pull-left">\n			<button type="button" class="btn btn-sm btn-info" ng-click="select(\'today\')" ng-disabled="isDisabled(\'today\')">{{ getText(\'current\') }}</button>\n			<button type="button" class="btn btn-sm btn-danger" ng-click="select(null)">{{ getText(\'clear\') }}</button>\n		</span>\n		<button type="button" class="btn btn-sm btn-success pull-right" ng-click="close()">{{ getText(\'close\') }}</button>\n	</li>\n</ul>\n')}]),angular.module("template/datepicker/year.html",[]).run(["$templateCache",function(a){a.put("template/datepicker/year.html",'<table role="grid" aria-labelledby="{{::uniqueId}}-title" aria-activedescendant="{{activeDateId}}">\n  <thead>\n    <tr>\n      <th><button type="button" class="btn btn-default btn-sm pull-left" ng-click="move(-1)" tabindex="-1"><i class="glyphicon glyphicon-chevron-left"></i></button></th>\n      <th colspan="3"><button id="{{::uniqueId}}-title" role="heading" aria-live="assertive" aria-atomic="true" type="button" class="btn btn-default btn-sm" ng-click="toggleMode()" ng-disabled="datepickerMode === maxMode" tabindex="-1" style="width:100%;"><strong>{{title}}</strong></button></th>\n      <th><button type="button" class="btn btn-default btn-sm pull-right" ng-click="move(1)" tabindex="-1"><i class="glyphicon glyphicon-chevron-right"></i></button></th>\n    </tr>\n  </thead>\n  <tbody>\n    <tr ng-repeat="row in rows track by $index">\n      <td ng-repeat="dt in row track by dt.date" class="text-center" role="gridcell" id="{{::dt.uid}}" ng-class="::dt.customClass">\n        <button type="button" style="min-width:100%;" class="btn btn-default" ng-class="{\'btn-info\': dt.selected, active: isActive(dt)}" ng-click="select(dt.date)" ng-disabled="dt.disabled" tabindex="-1"><span ng-class="::{\'text-info\': dt.current}">{{::dt.label}}</span></button>\n      </td>\n    </tr>\n  </tbody>\n</table>\n')}]),angular.module("template/modal/backdrop.html",[]).run(["$templateCache",function(a){a.put("template/modal/backdrop.html",'<div uib-modal-animation-class="fade"\n     modal-in-class="in"\n     ng-style="{\'z-index\': 1040 + (index && 1 || 0) + index*10}"\n></div>\n')}]),angular.module("template/modal/window.html",[]).run(["$templateCache",function(a){a.put("template/modal/window.html",'<div modal-render="{{$isRendered}}" tabindex="-1" role="dialog" class="modal"\n    uib-modal-animation-class="fade"\n    modal-in-class="in"\n    ng-style="{\'z-index\': 1050 + index*10, display: \'block\'}">\n    <div class="modal-dialog" ng-class="size ? \'modal-\' + size : \'\'"><div class="modal-content" uib-modal-transclude></div></div>\n</div>\n')}]),angular.module("template/pagination/pager.html",[]).run(["$templateCache",function(a){a.put("template/pagination/pager.html",'<ul class="pager">\n  <li ng-class="{disabled: noPrevious()||ngDisabled, previous: align}"><a href ng-click="selectPage(page - 1, $event)">{{::getText(\'previous\')}}</a></li>\n  <li ng-class="{disabled: noNext()||ngDisabled, next: align}"><a href ng-click="selectPage(page + 1, $event)">{{::getText(\'next\')}}</a></li>\n</ul>\n')}]),angular.module("template/pagination/pagination.html",[]).run(["$templateCache",function(a){a.put("template/pagination/pagination.html",'<ul class="pagination">\n  <li ng-if="::boundaryLinks" ng-class="{disabled: noPrevious()||ngDisabled}" class="pagination-first"><a href ng-click="selectPage(1, $event)">{{::getText(\'first\')}}</a></li>\n  <li ng-if="::directionLinks" ng-class="{disabled: noPrevious()||ngDisabled}" class="pagination-prev"><a href ng-click="selectPage(page - 1, $event)">{{::getText(\'previous\')}}</a></li>\n  <li ng-repeat="page in pages track by $index" ng-class="{active: page.active,disabled: ngDisabled&&!page.active}" class="pagination-page"><a href ng-click="selectPage(page.number, $event)">{{page.text}}</a></li>\n  <li ng-if="::directionLinks" ng-class="{disabled: noNext()||ngDisabled}" class="pagination-next"><a href ng-click="selectPage(page + 1, $event)">{{::getText(\'next\')}}</a></li>\n  <li ng-if="::boundaryLinks" ng-class="{disabled: noNext()||ngDisabled}" class="pagination-last"><a href ng-click="selectPage(totalPages, $event)">{{::getText(\'last\')}}</a></li>\n</ul>\n')}]),angular.module("template/tooltip/tooltip-html-popup.html",[]).run(["$templateCache",function(a){a.put("template/tooltip/tooltip-html-popup.html",'<div\n  tooltip-animation-class="fade"\n  uib-tooltip-classes\n  ng-class="{ in: isOpen() }">\n  <div class="tooltip-arrow"></div>\n  <div class="tooltip-inner" ng-bind-html="contentExp()"></div>\n</div>\n')}]),angular.module("template/tooltip/tooltip-popup.html",[]).run(["$templateCache",function(a){a.put("template/tooltip/tooltip-popup.html",'<div\n  tooltip-animation-class="fade"\n  uib-tooltip-classes\n  ng-class="{ in: isOpen() }">\n  <div class="tooltip-arrow"></div>\n  <div class="tooltip-inner" ng-bind="content"></div>\n</div>\n')}]),angular.module("template/tooltip/tooltip-template-popup.html",[]).run(["$templateCache",function(a){a.put("template/tooltip/tooltip-template-popup.html",'<div\n  tooltip-animation-class="fade"\n  uib-tooltip-classes\n  ng-class="{ in: isOpen() }">\n  <div class="tooltip-arrow"></div>\n  <div class="tooltip-inner"\n    uib-tooltip-template-transclude="contentExp()"\n    tooltip-template-transclude-scope="originScope()"></div>\n</div>\n')}]),angular.module("template/popover/popover-html.html",[]).run(["$templateCache",function(a){a.put("template/popover/popover-html.html",'<div tooltip-animation-class="fade"\n  uib-tooltip-classes\n  ng-class="{ in: isOpen() }">\n  <div class="arrow"></div>\n\n  <div class="popover-inner">\n      <h3 class="popover-title" ng-bind="title" ng-if="title"></h3>\n      <div class="popover-content" ng-bind-html="contentExp()"></div>\n  </div>\n</div>\n')}]),angular.module("template/popover/popover-template.html",[]).run(["$templateCache",function(a){a.put("template/popover/popover-template.html",'<div tooltip-animation-class="fade"\n  uib-tooltip-classes\n  ng-class="{ in: isOpen() }">\n  <div class="arrow"></div>\n\n  <div class="popover-inner">\n      <h3 class="popover-title" ng-bind="title" ng-if="title"></h3>\n      <div class="popover-content"\n        uib-tooltip-template-transclude="contentExp()"\n        tooltip-template-transclude-scope="originScope()"></div>\n  </div>\n</div>\n')}]),angular.module("template/popover/popover.html",[]).run(["$templateCache",function(a){a.put("template/popover/popover.html",'<div tooltip-animation-class="fade"\n  uib-tooltip-classes\n  ng-class="{ in: isOpen() }">\n  <div class="arrow"></div>\n\n  <div class="popover-inner">\n      <h3 class="popover-title" ng-bind="title" ng-if="title"></h3>\n      <div class="popover-content" ng-bind="content"></div>\n  </div>\n</div>\n')}]),angular.module("template/progressbar/bar.html",[]).run(["$templateCache",function(a){a.put("template/progressbar/bar.html",'<div class="progress-bar" ng-class="type && \'progress-bar-\' + type" role="progressbar" aria-valuenow="{{value}}" aria-valuemin="0" aria-valuemax="{{max}}" ng-style="{width: (percent < 100 ? percent : 100) + \'%\'}" aria-valuetext="{{percent | number:0}}%" aria-labelledby="{{::title}}" style="min-width: 0;" ng-transclude></div>\n')}]),angular.module("template/progressbar/progress.html",[]).run(["$templateCache",function(a){a.put("template/progressbar/progress.html",'<div class="progress" ng-transclude aria-labelledby="{{::title}}"></div>')}]),angular.module("template/progressbar/progressbar.html",[]).run(["$templateCache",function(a){a.put("template/progressbar/progressbar.html",'<div class="progress">\n  <div class="progress-bar" ng-class="type && \'progress-bar-\' + type" role="progressbar" aria-valuenow="{{value}}" aria-valuemin="0" aria-valuemax="{{max}}" ng-style="{width: (percent < 100 ? percent : 100) + \'%\'}" aria-valuetext="{{percent | number:0}}%" aria-labelledby="{{::title}}" style="min-width: 0;" ng-transclude></div>\n</div>\n')}]),angular.module("template/rating/rating.html",[]).run(["$templateCache",function(a){a.put("template/rating/rating.html",'<span ng-mouseleave="reset()" ng-keydown="onKeydown($event)" tabindex="0" role="slider" aria-valuemin="0" aria-valuemax="{{range.length}}" aria-valuenow="{{value}}">\n    <span ng-repeat-start="r in range track by $index" class="sr-only">({{ $index < value ? \'*\' : \' \' }})</span>\n    <i ng-repeat-end ng-mouseenter="enter($index + 1)" ng-click="rate($index + 1)" class="glyphicon" ng-class="$index < value && (r.stateOn || \'glyphicon-star\') || (r.stateOff || \'glyphicon-star-empty\')" ng-attr-title="{{r.title}}" aria-valuetext="{{r.title}}"></i>\n</span>\n');
}]),angular.module("template/tabs/tab.html",[]).run(["$templateCache",function(a){a.put("template/tabs/tab.html",'<li ng-class="{active: active, disabled: disabled}">\n  <a href ng-click="select()" uib-tab-heading-transclude>{{heading}}</a>\n</li>\n')}]),angular.module("template/tabs/tabset.html",[]).run(["$templateCache",function(a){a.put("template/tabs/tabset.html",'<div>\n  <ul class="nav nav-{{type || \'tabs\'}}" ng-class="{\'nav-stacked\': vertical, \'nav-justified\': justified}" ng-transclude></ul>\n  <div class="tab-content">\n    <div class="tab-pane" \n         ng-repeat="tab in tabs" \n         ng-class="{active: tab.active}"\n         uib-tab-content-transclude="tab">\n    </div>\n  </div>\n</div>\n')}]),angular.module("template/timepicker/timepicker.html",[]).run(["$templateCache",function(a){a.put("template/timepicker/timepicker.html",'<table>\n  <tbody>\n    <tr class="text-center" ng-show="::showSpinners">\n      <td><a ng-click="incrementHours()" ng-class="{disabled: noIncrementHours()}" class="btn btn-link" ng-disabled="noIncrementHours()" tabindex="{{::tabindex}}"><span class="glyphicon glyphicon-chevron-up"></span></a></td>\n      <td>&nbsp;</td>\n      <td><a ng-click="incrementMinutes()" ng-class="{disabled: noIncrementMinutes()}" class="btn btn-link" ng-disabled="noIncrementMinutes()" tabindex="{{::tabindex}}"><span class="glyphicon glyphicon-chevron-up"></span></a></td>\n      <td ng-show="showMeridian"></td>\n    </tr>\n    <tr>\n      <td class="form-group" ng-class="{\'has-error\': invalidHours}">\n        <input style="width:50px;" type="text" ng-model="hours" ng-change="updateHours()" class="form-control text-center" ng-readonly="::readonlyInput" maxlength="2" tabindex="{{::tabindex}}">\n      </td>\n      <td>:</td>\n      <td class="form-group" ng-class="{\'has-error\': invalidMinutes}">\n        <input style="width:50px;" type="text" ng-model="minutes" ng-change="updateMinutes()" class="form-control text-center" ng-readonly="::readonlyInput" maxlength="2" tabindex="{{::tabindex}}">\n      </td>\n      <td ng-show="showMeridian"><button type="button" ng-class="{disabled: noToggleMeridian()}" class="btn btn-default text-center" ng-click="toggleMeridian()" ng-disabled="noToggleMeridian()" tabindex="{{::tabindex}}">{{meridian}}</button></td>\n    </tr>\n    <tr class="text-center" ng-show="::showSpinners">\n      <td><a ng-click="decrementHours()" ng-class="{disabled: noDecrementHours()}" class="btn btn-link" ng-disabled="noDecrementHours()" tabindex="{{::tabindex}}"><span class="glyphicon glyphicon-chevron-down"></span></a></td>\n      <td>&nbsp;</td>\n      <td><a ng-click="decrementMinutes()" ng-class="{disabled: noDecrementMinutes()}" class="btn btn-link" ng-disabled="noDecrementMinutes()" tabindex="{{::tabindex}}"><span class="glyphicon glyphicon-chevron-down"></span></a></td>\n      <td ng-show="showMeridian"></td>\n    </tr>\n  </tbody>\n</table>\n')}]),angular.module("template/typeahead/typeahead-match.html",[]).run(["$templateCache",function(a){a.put("template/typeahead/typeahead-match.html",'<a href tabindex="-1" ng-bind-html="match.label | uibTypeaheadHighlight:query"></a>\n')}]),angular.module("template/typeahead/typeahead-popup.html",[]).run(["$templateCache",function(a){a.put("template/typeahead/typeahead-popup.html",'<ul class="dropdown-menu" ng-show="isOpen() && !moveInProgress" ng-style="{top: position().top+\'px\', left: position().left+\'px\'}" style="display: block;" role="listbox" aria-hidden="{{!isOpen()}}">\n    <li ng-repeat="match in matches track by $index" ng-class="{active: isActive($index) }" ng-mouseenter="selectActive($index)" ng-click="selectMatch($index)" role="option" id="{{::match.id}}">\n        <div uib-typeahead-match index="$index" match="match" query="query" template-url="templateUrl"></div>\n    </li>\n</ul>\n')}]),!angular.$$csp()&&angular.element(document).find("head").prepend('<style type="text/css">.ng-animate.item:not(.left):not(.right){-webkit-transition:0s ease-in-out left;transition:0s ease-in-out left}</style>');
/**
 * @license AngularJS v1.5.11
 * (c) 2010-2017 Google, Inc. http://angularjs.org
 * License: MIT
 */
(function(window, angular) {'use strict';

/* global shallowCopy: true */

/**
 * Creates a shallow copy of an object, an array or a primitive.
 *
 * Assumes that there are no proto properties for objects.
 */
function shallowCopy(src, dst) {
  if (isArray(src)) {
    dst = dst || [];

    for (var i = 0, ii = src.length; i < ii; i++) {
      dst[i] = src[i];
    }
  } else if (isObject(src)) {
    dst = dst || {};

    for (var key in src) {
      if (!(key.charAt(0) === '$' && key.charAt(1) === '$')) {
        dst[key] = src[key];
      }
    }
  }

  return dst || src;
}

/* global shallowCopy: false */

// There are necessary for `shallowCopy()` (included via `src/shallowCopy.js`).
// They are initialized inside the `$RouteProvider`, to ensure `window.angular` is available.
var isArray;
var isObject;

/**
 * @ngdoc module
 * @name ngRoute
 * @description
 *
 * # ngRoute
 *
 * The `ngRoute` module provides routing and deeplinking services and directives for angular apps.
 *
 * ## Example
 * See {@link ngRoute.$route#example $route} for an example of configuring and using `ngRoute`.
 *
 *
 * <div doc-module-components="ngRoute"></div>
 */
 /* global -ngRouteModule */
var ngRouteModule = angular.module('ngRoute', ['ng']).
                        provider('$route', $RouteProvider),
    $routeMinErr = angular.$$minErr('ngRoute');

/**
 * @ngdoc provider
 * @name $routeProvider
 * @this
 *
 * @description
 *
 * Used for configuring routes.
 *
 * ## Example
 * See {@link ngRoute.$route#example $route} for an example of configuring and using `ngRoute`.
 *
 * ## Dependencies
 * Requires the {@link ngRoute `ngRoute`} module to be installed.
 */
function $RouteProvider() {
  isArray = angular.isArray;
  isObject = angular.isObject;

  function inherit(parent, extra) {
    return angular.extend(Object.create(parent), extra);
  }

  var routes = {};

  /**
   * @ngdoc method
   * @name $routeProvider#when
   *
   * @param {string} path Route path (matched against `$location.path`). If `$location.path`
   *    contains redundant trailing slash or is missing one, the route will still match and the
   *    `$location.path` will be updated to add or drop the trailing slash to exactly match the
   *    route definition.
   *
   *    * `path` can contain named groups starting with a colon: e.g. `:name`. All characters up
   *        to the next slash are matched and stored in `$routeParams` under the given `name`
   *        when the route matches.
   *    * `path` can contain named groups starting with a colon and ending with a star:
   *        e.g.`:name*`. All characters are eagerly stored in `$routeParams` under the given `name`
   *        when the route matches.
   *    * `path` can contain optional named groups with a question mark: e.g.`:name?`.
   *
   *    For example, routes like `/color/:color/largecode/:largecode*\/edit` will match
   *    `/color/brown/largecode/code/with/slashes/edit` and extract:
   *
   *    * `color: brown`
   *    * `largecode: code/with/slashes`.
   *
   *
   * @param {Object} route Mapping information to be assigned to `$route.current` on route
   *    match.
   *
   *    Object properties:
   *
   *    - `controller` – `{(string|function()=}` – Controller fn that should be associated with
   *      newly created scope or the name of a {@link angular.Module#controller registered
   *      controller} if passed as a string.
   *    - `controllerAs` – `{string=}` – An identifier name for a reference to the controller.
   *      If present, the controller will be published to scope under the `controllerAs` name.
   *    - `template` – `{string=|function()=}` – html template as a string or a function that
   *      returns an html template as a string which should be used by {@link
   *      ngRoute.directive:ngView ngView} or {@link ng.directive:ngInclude ngInclude} directives.
   *      This property takes precedence over `templateUrl`.
   *
   *      If `template` is a function, it will be called with the following parameters:
   *
   *      - `{Array.<Object>}` - route parameters extracted from the current
   *        `$location.path()` by applying the current route
   *
   *    - `templateUrl` – `{string=|function()=}` – path or function that returns a path to an html
   *      template that should be used by {@link ngRoute.directive:ngView ngView}.
   *
   *      If `templateUrl` is a function, it will be called with the following parameters:
   *
   *      - `{Array.<Object>}` - route parameters extracted from the current
   *        `$location.path()` by applying the current route
   *
   *    - `resolve` - `{Object.<string, function>=}` - An optional map of dependencies which should
   *      be injected into the controller. If any of these dependencies are promises, the router
   *      will wait for them all to be resolved or one to be rejected before the controller is
   *      instantiated.
   *      If all the promises are resolved successfully, the values of the resolved promises are
   *      injected and {@link ngRoute.$route#$routeChangeSuccess $routeChangeSuccess} event is
   *      fired. If any of the promises are rejected the
   *      {@link ngRoute.$route#$routeChangeError $routeChangeError} event is fired.
   *      For easier access to the resolved dependencies from the template, the `resolve` map will
   *      be available on the scope of the route, under `$resolve` (by default) or a custom name
   *      specified by the `resolveAs` property (see below). This can be particularly useful, when
   *      working with {@link angular.Module#component components} as route templates.<br />
   *      <div class="alert alert-warning">
   *        **Note:** If your scope already contains a property with this name, it will be hidden
   *        or overwritten. Make sure, you specify an appropriate name for this property, that
   *        does not collide with other properties on the scope.
   *      </div>
   *      The map object is:
   *
   *      - `key` – `{string}`: a name of a dependency to be injected into the controller.
   *      - `factory` - `{string|function}`: If `string` then it is an alias for a service.
   *        Otherwise if function, then it is {@link auto.$injector#invoke injected}
   *        and the return value is treated as the dependency. If the result is a promise, it is
   *        resolved before its value is injected into the controller. Be aware that
   *        `ngRoute.$routeParams` will still refer to the previous route within these resolve
   *        functions.  Use `$route.current.params` to access the new route parameters, instead.
   *
   *    - `resolveAs` - `{string=}` - The name under which the `resolve` map will be available on
   *      the scope of the route. If omitted, defaults to `$resolve`.
   *
   *    - `redirectTo` – `{(string|function())=}` – value to update
   *      {@link ng.$location $location} path with and trigger route redirection.
   *
   *      If `redirectTo` is a function, it will be called with the following parameters:
   *
   *      - `{Object.<string>}` - route parameters extracted from the current
   *        `$location.path()` by applying the current route templateUrl.
   *      - `{string}` - current `$location.path()`
   *      - `{Object}` - current `$location.search()`
   *
   *      The custom `redirectTo` function is expected to return a string which will be used
   *      to update `$location.path()` and `$location.search()`.
   *
   *    - `[reloadOnSearch=true]` - `{boolean=}` - reload route when only `$location.search()`
   *      or `$location.hash()` changes.
   *
   *      If the option is set to `false` and url in the browser changes, then
   *      `$routeUpdate` event is broadcasted on the root scope.
   *
   *    - `[caseInsensitiveMatch=false]` - `{boolean=}` - match routes without being case sensitive
   *
   *      If the option is set to `true`, then the particular route can be matched without being
   *      case sensitive
   *
   * @returns {Object} self
   *
   * @description
   * Adds a new route definition to the `$route` service.
   */
  this.when = function(path, route) {
    //copy original route object to preserve params inherited from proto chain
    var routeCopy = shallowCopy(route);
    if (angular.isUndefined(routeCopy.reloadOnSearch)) {
      routeCopy.reloadOnSearch = true;
    }
    if (angular.isUndefined(routeCopy.caseInsensitiveMatch)) {
      routeCopy.caseInsensitiveMatch = this.caseInsensitiveMatch;
    }
    routes[path] = angular.extend(
      routeCopy,
      path && pathRegExp(path, routeCopy)
    );

    // create redirection for trailing slashes
    if (path) {
      var redirectPath = (path[path.length - 1] === '/')
            ? path.substr(0, path.length - 1)
            : path + '/';

      routes[redirectPath] = angular.extend(
        {redirectTo: path},
        pathRegExp(redirectPath, routeCopy)
      );
    }

    return this;
  };

  /**
   * @ngdoc property
   * @name $routeProvider#caseInsensitiveMatch
   * @description
   *
   * A boolean property indicating if routes defined
   * using this provider should be matched using a case insensitive
   * algorithm. Defaults to `false`.
   */
  this.caseInsensitiveMatch = false;

   /**
    * @param path {string} path
    * @param opts {Object} options
    * @return {?Object}
    *
    * @description
    * Normalizes the given path, returning a regular expression
    * and the original path.
    *
    * Inspired by pathRexp in visionmedia/express/lib/utils.js.
    */
  function pathRegExp(path, opts) {
    var insensitive = opts.caseInsensitiveMatch,
        ret = {
          originalPath: path,
          regexp: path
        },
        keys = ret.keys = [];

    path = path
      .replace(/([().])/g, '\\$1')
      .replace(/(\/)?:(\w+)(\*\?|[?*])?/g, function(_, slash, key, option) {
        var optional = (option === '?' || option === '*?') ? '?' : null;
        var star = (option === '*' || option === '*?') ? '*' : null;
        keys.push({ name: key, optional: !!optional });
        slash = slash || '';
        return ''
          + (optional ? '' : slash)
          + '(?:'
          + (optional ? slash : '')
          + (star && '(.+?)' || '([^/]+)')
          + (optional || '')
          + ')'
          + (optional || '');
      })
      .replace(/([/$*])/g, '\\$1');

    ret.regexp = new RegExp('^' + path + '$', insensitive ? 'i' : '');
    return ret;
  }

  /**
   * @ngdoc method
   * @name $routeProvider#otherwise
   *
   * @description
   * Sets route definition that will be used on route change when no other route definition
   * is matched.
   *
   * @param {Object|string} params Mapping information to be assigned to `$route.current`.
   * If called with a string, the value maps to `redirectTo`.
   * @returns {Object} self
   */
  this.otherwise = function(params) {
    if (typeof params === 'string') {
      params = {redirectTo: params};
    }
    this.when(null, params);
    return this;
  };


  this.$get = ['$rootScope',
               '$location',
               '$routeParams',
               '$q',
               '$injector',
               '$templateRequest',
               '$sce',
      function($rootScope, $location, $routeParams, $q, $injector, $templateRequest, $sce) {

    /**
     * @ngdoc service
     * @name $route
     * @requires $location
     * @requires $routeParams
     *
     * @property {Object} current Reference to the current route definition.
     * The route definition contains:
     *
     *   - `controller`: The controller constructor as defined in the route definition.
     *   - `locals`: A map of locals which is used by {@link ng.$controller $controller} service for
     *     controller instantiation. The `locals` contain
     *     the resolved values of the `resolve` map. Additionally the `locals` also contain:
     *
     *     - `$scope` - The current route scope.
     *     - `$template` - The current route template HTML.
     *
     *     The `locals` will be assigned to the route scope's `$resolve` property. You can override
     *     the property name, using `resolveAs` in the route definition. See
     *     {@link ngRoute.$routeProvider $routeProvider} for more info.
     *
     * @property {Object} routes Object with all route configuration Objects as its properties.
     *
     * @description
     * `$route` is used for deep-linking URLs to controllers and views (HTML partials).
     * It watches `$location.url()` and tries to map the path to an existing route definition.
     *
     * Requires the {@link ngRoute `ngRoute`} module to be installed.
     *
     * You can define routes through {@link ngRoute.$routeProvider $routeProvider}'s API.
     *
     * The `$route` service is typically used in conjunction with the
     * {@link ngRoute.directive:ngView `ngView`} directive and the
     * {@link ngRoute.$routeParams `$routeParams`} service.
     *
     * @example
     * This example shows how changing the URL hash causes the `$route` to match a route against the
     * URL, and the `ngView` pulls in the partial.
     *
     * <example name="$route-service" module="ngRouteExample"
     *          deps="angular-route.js" fixBase="true">
     *   <file name="index.html">
     *     <div ng-controller="MainController">
     *       Choose:
     *       <a href="Book/Moby">Moby</a> |
     *       <a href="Book/Moby/ch/1">Moby: Ch1</a> |
     *       <a href="Book/Gatsby">Gatsby</a> |
     *       <a href="Book/Gatsby/ch/4?key=value">Gatsby: Ch4</a> |
     *       <a href="Book/Scarlet">Scarlet Letter</a><br/>
     *
     *       <div ng-view></div>
     *
     *       <hr />
     *
     *       <pre>$location.path() = {{$location.path()}}</pre>
     *       <pre>$route.current.templateUrl = {{$route.current.templateUrl}}</pre>
     *       <pre>$route.current.params = {{$route.current.params}}</pre>
     *       <pre>$route.current.scope.name = {{$route.current.scope.name}}</pre>
     *       <pre>$routeParams = {{$routeParams}}</pre>
     *     </div>
     *   </file>
     *
     *   <file name="book.html">
     *     controller: {{name}}<br />
     *     Book Id: {{params.bookId}}<br />
     *   </file>
     *
     *   <file name="chapter.html">
     *     controller: {{name}}<br />
     *     Book Id: {{params.bookId}}<br />
     *     Chapter Id: {{params.chapterId}}
     *   </file>
     *
     *   <file name="script.js">
     *     angular.module('ngRouteExample', ['ngRoute'])
     *
     *      .controller('MainController', function($scope, $route, $routeParams, $location) {
     *          $scope.$route = $route;
     *          $scope.$location = $location;
     *          $scope.$routeParams = $routeParams;
     *      })
     *
     *      .controller('BookController', function($scope, $routeParams) {
     *          $scope.name = 'BookController';
     *          $scope.params = $routeParams;
     *      })
     *
     *      .controller('ChapterController', function($scope, $routeParams) {
     *          $scope.name = 'ChapterController';
     *          $scope.params = $routeParams;
     *      })
     *
     *     .config(function($routeProvider, $locationProvider) {
     *       $routeProvider
     *        .when('/Book/:bookId', {
     *         templateUrl: 'book.html',
     *         controller: 'BookController',
     *         resolve: {
     *           // I will cause a 1 second delay
     *           delay: function($q, $timeout) {
     *             var delay = $q.defer();
     *             $timeout(delay.resolve, 1000);
     *             return delay.promise;
     *           }
     *         }
     *       })
     *       .when('/Book/:bookId/ch/:chapterId', {
     *         templateUrl: 'chapter.html',
     *         controller: 'ChapterController'
     *       });
     *
     *       // configure html5 to get links working on jsfiddle
     *       $locationProvider.html5Mode(true);
     *     });
     *
     *   </file>
     *
     *   <file name="protractor.js" type="protractor">
     *     it('should load and compile correct template', function() {
     *       element(by.linkText('Moby: Ch1')).click();
     *       var content = element(by.css('[ng-view]')).getText();
     *       expect(content).toMatch(/controller: ChapterController/);
     *       expect(content).toMatch(/Book Id: Moby/);
     *       expect(content).toMatch(/Chapter Id: 1/);
     *
     *       element(by.partialLinkText('Scarlet')).click();
     *
     *       content = element(by.css('[ng-view]')).getText();
     *       expect(content).toMatch(/controller: BookController/);
     *       expect(content).toMatch(/Book Id: Scarlet/);
     *     });
     *   </file>
     * </example>
     */

    /**
     * @ngdoc event
     * @name $route#$routeChangeStart
     * @eventType broadcast on root scope
     * @description
     * Broadcasted before a route change. At this  point the route services starts
     * resolving all of the dependencies needed for the route change to occur.
     * Typically this involves fetching the view template as well as any dependencies
     * defined in `resolve` route property. Once  all of the dependencies are resolved
     * `$routeChangeSuccess` is fired.
     *
     * The route change (and the `$location` change that triggered it) can be prevented
     * by calling `preventDefault` method of the event. See {@link ng.$rootScope.Scope#$on}
     * for more details about event object.
     *
     * @param {Object} angularEvent Synthetic event object.
     * @param {Route} next Future route information.
     * @param {Route} current Current route information.
     */

    /**
     * @ngdoc event
     * @name $route#$routeChangeSuccess
     * @eventType broadcast on root scope
     * @description
     * Broadcasted after a route change has happened successfully.
     * The `resolve` dependencies are now available in the `current.locals` property.
     *
     * {@link ngRoute.directive:ngView ngView} listens for the directive
     * to instantiate the controller and render the view.
     *
     * @param {Object} angularEvent Synthetic event object.
     * @param {Route} current Current route information.
     * @param {Route|Undefined} previous Previous route information, or undefined if current is
     * first route entered.
     */

    /**
     * @ngdoc event
     * @name $route#$routeChangeError
     * @eventType broadcast on root scope
     * @description
     * Broadcasted if any of the resolve promises are rejected.
     *
     * @param {Object} angularEvent Synthetic event object
     * @param {Route} current Current route information.
     * @param {Route} previous Previous route information.
     * @param {Route} rejection Rejection of the promise. Usually the error of the failed promise.
     */

    /**
     * @ngdoc event
     * @name $route#$routeUpdate
     * @eventType broadcast on root scope
     * @description
     * The `reloadOnSearch` property has been set to false, and we are reusing the same
     * instance of the Controller.
     *
     * @param {Object} angularEvent Synthetic event object
     * @param {Route} current Current/previous route information.
     */

    var forceReload = false,
        preparedRoute,
        preparedRouteIsUpdateOnly,
        $route = {
          routes: routes,

          /**
           * @ngdoc method
           * @name $route#reload
           *
           * @description
           * Causes `$route` service to reload the current route even if
           * {@link ng.$location $location} hasn't changed.
           *
           * As a result of that, {@link ngRoute.directive:ngView ngView}
           * creates new scope and reinstantiates the controller.
           */
          reload: function() {
            forceReload = true;

            var fakeLocationEvent = {
              defaultPrevented: false,
              preventDefault: function fakePreventDefault() {
                this.defaultPrevented = true;
                forceReload = false;
              }
            };

            $rootScope.$evalAsync(function() {
              prepareRoute(fakeLocationEvent);
              if (!fakeLocationEvent.defaultPrevented) commitRoute();
            });
          },

          /**
           * @ngdoc method
           * @name $route#updateParams
           *
           * @description
           * Causes `$route` service to update the current URL, replacing
           * current route parameters with those specified in `newParams`.
           * Provided property names that match the route's path segment
           * definitions will be interpolated into the location's path, while
           * remaining properties will be treated as query params.
           *
           * @param {!Object<string, string>} newParams mapping of URL parameter names to values
           */
          updateParams: function(newParams) {
            if (this.current && this.current.$$route) {
              newParams = angular.extend({}, this.current.params, newParams);
              $location.path(interpolate(this.current.$$route.originalPath, newParams));
              // interpolate modifies newParams, only query params are left
              $location.search(newParams);
            } else {
              throw $routeMinErr('norout', 'Tried updating route when with no current route');
            }
          }
        };

    $rootScope.$on('$locationChangeStart', prepareRoute);
    $rootScope.$on('$locationChangeSuccess', commitRoute);

    return $route;

    /////////////////////////////////////////////////////

    /**
     * @param on {string} current url
     * @param route {Object} route regexp to match the url against
     * @return {?Object}
     *
     * @description
     * Check if the route matches the current url.
     *
     * Inspired by match in
     * visionmedia/express/lib/router/router.js.
     */
    function switchRouteMatcher(on, route) {
      var keys = route.keys,
          params = {};

      if (!route.regexp) return null;

      var m = route.regexp.exec(on);
      if (!m) return null;

      for (var i = 1, len = m.length; i < len; ++i) {
        var key = keys[i - 1];

        var val = m[i];

        if (key && val) {
          params[key.name] = val;
        }
      }
      return params;
    }

    function prepareRoute($locationEvent) {
      var lastRoute = $route.current;

      preparedRoute = parseRoute();
      preparedRouteIsUpdateOnly = preparedRoute && lastRoute && preparedRoute.$$route === lastRoute.$$route
          && angular.equals(preparedRoute.pathParams, lastRoute.pathParams)
          && !preparedRoute.reloadOnSearch && !forceReload;

      if (!preparedRouteIsUpdateOnly && (lastRoute || preparedRoute)) {
        if ($rootScope.$broadcast('$routeChangeStart', preparedRoute, lastRoute).defaultPrevented) {
          if ($locationEvent) {
            $locationEvent.preventDefault();
          }
        }
      }
    }

    function commitRoute() {
      var lastRoute = $route.current;
      var nextRoute = preparedRoute;

      if (preparedRouteIsUpdateOnly) {
        lastRoute.params = nextRoute.params;
        angular.copy(lastRoute.params, $routeParams);
        $rootScope.$broadcast('$routeUpdate', lastRoute);
      } else if (nextRoute || lastRoute) {
        forceReload = false;
        $route.current = nextRoute;
        if (nextRoute) {
          if (nextRoute.redirectTo) {
            if (angular.isString(nextRoute.redirectTo)) {
              $location.path(interpolate(nextRoute.redirectTo, nextRoute.params)).search(nextRoute.params)
                       .replace();
            } else {
              $location.url(nextRoute.redirectTo(nextRoute.pathParams, $location.path(), $location.search()))
                       .replace();
            }
          }
        }

        $q.when(nextRoute).
          then(resolveLocals).
          then(function(locals) {
            // after route change
            if (nextRoute === $route.current) {
              if (nextRoute) {
                nextRoute.locals = locals;
                angular.copy(nextRoute.params, $routeParams);
              }
              $rootScope.$broadcast('$routeChangeSuccess', nextRoute, lastRoute);
            }
          }, function(error) {
            if (nextRoute === $route.current) {
              $rootScope.$broadcast('$routeChangeError', nextRoute, lastRoute, error);
            }
          });
      }
    }

    function resolveLocals(route) {
      if (route) {
        var locals = angular.extend({}, route.resolve);
        angular.forEach(locals, function(value, key) {
          locals[key] = angular.isString(value) ?
              $injector.get(value) :
              $injector.invoke(value, null, null, key);
        });
        var template = getTemplateFor(route);
        if (angular.isDefined(template)) {
          locals['$template'] = template;
        }
        return $q.all(locals);
      }
    }


    function getTemplateFor(route) {
      var template, templateUrl;
      if (angular.isDefined(template = route.template)) {
        if (angular.isFunction(template)) {
          template = template(route.params);
        }
      } else if (angular.isDefined(templateUrl = route.templateUrl)) {
        if (angular.isFunction(templateUrl)) {
          templateUrl = templateUrl(route.params);
        }
        if (angular.isDefined(templateUrl)) {
          route.loadedTemplateUrl = $sce.valueOf(templateUrl);
          template = $templateRequest(templateUrl);
        }
      }
      return template;
    }


    /**
     * @returns {Object} the current active route, by matching it against the URL
     */
    function parseRoute() {
      // Match a route
      var params, match;
      angular.forEach(routes, function(route, path) {
        if (!match && (params = switchRouteMatcher($location.path(), route))) {
          match = inherit(route, {
            params: angular.extend({}, $location.search(), params),
            pathParams: params});
          match.$$route = route;
        }
      });
      // No route matched; fallback to "otherwise" route
      return match || routes[null] && inherit(routes[null], {params: {}, pathParams:{}});
    }

    /**
     * @returns {string} interpolation of the redirect path with the parameters
     */
    function interpolate(string, params) {
      var result = [];
      angular.forEach((string || '').split(':'), function(segment, i) {
        if (i === 0) {
          result.push(segment);
        } else {
          var segmentMatch = segment.match(/(\w+)(?:[?*])?(.*)/);
          var key = segmentMatch[1];
          result.push(params[key]);
          result.push(segmentMatch[2] || '');
          delete params[key];
        }
      });
      return result.join('');
    }
  }];
}

ngRouteModule.provider('$routeParams', $RouteParamsProvider);


/**
 * @ngdoc service
 * @name $routeParams
 * @requires $route
 * @this
 *
 * @description
 * The `$routeParams` service allows you to retrieve the current set of route parameters.
 *
 * Requires the {@link ngRoute `ngRoute`} module to be installed.
 *
 * The route parameters are a combination of {@link ng.$location `$location`}'s
 * {@link ng.$location#search `search()`} and {@link ng.$location#path `path()`}.
 * The `path` parameters are extracted when the {@link ngRoute.$route `$route`} path is matched.
 *
 * In case of parameter name collision, `path` params take precedence over `search` params.
 *
 * The service guarantees that the identity of the `$routeParams` object will remain unchanged
 * (but its properties will likely change) even when a route change occurs.
 *
 * Note that the `$routeParams` are only updated *after* a route change completes successfully.
 * This means that you cannot rely on `$routeParams` being correct in route resolve functions.
 * Instead you can use `$route.current.params` to access the new route's parameters.
 *
 * @example
 * ```js
 *  // Given:
 *  // URL: http://server.com/index.html#/Chapter/1/Section/2?search=moby
 *  // Route: /Chapter/:chapterId/Section/:sectionId
 *  //
 *  // Then
 *  $routeParams ==> {chapterId:'1', sectionId:'2', search:'moby'}
 * ```
 */
function $RouteParamsProvider() {
  this.$get = function() { return {}; };
}

ngRouteModule.directive('ngView', ngViewFactory);
ngRouteModule.directive('ngView', ngViewFillContentFactory);


/**
 * @ngdoc directive
 * @name ngView
 * @restrict ECA
 *
 * @description
 * # Overview
 * `ngView` is a directive that complements the {@link ngRoute.$route $route} service by
 * including the rendered template of the current route into the main layout (`index.html`) file.
 * Every time the current route changes, the included view changes with it according to the
 * configuration of the `$route` service.
 *
 * Requires the {@link ngRoute `ngRoute`} module to be installed.
 *
 * @animations
 * | Animation                        | Occurs                              |
 * |----------------------------------|-------------------------------------|
 * | {@link ng.$animate#enter enter}  | when the new element is inserted to the DOM |
 * | {@link ng.$animate#leave leave}  | when the old element is removed from to the DOM  |
 *
 * The enter and leave animation occur concurrently.
 *
 * @knownIssue If `ngView` is contained in an asynchronously loaded template (e.g. in another
 *             directive's templateUrl or in a template loaded using `ngInclude`), then you need to
 *             make sure that `$route` is instantiated in time to capture the initial
 *             `$locationChangeStart` event and load the appropriate view. One way to achieve this
 *             is to have it as a dependency in a `.run` block:
 *             `myModule.run(['$route', function() {}]);`
 *
 * @scope
 * @priority 400
 * @param {string=} onload Expression to evaluate whenever the view updates.
 *
 * @param {string=} autoscroll Whether `ngView` should call {@link ng.$anchorScroll
 *                  $anchorScroll} to scroll the viewport after the view is updated.
 *
 *                  - If the attribute is not set, disable scrolling.
 *                  - If the attribute is set without value, enable scrolling.
 *                  - Otherwise enable scrolling only if the `autoscroll` attribute value evaluated
 *                    as an expression yields a truthy value.
 * @example
    <example name="ngView-directive" module="ngViewExample"
             deps="angular-route.js;angular-animate.js"
             animations="true" fixBase="true">
      <file name="index.html">
        <div ng-controller="MainCtrl as main">
          Choose:
          <a href="Book/Moby">Moby</a> |
          <a href="Book/Moby/ch/1">Moby: Ch1</a> |
          <a href="Book/Gatsby">Gatsby</a> |
          <a href="Book/Gatsby/ch/4?key=value">Gatsby: Ch4</a> |
          <a href="Book/Scarlet">Scarlet Letter</a><br/>

          <div class="view-animate-container">
            <div ng-view class="view-animate"></div>
          </div>
          <hr />

          <pre>$location.path() = {{main.$location.path()}}</pre>
          <pre>$route.current.templateUrl = {{main.$route.current.templateUrl}}</pre>
          <pre>$route.current.params = {{main.$route.current.params}}</pre>
          <pre>$routeParams = {{main.$routeParams}}</pre>
        </div>
      </file>

      <file name="book.html">
        <div>
          controller: {{book.name}}<br />
          Book Id: {{book.params.bookId}}<br />
        </div>
      </file>

      <file name="chapter.html">
        <div>
          controller: {{chapter.name}}<br />
          Book Id: {{chapter.params.bookId}}<br />
          Chapter Id: {{chapter.params.chapterId}}
        </div>
      </file>

      <file name="animations.css">
        .view-animate-container {
          position:relative;
          height:100px!important;
          background:white;
          border:1px solid black;
          height:40px;
          overflow:hidden;
        }

        .view-animate {
          padding:10px;
        }

        .view-animate.ng-enter, .view-animate.ng-leave {
          transition:all cubic-bezier(0.250, 0.460, 0.450, 0.940) 1.5s;

          display:block;
          width:100%;
          border-left:1px solid black;

          position:absolute;
          top:0;
          left:0;
          right:0;
          bottom:0;
          padding:10px;
        }

        .view-animate.ng-enter {
          left:100%;
        }
        .view-animate.ng-enter.ng-enter-active {
          left:0;
        }
        .view-animate.ng-leave.ng-leave-active {
          left:-100%;
        }
      </file>

      <file name="script.js">
        angular.module('ngViewExample', ['ngRoute', 'ngAnimate'])
          .config(['$routeProvider', '$locationProvider',
            function($routeProvider, $locationProvider) {
              $routeProvider
                .when('/Book/:bookId', {
                  templateUrl: 'book.html',
                  controller: 'BookCtrl',
                  controllerAs: 'book'
                })
                .when('/Book/:bookId/ch/:chapterId', {
                  templateUrl: 'chapter.html',
                  controller: 'ChapterCtrl',
                  controllerAs: 'chapter'
                });

              $locationProvider.html5Mode(true);
          }])
          .controller('MainCtrl', ['$route', '$routeParams', '$location',
            function MainCtrl($route, $routeParams, $location) {
              this.$route = $route;
              this.$location = $location;
              this.$routeParams = $routeParams;
          }])
          .controller('BookCtrl', ['$routeParams', function BookCtrl($routeParams) {
            this.name = 'BookCtrl';
            this.params = $routeParams;
          }])
          .controller('ChapterCtrl', ['$routeParams', function ChapterCtrl($routeParams) {
            this.name = 'ChapterCtrl';
            this.params = $routeParams;
          }]);

      </file>

      <file name="protractor.js" type="protractor">
        it('should load and compile correct template', function() {
          element(by.linkText('Moby: Ch1')).click();
          var content = element(by.css('[ng-view]')).getText();
          expect(content).toMatch(/controller: ChapterCtrl/);
          expect(content).toMatch(/Book Id: Moby/);
          expect(content).toMatch(/Chapter Id: 1/);

          element(by.partialLinkText('Scarlet')).click();

          content = element(by.css('[ng-view]')).getText();
          expect(content).toMatch(/controller: BookCtrl/);
          expect(content).toMatch(/Book Id: Scarlet/);
        });
      </file>
    </example>
 */


/**
 * @ngdoc event
 * @name ngView#$viewContentLoaded
 * @eventType emit on the current ngView scope
 * @description
 * Emitted every time the ngView content is reloaded.
 */
ngViewFactory.$inject = ['$route', '$anchorScroll', '$animate'];
function ngViewFactory($route, $anchorScroll, $animate) {
  return {
    restrict: 'ECA',
    terminal: true,
    priority: 400,
    transclude: 'element',
    link: function(scope, $element, attr, ctrl, $transclude) {
        var currentScope,
            currentElement,
            previousLeaveAnimation,
            autoScrollExp = attr.autoscroll,
            onloadExp = attr.onload || '';

        scope.$on('$routeChangeSuccess', update);
        update();

        function cleanupLastView() {
          if (previousLeaveAnimation) {
            $animate.cancel(previousLeaveAnimation);
            previousLeaveAnimation = null;
          }

          if (currentScope) {
            currentScope.$destroy();
            currentScope = null;
          }
          if (currentElement) {
            previousLeaveAnimation = $animate.leave(currentElement);
            previousLeaveAnimation.done(function(response) {
              if (response !== false) previousLeaveAnimation = null;
            });
            currentElement = null;
          }
        }

        function update() {
          var locals = $route.current && $route.current.locals,
              template = locals && locals.$template;

          if (angular.isDefined(template)) {
            var newScope = scope.$new();
            var current = $route.current;

            // Note: This will also link all children of ng-view that were contained in the original
            // html. If that content contains controllers, ... they could pollute/change the scope.
            // However, using ng-view on an element with additional content does not make sense...
            // Note: We can't remove them in the cloneAttchFn of $transclude as that
            // function is called before linking the content, which would apply child
            // directives to non existing elements.
            var clone = $transclude(newScope, function(clone) {
              $animate.enter(clone, null, currentElement || $element).done(function onNgViewEnter(response) {
                if (response !== false && angular.isDefined(autoScrollExp)
                  && (!autoScrollExp || scope.$eval(autoScrollExp))) {
                  $anchorScroll();
                }
              });
              cleanupLastView();
            });

            currentElement = clone;
            currentScope = current.scope = newScope;
            currentScope.$emit('$viewContentLoaded');
            currentScope.$eval(onloadExp);
          } else {
            cleanupLastView();
          }
        }
    }
  };
}

// This directive is called during the $transclude call of the first `ngView` directive.
// It will replace and compile the content of the element with the loaded template.
// We need this directive so that the element content is already filled when
// the link function of another directive on the same element as ngView
// is called.
ngViewFillContentFactory.$inject = ['$compile', '$controller', '$route'];
function ngViewFillContentFactory($compile, $controller, $route) {
  return {
    restrict: 'ECA',
    priority: -400,
    link: function(scope, $element) {
      var current = $route.current,
          locals = current.locals;

      $element.html(locals.$template);

      var link = $compile($element.contents());

      if (current.controller) {
        locals.$scope = scope;
        var controller = $controller(current.controller, locals);
        if (current.controllerAs) {
          scope[current.controllerAs] = controller;
        }
        $element.data('$ngControllerController', controller);
        $element.children().data('$ngControllerController', controller);
      }
      scope[current.resolveAs || '$resolve'] = locals;

      link(scope);
    }
  };
}


})(window, window.angular);

/*!
 * ui-select
 * http://github.com/angular-ui/ui-select
 * Version: 0.13.2 - 2015-10-09T15:34:24.040Z
 * License: MIT
 */


(function () { 
"use strict";

var KEY = {
    TAB: 9,
    ENTER: 13,
    ESC: 27,
    SPACE: 32,
    LEFT: 37,
    UP: 38,
    RIGHT: 39,
    DOWN: 40,
    SHIFT: 16,
    CTRL: 17,
    ALT: 18,
    PAGE_UP: 33,
    PAGE_DOWN: 34,
    HOME: 36,
    END: 35,
    BACKSPACE: 8,
    DELETE: 46,
    COMMAND: 91,

    MAP: { 91 : "COMMAND", 8 : "BACKSPACE" , 9 : "TAB" , 13 : "ENTER" , 16 : "SHIFT" , 17 : "CTRL" , 18 : "ALT" , 19 : "PAUSEBREAK" , 20 : "CAPSLOCK" , 27 : "ESC" , 32 : "SPACE" , 33 : "PAGE_UP", 34 : "PAGE_DOWN" , 35 : "END" , 36 : "HOME" , 37 : "LEFT" , 38 : "UP" , 39 : "RIGHT" , 40 : "DOWN" , 43 : "+" , 44 : "PRINTSCREEN" , 45 : "INSERT" , 46 : "DELETE", 48 : "0" , 49 : "1" , 50 : "2" , 51 : "3" , 52 : "4" , 53 : "5" , 54 : "6" , 55 : "7" , 56 : "8" , 57 : "9" , 59 : ";", 61 : "=" , 65 : "A" , 66 : "B" , 67 : "C" , 68 : "D" , 69 : "E" , 70 : "F" , 71 : "G" , 72 : "H" , 73 : "I" , 74 : "J" , 75 : "K" , 76 : "L", 77 : "M" , 78 : "N" , 79 : "O" , 80 : "P" , 81 : "Q" , 82 : "R" , 83 : "S" , 84 : "T" , 85 : "U" , 86 : "V" , 87 : "W" , 88 : "X" , 89 : "Y" , 90 : "Z", 96 : "0" , 97 : "1" , 98 : "2" , 99 : "3" , 100 : "4" , 101 : "5" , 102 : "6" , 103 : "7" , 104 : "8" , 105 : "9", 106 : "*" , 107 : "+" , 109 : "-" , 110 : "." , 111 : "/", 112 : "F1" , 113 : "F2" , 114 : "F3" , 115 : "F4" , 116 : "F5" , 117 : "F6" , 118 : "F7" , 119 : "F8" , 120 : "F9" , 121 : "F10" , 122 : "F11" , 123 : "F12", 144 : "NUMLOCK" , 145 : "SCROLLLOCK" , 186 : ";" , 187 : "=" , 188 : "," , 189 : "-" , 190 : "." , 191 : "/" , 192 : "`" , 219 : "[" , 220 : "\\" , 221 : "]" , 222 : "'"
    },

    isControl: function (e) {
        var k = e.which;
        switch (k) {
        case KEY.COMMAND:
        case KEY.SHIFT:
        case KEY.CTRL:
        case KEY.ALT:
            return true;
        }

        if (e.metaKey) return true;

        return false;
    },
    isFunctionKey: function (k) {
        k = k.which ? k.which : k;
        return k >= 112 && k <= 123;
    },
    isVerticalMovement: function (k){
      return ~[KEY.UP, KEY.DOWN].indexOf(k);
    },
    isHorizontalMovement: function (k){
      return ~[KEY.LEFT,KEY.RIGHT,KEY.BACKSPACE,KEY.DELETE].indexOf(k);
    }
  };

/**
 * Add querySelectorAll() to jqLite.
 *
 * jqLite find() is limited to lookups by tag name.
 * TODO This will change with future versions of AngularJS, to be removed when this happens
 *
 * See jqLite.find - why not use querySelectorAll? https://github.com/angular/angular.js/issues/3586
 * See feat(jqLite): use querySelectorAll instead of getElementsByTagName in jqLite.find https://github.com/angular/angular.js/pull/3598
 */
if (angular.element.prototype.querySelectorAll === undefined) {
  angular.element.prototype.querySelectorAll = function(selector) {
    return angular.element(this[0].querySelectorAll(selector));
  };
}

/**
 * Add closest() to jqLite.
 */
if (angular.element.prototype.closest === undefined) {
  angular.element.prototype.closest = function( selector) {
    var elem = this[0];
    var matchesSelector = elem.matches || elem.webkitMatchesSelector || elem.mozMatchesSelector || elem.msMatchesSelector;

    while (elem) {
      if (matchesSelector.bind(elem)(selector)) {
        return elem;
      } else {
        elem = elem.parentElement;
      }
    }
    return false;
  };
}

var latestId = 0;

var uis = angular.module('ui.select', [])

.constant('uiSelectConfig', {
  theme: 'bootstrap',
  searchEnabled: true,
  sortable: false,
  placeholder: '', // Empty by default, like HTML tag <select>
  refreshDelay: 1000, // In milliseconds
  closeOnSelect: true,
  dropdownPosition: 'auto',
  generateId: function() {
    return latestId++;
  },
  appendToBody: false
})

// See Rename minErr and make it accessible from outside https://github.com/angular/angular.js/issues/6913
.service('uiSelectMinErr', function() {
  var minErr = angular.$$minErr('ui.select');
  return function() {
    var error = minErr.apply(this, arguments);
    var message = error.message.replace(new RegExp('\nhttp://errors.angularjs.org/.*'), '');
    return new Error(message);
  };
})

// Recreates old behavior of ng-transclude. Used internally.
.directive('uisTranscludeAppend', function () {
  return {
    link: function (scope, element, attrs, ctrl, transclude) {
        transclude(scope, function (clone) {
          element.append(clone);
        });
      }
    };
})

/**
 * Highlights text that matches $select.search.
 *
 * Taken from AngularUI Bootstrap Typeahead
 * See https://github.com/angular-ui/bootstrap/blob/0.10.0/src/typeahead/typeahead.js#L340
 */
.filter('highlight', function() {
  function escapeRegexp(queryToEscape) {
    return queryToEscape.replace(/([.?*+^$[\]\\(){}|-])/g, '\\$1');
  }

  return function(matchItem, query) {
    return query && matchItem ? matchItem.replace(new RegExp(escapeRegexp(query), 'gi'), '<span class="ui-select-highlight">$&</span>') : matchItem;
  };
})

/**
 * A read-only equivalent of jQuery's offset function: http://api.jquery.com/offset/
 *
 * Taken from AngularUI Bootstrap Position:
 * See https://github.com/angular-ui/bootstrap/blob/master/src/position/position.js#L70
 */
.factory('uisOffset',
  ['$document', '$window',
  function ($document, $window) {

  return function(element) {
    var boundingClientRect = element[0].getBoundingClientRect();
    return {
      width: boundingClientRect.width || element.prop('offsetWidth'),
      height: boundingClientRect.height || element.prop('offsetHeight'),
      top: boundingClientRect.top + ($window.pageYOffset || $document[0].documentElement.scrollTop),
      left: boundingClientRect.left + ($window.pageXOffset || $document[0].documentElement.scrollLeft)
    };
  };
}]);

uis.directive('uiSelectChoices',
  ['uiSelectConfig', 'uisRepeatParser', 'uiSelectMinErr', '$compile',
  function(uiSelectConfig, RepeatParser, uiSelectMinErr, $compile) {

  return {
    restrict: 'EA',
    require: '^uiSelect',
    replace: true,
    transclude: true,
    templateUrl: function(tElement) {
      // Gets theme attribute from parent (ui-select)
      var theme = tElement.parent().attr('theme') || uiSelectConfig.theme;
      return theme + '/choices.tpl.html';
    },

    compile: function(tElement, tAttrs) {

      if (!tAttrs.repeat) throw uiSelectMinErr('repeat', "Expected 'repeat' expression.");

      return function link(scope, element, attrs, $select, transcludeFn) {

        // var repeat = RepeatParser.parse(attrs.repeat);
        var groupByExp = attrs.groupBy;
        var groupFilterExp = attrs.groupFilter;

        $select.parseRepeatAttr(attrs.repeat, groupByExp, groupFilterExp); //Result ready at $select.parserResult

        $select.disableChoiceExpression = attrs.uiDisableChoice;
        $select.onHighlightCallback = attrs.onHighlight;

        $select.dropdownPosition = attrs.position ? attrs.position.toLowerCase() : uiSelectConfig.dropdownPosition;

        if(groupByExp) {
          var groups = element.querySelectorAll('.ui-select-choices-group');
          if (groups.length !== 1) throw uiSelectMinErr('rows', "Expected 1 .ui-select-choices-group but got '{0}'.", groups.length);
          groups.attr('ng-repeat', RepeatParser.getGroupNgRepeatExpression());
        }

        var choices = element.querySelectorAll('.ui-select-choices-row');
        if (choices.length !== 1) {
          throw uiSelectMinErr('rows', "Expected 1 .ui-select-choices-row but got '{0}'.", choices.length);
        }

        choices.attr('ng-repeat', $select.parserResult.repeatExpression(groupByExp))
            .attr('ng-if', '$select.open') //Prevent unnecessary watches when dropdown is closed
            .attr('ng-click', '$select.select(' + $select.parserResult.itemName + ',false,$event)');

        var rowsInner = element.querySelectorAll('.ui-select-choices-row-inner');
        if (rowsInner.length !== 1) throw uiSelectMinErr('rows', "Expected 1 .ui-select-choices-row-inner but got '{0}'.", rowsInner.length);
        rowsInner.attr('uis-transclude-append', ''); //Adding uisTranscludeAppend directive to row element after choices element has ngRepeat

        $compile(element, transcludeFn)(scope); //Passing current transcludeFn to be able to append elements correctly from uisTranscludeAppend

        scope.$watch('$select.search', function(newValue) {
          if(newValue && !$select.open && $select.multiple) $select.activate(false, true);
          $select.activeIndex = $select.tagging.isActivated ? -1 : 0;
          $select.refresh(attrs.refresh);
        });

        attrs.$observe('refreshDelay', function() {
          // $eval() is needed otherwise we get a string instead of a number
          var refreshDelay = scope.$eval(attrs.refreshDelay);
          $select.refreshDelay = refreshDelay !== undefined ? refreshDelay : uiSelectConfig.refreshDelay;
        });
      };
    }
  };
}]);

/**
 * Contains ui-select "intelligence".
 *
 * The goal is to limit dependency on the DOM whenever possible and
 * put as much logic in the controller (instead of the link functions) as possible so it can be easily tested.
 */
uis.controller('uiSelectCtrl',
  ['$scope', '$element', '$timeout', '$filter', 'uisRepeatParser', 'uiSelectMinErr', 'uiSelectConfig', '$parse',
  function($scope, $element, $timeout, $filter, RepeatParser, uiSelectMinErr, uiSelectConfig, $parse) {

  var ctrl = this;

  var EMPTY_SEARCH = '';

  ctrl.placeholder = uiSelectConfig.placeholder;
  ctrl.searchEnabled = uiSelectConfig.searchEnabled;
  ctrl.sortable = uiSelectConfig.sortable;
  ctrl.refreshDelay = uiSelectConfig.refreshDelay;

  ctrl.removeSelected = false; //If selected item(s) should be removed from dropdown list
  ctrl.closeOnSelect = true; //Initialized inside uiSelect directive link function
  ctrl.search = EMPTY_SEARCH;

  ctrl.activeIndex = 0; //Dropdown of choices
  ctrl.items = []; //All available choices

  ctrl.open = false;
  ctrl.focus = false;
  ctrl.disabled = false;
  ctrl.selected = undefined;

  ctrl.dropdownPosition = 'auto';

  ctrl.focusser = undefined; //Reference to input element used to handle focus events
  ctrl.resetSearchInput = true;
  ctrl.multiple = undefined; // Initialized inside uiSelect directive link function
  ctrl.disableChoiceExpression = undefined; // Initialized inside uiSelectChoices directive link function
  ctrl.tagging = {isActivated: false, fct: undefined};
  ctrl.taggingTokens = {isActivated: false, tokens: undefined};
  ctrl.lockChoiceExpression = undefined; // Initialized inside uiSelectMatch directive link function
  ctrl.clickTriggeredSelect = false;
  ctrl.$filter = $filter;

  ctrl.searchInput = $element.querySelectorAll('input.ui-select-search');
  if (ctrl.searchInput.length !== 1) {
    throw uiSelectMinErr('searchInput', "Expected 1 input.ui-select-search but got '{0}'.", ctrl.searchInput.length);
  }
  
  ctrl.isEmpty = function() {
    return angular.isUndefined(ctrl.selected) || ctrl.selected === null || ctrl.selected === '';
  };

  // Most of the time the user does not want to empty the search input when in typeahead mode
  function _resetSearchInput() {
    if (ctrl.resetSearchInput || (ctrl.resetSearchInput === undefined && uiSelectConfig.resetSearchInput)) {
      ctrl.search = EMPTY_SEARCH;
      //reset activeIndex
      if (ctrl.selected && ctrl.items.length && !ctrl.multiple) {
        ctrl.activeIndex = ctrl.items.indexOf(ctrl.selected);
      }
    }
  }

    function _groupsFilter(groups, groupNames) {
      var i, j, result = [];
      for(i = 0; i < groupNames.length ;i++){
        for(j = 0; j < groups.length ;j++){
          if(groups[j].name == [groupNames[i]]){
            result.push(groups[j]);
          }
        }
      }
      return result;
    }

  // When the user clicks on ui-select, displays the dropdown list
  ctrl.activate = function(initSearchValue, avoidReset) {
    if (!ctrl.disabled  && !ctrl.open) {
      if(!avoidReset) _resetSearchInput();

      $scope.$broadcast('uis:activate');

      ctrl.open = true;

      ctrl.activeIndex = ctrl.activeIndex >= ctrl.items.length ? 0 : ctrl.activeIndex;

      // ensure that the index is set to zero for tagging variants
      // that where first option is auto-selected
      if ( ctrl.activeIndex === -1 && ctrl.taggingLabel !== false ) {
        ctrl.activeIndex = 0;
      }

      // Give it time to appear before focus
      $timeout(function() {
        ctrl.search = initSearchValue || ctrl.search;
        ctrl.searchInput[0].focus();
        if(!ctrl.tagging.isActivated && ctrl.items.length > 1) {
          _ensureHighlightVisible();
        }
      });
    }
  };

  ctrl.findGroupByName = function(name) {
    return ctrl.groups && ctrl.groups.filter(function(group) {
      return group.name === name;
    })[0];
  };

  ctrl.parseRepeatAttr = function(repeatAttr, groupByExp, groupFilterExp) {
    function updateGroups(items) {
      var groupFn = $scope.$eval(groupByExp);
      ctrl.groups = [];
      angular.forEach(items, function(item) {
        var groupName = angular.isFunction(groupFn) ? groupFn(item) : item[groupFn];
        var group = ctrl.findGroupByName(groupName);
        if(group) {
          group.items.push(item);
        }
        else {
          ctrl.groups.push({name: groupName, items: [item]});
        }
      });
      if(groupFilterExp){
        var groupFilterFn = $scope.$eval(groupFilterExp);
        if( angular.isFunction(groupFilterFn)){
          ctrl.groups = groupFilterFn(ctrl.groups);
        } else if(angular.isArray(groupFilterFn)){
          ctrl.groups = _groupsFilter(ctrl.groups, groupFilterFn);
        }
      }
      ctrl.items = [];
      ctrl.groups.forEach(function(group) {
        ctrl.items = ctrl.items.concat(group.items);
      });
    }

    function setPlainItems(items) {
      ctrl.items = items;
    }

    ctrl.setItemsFn = groupByExp ? updateGroups : setPlainItems;

    ctrl.parserResult = RepeatParser.parse(repeatAttr);

    ctrl.isGrouped = !!groupByExp;
    ctrl.itemProperty = ctrl.parserResult.itemName;

    //If collection is an Object, convert it to Array

    var originalSource = ctrl.parserResult.source;
    
    //When an object is used as source, we better create an array and use it as 'source'
    var createArrayFromObject = function(){
      var origSrc = originalSource($scope);
      $scope.$uisSource = Object.keys(origSrc).map(function(v){
        var result = {};
        result[ctrl.parserResult.keyName] = v;
        result.value = origSrc[v];
        return result;
      });
    };

    if (ctrl.parserResult.keyName){ // Check for (key,value) syntax
      createArrayFromObject();
      ctrl.parserResult.source = $parse('$uisSource' + ctrl.parserResult.filters);
      $scope.$watch(originalSource, function(newVal, oldVal){
        if (newVal !== oldVal) createArrayFromObject();
      }, true);
    }

    ctrl.refreshItems = function (data){
      data = data || ctrl.parserResult.source($scope);
      var selectedItems = ctrl.selected;
      //TODO should implement for single mode removeSelected
      if (ctrl.isEmpty() || (angular.isArray(selectedItems) && !selectedItems.length) || !ctrl.removeSelected) {
        ctrl.setItemsFn(data);
      }else{
        if ( data !== undefined ) {
          var filteredItems = data.filter(function(i) {return selectedItems && selectedItems.indexOf(i) < 0;});
          ctrl.setItemsFn(filteredItems);
        }
      }
      if (ctrl.dropdownPosition === 'auto' || ctrl.dropdownPosition === 'up'){
        $scope.calculateDropdownPos();
      }
    };

    // See https://github.com/angular/angular.js/blob/v1.2.15/src/ng/directive/ngRepeat.js#L259
    $scope.$watchCollection(ctrl.parserResult.source, function(items) {
      if (items === undefined || items === null) {
        // If the user specifies undefined or null => reset the collection
        // Special case: items can be undefined if the user did not initialized the collection on the scope
        // i.e $scope.addresses = [] is missing
        ctrl.items = [];
      } else {
        if (!angular.isArray(items)) {
          throw uiSelectMinErr('items', "Expected an array but got '{0}'.", items);          
        } else {
          //Remove already selected items (ex: while searching)
          //TODO Should add a test
          ctrl.refreshItems(items);
          ctrl.ngModel.$modelValue = null; //Force scope model value and ngModel value to be out of sync to re-run formatters
        }
      }
    });

  };

  var _refreshDelayPromise;

  /**
   * Typeahead mode: lets the user refresh the collection using his own function.
   *
   * See Expose $select.search for external / remote filtering https://github.com/angular-ui/ui-select/pull/31
   */
  ctrl.refresh = function(refreshAttr) {
    if (refreshAttr !== undefined) {

      // Debounce
      // See https://github.com/angular-ui/bootstrap/blob/0.10.0/src/typeahead/typeahead.js#L155
      // FYI AngularStrap typeahead does not have debouncing: https://github.com/mgcrea/angular-strap/blob/v2.0.0-rc.4/src/typeahead/typeahead.js#L177
      if (_refreshDelayPromise) {
        $timeout.cancel(_refreshDelayPromise);
      }
      _refreshDelayPromise = $timeout(function() {
        $scope.$eval(refreshAttr);
      }, ctrl.refreshDelay);
    }
  };

  ctrl.isActive = function(itemScope) {
    if ( !ctrl.open ) {
      return false;
    }
    var itemIndex = ctrl.items.indexOf(itemScope[ctrl.itemProperty]);
    var isActive =  itemIndex === ctrl.activeIndex;

    if ( !isActive || ( itemIndex < 0 && ctrl.taggingLabel !== false ) ||( itemIndex < 0 && ctrl.taggingLabel === false) ) {
      return false;
    }

    if (isActive && !angular.isUndefined(ctrl.onHighlightCallback)) {
      itemScope.$eval(ctrl.onHighlightCallback);
    }

    return isActive;
  };

  ctrl.isDisabled = function(itemScope) {

    if (!ctrl.open) return;

    var itemIndex = ctrl.items.indexOf(itemScope[ctrl.itemProperty]);
    var isDisabled = false;
    var item;

    if (itemIndex >= 0 && !angular.isUndefined(ctrl.disableChoiceExpression)) {
      item = ctrl.items[itemIndex];
      isDisabled = !!(itemScope.$eval(ctrl.disableChoiceExpression)); // force the boolean value
      item._uiSelectChoiceDisabled = isDisabled; // store this for later reference
    }

    return isDisabled;
  };


  // When the user selects an item with ENTER or clicks the dropdown
  ctrl.select = function(item, skipFocusser, $event) {
    if (item === undefined || !item._uiSelectChoiceDisabled) {

      if ( ! ctrl.items && ! ctrl.search ) return;

      if (!item || !item._uiSelectChoiceDisabled) {
        if(ctrl.tagging.isActivated) {
          // if taggingLabel is disabled, we pull from ctrl.search val
          if ( ctrl.taggingLabel === false ) {
            if ( ctrl.activeIndex < 0 ) {
              item = ctrl.tagging.fct !== undefined ? ctrl.tagging.fct(ctrl.search) : ctrl.search;
              if (!item || angular.equals( ctrl.items[0], item ) ) {
                return;
              }
            } else {
              // keyboard nav happened first, user selected from dropdown
              item = ctrl.items[ctrl.activeIndex];
            }
          } else {
            // tagging always operates at index zero, taggingLabel === false pushes
            // the ctrl.search value without having it injected
            if ( ctrl.activeIndex === 0 ) {
              // ctrl.tagging pushes items to ctrl.items, so we only have empty val
              // for `item` if it is a detected duplicate
              if ( item === undefined ) return;

              // create new item on the fly if we don't already have one;
              // use tagging function if we have one
              if ( ctrl.tagging.fct !== undefined && typeof item === 'string' ) {
                item = ctrl.tagging.fct(ctrl.search);
                if (!item) return;
              // if item type is 'string', apply the tagging label
              } else if ( typeof item === 'string' ) {
                // trim the trailing space
                item = item.replace(ctrl.taggingLabel,'').trim();
              }
            }
          }
          // search ctrl.selected for dupes potentially caused by tagging and return early if found
          if ( ctrl.selected && angular.isArray(ctrl.selected) && ctrl.selected.filter( function (selection) { return angular.equals(selection, item); }).length > 0 ) {
            ctrl.close(skipFocusser);
            return;
          }
        }

        $scope.$broadcast('uis:select', item);

        var locals = {};
        locals[ctrl.parserResult.itemName] = item;

        $timeout(function(){
          ctrl.onSelectCallback($scope, {
            $item: item,
            $model: ctrl.parserResult.modelMapper($scope, locals)
          });
        });

        if (ctrl.closeOnSelect) {
          ctrl.close(skipFocusser);
        }
        if ($event && $event.type === 'click') {
          ctrl.clickTriggeredSelect = true;
        }
      }
    }
  };

  // Closes the dropdown
  ctrl.close = function(skipFocusser) {
    if (!ctrl.open) return;
    if (ctrl.ngModel && ctrl.ngModel.$setTouched) ctrl.ngModel.$setTouched();
    _resetSearchInput();
    ctrl.open = false;

    $scope.$broadcast('uis:close', skipFocusser);

  };

  ctrl.setFocus = function(){
    if (!ctrl.focus) ctrl.focusInput[0].focus();
  };

  ctrl.clear = function($event) {
    ctrl.select(undefined);
    $event.stopPropagation();
    $timeout(function() {
      ctrl.focusser[0].focus();
    }, 0, false);
  };

  // Toggle dropdown
  ctrl.toggle = function(e) {
    if (ctrl.open) {
      ctrl.close();
      e.preventDefault();
      e.stopPropagation();
    } else {
      ctrl.activate();
    }
  };

  ctrl.isLocked = function(itemScope, itemIndex) {
      var isLocked, item = ctrl.selected[itemIndex];

      if (item && !angular.isUndefined(ctrl.lockChoiceExpression)) {
          isLocked = !!(itemScope.$eval(ctrl.lockChoiceExpression)); // force the boolean value
          item._uiSelectChoiceLocked = isLocked; // store this for later reference
      }

      return isLocked;
  };

  var sizeWatch = null;
  ctrl.sizeSearchInput = function() {

    var input = ctrl.searchInput[0],
        container = ctrl.searchInput.parent().parent()[0],
        calculateContainerWidth = function() {
          // Return the container width only if the search input is visible
          return container.clientWidth * !!input.offsetParent;
        },
        updateIfVisible = function(containerWidth) {
          if (containerWidth === 0) {
            return false;
          }
          var inputWidth = containerWidth - input.offsetLeft - 10;
          if (inputWidth < 50) inputWidth = containerWidth;
          ctrl.searchInput.css('width', inputWidth+'px');
          return true;
        };

    ctrl.searchInput.css('width', '10px');
    $timeout(function() { //Give tags time to render correctly
      if (sizeWatch === null && !updateIfVisible(calculateContainerWidth())) {
        sizeWatch = $scope.$watch(calculateContainerWidth, function(containerWidth) {
          if (updateIfVisible(containerWidth)) {
            sizeWatch();
            sizeWatch = null;
          }
        });
      }
    });
  };

  function _handleDropDownSelection(key) {
    var processed = true;
    switch (key) {
      case KEY.DOWN:
        if (!ctrl.open && ctrl.multiple) ctrl.activate(false, true); //In case its the search input in 'multiple' mode
        else if (ctrl.activeIndex < ctrl.items.length - 1) { ctrl.activeIndex++; }
        break;
      case KEY.UP:
        if (!ctrl.open && ctrl.multiple) ctrl.activate(false, true); //In case its the search input in 'multiple' mode
        else if (ctrl.activeIndex > 0 || (ctrl.search.length === 0 && ctrl.tagging.isActivated && ctrl.activeIndex > -1)) { ctrl.activeIndex--; }
        break;
      case KEY.TAB:
        if (!ctrl.multiple || ctrl.open) ctrl.select(ctrl.items[ctrl.activeIndex], true);
        break;
      case KEY.ENTER:
        if(ctrl.open && (ctrl.tagging.isActivated || ctrl.activeIndex >= 0)){
          ctrl.select(ctrl.items[ctrl.activeIndex]); // Make sure at least one dropdown item is highlighted before adding if not in tagging mode
        } else {
          ctrl.activate(false, true); //In case its the search input in 'multiple' mode
        }
        break;
      case KEY.ESC:
        ctrl.close();
        break;
      default:
        processed = false;
    }
    return processed;
  }

  // Bind to keyboard shortcuts
  ctrl.searchInput.on('keydown', function(e) {

    var key = e.which;

    // if(~[KEY.ESC,KEY.TAB].indexOf(key)){
    //   //TODO: SEGURO?
    //   ctrl.close();
    // }

    $scope.$apply(function() {

      var tagged = false;

      if (ctrl.items.length > 0 || ctrl.tagging.isActivated) {
        _handleDropDownSelection(key);
        if ( ctrl.taggingTokens.isActivated ) {
          for (var i = 0; i < ctrl.taggingTokens.tokens.length; i++) {
            if ( ctrl.taggingTokens.tokens[i] === KEY.MAP[e.keyCode] ) {
              // make sure there is a new value to push via tagging
              if ( ctrl.search.length > 0 ) {
                tagged = true;
              }
            }
          }
          if ( tagged ) {
            $timeout(function() {
              ctrl.searchInput.triggerHandler('tagged');
              var newItem = ctrl.search.replace(KEY.MAP[e.keyCode],'').trim();
              if ( ctrl.tagging.fct ) {
                newItem = ctrl.tagging.fct( newItem );
              }
              if (newItem) ctrl.select(newItem, true);
            });
          }
        }
      }

    });

    if(KEY.isVerticalMovement(key) && ctrl.items.length > 0){
      _ensureHighlightVisible();
    }

    if (key === KEY.ENTER || key === KEY.ESC) {
      e.preventDefault();
      e.stopPropagation();
    }

  });

  // If tagging try to split by tokens and add items
  ctrl.searchInput.on('paste', function (e) {
    var data = e.originalEvent.clipboardData.getData('text/plain');
    if (data && data.length > 0 && ctrl.taggingTokens.isActivated && ctrl.tagging.fct) {
      var items = data.split(ctrl.taggingTokens.tokens[0]); // split by first token only
      if (items && items.length > 0) {
        angular.forEach(items, function (item) {
          var newItem = ctrl.tagging.fct(item);
          if (newItem) {
            ctrl.select(newItem, true);
          }
        });
        e.preventDefault();
        e.stopPropagation();
      }
    }
  });

  ctrl.searchInput.on('tagged', function() {
    $timeout(function() {
      _resetSearchInput();
    });
  });

  // See https://github.com/ivaynberg/select2/blob/3.4.6/select2.js#L1431
  function _ensureHighlightVisible() {
    var container = $element.querySelectorAll('.ui-select-choices-content');
    var choices = container.querySelectorAll('.ui-select-choices-row');
    if (choices.length < 1) {
      throw uiSelectMinErr('choices', "Expected multiple .ui-select-choices-row but got '{0}'.", choices.length);
    }

    if (ctrl.activeIndex < 0) {
      return;
    }

    var highlighted = choices[ctrl.activeIndex];
    var posY = highlighted.offsetTop + highlighted.clientHeight - container[0].scrollTop;
    var height = container[0].offsetHeight;

    if (posY > height) {
      container[0].scrollTop += posY - height;
    } else if (posY < highlighted.clientHeight) {
      if (ctrl.isGrouped && ctrl.activeIndex === 0)
        container[0].scrollTop = 0; //To make group header visible when going all the way up
      else
        container[0].scrollTop -= highlighted.clientHeight - posY;
    }
  }

  $scope.$on('$destroy', function() {
    ctrl.searchInput.off('keyup keydown tagged blur paste');
  });

}]);

uis.directive('uiSelect',
  ['$document', 'uiSelectConfig', 'uiSelectMinErr', 'uisOffset', '$compile', '$parse', '$timeout',
  function($document, uiSelectConfig, uiSelectMinErr, uisOffset, $compile, $parse, $timeout) {

  return {
    restrict: 'EA',
    templateUrl: function(tElement, tAttrs) {
      var theme = tAttrs.theme || uiSelectConfig.theme;
      return theme + (angular.isDefined(tAttrs.multiple) ? '/select-multiple.tpl.html' : '/select.tpl.html');
    },
    replace: true,
    transclude: true,
    require: ['uiSelect', '^ngModel'],
    scope: true,

    controller: 'uiSelectCtrl',
    controllerAs: '$select',
    compile: function(tElement, tAttrs) {

      //Multiple or Single depending if multiple attribute presence
      if (angular.isDefined(tAttrs.multiple))
        tElement.append('<ui-select-multiple/>').removeAttr('multiple');
      else
        tElement.append('<ui-select-single/>');

      if (tAttrs.inputId)
        tElement.querySelectorAll('input.ui-select-search')[0].id = tAttrs.inputId;

      return function(scope, element, attrs, ctrls, transcludeFn) {

        var $select = ctrls[0];
        var ngModel = ctrls[1];

        $select.generatedId = uiSelectConfig.generateId();
        $select.baseTitle = attrs.title || 'Select box';
        $select.focusserTitle = $select.baseTitle + ' focus';
        $select.focusserId = 'focusser-' + $select.generatedId;

        $select.closeOnSelect = function() {
          if (angular.isDefined(attrs.closeOnSelect)) {
            return $parse(attrs.closeOnSelect)();
          } else {
            return uiSelectConfig.closeOnSelect;
          }
        }();

        $select.onSelectCallback = $parse(attrs.onSelect);
        $select.onRemoveCallback = $parse(attrs.onRemove);

        //Limit the number of selections allowed
        $select.limit = (angular.isDefined(attrs.limit)) ? parseInt(attrs.limit, 10) : undefined;

        //Set reference to ngModel from uiSelectCtrl
        $select.ngModel = ngModel;

        $select.choiceGrouped = function(group){
          return $select.isGrouped && group && group.name;
        };

        if(attrs.tabindex){
          attrs.$observe('tabindex', function(value) {
            $select.focusInput.attr('tabindex', value);
            element.removeAttr('tabindex');
          });
        }

        scope.$watch('searchEnabled', function() {
            var searchEnabled = scope.$eval(attrs.searchEnabled);
            $select.searchEnabled = searchEnabled !== undefined ? searchEnabled : uiSelectConfig.searchEnabled;
        });

        scope.$watch('sortable', function() {
            var sortable = scope.$eval(attrs.sortable);
            $select.sortable = sortable !== undefined ? sortable : uiSelectConfig.sortable;
        });

        attrs.$observe('disabled', function() {
          // No need to use $eval() (thanks to ng-disabled) since we already get a boolean instead of a string
          $select.disabled = attrs.disabled !== undefined ? attrs.disabled : false;
        });

        attrs.$observe('resetSearchInput', function() {
          // $eval() is needed otherwise we get a string instead of a boolean
          var resetSearchInput = scope.$eval(attrs.resetSearchInput);
          $select.resetSearchInput = resetSearchInput !== undefined ? resetSearchInput : true;
        });

        attrs.$observe('tagging', function() {
          if(attrs.tagging !== undefined)
          {
            // $eval() is needed otherwise we get a string instead of a boolean
            var taggingEval = scope.$eval(attrs.tagging);
            $select.tagging = {isActivated: true, fct: taggingEval !== true ? taggingEval : undefined};
          }
          else
          {
            $select.tagging = {isActivated: false, fct: undefined};
          }
        });

        attrs.$observe('taggingLabel', function() {
          if(attrs.tagging !== undefined )
          {
            // check eval for FALSE, in this case, we disable the labels
            // associated with tagging
            if ( attrs.taggingLabel === 'false' ) {
              $select.taggingLabel = false;
            }
            else
            {
              $select.taggingLabel = attrs.taggingLabel !== undefined ? attrs.taggingLabel : '(new)';
            }
          }
        });

        attrs.$observe('taggingTokens', function() {
          if (attrs.tagging !== undefined) {
            var tokens = attrs.taggingTokens !== undefined ? attrs.taggingTokens.split('|') : [',','ENTER'];
            $select.taggingTokens = {isActivated: true, tokens: tokens };
          }
        });

        //Automatically gets focus when loaded
        if (angular.isDefined(attrs.autofocus)){
          $timeout(function(){
            $select.setFocus();
          });
        }

        //Gets focus based on scope event name (e.g. focus-on='SomeEventName')
        if (angular.isDefined(attrs.focusOn)){
          scope.$on(attrs.focusOn, function() {
              $timeout(function(){
                $select.setFocus();
              });
          });
        }

        function onDocumentClick(e) {
          if (!$select.open) return; //Skip it if dropdown is close

          var contains = false;

          if (window.jQuery) {
            // Firefox 3.6 does not support element.contains()
            // See Node.contains https://developer.mozilla.org/en-US/docs/Web/API/Node.contains
            contains = window.jQuery.contains(element[0], e.target);
          } else {
            contains = element[0].contains(e.target);
          }

          if (!contains && !$select.clickTriggeredSelect) {
            //Will lose focus only with certain targets
            var focusableControls = ['input','button','textarea'];
            var targetController = angular.element(e.target).controller('uiSelect'); //To check if target is other ui-select
            var skipFocusser = targetController && targetController !== $select; //To check if target is other ui-select
            if (!skipFocusser) skipFocusser =  ~focusableControls.indexOf(e.target.tagName.toLowerCase()); //Check if target is input, button or textarea
            $select.close(skipFocusser);
            scope.$digest();
          }
          $select.clickTriggeredSelect = false;
        }

        // See Click everywhere but here event http://stackoverflow.com/questions/12931369
        $document.on('click', onDocumentClick);

        scope.$on('$destroy', function() {
          $document.off('click', onDocumentClick);
        });

        // Move transcluded elements to their correct position in main template
        transcludeFn(scope, function(clone) {
          // See Transclude in AngularJS http://blog.omkarpatil.com/2012/11/transclude-in-angularjs.html

          // One day jqLite will be replaced by jQuery and we will be able to write:
          // var transcludedElement = clone.filter('.my-class')
          // instead of creating a hackish DOM element:
          var transcluded = angular.element('<div>').append(clone);

          var transcludedMatch = transcluded.querySelectorAll('.ui-select-match');
          transcludedMatch.removeAttr('ui-select-match'); //To avoid loop in case directive as attr
          transcludedMatch.removeAttr('data-ui-select-match'); // Properly handle HTML5 data-attributes
          if (transcludedMatch.length !== 1) {
            throw uiSelectMinErr('transcluded', "Expected 1 .ui-select-match but got '{0}'.", transcludedMatch.length);
          }
          element.querySelectorAll('.ui-select-match').replaceWith(transcludedMatch);

          var transcludedChoices = transcluded.querySelectorAll('.ui-select-choices');
          transcludedChoices.removeAttr('ui-select-choices'); //To avoid loop in case directive as attr
          transcludedChoices.removeAttr('data-ui-select-choices'); // Properly handle HTML5 data-attributes
          if (transcludedChoices.length !== 1) {
            throw uiSelectMinErr('transcluded', "Expected 1 .ui-select-choices but got '{0}'.", transcludedChoices.length);
          }
          element.querySelectorAll('.ui-select-choices').replaceWith(transcludedChoices);
        });

        // Support for appending the select field to the body when its open
        var appendToBody = scope.$eval(attrs.appendToBody);
        if (appendToBody !== undefined ? appendToBody : uiSelectConfig.appendToBody) {
          scope.$watch('$select.open', function(isOpen) {
            if (isOpen) {
              positionDropdown();
            } else {
              resetDropdown();
            }
          });

          // Move the dropdown back to its original location when the scope is destroyed. Otherwise
          // it might stick around when the user routes away or the select field is otherwise removed
          scope.$on('$destroy', function() {
            resetDropdown();
          });
        }

        // Hold on to a reference to the .ui-select-container element for appendToBody support
        var placeholder = null,
            originalWidth = '';

        function positionDropdown() {
          // Remember the absolute position of the element
          var offset = uisOffset(element);

          // Clone the element into a placeholder element to take its original place in the DOM
          placeholder = angular.element('<div class="ui-select-placeholder"></div>');
          placeholder[0].style.width = offset.width + 'px';
          placeholder[0].style.height = offset.height + 'px';
          element.after(placeholder);

          // Remember the original value of the element width inline style, so it can be restored
          // when the dropdown is closed
          originalWidth = element[0].style.width;

          // Now move the actual dropdown element to the end of the body
          $document.find('body').append(element);

          element[0].style.position = 'absolute';
          element[0].style.left = offset.left + 'px';
          element[0].style.top = offset.top + 'px';
          element[0].style.width = offset.width + 'px';
        }

        function resetDropdown() {
          if (placeholder === null) {
            // The dropdown has not actually been display yet, so there's nothing to reset
            return;
          }

          // Move the dropdown element back to its original location in the DOM
          placeholder.replaceWith(element);
          placeholder = null;

          element[0].style.position = '';
          element[0].style.left = '';
          element[0].style.top = '';
          element[0].style.width = originalWidth;
        }

        // Hold on to a reference to the .ui-select-dropdown element for direction support.
        var dropdown = null,
            directionUpClassName = 'direction-up';

        // Support changing the direction of the dropdown if there isn't enough space to render it.
        scope.$watch('$select.open', function() {

          if ($select.dropdownPosition === 'auto' || $select.dropdownPosition === 'up'){
            scope.calculateDropdownPos();
          }

        });

        var setDropdownPosUp = function(offset, offsetDropdown){

          offset = offset || uisOffset(element);
          offsetDropdown = offsetDropdown || uisOffset(dropdown);

          dropdown[0].style.position = 'absolute';
          dropdown[0].style.top = (offsetDropdown.height * -1) + 'px';
          element.addClass(directionUpClassName);

        };

        var setDropdownPosDown = function(offset, offsetDropdown){

          element.removeClass(directionUpClassName);

          offset = offset || uisOffset(element);
          offsetDropdown = offsetDropdown || uisOffset(dropdown);

          dropdown[0].style.position = '';
          dropdown[0].style.top = '';

        };

        scope.calculateDropdownPos = function(){

          if ($select.open) {
            dropdown = angular.element(element).querySelectorAll('.ui-select-dropdown');
            if (dropdown.length === 0) {
              return;
            }

            // Hide the dropdown so there is no flicker until $timeout is done executing.
            dropdown[0].style.opacity = 0;

            // Delay positioning the dropdown until all choices have been added so its height is correct.
            $timeout(function(){

              if ($select.dropdownPosition === 'up'){
                  //Go UP
                  setDropdownPosUp(offset, offsetDropdown);

              }else{ //AUTO

                element.removeClass(directionUpClassName);

                var offset = uisOffset(element);
                var offsetDropdown = uisOffset(dropdown);

                //https://code.google.com/p/chromium/issues/detail?id=342307#c4
                var scrollTop = $document[0].documentElement.scrollTop || $document[0].body.scrollTop; //To make it cross browser (blink, webkit, IE, Firefox).

                // Determine if the direction of the dropdown needs to be changed.
                if (offset.top + offset.height + offsetDropdown.height > scrollTop + $document[0].documentElement.clientHeight) {
                  //Go UP
                  setDropdownPosUp(offset, offsetDropdown);
                }else{
                  //Go DOWN
                  setDropdownPosDown(offset, offsetDropdown);
                }

              }

              // Display the dropdown once it has been positioned.
              dropdown[0].style.opacity = 1;
            });
          } else {
              if (dropdown === null || dropdown.length === 0) {
                return;
              }

              // Reset the position of the dropdown.
              dropdown[0].style.position = '';
              dropdown[0].style.top = '';
              element.removeClass(directionUpClassName);
          }
        };
      };
    }
  };
}]);

uis.directive('uiSelectMatch', ['uiSelectConfig', function(uiSelectConfig) {
  return {
    restrict: 'EA',
    require: '^uiSelect',
    replace: true,
    transclude: true,
    templateUrl: function(tElement) {
      // Gets theme attribute from parent (ui-select)
      var theme = tElement.parent().attr('theme') || uiSelectConfig.theme;
      var multi = tElement.parent().attr('multiple');
      return theme + (multi ? '/match-multiple.tpl.html' : '/match.tpl.html');
    },
    link: function(scope, element, attrs, $select) {
      $select.lockChoiceExpression = attrs.uiLockChoice;
      attrs.$observe('placeholder', function(placeholder) {
        $select.placeholder = placeholder !== undefined ? placeholder : uiSelectConfig.placeholder;
      });

      function setAllowClear(allow) {
        $select.allowClear = (angular.isDefined(allow)) ? (allow === '') ? true : (allow.toLowerCase() === 'true') : false;
      }

      attrs.$observe('allowClear', setAllowClear);
      setAllowClear(attrs.allowClear);

      if($select.multiple){
        $select.sizeSearchInput();
      }

    }
  };
}]);

uis.directive('uiSelectMultiple', ['uiSelectMinErr','$timeout', function(uiSelectMinErr, $timeout) {
  return {
    restrict: 'EA',
    require: ['^uiSelect', '^ngModel'],

    controller: ['$scope','$timeout', function($scope, $timeout){

      var ctrl = this,
          $select = $scope.$select,
          ngModel;

      //Wait for link fn to inject it 
      $scope.$evalAsync(function(){ ngModel = $scope.ngModel; });

      ctrl.activeMatchIndex = -1;

      ctrl.updateModel = function(){
        ngModel.$setViewValue(Date.now()); //Set timestamp as a unique string to force changes
        ctrl.refreshComponent();
      };

      ctrl.refreshComponent = function(){
        //Remove already selected items
        //e.g. When user clicks on a selection, the selected array changes and 
        //the dropdown should remove that item
        $select.refreshItems();
        $select.sizeSearchInput();
      };

      // Remove item from multiple select
      ctrl.removeChoice = function(index){

        var removedChoice = $select.selected[index];

        // if the choice is locked, can't remove it
        if(removedChoice._uiSelectChoiceLocked) return;

        var locals = {};
        locals[$select.parserResult.itemName] = removedChoice;

        $select.selected.splice(index, 1);
        ctrl.activeMatchIndex = -1;
        $select.sizeSearchInput();

        // Give some time for scope propagation.
        $timeout(function(){
          $select.onRemoveCallback($scope, {
            $item: removedChoice,
            $model: $select.parserResult.modelMapper($scope, locals)
          });
        });

        ctrl.updateModel();

      };

      ctrl.getPlaceholder = function(){
        //Refactor single?
        if($select.selected && $select.selected.length) return;
        return $select.placeholder;
      };


    }],
    controllerAs: '$selectMultiple',

    link: function(scope, element, attrs, ctrls) {

      var $select = ctrls[0];
      var ngModel = scope.ngModel = ctrls[1];
      var $selectMultiple = scope.$selectMultiple;

      //$select.selected = raw selected objects (ignoring any property binding)

      $select.multiple = true;
      $select.removeSelected = true;

      //Input that will handle focus
      $select.focusInput = $select.searchInput;

      //From view --> model
      ngModel.$parsers.unshift(function () {
        var locals = {},
            result,
            resultMultiple = [];
        for (var j = $select.selected.length - 1; j >= 0; j--) {
          locals = {};
          locals[$select.parserResult.itemName] = $select.selected[j];
          result = $select.parserResult.modelMapper(scope, locals);
          resultMultiple.unshift(result);
        }
        return resultMultiple;
      });

      // From model --> view
      ngModel.$formatters.unshift(function (inputValue) {
        var data = $select.parserResult.source (scope, { $select : {search:''}}), //Overwrite $search
            locals = {},
            result;
        if (!data) return inputValue;
        var resultMultiple = [];
        var checkFnMultiple = function(list, value){
          if (!list || !list.length) return;
          for (var p = list.length - 1; p >= 0; p--) {
            locals[$select.parserResult.itemName] = list[p];
            result = $select.parserResult.modelMapper(scope, locals);
            if($select.parserResult.trackByExp){
                var matches = /\.(.+)/.exec($select.parserResult.trackByExp);
                if(matches.length>0 && result[matches[1]] == value[matches[1]]){
                    resultMultiple.unshift(list[p]);
                    return true;
                }
            }
            if (angular.equals(result,value)){
              resultMultiple.unshift(list[p]);
              return true;
            }
          }
          return false;
        };
        if (!inputValue) return resultMultiple; //If ngModel was undefined
        for (var k = inputValue.length - 1; k >= 0; k--) {
          //Check model array of currently selected items 
          if (!checkFnMultiple($select.selected, inputValue[k])){
            //Check model array of all items available
            if (!checkFnMultiple(data, inputValue[k])){
              //If not found on previous lists, just add it directly to resultMultiple
              resultMultiple.unshift(inputValue[k]);
            }
          }
        }
        return resultMultiple;
      });
      
      //Watch for external model changes 
      scope.$watchCollection(function(){ return ngModel.$modelValue; }, function(newValue, oldValue) {
        if (oldValue != newValue){
          ngModel.$modelValue = null; //Force scope model value and ngModel value to be out of sync to re-run formatters
          $selectMultiple.refreshComponent();
        }
      });

      ngModel.$render = function() {
        // Make sure that model value is array
        if(!angular.isArray(ngModel.$viewValue)){
          // Have tolerance for null or undefined values
          if(angular.isUndefined(ngModel.$viewValue) || ngModel.$viewValue === null){
            $select.selected = [];
          } else {
            throw uiSelectMinErr('multiarr', "Expected model value to be array but got '{0}'", ngModel.$viewValue);
          }
        }
        $select.selected = ngModel.$viewValue;
        scope.$evalAsync(); //To force $digest
      };

      scope.$on('uis:select', function (event, item) {
        if($select.selected.length >= $select.limit) {
          return;
        }
        $select.selected.push(item);
        $selectMultiple.updateModel();
      });

      scope.$on('uis:activate', function () {
        $selectMultiple.activeMatchIndex = -1;
      });

      scope.$watch('$select.disabled', function(newValue, oldValue) {
        // As the search input field may now become visible, it may be necessary to recompute its size
        if (oldValue && !newValue) $select.sizeSearchInput();
      });

      $select.searchInput.on('keydown', function(e) {
        var key = e.which;
        scope.$apply(function() {
          var processed = false;
          // var tagged = false; //Checkme
          if(KEY.isHorizontalMovement(key)){
            processed = _handleMatchSelection(key);
          }
          if (processed  && key != KEY.TAB) {
            //TODO Check si el tab selecciona aun correctamente
            //Crear test
            e.preventDefault();
            e.stopPropagation();
          }
        });
      });
      function _getCaretPosition(el) {
        if(angular.isNumber(el.selectionStart)) return el.selectionStart;
        // selectionStart is not supported in IE8 and we don't want hacky workarounds so we compromise
        else return el.value.length;
      }
      // Handles selected options in "multiple" mode
      function _handleMatchSelection(key){
        var caretPosition = _getCaretPosition($select.searchInput[0]),
            length = $select.selected.length,
            // none  = -1,
            first = 0,
            last  = length-1,
            curr  = $selectMultiple.activeMatchIndex,
            next  = $selectMultiple.activeMatchIndex+1,
            prev  = $selectMultiple.activeMatchIndex-1,
            newIndex = curr;

        if(caretPosition > 0 || ($select.search.length && key == KEY.RIGHT)) return false;

        $select.close();

        function getNewActiveMatchIndex(){
          switch(key){
            case KEY.LEFT:
              // Select previous/first item
              if(~$selectMultiple.activeMatchIndex) return prev;
              // Select last item
              else return last;
              break;
            case KEY.RIGHT:
              // Open drop-down
              if(!~$selectMultiple.activeMatchIndex || curr === last){
                $select.activate();
                return false;
              }
              // Select next/last item
              else return next;
              break;
            case KEY.BACKSPACE:
              // Remove selected item and select previous/first
              if(~$selectMultiple.activeMatchIndex){
                $selectMultiple.removeChoice(curr);
                return prev;
              }
              // Select last item
              else return last;
              break;
            case KEY.DELETE:
              // Remove selected item and select next item
              if(~$selectMultiple.activeMatchIndex){
                $selectMultiple.removeChoice($selectMultiple.activeMatchIndex);
                return curr;
              }
              else return false;
          }
        }

        newIndex = getNewActiveMatchIndex();

        if(!$select.selected.length || newIndex === false) $selectMultiple.activeMatchIndex = -1;
        else $selectMultiple.activeMatchIndex = Math.min(last,Math.max(first,newIndex));

        return true;
      }

      $select.searchInput.on('keyup', function(e) {

        if ( ! KEY.isVerticalMovement(e.which) ) {
          scope.$evalAsync( function () {
            $select.activeIndex = $select.taggingLabel === false ? -1 : 0;
          });
        }
        // Push a "create new" item into array if there is a search string
        if ( $select.tagging.isActivated && $select.search.length > 0 ) {

          // return early with these keys
          if (e.which === KEY.TAB || KEY.isControl(e) || KEY.isFunctionKey(e) || e.which === KEY.ESC || KEY.isVerticalMovement(e.which) ) {
            return;
          }
          // always reset the activeIndex to the first item when tagging
          $select.activeIndex = $select.taggingLabel === false ? -1 : 0;
          // taggingLabel === false bypasses all of this
          if ($select.taggingLabel === false) return;

          var items = angular.copy( $select.items );
          var stashArr = angular.copy( $select.items );
          var newItem;
          var item;
          var hasTag = false;
          var dupeIndex = -1;
          var tagItems;
          var tagItem;

          // case for object tagging via transform `$select.tagging.fct` function
          if ( $select.tagging.fct !== undefined) {
            tagItems = $select.$filter('filter')(items,{'isTag': true});
            if ( tagItems.length > 0 ) {
              tagItem = tagItems[0];
            }
            // remove the first element, if it has the `isTag` prop we generate a new one with each keyup, shaving the previous
            if ( items.length > 0 && tagItem ) {
              hasTag = true;
              items = items.slice(1,items.length);
              stashArr = stashArr.slice(1,stashArr.length);
            }
            newItem = $select.tagging.fct($select.search);
            newItem.isTag = true;
            // verify the the tag doesn't match the value of an existing item
            if ( stashArr.filter( function (origItem) { return angular.equals( origItem, $select.tagging.fct($select.search) ); } ).length > 0 ) {
              return;
            }
            newItem.isTag = true;
          // handle newItem string and stripping dupes in tagging string context
          } else {
            // find any tagging items already in the $select.items array and store them
            tagItems = $select.$filter('filter')(items,function (item) {
              return item.match($select.taggingLabel);
            });
            if ( tagItems.length > 0 ) {
              tagItem = tagItems[0];
            }
            item = items[0];
            // remove existing tag item if found (should only ever be one tag item)
            if ( item !== undefined && items.length > 0 && tagItem ) {
              hasTag = true;
              items = items.slice(1,items.length);
              stashArr = stashArr.slice(1,stashArr.length);
            }
            newItem = $select.search+' '+$select.taggingLabel;
            if ( _findApproxDupe($select.selected, $select.search) > -1 ) {
              return;
            }
            // verify the the tag doesn't match the value of an existing item from
            // the searched data set or the items already selected
            if ( _findCaseInsensitiveDupe(stashArr.concat($select.selected)) ) {
              // if there is a tag from prev iteration, strip it / queue the change
              // and return early
              if ( hasTag ) {
                items = stashArr;
                scope.$evalAsync( function () {
                  $select.activeIndex = 0;
                  $select.items = items;
                });
              }
              return;
            }
            if ( _findCaseInsensitiveDupe(stashArr) ) {
              // if there is a tag from prev iteration, strip it
              if ( hasTag ) {
                $select.items = stashArr.slice(1,stashArr.length);
              }
              return;
            }
          }
          if ( hasTag ) dupeIndex = _findApproxDupe($select.selected, newItem);
          // dupe found, shave the first item
          if ( dupeIndex > -1 ) {
            items = items.slice(dupeIndex+1,items.length-1);
          } else {
            items = [];
            items.push(newItem);
            items = items.concat(stashArr);
          }
          scope.$evalAsync( function () {
            $select.activeIndex = 0;
            $select.items = items;
          });
        }
      });
      function _findCaseInsensitiveDupe(arr) {
        if ( arr === undefined || $select.search === undefined ) {
          return false;
        }
        var hasDupe = arr.filter( function (origItem) {
          if ( $select.search.toUpperCase() === undefined || origItem === undefined ) {
            return false;
          }
          return origItem.toUpperCase() === $select.search.toUpperCase();
        }).length > 0;

        return hasDupe;
      }
      function _findApproxDupe(haystack, needle) {
        var dupeIndex = -1;
        if(angular.isArray(haystack)) {
          var tempArr = angular.copy(haystack);
          for (var i = 0; i <tempArr.length; i++) {
            // handle the simple string version of tagging
            if ( $select.tagging.fct === undefined ) {
              // search the array for the match
              if ( tempArr[i]+' '+$select.taggingLabel === needle ) {
              dupeIndex = i;
              }
            // handle the object tagging implementation
            } else {
              var mockObj = tempArr[i];
              mockObj.isTag = true;
              if ( angular.equals(mockObj, needle) ) {
              dupeIndex = i;
              }
            }
          }
        }
        return dupeIndex;
      }

      $select.searchInput.on('blur', function() {
        $timeout(function() {
          $selectMultiple.activeMatchIndex = -1;
        });
      });

    }
  };
}]);

uis.directive('uiSelectSingle', ['$timeout','$compile', function($timeout, $compile) {
  return {
    restrict: 'EA',
    require: ['^uiSelect', '^ngModel'],
    link: function(scope, element, attrs, ctrls) {

      var $select = ctrls[0];
      var ngModel = ctrls[1];

      //From view --> model
      ngModel.$parsers.unshift(function (inputValue) {
        var locals = {},
            result;
        locals[$select.parserResult.itemName] = inputValue;
        result = $select.parserResult.modelMapper(scope, locals);
        return result;
      });

      //From model --> view
      ngModel.$formatters.unshift(function (inputValue) {
        var data = $select.parserResult.source (scope, { $select : {search:''}}), //Overwrite $search
            locals = {},
            result;
        if (data){
          var checkFnSingle = function(d){
            locals[$select.parserResult.itemName] = d;
            result = $select.parserResult.modelMapper(scope, locals);
            return result == inputValue;
          };
          //If possible pass same object stored in $select.selected
          if ($select.selected && checkFnSingle($select.selected)) {
            return $select.selected;
          }
          for (var i = data.length - 1; i >= 0; i--) {
            if (checkFnSingle(data[i])) return data[i];
          }
        }
        return inputValue;
      });

      //Update viewValue if model change
      scope.$watch('$select.selected', function(newValue) {
        if (ngModel.$viewValue !== newValue) {
          ngModel.$setViewValue(newValue);
        }
      });

      ngModel.$render = function() {
        $select.selected = ngModel.$viewValue;
      };

      scope.$on('uis:select', function (event, item) {
        $select.selected = item;
      });

      scope.$on('uis:close', function (event, skipFocusser) {
        $timeout(function(){
          $select.focusser.prop('disabled', false);
          if (!skipFocusser) $select.focusser[0].focus();
        },0,false);
      });

      scope.$on('uis:activate', function () {
        focusser.prop('disabled', true); //Will reactivate it on .close()
      });

      //Idea from: https://github.com/ivaynberg/select2/blob/79b5bf6db918d7560bdd959109b7bcfb47edaf43/select2.js#L1954
      var focusser = angular.element("<input ng-disabled='$select.disabled' class='ui-select-focusser ui-select-offscreen' type='text' id='{{ $select.focusserId }}' aria-label='{{ $select.focusserTitle }}' aria-haspopup='true' role='button' />");
      $compile(focusser)(scope);
      $select.focusser = focusser;

      //Input that will handle focus
      $select.focusInput = focusser;

      element.parent().append(focusser);
      focusser.bind("focus", function(){
        scope.$evalAsync(function(){
          $select.focus = true;
        });
      });
      focusser.bind("blur", function(){
        scope.$evalAsync(function(){
          $select.focus = false;
        });
      });
      focusser.bind("keydown", function(e){

        if (e.which === KEY.BACKSPACE) {
          e.preventDefault();
          e.stopPropagation();
          $select.select(undefined);
          scope.$apply();
          return;
        }

        if (e.which === KEY.TAB || KEY.isControl(e) || KEY.isFunctionKey(e) || e.which === KEY.ESC) {
          return;
        }

        if (e.which == KEY.DOWN  || e.which == KEY.UP || e.which == KEY.ENTER || e.which == KEY.SPACE){
          e.preventDefault();
          e.stopPropagation();
          $select.activate();
        }

        scope.$digest();
      });

      focusser.bind("keyup input", function(e){

        if (e.which === KEY.TAB || KEY.isControl(e) || KEY.isFunctionKey(e) || e.which === KEY.ESC || e.which == KEY.ENTER || e.which === KEY.BACKSPACE) {
          return;
        }

        $select.activate(focusser.val()); //User pressed some regular key, so we pass it to the search input
        focusser.val('');
        scope.$digest();

      });


    }
  };
}]);
// Make multiple matches sortable
uis.directive('uiSelectSort', ['$timeout', 'uiSelectConfig', 'uiSelectMinErr', function($timeout, uiSelectConfig, uiSelectMinErr) {
  return {
    require: '^uiSelect',
    link: function(scope, element, attrs, $select) {
      if (scope[attrs.uiSelectSort] === null) {
        throw uiSelectMinErr('sort', "Expected a list to sort");
      }

      var options = angular.extend({
          axis: 'horizontal'
        },
        scope.$eval(attrs.uiSelectSortOptions));

      var axis = options.axis,
        draggingClassName = 'dragging',
        droppingClassName = 'dropping',
        droppingBeforeClassName = 'dropping-before',
        droppingAfterClassName = 'dropping-after';

      scope.$watch(function(){
        return $select.sortable;
      }, function(n){
        if (n) {
          element.attr('draggable', true);
        } else {
          element.removeAttr('draggable');
        }
      });

      element.on('dragstart', function(e) {
        element.addClass(draggingClassName);

        (e.dataTransfer || e.originalEvent.dataTransfer).setData('text/plain', scope.$index);
      });

      element.on('dragend', function() {
        element.removeClass(draggingClassName);
      });

      var move = function(from, to) {
        /*jshint validthis: true */
        this.splice(to, 0, this.splice(from, 1)[0]);
      };

      var dragOverHandler = function(e) {
        e.preventDefault();

        var offset = axis === 'vertical' ? e.offsetY || e.layerY || (e.originalEvent ? e.originalEvent.offsetY : 0) : e.offsetX || e.layerX || (e.originalEvent ? e.originalEvent.offsetX : 0);

        if (offset < (this[axis === 'vertical' ? 'offsetHeight' : 'offsetWidth'] / 2)) {
          element.removeClass(droppingAfterClassName);
          element.addClass(droppingBeforeClassName);

        } else {
          element.removeClass(droppingBeforeClassName);
          element.addClass(droppingAfterClassName);
        }
      };

      var dropTimeout;

      var dropHandler = function(e) {
        e.preventDefault();

        var droppedItemIndex = parseInt((e.dataTransfer || e.originalEvent.dataTransfer).getData('text/plain'), 10);

        // prevent event firing multiple times in firefox
        $timeout.cancel(dropTimeout);
        dropTimeout = $timeout(function() {
          _dropHandler(droppedItemIndex);
        }, 20);
      };

      var _dropHandler = function(droppedItemIndex) {
        var theList = scope.$eval(attrs.uiSelectSort),
          itemToMove = theList[droppedItemIndex],
          newIndex = null;

        if (element.hasClass(droppingBeforeClassName)) {
          if (droppedItemIndex < scope.$index) {
            newIndex = scope.$index - 1;
          } else {
            newIndex = scope.$index;
          }
        } else {
          if (droppedItemIndex < scope.$index) {
            newIndex = scope.$index;
          } else {
            newIndex = scope.$index + 1;
          }
        }

        move.apply(theList, [droppedItemIndex, newIndex]);

        scope.$apply(function() {
          scope.$emit('uiSelectSort:change', {
            array: theList,
            item: itemToMove,
            from: droppedItemIndex,
            to: newIndex
          });
        });

        element.removeClass(droppingClassName);
        element.removeClass(droppingBeforeClassName);
        element.removeClass(droppingAfterClassName);

        element.off('drop', dropHandler);
      };

      element.on('dragenter', function() {
        if (element.hasClass(draggingClassName)) {
          return;
        }

        element.addClass(droppingClassName);

        element.on('dragover', dragOverHandler);
        element.on('drop', dropHandler);
      });

      element.on('dragleave', function(e) {
        if (e.target != element) {
          return;
        }
        element.removeClass(droppingClassName);
        element.removeClass(droppingBeforeClassName);
        element.removeClass(droppingAfterClassName);

        element.off('dragover', dragOverHandler);
        element.off('drop', dropHandler);
      });
    }
  };
}]);

/**
 * Parses "repeat" attribute.
 *
 * Taken from AngularJS ngRepeat source code
 * See https://github.com/angular/angular.js/blob/v1.2.15/src/ng/directive/ngRepeat.js#L211
 *
 * Original discussion about parsing "repeat" attribute instead of fully relying on ng-repeat:
 * https://github.com/angular-ui/ui-select/commit/5dd63ad#commitcomment-5504697
 */

uis.service('uisRepeatParser', ['uiSelectMinErr','$parse', function(uiSelectMinErr, $parse) {
  var self = this;

  /**
   * Example:
   * expression = "address in addresses | filter: {street: $select.search} track by $index"
   * itemName = "address",
   * source = "addresses | filter: {street: $select.search}",
   * trackByExp = "$index",
   */
  self.parse = function(expression) {


    var match;
    var isObjectCollection = /\(\s*([\$\w][\$\w]*)\s*,\s*([\$\w][\$\w]*)\s*\)/.test(expression);
    // If an array is used as collection

    // if (isObjectCollection){
      //00000000000000000000000000000111111111000000000000000222222222222220033333333333333333333330000444444444444444444000000000000000556666660000077777777777755000000000000000000000088888880000000
    match = expression.match(/^\s*(?:([\s\S]+?)\s+as\s+)?(?:([\$\w][\$\w]*)|(?:\(\s*([\$\w][\$\w]*)\s*,\s*([\$\w][\$\w]*)\s*\)))\s+in\s+(([\w\.]+)?\s*(|\s*[\s\S]+?))?(?:\s+track\s+by\s+([\s\S]+?))?\s*$/);      

    // 1 Alias
    // 2 Item
    // 3 Key on (key,value)
    // 4 Value on (key,value)
    // 5 Collection expresion (only used when using an array collection)
    // 6 Object that will be converted to Array when using (key,value) syntax
    // 7 Filters that will be applied to #6 when using (key,value) syntax
    // 8 Track by

    if (!match) {
      throw uiSelectMinErr('iexp', "Expected expression in form of '_item_ in _collection_[ track by _id_]' but got '{0}'.",
              expression);
    }
    if (!match[6] && isObjectCollection) {
      throw uiSelectMinErr('iexp', "Expected expression in form of '_item_ as (_key_, _item_) in _ObjCollection_ [ track by _id_]' but got '{0}'.",
              expression);
    }

    return {
      itemName: match[4] || match[2], // (lhs) Left-hand side,
      keyName: match[3], //for (key, value) syntax
      source: $parse(!match[3] ? match[5] : match[6]),
      sourceName: match[6],
      filters: match[7],
      trackByExp: match[8],
      modelMapper: $parse(match[1] || match[4] || match[2]),
      repeatExpression: function (grouped) {
        var expression = this.itemName + ' in ' + (grouped ? '$group.items' : '$select.items');
        if (this.trackByExp) {
          expression += ' track by ' + this.trackByExp;
        }
        return expression;
      } 
    };

  };

  self.getGroupNgRepeatExpression = function() {
    return '$group in $select.groups';
  };

}]);

}());
angular.module("ui.select").run(["$templateCache", function($templateCache) {$templateCache.put("bootstrap/choices.tpl.html","<ul class=\"ui-select-choices ui-select-choices-content ui-select-dropdown dropdown-menu\" role=\"listbox\" ng-show=\"$select.items.length > 0\"><li class=\"ui-select-choices-group\" id=\"ui-select-choices-{{ $select.generatedId }}\"><div class=\"divider\" ng-show=\"$select.isGrouped && $index > 0\"></div><div ng-show=\"$select.isGrouped\" class=\"ui-select-choices-group-label dropdown-header\" ng-bind=\"$group.name\"></div><div id=\"ui-select-choices-row-{{ $select.generatedId }}-{{$index}}\" class=\"ui-select-choices-row\" ng-class=\"{active: $select.isActive(this), disabled: $select.isDisabled(this)}\" role=\"option\"><a href=\"javascript:void(0)\" class=\"ui-select-choices-row-inner\"></a></div></li></ul>");
$templateCache.put("bootstrap/match-multiple.tpl.html","<span class=\"ui-select-match\"><span ng-repeat=\"$item in $select.selected\"><span class=\"ui-select-match-item btn btn-default btn-xs\" tabindex=\"-1\" type=\"button\" ng-disabled=\"$select.disabled\" ng-click=\"$selectMultiple.activeMatchIndex = $index;\" ng-class=\"{\'btn-primary\':$selectMultiple.activeMatchIndex === $index, \'select-locked\':$select.isLocked(this, $index)}\" ui-select-sort=\"$select.selected\"><span class=\"close ui-select-match-close\" ng-hide=\"$select.disabled\" ng-click=\"$selectMultiple.removeChoice($index)\">&nbsp;&times;</span> <span uis-transclude-append=\"\"></span></span></span></span>");
$templateCache.put("bootstrap/match.tpl.html","<div class=\"ui-select-match\" ng-hide=\"$select.open\" ng-disabled=\"$select.disabled\" ng-class=\"{\'btn-default-focus\':$select.focus}\"><span tabindex=\"-1\" class=\"btn btn-default form-control ui-select-toggle\" aria-label=\"{{ $select.baseTitle }} activate\" ng-disabled=\"$select.disabled\" ng-click=\"$select.activate()\" style=\"outline: 0;\"><span ng-show=\"$select.isEmpty()\" class=\"ui-select-placeholder text-muted\">{{$select.placeholder}}</span> <span ng-hide=\"$select.isEmpty()\" class=\"ui-select-match-text pull-left\" ng-class=\"{\'ui-select-allow-clear\': $select.allowClear && !$select.isEmpty()}\" ng-transclude=\"\"></span> <i class=\"caret pull-right\" ng-click=\"$select.toggle($event)\"></i> <a ng-show=\"$select.allowClear && !$select.isEmpty()\" aria-label=\"{{ $select.baseTitle }} clear\" style=\"margin-right: 10px\" ng-click=\"$select.clear($event)\" class=\"btn btn-xs btn-link pull-right\"><i class=\"glyphicon glyphicon-remove\" aria-hidden=\"true\"></i></a></span></div>");
$templateCache.put("bootstrap/select-multiple.tpl.html","<div class=\"ui-select-container ui-select-multiple ui-select-bootstrap dropdown form-control\" ng-class=\"{open: $select.open}\"><div><div class=\"ui-select-match\"></div><input type=\"text\" autocomplete=\"false\" autocorrect=\"off\" autocapitalize=\"off\" spellcheck=\"false\" class=\"ui-select-search input-xs\" placeholder=\"{{$selectMultiple.getPlaceholder()}}\" ng-disabled=\"$select.disabled\" ng-hide=\"$select.disabled\" ng-click=\"$select.activate()\" ng-model=\"$select.search\" role=\"combobox\" aria-label=\"{{ $select.baseTitle }}\" ondrop=\"return false;\"></div><div class=\"ui-select-choices\"></div></div>");
$templateCache.put("bootstrap/select.tpl.html","<div class=\"ui-select-container ui-select-bootstrap dropdown\" ng-class=\"{open: $select.open}\"><div class=\"ui-select-match\"></div><input type=\"text\" autocomplete=\"false\" tabindex=\"-1\" aria-expanded=\"true\" aria-label=\"{{ $select.baseTitle }}\" aria-owns=\"ui-select-choices-{{ $select.generatedId }}\" aria-activedescendant=\"ui-select-choices-row-{{ $select.generatedId }}-{{ $select.activeIndex }}\" class=\"form-control ui-select-search\" placeholder=\"{{$select.placeholder}}\" ng-model=\"$select.search\" ng-show=\"$select.searchEnabled && $select.open\"><div class=\"ui-select-choices\"></div></div>");
$templateCache.put("selectize/choices.tpl.html","<div ng-show=\"$select.open\" class=\"ui-select-choices ui-select-dropdown selectize-dropdown single\"><div class=\"ui-select-choices-content selectize-dropdown-content\"><div class=\"ui-select-choices-group optgroup\" role=\"listbox\"><div ng-show=\"$select.isGrouped\" class=\"ui-select-choices-group-label optgroup-header\" ng-bind=\"$group.name\"></div><div role=\"option\" class=\"ui-select-choices-row\" ng-class=\"{active: $select.isActive(this), disabled: $select.isDisabled(this)}\"><div class=\"option ui-select-choices-row-inner\" data-selectable=\"\"></div></div></div></div></div>");
$templateCache.put("selectize/match.tpl.html","<div ng-hide=\"($select.open || $select.isEmpty())\" class=\"ui-select-match\" ng-transclude=\"\"></div>");
$templateCache.put("selectize/select.tpl.html","<div class=\"ui-select-container selectize-control single\" ng-class=\"{\'open\': $select.open}\"><div class=\"selectize-input\" ng-class=\"{\'focus\': $select.open, \'disabled\': $select.disabled, \'selectize-focus\' : $select.focus}\" ng-click=\"$select.activate()\"><div class=\"ui-select-match\"></div><input type=\"text\" autocomplete=\"false\" tabindex=\"-1\" class=\"ui-select-search ui-select-toggle\" ng-click=\"$select.toggle($event)\" placeholder=\"{{$select.placeholder}}\" ng-model=\"$select.search\" ng-hide=\"!$select.searchEnabled || ($select.selected && !$select.open)\" ng-disabled=\"$select.disabled\" aria-label=\"{{ $select.baseTitle }}\"></div><div class=\"ui-select-choices\"></div></div>");
$templateCache.put("select2/choices.tpl.html","<ul class=\"ui-select-choices ui-select-choices-content select2-results\"><li class=\"ui-select-choices-group\" ng-class=\"{\'select2-result-with-children\': $select.choiceGrouped($group) }\"><div ng-show=\"$select.choiceGrouped($group)\" class=\"ui-select-choices-group-label select2-result-label\" ng-bind=\"$group.name\"></div><ul role=\"listbox\" id=\"ui-select-choices-{{ $select.generatedId }}\" ng-class=\"{\'select2-result-sub\': $select.choiceGrouped($group), \'select2-result-single\': !$select.choiceGrouped($group) }\"><li role=\"option\" id=\"ui-select-choices-row-{{ $select.generatedId }}-{{$index}}\" class=\"ui-select-choices-row\" ng-class=\"{\'select2-highlighted\': $select.isActive(this), \'select2-disabled\': $select.isDisabled(this)}\"><div class=\"select2-result-label ui-select-choices-row-inner\"></div></li></ul></li></ul>");
$templateCache.put("select2/match-multiple.tpl.html","<span class=\"ui-select-match\"><li class=\"ui-select-match-item select2-search-choice\" ng-repeat=\"$item in $select.selected\" ng-class=\"{\'select2-search-choice-focus\':$selectMultiple.activeMatchIndex === $index, \'select2-locked\':$select.isLocked(this, $index)}\" ui-select-sort=\"$select.selected\"><span uis-transclude-append=\"\"></span> <a href=\"javascript:;\" class=\"ui-select-match-close select2-search-choice-close\" ng-click=\"$selectMultiple.removeChoice($index)\" tabindex=\"-1\"></a></li></span>");
$templateCache.put("select2/match.tpl.html","<a class=\"select2-choice ui-select-match\" ng-class=\"{\'select2-default\': $select.isEmpty()}\" ng-click=\"$select.toggle($event)\" aria-label=\"{{ $select.baseTitle }} select\"><span ng-show=\"$select.isEmpty()\" class=\"select2-chosen\">{{$select.placeholder}}</span> <span ng-hide=\"$select.isEmpty()\" class=\"select2-chosen\" ng-transclude=\"\"></span> <abbr ng-if=\"$select.allowClear && !$select.isEmpty()\" class=\"select2-search-choice-close\" ng-click=\"$select.clear($event)\"></abbr> <span class=\"select2-arrow ui-select-toggle\"><b></b></span></a>");
$templateCache.put("select2/select-multiple.tpl.html","<div class=\"ui-select-container ui-select-multiple select2 select2-container select2-container-multi\" ng-class=\"{\'select2-container-active select2-dropdown-open open\': $select.open, \'select2-container-disabled\': $select.disabled}\"><ul class=\"select2-choices\"><span class=\"ui-select-match\"></span><li class=\"select2-search-field\"><input type=\"text\" autocomplete=\"false\" autocorrect=\"off\" autocapitalize=\"off\" spellcheck=\"false\" role=\"combobox\" aria-expanded=\"true\" aria-owns=\"ui-select-choices-{{ $select.generatedId }}\" aria-label=\"{{ $select.baseTitle }}\" aria-activedescendant=\"ui-select-choices-row-{{ $select.generatedId }}-{{ $select.activeIndex }}\" class=\"select2-input ui-select-search\" placeholder=\"{{$selectMultiple.getPlaceholder()}}\" ng-disabled=\"$select.disabled\" ng-hide=\"$select.disabled\" ng-model=\"$select.search\" ng-click=\"$select.activate()\" style=\"width: 34px;\" ondrop=\"return false;\"></li></ul><div class=\"ui-select-dropdown select2-drop select2-with-searchbox select2-drop-active\" ng-class=\"{\'select2-display-none\': !$select.open}\"><div class=\"ui-select-choices\"></div></div></div>");
$templateCache.put("select2/select.tpl.html","<div class=\"ui-select-container select2 select2-container\" ng-class=\"{\'select2-container-active select2-dropdown-open open\': $select.open, \'select2-container-disabled\': $select.disabled, \'select2-container-active\': $select.focus, \'select2-allowclear\': $select.allowClear && !$select.isEmpty()}\"><div class=\"ui-select-match\"></div><div class=\"ui-select-dropdown select2-drop select2-with-searchbox select2-drop-active\" ng-class=\"{\'select2-display-none\': !$select.open}\"><div class=\"select2-search\" ng-show=\"$select.searchEnabled\"><input type=\"text\" autocomplete=\"false\" autocorrect=\"false\" autocapitalize=\"off\" spellcheck=\"false\" role=\"combobox\" aria-expanded=\"true\" aria-owns=\"ui-select-choices-{{ $select.generatedId }}\" aria-label=\"{{ $select.baseTitle }}\" aria-activedescendant=\"ui-select-choices-row-{{ $select.generatedId }}-{{ $select.activeIndex }}\" class=\"ui-select-search select2-input\" ng-model=\"$select.search\"></div><div class=\"ui-select-choices\"></div></div></div>");}]);
/**
 * @license AngularJS v1.5.11
 * (c) 2010-2017 Google, Inc. http://angularjs.org
 * License: MIT
 */
(function(window, angular) {'use strict';

/* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
 *     Any commits to this file should be reviewed with security in mind.  *
 *   Changes to this file can potentially create security vulnerabilities. *
 *          An approval from 2 Core members with history of modifying      *
 *                         this file is required.                          *
 *                                                                         *
 *  Does the change somehow allow for arbitrary javascript to be executed? *
 *    Or allows for someone to change the prototype of built-in objects?   *
 *     Or gives undesired access to variables likes document or window?    *
 * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * */

var $sanitizeMinErr = angular.$$minErr('$sanitize');
var bind;
var extend;
var forEach;
var isDefined;
var lowercase;
var noop;
var htmlParser;
var htmlSanitizeWriter;

/**
 * @ngdoc module
 * @name ngSanitize
 * @description
 *
 * # ngSanitize
 *
 * The `ngSanitize` module provides functionality to sanitize HTML.
 *
 *
 * <div doc-module-components="ngSanitize"></div>
 *
 * See {@link ngSanitize.$sanitize `$sanitize`} for usage.
 */

/**
 * @ngdoc service
 * @name $sanitize
 * @kind function
 *
 * @description
 *   Sanitizes an html string by stripping all potentially dangerous tokens.
 *
 *   The input is sanitized by parsing the HTML into tokens. All safe tokens (from a whitelist) are
 *   then serialized back to properly escaped html string. This means that no unsafe input can make
 *   it into the returned string.
 *
 *   The whitelist for URL sanitization of attribute values is configured using the functions
 *   `aHrefSanitizationWhitelist` and `imgSrcSanitizationWhitelist` of {@link ng.$compileProvider
 *   `$compileProvider`}.
 *
 *   The input may also contain SVG markup if this is enabled via {@link $sanitizeProvider}.
 *
 * @param {string} html HTML input.
 * @returns {string} Sanitized HTML.
 *
 * @example
   <example module="sanitizeExample" deps="angular-sanitize.js" name="sanitize-service">
   <file name="index.html">
     <script>
         angular.module('sanitizeExample', ['ngSanitize'])
           .controller('ExampleController', ['$scope', '$sce', function($scope, $sce) {
             $scope.snippet =
               '<p style="color:blue">an html\n' +
               '<em onmouseover="this.textContent=\'PWN3D!\'">click here</em>\n' +
               'snippet</p>';
             $scope.deliberatelyTrustDangerousSnippet = function() {
               return $sce.trustAsHtml($scope.snippet);
             };
           }]);
     </script>
     <div ng-controller="ExampleController">
        Snippet: <textarea ng-model="snippet" cols="60" rows="3"></textarea>
       <table>
         <tr>
           <td>Directive</td>
           <td>How</td>
           <td>Source</td>
           <td>Rendered</td>
         </tr>
         <tr id="bind-html-with-sanitize">
           <td>ng-bind-html</td>
           <td>Automatically uses $sanitize</td>
           <td><pre>&lt;div ng-bind-html="snippet"&gt;<br/>&lt;/div&gt;</pre></td>
           <td><div ng-bind-html="snippet"></div></td>
         </tr>
         <tr id="bind-html-with-trust">
           <td>ng-bind-html</td>
           <td>Bypass $sanitize by explicitly trusting the dangerous value</td>
           <td>
           <pre>&lt;div ng-bind-html="deliberatelyTrustDangerousSnippet()"&gt;
&lt;/div&gt;</pre>
           </td>
           <td><div ng-bind-html="deliberatelyTrustDangerousSnippet()"></div></td>
         </tr>
         <tr id="bind-default">
           <td>ng-bind</td>
           <td>Automatically escapes</td>
           <td><pre>&lt;div ng-bind="snippet"&gt;<br/>&lt;/div&gt;</pre></td>
           <td><div ng-bind="snippet"></div></td>
         </tr>
       </table>
       </div>
   </file>
   <file name="protractor.js" type="protractor">
     it('should sanitize the html snippet by default', function() {
       expect(element(by.css('#bind-html-with-sanitize div')).getAttribute('innerHTML')).
         toBe('<p>an html\n<em>click here</em>\nsnippet</p>');
     });

     it('should inline raw snippet if bound to a trusted value', function() {
       expect(element(by.css('#bind-html-with-trust div')).getAttribute('innerHTML')).
         toBe("<p style=\"color:blue\">an html\n" +
              "<em onmouseover=\"this.textContent='PWN3D!'\">click here</em>\n" +
              "snippet</p>");
     });

     it('should escape snippet without any filter', function() {
       expect(element(by.css('#bind-default div')).getAttribute('innerHTML')).
         toBe("&lt;p style=\"color:blue\"&gt;an html\n" +
              "&lt;em onmouseover=\"this.textContent='PWN3D!'\"&gt;click here&lt;/em&gt;\n" +
              "snippet&lt;/p&gt;");
     });

     it('should update', function() {
       element(by.model('snippet')).clear();
       element(by.model('snippet')).sendKeys('new <b onclick="alert(1)">text</b>');
       expect(element(by.css('#bind-html-with-sanitize div')).getAttribute('innerHTML')).
         toBe('new <b>text</b>');
       expect(element(by.css('#bind-html-with-trust div')).getAttribute('innerHTML')).toBe(
         'new <b onclick="alert(1)">text</b>');
       expect(element(by.css('#bind-default div')).getAttribute('innerHTML')).toBe(
         "new &lt;b onclick=\"alert(1)\"&gt;text&lt;/b&gt;");
     });
   </file>
   </example>
 */


/**
 * @ngdoc provider
 * @name $sanitizeProvider
 * @this
 *
 * @description
 * Creates and configures {@link $sanitize} instance.
 */
function $SanitizeProvider() {
  var svgEnabled = false;

  this.$get = ['$$sanitizeUri', function($$sanitizeUri) {
    if (svgEnabled) {
      extend(validElements, svgElements);
    }
    return function(html) {
      var buf = [];
      htmlParser(html, htmlSanitizeWriter(buf, function(uri, isImage) {
        return !/^unsafe:/.test($$sanitizeUri(uri, isImage));
      }));
      return buf.join('');
    };
  }];


  /**
   * @ngdoc method
   * @name $sanitizeProvider#enableSvg
   * @kind function
   *
   * @description
   * Enables a subset of svg to be supported by the sanitizer.
   *
   * <div class="alert alert-warning">
   *   <p>By enabling this setting without taking other precautions, you might expose your
   *   application to click-hijacking attacks. In these attacks, sanitized svg elements could be positioned
   *   outside of the containing element and be rendered over other elements on the page (e.g. a login
   *   link). Such behavior can then result in phishing incidents.</p>
   *
   *   <p>To protect against these, explicitly setup `overflow: hidden` css rule for all potential svg
   *   tags within the sanitized content:</p>
   *
   *   <br>
   *
   *   <pre><code>
   *   .rootOfTheIncludedContent svg {
   *     overflow: hidden !important;
   *   }
   *   </code></pre>
   * </div>
   *
   * @param {boolean=} flag Enable or disable SVG support in the sanitizer.
   * @returns {boolean|ng.$sanitizeProvider} Returns the currently configured value if called
   *    without an argument or self for chaining otherwise.
   */
  this.enableSvg = function(enableSvg) {
    if (isDefined(enableSvg)) {
      svgEnabled = enableSvg;
      return this;
    } else {
      return svgEnabled;
    }
  };

  //////////////////////////////////////////////////////////////////////////////////////////////////
  // Private stuff
  //////////////////////////////////////////////////////////////////////////////////////////////////

  bind = angular.bind;
  extend = angular.extend;
  forEach = angular.forEach;
  isDefined = angular.isDefined;
  lowercase = angular.lowercase;
  noop = angular.noop;

  htmlParser = htmlParserImpl;
  htmlSanitizeWriter = htmlSanitizeWriterImpl;

  // Regular Expressions for parsing tags and attributes
  var SURROGATE_PAIR_REGEXP = /[\uD800-\uDBFF][\uDC00-\uDFFF]/g,
    // Match everything outside of normal chars and " (quote character)
    NON_ALPHANUMERIC_REGEXP = /([^#-~ |!])/g;


  // Good source of info about elements and attributes
  // http://dev.w3.org/html5/spec/Overview.html#semantics
  // http://simon.html5.org/html-elements

  // Safe Void Elements - HTML5
  // http://dev.w3.org/html5/spec/Overview.html#void-elements
  var voidElements = toMap('area,br,col,hr,img,wbr');

  // Elements that you can, intentionally, leave open (and which close themselves)
  // http://dev.w3.org/html5/spec/Overview.html#optional-tags
  var optionalEndTagBlockElements = toMap('colgroup,dd,dt,li,p,tbody,td,tfoot,th,thead,tr'),
      optionalEndTagInlineElements = toMap('rp,rt'),
      optionalEndTagElements = extend({},
                                              optionalEndTagInlineElements,
                                              optionalEndTagBlockElements);

  // Safe Block Elements - HTML5
  var blockElements = extend({}, optionalEndTagBlockElements, toMap('address,article,' +
          'aside,blockquote,caption,center,del,dir,div,dl,figure,figcaption,footer,h1,h2,h3,h4,h5,' +
          'h6,header,hgroup,hr,ins,map,menu,nav,ol,pre,section,table,ul'));

  // Inline Elements - HTML5
  var inlineElements = extend({}, optionalEndTagInlineElements, toMap('a,abbr,acronym,b,' +
          'bdi,bdo,big,br,cite,code,del,dfn,em,font,i,img,ins,kbd,label,map,mark,q,ruby,rp,rt,s,' +
          'samp,small,span,strike,strong,sub,sup,time,tt,u,var'));

  // SVG Elements
  // https://wiki.whatwg.org/wiki/Sanitization_rules#svg_Elements
  // Note: the elements animate,animateColor,animateMotion,animateTransform,set are intentionally omitted.
  // They can potentially allow for arbitrary javascript to be executed. See #11290
  var svgElements = toMap('circle,defs,desc,ellipse,font-face,font-face-name,font-face-src,g,glyph,' +
          'hkern,image,linearGradient,line,marker,metadata,missing-glyph,mpath,path,polygon,polyline,' +
          'radialGradient,rect,stop,svg,switch,text,title,tspan');

  // Blocked Elements (will be stripped)
  var blockedElements = toMap('script,style');

  var validElements = extend({},
                                     voidElements,
                                     blockElements,
                                     inlineElements,
                                     optionalEndTagElements);

  //Attributes that have href and hence need to be sanitized
  var uriAttrs = toMap('background,cite,href,longdesc,src,xlink:href');

  var htmlAttrs = toMap('abbr,align,alt,axis,bgcolor,border,cellpadding,cellspacing,class,clear,' +
      'color,cols,colspan,compact,coords,dir,face,headers,height,hreflang,hspace,' +
      'ismap,lang,language,nohref,nowrap,rel,rev,rows,rowspan,rules,' +
      'scope,scrolling,shape,size,span,start,summary,tabindex,target,title,type,' +
      'valign,value,vspace,width');

  // SVG attributes (without "id" and "name" attributes)
  // https://wiki.whatwg.org/wiki/Sanitization_rules#svg_Attributes
  var svgAttrs = toMap('accent-height,accumulate,additive,alphabetic,arabic-form,ascent,' +
      'baseProfile,bbox,begin,by,calcMode,cap-height,class,color,color-rendering,content,' +
      'cx,cy,d,dx,dy,descent,display,dur,end,fill,fill-rule,font-family,font-size,font-stretch,' +
      'font-style,font-variant,font-weight,from,fx,fy,g1,g2,glyph-name,gradientUnits,hanging,' +
      'height,horiz-adv-x,horiz-origin-x,ideographic,k,keyPoints,keySplines,keyTimes,lang,' +
      'marker-end,marker-mid,marker-start,markerHeight,markerUnits,markerWidth,mathematical,' +
      'max,min,offset,opacity,orient,origin,overline-position,overline-thickness,panose-1,' +
      'path,pathLength,points,preserveAspectRatio,r,refX,refY,repeatCount,repeatDur,' +
      'requiredExtensions,requiredFeatures,restart,rotate,rx,ry,slope,stemh,stemv,stop-color,' +
      'stop-opacity,strikethrough-position,strikethrough-thickness,stroke,stroke-dasharray,' +
      'stroke-dashoffset,stroke-linecap,stroke-linejoin,stroke-miterlimit,stroke-opacity,' +
      'stroke-width,systemLanguage,target,text-anchor,to,transform,type,u1,u2,underline-position,' +
      'underline-thickness,unicode,unicode-range,units-per-em,values,version,viewBox,visibility,' +
      'width,widths,x,x-height,x1,x2,xlink:actuate,xlink:arcrole,xlink:role,xlink:show,xlink:title,' +
      'xlink:type,xml:base,xml:lang,xml:space,xmlns,xmlns:xlink,y,y1,y2,zoomAndPan', true);

  var validAttrs = extend({},
                                  uriAttrs,
                                  svgAttrs,
                                  htmlAttrs);

  function toMap(str, lowercaseKeys) {
    var obj = {}, items = str.split(','), i;
    for (i = 0; i < items.length; i++) {
      obj[lowercaseKeys ? lowercase(items[i]) : items[i]] = true;
    }
    return obj;
  }

  var inertBodyElement;
  (function(window) {
    var doc;
    if (window.document && window.document.implementation) {
      doc = window.document.implementation.createHTMLDocument('inert');
    } else {
      throw $sanitizeMinErr('noinert', 'Can\'t create an inert html document');
    }
    var docElement = doc.documentElement || doc.getDocumentElement();
    var bodyElements = docElement.getElementsByTagName('body');

    // usually there should be only one body element in the document, but IE doesn't have any, so we need to create one
    if (bodyElements.length === 1) {
      inertBodyElement = bodyElements[0];
    } else {
      var html = doc.createElement('html');
      inertBodyElement = doc.createElement('body');
      html.appendChild(inertBodyElement);
      doc.appendChild(html);
    }
  })(window);

  /**
   * @example
   * htmlParser(htmlString, {
   *     start: function(tag, attrs) {},
   *     end: function(tag) {},
   *     chars: function(text) {},
   *     comment: function(text) {}
   * });
   *
   * @param {string} html string
   * @param {object} handler
   */
  function htmlParserImpl(html, handler) {
    if (html === null || html === undefined) {
      html = '';
    } else if (typeof html !== 'string') {
      html = '' + html;
    }
    inertBodyElement.innerHTML = html;

    //mXSS protection
    var mXSSAttempts = 5;
    do {
      if (mXSSAttempts === 0) {
        throw $sanitizeMinErr('uinput', 'Failed to sanitize html because the input is unstable');
      }
      mXSSAttempts--;

      // strip custom-namespaced attributes on IE<=11
      if (window.document.documentMode) {
        stripCustomNsAttrs(inertBodyElement);
      }
      html = inertBodyElement.innerHTML; //trigger mXSS
      inertBodyElement.innerHTML = html;
    } while (html !== inertBodyElement.innerHTML);

    var node = inertBodyElement.firstChild;
    while (node) {
      switch (node.nodeType) {
        case 1: // ELEMENT_NODE
          handler.start(node.nodeName.toLowerCase(), attrToMap(node.attributes));
          break;
        case 3: // TEXT NODE
          handler.chars(node.textContent);
          break;
      }

      var nextNode;
      if (!(nextNode = node.firstChild)) {
      if (node.nodeType === 1) {
          handler.end(node.nodeName.toLowerCase());
        }
        nextNode = node.nextSibling;
        if (!nextNode) {
          while (nextNode == null) {
            node = node.parentNode;
            if (node === inertBodyElement) break;
            nextNode = node.nextSibling;
          if (node.nodeType === 1) {
              handler.end(node.nodeName.toLowerCase());
            }
          }
        }
      }
      node = nextNode;
    }

    while ((node = inertBodyElement.firstChild)) {
      inertBodyElement.removeChild(node);
    }
  }

  function attrToMap(attrs) {
    var map = {};
    for (var i = 0, ii = attrs.length; i < ii; i++) {
      var attr = attrs[i];
      map[attr.name] = attr.value;
    }
    return map;
  }


  /**
   * Escapes all potentially dangerous characters, so that the
   * resulting string can be safely inserted into attribute or
   * element text.
   * @param value
   * @returns {string} escaped text
   */
  function encodeEntities(value) {
    return value.
      replace(/&/g, '&amp;').
      replace(SURROGATE_PAIR_REGEXP, function(value) {
        var hi = value.charCodeAt(0);
        var low = value.charCodeAt(1);
        return '&#' + (((hi - 0xD800) * 0x400) + (low - 0xDC00) + 0x10000) + ';';
      }).
      replace(NON_ALPHANUMERIC_REGEXP, function(value) {
        return '&#' + value.charCodeAt(0) + ';';
      }).
      replace(/</g, '&lt;').
      replace(/>/g, '&gt;');
  }

  /**
   * create an HTML/XML writer which writes to buffer
   * @param {Array} buf use buf.join('') to get out sanitized html string
   * @returns {object} in the form of {
   *     start: function(tag, attrs) {},
   *     end: function(tag) {},
   *     chars: function(text) {},
   *     comment: function(text) {}
   * }
   */
  function htmlSanitizeWriterImpl(buf, uriValidator) {
    var ignoreCurrentElement = false;
    var out = bind(buf, buf.push);
    return {
      start: function(tag, attrs) {
        tag = lowercase(tag);
        if (!ignoreCurrentElement && blockedElements[tag]) {
          ignoreCurrentElement = tag;
        }
        if (!ignoreCurrentElement && validElements[tag] === true) {
          out('<');
          out(tag);
          forEach(attrs, function(value, key) {
            var lkey = lowercase(key);
            var isImage = (tag === 'img' && lkey === 'src') || (lkey === 'background');
            if (validAttrs[lkey] === true &&
              (uriAttrs[lkey] !== true || uriValidator(value, isImage))) {
              out(' ');
              out(key);
              out('="');
              out(encodeEntities(value));
              out('"');
            }
          });
          out('>');
        }
      },
      end: function(tag) {
        tag = lowercase(tag);
        if (!ignoreCurrentElement && validElements[tag] === true && voidElements[tag] !== true) {
          out('</');
          out(tag);
          out('>');
        }
        // eslint-disable-next-line eqeqeq
        if (tag == ignoreCurrentElement) {
          ignoreCurrentElement = false;
        }
      },
      chars: function(chars) {
        if (!ignoreCurrentElement) {
          out(encodeEntities(chars));
        }
      }
    };
  }


  /**
   * When IE9-11 comes across an unknown namespaced attribute e.g. 'xlink:foo' it adds 'xmlns:ns1' attribute to declare
   * ns1 namespace and prefixes the attribute with 'ns1' (e.g. 'ns1:xlink:foo'). This is undesirable since we don't want
   * to allow any of these custom attributes. This method strips them all.
   *
   * @param node Root element to process
   */
  function stripCustomNsAttrs(node) {
    while (node) {
      if (node.nodeType === window.Node.ELEMENT_NODE) {
        var attrs = node.attributes;
        for (var i = 0, l = attrs.length; i < l; i++) {
          var attrNode = attrs[i];
          var attrName = attrNode.name.toLowerCase();
          if (attrName === 'xmlns:ns1' || attrName.lastIndexOf('ns1:', 0) === 0) {
            node.removeAttributeNode(attrNode);
            i--;
            l--;
          }
        }
      }

      var nextNode = node.firstChild;
      if (nextNode) {
        stripCustomNsAttrs(nextNode);
      }

      node = node.nextSibling;
    }
  }
}

function sanitizeText(chars) {
  var buf = [];
  var writer = htmlSanitizeWriter(buf, noop);
  writer.chars(chars);
  return buf.join('');
}


// define ngSanitize module and register $sanitize service
angular.module('ngSanitize', []).provider('$sanitize', $SanitizeProvider);

/**
 * @ngdoc filter
 * @name linky
 * @kind function
 *
 * @description
 * Finds links in text input and turns them into html links. Supports `http/https/ftp/mailto` and
 * plain email address links.
 *
 * Requires the {@link ngSanitize `ngSanitize`} module to be installed.
 *
 * @param {string} text Input text.
 * @param {string} target Window (`_blank|_self|_parent|_top`) or named frame to open links in.
 * @param {object|function(url)} [attributes] Add custom attributes to the link element.
 *
 *    Can be one of:
 *
 *    - `object`: A map of attributes
 *    - `function`: Takes the url as a parameter and returns a map of attributes
 *
 *    If the map of attributes contains a value for `target`, it overrides the value of
 *    the target parameter.
 *
 *
 * @returns {string} Html-linkified and {@link $sanitize sanitized} text.
 *
 * @usage
   <span ng-bind-html="linky_expression | linky"></span>
 *
 * @example
   <example module="linkyExample" deps="angular-sanitize.js" name="linky-filter">
     <file name="index.html">
       <div ng-controller="ExampleController">
       Snippet: <textarea ng-model="snippet" cols="60" rows="3"></textarea>
       <table>
         <tr>
           <th>Filter</th>
           <th>Source</th>
           <th>Rendered</th>
         </tr>
         <tr id="linky-filter">
           <td>linky filter</td>
           <td>
             <pre>&lt;div ng-bind-html="snippet | linky"&gt;<br>&lt;/div&gt;</pre>
           </td>
           <td>
             <div ng-bind-html="snippet | linky"></div>
           </td>
         </tr>
         <tr id="linky-target">
          <td>linky target</td>
          <td>
            <pre>&lt;div ng-bind-html="snippetWithSingleURL | linky:'_blank'"&gt;<br>&lt;/div&gt;</pre>
          </td>
          <td>
            <div ng-bind-html="snippetWithSingleURL | linky:'_blank'"></div>
          </td>
         </tr>
         <tr id="linky-custom-attributes">
          <td>linky custom attributes</td>
          <td>
            <pre>&lt;div ng-bind-html="snippetWithSingleURL | linky:'_self':{rel: 'nofollow'}"&gt;<br>&lt;/div&gt;</pre>
          </td>
          <td>
            <div ng-bind-html="snippetWithSingleURL | linky:'_self':{rel: 'nofollow'}"></div>
          </td>
         </tr>
         <tr id="escaped-html">
           <td>no filter</td>
           <td><pre>&lt;div ng-bind="snippet"&gt;<br>&lt;/div&gt;</pre></td>
           <td><div ng-bind="snippet"></div></td>
         </tr>
       </table>
     </file>
     <file name="script.js">
       angular.module('linkyExample', ['ngSanitize'])
         .controller('ExampleController', ['$scope', function($scope) {
           $scope.snippet =
             'Pretty text with some links:\n' +
             'http://angularjs.org/,\n' +
             'mailto:us@somewhere.org,\n' +
             'another@somewhere.org,\n' +
             'and one more: ftp://127.0.0.1/.';
           $scope.snippetWithSingleURL = 'http://angularjs.org/';
         }]);
     </file>
     <file name="protractor.js" type="protractor">
       it('should linkify the snippet with urls', function() {
         expect(element(by.id('linky-filter')).element(by.binding('snippet | linky')).getText()).
             toBe('Pretty text with some links: http://angularjs.org/, us@somewhere.org, ' +
                  'another@somewhere.org, and one more: ftp://127.0.0.1/.');
         expect(element.all(by.css('#linky-filter a')).count()).toEqual(4);
       });

       it('should not linkify snippet without the linky filter', function() {
         expect(element(by.id('escaped-html')).element(by.binding('snippet')).getText()).
             toBe('Pretty text with some links: http://angularjs.org/, mailto:us@somewhere.org, ' +
                  'another@somewhere.org, and one more: ftp://127.0.0.1/.');
         expect(element.all(by.css('#escaped-html a')).count()).toEqual(0);
       });

       it('should update', function() {
         element(by.model('snippet')).clear();
         element(by.model('snippet')).sendKeys('new http://link.');
         expect(element(by.id('linky-filter')).element(by.binding('snippet | linky')).getText()).
             toBe('new http://link.');
         expect(element.all(by.css('#linky-filter a')).count()).toEqual(1);
         expect(element(by.id('escaped-html')).element(by.binding('snippet')).getText())
             .toBe('new http://link.');
       });

       it('should work with the target property', function() {
        expect(element(by.id('linky-target')).
            element(by.binding("snippetWithSingleURL | linky:'_blank'")).getText()).
            toBe('http://angularjs.org/');
        expect(element(by.css('#linky-target a')).getAttribute('target')).toEqual('_blank');
       });

       it('should optionally add custom attributes', function() {
        expect(element(by.id('linky-custom-attributes')).
            element(by.binding("snippetWithSingleURL | linky:'_self':{rel: 'nofollow'}")).getText()).
            toBe('http://angularjs.org/');
        expect(element(by.css('#linky-custom-attributes a')).getAttribute('rel')).toEqual('nofollow');
       });
     </file>
   </example>
 */
angular.module('ngSanitize').filter('linky', ['$sanitize', function($sanitize) {
  var LINKY_URL_REGEXP =
        /((ftp|https?):\/\/|(www\.)|(mailto:)?[A-Za-z0-9._%+-]+@)\S*[^\s.;,(){}<>"\u201d\u2019]/i,
      MAILTO_REGEXP = /^mailto:/i;

  var linkyMinErr = angular.$$minErr('linky');
  var isDefined = angular.isDefined;
  var isFunction = angular.isFunction;
  var isObject = angular.isObject;
  var isString = angular.isString;

  return function(text, target, attributes) {
    if (text == null || text === '') return text;
    if (!isString(text)) throw linkyMinErr('notstring', 'Expected string but received: {0}', text);

    var attributesFn =
      isFunction(attributes) ? attributes :
      isObject(attributes) ? function getAttributesObject() {return attributes;} :
      function getEmptyAttributesObject() {return {};};

    var match;
    var raw = text;
    var html = [];
    var url;
    var i;
    while ((match = raw.match(LINKY_URL_REGEXP))) {
      // We can not end in these as they are sometimes found at the end of the sentence
      url = match[0];
      // if we did not match ftp/http/www/mailto then assume mailto
      if (!match[2] && !match[4]) {
        url = (match[3] ? 'http://' : 'mailto:') + url;
      }
      i = match.index;
      addText(raw.substr(0, i));
      addLink(url, match[0].replace(MAILTO_REGEXP, ''));
      raw = raw.substring(i + match[0].length);
    }
    addText(raw);
    return $sanitize(html.join(''));

    function addText(text) {
      if (!text) {
        return;
      }
      html.push(sanitizeText(text));
    }

    function addLink(url, text) {
      var key, linkAttributes = attributesFn(url);
      html.push('<a ');

      for (key in linkAttributes) {
        html.push(key + '="' + linkAttributes[key] + '" ');
      }

      if (isDefined(target) && !('target' in linkAttributes)) {
        html.push('target="',
                  target,
                  '" ');
      }
      html.push('href="',
                url.replace(/"/g, '&quot;'),
                '">');
      addText(text);
      html.push('</a>');
    }
  };
}]);


})(window, window.angular);

/*! 12.2.13 */
!window.XMLHttpRequest||window.FileAPI&&FileAPI.shouldLoad||(window.XMLHttpRequest.prototype.setRequestHeader=function(a){return function(b,c){if("__setXHR_"===b){var d=c(this);d instanceof Function&&d(this)}else a.apply(this,arguments)}}(window.XMLHttpRequest.prototype.setRequestHeader));var ngFileUpload=angular.module("ngFileUpload",[]);ngFileUpload.version="12.2.13",ngFileUpload.service("UploadBase",["$http","$q","$timeout",function(a,b,c){function d(d){function e(a){j.notify&&j.notify(a),k.progressFunc&&c(function(){k.progressFunc(a)})}function h(a){return null!=d._start&&g?{loaded:a.loaded+d._start,total:d._file&&d._file.size||a.total,type:a.type,config:d,lengthComputable:!0,target:a.target}:a}function i(){a(d).then(function(a){if(g&&d._chunkSize&&!d._finished&&d._file){var b=d._file&&d._file.size||0;e({loaded:Math.min(d._end,b),total:b,config:d,type:"progress"}),f.upload(d,!0)}else d._finished&&delete d._finished,j.resolve(a)},function(a){j.reject(a)},function(a){j.notify(a)})}d.method=d.method||"POST",d.headers=d.headers||{};var j=d._deferred=d._deferred||b.defer(),k=j.promise;return d.disableProgress||(d.headers.__setXHR_=function(){return function(a){a&&a.upload&&a.upload.addEventListener&&(d.__XHR=a,d.xhrFn&&d.xhrFn(a),a.upload.addEventListener("progress",function(a){a.config=d,e(h(a))},!1),a.upload.addEventListener("load",function(a){a.lengthComputable&&(a.config=d,e(h(a)))},!1))}}),g?d._chunkSize&&d._end&&!d._finished?(d._start=d._end,d._end+=d._chunkSize,i()):d.resumeSizeUrl?a.get(d.resumeSizeUrl).then(function(a){d._start=d.resumeSizeResponseReader?d.resumeSizeResponseReader(a.data):parseInt((null==a.data.size?a.data:a.data.size).toString()),d._chunkSize&&(d._end=d._start+d._chunkSize),i()},function(a){throw a}):d.resumeSize?d.resumeSize().then(function(a){d._start=a,d._chunkSize&&(d._end=d._start+d._chunkSize),i()},function(a){throw a}):(d._chunkSize&&(d._start=0,d._end=d._start+d._chunkSize),i()):i(),k.success=function(a){return k.then(function(b){a(b.data,b.status,b.headers,d)}),k},k.error=function(a){return k.then(null,function(b){a(b.data,b.status,b.headers,d)}),k},k.progress=function(a){return k.progressFunc=a,k.then(null,null,function(b){a(b)}),k},k.abort=k.pause=function(){return d.__XHR&&c(function(){d.__XHR.abort()}),k},k.xhr=function(a){return d.xhrFn=function(b){return function(){b&&b.apply(k,arguments),a.apply(k,arguments)}}(d.xhrFn),k},f.promisesCount++,k["finally"]&&k["finally"]instanceof Function&&k["finally"](function(){f.promisesCount--}),k}function e(a){var b={};for(var c in a)a.hasOwnProperty(c)&&(b[c]=a[c]);return b}var f=this;f.promisesCount=0,this.isResumeSupported=function(){return window.Blob&&window.Blob.prototype.slice};var g=this.isResumeSupported();this.isUploadInProgress=function(){return f.promisesCount>0},this.rename=function(a,b){return a.ngfName=b,a},this.jsonBlob=function(a){null==a||angular.isString(a)||(a=JSON.stringify(a));var b=new window.Blob([a],{type:"application/json"});return b._ngfBlob=!0,b},this.json=function(a){return angular.toJson(a)},this.isFile=function(a){return null!=a&&(a instanceof window.Blob||a.flashId&&a.name&&a.size)},this.upload=function(a,b){function c(b,c){if(b._ngfBlob)return b;if(a._file=a._file||b,null!=a._start&&g){a._end&&a._end>=b.size&&(a._finished=!0,a._end=b.size);var d=b.slice(a._start,a._end||b.size);return d.name=b.name,d.ngfName=b.ngfName,a._chunkSize&&(c.append("_chunkSize",a._chunkSize),c.append("_currentChunkSize",a._end-a._start),c.append("_chunkNumber",Math.floor(a._start/a._chunkSize)),c.append("_totalSize",a._file.size)),d}return b}function h(b,d,e){if(void 0!==d)if(angular.isDate(d)&&(d=d.toISOString()),angular.isString(d))b.append(e,d);else if(f.isFile(d)){var g=c(d,b),i=e.split(",");i[1]&&(g.ngfName=i[1].replace(/^\s+|\s+$/g,""),e=i[0]),a._fileKey=a._fileKey||e,b.append(e,g,g.ngfName||g.name)}else if(angular.isObject(d)){if(d.$$ngfCircularDetection)throw"ngFileUpload: Circular reference in config.data. Make sure specified data for Upload.upload() has no circular reference: "+e;d.$$ngfCircularDetection=!0;try{for(var j in d)if(d.hasOwnProperty(j)&&"$$ngfCircularDetection"!==j){var k=null==a.objectKey?"[i]":a.objectKey;d.length&&parseInt(j)>-1&&(k=null==a.arrayKey?k:a.arrayKey),h(b,d[j],e+k.replace(/[ik]/g,j))}}finally{delete d.$$ngfCircularDetection}}else b.append(e,d)}function i(){a._chunkSize=f.translateScalars(a.resumeChunkSize),a._chunkSize=a._chunkSize?parseInt(a._chunkSize.toString()):null,a.headers=a.headers||{},a.headers["Content-Type"]=void 0,a.transformRequest=a.transformRequest?angular.isArray(a.transformRequest)?a.transformRequest:[a.transformRequest]:[],a.transformRequest.push(function(b){var c,d=new window.FormData;b=b||a.fields||{},a.file&&(b.file=a.file);for(c in b)if(b.hasOwnProperty(c)){var e=b[c];a.formDataAppender?a.formDataAppender(d,c,e):h(d,e,c)}return d})}return b||(a=e(a)),a._isDigested||(a._isDigested=!0,i()),d(a)},this.http=function(b){return b=e(b),b.transformRequest=b.transformRequest||function(b){return window.ArrayBuffer&&b instanceof window.ArrayBuffer||b instanceof window.Blob?b:a.defaults.transformRequest[0].apply(this,arguments)},b._chunkSize=f.translateScalars(b.resumeChunkSize),b._chunkSize=b._chunkSize?parseInt(b._chunkSize.toString()):null,d(b)},this.translateScalars=function(a){if(angular.isString(a)){if(a.search(/kb/i)===a.length-2)return parseFloat(1024*a.substring(0,a.length-2));if(a.search(/mb/i)===a.length-2)return parseFloat(1048576*a.substring(0,a.length-2));if(a.search(/gb/i)===a.length-2)return parseFloat(1073741824*a.substring(0,a.length-2));if(a.search(/b/i)===a.length-1)return parseFloat(a.substring(0,a.length-1));if(a.search(/s/i)===a.length-1)return parseFloat(a.substring(0,a.length-1));if(a.search(/m/i)===a.length-1)return parseFloat(60*a.substring(0,a.length-1));if(a.search(/h/i)===a.length-1)return parseFloat(3600*a.substring(0,a.length-1))}return a},this.urlToBlob=function(c){var d=b.defer();return a({url:c,method:"get",responseType:"arraybuffer"}).then(function(a){var b=new Uint8Array(a.data),e=a.headers("content-type")||"image/WebP",f=new window.Blob([b],{type:e}),g=c.match(/.*\/(.+?)(\?.*)?$/);g.length>1&&(f.name=g[1]),d.resolve(f)},function(a){d.reject(a)}),d.promise},this.setDefaults=function(a){this.defaults=a||{}},this.defaults={},this.version=ngFileUpload.version}]),ngFileUpload.service("Upload",["$parse","$timeout","$compile","$q","UploadExif",function(a,b,c,d,e){function f(a,b,c){var e=[i.emptyPromise()];return angular.forEach(a,function(d,f){0===d.type.indexOf("image/jpeg")&&i.attrGetter("ngfFixOrientation",b,c,{$file:d})&&e.push(i.happyPromise(i.applyExifRotation(d),d).then(function(b){a.splice(f,1,b)}))}),d.all(e)}function g(a,b,c,e){var f=i.attrGetter("ngfResize",b,c);if(!f||!i.isResizeSupported()||!a.length)return i.emptyPromise();if(f instanceof Function){var g=d.defer();return f(a).then(function(d){h(d,a,b,c,e).then(function(a){g.resolve(a)},function(a){g.reject(a)})},function(a){g.reject(a)})}return h(f,a,b,c,e)}function h(a,b,c,e,f){function g(d,g){if(0===d.type.indexOf("image")){if(a.pattern&&!i.validatePattern(d,a.pattern))return;a.resizeIf=function(a,b){return i.attrGetter("ngfResizeIf",c,e,{$width:a,$height:b,$file:d})};var j=i.resize(d,a);h.push(j),j.then(function(a){b.splice(g,1,a)},function(a){d.$error="resize",(d.$errorMessages=d.$errorMessages||{}).resize=!0,d.$errorParam=(a?(a.message?a.message:a)+": ":"")+(d&&d.name),f.$ngfValidations.push({name:"resize",valid:!1}),i.applyModelValidation(f,b)})}}for(var h=[i.emptyPromise()],j=0;j<b.length;j++)g(b[j],j);return d.all(h)}var i=e;return i.getAttrWithDefaults=function(a,b){if(null!=a[b])return a[b];var c=i.defaults[b];return null==c?c:angular.isString(c)?c:JSON.stringify(c)},i.attrGetter=function(b,c,d,e){var f=this.getAttrWithDefaults(c,b);if(!d)return f;try{return e?a(f)(d,e):a(f)(d)}catch(g){if(b.search(/min|max|pattern/i))return f;throw g}},i.shouldUpdateOn=function(a,b,c){var d=i.attrGetter("ngfModelOptions",b,c);return d&&d.updateOn?d.updateOn.split(" ").indexOf(a)>-1:!0},i.emptyPromise=function(){var a=d.defer(),c=arguments;return b(function(){a.resolve.apply(a,c)}),a.promise},i.rejectPromise=function(){var a=d.defer(),c=arguments;return b(function(){a.reject.apply(a,c)}),a.promise},i.happyPromise=function(a,c){var e=d.defer();return a.then(function(a){e.resolve(a)},function(a){b(function(){throw a}),e.resolve(c)}),e.promise},i.updateModel=function(c,d,e,h,j,k,l){function m(f,g,j,l,m){d.$$ngfPrevValidFiles=f,d.$$ngfPrevInvalidFiles=g;var n=f&&f.length?f[0]:null,o=g&&g.length?g[0]:null;c&&(i.applyModelValidation(c,f),c.$setViewValue(m?n:f)),h&&a(h)(e,{$files:f,$file:n,$newFiles:j,$duplicateFiles:l,$invalidFiles:g,$invalidFile:o,$event:k});var p=i.attrGetter("ngfModelInvalid",d);p&&b(function(){a(p).assign(e,m?o:g)}),b(function(){})}function n(){function a(a,b){return a.name===b.name&&(a.$ngfOrigSize||a.size)===(b.$ngfOrigSize||b.size)&&a.type===b.type}function b(b){var c;for(c=0;c<r.length;c++)if(a(b,r[c]))return!0;for(c=0;c<s.length;c++)if(a(b,s[c]))return!0;return!1}if(j){q=[],t=[];for(var c=0;c<j.length;c++)b(j[c])?t.push(j[c]):q.push(j[c])}}function o(a){return angular.isArray(a)?a:[a]}function p(){function a(){b(function(){m(w?r.concat(v):v,w?s.concat(u):u,j,t,x)},z&&z.debounce?z.debounce.change||z.debounce:0)}var f=y?q:v;g(f,d,e,c).then(function(){y?i.validate(q,w?r.length:0,c,d,e).then(function(b){v=b.validsFiles,u=b.invalidsFiles,a()}):a()},function(){for(var b=0;b<f.length;b++){var c=f[b];if("resize"===c.$error){var d=v.indexOf(c);d>-1&&(v.splice(d,1),u.push(c)),a()}}})}var q,r,s,t=[],u=[],v=[];r=d.$$ngfPrevValidFiles||[],s=d.$$ngfPrevInvalidFiles||[],c&&c.$modelValue&&(r=o(c.$modelValue));var w=i.attrGetter("ngfKeep",d,e);q=(j||[]).slice(0),("distinct"===w||i.attrGetter("ngfKeepDistinct",d,e)===!0)&&n(d,e);var x=!w&&!i.attrGetter("ngfMultiple",d,e)&&!i.attrGetter("multiple",d);if(!w||q.length){i.attrGetter("ngfBeforeModelChange",d,e,{$files:j,$file:j&&j.length?j[0]:null,$newFiles:q,$duplicateFiles:t,$event:k});var y=i.attrGetter("ngfValidateAfterResize",d,e),z=i.attrGetter("ngfModelOptions",d,e);i.validate(q,w?r.length:0,c,d,e).then(function(a){l?m(q,[],j,t,x):(z&&z.allowInvalid||y?v=q:(v=a.validFiles,u=a.invalidFiles),i.attrGetter("ngfFixOrientation",d,e)&&i.isExifSupported()?f(v,d,e).then(function(){p()}):p())})}},i}]),ngFileUpload.directive("ngfSelect",["$parse","$timeout","$compile","Upload",function(a,b,c,d){function e(a){var b=a.match(/Android[^\d]*(\d+)\.(\d+)/);if(b&&b.length>2){var c=d.defaults.androidFixMinorVersion||4;return parseInt(b[1])<4||parseInt(b[1])===c&&parseInt(b[2])<c}return-1===a.indexOf("Chrome")&&/.*Windows.*Safari.*/.test(a)}function f(a,b,c,d,f,h,i,j){function k(){return"input"===b[0].tagName.toLowerCase()&&c.type&&"file"===c.type.toLowerCase()}function l(){return t("ngfChange")||t("ngfSelect")}function m(b){if(j.shouldUpdateOn("change",c,a)){var e=b.__files_||b.target&&b.target.files,f=[];if(!e)return;for(var g=0;g<e.length;g++)f.push(e[g]);j.updateModel(d,c,a,l(),f.length?f:null,b)}}function n(a,d){function e(b){a.attr("id","ngf-"+b),d.attr("id","ngf-label-"+b)}for(var f=0;f<b[0].attributes.length;f++){var g=b[0].attributes[f];"type"!==g.name&&"class"!==g.name&&"style"!==g.name&&("id"===g.name?(e(g.value),u.push(c.$observe("id",e))):a.attr(g.name,g.value||"required"!==g.name&&"multiple"!==g.name?g.value:g.name))}}function o(){if(k())return b;var a=angular.element('<input type="file">'),c=angular.element("<label>upload</label>");return c.css("visibility","hidden").css("position","absolute").css("overflow","hidden").css("width","0px").css("height","0px").css("border","none").css("margin","0px").css("padding","0px").attr("tabindex","-1"),n(a,c),g.push({el:b,ref:c}),document.body.appendChild(c.append(a)[0]),a}function p(c){if(b.attr("disabled"))return!1;if(!t("ngfSelectDisabled",a)){var d=q(c);if(null!=d)return d;r(c);try{k()||document.body.contains(x[0])||(g.push({el:b,ref:x.parent()}),document.body.appendChild(x.parent()[0]),x.bind("change",m))}catch(f){}return e(navigator.userAgent)?setTimeout(function(){x[0].click()},0):x[0].click(),!1}}function q(a){var b=a.changedTouches||a.originalEvent&&a.originalEvent.changedTouches;if(b){if("touchstart"===a.type)return w=b[0].clientX,v=b[0].clientY,!0;if("touchend"===a.type){var c=b[0].clientX,d=b[0].clientY;if(Math.abs(c-w)>20||Math.abs(d-v)>20)return a.stopPropagation(),a.preventDefault(),!1}return!0}}function r(b){j.shouldUpdateOn("click",c,a)&&x.val()&&(x.val(null),j.updateModel(d,c,a,l(),null,b,!0))}function s(a){if(x&&!x.attr("__ngf_ie10_Fix_")){if(!x[0].parentNode)return void(x=null);a.preventDefault(),a.stopPropagation(),x.unbind("click");var b=x.clone();return x.replaceWith(b),x=b,x.attr("__ngf_ie10_Fix_","true"),x.bind("change",m),x.bind("click",s),x[0].click(),!1}x.removeAttr("__ngf_ie10_Fix_")}var t=function(a,b){return j.attrGetter(a,c,b)};j.registerModelChangeValidator(d,c,a);var u=[];t("ngfMultiple")&&u.push(a.$watch(t("ngfMultiple"),function(){x.attr("multiple",t("ngfMultiple",a))})),t("ngfCapture")&&u.push(a.$watch(t("ngfCapture"),function(){x.attr("capture",t("ngfCapture",a))})),t("ngfAccept")&&u.push(a.$watch(t("ngfAccept"),function(){x.attr("accept",t("ngfAccept",a))})),u.push(c.$observe("accept",function(){x.attr("accept",t("accept"))}));var v=0,w=0,x=b;k()||(x=o()),x.bind("change",m),k()?b.bind("click",r):b.bind("click touchstart touchend",p),-1!==navigator.appVersion.indexOf("MSIE 10")&&x.bind("click",s),d&&d.$formatters.push(function(a){return(null==a||0===a.length)&&x.val()&&x.val(null),a}),a.$on("$destroy",function(){k()||x.parent().remove(),angular.forEach(u,function(a){a()})}),h(function(){for(var a=0;a<g.length;a++){var b=g[a];document.body.contains(b.el[0])||(g.splice(a,1),b.ref.remove())}}),window.FileAPI&&window.FileAPI.ngfFixIE&&window.FileAPI.ngfFixIE(b,x,m)}var g=[];return{restrict:"AEC",require:"?ngModel",link:function(e,g,h,i){f(e,g,h,i,a,b,c,d)}}}]),function(){function a(a){return"img"===a.tagName.toLowerCase()?"image":"audio"===a.tagName.toLowerCase()?"audio":"video"===a.tagName.toLowerCase()?"video":/./}function b(b,c,d,e,f,g,h,i){function j(a){var g=b.attrGetter("ngfNoObjectUrl",f,d);b.dataUrl(a,g)["finally"](function(){c(function(){var b=(g?a.$ngfDataUrl:a.$ngfBlobUrl)||a.$ngfDataUrl;i?e.css("background-image","url('"+(b||"")+"')"):e.attr("src",b),b?e.removeClass("ng-hide"):e.addClass("ng-hide")})})}c(function(){var c=d.$watch(f[g],function(c){var k=h;if("ngfThumbnail"===g&&(k||(k={width:e[0].naturalWidth||e[0].clientWidth,height:e[0].naturalHeight||e[0].clientHeight}),0===k.width&&window.getComputedStyle)){var l=getComputedStyle(e[0]);l.width&&l.width.indexOf("px")>-1&&l.height&&l.height.indexOf("px")>-1&&(k={width:parseInt(l.width.slice(0,-2)),height:parseInt(l.height.slice(0,-2))})}return angular.isString(c)?(e.removeClass("ng-hide"),i?e.css("background-image","url('"+c+"')"):e.attr("src",c)):void(!c||!c.type||0!==c.type.search(a(e[0]))||i&&0!==c.type.indexOf("image")?e.addClass("ng-hide"):k&&b.isResizeSupported()?(k.resizeIf=function(a,e){return b.attrGetter("ngfResizeIf",f,d,{$width:a,$height:e,$file:c})},b.resize(c,k).then(function(a){j(a)},function(a){throw a})):j(c))});d.$on("$destroy",function(){c()})})}ngFileUpload.service("UploadDataUrl",["UploadBase","$timeout","$q",function(a,b,c){var d=a;return d.base64DataUrl=function(a){if(angular.isArray(a)){var b=c.defer(),e=0;return angular.forEach(a,function(c){d.dataUrl(c,!0)["finally"](function(){if(e++,e===a.length){var c=[];angular.forEach(a,function(a){c.push(a.$ngfDataUrl)}),b.resolve(c,a)}})}),b.promise}return d.dataUrl(a,!0)},d.dataUrl=function(a,e){if(!a)return d.emptyPromise(a,a);if(e&&null!=a.$ngfDataUrl||!e&&null!=a.$ngfBlobUrl)return d.emptyPromise(e?a.$ngfDataUrl:a.$ngfBlobUrl,a);var f=e?a.$$ngfDataUrlPromise:a.$$ngfBlobUrlPromise;if(f)return f;var g=c.defer();return b(function(){if(window.FileReader&&a&&(!window.FileAPI||-1===navigator.userAgent.indexOf("MSIE 8")||a.size<2e4)&&(!window.FileAPI||-1===navigator.userAgent.indexOf("MSIE 9")||a.size<4e6)){var c=window.URL||window.webkitURL;if(c&&c.createObjectURL&&!e){var f;try{f=c.createObjectURL(a)}catch(h){return void b(function(){a.$ngfBlobUrl="",g.reject()})}b(function(){if(a.$ngfBlobUrl=f,f){g.resolve(f,a),d.blobUrls=d.blobUrls||[],d.blobUrlsTotalSize=d.blobUrlsTotalSize||0,d.blobUrls.push({url:f,size:a.size}),d.blobUrlsTotalSize+=a.size||0;for(var b=d.defaults.blobUrlsMaxMemory||268435456,e=d.defaults.blobUrlsMaxQueueSize||200;(d.blobUrlsTotalSize>b||d.blobUrls.length>e)&&d.blobUrls.length>1;){var h=d.blobUrls.splice(0,1)[0];c.revokeObjectURL(h.url),d.blobUrlsTotalSize-=h.size}}})}else{var i=new FileReader;i.onload=function(c){b(function(){a.$ngfDataUrl=c.target.result,g.resolve(c.target.result,a),b(function(){delete a.$ngfDataUrl},1e3)})},i.onerror=function(){b(function(){a.$ngfDataUrl="",g.reject()})},i.readAsDataURL(a)}}else b(function(){a[e?"$ngfDataUrl":"$ngfBlobUrl"]="",g.reject()})}),f=e?a.$$ngfDataUrlPromise=g.promise:a.$$ngfBlobUrlPromise=g.promise,f["finally"](function(){delete a[e?"$$ngfDataUrlPromise":"$$ngfBlobUrlPromise"]}),f},d}]),ngFileUpload.directive("ngfSrc",["Upload","$timeout",function(a,c){return{restrict:"AE",link:function(d,e,f){b(a,c,d,e,f,"ngfSrc",a.attrGetter("ngfResize",f,d),!1)}}}]),ngFileUpload.directive("ngfBackground",["Upload","$timeout",function(a,c){return{restrict:"AE",link:function(d,e,f){b(a,c,d,e,f,"ngfBackground",a.attrGetter("ngfResize",f,d),!0)}}}]),ngFileUpload.directive("ngfThumbnail",["Upload","$timeout",function(a,c){return{restrict:"AE",link:function(d,e,f){var g=a.attrGetter("ngfSize",f,d);b(a,c,d,e,f,"ngfThumbnail",g,a.attrGetter("ngfAsBackground",f,d))}}}]),ngFileUpload.config(["$compileProvider",function(a){a.imgSrcSanitizationWhitelist&&a.imgSrcSanitizationWhitelist(/^\s*(https?|ftp|mailto|tel|webcal|local|file|data|blob):/),a.aHrefSanitizationWhitelist&&a.aHrefSanitizationWhitelist(/^\s*(https?|ftp|mailto|tel|webcal|local|file|data|blob):/)}]),ngFileUpload.filter("ngfDataUrl",["UploadDataUrl","$sce",function(a,b){return function(c,d,e){if(angular.isString(c))return b.trustAsResourceUrl(c);var f=c&&((d?c.$ngfDataUrl:c.$ngfBlobUrl)||c.$ngfDataUrl);return c&&!f?(!c.$ngfDataUrlFilterInProgress&&angular.isObject(c)&&(c.$ngfDataUrlFilterInProgress=!0,a.dataUrl(c,d)),""):(c&&delete c.$ngfDataUrlFilterInProgress,(c&&f?e?b.trustAsResourceUrl(f):f:c)||"")}}])}(),ngFileUpload.service("UploadValidate",["UploadDataUrl","$q","$timeout",function(a,b,c){function d(a){var b="",c=[];if(a.length>2&&"/"===a[0]&&"/"===a[a.length-1])b=a.substring(1,a.length-1);else{var e=a.split(",");if(e.length>1)for(var f=0;f<e.length;f++){var g=d(e[f]);g.regexp?(b+="("+g.regexp+")",f<e.length-1&&(b+="|")):c=c.concat(g.excludes)}else 0===a.indexOf("!")?c.push("^((?!"+d(a.substring(1)).regexp+").)*$"):(0===a.indexOf(".")&&(a="*"+a),b="^"+a.replace(new RegExp("[.\\\\+*?\\[\\^\\]$(){}=!<>|:\\-]","g"),"\\$&")+"$",b=b.replace(/\\\*/g,".*").replace(/\\\?/g,"."))}return{regexp:b,excludes:c}}function e(a,b){null==b||a.$dirty||(a.$setDirty?a.$setDirty():a.$dirty=!0)}var f=a;return f.validatePattern=function(a,b){if(!b)return!0;var c=d(b),e=!0;if(c.regexp&&c.regexp.length){var f=new RegExp(c.regexp,"i");e=null!=a.type&&f.test(a.type)||null!=a.name&&f.test(a.name)}for(var g=c.excludes.length;g--;){var h=new RegExp(c.excludes[g],"i");e=e&&(null==a.type||h.test(a.type))&&(null==a.name||h.test(a.name))}return e},f.ratioToFloat=function(a){var b=a.toString(),c=b.search(/[x:]/i);return b=c>-1?parseFloat(b.substring(0,c))/parseFloat(b.substring(c+1)):parseFloat(b)},f.registerModelChangeValidator=function(a,b,c){a&&a.$formatters.push(function(d){if(a.$dirty){var e=d;d&&!angular.isArray(d)&&(e=[d]),f.validate(e,0,a,b,c).then(function(){f.applyModelValidation(a,e)})}return d})},f.applyModelValidation=function(a,b){e(a,b),angular.forEach(a.$ngfValidations,function(b){a.$setValidity(b.name,b.valid)})},f.getValidationAttr=function(a,b,c,d,e){var g="ngf"+c[0].toUpperCase()+c.substr(1),h=f.attrGetter(g,a,b,{$file:e});if(null==h&&(h=f.attrGetter("ngfValidate",a,b,{$file:e}))){var i=(d||c).split(".");h=h[i[0]],i.length>1&&(h=h&&h[i[1]])}return h},f.validate=function(a,c,d,e,g){function h(b,c,h){if(a){for(var i=a.length,j=null;i--;){var n=a[i];if(n){var o=f.getValidationAttr(e,g,b,c,n);null!=o&&(h(n,o,i)||(-1===k.indexOf(b)?(n.$error=b,(n.$errorMessages=n.$errorMessages||{})[b]=!0,n.$errorParam=o,-1===m.indexOf(n)&&m.push(n),l||a.splice(i,1),j=!1):a.splice(i,1)))}}null!==j&&d.$ngfValidations.push({name:b,valid:j})}}function i(c,h,i,n,o){function p(b,d,e){function f(f){if(f())if(-1===k.indexOf(c)){if(d.$error=c,(d.$errorMessages=d.$errorMessages||{})[c]=!0,d.$errorParam=e,-1===m.indexOf(d)&&m.push(d),!l){var g=a.indexOf(d);g>-1&&a.splice(g,1)}b.resolve(!1)}else{var h=a.indexOf(d);h>-1&&a.splice(h,1),b.resolve(!0)}else b.resolve(!0)}null!=e?n(d,e).then(function(a){f(function(){return!o(a,e)})},function(){f(function(){return j("ngfValidateForce",{$file:d})})}):b.resolve(!0)}var q=[f.emptyPromise(!0)];a&&(a=void 0===a.length?[a]:a,angular.forEach(a,function(a){var d=b.defer();return q.push(d.promise),!i||null!=a.type&&0===a.type.search(i)?void("dimensions"===c&&null!=f.attrGetter("ngfDimensions",e)?f.imageDimensions(a).then(function(b){p(d,a,j("ngfDimensions",{$file:a,$width:b.width,$height:b.height}))},function(){d.resolve(!1)}):"duration"===c&&null!=f.attrGetter("ngfDuration",e)?f.mediaDuration(a).then(function(b){p(d,a,j("ngfDuration",{$file:a,$duration:b}))},function(){d.resolve(!1)}):p(d,a,f.getValidationAttr(e,g,c,h,a))):void d.resolve(!0)}));var r=b.defer();return b.all(q).then(function(a){for(var b=!0,e=0;e<a.length;e++)if(!a[e]){b=!1;break}d.$ngfValidations.push({name:c,valid:b}),r.resolve(b)}),r.promise}d=d||{},d.$ngfValidations=d.$ngfValidations||[],angular.forEach(d.$ngfValidations,function(a){a.valid=!0});var j=function(a,b){return f.attrGetter(a,e,g,b)},k=(f.attrGetter("ngfIgnoreInvalid",e,g)||"").split(" "),l=f.attrGetter("ngfRunAllValidations",e,g);if(null==a||0===a.length)return f.emptyPromise({validFiles:a,invalidFiles:[]});a=void 0===a.length?[a]:a.slice(0);var m=[];h("pattern",null,f.validatePattern),h("minSize","size.min",function(a,b){return a.size+.1>=f.translateScalars(b)}),h("maxSize","size.max",function(a,b){return a.size-.1<=f.translateScalars(b)});var n=0;if(h("maxTotalSize",null,function(b,c){return n+=b.size,n>f.translateScalars(c)?(a.splice(0,a.length),!1):!0}),h("validateFn",null,function(a,b){return b===!0||null===b||""===b}),!a.length)return f.emptyPromise({validFiles:[],invalidFiles:m});var o=b.defer(),p=[];return p.push(i("maxHeight","height.max",/image/,this.imageDimensions,function(a,b){return a.height<=b})),p.push(i("minHeight","height.min",/image/,this.imageDimensions,function(a,b){return a.height>=b})),p.push(i("maxWidth","width.max",/image/,this.imageDimensions,function(a,b){return a.width<=b})),p.push(i("minWidth","width.min",/image/,this.imageDimensions,function(a,b){return a.width>=b})),p.push(i("dimensions",null,/image/,function(a,b){return f.emptyPromise(b)},function(a){return a})),p.push(i("ratio",null,/image/,this.imageDimensions,function(a,b){for(var c=b.toString().split(","),d=!1,e=0;e<c.length;e++)Math.abs(a.width/a.height-f.ratioToFloat(c[e]))<.01&&(d=!0);return d})),p.push(i("maxRatio","ratio.max",/image/,this.imageDimensions,function(a,b){return a.width/a.height-f.ratioToFloat(b)<1e-4})),p.push(i("minRatio","ratio.min",/image/,this.imageDimensions,function(a,b){return a.width/a.height-f.ratioToFloat(b)>-1e-4})),p.push(i("maxDuration","duration.max",/audio|video/,this.mediaDuration,function(a,b){return a<=f.translateScalars(b)})),p.push(i("minDuration","duration.min",/audio|video/,this.mediaDuration,function(a,b){return a>=f.translateScalars(b)})),p.push(i("duration",null,/audio|video/,function(a,b){return f.emptyPromise(b)},function(a){return a})),p.push(i("validateAsyncFn",null,null,function(a,b){return b},function(a){return a===!0||null===a||""===a})),b.all(p).then(function(){if(l)for(var b=0;b<a.length;b++){var d=a[b];d.$error&&a.splice(b--,1)}l=!1,h("maxFiles",null,function(a,b,d){return b>c+d}),o.resolve({validFiles:a,invalidFiles:m})}),o.promise},f.imageDimensions=function(a){if(a.$ngfWidth&&a.$ngfHeight){var d=b.defer();return c(function(){d.resolve({width:a.$ngfWidth,height:a.$ngfHeight})}),d.promise}if(a.$ngfDimensionPromise)return a.$ngfDimensionPromise;var e=b.defer();return c(function(){return 0!==a.type.indexOf("image")?void e.reject("not image"):void f.dataUrl(a).then(function(b){function d(){var b=h[0].naturalWidth||h[0].clientWidth,c=h[0].naturalHeight||h[0].clientHeight;h.remove(),a.$ngfWidth=b,a.$ngfHeight=c,e.resolve({width:b,height:c})}function f(){h.remove(),e.reject("load error")}function g(){c(function(){h[0].parentNode&&(h[0].clientWidth?d():i++>10?f():g())},1e3)}var h=angular.element("<img>").attr("src",b).css("visibility","hidden").css("position","fixed").css("max-width","none !important").css("max-height","none !important");h.on("load",d),h.on("error",f);var i=0;g(),angular.element(document.getElementsByTagName("body")[0]).append(h)},function(){e.reject("load error")})}),a.$ngfDimensionPromise=e.promise,a.$ngfDimensionPromise["finally"](function(){delete a.$ngfDimensionPromise}),a.$ngfDimensionPromise},f.mediaDuration=function(a){if(a.$ngfDuration){var d=b.defer();return c(function(){d.resolve(a.$ngfDuration)}),d.promise}if(a.$ngfDurationPromise)return a.$ngfDurationPromise;var e=b.defer();return c(function(){return 0!==a.type.indexOf("audio")&&0!==a.type.indexOf("video")?void e.reject("not media"):void f.dataUrl(a).then(function(b){function d(){var b=h[0].duration;a.$ngfDuration=b,h.remove(),e.resolve(b)}function f(){h.remove(),e.reject("load error")}function g(){c(function(){h[0].parentNode&&(h[0].duration?d():i>10?f():g())},1e3)}var h=angular.element(0===a.type.indexOf("audio")?"<audio>":"<video>").attr("src",b).css("visibility","none").css("position","fixed");h.on("loadedmetadata",d),h.on("error",f);var i=0;g(),angular.element(document.body).append(h)},function(){e.reject("load error")})}),a.$ngfDurationPromise=e.promise,a.$ngfDurationPromise["finally"](function(){delete a.$ngfDurationPromise}),a.$ngfDurationPromise},f}]),ngFileUpload.service("UploadResize",["UploadValidate","$q",function(a,b){var c=a,d=function(a,b,c,d,e){var f=e?Math.max(c/a,d/b):Math.min(c/a,d/b);return{width:a*f,height:b*f,marginX:a*f-c,marginY:b*f-d}},e=function(a,e,f,g,h,i,j,k){var l=b.defer(),m=document.createElement("canvas"),n=document.createElement("img");return n.setAttribute("style","visibility:hidden;position:fixed;z-index:-100000"),document.body.appendChild(n),n.onload=function(){var a=n.width,b=n.height;if(n.parentNode.removeChild(n),null!=k&&k(a,b)===!1)return void l.reject("resizeIf");try{if(i){var o=c.ratioToFloat(i),p=a/b;o>p?(e=a,f=e/o):(f=b,e=f*o)}e||(e=a),f||(f=b);var q=d(a,b,e,f,j);m.width=Math.min(q.width,e),m.height=Math.min(q.height,f);var r=m.getContext("2d");r.drawImage(n,Math.min(0,-q.marginX/2),Math.min(0,-q.marginY/2),q.width,q.height),l.resolve(m.toDataURL(h||"image/WebP",g||.934))}catch(s){l.reject(s)}},n.onerror=function(){n.parentNode.removeChild(n),l.reject()},n.src=a,l.promise};return c.dataUrltoBlob=function(a,b,c){for(var d=a.split(","),e=d[0].match(/:(.*?);/)[1],f=atob(d[1]),g=f.length,h=new Uint8Array(g);g--;)h[g]=f.charCodeAt(g);var i=new window.Blob([h],{type:e});return i.name=b,i.$ngfOrigSize=c,i},c.isResizeSupported=function(){var a=document.createElement("canvas");return window.atob&&a.getContext&&a.getContext("2d")&&window.Blob},c.isResizeSupported()&&Object.defineProperty(window.Blob.prototype,"name",{get:function(){return this.$ngfName},set:function(a){this.$ngfName=a},configurable:!0}),c.resize=function(a,d){if(0!==a.type.indexOf("image"))return c.emptyPromise(a);var f=b.defer();return c.dataUrl(a,!0).then(function(b){e(b,d.width,d.height,d.quality,d.type||a.type,d.ratio,d.centerCrop,d.resizeIf).then(function(e){if("image/jpeg"===a.type&&d.restoreExif!==!1)try{e=c.restoreExif(b,e)}catch(g){setTimeout(function(){throw g},1)}try{var h=c.dataUrltoBlob(e,a.name,a.size);f.resolve(h)}catch(g){f.reject(g)}},function(b){"resizeIf"===b&&f.resolve(a),f.reject(b)})},function(a){f.reject(a)}),f.promise},c}]),function(){function a(a,c,d,e,f,g,h,i,j,k){function l(){return c.attr("disabled")||s("ngfDropDisabled",a)}function m(b,c,d){if(b){var e;try{e=b&&b.getData&&b.getData("text/html")}catch(f){}q(b.items,b.files,s("ngfAllowDir",a)!==!1,s("multiple")||s("ngfMultiple",a)).then(function(a){a.length?n(a,c):o(d,e).then(function(a){n(a,c)})})}}function n(b,c){i.updateModel(e,d,a,s("ngfChange")||s("ngfDrop"),b,c)}function o(b,c){if(!i.shouldUpdateOn(b,d,a)||"string"!=typeof c)return i.rejectPromise([]);var e=[];c.replace(/<(img src|img [^>]* src) *=\"([^\"]*)\"/gi,function(a,b,c){e.push(c)});var f=[],g=[];if(e.length){angular.forEach(e,function(a){f.push(i.urlToBlob(a).then(function(a){g.push(a)}))});var h=k.defer();return k.all(f).then(function(){h.resolve(g)},function(a){h.reject(a)}),h.promise}return i.emptyPromise()}function p(a,b,c,d){var e=s("ngfDragOverClass",a,{$event:c}),f="dragover";if(angular.isString(e))f=e;else if(e&&(e.delay&&(w=e.delay),e.accept||e.reject)){var g=c.dataTransfer.items;if(null!=g&&g.length)for(var h=e.pattern||s("ngfPattern",a,{$event:c}),j=g.length;j--;){if(!i.validatePattern(g[j],h)){f=e.reject;break}f=e.accept}else f=e.accept}d(f)}function q(b,c,e,f){function g(a,b){var c=k.defer();if(null!=a)if(a.isDirectory){var d=[i.emptyPromise()];if(m){var e={type:"directory"};e.name=e.path=(b||"")+a.name,n.push(e)}var f=a.createReader(),h=[],p=function(){f.readEntries(function(e){try{e.length?(h=h.concat(Array.prototype.slice.call(e||[],0)),p()):(angular.forEach(h.slice(0),function(c){n.length<=j&&l>=o&&d.push(g(c,(b?b:"")+a.name+"/"))}),k.all(d).then(function(){c.resolve()},function(a){c.reject(a)}))}catch(f){c.reject(f)}},function(a){c.reject(a)})};p()}else a.file(function(a){try{a.path=(b?b:"")+a.name,m&&(a=i.rename(a,a.path)),n.push(a),o+=a.size,c.resolve()}catch(d){c.reject(d)}},function(a){c.reject(a)});return c.promise}var j=i.getValidationAttr(d,a,"maxFiles");null==j&&(j=Number.MAX_VALUE);var l=i.getValidationAttr(d,a,"maxTotalSize");null==l&&(l=Number.MAX_VALUE);var m=s("ngfIncludeDir",a),n=[],o=0,p=[i.emptyPromise()];if(b&&b.length>0&&"file:"!==h.location.protocol)for(var q=0;q<b.length;q++){if(b[q].webkitGetAsEntry&&b[q].webkitGetAsEntry()&&b[q].webkitGetAsEntry().isDirectory){var r=b[q].webkitGetAsEntry();if(r.isDirectory&&!e)continue;null!=r&&p.push(g(r))}else{var t=b[q].getAsFile();null!=t&&(n.push(t),o+=t.size)}if(n.length>j||o>l||!f&&n.length>0)break}else if(null!=c)for(var u=0;u<c.length;u++){var v=c.item(u);if((v.type||v.size>0)&&(n.push(v),o+=v.size),n.length>j||o>l||!f&&n.length>0)break}var w=k.defer();return k.all(p).then(function(){if(f||m||!n.length)w.resolve(n);else{for(var a=0;n[a]&&"directory"===n[a].type;)a++;w.resolve([n[a]])}},function(a){w.reject(a)}),w.promise}var r=b(),s=function(a,b,c){return i.attrGetter(a,d,b,c)};if(s("dropAvailable")&&g(function(){a[s("dropAvailable")]?a[s("dropAvailable")].value=r:a[s("dropAvailable")]=r}),!r)return void(s("ngfHideOnDropNotAvailable",a)===!0&&c.css("display","none"));null==s("ngfSelect")&&i.registerModelChangeValidator(e,d,a);var t,u=null,v=f(s("ngfStopPropagation")),w=1;c[0].addEventListener("dragover",function(b){if(!l()&&i.shouldUpdateOn("drop",d,a)){if(b.preventDefault(),v(a)&&b.stopPropagation(),navigator.userAgent.indexOf("Chrome")>-1){var e=b.dataTransfer.effectAllowed;b.dataTransfer.dropEffect="move"===e||"linkMove"===e?"move":"copy"}g.cancel(u),t||(t="C",p(a,d,b,function(d){t=d,c.addClass(t),s("ngfDrag",a,{$isDragging:!0,$class:t,$event:b})}))}},!1),c[0].addEventListener("dragenter",function(b){!l()&&i.shouldUpdateOn("drop",d,a)&&(b.preventDefault(),v(a)&&b.stopPropagation())},!1),c[0].addEventListener("dragleave",function(b){!l()&&i.shouldUpdateOn("drop",d,a)&&(b.preventDefault(),
v(a)&&b.stopPropagation(),u=g(function(){t&&c.removeClass(t),t=null,s("ngfDrag",a,{$isDragging:!1,$event:b})},w||100))},!1),c[0].addEventListener("drop",function(b){!l()&&i.shouldUpdateOn("drop",d,a)&&(b.preventDefault(),v(a)&&b.stopPropagation(),t&&c.removeClass(t),t=null,m(b.dataTransfer,b,"dropUrl"))},!1),c[0].addEventListener("paste",function(b){navigator.userAgent.toLowerCase().indexOf("firefox")>-1&&s("ngfEnableFirefoxPaste",a)&&b.preventDefault(),!l()&&i.shouldUpdateOn("paste",d,a)&&m(b.clipboardData||b.originalEvent.clipboardData,b,"pasteUrl")},!1),navigator.userAgent.toLowerCase().indexOf("firefox")>-1&&s("ngfEnableFirefoxPaste",a)&&(c.attr("contenteditable",!0),c.on("keypress",function(a){a.metaKey||a.ctrlKey||a.preventDefault()}))}function b(){var a=document.createElement("div");return"draggable"in a&&"ondrop"in a&&!/Edge\/12./i.test(navigator.userAgent)}ngFileUpload.directive("ngfDrop",["$parse","$timeout","$window","Upload","$http","$q",function(b,c,d,e,f,g){return{restrict:"AEC",require:"?ngModel",link:function(h,i,j,k){a(h,i,j,k,b,c,d,e,f,g)}}}]),ngFileUpload.directive("ngfNoFileDrop",function(){return function(a,c){b()&&c.css("display","none")}}),ngFileUpload.directive("ngfDropAvailable",["$parse","$timeout","Upload",function(a,c,d){return function(e,f,g){if(b()){var h=a(d.attrGetter("ngfDropAvailable",g));c(function(){h(e),h.assign&&h.assign(e,!0)})}}}])}(),ngFileUpload.service("UploadExif",["UploadResize","$q",function(a,b){function c(a,b,c,d){switch(b){case 2:return a.transform(-1,0,0,1,c,0);case 3:return a.transform(-1,0,0,-1,c,d);case 4:return a.transform(1,0,0,-1,0,d);case 5:return a.transform(0,1,1,0,0,0);case 6:return a.transform(0,1,-1,0,d,0);case 7:return a.transform(0,-1,-1,0,d,c);case 8:return a.transform(0,-1,1,0,0,c)}}function d(a){for(var b="",c=new Uint8Array(a),d=c.byteLength,e=0;d>e;e++)b+=String.fromCharCode(c[e]);return window.btoa(b)}var e=a;return e.isExifSupported=function(){return window.FileReader&&(new FileReader).readAsArrayBuffer&&e.isResizeSupported()},e.readOrientation=function(a){var c=b.defer(),d=new FileReader,e=a.slice?a.slice(0,65536):a;return d.readAsArrayBuffer(e),d.onerror=function(a){return c.reject(a)},d.onload=function(a){var b={orientation:1},d=new DataView(this.result);if(65496!==d.getUint16(0,!1))return c.resolve(b);for(var e=d.byteLength,f=2;e>f;){var g=d.getUint16(f,!1);if(f+=2,65505===g){if(1165519206!==d.getUint32(f+=2,!1))return c.resolve(b);var h=18761===d.getUint16(f+=6,!1);f+=d.getUint32(f+4,h);var i=d.getUint16(f,h);f+=2;for(var j=0;i>j;j++)if(274===d.getUint16(f+12*j,h)){var k=d.getUint16(f+12*j+8,h);return k>=2&&8>=k&&(d.setUint16(f+12*j+8,1,h),b.fixedArrayBuffer=a.target.result),b.orientation=k,c.resolve(b)}}else{if(65280!==(65280&g))break;f+=d.getUint16(f,!1)}}return c.resolve(b)},c.promise},e.applyExifRotation=function(a){if(0!==a.type.indexOf("image/jpeg"))return e.emptyPromise(a);var f=b.defer();return e.readOrientation(a).then(function(b){return b.orientation<2||b.orientation>8?f.resolve(a):void e.dataUrl(a,!0).then(function(g){var h=document.createElement("canvas"),i=document.createElement("img");i.onload=function(){try{h.width=b.orientation>4?i.height:i.width,h.height=b.orientation>4?i.width:i.height;var g=h.getContext("2d");c(g,b.orientation,i.width,i.height),g.drawImage(i,0,0);var j=h.toDataURL(a.type||"image/WebP",.934);j=e.restoreExif(d(b.fixedArrayBuffer),j);var k=e.dataUrltoBlob(j,a.name);f.resolve(k)}catch(l){return f.reject(l)}},i.onerror=function(){f.reject()},i.src=g},function(a){f.reject(a)})},function(a){f.reject(a)}),f.promise},e.restoreExif=function(a,b){var c={};return c.KEY_STR="ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789+/=",c.encode64=function(a){var b,c,d,e,f,g="",h="",i="",j=0;do b=a[j++],c=a[j++],h=a[j++],d=b>>2,e=(3&b)<<4|c>>4,f=(15&c)<<2|h>>6,i=63&h,isNaN(c)?f=i=64:isNaN(h)&&(i=64),g=g+this.KEY_STR.charAt(d)+this.KEY_STR.charAt(e)+this.KEY_STR.charAt(f)+this.KEY_STR.charAt(i),b=c=h="",d=e=f=i="";while(j<a.length);return g},c.restore=function(a,b){a.match("data:image/jpeg;base64,")&&(a=a.replace("data:image/jpeg;base64,",""));var c=this.decode64(a),d=this.slice2Segments(c),e=this.exifManipulation(b,d);return"data:image/jpeg;base64,"+this.encode64(e)},c.exifManipulation=function(a,b){var c=this.getExifArray(b),d=this.insertExif(a,c);return new Uint8Array(d)},c.getExifArray=function(a){for(var b,c=0;c<a.length;c++)if(b=a[c],255===b[0]&225===b[1])return b;return[]},c.insertExif=function(a,b){var c=a.replace("data:image/jpeg;base64,",""),d=this.decode64(c),e=d.indexOf(255,3),f=d.slice(0,e),g=d.slice(e),h=f;return h=h.concat(b),h=h.concat(g)},c.slice2Segments=function(a){for(var b=0,c=[];;){if(255===a[b]&218===a[b+1])break;if(255===a[b]&216===a[b+1])b+=2;else{var d=256*a[b+2]+a[b+3],e=b+d+2,f=a.slice(b,e);c.push(f),b=e}if(b>a.length)break}return c},c.decode64=function(a){var b,c,d,e,f,g="",h="",i=0,j=[],k=/[^A-Za-z0-9\+\/\=]/g;k.exec(a)&&console.log("There were invalid base64 characters in the input text.\nValid base64 characters are A-Z, a-z, 0-9, NaNExpect errors in decoding."),a=a.replace(/[^A-Za-z0-9\+\/\=]/g,"");do d=this.KEY_STR.indexOf(a.charAt(i++)),e=this.KEY_STR.indexOf(a.charAt(i++)),f=this.KEY_STR.indexOf(a.charAt(i++)),h=this.KEY_STR.indexOf(a.charAt(i++)),b=d<<2|e>>4,c=(15&e)<<4|f>>2,g=(3&f)<<6|h,j.push(b),64!==f&&j.push(c),64!==h&&j.push(g),b=c=g="",d=e=f=h="";while(i<a.length);return j},c.restore(a,b)},e}]);