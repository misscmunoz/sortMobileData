<?php

class View
{
    private $model;
    private $controller;
    private $rowKey = null;
    private $columnKey = array("make","model");
    private $output = '';

    /**
     * View constructor.
     * @param $controller
     * @param $model
     */
    public function __construct($controller,$model)
    {
        $this->controller = $controller;
        $this->model = $model;
    }


    /**
     * Create formatted columns
     * @param $columnItem
     * @param bool $return
     * @return string
     */
    public function getFormattedColumns($columnItem, $return = false)
    {
        //Loop through columns
        foreach ($columnItem as $column => $items)
        {
            //Add the table row
            $this->output .= "<tr>";
            $this->formatColumn($column, $columnItem[$column]);
            $this->output .= "</tr>";
        }

        if($return)
        {
            return $this->output;
        }
    }


    /**
     * Add column items to relevant table tags
     * @param $key
     * @param $items
     */
    public function formatColumn($key, $items)
    {
        foreach($items as $itemKey => $item)
        {
            //If it's a header, then put in table header <th> tag
            if (in_array($item, $this->model->labelList))
            {
                $this->output .= "<th>". ucfirst($item) ."</th>";
            }
            else
            {
                $this->output .= "<td>";
                $this->output .= ($itemKey == 2) ? "<a href='#' onclick='test.toggleMobileInfo(this,$key);return false;'>$item</a>" : $item;
                $this->output .= "</td>";
            }
        }
    }


    /**
     * Call this function to output formatted column
     */
    public function output()
    {
        //Get the list of values
        $this->controller->getListValues($this->rowKey,$this->columnKey);

        //Add to output the select dropDown
        $this->formatOptions();

        if(isset($this->model->columns))
        {
            $this->getFormattedColumns($this->model->columns);
        }

        print_r($this->output);
    }

    /**
     * Format sort options
     */
    public function formatOptions()
    {
        $this->output .= '<select id="sort">';

        foreach ($this->model->sortOptions as $option => $value)
        {
            $this->output .= "<option value='$option'> $value </option>";
        }

        $this->output .= '</select>';
    }
}