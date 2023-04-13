<script>
    	var bizData = [
		{
			DELIVERY_ID: "10001",
			DeliveryAddress    : "Cebu City",
			ContactName    			: "Juan De la Cruz",
			ContactPhoneNumber      	: "091234567",
			EmailAddress      	: "juan123@gmail.com",
			DeliveryDate     		: "04/13/23",
            DeliveryTime          : "07:00",
			DeliveryInstructions   : "true",
 

            
		},
		{
			TYPE     			: "ACT",
			NAME1    			: "Noel Lehitimasss2",
			BIZPART_ID      	: "100002",
			EXT_PARTNER      	: "EXT_PARTNER2",
			SOURCE_SYS     		: "SOURCESYS2",
			DEL_FLAG    		: true
		},
		
	];

	const bpDataOrganizer = {
		_filteredById : function(id){
			filteredBP = [];
			for(let i=0; i<bizData.length; i++){
				if(bizData[i].BIZPART_ID == id){
					filteredBP.push(bizData[i]);
				}
			}
			return filteredBP;
		},
		_updateById : function(id){
			let busyDialog = showBusyDialog("Please wait loading..");
				busyDialog.open();
			
			bizData.map(bp_id => {
				if (bp_id.BIZPART_ID == id) {
				 
						bp_id.NAME1    			= ui('BP_TYPE_REGNAME').getValue().trim();
						bp_id.TYPE     			= ui('BP_TYPE_INFO').getSelectedKey();
						bp_id.NAME1    			= ui('BP_TYPE_REGNAME').getValue().trim();
						bp_id.BIZPART_ID      	= ui('INPUT_BP_ID').getValue().trim();
						bp_id.EXT_PARTNER      	= ui('BP_TYPE_EXTPARTNER').getValue().trim();
						bp_id.SOURCE_SYS     	= ui('INPUT_CONTROL_INFO_SOURCE_SYS').getValue().trim();
						bp_id.DEL_FLAG    		= ui('CONTROL_INFO_DEL_FLAG').getState();
				}
				
			});
			screenMode._display(id);
			listingBp._getData(bizData);
			setTimeout(() => {busyDialog.close();}, 2000);
		}
	}

	const screenMode = {
		_id : "",
		_title : "",
		_mode : "",
		_create : function(){
			this._mode = "create";
			let bp_title = this._title;
			bp_title = "Create Business Partner";
			//this._clear();
			//Buttons
			ui("CREATE_BP_SAVE_BTN").setVisible(true);
			ui("CREATE_BP_EDIT_BTN").setVisible(false);
			//ui("CREATE_BP_CANCEL_BTN").setVisible(false);

			//title and crumbs
			///ui('BP_TITLE').setText(bp_title);
			///ui('CREATE_BP_BRDCRMS').setCurrentLocationText(bp_title);
			//ui("PANEL_FORM").setTitle("New Business Partner");

			//Fields
			//ui('BP_TYPE_INFO').setEditable(true);
			//ui('BP_TYPE_REGNAME').setEditable(true);
			//ui('INPUT_BP_ID').setEditable(true);
			//ui('BP_TYPE_EXTPARTNER').setEditable(true);
			//ui('INPUT_CONTROL_INFO_SOURCE_SYS').setEditable(true);
			

			go_App_Right.to('CREATE_BP_PAGE');
		},
		_edit : function(){
			this._mode = "edit";
			//Buttons
			ui("CREATE_BP_SAVE_BTN").setVisible(true);
			ui("CREATE_BP_EDIT_BTN").setVisible(false);
			//ui("CREATE_BP_CANCEL_BTN").setVisible(true);

			//Fields
			ui('BP_TYPE_INFO').setEditable(true);
			ui('BP_TYPE_REGNAME').setEditable(true);
			ui('INPUT_BP_ID').setEditable(false);
			ui('BP_TYPE_EXTPARTNER').setEditable(true);
			ui('INPUT_CONTROL_INFO_SOURCE_SYS').setEditable(true);
			ui('CONTROL_INFO_DEL_FLAG').setEnabled(true);
		},
		_display : function(id){
			this._mode = "display";
			this._id = id;
			let bp_title = this._title;
			bp_title = "Display Business Partner";
			//Buttons
			ui("CREATE_BP_SAVE_BTN").setVisible(false);
			ui("CREATE_BP_EDIT_BTN").setVisible(true);
		//	ui("CREATE_BP_CANCEL_BTN").setVisible(false);


			//fields with value
			let data = bpDataOrganizer._filteredById(id);
			if(data.length > 0){
				ui('BP_TYPE_INFO').setSelectedKey(data[0].TYPE).setEditable(false);
       			ui('BP_TYPE_REGNAME').setValue(data[0].NAME1).setEditable(false);
        		ui('INPUT_BP_ID').setValue(data[0].BIZPART_ID).setEditable(false);
				ui('BP_TYPE_EXTPARTNER').setValue(data[0].EXT_PARTNER).setEditable(false);
				ui('INPUT_CONTROL_INFO_SOURCE_SYS').setValue(data[0].SOURCE_SYS).setEditable(false);
				ui('CONTROL_INFO_DEL_FLAG').setState(data[0].DEL_FLAG).setEnabled(false);
			
			
				//title and crumbs
				ui('BP_TITLE').setText(bp_title);
				ui('CREATE_BP_BRDCRMS').setCurrentLocationText(bp_title);
				ui("PANEL_FORM").setTitle("Business Partner ID "+"("+data[0].BIZPART_ID+")");

				go_App_Right.to('CREATE_BP_PAGE');
			}			
		},
		_clear : function(){
			ui('BP_TYPE_INFO').setValue("");
			ui('BP_TYPE_REGNAME').setValue("");
			ui('INPUT_BP_ID').setValue("");
			ui('BP_TYPE_EXTPARTNER').setValue("");
			ui('INPUT_CONTROL_INFO_SOURCE_SYS').setValue("");
			ui('CONTROL_INFO_DEL_FLAG').setEnabled(true);
		}
	
	
	};
    const createBP = ()=> {
		let busyDialog = showBusyDialog("Please wait loading..");
				busyDialog.open();
    let createBPdetails = {
       
		DELIVERY_ID: ui("DELIVERY_ID").getValue().trim(),
        APPDEV_TYPE : ui("DELIVERY_ADDRESS").getValue().trim(),
        APPDEV_NAME : ui("EMP_NAME").getValue().trim(),
        APPDEV_NUMBER : ui("EMP_PHONE").getValue().trim(),
        APPDEV_EMAIL : ui("EMP_EMAIL").getValue().trim(),
        APPDEV_DELIVERDATE : ui("EMP_DELIVERY_DATE").getValue().trim(),
        APPDEV_DELIVERYTIME : ui("EMP_DELIVERY_TIME").getValue().trim(),
        APPDEV_DELIVERYINSTRUCTION : ui("EMP_DELIVERY_INSTRUCTION").getValue().trim(),
        APPDEV_SHIPMETHOD: ui("EMP_SHIPPING_METHOD").getValue().trim(),
        APPDEV_SHIPCARRIER : ui("EMP_SHIPPING_CARRIER").getValue().trim(),
        APPDEV_TRACKNUM : ui("EMP_TRACKING_NUMBER").getValue().trim(),
        APPDEV_PACKWEIGHT : ui("EMP_PACKAGE_WEIGHT").getValue().trim(),
        APPDEV_PACKDIMENSION: ui("EMP_PACKAGE_DIMENSION").getValue().trim(),
        APPDEV_DELIVERYCONFIRM: ui("EMP_DELIVERY_CONFIRMATION").getValue().trim(),
        APPDEV_SIGNATURE: ui("EMP_SIGNATURE_REQUIRED").getValue().trim(),
        APPDEV_ORDERNUM: ui("EMP_ORDER_NUMBER").getValue().trim(),
        APPDEV_SHIPCOST: ui("EMP_SHIPPING_COST").getValue().trim(),
        APPDEV_INSURANCE: ui("EMP_INSURANCE").getValue().trim(),
        APPDEV_CUSTOMSINFO: ui("EMP_CUSTOMS_INFO").getValue().trim(),
        APPDEV_ORDERSTATUS: ui("EMP_ORDER_STATUS").getValue().trim(),

    };
        bizData.push(createBPdetails);
		screenMode._display(createBPdetails.DELIVERY_ID);
		setTimeout(() => {busyDialog.close();}, 2000);
   
    
    /*ui("DELIVERY_ADDRESS").setValue(createBPdetails.APPDEV_TYPE).setEditable(false).addStyleClass('deliveryInput');
    ui("EMP_NAME").setValue(createBPdetails.APPDEV_NAME).setEditable(false);
    ui("EMP_PHONE").setValue(createBPdetails.APPDEV_NUMBER).setEditable(false);
    ui("EMP_EMAIL").setValue(createBPdetails.APPDEV_EMAIL).setEditable(false);
    ui("EMP_DELIVERY_DATE").setValue(createBPdetails.APPDEV_DELIVERYDATE).setEditable(false);
    ui("EMP_DELIVERY_TIME").setValue(createBPdetails.APPDEV_DELIVERYTIME).setEditable(false);
    ui("EMP_DELIVERY_INSTRUCTION").setValue(createBPdetails.APPDEV_DELIVERYINSTRUCTION).setEditable(false);
    ui("EMP_SHIPPING_METHOD").setValue(createBPdetails.APPDEV_SHIPMETHOD).setEditable(false);
    ui("EMP_SHIPPING_CARRIER").setValue(createBPdetails.APPDEV_SHIPCARRIER).setEditable(false);
    ui("EMP_TRACKING_NUMBER").setValue(createBPdetails.APPDEV_TRACKNUM).setEditable(false);
    ui("EMP_PACKAGE_WEIGHT").setValue(createBPdetails.APPDEV_PACKWEIGHT).setEditable(false);
    ui("EMP_PACKAGE_DIMENSION").setValue(createBPdetails.APPDEV_PACKDIMENSION).setEditable(false);
    ui("EMP_DELIVERY_CONFIRMATION").setValue(createBPdetails.APPDEV_DELIVERYCONFIRM).setEditable(false);
    ui("EMP_SIGNATURE_REQUIRED").setValue(createBPdetails.APPDEV_SIGNATURE).setEditable(false);
    ui("EMP_ORDER_NUMBER").setValue(createBPdetails.APPDEV_ORDERNUM).setEditable(false);
    ui("EMP_SHIPPING_COST").setValue(createBPdetails.APPDEV_SHIPCOST).setEditable(false);
    ui("EMP_INSURANCE").setValue(createBPdetails.APPDEV_INSURANCE).setEditable(false);
    ui("EMP_CUSTOMS_INFO").setValue(createBPdetails.APPDEV_CUSTOMSINFO).setEditable(false);
    ui("EMP_ORDER_STATUS").setValue(createBPdetails.APPDEV_ORDERSTATUS).setEditable(false);*/
}

