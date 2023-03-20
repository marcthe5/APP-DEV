<script>
    const createBP = () => {
    let createBPdetails = {
       
        APPDEV_TYPE : ui("DELIVERY_ADDRESS").getValue().trim(),
        APPDEV_NAME : ui("EMP_NAME").getValue().trim();
        APPDEV_NUMBER : ui("EMP_NUMBER").getValue().trim();
        APPDEV_EMAIL : ui("EMP_EMAIL").getValue().trim();
        APPDEV_DELIVERDATE : ui("EMP_DELIVERY_DATE").getValue().trim();
        APPDEV_DELIVERYTIME : ui("EMP_DELIVERY_TIME").getValue().trim();
        APPDEV_DELIVERYINSTRUCTION : ui("EMP_DELIVERY_INSTRUCTION").getValue().trim();
        APPDEV_SHIPMETHOD: ui("EMP_SHIPPING_METHOD").getValue().trim();
        APPDEV_SHIPCARRIER : ui("EMP_SHIPPING_CARRIER").getValue().trim();
        APPDEV_TRACKNUM : ui("EMP_TRACKING_NUMBER").getValue().trim();
        APPDEV_PACKWEIGHT : ui("EMP_PACKAGE_WEIGHT").getValue().trim();
        APPDEV_PACKDIMENSION: ui("EMP_PACKAGE_DIMENSION").getValue().trim();
        APPDEV_DELIVERYCONFIRM: ui("EMP_DELIVERY_CONFIRMATION").getValue().trim();
        APPDEV_SIGNATURE: ui("EMP_SIGNATURE_REQUIRED").getValue().trim();
        APPDEV_ORDERNUM: ui("EMP_ORDER_NUMBER").getValue().trim();
        APPDEV_SHIPCOST: ui("EMP_SHIPPING_COST").getValue().trim();
        APPDEV_INSURANCE: ui("EMP_INSURANCE").getValue().trim();
        APPDEV_CUSTOMSINFO: ui("EMP_CUSTOMS_INFO").getValue().trim();
        APPDEV_ORDERSTATUS: ui("EMP_ORDER_STATUS").getValue().trim();

    };

    ui("DELIVERY_ADDRESS").setValue(createBPdetails.APPDEV_TYPE).setEditable(false);
    ui("EMP_NAME").setValue(createBPdetails.APPDEV_NAME).setEditable(false);
    ui("EMP_NUMBER").setValue(createBPdetails.APPDEV_NUMBER).setEditable(false);
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
    ui("EMP_ORDER_STATUS").setValue(createBPdetails.APPDEV_ORDERSTATUS).setEditable(false);
}
    </script>