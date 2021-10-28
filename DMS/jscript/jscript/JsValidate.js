/**
 * 
 * This js file is designed to achive commonly used web validation.
 * @author RC004-364
 * @version 1.0
 * @copyright Copyright (c) 2007, Red Couch Interactive
 * @package System.Js
 * @class  Validate
 * @date 19,Apr 2007
 * @example ../rciKernelDemo/System.Js/Vaidate.php Validates Demo
 */
var frmName 	= 'form1';
var sysMsg 		= true;
var alertMsg	= true, gblMsg = null;
var keyToCheck	= Array(Array()), keyToCheckCtr = 0;

var Msg = Array(Array('S','Enter value'),
			  Array('I','Enter numeric value with out decimal'),	
			  Array('F','Enter decimal number'),
			  Array('E','Enter valid E-mail address'),
			  Array('IP','Enter  IP format (64.233.187.99)')
			  );

/**
 * This is prototyping of string function which will handel trim function.
 * @return string
 */
 String.prototype.trim = function() { return this.replace(/^\s+|\s+$/, ''); };

/**
 * This function trims the given input.  trim is defined as prototype of  string function.
 * @param string val 
 * @return string
 */
function jsTrim(inputVal){

	//return inputVal.trim();
	return inputVal;
}
/**
 * This function check weather given value is blank or not.
 * @param string val 
 * @return boolen
 */

function isBlank( inputVal)	{
	return jsTrim(inputVal)==''?true:false;
}


	/**
	 * This function returns the pattern of ereg based on parameter
	 * @param string  key 
     * @param bool required
	 * @return string
	 */
function getPattern( key, required){
	if(getPattern.arguments.length == 0){
		key='int';
		required=false;
	}else if(getPattern.arguments.length == 1){
		required=false;
	}

	key=key.toUpperCase();
	numberLen=required?1:0;

	
		var patternArray=Array(
								Array('INT','^-{0,1}[0-9]{'+numberLen+',}$'),
								Array('FLOAT','^-{0,1}[0-9]{'+numberLen+',}\.{0,1}[0-9]{0,}$'),
								Array('EMAIL','^[.a-zA-Z0-9_-]{3,}@[a-zA-Z0-9_-]{3,}.[a-zA-Z]{2,3}.{0,1}[a-zA-Z]{0,3}$')
							);
	
	for(i=0;i<patternArray.length;i++){
		if(patternArray[i][0]==key)
			return patternArray[i][1];
	}

}

	/**
	 * This function returns weather given value is number or not.
	 * @param string  whichPattern 
     * @param float inputNumber
	 * @param bool required
	 * @param float minVal
     * @param float $maxVal
	 * @return bool
	 */

function isValidNumber(whichPattern,inputNumber,required,minVal,maxVal){
	if(isValidNumber.arguments.length == 1){
		required=false;
		minVal=0;
		maxVal=0;
	}else if(isValidNumber.arguments.length == 2){
		minVal=0;
		maxVal=0;

	}else if(isValidNumber.arguments.length == 3){
		maxVal=0;
	}
	
	inputNumber=jsTrim(inputNumber);
	filter=getPattern( whichPattern, required);
	filter = new RegExp(filter);
	
		if(inputNumber=='' && required==false)
			return true;
		else if(filter.test(inputNumber)){
			if(minVal==0 && maxVal==0)	
				return true;
			else
				return (inputNumber>=minVal && inputNumber<=maxVal)?true:false;
			
		}else
			return false;
}

	/**
	 * This function returns weather given value is integer or not.
     * @param float inputNumber
	 * @param bool required
	 * @param float minVal
     * @param float maxVal
	 * @return bool
	 */
function isInteger(inputNumber,required,minVal,maxVal){
	
		if(isInteger.arguments.length == 1){
			required=false;
			minVal=0;
			maxVal=0;
		}else if(isInteger.arguments.length == 2){
				minVal=0;
				maxVal=0;
		}else if(isInteger.arguments.length == 3){
				maxVal=0;
		}
	inputNumber=inputNumber.replace(' ', '')
	return isValidNumber("INT",inputNumber,required,minVal,maxVal);
}

	/**
	 * This function returns weather given value is float or not.
     * @param float inputNumber
	 * @param bool required
	 * @param float minVal
     * @param float maxVal
	 * @return bool
	 */	