const onEdit = () => {

	ui("CREATE_BP_SAVE_BTN").setVisible(true);
	ui("CREATE_BP_EDIT_BTN").setVisible(false);

    ui("DELIVERY_ID").setEditable(false);

    ui("DELIVERY_ADDRESS").setEditable(true);
    ui("EMP_NAME").setEditable(true);
    ui("EMP_PHONE").setEditable(true);
    ui("EMP_EMAIL").setEditable(true);
    ui("EMP_DELIVERY_DATE").setEditable(true);
    ui("EMP_DELIVERY_TIME").setEditable(true);
    ui("EMP_DELIVERY_INSTRUCTION").setEditable(true);
    ui("EMP_SHIPPING_METHOD").setEditable(true);
    ui("EMP_SHIPPING_CARRIER").setEditable(true);
    ui("EMP_TRACKING_NUMBER").setEditable(true);
    ui("EMP_PACKAGE_WEIGHT").setEditable(true);
    ui("EMP_PACKAGE_DIMENSION").setEditable(true);
    ui("EMP_DELIVERY_CONFIRMATION").setEditable(true);
    ui("EMP_SIGNATURE_REQUIRED").setEditable(true);
    ui("EMP_ORDER_NUMBER").setEditable(true);
    ui("EMP_SHIPPING_COST").setEditable(true);
    ui("EMP_INSURANCE").setEditable(true);
    ui("EMP_CUSTOMS_INFO").setEditable(true);
    ui("EMP_ORDER_STATUS").setEditable(true);
}

