if(!Control){
var Control={};
}
Control.Slider=Class.create();
Control.Slider.prototype={initialize:function(_1,_2,_3){
var _4=this;
if(_1 instanceof Array){
this.handles=_1.collect(function(e){
return $(e);
});
}else{
this.handles=[$(_1)];
}
this.track=$(_2);
this.options=_3||{};
this.axis=this.options.axis||"horizontal";
this.increment=this.options.increment||1;
this.step=parseInt(this.options.step||"1");
this.range=this.options.range||$R(0,1);
this.value=0;
this.values=this.handles.map(function(){
return 0;
});
this.spans=this.options.spans?this.options.spans.map(function(s){
return $(s);
}):false;
this.options.startSpan=$(this.options.startSpan||null);
this.options.endSpan=$(this.options.endSpan||null);
this.restricted=this.options.restricted||false;
this.maximum=this.options.maximum||this.range.end;
this.minimum=this.options.minimum||this.range.start;
this.alignX=parseInt(this.options.alignX||"0");
this.alignY=parseInt(this.options.alignY||"0");
this.trackLength=this.maximumOffset()-this.minimumOffset();
this.handleLength=this.isVertical()?this.handles[0].offsetHeight:this.handles[0].offsetWidth;
this.active=false;
this.dragging=false;
this.disabled=false;
if(this.options.disabled){
this.setDisabled();
}
this.allowedValues=this.options.values?this.options.values.sortBy(Prototype.K):false;
if(this.allowedValues){
this.minimum=this.allowedValues.min();
this.maximum=this.allowedValues.max();
}
this.eventMouseDown=this.startDrag.bindAsEventListener(this);
this.eventMouseUp=this.endDrag.bindAsEventListener(this);
this.eventMouseMove=this.update.bindAsEventListener(this);
this.handles.each(function(h,i){
i=_4.handles.length-1-i;
_4.setValue(parseFloat((_4.options.sliderValue instanceof Array?_4.options.sliderValue[i]:_4.options.sliderValue)||_4.range.start),i);
Element.makePositioned(h);
Event.observe(h,"mousedown",_4.eventMouseDown);
});
Event.observe(this.track,"mousedown",this.eventMouseDown);
Event.observe(document,"mouseup",this.eventMouseUp);
Event.observe(document,"mousemove",this.eventMouseMove);
this.initialized=true;
},dispose:function(){
var _9=this;
Event.stopObserving(this.track,"mousedown",this.eventMouseDown);
Event.stopObserving(document,"mouseup",this.eventMouseUp);
Event.stopObserving(document,"mousemove",this.eventMouseMove);
this.handles.each(function(h){
Event.stopObserving(h,"mousedown",_9.eventMouseDown);
});
},setDisabled:function(){
this.disabled=true;
},setEnabled:function(){
this.disabled=false;
},getNearestValue:function(_10){
if(this.allowedValues){
if(_10>=this.allowedValues.max()){
return (this.allowedValues.max());
}
if(_10<=this.allowedValues.min()){
return (this.allowedValues.min());
}
var _11=Math.abs(this.allowedValues[0]-_10);
var _12=this.allowedValues[0];
this.allowedValues.each(function(v){
var _14=Math.abs(v-_10);
if(_14<=_11){
_12=v;
_11=_14;
}
});
return _12;
}
if(_10>this.range.end){
return this.range.end;
}
if(_10<this.range.start){
return this.range.start;
}
return _10;
},setValue:function(_15,_16){
if(!this.active){
this.activeHandle=this.handles[_16];
this.activeHandleIdx=_16;
this.updateStyles();
}
_16=_16||this.activeHandleIdx||0;
if(this.initialized&&this.restricted){
if((_16>0)&&(_15<this.values[_16-1])){
_15=this.values[_16-1];
}
if((_16<(this.handles.length-1))&&(_15>this.values[_16+1])){
_15=this.values[_16+1];
}
}
_15=this.getNearestValue(_15);
this.values[_16]=_15;
this.value=this.values[0];
this.handles[_16].style[this.isVertical()?"top":"left"]=this.translateToPx(_15);
this.drawSpans();
if(!this.dragging||!this.event){
this.updateFinished();
}
},setValueBy:function(_17,_18){
this.setValue(this.values[_18||this.activeHandleIdx||0]+_17,_18||this.activeHandleIdx||0);
},translateToPx:function(_19){
return Math.round(((this.trackLength-this.handleLength)/(this.range.end-this.range.start))*(_19-this.range.start))+"px";
},translateToValue:function(_20){
return ((_20/(this.trackLength-this.handleLength)*(this.range.end-this.range.start))+this.range.start);
},getRange:function(_21){
var v=this.values.sortBy(Prototype.K);
_21=_21||0;
return $R(v[_21],v[_21+1]);
},minimumOffset:function(){
return (this.isVertical()?this.alignY:this.alignX);
},maximumOffset:function(){
return (this.isVertical()?this.track.offsetHeight-this.alignY:this.track.offsetWidth-this.alignX);
},isVertical:function(){
return (this.axis=="vertical");
},drawSpans:function(){
var _22=this;
if(this.spans){
$R(0,this.spans.length-1).each(function(r){
_22.setSpan(_22.spans[r],_22.getRange(r));
});
}
if(this.options.startSpan){
this.setSpan(this.options.startSpan,$R(0,this.values.length>1?this.getRange(0).min():this.value));
}
if(this.options.endSpan){
this.setSpan(this.options.endSpan,$R(this.values.length>1?this.getRange(this.spans.length-1).max():this.value,this.maximum));
}
},setSpan:function(_24,_25){
if(this.isVertical()){
_24.style.top=this.translateToPx(_25.start);
_24.style.height=this.translateToPx(_25.end-_25.start);
}else{
_24.style.left=this.translateToPx(_25.start);
_24.style.width=this.translateToPx(_25.end-_25.start);
}
},updateStyles:function(){
this.handles.each(function(h){
Element.removeClassName(h,"selected");
});
Element.addClassName(this.activeHandle,"selected");
},startDrag:function(_26){
if(Event.isLeftClick(_26)){
if(!this.disabled){
this.active=true;
var _27=Event.element(_26);
var _28=[Event.pointerX(_26),Event.pointerY(_26)];
if(_27==this.track){
var _29=Position.cumulativeOffset(this.track);
this.event=_26;
this.setValue(this.translateToValue((this.isVertical()?_28[1]-_29[1]:_28[0]-_29[0])-(this.handleLength/2)));
var _29=Position.cumulativeOffset(this.activeHandle);
this.offsetX=(_28[0]-_29[0]);
this.offsetY=(_28[1]-_29[1]);
}else{
while((this.handles.indexOf(_27)==-1)&&_27.parentNode){
_27=_27.parentNode;
}
this.activeHandle=_27;
this.activeHandleIdx=this.handles.indexOf(this.activeHandle);
this.updateStyles();
var _29=Position.cumulativeOffset(this.activeHandle);
this.offsetX=(_28[0]-_29[0]);
this.offsetY=(_28[1]-_29[1]);
}
}
Event.stop(_26);
}
},update:function(_30){
if(this.active){
if(!this.dragging){
this.dragging=true;
}
this.draw(_30);
if(navigator.appVersion.indexOf("AppleWebKit")>0){
window.scrollBy(0,0);
}
Event.stop(_30);
}
},draw:function(_31){
var _32=[Event.pointerX(_31),Event.pointerY(_31)];
var _33=Position.cumulativeOffset(this.track);
_32[0]-=this.offsetX+_33[0];
_32[1]-=this.offsetY+_33[1];
this.event=_31;
this.setValue(this.translateToValue(this.isVertical()?_32[1]:_32[0]));
if(this.initialized&&this.options.onSlide){
this.options.onSlide(this.values.length>1?this.values:this.value,this);
}
},endDrag:function(_34){
if(this.active&&this.dragging){
this.finishDrag(_34,true);
Event.stop(_34);
}
this.active=false;
this.dragging=false;
},finishDrag:function(_35,_36){
this.active=false;
this.dragging=false;
this.updateFinished();
},updateFinished:function(){
if(this.initialized&&this.options.onChange){
this.options.onChange(this.values.length>1?this.values:this.value,this);
}
this.event=null;
}};

