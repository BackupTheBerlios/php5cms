document.getElementsByClassName=function(_1,_2){
var _3=($(_2)||document.body).getElementsByTagName("*");
return $A(_3).inject([],function(_4,_5){
if(_5.className.match(new RegExp("(^|\\s)"+_1+"(\\s|$)"))){
_4.push(_5);
}
return _4;
});
};
if(!window.Element){
var Element=new Object();
}
Object.extend(Element,{visible:function(_6){
return $(_6).style.display!="none";
},toggle:function(){
for(var i=0;i<arguments.length;i++){
var _8=$(arguments[i]);
Element[Element.visible(_8)?"hide":"show"](_8);
}
},hide:function(){
for(var i=0;i<arguments.length;i++){
var _9=$(arguments[i]);
_9.style.display="none";
}
},show:function(){
for(var i=0;i<arguments.length;i++){
var _10=$(arguments[i]);
_10.style.display="";
}
},remove:function(_11){
_11=$(_11);
_11.parentNode.removeChild(_11);
},update:function(_12,_13){
$(_12).innerHTML=_13.stripScripts();
setTimeout(function(){
_13.evalScripts();
},10);
},getHeight:function(_14){
_14=$(_14);
return _14.offsetHeight;
},classNames:function(_15){
return new Element.ClassNames(_15);
},hasClassName:function(_16,_17){
if(!(_16=$(_16))){
return;
}
return Element.classNames(_16).include(_17);
},addClassName:function(_18,_19){
if(!(_18=$(_18))){
return;
}
return Element.classNames(_18).add(_19);
},removeClassName:function(_20,_21){
if(!(_20=$(_20))){
return;
}
return Element.classNames(_20).remove(_21);
},cleanWhitespace:function(_22){
_22=$(_22);
for(var i=0;i<_22.childNodes.length;i++){
var _23=_22.childNodes[i];
if(_23.nodeType==3&&!/\S/.test(_23.nodeValue)){
Element.remove(_23);
}
}
},empty:function(_24){
return $(_24).innerHTML.match(/^\s*$/);
},scrollTo:function(_25){
_25=$(_25);
var x=_25.x?_25.x:_25.offsetLeft,y=_25.y?_25.y:_25.offsetTop;
window.scrollTo(x,y);
},getStyle:function(_27,_28){
_27=$(_27);
var _29=_27.style[_28.camelize()];
if(!_29){
if(document.defaultView&&document.defaultView.getComputedStyle){
var css=document.defaultView.getComputedStyle(_27,null);
_29=css?css.getPropertyValue(_28):null;
}else{
if(_27.currentStyle){
_29=_27.currentStyle[_28.camelize()];
}
}
}
if(window.opera&&["left","top","right","bottom"].include(_28)){
if(Element.getStyle(_27,"position")=="static"){
_29="auto";
}
}
return _29=="auto"?null:_29;
},setStyle:function(_31,_32){
_31=$(_31);
for(name in _32){
_31.style[name.camelize()]=_32[name];
}
},getDimensions:function(_33){
_33=$(_33);
if(Element.getStyle(_33,"display")!="none"){
return {width:_33.offsetWidth,height:_33.offsetHeight};
}
var els=_33.style;
var _35=els.visibility;
var _36=els.position;
els.visibility="hidden";
els.position="absolute";
els.display="";
var _37=_33.clientWidth;
var _38=_33.clientHeight;
els.display="none";
els.position=_36;
els.visibility=_35;
return {width:_37,height:_38};
},makePositioned:function(_39){
_39=$(_39);
var pos=Element.getStyle(_39,"position");
if(pos=="static"||!pos){
_39._madePositioned=true;
_39.style.position="relative";
if(window.opera){
_39.style.top=0;
_39.style.left=0;
}
}
},undoPositioned:function(_41){
_41=$(_41);
if(_41._madePositioned){
_41._madePositioned=undefined;
_41.style.position=_41.style.top=_41.style.left=_41.style.bottom=_41.style.right="";
}
},makeClipping:function(_42){
_42=$(_42);
if(_42._overflow){
return;
}
_42._overflow=_42.style.overflow;
if((Element.getStyle(_42,"overflow")||"visible")!="hidden"){
_42.style.overflow="hidden";
}
},undoClipping:function(_43){
_43=$(_43);
if(_43._overflow){
return;
}
_43.style.overflow=_43._overflow;
_43._overflow=undefined;
}});
var Toggle=new Object();
Toggle.display=Element.toggle;
Abstract.Insertion=function(_44){
this.adjacency=_44;
};
Abstract.Insertion.prototype={initialize:function(_45,_46){
this.element=$(_45);
this.content=_46.stripScripts();
if(this.adjacency&&this.element.insertAdjacentHTML){
try{
this.element.insertAdjacentHTML(this.adjacency,this.content);
}
catch(e){
if(this.element.tagName.toLowerCase()=="tbody"){
this.insertContent(this.contentFromAnonymousTable());
}else{
throw e;
}
}
}else{
this.range=this.element.ownerDocument.createRange();
if(this.initializeRange){
this.initializeRange();
}
this.insertContent([this.range.createContextualFragment(this.content)]);
}
setTimeout(function(){
_46.evalScripts();
},10);
},contentFromAnonymousTable:function(){
var div=document.createElement("div");
div.innerHTML="<table><tbody>"+this.content+"</tbody></table>";
return $A(div.childNodes[0].childNodes[0].childNodes);
}};
var Insertion=new Object();
Insertion.Before=Class.create();
Insertion.Before.prototype=Object.extend(new Abstract.Insertion("beforeBegin"),{initializeRange:function(){
this.range.setStartBefore(this.element);
},insertContent:function(_48){
_48.each((function(_49){
this.element.parentNode.insertBefore(_49,this.element);
}).bind(this));
}});
Insertion.Top=Class.create();
Insertion.Top.prototype=Object.extend(new Abstract.Insertion("afterBegin"),{initializeRange:function(){
this.range.selectNodeContents(this.element);
this.range.collapse(true);
},insertContent:function(_50){
_50.reverse(false).each((function(_51){
this.element.insertBefore(_51,this.element.firstChild);
}).bind(this));
}});
Insertion.Bottom=Class.create();
Insertion.Bottom.prototype=Object.extend(new Abstract.Insertion("beforeEnd"),{initializeRange:function(){
this.range.selectNodeContents(this.element);
this.range.collapse(this.element);
},insertContent:function(_52){
_52.each((function(_53){
this.element.appendChild(_53);
}).bind(this));
}});
Insertion.After=Class.create();
Insertion.After.prototype=Object.extend(new Abstract.Insertion("afterEnd"),{initializeRange:function(){
this.range.setStartAfter(this.element);
},insertContent:function(_54){
_54.each((function(_55){
this.element.parentNode.insertBefore(_55,this.element.nextSibling);
}).bind(this));
}});
Element.ClassNames=Class.create();
Element.ClassNames.prototype={initialize:function(_56){
this.element=$(_56);
},_each:function(_57){
this.element.className.split(/\s+/).select(function(_58){
return _58.length>0;
})._each(_57);
},set:function(_59){
this.element.className=_59;
},add:function(_60){
if(this.include(_60)){
return;
}
this.set(this.toArray().concat(_60).join(" "));
},remove:function(_61){
if(!this.include(_61)){
return;
}
this.set(this.select(function(_62){
return _62!=_61;
}).join(" "));
},toString:function(){
return this.toArray().join(" ");
}};
Object.extend(Element.ClassNames.prototype,Enumerable);

