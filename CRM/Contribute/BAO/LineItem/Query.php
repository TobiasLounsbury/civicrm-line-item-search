<?php


class CRM_Contribute_BAO_LineItem_Query {

    const JOIN_BY_NONE = 0;
    const JOIN_BY_CONTRIBUTION = 1;
    const JOIN_BY_MEMBERSHIP = 2;
    const JOIN_BY_EVENT = 3;

    //static $_lineItemFields = NULL;
    static $_priceFieldValues = NULL;


    function __construct() {
        $this->_joinby = self::JOIN_BY_NONE;
    }

    function &getFields() {
        if (!isset($this->_lineItemFields)) {
            $this->_lineItemFields = array();

            $LIFields = CRM_Price_DAO_LineItem::fields();

            unset($LIFields['entity_table']);
            unset($LIFields['entity_id']);
            unset($LIFields['participant_count']);
            unset($LIFields['deductible_amount']);
            unset($LIFields['price_field_id']);
            unset($LIFields['contribution_id']);
            unset($LIFields['id']);

            $fields = array();
            //FKClassName, export, import, headerPattern, dataPattern
            foreach ($LIFields as $name => $field) {
                //$field['where'] = "civicrm_line_item.".$field['name'];
                $field['export'] = true;
                $field['import'] = true;
                unset($field['required']);
                $fields['lineitems_'.$name] = $field;
            }

            /*
            $fields['lineitems_join_type'] = array(
                'name'  => 'join_type',
                'title' => 'Join Type',
                'type'  => CRM_Utils_Type::T_INT,
            );
            */


            //todo: Add field for join selector


            $this->_lineItemFields = $fields;
        }
        return $this->_lineItemFields;
    }
    function select(&$query) {
        if (CRM_Contact_BAO_Query::componentPresent($query->_returnProperties, 'lineitems_')) {
            $fields = $this->getFields();

        }
    }
    public function where(&$query) {
        $grouping = NULL;
        $myparams = array();
        foreach (array_keys($query->_params) as $id) {
            if (empty($query->_params[$id][0])) {
                continue;
            }
            if ($query->_params[$id][0] == "lineitems_join_type") {
                $this->_joinby = $query->_params[$id][2];
            }
            elseif (substr($query->_params[$id][0], 0, 10) == 'lineitems_') {
                if ($query->_mode == CRM_Contact_BAO_QUERY::MODE_CONTACTS) {
                    $query->_useDistinct = TRUE;
                }
                $myparams[] = $id;

            }
        }
        foreach($myparams as $id) {
            $this->whereClauseSingle($query->_params[$id], $query);
        }
    }
    public function whereClauseSingle(&$values, &$query)
    {
        list($name, $op, $value, $grouping, $wildcard) = $values;
        //Filter output based on $this->_joinby

        $fields = $this->getFields();
        if (!empty($value) && !is_array($value)) {
            $quoteValue = "\"$value\"";
        }

        /*
        switch ($name) {

        default:
            if (!isset($fields[$name])) {
                CRM_Core_Session::setStatus(ts(
                        'We did not recognize the search field: %1.',
                        array(1 => $name)
                    )
                );
                return;
            }
        }
        */
    }

    function from($name, $mode, $side) {
        error_log("test");
        $from = NULL;
        if($name == "civicrm_lineitems") {
            error_log("Something");
        }
        return $from;
    }


    /*
    public function buildSearchForm(&$form) {
        error_log("test");
    }
    public function searchAction(&$row, $id) {
        error_log("test");
    }
    public function tableNames(&$tables) {
        error_log("test");
    }
    */

    function setTableDependency(&$tables) {
        if (!empty($tables['civicrm_lineitem'])) {
            $tables = array_merge(array('civicrm_lineitem' => 1), $tables);
        }
    }


    /***[  Register the LineItems Search Pane on the advanced search page  ]***/
    public function registerAdvancedSearchPane(&$panes) {
        if (!CRM_Core_Permission::check('access CiviContribute')) return;
        $panes['Line Items'] = 'lineitems';
    }


    public function getPanesMapper(&$panes) {
        if (!CRM_Core_Permission::check('access CiviContribute')) return;
        $panes['Line Items'] = 'civicrm_lineitems';
    }

