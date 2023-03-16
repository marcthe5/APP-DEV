@extends('global_template') 
@section('title', 'Business Partner Management')

@section('content')

@include('bizpartner.css.bizpartner_css')
@include('bizpartner.js.bizpartner_controls')

<script type="text/javascript">
    function ui(id){ return sap.ui.getCore().byId(id); } 
    var go_App_Right = "";
    var go_App_Left = "";
    var go_SplitContainer = "";
    var labelWidth = "140px";
	var TextWidth ="auto";
    CreateContent();
</script>

 @endsection



 