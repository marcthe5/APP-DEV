<script>
    
    function CreateContent(){
        var go_Shell = new sap.m.Shell({});
        //left page
        go_App_Left = new sap.m.App({});
        go_App_Left.addPage(create_page_menu());
		
        //right page
        go_App_Right = new sap.m.App({});
        go_App_Right.addPage(createBizPage());	
		go_App_Right.addPage(createDisplayBizPage());	
		go_App_Right.addPage(createListBP());
        go_SplitContainer = new sap.ui.unified.SplitContainer({ content: [go_App_Right], secondaryContent: [go_App_Left]});		
        go_SplitContainer.setSecondaryContentWidth("250px");
        go_SplitContainer.setShowSecondaryContent(true);
        
        let go_App = new sap.m.App({
            pages : [go_SplitContainer]
        });
        go_Shell.setApp(go_App);
        go_Shell.setAppWidthLimited(false);
        go_Shell.placeAt("content");     
    }
    function create_page_menu(){
        let page = new sap.m.Page({}).addStyleClass('sapUiSizeCompact');
        let pageHeader  = new sap.m.Bar({enableFlexBox: false,contentMiddle:[ new sap.m.Label({text:"Action"})]})
        const menuList = new sap.m.List("MENU_LIST",{});
		const menuListTemplate = new sap.m.StandardListItem("LEFT_MENU_TEMPLATE",{
			title:"{title}",
			icon:"{icon}",
			visible:"{visible}",
			type: sap.m.ListType.Active,
			press:function(oEvent){
				
             let menu =  oEvent.getSource().getBindingContext().getProperty('funct');
				switch(menu){
					case "create_delivery" :
						go_App_Right.to('CREATE_BP_PAGE');
						emptyFields();
						//after click DELIVERY-button > empty input fields
						//emptyFields();
						
						screenMode._create();
					break;
					case "display_delivery" :
						go_App_Right.to('BP_PAGE_DISPLAY');
					break;
					case "delivery_listing" :
						listingBp._getData(bizData);
						go_App_Right.to('PAGE_BP_LISTING');
					break;
					
				}
			}
		});
		
        const gt_list = [
                {
                    title   : "Main Page",
                    icon    : "sap-icon://course-program",
                    visible : true,
					funct   :"create_delivery"
		
                },
                {
                    title   : "Lookup User",
                    icon    : "sap-icon://employee-lookup",
                    visible : true,
					funct   :"display_delivery"
                },
                {
                    title   : "Data Table",
                    icon    : "sap-icon://bar-chart",
                    visible : true,
					funct   :"delivery_listing"
				}
                
        ];
        let model = new sap.ui.model.json.JSONModel();
			model.setSizeLimit(gt_list.length);
			model.setData(gt_list);
			ui('MENU_LIST').setModel(model).bindAggregation("items",{
				path:"/",
				template:ui('LEFT_MENU_TEMPLATE')
			});
		
        page.setCustomHeader(pageHeader);
		page.addContent(menuList);		
		return page;
    	
	}
	
    function createBizPage(){
        let page  = new sap.m.Page("CREATE_BP_PAGE",{}).addStyleClass('sapUiSizeCompact');
        let pageHeader = new sap.m.Bar("",{  
			enableFlexBox: false,
			contentLeft:[
				new sap.m.Button({ icon:"sap-icon://nav-back",
					press:function(oEvt){
						
					} 
				}),
				new sap.m.Button({icon:"sap-icon://menu2",
					press:function(){
						go_SplitContainer.setSecondaryContentWidth("250px");
						if(!go_SplitContainer.getShowSecondaryContent()){
							go_SplitContainer.setShowSecondaryContent(true);
						} else {							
							go_SplitContainer.setShowSecondaryContent(false);
						}
					
					}
				}), 
				
			],
			contentMiddle:[
                new sap.m.Label("",{text:"APPDEV - DELIVERY"})
            ],
		
		});
        let crumbs = new sap.m.Breadcrumbs("CREATE_BP_BRDCRMS",{
            currentLocationText: "CRUD-DELIVERY",
            links: [
                new sap.m.Link({
                    text:"Home",
                    press:function(oEvt){
                       // fn_click_breadcrumbs("HOME");
                    }
                }),
				new sap.m.Link("CREATE_BP_BRDCRMS_TITLE",{
                    text:"APPLICATION DEVELOPMENT",
                    press:function(oEvt){
                      //  fn_click_breadcrumbs("HOME");
                    }
                }),
				
            ]
        });
		
        let createPageForm = new sap.uxap.ObjectPageLayout({
            headerTitle:[
                new sap.uxap.ObjectPageHeader("OBJECTHEADER_BP_NAME",{
                    objectTitle:"INFORMATION FORM",
					showPlaceholder : false,
					actions:[
                        new sap.uxap.ObjectPageHeaderActionButton("CREATE_BP_SAVE_BTN",{
                            icon: "sap-icon://save",
							
							press: function(){
                            								
							let id = ui("DELIVERY_ID").getValue().trim();
							if(id){
								if(screenMode._mode == "create"){
						    		let exist = bpDataOrganizer._validate(id);
									if(exist){
										warning_notification("ID EXIST!");			
								    }
									else{
										createBP();
										go_App_Right.to('PAGE_BP_LISTING');
								
									}
								}
								else{
									bpDataOrganizer._updateById(screenMode.id);
								}		
						    }
							else{
								warning_notification("DELIVERY ID IS REQUIRED");
							}
			
						
                            }
                        }).addStyleClass("sapMTB-Transparent-CTX"),
                        new sap.uxap.ObjectPageHeaderActionButton("CREATE_BP_EDIT_BTN",{
                            icon: "sap-icon://edit",
							press: function(){
							
							//function call 
							onEdit();
						
					}
                        }).addStyleClass("sapMTB-Transparent-CTX"),
						
					new sap.uxap.ObjectPageHeaderActionButton("CREATE_BP_CANCEL_BTN",{
                            icon: "sap-icon://decline",
							press: function(){
							
							//function call 
							//onCancel();
							screenMode._display(screenMode._id);
						
					}
                        }).addStyleClass("sapMTB-Transparent-CTX"),
                    ],
                })
            ],
            sections:[
                new sap.uxap.ObjectPageSection("GENERAL_DATA_TAB",{
                    title: "Customer Info",
                    subSections : [
                        new sap.uxap.ObjectPageSubSection({
                            title: "",
							blocks:[
                                new sap.m.Panel({
                                    content: [
                                        new sap.ui.layout.Grid({
                                            defaultSpan:"L12 M12 S12",
											width:"auto",
											content:[
                                                new sap.ui.layout.form.SimpleForm({
                                                    maxContainerCols:2,
													labelMinWidth:130,
													content:[
														/* LEFT PANEL */
														
                                                        new sap.ui.core.Title("GENERAL_INFO_TITLE1",{text:""}),
														new sap.m.Label({text:"Delivery ID",width:"130px"}).addStyleClass('class_label_padding'),
														new sap.m.Input("DELIVERY_ID",{
															value:"", 
									              			width:TextWidth,
															liveChange: function(oEvt){
															fn_livechange_numeric_input(oEvt);
																},
															change : function(oEvt){
															let lv_value = oEvt.getSource().getValue().trim();
															let lv_bpid = lv_value;
										
																					}
															}),
															
									
														
                                                        new sap.m.Label({text:"Delivery Address",width:"130px"}).addStyleClass('class_label_padding'),
														new sap.m.Input("DELIVERY_ADDRESS",{
															placeholder:"", 
															width:TextWidth, 
															
														}),														
                                                        new sap.m.Label({text:"Contact Name",width:"130px"}).addStyleClass('class_label_padding'),
														new sap.m.Input("EMP_NAME",{placeholder:"",value:"", width:TextWidth, editable:true}),
                                                        new sap.m.Label({text:"Contact Phone Number",width:"130px"}).addStyleClass('class_label_padding'),
														new sap.m.Input("EMP_PHONE",{placeholder:"",value:"63", editable:true,  value:"", 
									              			width:TextWidth,
															liveChange: function(oEvt){
															fn_livechange_numeric_input(oEvt);
																},
															change : function(oEvt){
															let lv_value = oEvt.getSource().getValue().trim();
															let lv_bpid = lv_value;
										
																					}}),
														new sap.m.Label({text:"Email Address",width:"130px"}).addStyleClass('class_label_padding'),
														new sap.m.Input("EMP_EMAIL",{placeholder:"",value:"", width:TextWidth, editable:true}),
														new sap.m.Label({text:"Delivery Date",width:"130px"}).addStyleClass('class_label_padding'),
														new sap.m.Input("EMP_DELIVERY_DATE",{placeholder:"",value:"", width:TextWidth,
															type: "Date",
															 editable:true}),
														new sap.m.Label({text:"Delivery Time",width:"130px"}).addStyleClass('class_label_padding'),
														new sap.m.Input("EMP_DELIVERY_TIME",{placeholder:"",value:"", width:TextWidth,
															type: "Time",
															 editable:true}),
														new sap.m.Label({text:"Delivery Instructions",width:"130px"}).addStyleClass('class_label_padding'),
														new sap.m.Input("EMP_DELIVERY_INSTRUCTION",{placeholder:"",value:"", width:TextWidth, editable:true}),
														new sap.m.Label({text:"Shipping Method",width:"130px"}).addStyleClass('class_label_padding'),
														new sap.m.Select("EMP_SHIPPING_METHOD",{
															items : [
																new sap.ui.core.ListItem({
																	text:"COD",
																	key: "COD",
																	icon: "sap-icon://loan",
																	additionalText:"COD",
																}),	
																new sap.ui.core.ListItem({
																	text:"BANK",
																	key: "BANK",
																	icon: "sap-icon://credit-card",
																	additionalText:"BANK",
																}),	
																new sap.ui.core.ListItem({
																	text:"GCASH",
																	key: "GCASH",
																	icon: "sap-icon://paid-leave",
																	additionalText:"GCASH",
																})	
															]
															}),
														new sap.m.Label({text:"Shipping Carrier",width:"130px"}).addStyleClass('class_label_padding'),
														new sap.m.Select("EMP_SHIPPING_CARRIER",{
															items : [
																new sap.ui.core.ListItem({
																	text:"FedEx",
																	key: "FedEx",
																	icon: "sap-icon://Netweaver-business-client",
																	additionalText:"FedEx",
																}),	
																new sap.ui.core.ListItem({
																	text:"LBC",
																	key: "LBC",
																	icon: "sap-icon://Netweaver-business-client",
																	additionalText:"LBC",
																}),	
																new sap.ui.core.ListItem({
																	text:"J&T",
																	key: "J&T",
																	icon: "sap-icon://Netweaver-business-client",
																	additionalText:"J&T",
																}),
																new sap.ui.core.ListItem({
																	text:"Ninja Van",
																	key: "Ninja Van",
																	icon: "sap-icon://Netweaver-business-client",
																	additionalText:"Ninja Van",
																})		
															]
															}),                                                        
                                                        new sap.m.Label({text:"Tracking Number",width:"130px"}).addStyleClass('class_label_padding'),
														new sap.m.Input("EMP_TRACKING_NUMBER",{placeholder:"",value:"",  editable:true,
									              			width:TextWidth,
															liveChange: function(oEvt){
															fn_livechange_numeric_input(oEvt);
																},
															change : function(oEvt){
															let lv_value = oEvt.getSource().getValue().trim();
															let lv_bpid = lv_value;
										
																					}
															}),
	
														
														/** RIGHT PANEL **/
                                                        new sap.ui.core.Title("GENERAL_INFO_TITLE2",{text:""}),
														new sap.m.Label({text:"Package Weight",width:"130px"}).addStyleClass('class_label_padding'),
														new sap.m.Input("EMP_PACKAGE_WEIGHT",{placeholder:"kg", editable:true, value:"", 
									              			width:TextWidth,
															liveChange: function(oEvt){
															fn_livechange_numeric_input(oEvt);
																},
															change : function(oEvt){
															let lv_value = oEvt.getSource().getValue().trim();
															let lv_bpid = lv_value;
										
																					}}),
 
														new sap.m.Label({text:"Package Dimensions",width:"130px"}).addStyleClass('class_label_padding'),
														new sap.m.Input("EMP_PACKAGE_DIMENSION",{placeholder:"width x length x height",value:"", width:TextWidth, editable:true}),
														new sap.m.Label({text:"Delivery Confirmation",width:"130px"}).addStyleClass('class_label_padding'),
														new sap.m.Select("EMP_DELIVERY_CONFIRMATION",{
															items : [
																new sap.ui.core.ListItem({
																	text:"pending",
																	key: "pending",
																	icon: "sap-icon://pending",
																	additionalText:"pending",
																}),	
																new sap.ui.core.ListItem({
																	text:"yes",
																	key: "yes",
																	icon: "sap-icon://accept",
																	additionalText:"yes",
																}),
																new sap.ui.core.ListItem({
																	text:"no",
																	key: "no",
																	icon: "sap-icon://error",
																	additionalText:"no",
																})
															]
															}),							
														new sap.m.Label({text:"Signature Required",width:"130px"}).addStyleClass('class_label_padding'),
														new sap.m.Select("EMP_SIGNATURE_REQUIRED",{
															items : [
																new sap.ui.core.ListItem({
																	text:"yes",
																	key: "yes",
																	icon: "sap-icon://accept",
																	additionalText:"yes",
																}),	
																new sap.ui.core.ListItem({
																	text:"no",
																	key: "no",
																	icon: "sap-icon://error",
																	additionalText:"no",
																})
															]
															}),	new sap.m.Label({text:"Order Number",width:"130px"}).addStyleClass('class_label_padding'),
														new sap.m.Input("EMP_ORDER_NUMBER",{placeholder:"",editable: true, value:"", 
									              			width:TextWidth,
															liveChange: function(oEvt){
															fn_livechange_numeric_input(oEvt);
																},
															change : function(oEvt){
															let lv_value = oEvt.getSource().getValue().trim();
															let lv_bpid = lv_value;
										
																					}
															}),
														new sap.m.Label({text:"Shipping Cost",width:"130px"}).addStyleClass('class_label_padding'),
														new sap.m.Input("EMP_SHIPPING_COST",{placeholder:"", editable:true, value:"", 
									              			width:TextWidth,
															liveChange: function(oEvt){
															fn_livechange_numeric_input(oEvt);
																},
															change : function(oEvt){
															let lv_value = oEvt.getSource().getValue().trim();
															let lv_bpid = lv_value;
										
																					}}),
														new sap.m.Label({text:"Insurance",width:"130px"}).addStyleClass('class_label_padding'),
														new sap.m.Select("EMP_INSURANCE",{
															items : [
																new sap.ui.core.ListItem({
																	text:"MANULIFE",
																	key: "MANULIFE",
																	icon: "sap-icon://insurance-life",
																	additionalText:"MANULIFE",
																}),	
																new sap.ui.core.ListItem({
																	text:"INSULAR",
																	key: "INSULAR",
																	icon: "sap-icon://insurance-life",
																	additionalText:"INSULAR",
																}),	
																new sap.ui.core.ListItem({
																	text:"AXA",
																	key: "AXA",
																	icon: "sap-icon://insurance-life",
																	additionalText:"AXA",
																})
															]
																})	,
														new sap.m.Label({text:"Customs Information",width:"130px"}).addStyleClass('class_label_padding'),
														new sap.m.Input("EMP_CUSTOMS_INFO",{placeholder:"",value:"", width:TextWidth, editable:true}),
														new sap.m.Label({text:"Order Status",width:"130px"}).addStyleClass('class_label_padding'),
														new sap.m.Select("EMP_ORDER_STATUS",{
															items : [
																new sap.ui.core.ListItem({
																	text:"PARCEL COLLECT",
																	key: "PARCEL COLLECT",
																	icon: "sap-icon://inbox",
																	additionalText:"PARCEL COLLECT",
																}),	
																new sap.ui.core.ListItem({
																	text:"SHIPPING",
																	key: "SHIPPING",
																	icon: "sap-icon://shipping-status",
																	additionalText:"SHIPPING",
																}),	
																new sap.ui.core.ListItem({
																	text:"RECEIVED",
																	key: "RECEIVED",
																	icon: "sap-icon://activity-2",
																	additionalText:"RECEIVED",
																})	
															]
															}),                                                  
                                                       
                                                    ]
                                                })
                                            ]
                                        })
                                    ]
                                })
                            ]
                        }),
                        new sap.uxap.ObjectPageSubSection({
                            title: "ADDRESS",
                            blocks:[]
                        })
                    ]        
                }),
				/** CRUD TABLE */
                new sap.uxap.ObjectPageSection("COMP_CODE_TAB",{
					title: "Delivery Table Crud",
					subSections:[
						new sap.uxap.ObjectPageSubSection({
							blocks:[
								new sap.m.Panel({
									content:[
										new sap.ui.table.Table("GO_TABLE_COMPCODE",{
											visibleRowCount:8,
											selectionMode:"None",
											enableCellFilter: true,
											enableColumnReordering:true,
											toolbar:[
												new sap.m.Toolbar({
													design:"Transparent",
													content:[
														new sap.m.Text("TABLE_LABEL_COMPCODE",{text:"DELIVERY APP (0)"}),
														new sap.m.ToolbarSpacer(),
														new sap.m.Button ("COMPCODE_ADD_BUTTON",{
															icon: "sap-icon://add",
															press: function(){
																gv_bind_mode = "create";
																ui('COMPCODE_FORM_DIALOG').open();
															}
														})
													]
												})
											],
											columns:[
												
												new sap.ui.table.Column({label:new sap.m.Text({text:"DELIVERY ID"}),
													autoResizable:true,
													sortProperty:"DELIVERY_ID",
													filterProperty:"DELIVERY_ID",
													autoResizable:true,
													template:new sap.m.Text({text:"{DELIVERY_ID}",maxLines:1,tooltip:"{DELIVERY_ID}"})
												}),
												new sap.ui.table.Column({label:new sap.m.Text({text:"DELIVERY ADDRESS"}),
													autoResizable:true,
													sortProperty:"DELIVERY_ADDRESS",
													filterProperty:"DELIVERY_ADDRESS",
													autoResizable:true,
													template:new sap.m.Text({text:"{DELIVERY_ADDRESS}",maxLines:1,tooltip:"{DELIVERY_ADDRESS}"})
												}),
												new sap.ui.table.Column({label:new sap.m.Text({text:"Payment Term"}),
													autoResizable:true,
													sortProperty:"PYMT_TERM",
													filterProperty:"PYMT_TERM",
													autoResizable:true,
													template:new sap.m.Text({text:"{PYMT_TERM}",maxLines:1,tooltip:"{PYMT_TERM}"})
												}),
												new sap.ui.table.Column({label:new sap.m.Text({text:"GST Reg No"}),
													autoResizable:true,
													sortProperty:"GST_REG",
													filterProperty:"GST_REG",
													autoResizable:true,
													template:new sap.m.Text({text:"{GST_REG}",maxLines:1,tooltip:"{GST_REG}"})
												}),
												new sap.ui.table.Column({label:new sap.m.Text({text:"GST Effective Date"}),
													autoResizable:true,
													sortProperty:"GST_DATE",
													filterProperty:"GST_DATE_DESC",
													autoResizable:true,
													template:new sap.m.Text({text:"{GST_DATE_DESC}",maxLines:1,tooltip:"{GST_DATE_DESC}"})
												}),
												new sap.ui.table.Column("COMPCODE_DEL_BTN", {
													width:"50px",
													hAlign :"Left",
													template: new sap.m.Button({
														icon: "sap-icon://delete",
														width: "100%",
														//textAlign: "Left",
														press: function (oEvt) {
															var lo_index = String(oEvt.getSource().getBindingContext().getPath());
															var lv_index = parseInt(lo_index.split("/")[1]);
															var lt_deleted_data = gt_compcode_details.splice(lv_index,1);
																							
															for(var i=0; i < lt_deleted_data.length; i++){
																if(lt_deleted_data[i].DATA_ID !== ""){
																	gt_deleted_compcode_data.push(lt_deleted_data[i]);
																}
															}
															fn_bind_bizdata(gt_compcode_details,"GO_TABLE_COMPCODE");
															ui('TABLE_LABEL_COMPCODE').setText("Company Code ("+gt_compcode_details.length+")");
														}
													})
												}),
												
											],
											cellClick : function(oEvt){
												var lv_bind = oEvt.getParameters().rowBindingContext;	
												if(lv_bind != undefined){
													gv_bind_mode = "edit";
													var lv_data = ui("GO_TABLE_COMPCODE").getModel().getData();
													var lv_row_index = oEvt.getParameters().rowIndex;
													gv_bind_index = fn_actual_index("GO_TABLE_COMPCODE",lv_row_index);
													fn_set_company_code_fields_visibility(lv_bind);
												}
											}
										})
									]
								})
							]
						})
					]
				}),
                new sap.uxap.ObjectPageSection("SECTION_ATTACHMENT",{
                    title:"ATTACHMENT",
					subSections:[
						new sap.uxap.ObjectPageSubSection({
                            title:"Attachment",
							blocks:[
							]
						})
					]
				}),
            ]      
        });
        page.setCustomHeader(pageHeader);
        page.addContent(crumbs);
        page.addContent(createPageForm);
        return page;
    }
	function createDisplayBizPage(){
				
				var lv_Page  = new sap.m.Page("BP_PAGE_DISPLAY",{}).addStyleClass('sapUiSizeCompact');
				
				var lv_header = new sap.m.Bar({
					enableFlexBox: false,
					contentLeft:[
						new sap.m.Button({ icon:"sap-icon://nav-back",
							press:function(oEvt){
								go_App_Right.back();
							} 
						}),
						new sap.m.Button({icon:"sap-icon://menu2",
							press:function(){
								go_SplitContainer.setSecondaryContentWidth("250px");
								if(!go_SplitContainer.getShowSecondaryContent()){
									go_SplitContainer.setShowSecondaryContent(true);
								} else {							
									go_SplitContainer.setShowSecondaryContent(false);
								}
							}
						})
						//new sap.m.Image({src: logo_path}),
					],
		
					contentMiddle:[gv_Lbl_NewPrdPage_Title = new sap.m.Label("DISP_BP_TITLE",{text:"Display Delivery Partner"})],
					
					contentRight:[
						new sap.m.Button({
							icon: "sap-icon://home",
							press: function(){
								window.location.href = MainPageLink; 
						//go_App_Right.to('CREATE_BP_PAGE');
							}
						})
					]
				});
				
				var lv_crumbs = new sap.m.Breadcrumbs("DISP_BP_BRDCRMS",{
					currentLocationText: "Display Business Partner",
					links: [
						new sap.m.Link({
							text:"Home",
							press:function(oEvt){
							   // fn_click_breadcrumbs("HOME");
							}
						}),
						new sap.m.Link("DISP_BP_BRDCRMS_TITLE",{
							text:"Business Partner Management",
							press:function(oEvt){
							  //  fn_click_breadcrumbs("HOME");
							}
						}),
						
					]
				}).addStyleClass('breadcrumbs-padding');
				
				
				var lv_searchfield =  new sap.m.Bar({
					enableFlexBox: false,
					contentLeft: [
						// actual search field
						new sap.m.SearchField("SEARCHFIELD_DISPLAY_OUTLET",{
							width: "99%",
							change: function(oEvt){
								var lv_search_val = oEvt.getSource().getValue().trim();
								if(lv_search_val == ""){
									ui("DISPLAY_BP_TABLE").setVisible(false);
								}
								else{
									displayBp._get_data(lv_search_val);
								}
								//if(lv_search_val == createBP().createBPdetails.DELIVERY_ID){
								//alert("123");
							//}
							},
							placeholder: "Search...",
							search: function(oEvent){
							//	var lv_searchval = oEvent.getSource().getValue().trim();
							//	displayBp._get_data(lv_searchval);
							
							},
						})
					],
				});
				
				var lv_table = new sap.ui.table.Table("DISPLAY_BP_TABLE", {
					visible:false,
					visibleRowCountMode:"Auto",
					selectionMode:"None",
					enableCellFilter: true,
					enableColumnReordering:true,
					toolbar:[
						new sap.m.Toolbar({
							design:"Transparent",
							content:[
								new sap.m.Text("DISPLAY_BP_TABLE_LABEL",{text:"Delivery List (0)"}),
							]
						})
					],
					filter:function(oEvt){
						oEvt.getSource().getBinding("rows").attachChange(function(oEvt){
							var lv_row_count = oEvt.getSource().iLength;
							ui('DISPLAY_BP_TABLE_LABEL').setText("Delivery List (" + lv_row_count + ")");
						});
					},
					cellClick: function(oEvt){
						
						var lv_bind = oEvt.getParameters().rowBindingContext;
						
						if(lv_bind != undefined){
							var lv_bp_id = oEvt.getParameters().rowBindingContext.getProperty("DELIVERY_ID");
							if(lv_bp_id){
								screenMode._display(lv_bp_id);
							}
						}
						
					},
					columns: [
					
						new sap.ui.table.Column({label:new sap.m.Text({text:"DELIVERY_ID"}),
							width:"80px",
							sortProperty:"DELIVERY_ID",
							filterProperty:"DELIVERY_ID",
							autoResizable:true,
							template:new sap.m.Text({text:"{DELIVERY_ID}",maxLines:1}),
						}),
						new sap.ui.table.Column({label:new sap.m.Text({text:"DELIVERY ADDRESS"}),
							width:"40%",
							sortProperty:"DELIVERY_ADDRESS",
							filterProperty:"DELIVERY_ADDRESS",
							autoResizable:true,
							template:new sap.m.Text({text:"{DELIVERY_ADDRESS}",tooltip:"{DELIVERY_ADDRESS}",maxLines:1}),
						}),
						new sap.ui.table.Column({label:new sap.m.Text({text:"CONTACT NAME"}),
							width:"40%",
							sortProperty:"EMP_NAME",
							filterProperty:"EMP_NAME",
							autoResizable:true,
							template:new sap.m.Text({text:"{EMP_NAME}",tooltip:"{EMP_NAME}",maxLines:1}),
						}),
						new sap.ui.table.Column({label:new sap.m.Text({text:"CONTACT PHONE"}),
							width:"20%",
							sortProperty:"EMP_PHONE",
							filterProperty:"EMP_PHONE",
							autoResizable:true,
							template:new sap.m.Text({text:"{EMP_PHONE}",maxLines:1}),
						}),new sap.ui.table.Column({label:new sap.m.Text({text:"EMAIL"}),
							width:"20%",
							sortProperty:"EMP_EMAIL",
							filterProperty:"EMP_EMAIL",
							autoResizable:true,
							template:new sap.m.Text({text:"{EMP_EMAIL}",maxLines:1}),
						}),new sap.ui.table.Column({label:new sap.m.Text({text:"DELIVERY DATE"}),
							width:"20%",
							sortProperty:"EMP_DELIVERY_DATE",
							filterProperty:"EMP_DELIVERY_DATE",
							autoResizable:true,
							template:new sap.m.Text({text:"{EMP_DELIVERY_DATE}",maxLines:1}),
						}),new sap.ui.table.Column({label:new sap.m.Text({text:"DELIVERY TIME"}),
							width:"20%",
							sortProperty:"EMP_DELIVERY_TIME",
							filterProperty:"EMP_DELIVERY_TIME",
							autoResizable:true,
							template:new sap.m.Text({text:"{EMP_DELIVERY_TIME}",maxLines:1}),
						}),new sap.ui.table.Column({label:new sap.m.Text({text:"DELIVERY INSTRUCTION"}),
							width:"20%",
							sortProperty:"EMP_DELIVERY_INSTRUCTION",
							filterProperty:"EMP_DELIVERY_INSTRUCTION",
							autoResizable:true,
							template:new sap.m.Text({text:"{EMP_DELIVERY_INSTRUCTION}",maxLines:1}),
						}),new sap.ui.table.Column({label:new sap.m.Text({text:"SHIPPING METHOD"}),
							width:"20%",
							sortProperty:"EMP_SHIPPING_METHOD",
							filterProperty:"EMP_SHIPPING_METHOD",
							autoResizable:true,
							template:new sap.m.Text({text:"{EMP_SHIPPING_METHOD}",maxLines:1}),
						}),new sap.ui.table.Column({label:new sap.m.Text({text:"SHIPPING CARRIER"}),
							width:"20%",
							sortProperty:"EMP_SHIPPING_CARRIER",
							filterProperty:"EMP_SHIPPING_CARRIER",
							autoResizable:true,
							template:new sap.m.Text({text:"{EMP_SHIPPING_CARRIER}",maxLines:1}),
						}),new sap.ui.table.Column({label:new sap.m.Text({text:"TRACKING NUMBER"}),
							width:"20%",
							sortProperty:"EMP_TRACKING_NUMBER",
							filterProperty:"EMP_TRACKING_NUMBER",
							autoResizable:true,
							template:new sap.m.Text({text:"{EMP_TRACKING_NUMBER}",maxLines:1}),
						}),new sap.ui.table.Column({label:new sap.m.Text({text:"PACKAGE WEIGHT"}),
							width:"20%",
							sortProperty:"EMP_PACKAGE_WEIGHT",
							filterProperty:"EMP_PACKAGE_WEIGHT",
							autoResizable:true,
							template:new sap.m.Text({text:"{EMP_PACKAGE_WEIGHT}",maxLines:1}),
						}),new sap.ui.table.Column({label:new sap.m.Text({text:"PACKAGE DIMENSION"}),
							width:"20%",
							sortProperty:"EMP_PACKAGE_DIMENSION",
							filterProperty:"EMP_PACKAGE_DIMENSION",
							autoResizable:true,
							template:new sap.m.Text({text:"{EMP_PACKAGE_DIMENSION}",maxLines:1}),
						}),new sap.ui.table.Column({label:new sap.m.Text({text:"DELIVERY CONFIRMATION"}),
							width:"20%",
							sortProperty:"EMP_DELIVERY_CONFIRMATION",
							filterProperty:"EMP_DELIVERY_CONFIRMATION",
							autoResizable:true,
							template:new sap.m.Text({text:"{EMP_DELIVERY_CONFIRMATION}",maxLines:1}),
						}),new sap.ui.table.Column({label:new sap.m.Text({text:"SIGNATURE REQUIRED"}),
							width:"20%",
							sortProperty:"EMP_SIGNATURE_REQUIRED",
							filterProperty:"EMP_SIGNATURE_REQUIRED",
							autoResizable:true,
							template:new sap.m.Text({text:"{EMP_SIGNATURE_REQUIRED}",maxLines:1}),
						}),new sap.ui.table.Column({label:new sap.m.Text({text:"ORDER NUMBER"}),
							width:"20%",
							sortProperty:"EMP_ORDER_NUMBER",
							filterProperty:"EMP_ORDER_NUMBER",
							autoResizable:true,
							template:new sap.m.Text({text:"{EMP_ORDER_NUMBER}",maxLines:1}),
						}),new sap.ui.table.Column({label:new sap.m.Text({text:"SHIPPING COST"}),
							width:"20%",
							sortProperty:"EMP_SHIPPING_COST",
							filterProperty:"EMP_SHIPPING_COST",
							autoResizable:true,
							template:new sap.m.Text({text:"{EMP_SHIPPING_COST}",maxLines:1}),
						}),new sap.ui.table.Column({label:new sap.m.Text({text:"INSURANCE"}),
							width:"20%",
							sortProperty:"EMP_INSURANCE",
							filterProperty:"EMP_INSURANCE",
							autoResizable:true,
							template:new sap.m.Text({text:"{EMP_INSURANCE}",maxLines:1}),
						
						}),new sap.ui.table.Column({label:new sap.m.Text({text:"CUSTOMS INFO"}),
							width:"20%",
							sortProperty:"EMP_CUSTOMS_INFO",
							filterProperty:"EMP_CUSTOMS_INFO",
							autoResizable:true,
							template:new sap.m.Text({text:"{EMP_CUSTOMS_INFO}",maxLines:1}),
							
						}),new sap.ui.table.Column({label:new sap.m.Text({text:"ORDER STATUS"}),
							width:"20%",
							sortProperty:"EMP_ORDER_STATUS",
							filterProperty:"EMP_ORDER_STATUS",
							autoResizable:true,
							template:new sap.m.Text({text:"{EMP_ORDER_STATUS}",maxLines:1}),
						}),
						
					]
				});
				
				lv_Page.setCustomHeader(lv_header);
				lv_Page.addContent(lv_crumbs);
				lv_Page.addContent(lv_searchfield);
				lv_Page.addContent(lv_table);
				
				return lv_Page;
			}
	function createListBP(){
var lv_Page  = new sap.m.Page("PAGE_BP_LISTING",{}).addStyleClass('sapUiSizeCompact');
var lv_header = new sap.m.Bar({
	enableFlexBox: false,
	contentLeft:[
		new sap.m.Button({ icon:"sap-icon://nav-back",
			press:function(oEvt){ 
				
				go_App_Right.back();
				
			}
		}),
		new sap.m.Button({icon:"sap-icon://menu2",
			press:function(){
				go_SplitContainer.setSecondaryContentWidth("270px");
				if(!go_SplitContainer.getShowSecondaryContent()){
					go_SplitContainer.setShowSecondaryContent(true);
				} else {							
					go_SplitContainer.setShowSecondaryContent(false);
				}
			}
		}), 
		//new sap.m.Image({src: logo_path}),
		],
	contentMiddle:[gv_Lbl_NewPrdPage_Title = new sap.m.Label("BP_LISTING_PAGE_LABEL",{text:"Business Delivery Table"})],
	
	contentRight:[
		//fn_help_button(SelectedAppID,"BP_LISTING"),
		new sap.m.Button({  
			icon: "sap-icon://home",
			press: function(){
			window.location.href = MainPageLink; 
			}
		})
	]
});
			
var lv_crumbs = new sap.m.Breadcrumbs("LIST_BP_BRDCRMS",{
	currentLocationText: "Business Delivery Table",
	links: [
		new sap.m.Link({
			text:"Home",
			press:function(oEvt){
			// fn_click_breadcrumbs("HOME");
			}
		}),
		new sap.m.Link("LIST_BP_BRDCRMS_TITLE",{
			text:"Business Partner Management",
			press:function(oEvt){
			//  fn_click_breadcrumbs("HOME");
			}
		}),
		
	]
}).addStyleClass('breadcrumbs-padding');
var lv_table = new sap.ui.table.Table("BP_LISTING_TABLE",{
	visibleRowCountMode:"Auto",
	selectionMode:"None",
	enableCellFilter: true,
	enableColumnReordering:true,
	filter:function(oEvt){
		oEvt.getSource().getBinding("rows").attachChange(function(oEvt){
			var lv_row_count = oEvt.getSource().iLength;
			ui('BP_LISTING_LABEL').setText("Business Partner (" + lv_row_count + ")");
		});
	},
	toolbar: [
		new sap.m.Toolbar({
			content: [
				new sap.m.Label("BP_LISTING_LABEL", {
					text:"Business Partner (0)"
				}),
				new sap.m.ToolbarSpacer(),
				new sap.m.Button("BTN_DOWNLOAD", {
					visible: true,
					icon: "sap-icon://download",
					press: function () {
						if(ui('BP_LISTING_TABLE').getModel().getData().length == 0){
									fn_show_message_toast("No data to download");
								}else{
									fn_download_bp_listing();
								}
					}
				})
			]
		}).addStyleClass('class_transparent_bar'),
	],
	cellClick: function(oEvt){
		
		var lv_bind = oEvt.getParameters().rowBindingContext;
		if(lv_bind != undefined){
			var lv_bp_id = oEvt.getParameters().rowBindingContext.getProperty("DELIVERY_ID");
			if(lv_bp_id){
				screenMode._display(lv_bp_id);
			}
		}
	},
	columns:[
		/** COLUMN HEADER - DATA TABLE */
		new sap.ui.table.Column({label:new sap.m.Text({text:"DELIVERY ID"}),
			width:"180px",
			sortProperty:"DELIVERY_ID",
			filterProperty:"DELIVERY_ID",
			//autoResizable:true,
			template:new sap.m.Text({text:"{DELIVERY_ID}",tooltip:"{DELIVERY_ID}",maxLines:1}),
		}),
		new sap.ui.table.Column({label:new sap.m.Text({text:"DELIVERY ADDRESS"}),
			width:"250px",
			sortProperty:"DELIVERY_ADDRESS",
			filterProperty:"DELIVERY_ADDRESS",
			autoResizable:true,
			template:new sap.m.Text({text:"{DELIVERY_ADDRESS}",tooltip:"{DELIVERY_ADDRESS}",maxLines:1}),
		}),
		new sap.ui.table.Column({label:new sap.m.Text({text:"CONTACT NAME"}),
			width:"350px",
			sortProperty:"EMP_NAME",
			filterProperty:"EMP_NAME",
			template:new sap.m.Text({text:"{EMP_NAME}",tooltip:"{EMP_NAME}",maxLines:1}),
		}),
		new sap.ui.table.Column({label:new sap.m.Text({text:"CONTACT PHONE"}),
			width:"400px",
			sortProperty:"EMP_PHONE",
			filterProperty:"EMP_PHONE",
			template:new sap.m.Text({text:"{EMP_PHONE}",tooltip:"{EXT_PARTNEMP_PHONEER}",maxLines:1}),
		}),
		
		
		new sap.ui.table.Column({label:new sap.m.Text({text:"EMAIL"}),
			width:"160px",
			sortProperty:"EMP_EMAIL",
			filterProperty:"EMP_EMAIL",
			template:new sap.m.Text({text:"{EMP_EMAIL}",tooltip:"{EMP_EMAIL}",maxLines:1}),
		}),
		new sap.ui.table.Column({label:new sap.m.Text({text:"DELIVERY DATE"}),
			width:"150px",
			sortProperty:"EMP_DELIVERY_DATE",
			filterProperty:"EMP_DELIVERY_DATE",
			template:new sap.m.Text({text:"{EMP_DELIVERY_DATE}",tooltip:"{EMP_DELIVERY_DATE}",maxLines:1}),
		}),
		new sap.ui.table.Column({label:new sap.m.Text({text:"DELIVERY TIME"}),
			width:"150px",
			sortProperty:"EMP_DELIVERY_TIME",
			filterProperty:"EMP_DELIVERY_TIME",
			template:new sap.m.Text({text:"{EMP_DELIVERY_TIME}",tooltip:"{EMP_DELIVERY_TIME}",maxLines:1}),
		}),
		new sap.ui.table.Column({label:new sap.m.Text({text:"DELIVERY INSTRUCTION"}),
			width:"150px",
			sortProperty:"EMP_DELIVERY_INSTRUCTION",
			filterProperty:"EMP_DELIVERY_INSTRUCTION",
			template:new sap.m.Text({text:"{EMP_DELIVERY_INSTRUCTION}",tooltip:"{EMP_DELIVERY_INSTRUCTION}",maxLines:1}),
		}),
		new sap.ui.table.Column({label:new sap.m.Text({text:"SHIPPING METHOD"}),
			width:"150px",
			sortProperty:"EMP_SHIPPING_METHOD",
			filterProperty:"EMP_SHIPPING_METHOD",
			template:new sap.m.Text({text:"{EMP_SHIPPING_METHOD}",tooltip:"{EMP_SHIPPING_METHOD}",maxLines:1}),
		}),
		new sap.ui.table.Column({label:new sap.m.Text({text:"SHIPPING CARRIER"}),
			width:"150px",
			sortProperty:"EMP_SHIPPING_CARRIER",
			filterProperty:"EMP_SHIPPING_CARRIER",
			template:new sap.m.Text({text:"{EMP_SHIPPING_CARRIER}",tooltip:"{EMP_SHIPPING_CARRIER}",maxLines:1}),
		}),
		new sap.ui.table.Column({label:new sap.m.Text({text:"TRACKING NUMBER"}),
			width:"150px",
			sortProperty:"EMP_TRACKING_NUMBER",
			filterProperty:"EMP_TRACKING_NUMBER",
			template:new sap.m.Text({text:"{EMP_TRACKING_NUMBER}",tooltip:"{EMP_TRACKING_NUMBER}",maxLines:1}),
		}),
		new sap.ui.table.Column({label:new sap.m.Text({text:"PACKAGE WEIGHT"}),
			width:"150px",
			sortProperty:"EMP_PACKAGE_WEIGHT",
			filterProperty:"EMP_PACKAGE_WEIGHT",
			template:new sap.m.Text({text:"{EMP_PACKAGE_WEIGHT}",tooltip:"{EMP_PACKAGE_WEIGHT}",maxLines:1}),
		}),
		new sap.ui.table.Column({label:new sap.m.Text({text:"PACKAGE DIMENSION"}),
			width:"150px",
			sortProperty:"EMP_PACKAGE_DIMENSION",
			filterProperty:"EMP_PACKAGE_DIMENSION",
			template:new sap.m.Text({text:"{EMP_PACKAGE_DIMENSION}",tooltip:"{EMP_PACKAGE_DIMENSION}",maxLines:1}),
		}),
		new sap.ui.table.Column({label:new sap.m.Text({text:"DELIVERY CONFIRMATION"}),
			width:"150px",
			sortProperty:"EMP_DELIVERY_CONFIRMATION",
			filterProperty:"EMP_DELIVERY_CONFIRMATION",
			template:new sap.m.Text({text:"{EMP_DELIVERY_CONFIRMATION}",tooltip:"{EMP_DELIVERY_CONFIRMATION}",maxLines:1}),
		}),
		new sap.ui.table.Column({label:new sap.m.Text({text:"SIGNATURE REQUIRED"}),
			width:"150px",
			sortProperty:"EMP_SIGNATURE_REQUIRED",
			filterProperty:"EMP_SIGNATURE_REQUIRED",
			template:new sap.m.Text({text:"{EMP_SIGNATURE_REQUIRED}",tooltip:"{EMP_SIGNATURE_REQUIRED}",maxLines:1}),
		}),
		new sap.ui.table.Column({label:new sap.m.Text({text:"ORDER NUMBER"}),
			width:"150px",
			sortProperty:"EMP_ORDER_NUMBER",
			filterProperty:"EMP_ORDER_NUMBER",
			template:new sap.m.Text({text:"{EMP_ORDER_NUMBER}",tooltip:"{EMP_ORDER_NUMBER}",maxLines:1}),
		}),
		new sap.ui.table.Column({label:new sap.m.Text({text:"SHIPPING COST"}),
			width:"150px",
			sortProperty:"EMP_SHIPPING_COST",
			filterProperty:"EMP_SHIPPING_COST",
			template:new sap.m.Text({text:"{EMP_SHIPPING_COST}",tooltip:"{EMP_SHIPPING_COST}",maxLines:1}),
		}),
		new sap.ui.table.Column({label:new sap.m.Text({text:"INSURANCE"}),
			width:"150px",
			sortProperty:"EMP_INSURANCE",
			filterProperty:"EMP_INSURANCE",
			template:new sap.m.Text({text:"{EMP_INSURANCE}",tooltip:"{EMP_INSURANCE}",maxLines:1}),
		}),
		new sap.ui.table.Column({label:new sap.m.Text({text:"CUSTOMS INFO"}),
			width:"150px",
			sortProperty:"EMP_CUSTOMS_INFO",
			filterProperty:"EMP_CUSTOMS_INFO",
			template:new sap.m.Text({text:"{EMP_CUSTOMS_INFO}",tooltip:"{EMP_CUSTOMS_INFO}",maxLines:1}),
		}),
		new sap.ui.table.Column({label:new sap.m.Text({text:"ORDER STATUS"}),
			width:"150px",
			sortProperty:"EMP_ORDER_STATUS",
			filterProperty:"EMP_ORDER_STATUS",
			template:new sap.m.Text({text:"{EMP_ORDER_STATUS}",tooltip:"{EMP_ORDER_STATUS}",maxLines:1}),
		}),
		
	]
});
lv_Page.setCustomHeader(lv_header);
lv_Page.addContent(lv_crumbs);
lv_Page.addContent(lv_table);
return lv_Page;
}
	
</script>	