var Autocompleter={};
Autocompleter.Base=function(){
};
Autocompleter.Base.prototype={baseInitialize:function(_1,_2,_3){
this.element=$(_1);
this.update=$(_2);
this.hasFocus=false;
this.changed=false;
this.active=false;
this.index=0;
this.entryCount=0;
if(this.setOptions){
this.setOptions(_3);
}else{
this.options=_3||{};
}
this.options.paramName=this.options.paramName||this.element.name;
this.options.tokens=this.options.tokens||[];
this.options.frequency=this.options.frequency||0.4;
this.options.minChars=this.options.minChars||1;
this.options.onShow=this.options.onShow||function(_1,_2){
if(!_2.style.position||_2.style.position=="absolute"){
_2.style.position="absolute";
Position.clone(_1,_2,{setHeight:false,offsetTop:_1.offsetHeight});
}
Effect.Appear(_2,{duration:0.15});
};
this.options.onHide=this.options.onHide||function(_4,_5){
new Effect.Fade(_5,{duration:0.15});
};
if(typeof (this.options.tokens)=="string"){
this.options.tokens=new Array(this.options.tokens);
}
this.observer=null;
this.element.setAttribute("autocomplete","off");
Element.hide(this.update);
Event.observe(this.element,"blur",this.onBlur.bindAsEventListener(this));
Event.observe(this.element,"keypress",this.onKeyPress.bindAsEventListener(this));
},show:function(){
if(Element.getStyle(this.update,"display")=="none"){
this.options.onShow(this.element,this.update);
}
if(!this.iefix&&(navigator.appVersion.indexOf("MSIE")>0)&&(navigator.userAgent.indexOf("Opera")<0)&&(Element.getStyle(this.update,"position")=="absolute")){
new Insertion.After(this.update,"<iframe id=\""+this.update.id+"_iefix\" "+"style=\"display:none;position:absolute;filter:progid:DXImageTransform.Microsoft.Alpha(opacity=0);\" "+"src=\"javascript:false;\" frameborder=\"0\" scrolling=\"no\"></iframe>");
this.iefix=$(this.update.id+"_iefix");
}
if(this.iefix){
setTimeout(this.fixIEOverlapping.bind(this),50);
}
},fixIEOverlapping:function(){
Position.clone(this.update,this.iefix);
this.iefix.style.zIndex=1;
this.update.style.zIndex=2;
Element.show(this.iefix);
},hide:function(){
this.stopIndicator();
if(Element.getStyle(this.update,"display")!="none"){
this.options.onHide(this.element,this.update);
}
if(this.iefix){
Element.hide(this.iefix);
}
},startIndicator:function(){
if(this.options.indicator){
Element.show(this.options.indicator);
}
},stopIndicator:function(){
if(this.options.indicator){
Element.hide(this.options.indicator);
}
},onKeyPress:function(_6){
if(this.active){
switch(_6.keyCode){
case Event.KEY_TAB:
case Event.KEY_RETURN:
this.selectEntry();
Event.stop(_6);
case Event.KEY_ESC:
this.hide();
this.active=false;
Event.stop(_6);
return;
case Event.KEY_LEFT:
case Event.KEY_RIGHT:
return;
case Event.KEY_UP:
this.markPrevious();
this.render();
if(navigator.appVersion.indexOf("AppleWebKit")>0){
Event.stop(_6);
}
return;
case Event.KEY_DOWN:
this.markNext();
this.render();
if(navigator.appVersion.indexOf("AppleWebKit")>0){
Event.stop(_6);
}
return;
}
}else{
if(_6.keyCode==Event.KEY_TAB||_6.keyCode==Event.KEY_RETURN){
return;
}
}
this.changed=true;
this.hasFocus=true;
if(this.observer){
clearTimeout(this.observer);
}
this.observer=setTimeout(this.onObserverEvent.bind(this),this.options.frequency*1000);
},onHover:function(_7){
var _8=Event.findElement(_7,"LI");
if(this.index!=_8.autocompleteIndex){
this.index=_8.autocompleteIndex;
this.render();
}
Event.stop(_7);
},onClick:function(_9){
var _10=Event.findElement(_9,"LI");
this.index=_10.autocompleteIndex;
this.selectEntry();
this.hide();
},onBlur:function(_11){
setTimeout(this.hide.bind(this),250);
this.hasFocus=false;
this.active=false;
},render:function(){
if(this.entryCount>0){
for(var i=0;i<this.entryCount;i++){
this.index==i?Element.addClassName(this.getEntry(i),"selected"):Element.removeClassName(this.getEntry(i),"selected");
}
if(this.hasFocus){
this.show();
this.active=true;
}
}else{
this.active=false;
this.hide();
}
},markPrevious:function(){
if(this.index>0){
this.index--;
}else{
this.index=this.entryCount-1;
}
},markNext:function(){
if(this.index<this.entryCount-1){
this.index++;
}else{
this.index=0;
}
},getEntry:function(_13){
return this.update.firstChild.childNodes[_13];
},getCurrentEntry:function(){
return this.getEntry(this.index);
},selectEntry:function(){
this.active=false;
this.updateElement(this.getCurrentEntry());
},updateElement:function(_14){
if(this.options.updateElement){
this.options.updateElement(_14);
return;
}
var _15=Element.collectTextNodesIgnoreClass(_14,"informal");
var _16=this.findLastToken();
if(_16!=-1){
var _17=this.element.value.substr(0,_16+1);
var _18=this.element.value.substr(_16+1).match(/^\s+/);
if(_18){
_17+=_18[0];
}
this.element.value=_17+_15;
}else{
this.element.value=_15;
}
this.element.focus();
if(this.options.afterUpdateElement){
this.options.afterUpdateElement(this.element,_14);
}
},updateChoices:function(_19){
if(!this.changed&&this.hasFocus){
this.update.innerHTML=_19;
Element.cleanWhitespace(this.update);
Element.cleanWhitespace(this.update.firstChild);
if(this.update.firstChild&&this.update.firstChild.childNodes){
this.entryCount=this.update.firstChild.childNodes.length;
for(var i=0;i<this.entryCount;i++){
var _20=this.getEntry(i);
_20.autocompleteIndex=i;
this.addObservers(_20);
}
}else{
this.entryCount=0;
}
this.stopIndicator();
this.index=0;
this.render();
}
},addObservers:function(_21){
Event.observe(_21,"mouseover",this.onHover.bindAsEventListener(this));
Event.observe(_21,"click",this.onClick.bindAsEventListener(this));
},onObserverEvent:function(){
this.changed=false;
if(this.getToken().length>=this.options.minChars){
this.startIndicator();
this.getUpdatedChoices();
}else{
this.active=false;
this.hide();
}
},getToken:function(){
var _22=this.findLastToken();
if(_22!=-1){
var ret=this.element.value.substr(_22+1).replace(/^\s+/,"").replace(/\s+$/,"");
}else{
var ret=this.element.value;
}
return /\n/.test(ret)?"":ret;
},findLastToken:function(){
var _24=-1;
for(var i=0;i<this.options.tokens.length;i++){
var _25=this.element.value.lastIndexOf(this.options.tokens[i]);
if(_25>_24){
_24=_25;
}
}
return _24;
}};
Ajax.Autocompleter=Class.create();
Object.extend(Object.extend(Ajax.Autocompleter.prototype,Autocompleter.Base.prototype),{initialize:function(_26,_27,url,_29){
this.baseInitialize(_26,_27,_29);
this.options.asynchronous=true;
this.options.onComplete=this.onComplete.bind(this);
this.options.defaultParams=this.options.parameters||null;
this.url=url;
},getUpdatedChoices:function(){
entry=encodeURIComponent(this.options.paramName)+"="+encodeURIComponent(this.getToken());
this.options.parameters=this.options.callback?this.options.callback(this.element,entry):entry;
if(this.options.defaultParams){
this.options.parameters+="&"+this.options.defaultParams;
}
new Ajax.Request(this.url,this.options);
},onComplete:function(_30){
this.updateChoices(_30.responseText);
}});
Autocompleter.Local=Class.create();
Autocompleter.Local.prototype=Object.extend(new Autocompleter.Base(),{initialize:function(_31,_32,_33,_34){
this.baseInitialize(_31,_32,_34);
this.options.array=_33;
},getUpdatedChoices:function(){
this.updateChoices(this.options.selector(this));
},setOptions:function(_35){
this.options=Object.extend({choices:10,partialSearch:true,partialChars:2,ignoreCase:true,fullSearch:false,selector:function(_36){
var ret=[];
var _37=[];
var _38=_36.getToken();
var _39=0;
for(var i=0;i<_36.options.array.length&&ret.length<_36.options.choices;i++){
var _40=_36.options.array[i];
var _41=_36.options.ignoreCase?_40.toLowerCase().indexOf(_38.toLowerCase()):_40.indexOf(_38);
while(_41!=-1){
if(_41==0&&_40.length!=_38.length){
ret.push("<li><strong>"+_40.substr(0,_38.length)+"</strong>"+_40.substr(_38.length)+"</li>");
break;
}else{
if(_38.length>=_36.options.partialChars&&_36.options.partialSearch&&_41!=-1){
if(_36.options.fullSearch||/\s/.test(_40.substr(_41-1,1))){
_37.push("<li>"+_40.substr(0,_41)+"<strong>"+_40.substr(_41,_38.length)+"</strong>"+_40.substr(_41+_38.length)+"</li>");
break;
}
}
}
_41=_36.options.ignoreCase?_40.toLowerCase().indexOf(_38.toLowerCase(),_41+1):_40.indexOf(_38,_41+1);
}
}
if(_37.length){
ret=ret.concat(_37.slice(0,_36.options.choices-ret.length));
}
return "<ul>"+ret.join("")+"</ul>";
}},_35||{});
}});
Field.scrollFreeActivate=function(_42){
setTimeout(function(){
Field.activate(_42);
},1);
};
Ajax.InPlaceEditor=Class.create();
Ajax.InPlaceEditor.defaultHighlightColor="#FFFF99";
Ajax.InPlaceEditor.prototype={initialize:function(_43,url,_44){
this.url=url;
this.element=$(_43);
this.options=Object.extend({okText:"ok",cancelText:"cancel",savingText:"Saving...",clickToEditText:"Click to edit",okText:"ok",rows:1,onComplete:function(_45,_43){
new Effect.Highlight(_43,{startcolor:this.options.highlightcolor});
},onFailure:function(_46){
alert("Error communicating with the server: "+_46.responseText.stripTags());
},callback:function(_47){
return Form.serialize(_47);
},handleLineBreaks:true,loadingText:"Loading...",savingClassName:"inplaceeditor-saving",loadingClassName:"inplaceeditor-loading",formClassName:"inplaceeditor-form",highlightcolor:Ajax.InPlaceEditor.defaultHighlightColor,highlightendcolor:"#FFFFFF",externalControl:null,ajaxOptions:{}},_44||{});
if(!this.options.formId&&this.element.id){
this.options.formId=this.element.id+"-inplaceeditor";
if($(this.options.formId)){
this.options.formId=null;
}
}
if(this.options.externalControl){
this.options.externalControl=$(this.options.externalControl);
}
this.originalBackground=Element.getStyle(this.element,"background-color");
if(!this.originalBackground){
this.originalBackground="transparent";
}
this.element.title=this.options.clickToEditText;
this.onclickListener=this.enterEditMode.bindAsEventListener(this);
this.mouseoverListener=this.enterHover.bindAsEventListener(this);
this.mouseoutListener=this.leaveHover.bindAsEventListener(this);
Event.observe(this.element,"click",this.onclickListener);
Event.observe(this.element,"mouseover",this.mouseoverListener);
Event.observe(this.element,"mouseout",this.mouseoutListener);
if(this.options.externalControl){
Event.observe(this.options.externalControl,"click",this.onclickListener);
Event.observe(this.options.externalControl,"mouseover",this.mouseoverListener);
Event.observe(this.options.externalControl,"mouseout",this.mouseoutListener);
}
},enterEditMode:function(evt){
if(this.saving){
return;
}
if(this.editing){
return;
}
this.editing=true;
this.onEnterEditMode();
if(this.options.externalControl){
Element.hide(this.options.externalControl);
}
Element.hide(this.element);
this.createForm();
this.element.parentNode.insertBefore(this.form,this.element);
Field.scrollFreeActivate(this.editField);
if(evt){
Event.stop(evt);
}
return false;
},createForm:function(){
this.form=document.createElement("form");
this.form.id=this.options.formId;
Element.addClassName(this.form,this.options.formClassName);
this.form.onsubmit=this.onSubmit.bind(this);
this.createEditField();
if(this.options.textarea){
var br=document.createElement("br");
this.form.appendChild(br);
}
okButton=document.createElement("input");
okButton.type="submit";
okButton.value=this.options.okText;
this.form.appendChild(okButton);
cancelLink=document.createElement("a");
cancelLink.href="#";
cancelLink.appendChild(document.createTextNode(this.options.cancelText));
cancelLink.onclick=this.onclickCancel.bind(this);
this.form.appendChild(cancelLink);
},hasHTMLLineBreaks:function(_50){
if(!this.options.handleLineBreaks){
return false;
}
return _50.match(/<br/i)||_50.match(/<p>/i);
},convertHTMLLineBreaks:function(_51){
return _51.replace(/<br>/gi,"\n").replace(/<br\/>/gi,"\n").replace(/<\/p>/gi,"\n").replace(/<p>/gi,"");
},createEditField:function(){
var _52;
if(this.options.loadTextURL){
_52=this.options.loadingText;
}else{
_52=this.getText();
}
if(this.options.rows==1&&!this.hasHTMLLineBreaks(_52)){
this.options.textarea=false;
var _53=document.createElement("input");
_53.type="text";
_53.name="value";
_53.value=_52;
_53.style.backgroundColor=this.options.highlightcolor;
var _54=this.options.size||this.options.cols||0;
if(_54!=0){
_53.size=_54;
}
this.editField=_53;
}else{
this.options.textarea=true;
var _55=document.createElement("textarea");
_55.name="value";
_55.value=this.convertHTMLLineBreaks(_52);
_55.rows=this.options.rows;
_55.cols=this.options.cols||40;
this.editField=_55;
}
if(this.options.loadTextURL){
this.loadExternalText();
}
this.form.appendChild(this.editField);
},getText:function(){
return this.element.innerHTML;
},loadExternalText:function(){
Element.addClassName(this.form,this.options.loadingClassName);
this.editField.disabled=true;
new Ajax.Request(this.options.loadTextURL,Object.extend({asynchronous:true,onComplete:this.onLoadedExternalText.bind(this)},this.options.ajaxOptions));
},onLoadedExternalText:function(_56){
Element.removeClassName(this.form,this.options.loadingClassName);
this.editField.disabled=false;
this.editField.value=_56.responseText.stripTags();
},onclickCancel:function(){
this.onComplete();
this.leaveEditMode();
return false;
},onFailure:function(_57){
this.options.onFailure(_57);
if(this.oldInnerHTML){
this.element.innerHTML=this.oldInnerHTML;
this.oldInnerHTML=null;
}
return false;
},onSubmit:function(){
var _58=this.form;
var _59=this.editField.value;
this.onLoading();
new Ajax.Updater({success:this.element,failure:null},this.url,Object.extend({parameters:this.options.callback(_58,_59),onComplete:this.onComplete.bind(this),onFailure:this.onFailure.bind(this)},this.options.ajaxOptions));
if(arguments.length>1){
Event.stop(arguments[0]);
}
return false;
},onLoading:function(){
this.saving=true;
this.removeForm();
this.leaveHover();
this.showSaving();
},showSaving:function(){
this.oldInnerHTML=this.element.innerHTML;
this.element.innerHTML=this.options.savingText;
Element.addClassName(this.element,this.options.savingClassName);
this.element.style.backgroundColor=this.originalBackground;
Element.show(this.element);
},removeForm:function(){
if(this.form){
if(this.form.parentNode){
Element.remove(this.form);
}
this.form=null;
}
},enterHover:function(){
if(this.saving){
return;
}
this.element.style.backgroundColor=this.options.highlightcolor;
if(this.effect){
this.effect.cancel();
}
Element.addClassName(this.element,this.options.hoverClassName);
},leaveHover:function(){
if(this.options.backgroundColor){
this.element.style.backgroundColor=this.oldBackground;
}
Element.removeClassName(this.element,this.options.hoverClassName);
if(this.saving){
return;
}
this.effect=new Effect.Highlight(this.element,{startcolor:this.options.highlightcolor,endcolor:this.options.highlightendcolor,restorecolor:this.originalBackground});
},leaveEditMode:function(){
Element.removeClassName(this.element,this.options.savingClassName);
this.removeForm();
this.leaveHover();
this.element.style.backgroundColor=this.originalBackground;
Element.show(this.element);
if(this.options.externalControl){
Element.show(this.options.externalControl);
}
this.editing=false;
this.saving=false;
this.oldInnerHTML=null;
this.onLeaveEditMode();
},onComplete:function(_60){
this.leaveEditMode();
this.options.onComplete.bind(this)(_60,this.element);
},onEnterEditMode:function(){
},onLeaveEditMode:function(){
},dispose:function(){
if(this.oldInnerHTML){
this.element.innerHTML=this.oldInnerHTML;
}
this.leaveEditMode();
Event.stopObserving(this.element,"click",this.onclickListener);
Event.stopObserving(this.element,"mouseover",this.mouseoverListener);
Event.stopObserving(this.element,"mouseout",this.mouseoutListener);
if(this.options.externalControl){
Event.stopObserving(this.options.externalControl,"click",this.onclickListener);
Event.stopObserving(this.options.externalControl,"mouseover",this.mouseoverListener);
Event.stopObserving(this.options.externalControl,"mouseout",this.mouseoutListener);
}
}};
Form.Element.DelayedObserver=Class.create();
Form.Element.DelayedObserver.prototype={initialize:function(_61,_62,_63){
this.delay=_62||0.5;
this.element=$(_61);
this.callback=_63;
this.timer=null;
this.lastValue=$F(this.element);
Event.observe(this.element,"keyup",this.delayedListener.bindAsEventListener(this));
},delayedListener:function(_64){
if(this.lastValue==$F(this.element)){
return;
}
if(this.timer){
clearTimeout(this.timer);
}
this.timer=setTimeout(this.onTimerEvent.bind(this),this.delay*1000);
this.lastValue=$F(this.element);
},onTimerEvent:function(){
this.timer=null;
this.callback(this.element,$F(this.element));
}};

