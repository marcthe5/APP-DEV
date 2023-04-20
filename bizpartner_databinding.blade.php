<script>

	//let ID = ui("DELIVERY_ID").getValue();
    	var bizData = [
		{
			//dummy data
			DELIVERY_ID: "10001",
			DELIVERY_ADDRESS    : "Cebu City",
			EMP_NAME    			: "Juan De la Cruz",
			EMP_PHONE      	: "09123456789",
			EMP_EMAIL      	: "juan123@gmail.com",
			EMP_DELIVERY_DATE     		: "04/13/23",
            EMP_DELIVERY_TIME          : "07:00",
			EMP_DELIVERY_INSTRUCTION   : "Deliver at Arrival Time!",
			EMP_SHIPPING_METHOD: "COD",
			EMP_SHIPPING_CARRIER : "LBC",
            EMP_TRACKING_NUMBER:"12345",
			EMP_PACKAGE_WEIGHT:"10kg",
			EMP_PACKAGE_DIMENSION:"10x10",
			EMP_DELIVERY_CONFIRMATION:"true",
			EMP_SIGNATURE_REQUIRED	:"true",
			EMP_ORDER_NUMBER:"01",
			EMP_SHIPPING_COST:"100.00",
			EMP_INSURANCE:"50.00",
			EMP_CUSTOMS_INFO:"false",
			EMP_ORDER_STATUS:"Shipping"
		},
		
		
	];

	const bpDataOrganizer = {
		_filteredById : function(id){
			filteredBP = [];
			for(let i=0; i<bizData.length; i++){
				if(bizData[i].DELIVERY_ID == id){
					filteredBP.push(bizData[i]);
				}
			}
			return filteredBP;
		},
		_updateById : function(id){
			let busyDialog = showBusyDialog("Directing to Table Data..");
				busyDialog.open();
			
				/** GET CUSTOMER INFO BY ID as PRIMARY KEY to DATABASE */
			bizData.map(bp_id => {
				if (bp_id.DELIVERY_ID == id) {
				 
						bp_id.DELIVERY_ADDRESS    			= ui('DELIVERY_ADDRESS').getValue().trim();
						bp_id.EMP_NAME     			= ui('EMP_NAME').getValue();
						bp_id.EMP_PHONE    			= ui('EMP_PHONE').getValue().trim();
						bp_id.EMP_EMAIL      	= ui('EMP_EMAIL').getValue().trim();
						bp_id.EMP_DELIVERY_DATE      	= ui('EMP_DELIVERY_DATE').getValue().trim();
						bp_id.EMP_DELIVERY_TIME     	= ui('EMP_DELIVERY_TIME').getValue().trim();
						bp_id.EMP_DELIVERY_INSTRUCTION    		= ui('EMP_DELIVERY_INSTRUCTION').getValue().trim();
						bp_id.EMP_SHIPPING_METHOD    		= ui('EMP_SHIPPING_METHOD').getSelectedKey().trim();
						bp_id.EMP_SHIPPING_CARRIER    		= ui('EMP_SHIPPING_CARRIER').getValue().trim();
						bp_id.EMP_TRACKING_NUMBER    		= ui('EMP_TRACKING_NUMBER').getValue().trim();
						bp_id.EMP_PACKAGE_WEIGHT    		= ui('EMP_PACKAGE_WEIGHT').getValue().trim();
						bp_id.EMP_PACKAGE_DIMENSION    		= ui('EMP_PACKAGE_DIMENSION').getValue().trim();
						bp_id.EMP_DELIVERY_CONFIRMATION    		= ui('EMP_DELIVERY_CONFIRMATION').getValue().trim();
						bp_id.EMP_SIGNATURE_REQUIRED    		= ui('EMP_SIGNATURE_REQUIRED').getValue().trim();
						bp_id.EMP_ORDER_NUMBER    		= ui('EMP_ORDER_NUMBER').getValue().trim();
						bp_id.EMP_SHIPPING_COST    		= ui('EMP_SHIPPING_COST').getValue().trim();
						bp_id.EMP_INSURANCE    		= ui('EMP_INSURANCE').getValue().trim();
						bp_id.EMP_CUSTOMS_INFO    		= ui('EMP_CUSTOMS_INFO').getValue().trim();
						bp_id.EMP_ORDER_STATUS    		= ui('EMP_ORDER_STATUS').getValue().trim();


						
				}
				
			});
			screenMode._display(id);
			listingBp._getData(bizData);
			setTimeout(() => {busyDialog.close();}, 2000);
		},
		_validate: function(id){
			let existID = false;
			for(let i=0; i<bizData.length; i++){
				if(bizData[i].DELIVERY_ID == id){
					existID = true;
				}
			}

			return existID;

		}
	}

	const screenMode = {
		_id : "",
		_title : "",
		_mode : "",
		_create : function(){
			this._mode = "create";
			let bp_title = this._title;
			bp_title = "Create Delivery Partner";
			//this._clear();
			//Buttons
			ui("CREATE_BP_SAVE_BTN").setVisible(true);
			ui("CREATE_BP_EDIT_BTN").setVisible(false);
			ui("CREATE_BP_CANCEL_BTN").setVisible(false);

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
			ui("CREATE_BP_CANCEL_BTN").setVisible(true);

			//Fields
			/*
			ui('BP_TYPE_INFO').setEditable(true);
			ui('BP_TYPE_REGNAME').setEditable(true);
			ui('INPUT_BP_ID').setEditable(false);
			ui('BP_TYPE_EXTPARTNER').setEditable(true);
			ui('INPUT_CONTROL_INFO_SOURCE_SYS').setEditable(true);
			ui('CONTROL_INFO_DEL_FLAG').setEnabled(true);
			*/
		},
		_display : function(id){
			this._mode = "display";
			this._id = id;
			let bp_title = this._title;
			bp_title = "Display Delivery Partner";
			//Buttons
			ui("CREATE_BP_SAVE_BTN").setVisible(false);
			ui("CREATE_BP_EDIT_BTN").setVisible(true);
			ui("CREATE_BP_CANCEL_BTN").setVisible(false);


			//fields with value
			let data = bpDataOrganizer._filteredById(id);
			if(data.length > 0){
				ui('DELIVERY_ID').setValue(data[0].DELIVERY_ID).setEditable(false);
       			ui('DELIVERY_ADDRESS').setValue(data[0].DELIVERY_ADDRESS).setEditable(false);
        		ui('EMP_NAME').setValue(data[0].EMP_NAME).setEditable(false);
				ui('EMP_PHONE').setValue(data[0].EMP_PHONE).setEditable(false);
				ui('EMP_EMAIL').setValue(data[0].EMP_EMAIL).setEditable(false);
				ui('EMP_DELIVERY_DATE').setValue(data[0].EMP_DELIVERY_DATE).setEditable(false);
				ui('EMP_DELIVERY_TIME').setValue(data[0].EMP_DELIVERY_TIME).setEditable(false);
				ui('EMP_DELIVERY_INSTRUCTION').setValue(data[0].EMP_DELIVERY_INSTRUCTION).setEditable(false);
				//ui('EMP_SHIPPING_METHOD').setValue(data[0].EMP_SHIPPING_METHOD).setEditable(false);
				ui('EMP_SHIPPING_CARRIER').setValue(data[0].EMP_SHIPPING_CARRIER).setEditable(false);
				ui('EMP_TRACKING_NUMBER').setValue(data[0].EMP_TRACKING_NUMBER).setEditable(false);
				ui('EMP_PACKAGE_WEIGHT').setValue(data[0].EMP_PACKAGE_WEIGHT).setEditable(false);
				ui('EMP_PACKAGE_DIMENSION').setValue(data[0].EMP_PACKAGE_DIMENSION).setEditable(false);
				ui('EMP_DELIVERY_CONFIRMATION').setValue(data[0].EMP_DELIVERY_CONFIRMATION).setEditable(false);
				ui('EMP_SIGNATURE_REQUIRED').setValue(data[0].EMP_SIGNATURE_REQUIRED).setEditable(false);
				ui('EMP_ORDER_NUMBER').setValue(data[0].EMP_ORDER_NUMBER).setEditable(false);
				ui('EMP_SHIPPING_COST').setValue(data[0].EMP_SHIPPING_COST).setEditable(false);
				ui('EMP_INSURANCE').setValue(data[0].EMP_INSURANCE).setEditable(false);
				ui('EMP_CUSTOMS_INFO').setValue(data[0].EMP_CUSTOMS_INFO).setEditable(false);
				ui('EMP_ORDER_STATUS').setValue(data[0].EMP_ORDER_STATUS).setEditable(false);

			
			
				//title and crumbs
				//ui('BP_TITLE').setText(bp_title);
				//ui('CREATE_BP_BRDCRMS').setCurrentLocationText(bp_title);
				//ui("PANEL_FORM").setTitle("Business Partner ID "+"("+data[0].BIZPART_ID+")");

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
	const modal_idExist = ()=> {
		//open modal after save button
		let busyDialog = showBusyDialog("ID EXIST!");
				busyDialog.open();
				//go_App_Right.to('BP_PAGE_DISPLAY');
				setTimeout(() => {busyDialog.close();}, 2000);
	}
    const createBP = ()=> {
		//open modal after save button
		proceed_notification("Directing to Table Data....");
				go_App_Right.to('BP_PAGE_DISPLAY');


    let createBPdetails = {
       
		
		DELIVERY_ID: ui("DELIVERY_ID").getValue().trim(),
        DELIVERY_ADDRESS : ui("DELIVERY_ADDRESS").getValue().trim(),
        EMP_NAME : ui("EMP_NAME").getValue().trim(),
        EMP_PHONE : ui("EMP_PHONE").getValue().trim(),
        EMP_EMAIL : ui("EMP_EMAIL").getValue().trim(),
        EMP_DELIVERY_DATE : ui("EMP_DELIVERY_DATE").getValue().trim(),
        EMP_DELIVERY_TIME : ui("EMP_DELIVERY_TIME").getValue().trim(),
        EMP_DELIVERY_INSTRUCTION : ui("EMP_DELIVERY_INSTRUCTION").getValue().trim(),
        EMP_SHIPPING_METHOD: ui("EMP_SHIPPING_METHOD").getSelectedKey().trim(),
        EMP_SHIPPING_CARRIER : ui("EMP_SHIPPING_CARRIER").getValue().trim(),
        EMP_TRACKING_NUMBER : ui("EMP_TRACKING_NUMBER").getValue().trim(),
        EMP_PACKAGE_WEIGHT : ui("EMP_PACKAGE_WEIGHT").getValue().trim(),
        EMP_PACKAGE_DIMENSION: ui("EMP_PACKAGE_DIMENSION").getValue().trim(),
        EMP_DELIVERY_CONFIRMATION: ui("EMP_DELIVERY_CONFIRMATION").getValue().trim(),
        EMP_SIGNATURE_REQUIRED: ui("EMP_SIGNATURE_REQUIRED").getValue().trim(),
        EMP_ORDER_NUMBER: ui("EMP_ORDER_NUMBER").getValue().trim(),
        EMP_SHIPPING_COST: ui("EMP_SHIPPING_COST").getValue().trim(),
        EMP_INSURANCE: ui("EMP_INSURANCE").getValue().trim(),
        EMP_CUSTOMS_INFO: ui("EMP_CUSTOMS_INFO").getValue().trim(),
        EMP_ORDER_STATUS: ui("EMP_ORDER_STATUS").getValue().trim(),

    };
	/** SEND INPUTTED DATA to TABLE DATA */
	//if(createBPdetails.DELIVERY_ID!= ui("DELIVERY_ID").getValue()){
        bizData.push(createBPdetails);
		screenMode._display(createBPdetails.DELIVERY_ID);
		setTimeout(() => {busyDialog.close();}, 2000);
	//}
	
    
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
	ui("CREATE_BP_CANCEL_BTN").setVisible(true);


    ui("DELIVERY_ID").setEditable(false);

    ui("DELIVERY_ADDRESS").setEditable(true);
    ui("EMP_NAME").setEditable(true);
    ui("EMP_PHONE").setEditable(true);
    ui("EMP_EMAIL").setEditable(true);
    ui("EMP_DELIVERY_DATE").setEditable(true);
    ui("EMP_DELIVERY_TIME").setEditable(true);
    ui("EMP_DELIVERY_INSTRUCTION").setEditable(true);
   // ui("EMP_SHIPPING_METHOD").setEditable(true);
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


const onCancel = () => {

	ui("CREATE_BP_SAVE_BTN").setVisible(false);
	ui("CREATE_BP_EDIT_BTN").setVisible(true);
	ui("CREATE_BP_CANCEL_BTN").setVisible(false);

	ui("DELIVERY_ID").setEditable(false);

ui("DELIVERY_ADDRESS").setEditable(false);
ui("EMP_NAME").setEditable(false);
ui("EMP_PHONE").setEditable(false);
ui("EMP_EMAIL").setEditable(false);
ui("EMP_DELIVERY_DATE").setEditable(false);
ui("EMP_DELIVERY_TIME").setEditable(false);
ui("EMP_DELIVERY_INSTRUCTION").setEditable(false);
//ui("EMP_SHIPPING_METHOD").setEditable(false);
ui("EMP_SHIPPING_CARRIER").setEditable(false);
ui("EMP_TRACKING_NUMBER").setEditable(false);
ui("EMP_PACKAGE_WEIGHT").setEditable(false);
ui("EMP_PACKAGE_DIMENSION").setEditable(false);
ui("EMP_DELIVERY_CONFIRMATION").setEditable(false);
ui("EMP_SIGNATURE_REQUIRED").setEditable(false);
ui("EMP_ORDER_NUMBER").setEditable(false);
ui("EMP_SHIPPING_COST").setEditable(false);
ui("EMP_INSURANCE").setEditable(false);
ui("EMP_CUSTOMS_INFO").setEditable(false);
ui("EMP_ORDER_STATUS").setEditable(false);
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
			
			ui('BP_LISTING_LABEL').setText("Delivery Partner (" + data.length + ")");
		}
	}


	const emptyFields = () => {
		ui('DELIVERY_ID').setValue("").setEditable(true);
		ui('DELIVERY_ADDRESS').setValue("").setEditable(true);
		ui('EMP_NAME').setValue("").setEditable(true);
		ui('EMP_PHONE').setValue("").setEditable(true);
		ui('EMP_EMAIL').setValue("").setEditable(true);
		ui('EMP_DELIVERY_DATE').setValue("").setEditable(true);
		ui('EMP_DELIVERY_TIME').setValue("").setEditable(true);
		ui('EMP_DELIVERY_INSTRUCTION').setValue("").setEditable(true);
		ui('EMP_SHIPPING_METHOD').setSelectedKey("").setEditable(true);
		ui('EMP_SHIPPING_CARRIER').setValue("").setEditable(true);
		ui('EMP_TRACKING_NUMBER').setValue("").setEditable(true);
		ui('EMP_PACKAGE_WEIGHT').setValue("").setEditable(true);
		ui('EMP_PACKAGE_DIMENSION').setValue("").setEditable(true);
		ui('EMP_DELIVERY_CONFIRMATION').setValue("").setEditable(true);
		ui('EMP_SIGNATURE_REQUIRED').setValue("").setEditable(true);
		ui('EMP_ORDER_NUMBER').setValue("").setEditable(true);
		ui('EMP_SHIPPING_COST').setValue("").setEditable(true);
		ui('EMP_INSURANCE').setValue("").setEditable(true);
		ui('EMP_CUSTOMS_INFO').setValue("").setEditable(true);
		ui('EMP_ORDER_STATUS').setValue("").setEditable(true);

	}



    </script>