Object.extend(Element,{condClassName:function(_1,_2,_3){
(_3?Element.addClassName:Element.removeClassName)(_1,_2);
}});

var Field={clear:function(){
for(var i=0;i<arguments.length;i++){
$(arguments[i]).value="";
}
},focus:function(_2){
$(_2).focus();
},present:function(){
for(var i=0;i<arguments.length;i++){
if($(arguments[i]).value==""){
return false;
}
}
return true;
},select:function(_3){
$(_3).select();
},activate:function(_4){
_4=$(_4);
_4.focus();
if(_4.select){
_4.select();
}
}};
var Form={serialize:function(_5){
var _6=Form.getElements($(_5));
var _7=new Array();
for(var i=0;i<_6.length;i++){
var _8=Form.Element.serialize(_6[i]);
if(_8){
_7.push(_8);
}
}
return _7.join("&");
},getElements:function(_9){
_9=$(_9);
var _10=new Array();
for(tagName in Form.Element.Serializers){
var _11=_9.getElementsByTagName(tagName);
for(var j=0;j<_11.length;j++){
_10.push(_11[j]);
}
}
return _10;
},getInputs:function(_13,_14,_15){
_13=$(_13);
var _16=_13.getElementsByTagName("input");
if(!_14&&!_15){
return _16;
}
var _17=new Array();
for(var i=0;i<_16.length;i++){
var _18=_16[i];
if((_14&&_18.type!=_14)||(_15&&_18.name!=_15)){
continue;
}
_17.push(_18);
}
return _17;
},disable:function(_19){
var _20=Form.getElements(_19);
for(var i=0;i<_20.length;i++){
var _21=_20[i];
_21.blur();
_21.disabled="true";
}
},enable:function(_22){
var _23=Form.getElements(_22);
for(var i=0;i<_23.length;i++){
var _24=_23[i];
_24.disabled="";
}
},findFirstElement:function(_25){
return Form.getElements(_25).find(function(_26){
return _26.type!="hidden"&&!_26.disabled&&["input","select","textarea"].include(_26.tagName.toLowerCase());
});
},focusFirstElement:function(_27){
Field.activate(Form.findFirstElement(_27));
},reset:function(_28){
$(_28).reset();
}};
Form.Element={serialize:function(_29){
_29=$(_29);
var _30=_29.tagName.toLowerCase();
var _31=Form.Element.Serializers[_30](_29);
if(_31){
var key=encodeURIComponent(_31[0]);
if(key.length==0){
return;
}
if(_31[1].constructor!=Array){
_31[1]=[_31[1]];
}
return _31[1].map(function(_33){
return key+"="+encodeURIComponent(_33);
}).join("&");
}
},getValue:function(_34){
_34=$(_34);
var _35=_34.tagName.toLowerCase();
var _36=Form.Element.Serializers[_35](_34);
if(_36){
return _36[1];
}
}};
Form.Element.Serializers={input:function(_37){
switch(_37.type.toLowerCase()){
case "submit":
case "hidden":
case "password":
case "text":
return Form.Element.Serializers.textarea(_37);
case "checkbox":
case "radio":
return Form.Element.Serializers.inputSelector(_37);
}
return false;
},inputSelector:function(_38){
if(_38.checked){
return [_38.name,_38.value];
}
},textarea:function(_39){
return [_39.name,_39.value];
},select:function(_40){
return Form.Element.Serializers[_40.type=="select-one"?"selectOne":"selectMany"](_40);
},selectOne:function(_41){
var _42="",opt,index=_41.selectedIndex;
if(index>=0){
opt=_41.options[index];
_42=opt.value;
if(!_42&&!("value" in opt)){
_42=opt.text;
}
}
return [_41.name,_42];
},selectMany:function(_43){
var _44=new Array();
for(var i=0;i<_43.length;i++){
var opt=_43.options[i];
if(opt.selected){
var _46=opt.value;
if(!_46&&!("value" in opt)){
_46=opt.text;
}
_44.push(_46);
}
}
return [_43.name,_44];
}};
var $F=Form.Element.getValue;
Abstract.TimedObserver=function(){
};
Abstract.TimedObserver.prototype={initialize:function(_47,_48,_49){
this.frequency=_48;
this.element=$(_47);
this.callback=_49;
this.lastValue=this.getValue();
this.registerCallback();
},registerCallback:function(){
setInterval(this.onTimerEvent.bind(this),this.frequency*1000);
},onTimerEvent:function(){
var _50=this.getValue();
if(this.lastValue!=_50){
this.callback(this.element,_50);
this.lastValue=_50;
}
}};
Form.Element.Observer=Class.create();
Form.Element.Observer.prototype=Object.extend(new Abstract.TimedObserver(),{getValue:function(){
return Form.Element.getValue(this.element);
}});
Form.Observer=Class.create();
Form.Observer.prototype=Object.extend(new Abstract.TimedObserver(),{getValue:function(){
return Form.serialize(this.element);
}});
Abstract.EventObserver=function(){
};
Abstract.EventObserver.prototype={initialize:function(_51,_52){
this.element=$(_51);
this.callback=_52;
this.lastValue=this.getValue();
if(this.element.tagName.toLowerCase()=="form"){
this.registerFormCallbacks();
}else{
this.registerCallback(this.element);
}
},onElementEvent:function(){
var _53=this.getValue();
if(this.lastValue!=_53){
this.callback(this.element,_53);
this.lastValue=_53;
}
},registerFormCallbacks:function(){
var _54=Form.getElements(this.element);
for(var i=0;i<_54.length;i++){
this.registerCallback(_54[i]);
}
},registerCallback:function(_55){
if(_55.type){
switch(_55.type.toLowerCase()){
case "checkbox":
case "radio":
Event.observe(_55,"click",this.onElementEvent.bind(this));
break;
case "password":
case "text":
case "textarea":
case "select-one":
case "select-multiple":
Event.observe(_55,"change",this.onElementEvent.bind(this));
break;
}
}
}};
Form.Element.EventObserver=Class.create();
Form.Element.EventObserver.prototype=Object.extend(new Abstract.EventObserver(),{getValue:function(){
return Form.Element.getValue(this.element);
}});
Form.EventObserver=Class.create();
Form.EventObserver.prototype=Object.extend(new Abstract.EventObserver(),{getValue:function(){
return Form.serialize(this.element);
}});

