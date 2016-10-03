<?php

class Model
{
    public $data;
    public $sortOptions;
    public $labelList;

    /**
     * Model constructor.
     */
    function __construct()
    {
        //Put the data into our array
        $this->data = (array_map('str_getcsv', file('assets/csv/data.csv')));

        //Column names
        $this->labelList =  array(
            "code",
            "make",
            "model",
            "name",
            "type",
            "tar_code",
            "tar_name",
            "tar_minutes",
            "tar_sms",
            "tar_data"
        );

        //Sort options, used for select dropDown
        $this->sortOptions = array(
            "Relevance",
            "Make ASC",
            "Make DESC",
            "Highest Minutes",
            "Highest SMS",
            "Highest Data"
        );
    }
}