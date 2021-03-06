<?php

class ExportCsvPostFixture extends CakeTestFixture {
    public $name = 'ExportCsvPost';

    public $fields = array(
        'id' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'length' => 20, 'key' => 'primary'),
        'title' => array('type' => 'text', 'null' => true, 'default' => NULL, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
        'body' => array('type' => 'text', 'null' => true, 'default' => NULL, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
        'created' => array('type' => 'datetime', 'null' => true, 'default' => NULL),
        'modified' => array('type' => 'datetime', 'null' => true, 'default' => NULL),
    );

    public $records = array(
        array(
            'id' => 1,
            'title' => 'Title',
            'body' => 'ExportCsv.ExportCsv Test',
            'created' => '2011-08-23 17:44:58',
            'modified' => '2011-08-23 12:05:02',
        ),
        array(
            'id' => 401,
            'title' => '日本語',
            'body' => 'あいうえお',
            'created' => '2011-08-23 17:44:58',
            'modified' => '2011-08-23 12:05:02',
        ),
    );
}