var Droppables={drops:[],remove:function(_1){
this.drops=this.drops.reject(function(d){
return d.element==$(_1);
});
},add:function(_3){
_3=$(_3);
var _4=Object.extend({greedy:true,hoverclass:null},arguments[1]||{});
if(_4.containment){
_4._containers=[];
var _5=_4.containment;
if((typeof _5=="object")&&(_5.constructor==Array)){
_5.each(function(c){
_4._containers.push($(c));
});
}else{
_4._containers.push($(_5));
}
}
if(_4.accept){
_4.accept=[_4.accept].flatten();
}
Element.makePositioned(_3);
_4.element=_3;
this.drops.push(_4);
},isContained:function(_7,_8){
var _9=_7.parentNode;
return _8._containers.detect(function(c){
return _9==c;
});
},isAffected:function(_10,_11,_12){
return ((_12.element!=_11)&&((!_12._containers)||this.isContained(_11,_12))&&((!_12.accept)||(Element.classNames(_11).detect(function(v){
return _12.accept.include(v);
})))&&Position.within(_12.element,_10[0],_10[1]));
},deactivate:function(_14){
if(_14.hoverclass){
Element.removeClassName(_14.element,_14.hoverclass);
}
this.last_active=null;
},activate:function(_15){
if(_15.hoverclass){
Element.addClassName(_15.element,_15.hoverclass);
}
this.last_active=_15;
},show:function(_16,_17){
if(!this.drops.length){
return;
}
if(this.last_active){
this.deactivate(this.last_active);
}
this.drops.each(function(_18){
if(Droppables.isAffected(_16,_17,_18)){
if(_18.onHover){
_18.onHover(_17,_18.element,Position.overlap(_18.overlap,_18.element));
}
if(_18.greedy){
Droppables.activate(_18);
}
}
});
},fire:function(_19,_20){
if(!this.last_active){
return;
}
Position.prepare();
if(this.isAffected([Event.pointerX(_19),Event.pointerY(_19)],_20,this.last_active)){
if(this.last_active.onDrop){
this.last_active.onDrop(_20,this.last_active.element,_19);
}
}
},reset:function(){
if(this.last_active){
this.deactivate(this.last_active);
}
}};
var Draggables={drags:[],observers:[],register:function(_21){
if(this.drags.length==0){
this.eventMouseUp=this.endDrag.bindAsEventListener(this);
this.eventMouseMove=this.updateDrag.bindAsEventListener(this);
this.eventKeypress=this.keyPress.bindAsEventListener(this);
Event.observe(document,"mouseup",this.eventMouseUp);
Event.observe(document,"mousemove",this.eventMouseMove);
Event.observe(document,"keypress",this.eventKeypress);
}
this.drags.push(_21);
},unregister:function(_22){
this.drags=this.drags.reject(function(d){
return d==_22;
});
if(this.drags.length==0){
Event.stopObserving(document,"mouseup",this.eventMouseUp);
Event.stopObserving(document,"mousemove",this.eventMouseMove);
Event.stopObserving(document,"keypress",this.eventKeypress);
}
},activate:function(_23){
window.focus();
this.activeDraggable=_23;
},deactivate:function(_24){
this.activeDraggable=null;
},updateDrag:function(_25){
if(!this.activeDraggable){
return;
}
var _26=[Event.pointerX(_25),Event.pointerY(_25)];
if(this._lastPointer&&(this._lastPointer.inspect()==_26.inspect())){
return;
}
this._lastPointer=_26;
this.activeDraggable.updateDrag(_25,_26);
},endDrag:function(_27){
if(!this.activeDraggable){
return;
}
this._lastPointer=null;
this.activeDraggable.endDrag(_27);
},keyPress:function(_28){
if(this.activeDraggable){
this.activeDraggable.keyPress(_28);
}
},addObserver:function(_29){
this.observers.push(_29);
this._cacheObserverCallbacks();
},removeObserver:function(_30){
this.observers=this.observers.reject(function(o){
return o.element==_30;
});
this._cacheObserverCallbacks();
},notify:function(_32,_33,_34){
if(this[_32+"Count"]>0){
this.observers.each(function(o){
if(o[_32]){
o[_32](_32,_33,_34);
}
});
}
},_cacheObserverCallbacks:function(){
["onStart","onEnd","onDrag"].each(function(_35){
Draggables[_35+"Count"]=Draggables.observers.select(function(o){
return o[_35];
}).length;
});
}};
var Draggable=Class.create();
Draggable.prototype={initialize:function(_36){
this.element=$(_36);
var _37=Object.extend({handle:false,starteffect:function(_36){
new Effect.Opacity(_36,{duration:0.2,from:1,to:0.7});
},reverteffect:function(_38,_39,_40){
var dur=Math.sqrt(Math.abs(_39^2)+Math.abs(_40^2))*0.02;
_38._revert=new Effect.MoveBy(_38,-_39,-_40,{duration:dur});
},endeffect:function(_42){
new Effect.Opacity(_42,{duration:0.2,from:0.7,to:1});
},zindex:1000,revert:false,snap:false},arguments[1]||{});
if(_37.handle&&(typeof _37.handle=="string")){
this.handle=Element.childrenWithClassName(this.element,_37.handle)[0];
}
if(!this.handle){
this.handle=$(_37.handle);
}
if(!this.handle){
this.handle=this.element;
}
Element.makePositioned(this.element);
this.delta=this.currentDelta();
this.options=_37;
this.dragging=false;
this.eventMouseDown=this.initDrag.bindAsEventListener(this);
Event.observe(this.handle,"mousedown",this.eventMouseDown);
Draggables.register(this);
},destroy:function(){
Event.stopObserving(this.handle,"mousedown",this.eventMouseDown);
Draggables.unregister(this);
},currentDelta:function(){
return ([parseInt(this.element.style.left||"0"),parseInt(this.element.style.top||"0")]);
},initDrag:function(_43){
if(Event.isLeftClick(_43)){
var src=Event.element(_43);
if(src.tagName&&(src.tagName=="INPUT"||src.tagName=="SELECT"||src.tagName=="BUTTON"||src.tagName=="TEXTAREA")){
return;
}
if(this.element._revert){
this.element._revert.cancel();
this.element._revert=null;
}
var _45=[Event.pointerX(_43),Event.pointerY(_43)];
var pos=Position.cumulativeOffset(this.element);
this.offset=[0,1].map(function(i){
return (_45[i]-pos[i]);
});
Draggables.activate(this);
Event.stop(_43);
}
},startDrag:function(_48){
this.dragging=true;
if(this.options.zindex){
this.originalZ=parseInt(Element.getStyle(this.element,"z-index")||0);
this.element.style.zIndex=this.options.zindex;
}
if(this.options.ghosting){
this._clone=this.element.cloneNode(true);
Position.absolutize(this.element);
this.element.parentNode.insertBefore(this._clone,this.element);
}
Draggables.notify("onStart",this,_48);
if(this.options.starteffect){
this.options.starteffect(this.element);
}
},updateDrag:function(_49,_50){
if(!this.dragging){
this.startDrag(_49);
}
Position.prepare();
Droppables.show(_50,this.element);
Draggables.notify("onDrag",this,_49);
this.draw(_50);
if(this.options.change){
this.options.change(this);
}
if(navigator.appVersion.indexOf("AppleWebKit")>0){
window.scrollBy(0,0);
}
Event.stop(_49);
},finishDrag:function(_51,_52){
this.dragging=false;
if(this.options.ghosting){
Position.relativize(this.element);
Element.remove(this._clone);
this._clone=null;
}
if(_52){
Droppables.fire(_51,this.element);
}
Draggables.notify("onEnd",this,_51);
var _53=this.options.revert;
if(_53&&typeof _53=="function"){
_53=_53(this.element);
}
var d=this.currentDelta();
if(_53&&this.options.reverteffect){
this.options.reverteffect(this.element,d[1]-this.delta[1],d[0]-this.delta[0]);
}else{
this.delta=d;
}
if(this.options.zindex){
this.element.style.zIndex=this.originalZ;
}
if(this.options.endeffect){
this.options.endeffect(this.element);
}
Draggables.deactivate(this);
Droppables.reset();
},keyPress:function(_54){
if(!_54.keyCode==Event.KEY_ESC){
return;
}
this.finishDrag(_54,false);
Event.stop(_54);
},endDrag:function(_55){
if(!this.dragging){
return;
}
this.finishDrag(_55,true);
Event.stop(_55);
},draw:function(_56){
var pos=Position.cumulativeOffset(this.element);
var d=this.currentDelta();
pos[0]-=d[0];
pos[1]-=d[1];
var p=[0,1].map(function(i){
return (_56[i]-pos[i]-this.offset[i]);
}.bind(this));
if(this.options.snap){
if(typeof this.options.snap=="function"){
p=this.options.snap(p[0],p[1]);
}else{
if(this.options.snap instanceof Array){
p=p.map(function(v,i){
return Math.round(v/this.options.snap[i])*this.options.snap[i];
}.bind(this));
}else{
p=p.map(function(v){
return Math.round(v/this.options.snap)*this.options.snap;
}.bind(this));
}
}
}
var _58=this.element.style;
if((!this.options.constraint)||(this.options.constraint=="horizontal")){
_58.left=p[0]+"px";
}
if((!this.options.constraint)||(this.options.constraint=="vertical")){
_58.top=p[1]+"px";
}
if(_58.visibility=="hidden"){
_58.visibility="";
}
}};
var SortableObserver=Class.create();
SortableObserver.prototype={initialize:function(_59,_60){
this.element=$(_59);
this.observer=_60;
this.lastValue=Sortable.serialize(this.element);
},onStart:function(){
this.lastValue=Sortable.serialize(this.element);
},onEnd:function(){
Sortable.unmark();
if(this.lastValue!=Sortable.serialize(this.element)){
this.observer(this.element);
}
}};
var Sortable={sortables:new Array(),options:function(_61){
_61=$(_61);
return this.sortables.detect(function(s){
return s.element==_61;
});
},destroy:function(_63){
_63=$(_63);
this.sortables.findAll(function(s){
return s.element==_63;
}).each(function(s){
Draggables.removeObserver(s.element);
s.droppables.each(function(d){
Droppables.remove(d);
});
s.draggables.invoke("destroy");
});
this.sortables=this.sortables.reject(function(s){
return s.element==_63;
});
},create:function(_64){
_64=$(_64);
var _65=Object.extend({element:_64,tag:"li",dropOnEmpty:false,tree:false,overlap:"vertical",constraint:"vertical",containment:_64,handle:false,only:false,hoverclass:null,ghosting:false,format:null,onChange:Prototype.emptyFunction,onUpdate:Prototype.emptyFunction},arguments[1]||{});
this.destroy(_64);
var _66={revert:true,ghosting:_65.ghosting,constraint:_65.constraint,handle:_65.handle};
if(_65.starteffect){
_66.starteffect=_65.starteffect;
}
if(_65.reverteffect){
_66.reverteffect=_65.reverteffect;
}else{
if(_65.ghosting){
_66.reverteffect=function(_64){
_64.style.top=0;
_64.style.left=0;
};
}
}
if(_65.endeffect){
_66.endeffect=_65.endeffect;
}
if(_65.zindex){
_66.zindex=_65.zindex;
}
var _67={overlap:_65.overlap,containment:_65.containment,hoverclass:_65.hoverclass,onHover:Sortable.onHover,greedy:!_65.dropOnEmpty};
Element.cleanWhitespace(element);
_65.draggables=[];
_65.droppables=[];
if(_65.dropOnEmpty){
Droppables.add(element,{containment:_65.containment,onHover:Sortable.onEmptyHover,greedy:false});
_65.droppables.push(element);
}
(this.findElements(element,_65)||[]).each(function(e){
var _69=_65.handle?Element.childrenWithClassName(e,_65.handle)[0]:e;
_65.draggables.push(new Draggable(e,Object.extend(_66,{handle:_69})));
Droppables.add(e,_67);
_65.droppables.push(e);
});
this.sortables.push(_65);
Draggables.addObserver(new SortableObserver(element,_65.onUpdate));
},findElements:function(_70,_71){
if(!_70.hasChildNodes()){
return null;
}
var _72=[];
$A(_70.childNodes).each(function(e){
if(e.tagName&&e.tagName.toUpperCase()==_71.tag.toUpperCase()&&(!_71.only||(Element.hasClassName(e,_71.only)))){
_72.push(e);
}
if(_71.tree){
var _73=this.findElements(e,_71);
if(_73){
_72.push(_73);
}
}
});
return (_72.length>0?_72.flatten():null);
},onHover:function(_74,_75,_76){
if(_76>0.5){
Sortable.mark(_75,"before");
if(_75.previousSibling!=_74){
var _77=_74.parentNode;
_74.style.visibility="hidden";
_75.parentNode.insertBefore(_74,_75);
if(_75.parentNode!=_77){
Sortable.options(_77).onChange(_74);
}
Sortable.options(_75.parentNode).onChange(_74);
}
}else{
Sortable.mark(_75,"after");
var _78=_75.nextSibling||null;
if(_78!=_74){
var _77=_74.parentNode;
_74.style.visibility="hidden";
_75.parentNode.insertBefore(_74,_78);
if(_75.parentNode!=_77){
Sortable.options(_77).onChange(_74);
}
Sortable.options(_75.parentNode).onChange(_74);
}
}
},onEmptyHover:function(_79,_80){
if(_79.parentNode!=_80){
var _81=_79.parentNode;
_80.appendChild(_79);
Sortable.options(_81).onChange(_79);
Sortable.options(_80).onChange(_79);
}
},unmark:function(){
if(Sortable._marker){
Element.hide(Sortable._marker);
}
},mark:function(_82,_83){
var _84=Sortable.options(_82.parentNode);
if(_84&&!_84.ghosting){
return;
}
if(!Sortable._marker){
Sortable._marker=$("dropmarker")||document.createElement("DIV");
Element.hide(Sortable._marker);
Element.addClassName(Sortable._marker,"dropmarker");
Sortable._marker.style.position="absolute";
document.getElementsByTagName("body").item(0).appendChild(Sortable._marker);
}
var _85=Position.cumulativeOffset(_82);
Sortable._marker.style.left=_85[0]+"px";
Sortable._marker.style.top=_85[1]+"px";
if(_83=="after"){
if(_84.overlap=="horizontal"){
Sortable._marker.style.left=(_85[0]+_82.clientWidth)+"px";
}else{
Sortable._marker.style.top=(_85[1]+_82.clientHeight)+"px";
}
}
Element.show(Sortable._marker);
},serialize:function(_86){
_86=$(_86);
var _87=this.options(_86);
var _88=Object.extend({tag:_87.tag,only:_87.only,name:_86.id,format:_87.format||/^[^_]*_(.*)$/},arguments[1]||{});
return $(this.findElements(_86,_88)||[]).map(function(_89){
return (encodeURIComponent(_88.name)+"[]="+encodeURIComponent(_89.id.match(_88.format)?_89.id.match(_88.format)[1]:""));
}).join("&");
}};