if(!window.Event){
var Event=new Object();
}
Object.extend(Event,{KEY_BACKSPACE:8,KEY_TAB:9,KEY_RETURN:13,KEY_ESC:27,KEY_LEFT:37,KEY_UP:38,KEY_RIGHT:39,KEY_DOWN:40,KEY_DELETE:46,element:function(_1){
return _1.target||_1.srcElement;
},isLeftClick:function(_2){
return (((_2.which)&&(_2.which==1))||((_2.button)&&(_2.button==1)));
},pointerX:function(_3){
return _3.pageX||(_3.clientX+(document.documentElement.scrollLeft||document.body.scrollLeft));
},pointerY:function(_4){
return _4.pageY||(_4.clientY+(document.documentElement.scrollTop||document.body.scrollTop));
},stop:function(_5){
if(_5.preventDefault){
_5.preventDefault();
_5.stopPropagation();
}else{
_5.returnValue=false;
_5.cancelBubble=true;
}
},findElement:function(_6,_7){
var _8=Event.element(_6);
while(_8.parentNode&&(!_8.tagName||(_8.tagName.toUpperCase()!=_7.toUpperCase()))){
_8=_8.parentNode;
}
return _8;
},observers:false,_observeAndCache:function(_9,_10,_11,_12){
if(!this.observers){
this.observers=[];
}
if(_9.addEventListener){
this.observers.push([_9,_10,_11,_12]);
_9.addEventListener(_10,_11,_12);
}else{
if(_9.attachEvent){
this.observers.push([_9,_10,_11,_12]);
_9.attachEvent("on"+_10,_11);
}
}
},unloadCache:function(){
if(!Event.observers){
return;
}
for(var i=0;i<Event.observers.length;i++){
Event.stopObserving.apply(this,Event.observers[i]);
Event.observers[i][0]=null;
}
Event.observers=false;
},observe:function(_14,_15,_16,_17){
var _14=$(_14);
_17=_17||false;
if(_15=="keypress"&&(navigator.appVersion.match(/Konqueror|Safari|KHTML/)||_14.attachEvent)){
_15="keydown";
}
this._observeAndCache(_14,_15,_16,_17);
},stopObserving:function(_18,_19,_20,_21){
var _18=$(_18);
_21=_21||false;
if(_19=="keypress"&&(navigator.appVersion.match(/Konqueror|Safari|KHTML/)||_18.detachEvent)){
_19="keydown";
}
if(_18.removeEventListener){
_18.removeEventListener(_19,_20,_21);
}else{
if(_18.detachEvent){
_18.detachEvent("on"+_19,_20);
}
}
}});
Event.observe(window,"unload",Event.unloadCache,false);