    /***[  Add filter ui items to the pane  ]***/
    public function buildAdvancedSearchPaneForm(&$form, $type) {
        if ($type  == 'lineitems') {

            $form->add('hidden', 'hidden_lineitems', 1);
            $form->addRadio("lineitems_join_type", ts("Join Type"),
                array(0 => ts("None"), 1 => ts("Contribution"), 2 => ts("Membership"), 3 => ts("Event/Participant")),
                array("allowClear" => 1));

            $form->add('text', 'lineitems_label', ts('Label'), array("size" => 45));
            $form->add('text', 'lineitems_unit_price_from', ts('From:'), array("size" => 8));
            $form->addRule('lineitems_unit_price_from', ts('Please enter a valid money value (e.g. %1).', array(1 => CRM_Utils_Money::format('9.99', ' '))), 'money');
            $form->add('text', 'lineitems_unit_price_to', ts('To:'), array("size" => 8));
            $form->addRule('lineitems_unit_price_to', ts('Please enter a valid money value (e.g. %1).', array(1 => CRM_Utils_Money::format('9.99', ' '))), 'money');
            $form->add('text', 'lineitems_qty', ts('Quantity'), array("size" => 3));
            $form->add('text', 'lineitems_line_total_from', ts('From:'), array("size" => 8));
            $form->addRule('lineitems_line_total_from', ts('Please enter a valid money value (e.g. %1).', array(1 => CRM_Utils_Money::format('9.99', ' '))), 'money');
            $form->add('text', 'lineitems_line_total_to', ts('To:'), array("size" => 8));
            $form->addRule('lineitems_line_total_to', ts('Please enter a valid money value (e.g. %1).', array(1 => CRM_Utils_Money::format('9.99', ' '))), 'money');

            $financialTypes = CRM_Contribute_PseudoConstant::financialType();
            $form->add('select', 'lineitems_financial_type_id', ts('Financial Type(s)'), $financialTypes, FALSE,
                array('id' => 'lineitems_financial_type', 'multiple' => 'multiple', 'class' => 'crm-select2', 'style' => 'width: 500px;')
            );
            //
            //data = data
            $fieldValues = $this->getPriceFieldValues();
            $dataSelectParams = array("data" => $fieldValues, 'multiple' => 'multiple');

            $form->add('text', 'lineitems_ps_field_value_id', ts('Price Field Value(s)'),
                array('id' => 'lineitems_ps_field_value_id',
                    'multiple' => 'multiple',
                    'class' => 'crm-select2',
                    'style' => 'width: 500px;',
                    'data-select-params' => json_encode($dataSelectParams))
            );

        }
    }

    /***[ Connect the LineItem pane to the LinteItem template  ]***/
    public function setAdvancedSearchPaneTemplatePath(&$paneTemplatePathArray, $type) {
        if (!CRM_Core_Permission::check('access CiviContribute')) return;
        if ($type  == 'lineitems') {
            $paneTemplatePathArray['lineitems'] = 'LineItemSearch/Form/Search/Criteria/LineItem.tpl';
        }
    }
    public function alterSearchBuilderOptions(&$apiEntities, &$fieldOptions) {
        if (!CRM_Core_Permission::check('access CiviContribute')) return;
        $apiEntities = array_merge($apiEntities, array(
            'LineItem'
        ));
    }




    /***[   Helper functions   ]***/

    //Returns all pricesets
    function getPriceSets() {
        if (isset($this->_priceSets)) {
            return $this->_priceSets;
        }
        $params = array("sequential" => 1, "return" => "title");
        $psets = civicrm_api3("PriceSet", "get", $params);

        $options = array();
        if ($psets['is_error'] == 0) {
            foreach($psets['values'] as $set) {
                $options[$set['id']] = ts($set['title']);
            }
        }
        $this->_priceSets = $options;
        return $this->_priceSets;
    }

    //Returns a nested array of pricesets->PriceFields->FieldValues
    //For use in the FieldValue filter UI element
    function getPriceFieldValues() {
        if (isset($this->_priceFieldValues)) {
            //return $this->_priceFieldValues;
        }
        if (self::$_priceFieldValues) {
            return self::$_priceFieldValues;
        }


        $apiData =civicrm_api3('PriceSet', 'get', array(
            'return' => "title,price_set_id",
            'sequential' => 1,
            'api.PriceField.get' => array("return" => "label",
                'api.PriceFieldValue.get' => array("return" => "label"),
            ),
        ));

        $data = array();
        if ($apiData['is_error'] == 0) {
            foreach($apiData['values'] as $pset) {
                $pdata = array();
                foreach($pset['api.PriceField.get']['values'] as $field) {
                    $fdata = array();
                    foreach ( $field['api.PriceFieldValue.get']['values'] as $fieldValue) {
                        $fdata[] = array("id" => $fieldValue['id'], "text" => ts($fieldValue['label']));
                    }
                    if(count($fdata) == 1) {
                        $pdata[] = $fdata[0];
                    } else {
                        $pdata[] = array("text" => $field['label'], "children" => $fdata);
                    }
                }
                $data[] = array("text" => $pset['title'], "children" => $pdata);
            }
        }


        //$this->_priceFieldValues = $data;
        //return $this->_priceFieldValues;

        self::$_priceFieldValues = $data;
        return self::$_priceFieldValues;
    }
}