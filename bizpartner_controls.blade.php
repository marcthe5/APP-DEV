<script>
    
    function CreateContent(){
        var go_Shell = new sap.m.Shell({});
        //left page
        go_App_Left = new sap.m.App({});
        go_App_Left.addPage(create_page_menu());
        //right page
        go_App_Right = new sap.m.App({});
        go_App_Right.addPage(createBizPage());	
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
        let pageHeader  = new sap.m.Bar({enableFlexBox: false,contentMiddle:[ new sap.m.Label({text:"Action"})]});
        const menuList = new sap.m.List("MENU_LIST",{});
		const menuListTemplate = new sap.m.StandardListItem("LEFT_MENU_TEMPLATE",{
			title:"{title}",
			icon:"{icon}",
			visible:"{visible}",
			type: sap.m.ListType.Active,
			press:function(oEvent){
				
                alert(oEvent.getSource().getBindingContext().getProperty('title'));
                go_App_Right.to('CREATE_BP_PAGE');
			}
		});
		
        const gt_list = [
                {
                    title   : "Create Business Partner",
                    icon    : "sap-icon://add-product",
                    visible : true
                },
                {
                    title   : "Display Business Partner",
                    icon    : "sap-icon://business-card",
                    visible : true
                },
                {
                    title   : "Business Partner Listing",
                    icon    : "sap-icon://checklist-item",
                    visible : true
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
                new sap.m.Label("",{text:"Create Business Partner"})
            ],
		
		});
        let crumbs = new sap.m.Breadcrumbs("CREATE_BP_BRDCRMS",{
            currentLocationText: "Create Business Partner",
            links: [
                new sap.m.Link({
                    text:"Home",
                    press:function(oEvt){
                       // fn_click_breadcrumbs("HOME");
                    }
                }),
				new sap.m.Link("CREATE_BP_BRDCRMS_TITLE",{
                    text:"Business Partner Management",
                    press:function(oEvt){
                      //  fn_click_breadcrumbs("HOME");
                    }
                }),
				
            ]
        });
		
        let createPageForm = new sap.uxap.ObjectPageLayout({
            headerTitle:[
                new sap.uxap.ObjectPageHeader("OBJECTHEADER_BP_NAME",{
                    objectTitle:"",
					showPlaceholder : false,
					actions:[
                        new sap.uxap.ObjectPageHeaderActionButton("CREATE_BP_SAVE_BTN",{
                            icon: "sap-icon://save",
							press: function(){
								
                            ui("DELIVERY_ADDRESS").setEditable(false);
							ui("EMP_NAME").setEditable(false);
							ui("EMP_PHONE").setEditable(false);
							ui("EMP_EMAIL").setEditable(false);
							ui("EMP_DELIVERY_DATE").setEditable(false);
							ui("EMP_DELIVERY_TIME").setEditable(false);
							ui("EMP_DELIVERY_INSTRUCTION").setEditable(false);
							ui("EMP_SHIPPING_METHOD").setEditable(false);
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
                        }).addStyleClass("sapMTB-Transparent-CTX"),
                        new sap.uxap.ObjectPageHeaderActionButton("CREATE_BP_EDIT_BTN",{
                            icon: "sap-icon://edit",
							press: function(){
								
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
                        }).addStyleClass("sapMTB-Transparent-CTX"),
                    ],
                })
            ],
            sections:[
                new sap.uxap.ObjectPageSection("GENERAL_DATA_TAB",{
                    title: "General Info",
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
                                                        new sap.ui.core.Title("GENERAL_INFO_TITLE1",{text:""}),
                                                        new sap.m.Label({text:"Delivery Address",width:"160px"}).addStyleClass('class_label_padding'),
														new sap.m.Input("DELIVERY_ADDRESS",{value:"", width:TextWidth, editable:true}),

                                                        new sap.m.Label({text:"Contact Name",width:labelWidth}).addStyleClass('class_label_padding'),
														new sap.m.Input("EMP_NAME",{value:"", width:TextWidth, editable:true}),

                                                        new sap.m.Label({text:"Contact Phone Number",width:"150px"}).addStyleClass('class_label_padding'),
														new sap.m.Input("EMP_PHONE",{value:"", width:TextWidth, editable:true}),

														new sap.m.Label({text:"Email Address",width:"150px"}).addStyleClass('class_label_padding'),
														new sap.m.Input("EMP_EMAIL",{value:"", width:TextWidth, editable:true}),

														new sap.m.Label({text:"Delivery Date",width:"150px"}).addStyleClass('class_label_padding'),
														new sap.m.Input("EMP_DELIVERY_DATE",{value:"", width:TextWidth, editable:true}),

														new sap.m.Label({text:"Delivery Time",width:"150px"}).addStyleClass('class_label_padding'),
														new sap.m.Input("EMP_DELIVERY_TIME",{value:"", width:TextWidth, editable:true}),

														new sap.m.Label({text:"Delivery Instructions",width:"150px"}).addStyleClass('class_label_padding'),
														new sap.m.Input("EMP_DELIVERY_INSTRUCTION",{value:"", width:TextWidth, editable:true}),

														new sap.m.Label({text:"Shipping Method",width:"150px"}).addStyleClass('class_label_padding'),
														new sap.m.Input("EMP_SHIPPING_METHOD",{value:"", width:TextWidth, editable:true}),

														new sap.m.Label({text:"Shipping Carrier",width:"150px"}).addStyleClass('class_label_padding'),
														new sap.m.Input("EMP_SHIPPING_CARRIER",{value:"", width:TextWidth, editable:true}),
                                                        


                                                                     /** RIGHT PANEL **/





                                                        new sap.ui.core.Title("GENERAL_INFO_TITLE2",{text:""}),
                                                        new sap.m.Label({text:"Tracking Number",width:"150px"}).addStyleClass('class_label_padding'),
														new sap.m.Input("EMP_TRACKING_NUMBER",{value:"", width:TextWidth, editable:true}),

														new sap.m.Label({text:"Package Weight",width:"150px"}).addStyleClass('class_label_padding'),
														new sap.m.Input("EMP_PACKAGE_WEIGHT",{value:"", width:TextWidth, editable:true}),
 
														new sap.m.Label({text:"Package Dimensions",width:"150px"}).addStyleClass('class_label_padding'),
														new sap.m.Input("EMP_PACKAGE_DIMENSION",{value:"", width:TextWidth, editable:true}),

														new sap.m.Label({text:"Delivery Confirmation",width:"150px"}).addStyleClass('class_label_padding'),
														new sap.m.Input("EMP_DELIVERY_CONFIRMATION",{value:"", width:TextWidth, editable:true}),

														new sap.m.Label({text:"Signature Required",width:"150px"}).addStyleClass('class_label_padding'),
														new sap.m.Input("EMP_SIGNATURE_REQUIRED",{value:"", width:TextWidth, editable:true}),

														new sap.m.Label({text:"Order Number",width:"150px"}).addStyleClass('class_label_padding'),
														new sap.m.Input("EMP_ORDER_NUMBER",{value:"", width:TextWidth, editable:true}),

														new sap.m.Label({text:"Shipping Cost",width:"150px"}).addStyleClass('class_label_padding'),
														new sap.m.Input("EMP_SHIPPING_COST",{value:"", width:TextWidth, editable:true}),

														new sap.m.Label({text:"Insurance",width:"150px"}).addStyleClass('class_label_padding'),
														new sap.m.Input("EMP_INSURANCE",{value:"", width:TextWidth, editable:true}),

														new sap.m.Label({text:"Customs Information",width:"150px"}).addStyleClass('class_label_padding'),
														new sap.m.Input("EMP_CUSTOMS_INFO",{value:"", width:TextWidth, editable:true}),

														new sap.m.Label({text:"Order Status",width:"150px"}).addStyleClass('class_label_padding'),
														new sap.m.Input("EMP_ORDER_STATUS",{value:"", width:TextWidth, editable:true}),






                                                  

                                                        new sap.m.Label({text:"Deletion Flag",width:labelWidth}).addStyleClass('class_label_padding'),
														new sap.m.Switch("CONTROL_INFO_DEL_FLAG",{state:true}),
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
                new sap.uxap.ObjectPageSection("COMP_CODE_TAB",{
					title: "Company Code",
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
														new sap.m.Text("TABLE_LABEL_COMPCODE",{text:"Company Code (0)"}),
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
												
												new sap.ui.table.Column({label:new sap.m.Text({text:"Company Code"}),
													autoResizable:true,
													sortProperty:"COMPANY_DESC",
													filterProperty:"COMPANY_DESC",
													autoResizable:true,
													template:new sap.m.Text({text:"{COMPANY_DESC}",maxLines:1,tooltip:"{COMPANY_DESC}"})
												}),
												new sap.ui.table.Column({label:new sap.m.Text({text:"Business Reg No"}),
													autoResizable:true,
													sortProperty:"BIZ_REG",
													filterProperty:"BIZ_REG",
													autoResizable:true,
													template:new sap.m.Text({text:"{BIZ_REG}",maxLines:1,tooltip:"{BIZ_REG}"})
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
														textAlign: "Left",
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
</script>