Object.extend(Event,{OnLoad:function(fn){
var w=document.addEventListener&&!window.addEventListener?document:window;
Event.__observe(w,"load",fn);
},observe:function(_3,_4,_5,_6){
if(!isList(_3)){
return this.__observe(_3,_4,_5,_6);
}
for(var i=0;i<_3.length;i++){
this.__observe(_3[i],_4,_5,_6);
}
},__observe:function(_8,_9,_10,_11){
var _8=$(_8);
_11=_11||false;
if(_9=="keypress"&&((navigator.appVersion.indexOf("AppleWebKit")>0)||_8.attachEvent)){
_9="keydown";
}
this._observeAndCache(_8,_9,_10,_11);
}});

var Position={includeScrollOffsets:false,prepare:function(){
this.deltaX=window.pageXOffset||document.documentElement.scrollLeft||document.body.scrollLeft||0;
this.deltaY=window.pageYOffset||document.documentElement.scrollTop||document.body.scrollTop||0;
},realOffset:function(_1){
var _2=0,valueL=0;
do{
_2+=_1.scrollTop||0;
valueL+=_1.scrollLeft||0;
_1=_1.parentNode;
}while(_1);
return [valueL,_2];
},cumulativeOffset:function(_3){
var _4=0,valueL=0;
do{
_4+=_3.offsetTop||0;
valueL+=_3.offsetLeft||0;
_3=_3.offsetParent;
}while(_3);
return [valueL,_4];
},positionedOffset:function(_5){
var _6=0,valueL=0;
do{
_6+=_5.offsetTop||0;
valueL+=_5.offsetLeft||0;
_5=_5.offsetParent;
if(_5){
p=Element.getStyle(_5,"position");
if(p=="relative"||p=="absolute"){
break;
}
}
}while(_5);
return [valueL,_6];
},offsetParent:function(_7){
if(_7.offsetParent){
return _7.offsetParent;
}
if(_7==document.body){
return _7;
}
while((_7=_7.parentNode)&&_7!=document.body){
if(Element.getStyle(_7,"position")!="static"){
return _7;
}
}
return document.body;
},within:function(_8,x,y){
if(this.includeScrollOffsets){
return this.withinIncludingScrolloffsets(_8,x,y);
}
this.xcomp=x;
this.ycomp=y;
this.offset=this.cumulativeOffset(_8);
return (y>=this.offset[1]&&y<this.offset[1]+_8.offsetHeight&&x>=this.offset[0]&&x<this.offset[0]+_8.offsetWidth);
},withinIncludingScrolloffsets:function(_11,x,y){
var _12=this.realOffset(_11);
this.xcomp=x+_12[0]-this.deltaX;
this.ycomp=y+_12[1]-this.deltaY;
this.offset=this.cumulativeOffset(_11);
return (this.ycomp>=this.offset[1]&&this.ycomp<this.offset[1]+_11.offsetHeight&&this.xcomp>=this.offset[0]&&this.xcomp<this.offset[0]+_11.offsetWidth);
},overlap:function(_13,_14){
if(!_13){
return 0;
}
if(_13=="vertical"){
return ((this.offset[1]+_14.offsetHeight)-this.ycomp)/_14.offsetHeight;
}
if(_13=="horizontal"){
return ((this.offset[0]+_14.offsetWidth)-this.xcomp)/_14.offsetWidth;
}
},clone:function(_15,_16){
_15=$(_15);
_16=$(_16);
_16.style.position="absolute";
var _17=this.cumulativeOffset(_15);
_16.style.top=_17[1]+"px";
_16.style.left=_17[0]+"px";
_16.style.width=_15.offsetWidth+"px";
_16.style.height=_15.offsetHeight+"px";
},page:function(_18){
var _19=0,valueL=0;
var _20=_18;
do{
_19+=_20.offsetTop||0;
valueL+=_20.offsetLeft||0;
if(_20.offsetParent==document.body){
if(Element.getStyle(_20,"position")=="absolute"){
break;
}
}
}while(_20=_20.offsetParent);
_20=_18;
do{
_19-=_20.scrollTop||0;
valueL-=_20.scrollLeft||0;
}while(_20=_20.parentNode);
return [valueL,_19];
},clone:function(_21,_22){
var _23=Object.extend({setLeft:true,setTop:true,setWidth:true,setHeight:true,offsetTop:0,offsetLeft:0},arguments[2]||{});
_21=$(_21);
var p=Position.page(_21);
_22=$(_22);
var _25=[0,0];
var _26=null;
if(Element.getStyle(_22,"position")=="absolute"){
_26=Position.offsetParent(_22);
_25=Position.page(_26);
}
if(_26==document.body){
_25[0]-=document.body.offsetLeft;
_25[1]-=document.body.offsetTop;
}
if(_23.setLeft){
_22.style.left=(p[0]-_25[0]+_23.offsetLeft)+"px";
}
if(_23.setTop){
_22.style.top=(p[1]-_25[1]+_23.offsetTop)+"px";
}
if(_23.setWidth){
_22.style.width=_21.offsetWidth+"px";
}
if(_23.setHeight){
_22.style.height=_21.offsetHeight+"px";
}
},absolutize:function(_27){
_27=$(_27);
if(_27.style.position=="absolute"){
return;
}
Position.prepare();
var _28=Position.positionedOffset(_27);
var top=_28[1];
var _30=_28[0];
var _31=_27.clientWidth;
var _32=_27.clientHeight;
_27._originalLeft=_30-parseFloat(_27.style.left||0);
_27._originalTop=top-parseFloat(_27.style.top||0);
_27._originalWidth=_27.style.width;
_27._originalHeight=_27.style.height;
_27.style.position="absolute";
_27.style.top=top+"px";
_27.style.left=_30+"px";
_27.style.width=_31+"px";
_27.style.height=_32+"px";
},relativize:function(_33){
_33=$(_33);
if(_33.style.position=="relative"){
return;
}
Position.prepare();
_33.style.position="relative";
var top=parseFloat(_33.style.top||0)-(_33._originalTop||0);
var _34=parseFloat(_33.style.left||0)-(_33._originalLeft||0);
_33.style.top=top+"px";
_33.style.left=_34+"px";
_33.style.height=_33._originalHeight;
_33.style.width=_33._originalWidth;
}};
if(/Konqueror|Safari|KHTML/.test(navigator.userAgent)){
Position.cumulativeOffset=function(_35){
var _36=0,valueL=0;
do{
_36+=_35.offsetTop||0;
valueL+=_35.offsetLeft||0;
if(_35.offsetParent==document.body){
if(Element.getStyle(_35,"position")=="absolute"){
break;
}
}
_35=_35.offsetParent;
}while(_35);
return [valueL,_36];
};
}