Prado.AutoCompleter=Class.create();
Prado.AutoCompleter.Base=function(){
};
Prado.AutoCompleter.Base.prototype=Object.extend(Autocompleter.Base.prototype,{updateElement:function(_1){
if(this.options.updateElement){
this.options.updateElement(_1);
return;
}
var _2=Element.collectTextNodesIgnoreClass(_1,"informal");
var _3=this.findLastToken();
if(_3!=-1){
var _4=this.element.value.substr(0,_3+1);
var _5=this.element.value.substr(_3+1).match(/^\s+/);
if(_5){
_4+=_5[0];
}
this.element.value=(_4+_2).trim();
}else{
this.element.value=_2.trim();
}
this.element.focus();
if(this.options.afterUpdateElement){
this.options.afterUpdateElement(this.element,_1);
}
}});
Prado.AutoCompleter.prototype=Object.extend(new Autocompleter.Base(),{initialize:function(_6,_7,_8){
this.baseInitialize(_6,_7,_8);
},onUpdateReturn:function(_9){
if(isString(_9)&&_9.length>0){
this.updateChoices(_9);
}
},getUpdatedChoices:function(){
Prado.Callback(this.element.id,this.getToken(),this.onUpdateReturn.bind(this));
}});
Prado.ActivePanel={callbacks:{},register:function(id,_11){
Prado.ActivePanel.callbacks[id]=_11;
},update:function(id,_12){
var _13=new Prado.ActivePanel.Request(id,Prado.ActivePanel.callbacks[id]);
_13.callback(_12);
}};
Prado.ActivePanel.Request=Class.create();
Prado.ActivePanel.Request.prototype={initialize:function(_14,_15){
this.element=_14;
this.setOptions(_15);
},setOptions:function(_16){
this.options={onSuccess:this.onSuccess.bind(this)};
Object.extend(this.options,_16||{});
},callback:function(_17){
this.options.params=[_17];
new Prado.AJAX.Callback(this.element,this.options);
},onSuccess:function(_18,_19){
if(this.options.update){
if(!this.options.evalScripts){
_19=_19.stripScripts();
}
Element.update(this.options.update,_19);
}
}};
Prado.DropContainer=Class.create();
Prado.DropContainer.prototype=Object.extend(new Prado.ActivePanel.Request(),{initialize:function(_20,_21){
this.element=_20;
this.setOptions(_21);
Object.extend(this.options,{onDrop:this.onDrop.bind(this),evalScripts:true,onSuccess:_21.onSuccess||this.onSuccess.bind(this)});
Droppables.add(_20,this.options);
},onDrop:function(_22,_23){
this.callback(_22.id);
}});

