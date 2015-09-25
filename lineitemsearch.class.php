<?php

class CRM_LineItemSearch_Query_Interface extends CRM_Contact_BAO_Query_Interface {






    public function &getFields() {

        if(isset($this->qo)) {
            return $this->qo;
        }

        $this->qo = array(
            'lineitem_financial_type' => array(
                "dataPattern" => "",
                "export" => true,

                "name" => "financial_type_id",
                "title" => "LineItem Financial Type",

                //This is a constant for data types the defs can be found in packages/DB/DataObject.php
                //1 = int
                //2 = string
                //4 = date
                //8 = time
                "type" => 1,

                //Other options that are possible
                //"required" => true,
                //"html" => array("type" => ""),
                //"headerPattern" => "",
                //"FKClassName" => "CRM_Contact_DAO_Contact",
                //"import" = true,
                //"maxlength" = 255,
                //"hasLocationType" => true,
                //"size" => 45,
                //"rule" => "url",


                //This should be the table and column eg civicrm_line_item.financial_type_id
                "where" => "civicrm_line_item.financial_type_id"
            ),
        );

        return $this->qo;
    }

    public function from($fieldName, $mode, $side) {

        error_log("something");

    }
}