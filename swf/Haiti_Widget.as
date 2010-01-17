package {
	import flash.display.Sprite;
	import flash.display.StageAlign;
	import flash.display.StageScaleMode;
	import flash.events.*;
	import flash.net.URLRequest;
	import flash.net.navigateToURL;
	import flash.net.URLLoader;
	import flash.text.TextFieldAutoSize;
	import flash.text.TextField;
	import flash.text.TextFieldType;
	import flash.text.StyleSheet;
	public class Haiti_Widget extends Sprite {
		// _ prefix on var indicates var is being loaded asynchronously
		
		protected var textRect:Sprite = new Sprite();
		protected var tfHolder:Sprite = new Sprite();
		protected var tf:TextField = new TextField();
		protected var style:StyleSheet = new StyleSheet();
		protected var css:Object = new Object();
		protected var _personID:Number;
		protected var _firstName:String;
		protected var _lastName:String;
		
		public function Haiti_Widget() {
			stage.scaleMode=StageScaleMode.NO_SCALE;
			stage.align=StageAlign.TOP_LEFT;
			
			addEventListener(Event.ADDED_TO_STAGE, init);
			loaderInfo.addEventListener(Event.COMPLETE, loaderComplete);
		}
		protected function init(e:Event) {
			//code run when added to stage
			//textRect.mouseChildren = tfHolder.mouseChildren = true;
			tf.type = TextFieldType.DYNAMIC;
			tf.autoSize = TextFieldAutoSize.LEFT;
			tf.addEventListener(MouseEvent.CLICK, onPersonClick);
			addChild(tf);
			logo.buttonMode = true;
			logo.addEventListener(MouseEvent.CLICK, logoClick);
		}
		protected function logoClick(e:MouseEvent):void {
			//click to logo brings to home page
			var request:URLRequest = new URLRequest("http://www.haitianquake.com");
  			navigateToURL(request,"_blank");
		}
		protected function loaderComplete(e:Event):void {
			//code run after everything is loaded
			loaderInfo.removeEventListener(Event.COMPLETE, loaderComplete);
			var flashVars=loaderInfo.parameters;
			try {
				if(flashVars.PersonID) {
					trace("Id found in flashVar");
					//retreive first and last name
					_personID = flashVars.PersonID;
					getAdditionalData();
					//do after fromAPI loaded
					tf.htmlText = "<a href='http://www.haitianquake.com/person.php?id=" + _personID + "'>" + _firstName + " " + _lastName + "</a>";
				}
				else {
					trace("Error: FlashVar PersonID not defined");
					_personID = 0;
					
					_firstName = "Dardignac";
					_lastName = "Rene";
					tf.htmlText = "<a href='http://www.haitianquake.com/person.php?id=" + _personID + "'>" + _firstName + " " + _lastName + "</a>";
					css.fontFamily = "Arial";
					css.color = "#336699";
					css.fontSize = 37;
					tf.styleSheet = style;
					style.setStyle("a", css);
					tf.y = 75;
					trace(width);
					tf.x = (width/2) - (tf.width/2);
				}
			} catch(e){
				_personID = 0;
			}			
		}
		protected function getAdditionalData():void {
			//gets first and last name with _personID
			if (_personID.toString()=="NaN") {
				trace("There was a problem finding the topic ID number. If this is your website please check the embed code making sure topicID is included. \n \n Please visit <a href='http://www.votavox.com' TARGET='_blank'>www.votavox.com</a> for more topics.");
			} else {
				var loader:URLLoader=new URLLoader;
				var req:URLRequest=new URLRequest("http://www.haitianquake.com/API/"+_personID);
				loader.load(req);
				loader.addEventListener(Event.COMPLETE, onDataFetched);
				loader.addEventListener(SecurityErrorEvent.SECURITY_ERROR, secError);
				//loader.addEventListener(HTTPStatusEvent.HTTP_STATUS, httpEvent);
				loader.addEventListener(IOErrorEvent.IO_ERROR, ioError);
			}
		
		}
		protected function onDataFetched(e:Event):void {
			
		}
		
		/*------------*/
		/* Net Errors */
		
		protected function secError(event:SecurityErrorEvent):void {
			tf.htmlText = "<a>There was a problem connectiong... Problem is a [security error]</a>";
			css.fontSize = 12;
			tf.x = (width/2) - (tf.width/2);
		}
		/*
		protected function httpEvent(event:Event):void {
			tf.htmlText ="<a>httpStatusHandler: " + event + "</a>";
			css.fontSize = 12;
			tf.x = (width/2) - (tf.width/2);
		}
		*/
		protected function ioError(event:Event):void {
			tf.text = "There was a problem connectiong... Problem is a [IO Error]</a>";
			css.fontSize = 12;
			tf.x = (width/2) - (tf.width/2);
		}
		
		//check if needed
		protected function onPersonClick(e:MouseEvent):void {
			trace("clicked");
		}
		
	}
}