function isFloat(inputNumber,required,minVal,maxVal){
		inputNumber=inputNumber.replace(' ', '')

		if(isFloat.arguments.length == 1){
			required=false;
			minVal=0;
			maxVal=0;
		}else if(isFloat.arguments.length == 2){
			minVal=0;
			maxVal=0;
		}else if(isFloat.arguments.length == 3){
			maxVal=0;
		}
		return isValidNumber("FLOAT",inputNumber,required,minVal,maxVal);
}


	/**
	 * This function returns weather given value is string or not.
     * @param float Str
	 * @param bool required
	 * @return bool
	 */	
	function isString(Str,required){
		if(isString.arguments.length == 1){
					required=false;
			}
			if(jsTrim(Str)=="" && required==true)
				return false;
		return true;
	}

	/**
	 * This function returns weather given value is email or not.
     * @param float emailStr
	 * @param bool required
	 * @return bool
	 */	
function isEmail(emailStr,required){
		if(isEmail.arguments.length == 1){
				required=false;
		}
		emailStr=jsTrim(emailStr);
		if(emailStr=="" && required==false)
				return true;
		
		filter=getPattern("EMAIL",required)
		filter = new RegExp(filter);
	return filter.test(emailStr);
}

/**
	 * This function returns weather given value is ip or not.
     * @param float ip
	 * @param bool required
	 * @return bool
	 */	
function isIp(ip,required){
	var i;
	var oct_array,oct_val;
	if(isIp.arguments.length == 1){
			required=false;
		}

		ip=jsTrim(ip);
	
		if(ip=='' && required==false)
				return true;

		oct_array=ip.split('.');

			for(i=0;i<4;i++) {
				oct_val=oct_array[i];
		
				if(!isInteger(oct_val,true,0,255))
					return false;
		
			}
	
		return true;
}

function hasSameValue(val1,val2){
	return val1==val2?true:false;
	}

