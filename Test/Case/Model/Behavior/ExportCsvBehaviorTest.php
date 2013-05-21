<?php

App::uses('Model', 'Model');
App::uses('AppModel', 'Model');
App::uses('Security', 'Utility');

class ExportCsvPost extends CakeTestModel {
    public $name = 'ExportCsvPost';

    public $actsAs = array('ExportCsv.ExportCsv');
}

class ExportCsvBehaviorTest extends CakeTestCase {
    public $fixtures = array(
        'plugin.export_csv.export_csv_post',
    );

    public function setUp() {
        $this->ExportCsvPost = new ExportCsvPost();
        $this->ExportCsvPostFixture = ClassRegistry::init('ExportCsvPostFixture');
    }

    public function tearDown() {
        unset($this->ExportCsvPost);
        unset($this->ExportCsvPostFixture);
    }

    public function testExportCsv() {
        // 期待値を用意
        $expected_headers = array_keys($this->ExportCsvPostFixture->fields);
        $expected_records = array();
        foreach($this->ExportCsvPostFixture->records as $val) {
            $expected_records[] = array_values($val);
        }

        // 一時ファイルにCSV出力
        $query = 'SELECT * FROM export_csv_posts ORDER BY id ASC';
        $tmp_filename = TMP . Security::generateAuthKey() . '.csv';
        $this->ExportCsvPost->exportCsv($query, $tmp_filename, $expected_headers);

        // 出力したファイルを開いて比較
        $fh = fopen($tmp_filename, 'r');

        $csv_headers = fgetcsv($fh);

        // ヘッダの存在チェック
        $this->assertEqual(($csv_headers !== false), true);

        $csv_records = array();

        while(($data = fgetcsv($fh)) !== false) {
            $csv_records[] = $data;
        }

        fclose($fh);

        // 一時ファイル削除
        unlink($tmp_filename);

        // 内容比較
        $this->assertEqual(($csv_headers == $expected_headers), true);
        $this->assertEqual(($csv_records == $expected_records), true);
    }
}