function getAllChildren(e){
return e.all?e.all:e.getElementsByTagName("*");
}
document.getElementsBySelector=function(_2){
if(!document.getElementsByTagName){
return new Array();
}
var _3=_2.split(" ");
var _4=new Array(document);
for(var i=0;i<_3.length;i++){
token=_3[i].replace(/^\s+/,"").replace(/\s+$/,"");
if(token.indexOf("#")>-1){
var _6=token.split("#");
var _7=_6[0];
var id=_6[1];
var _9=document.getElementById(id);
if(_7&&_9.nodeName.toLowerCase()!=_7){
return new Array();
}
_4=new Array(_9);
continue;
}
if(token.indexOf(".")>-1){
var _6=token.split(".");
var _7=_6[0];
var _10=_6[1];
if(!_7){
_7="*";
}
var _11=new Array;
var _12=0;
for(var h=0;h<_4.length;h++){
var _14;
if(_7=="*"){
_14=getAllChildren(_4[h]);
}else{
_14=_4[h].getElementsByTagName(_7);
}
for(var j=0;j<_14.length;j++){
_11[_12++]=_14[j];
}
}
_4=new Array;
var _16=0;
for(var k=0;k<_11.length;k++){
if(_11[k].className&&_11[k].className.match(new RegExp("\\b"+_10+"\\b"))){
_4[_16++]=_11[k];
}
}
continue;
}
if(token.match(/^(\w*)\[(\w+)([=~\|\^\$\*]?)=?"?([^\]"]*)"?\]$/)){
var _7=RegExp.$1;
var _18=RegExp.$2;
var _19=RegExp.$3;
var _20=RegExp.$4;
if(!_7){
_7="*";
}
var _11=new Array;
var _12=0;
for(var h=0;h<_4.length;h++){
var _14;
if(_7=="*"){
_14=getAllChildren(_4[h]);
}else{
_14=_4[h].getElementsByTagName(_7);
}
for(var j=0;j<_14.length;j++){
_11[_12++]=_14[j];
}
}
_4=new Array;
var _16=0;
var _21;
switch(_19){
case "=":
_21=function(e){
return (e.getAttribute(_18)==_20);
};
break;
case "~":
_21=function(e){
return (e.getAttribute(_18).match(new RegExp("\\b"+_20+"\\b")));
};
break;
case "|":
_21=function(e){
return (e.getAttribute(_18).match(new RegExp("^"+_20+"-?")));
};
break;
case "^":
_21=function(e){
return (e.getAttribute(_18).indexOf(_20)==0);
};
break;
case "$":
_21=function(e){
return (e.getAttribute(_18).lastIndexOf(_20)==e.getAttribute(_18).length-_20.length);
};
break;
case "*":
_21=function(e){
return (e.getAttribute(_18).indexOf(_20)>-1);
};
break;
default:
_21=function(e){
return e.getAttribute(_18);
};
}
_4=new Array;
var _16=0;
for(var k=0;k<_11.length;k++){
if(_21(_11[k])){
_4[_16++]=_11[k];
}
}
continue;
}
_7=token;
var _11=new Array;
var _12=0;
for(var h=0;h<_4.length;h++){
var _14=_4[h].getElementsByTagName(_7);
for(var j=0;j<_14.length;j++){
_11[_12++]=_14[j];
}
}
_4=_11;
}
return _4;
};

var Behaviour={list:new Array,register:function(_1){
Behaviour.list.push(_1);
},start:function(){
Behaviour.addLoadEvent(function(){
Behaviour.apply();
});
},apply:function(){
for(h=0;sheet=Behaviour.list[h];h++){
for(selector in sheet){
list=document.getElementsBySelector(selector);
if(!list){
continue;
}
for(i=0;element=list[i];i++){
sheet[selector](element);
}
}
}
},addLoadEvent:function(_2){
var _3=window.onload;
if(typeof window.onload!="function"){
window.onload=_2;
}else{
window.onload=function(){
_3();
_2();
};
}
}};
Behaviour.start();

