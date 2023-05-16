@extends('global_template') 
@section('title', 'Delivery - APPDEV')

@section('content')

@include('bizpartner.css.AppDelivery_css')
@include('bizpartner.js.bizpartner_controls')
@include('bizpartner.js.bizpartner_databinding')

<script type="text/javascript">
    
    function ui(id){ return sap.ui.getCore().byId(id); } 
    function showBusyDialog(message){
        return new sap.m.BusyDialog({text:message});
    }
    function warning_notification (message) {
	
    return new sap.m.MessageToast.show(message, {
        duration: 600,                  // default
        my: "center center",             // default
        at: "center center",             // default
        of: window,                      // default
        offset: "0 0",                   // default
        collision: "fit fit",            // default
        onClose: null,                   // default
        autoClose: true,                 // default
        animationTimingFunction: "ease", // default
        animationDuration: 500,         // default
        closeOnBrowserNavigation: true   // default
        
        
        
    });
    
}
function proceed_notification (message) {
	
    return new sap.m.MessageToast.show(message, {
        duration: 600,                  // default
        my: "center center",             // default
        at: "center center",             // default
        of: window,                      // default
        offset: "0 0",                   // default
        collision: "fit fit",            // default
        onClose: null,                   // default
        autoClose: true,                 // default
        animationTimingFunction: "ease", // default
        animationDuration: 500,         // default
        closeOnBrowserNavigation: true   // default
        
        
        
    });
    
}
    var go_App_Right = "";
    var go_App_Left = "";
    var go_SplitContainer = "";
    var labelWidth = "140px";
	var TextWidth ="auto";
    
    $(document).ready(function(){
        CreateContent();
        ui('LEFT_MENU_TEMPLATE-MENU_LIST-0').firePress();
    })

    var gv_previous_livechange_time = new Date();
function fn_livechange_numeric_input(oEvt){
    var lv_control = oEvt.getSource();
    
    /* Check this input field if contains string then change to integer only */

    var lv_str_value = lv_control.getValue();
    var lv_numeric_pattern1 = /[^-0-9\.\,]+/g; //comma operator
    var lv_match_result = lv_str_value.match(lv_numeric_pattern1);

    //if non numeric character is entered, it will trigger fireChange - the fireChange will add the comma seperator
    if(lv_match_result && lv_match_result.length > 0){
        //remove the non nmeric characters
        lv_control.setValue(fn_convert_to_numeric(lv_str_value));

        //added by John to avoid retriggering of firechange when holding down a letter
        var lv_last_time = new Date();
        var lv_livechange_timediff = gv_previous_livechange_time.getTime() - lv_last_time.getTime();
         
        var lv_seconds_from_T1_to_T2 = lv_livechange_timediff / 1000;
        var lv_seconds_between_dates = Math.abs(lv_seconds_from_T1_to_T2);

        console.log("time difference for numeric livechange: " + lv_seconds_between_dates+ " seconds");
        //allow trigger fireChange if greater than 1 second
        if(lv_seconds_between_dates > 1){
            gv_previous_livechange_time = new Date();

            if(lv_control.getvalue().length > 0 && isNan(lv_control.getValue())){

                lv_control.setValue("0");

            }
            lv_control.fireChange();
        }
    }
}

    function fn_convert_to_numeric(lv_string){
        var lv_is_negative = false;
        //first char is a negative sign,
        if(lv_string.length > 0 && lv_string[0] == "-"){
            lv_is_negative = true;
        }
        var lv_replace_result = lv_string.replace(/[^0-9\.]+/g, "");

        if(lv_replace_result.length > 0 && lv_is_negative){
            lv_replace_result = "-" + lv_replace_result;
        }
        return lv_replace_result;
    }
</script>

 @endsection



 