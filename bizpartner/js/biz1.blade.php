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
		go_App_Right.addPage(createTestPage());

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
				
                let menu = oEvent.getSource().getBindingContext().getProperty('funct');
				let list_items = oEvent.getSource().getParent().getItems();

                for (var i = 0; i < list_items.length; i++) {
                    list_items[i].removeStyleClass('class_selected_list_item');
                   //$('LEFT_MENU_TEMPLATE-MENU_LIST-0').removeClass('class_selected_list_item');
                }

                oEvent.getSource().addStyleClass('class_selected_list_item');
				
				switch(menu){
					case "CREATE_BP" :
						screenMode._create();
					break;
					case "DISPLAY_BP" :
						go_App_Right.to('BP_PAGE_DISPLAY');
					break;
					case "BP_LIST" :
						let response = async () => {
							let data = await bpDataOrganizer._getBpData();
							listingBp._getData(data);
							go_App_Right.to('PAGE_BP_LISTING');
						}
						response();
						
					break;
					case "BP_TEST" :

						go_App_Right.to('TEST_PAGE');
					break;

				}
                
			}
		});
		
        const gt_list = [
                {
                    title   : "Create Business Partner",
					funct  	: "CREATE_BP",
                    icon    : "sap-icon://add-product",
                    visible : true
                },
                {
                    title   : "Display Business Partner",
                    icon    : "sap-icon://business-card",
					funct  	: "DISPLAY_BP",
                    visible : true
                },
                {
                    title   : "Business Partner Listing",
                    icon    : "sap-icon://checklist-item",
					funct  	: "BP_LIST",
                    visible : true
                },
				{
                    title   : "Test",
                    icon    : "sap-icon://checklist-item",
					funct  	: "BP_TEST",
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
						go_App_Right.back();
					} 
				}).addStyleClass('buttonHeaderColor'),
				new sap.m.Button({icon:"sap-icon://menu2",
					press:function(){
						go_SplitContainer.setSecondaryContentWidth("250px");
						if(!go_SplitContainer.getShowSecondaryContent()){
							go_SplitContainer.setShowSecondaryContent(true);
						} else {							
							go_SplitContainer.setShowSecondaryContent(false);
						}
					
					}
				}).addStyleClass('buttonHeaderColor'), 
				
			],
			contentRight:[
				new sap.m.Button({
					icon: "sap-icon://home",
					press: function(){
						window.location.href = MainPageLink; 
					}
				}).addStyleClass('buttonHeaderColor')
			],
			contentMiddle:[
                new sap.m.Label("BP_TITLE",{text:"Create Business Partner"})
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
		let errorPanel = new sap.m.Panel("MESSAGE_STRIP_BP_ERROR",{visible:false});
        let createPageFormHeader = new sap.uxap.ObjectPageLayout({
            headerTitle:[
                new sap.uxap.ObjectPageHeader("OBJECTHEADER_BP_NAME",{
                    objectTitle:"",
					showPlaceholder : false,
					actions:[
                        new sap.uxap.ObjectPageHeaderActionButton("CREATE_BP_SAVE_BTN1",{
                            icon: "sap-icon://save",
							press: function(evt){
								createBP();

                            }
                        }).addStyleClass("sapMTB-Transparent-CTX"),
                        new sap.uxap.ObjectPageHeaderActionButton("CREATE_BP_EDIT_BTN1",{
                            icon: "sap-icon://edit",
							press: function(){
									ui("COMPCODE_SAVE_DIALOG").open();
                            }
                        }).addStyleClass("sapMTB-Transparent-CTX"),

                    ],
                })
            ]     
        });

		let createPageFormContent = new sap.m.Panel("BP_GENERAL_PANEL",{
			headerToolbar: [
				new sap.m.Toolbar({
                    content: [
                        new sap.m.ToolbarSpacer(),
                        new sap.m.Button("CREATE_BP_SAVE_BTN", {
                            visible: true,
                            icon: "sap-icon://save",
                            press: function () {
								ui('INPUT_BP_ID').setValueState("None").setValueStateText("");
								ui('MESSAGE_STRIP_BP_ERROR').destroyContent().setVisible(false);
								let bpId = ui('INPUT_BP_ID').getValue().trim();
								let message = "";
								let lv_message_strip = "";
									if(bpId){
										if(screenMode._mode == "create"){
											let isExist = bpDataOrganizer._validateBP(bpId);
											if(isExist){
												message = "Business Partner ID already exist";
												ui('INPUT_BP_ID').setValueState("Error").setValueStateText(message);
												lv_message_strip = fn_show_message_strip("MESSAGE_STRIP_BP_ERROR",message);
												ui('MESSAGE_STRIP_BP_ERROR').setVisible(true).addContent(lv_message_strip);
											}else{
												ui('BP_SAVE_DIALOG').open();
											}
										}else{
											ui('BP_SAVE_DIALOG').open();
										}
										
									}else{
										message = "Business Partner ID is mandatory";
										ui('INPUT_BP_ID').setValueState("Error").setValueStateText(message);
										lv_message_strip = fn_show_message_strip("MESSAGE_STRIP_BP_ERROR",message);
										ui('MESSAGE_STRIP_BP_ERROR').setVisible(true).addContent(lv_message_strip);
									}
												
                            }
                        }),
						new sap.m.Button("CREATE_BP_EDIT_BTN", {
                            visible: true,
                            icon: "sap-icon://edit",
                            press: function () {
								screenMode._edit();
                            }
                        }),
						new sap.m.Button("CREATE_BP_CANCEL_BTN", {
                            visible: true,
                            icon: "sap-icon://decline",
                            press: function () {
								screenMode._display(screenMode._id);
                            }
                        }),
						new sap.m.Button("CREATE_BP_DEL_BTN", {
                            visible: true,
                            icon: "sap-icon://delete",
                            press: function () {
								ui('BP_DELETE_DIALOG').open();
                            }
                        }),
                    ]
                }).addStyleClass('class_transparent_bar'),

			],
			content: [
                new sap.ui.layout.Grid({
                    defaultSpan:"L12 M12 S12",
					width:"auto",
					content:[
                        new sap.ui.layout.form.SimpleForm("PANEL_FORM",{
							title: "New Business Partner",
                            maxContainerCols:2,
							labelMinWidth:130,
							content:[
                                new sap.ui.core.Title("GENERAL_INFO_TITLE1",{text:""}),
                                new sap.m.Label({text:"Business Partner Type",width:"160px"}).addStyleClass('class_label_padding'),
								new sap.m.Select("BP_TYPE_INFO",{
									width:TextWidth,
									//selectedKey: "",
									items: [
										new sap.ui.core.ListItem({
											text: "IBM",
											key: "IBM",
											additionalText: "IBM",
											icon: "sap-icon://along-stacked-chart"
										}),
										new sap.ui.core.ListItem({
											text: "ACT",
											key: "ACT",
											additionalText: "ACT",
											icon: "sap-icon://chart-table-view"
										}),
										new sap.ui.core.ListItem({
											text: "BFA",
											key: "BFA",
											additionalText: "BFA",
											icon: "sap-icon://permission"
										})
									]
								}),
                                new sap.m.Label({text:"Registered Name",width:labelWidth}).addStyleClass('class_label_padding'),
								new sap.m.Input("BP_TYPE_REGNAME",{value:"", width:TextWidth}),
                            	new sap.m.Label({text:"Business Partner ID",width:"150px"}).addStyleClass('class_label_padding'),
								new sap.m.Input("INPUT_BP_ID",{
									value:"", 
									width:TextWidth,
									liveChange: function(oEvt){
										fn_livechange_numeric_input(oEvt);
									},
									change : function(oEvt){
										let lv_value = oEvt.getSource().getValue().trim();
										let label = "New Business Partner"
										let lv_bpid = label + " (" + lv_value + ")";
										ui("PANEL_FORM").setTitle(lv_bpid);
										
									}
								}),
								new sap.m.Label({text:"Company",width:"150px"}).addStyleClass('class_label_padding'),
								new sap.m.RadioButtonGroup("BP_COMPANY",{
									buttons: [
										new sap.m.RadioButton({
											id:"ACN",
											text: "Accenture"
										}),
										new sap.m.RadioButton({
											id:"CDA",
											text: "Coding Avenue"
										}),
										new sap.m.RadioButton({
											id:"SUN",
											text: "Sun Asterisk"
										}),
									]
								}),
                                new sap.ui.core.Title("GENERAL_INFO_TITLE2",{text:""}),
                                new sap.m.Label({text:"External Partner",width:labelWidth}).addStyleClass('class_label_padding'),
								new sap.m.Input("BP_TYPE_EXTPARTNER",{value:"", width:TextWidth}),
								
								new sap.m.Label({text:"Source System",width:labelWidth}).addStyleClass('class_label_padding'),
								new sap.m.Input("INPUT_CONTROL_INFO_SOURCE_SYS",{width:TextWidth,maxLength:10}),
									
                                new sap.m.Label({text:"Deletion Flag",width:labelWidth}).addStyleClass('class_label_padding'),
								new sap.m.Switch("CONTROL_INFO_DEL_FLAG",{state:false}),
                            ]
                        })
                    ]
                })
            ]
        });

        page.setCustomHeader(pageHeader);
        page.addContent(crumbs);
		page.addContent(errorPanel);
        //page.addContent(createPageFormHeader);
		page.addContent(createPageFormContent);
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
				}).addStyleClass('buttonHeaderColor'),
				new sap.m.Button({icon:"sap-icon://menu2",
					press:function(){
						go_SplitContainer.setSecondaryContentWidth("250px");
						if(!go_SplitContainer.getShowSecondaryContent()){
							go_SplitContainer.setShowSecondaryContent(true);
						} else {							
							go_SplitContainer.setShowSecondaryContent(false);
						}
					}
				}).addStyleClass('buttonHeaderColor')
				//new sap.m.Image({src: logo_path}),
			],

			contentMiddle:[gv_Lbl_NewPrdPage_Title = new sap.m.Label("DISP_BP_TITLE",{text:"Display Business Partner"})],
			
			contentRight:[
				new sap.m.Button({
					icon: "sap-icon://home",
					press: function(){
						window.location.href = MainPageLink; 
					}
				}).addStyleClass('buttonHeaderColor')
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
					liveChange: function(oEvt){
						var lv_search_val = oEvt.getSource().getValue().trim();
						if(lv_search_val == ""){
							ui("DISPLAY_BP_TABLE").setVisible(false);
						}
					},
					placeholder: "Search...",
					search: function(oEvent){
						var lv_searchval = oEvent.getSource().getValue().trim();
						displayBp._get_data(lv_searchval);
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
						new sap.m.Text("DISPLAY_BP_TABLE_LABEL",{text:"List (0)"}),
					]
				})
			],
			filter:function(oEvt){
				oEvt.getSource().getBinding("rows").attachChange(function(oEvt){
					var lv_row_count = oEvt.getSource().iLength;
					ui('DISPLAY_BP_TABLE_LABEL').setText("List (" + lv_row_count + ")");
				});
			},
			cellClick: function(oEvt){
				
				var lv_bind = oEvt.getParameters().rowBindingContext;
				
				if(lv_bind != undefined){
					var lv_bp_id = oEvt.getParameters().rowBindingContext.getProperty("BIZPART_ID");
					if(lv_bp_id){
						screenMode._display(lv_bp_id);
					}
				}
				
			},
			columns: [
			
				new sap.ui.table.Column({label:new sap.m.Text({text:"Business Partner ID"}),
					width:"20%",
					sortProperty:"BIZPART_ID",
					filterProperty:"BIZPART_ID",
					autoResizable:true,
					template:new sap.m.Text({text:"{BIZPART_ID}",maxLines:1}),
				}),
				new sap.ui.table.Column({label:new sap.m.Text({text:"Business Partner Name"}),
					width:"40%",
					sortProperty:"NAME1",
					filterProperty:"NAME1",
					autoResizable:true,
					template:new sap.m.Text({text:"{NAME1}",tooltip:"{NAME1}",maxLines:1}),
				}),
				new sap.ui.table.Column({label:new sap.m.Text({text:"External Partner"}),
					width:"40%",
					sortProperty:"EXT_PARTNER",
					filterProperty:"EXT_PARTNER",
					autoResizable:true,
					template:new sap.m.Text({text:"{EXT_PARTNER}",tooltip:"{EXT_PARTNER}",maxLines:1}),
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
				}).addStyleClass('buttonHeaderColor'),
				new sap.m.Button({icon:"sap-icon://menu2",
					press:function(){
						go_SplitContainer.setSecondaryContentWidth("270px");
						if(!go_SplitContainer.getShowSecondaryContent()){
							go_SplitContainer.setShowSecondaryContent(true);
						} else {							
							go_SplitContainer.setShowSecondaryContent(false);
						}
					}
				}).addStyleClass('buttonHeaderColor'), 
				//new sap.m.Image({src: logo_path}),
				],
			contentMiddle:[gv_Lbl_NewPrdPage_Title = new sap.m.Label("BP_LISTING_PAGE_LABEL",{text:"Business Partner Listing"})],
			
			contentRight:[
				//fn_help_button(SelectedAppID,"BP_LISTING"),
				new sap.m.Button({  
					icon: "sap-icon://home",
					press: function(){
					window.location.href = MainPageLink; 
					}
				}).addStyleClass('buttonHeaderColor')
			]
		});
					
		var lv_crumbs = new sap.m.Breadcrumbs("LIST_BP_BRDCRMS",{
			currentLocationText: "Business Partner Listing",
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
					var lv_bp_id = oEvt.getParameters().rowBindingContext.getProperty("BIZPART_ID");
					if(lv_bp_id){
						screenMode._display(lv_bp_id);
					}
				}
			},
			columns:[
				
				new sap.ui.table.Column({label:new sap.m.Text({text:"Business Partner ID"}),
					width:"180px",
					sortProperty:"BIZPART_ID",
					filterProperty:"BIZPART_ID",
					//autoResizable:true,
					template:new sap.m.Text({text:"{BIZPART_ID}",tooltip:"{BIZPART_ID}",maxLines:1}),
				}),
				new sap.ui.table.Column({label:new sap.m.Text({text:"Business Partner Type"}),
					width:"250px",
					sortProperty:"TYPE",
					filterProperty:"TYPE",
					autoResizable:true,
					template:new sap.m.Text({text:"{TYPE}",tooltip:"{TYPE}",maxLines:1}),
				}),
				new sap.ui.table.Column({label:new sap.m.Text({text:"Registered Name"}),
					width:"350px",
					sortProperty:"NAME1",
					filterProperty:"NAME1",
					template:new sap.m.Text({text:"{NAME1}",tooltip:"{NAME1}",maxLines:1}),
				}),
				new sap.ui.table.Column({label:new sap.m.Text({text:"External Partner"}),
					width:"400px",
					sortProperty:"EXT_PARTNER",
					filterProperty:"EXT_PARTNER",
					template:new sap.m.Text({text:"{EXT_PARTNER}",tooltip:"{EXT_PARTNER}",maxLines:1}),
				}),
				
				
				new sap.ui.table.Column({label:new sap.m.Text({text:"Created By"}),
					width:"160px",
					sortProperty:"created_by",
					filterProperty:"created_by",
					template:new sap.m.Text({text:"{created_by}",tooltip:"{created_by}",maxLines:1}),
				}),
				new sap.ui.table.Column({label:new sap.m.Text({text:"Creation Date"}),
					width:"150px",
					sortProperty:"created_at",
					filterProperty:"created_at_desc",
					template:new sap.m.Text({text:"{created_at_desc}",tooltip:"{created_at_desc}",maxLines:1}),
				}),
				
			]

		});

		lv_Page.setCustomHeader(lv_header);
		lv_Page.addContent(lv_crumbs);
		lv_Page.addContent(lv_table);


		return lv_Page;
	}

	function createTestPage(){
		let page = new sap.m.Page("TEST_PAGE",{}).addStyleClass('sapUiSizeCompact');
		let crumbs = new sap.m.Breadcrumbs("TEST_CRUMBS",{
			currentLocationText: "Business Partner Listing",
			links: [
				new sap.m.Link({
					text:"Home",
					press:function(oEvt){
					// fn_click_breadcrumbs("HOME");
					}
				}),
				new sap.m.Link("TEST_LIST_CRUMBS",{
					text:"Business Partner Management",
					press:function(oEvt){
					//  fn_click_breadcrumbs("HOME");
					}
				}),
				
			]
		}).addStyleClass('breadcrumbs-padding');

		//page.addContent(crumbs);
		return page;


	}



</script>