function showBusyDialog(message){
return new sap.m.BusyDialog({text : message});
}



var lv_dialog_save = new sap.m.Dialog("COMPCODE_SAVE_DIALOG",{
title: "Confirmation",
beginButton: new sap.m.Button({
text:"Ok",
type:"Accept",
icon:"sap-icon://accept",
press:function(oEvt){
oEvt.getSource().getParent().close();
}
}),
endButton:new sap.m.Button({
text:"Cancel",
type:"Reject",
icon:"sap-icon://decline",
press:function(oEvt){
oEvt.getSource().getParent().close();
}
}),
content:[
new sap.m.HBox({
items:[
new sap.m.Label({text:"Confirm to create changes?"})
]
})
]
}).addStyleClass('sapUiSizeCompact');

//Table Binding:
const displayBp =  {
_get_data(search){
//var busy_diag = fn_show_busy_dialog("Please wait. Loading...");
//busy_diag.open();
const dataforDisplayBP = [
{
BIZPART_ID  : "10001",
NAME1       : "Noel Lehitimas",
NAME2       : "The Great Buhay Igit"
},
{
BIZPART_ID  : "10002",
NAME1       : "Noel Lehitimas2",
NAME2       : "The Great Buhay Igit2"
}
];
this._bind_data(dataforDisplayBP);
//busy_diag.close();
},
_bind_data(data){
ui("DISPLAY_BP_TABLE").unbindRows();
var lt_model = new sap.ui.model.json.JSONModel();
lt_model.setSizeLimit(data.length);
lt_model.setData(data);
ui('DISPLAY_BP_TABLE').setModel(lt_model).bindRows("/");
ui("DISPLAY_BP_TABLE").setVisible(true);
ui('DISPLAY_BP_TABLE_LABEL').setText("List (" + data.length + ")");
//fn_clear_table_sorter("DISPLAY_BP_TABLE");
}
};

const listingBp = {
		_getData : function(data){
			ui("BP_LISTING_TABLE").unbindRows();
			
			var lt_model = new sap.ui.model.json.JSONModel();
				lt_model.setSizeLimit(data.length);
				lt_model.setData(data);
				
			ui('BP_LISTING_TABLE').setModel(lt_model).bindRows("/");
			ui("BP_LISTING_TABLE").setVisible(true);
			
			ui('BP_LISTING_LABEL').setText("Business Partner (" + data.length + ")");
		}
	}



    </script>