/*################Web Form Handeling######################*/


	/**
	 * This function is used to set the form name whose data is to be checked.
	 * @param string inputFrmName
	 */
	 
		function setForm(inputFrmName){
			//global frmName
			 keyToCheck=Array(Array());
			 keyToCheckCtr=0;
			frmName=inputFrmName;
		}
		
		/**
	 * This function is used to assign key which has to go through validation process.
	 * @param string $whichField 
 	 * @param string $dataType 
 	 * @param string $label 
  	 * @param string $required 
  	 * @param int $minVal 
	 * @param int $maxVal 
	 */	

	function setCheckField(whichField,dataType,label,required,minVal,maxVal){
		/*
		whichField=0
		dataType=1
		label=2
		required=3
		minVal=4
		maxVal=5
		fieldType=6
		*/
			if(setCheckField.arguments.length == 2){
				label=whichField.replace('_',' ');
				required=false;
				minVal=0;
				maxVal=0;
			}else if(setCheckField.arguments.length == 3){
				required=false;
				minVal=0;
				maxVal=0;
			}else if(setCheckField.arguments.length == 4){
				minVal=0;
				maxVal=0;
			}else if(setCheckField.arguments.length == 5){
				maxVal=0;
			}
			//global keyToCheck array
		/*
		//I don't why the following don't work.
				keyToCheck[keyToCheckCtr][0]=whichField;
				keyToCheck[keyToCheckCtr][1]=dataType;
				keyToCheck[keyToCheckCtr][2]=label;
				keyToCheck[keyToCheckCtr][3]=required;
					if(dataType=="I" || dataType=="F"){
						keyToCheck[keyToCheckCtr][4]=minVal;
						keyToCheck[keyToCheckCtr][5]=maxVal;
					}
		*/
		//hack of above array
		if(dataType=="I" || dataType=="F")
			keyToCheck[keyToCheckCtr]=Array(whichField,dataType,label,required,minVal,maxVal);
		else
			keyToCheck[keyToCheckCtr]=Array(whichField,dataType,label,required);
		
			keyToCheckCtr++;
		}
		
		
		
	/**
	 * This function is used to get message of given key.
	 * @param string whichMsg 
	 * @return string
	 */	
		
		function getMsg(whichMsg){
		//global Msg
		var i;
			for(i=0;i<Msg.length;i++){
				if(Msg[i][0]==whichMsg)
					return Msg[i][1];
			}
			
		}
		
		
	/**
	 * This function is used for mass validation.It is mainly used for validating form field
	 * where we have to validate in bulk. 
	 *@return bool;
	 */	
		function doAllValidate(){
		var i,focusCtr=0;
		var Output=Array();
		var curMsg='Please do the following: ';
		var whichField,dataType,label,minVal,maxVal,focusField,fieldType='TEXT',fieldVal='';
		var returnState=true;
		//global keyToCheck array
			/*
			whichField=0 , dataType=1 , label=2 ,required=3 , minVal=4, maxVal=5
			*/
			for(i=0;i<keyToCheck.length;i++){
				
				//easy assignment of array
				whichField=keyToCheck[i][0]; 
				dataType=keyToCheck[i][1];
				dataType=dataType.toUpperCase();
				label=keyToCheck[i][2];
				required=keyToCheck[i][3];
				minVal=keyToCheck[i][4];
				maxVal=keyToCheck[i][5];

					//for feature enhancement				
					if(fieldType=='TEXT')
						fieldVal=eval('document.'+frmName+'.'+whichField+'.value');
				
					if(required && isBlank(fieldVal)){
							curMsg+='\n'+label+' is a required field.';
							
							if(focusCtr==0)
									focusField=whichField;
							
							focusCtr++;	
							returnState=false;
						continue;	
					}

					
					if(dataType=='S' && !isString(fieldVal,required)){
							if(sysMsg){
								curMsg+='\n'+getMsg(dataType);	
								curMsg+=' on '+label+'.';
							}else
								curMsg+='\n'+label;
								
							if(focusCtr==0)
									focusField=whichField;
							focusCtr++;		
							returnState=false;
							
					 }else if(dataType=='I' && !isInteger(fieldVal,required,minVal,maxVal)){
						
						if(sysMsg){
								curMsg+='\n'+getMsg(dataType);	
								if(!(maxVal==0 && minVal==0))
									curMsg+=' which value is between '+minVal+' to '+maxVal;
							
								curMsg+=' on '+label+'.';
							}else
								curMsg+='\n'+label;

							if(focusCtr==0)
								focusField=whichField;

							focusCtr++;	
							returnState=false;
								
					}else if(dataType=='F' && !isFloat(fieldVal,required,minVal,maxVal)){
							if(sysMsg){
								curMsg+='\n'+getMsg(dataType);	
								
								if(!(maxVal==0 && minVal==0))
									curMsg+=' which value is between '+minVal+' to '+maxVal;
								
								curMsg+=' on '+label+'.';
							}else
								curMsg+='\n'+label;	
							if(focusCtr==0)
									focusField=whichField;

							focusCtr++;	
							returnState=false;
							
					}else if(dataType=="E" && !isEmail(fieldVal,required)){
							if(sysMsg){
								curMsg+='\n'+getMsg(dataType);	
								curMsg+=' on '+label+'.';
							}else
								curMsg+='\n'+label;
								
								
								
							if(focusCtr==0)
								focusField=whichField;
	
							focusCtr++;								
							returnState=false;
						
					}else if(dataType=="IP" && !isIP(fieldVal,required)){
							if(sysMsg){
							curMsg+='\n'+getMsg(dataType);	
							curMsg+=' on '+label+'.';
							}else
								curMsg+='\n'+label;
							if(focusCtr==0)
									focusField=whichField;
							
							focusCtr++;								
							returnState=false;
					}

			
			}

			if(alertMsg){
			if(focusCtr>0){
				alert(curMsg);
				eval('document.'+frmName+'.'+focusField+'.focus();');
			}
			}else{
				gblMsg=curMsg;
			}
		return returnState;
		}
		
		

/**
 * This function is used for conformation. Possible used at one shot database update.
 *@return void;
 */			
function confirmAction(url,message){
	if(confirm(message)){
//	alert("Clicked ok");
	window.location=url;
	}
}
		
/**
 * This function is used for redirect page.
 *@return void;
 */			
function _Redirect(url){
window.location=url;
}