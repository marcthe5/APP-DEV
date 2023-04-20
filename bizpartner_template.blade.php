@extends('global_template') 
@section('title', 'Business Partner Management')

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
        duration: 400,                  // default
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
        duration: 400,                  // default
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
    
    
</script>

 @endsection



 