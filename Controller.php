<?php

class Controller
{
    private $model;
    private $header;

    /**
     * Controller constructor.
     * @param $model
     */
    public function __construct($model)
    {
        $this->model = $model;
    }

    /**
     * Add column to an array
     * @param $row
     * @param $key
     * @param $column
     */
    function addColumn($row,$key, $column)
    {
        $this->model->columns[$row][$key] = $column;
    }

    /**
     * Add row to an array
     * @param $rowKey
     * @param $row
     */

    function addRow($rowKey,$row)
    {
        $this->model->rows[$rowKey] = $row;
    }

    /**
     * Find column
     * @param $row
     * @param $columnKey
     */
    function findColumn($row,$columnKey)
    {
        for($column = 0; $column < count($columnKey); $column++)
        {
            //Loop through each column
            foreach($this->model->data[$row] as $key => $columnValue)
            {
                if ($this->getField($columnKey[$column]) === $key)
                {
                    $this->addColumn($row,$key, $columnValue);
                }
            }
        }
    }

    /**
     * Used in ajaxHandler.php to find row
     *
     * @param $rowKey
     * @return string
     */
    function findRowJS($rowKey)
    {
       $this->getListValues($rowKey);

        if(isset($rowKey))
        {
            $this->getListValues(0);
            $this->model->rows = array_combine($this->model->rows[0],$this->model->rows[$rowKey]);
        }

       return json_encode($this->model->rows);
    }

    /**
     * Used in to sort columns
     * @param $columns
     * @param $sortBy
     */
    function sortColumns($columns,$sortBy)
    {
        //Get list using columns
        $this->getListValues(null,$columns);
        
        switch($sortBy)
        {
            case 0:
                $this->getListValues(null,array("make","model")); break;
            case 1:
                //Remove header, so it doesn't get sorted
                $this->removeHeader();

                asort($this->model->columns);

                //Add back the header
                array_unshift($this->model->columns, $this->header);
                break;
            case 2:
            default:
                arsort($this->model->columns); break;
        }

        echo json_encode($this->model->columns);
    }

    function removeHeader()
    {
        $this->header = $this->model->columns[0];
        unset($this->model->columns[0]);
    }

    /**
     * Get all of the corresponding row or column
     *
     * @param null $rowKey
     * @param null $columnKey
     */
    function getListValues($rowKey = null, $columnKey = null)
    {
        if(isset($this->model->data))
        {
            //Loop through all of the data
            for($row = 0; $row < count($this->model->data); $row++)
            {
                //Check if $columnKey exists
                if(isset($columnKey) && is_array($columnKey))
                {
                    //Loop through $key and find relevant columns
                    $this->findColumn($row, $columnKey);
                }

                //Check if there's a key that's been passed
                if(isset($rowKey))
                {
                    if ($rowKey == $row)
                    {
                        $this->addRow($rowKey, $this->model->data[$row]);
                    }
                }
            }
        }
    }

    /**
     * Get the key for field
     * @param $field
     * @return int
     */
    function getField($field)
    {
        switch($field)
        {
            case 'code':
                return 0; break;
            case 'make':
                return 1; break;
            case 'model':
                return 2; break;
            case 'name':
                return 3; break;
            case 'type':
                return 4; break;
            case 'tar_code':
                return 5; break;
            case 'tar_name':
                return 6; break;
            case 'tar_minutes':
            case 'minutes':
                return 7; break;
            case 'tar_sms':
            case 'sms':
                return 8; break;
            case 'tar_data':
            case 'data':
                return 9; break;

        }
    }

    /**
     * Used in ajaxHandler to get the data after sorting
     * @param $sortID
     */
    function getSortValues($sortID)
    {
        $column = null;
        $sort = null;

        switch($sortID)
        {
            case 0:
                $column = null; break;
            case 1:
            case 2:
                $column = "make"; break;
            case 3:
                $column = "minutes"; break;
            case 4:
                $column = "sms"; break;
            case 5:
                $column = "data"; break;
        }

        switch($sortID)
        {
            /*
             * 0 = String Descending
             * 1 = String Ascending
             *
             */
            case 0:
                $sort = 0; break;
            case 1:
                $sort = 1; break;
            default:
                $sort = 2; break;
        }

        $this->sortColumns(array($column,"make","model"), $sort);
    }
}
