<?php

class ExportCsvBehavior extends ModelBehavior {

    /**
     * SQL文の実行結果をCSVとしてfputcsvでファイル出力する
     * 文字コードと改行文字は変更しない
     */
    public function exportCsv(Model $model, $query, $filename, $headers = array()) {
        // モデルのデータソースがDboSourceベースの場合だけ対応
        $db = $model->getDataSource();
        if(!is_subclass_of($db, 'DboSource')) {
            throw new InternalErrorException();
        }

        // SQLを実行
        $result = $db->rawQuery($query);
        if($result === false) {
            return false;
        }

        // ファイルオープン
        $fh = fopen($filename, 'w');
        if($fh === false) {
            return false;
        }

        // ヘッダーが指定されていたら出力する
        if(!empty($headers)) {
            fputcsv($fh, $headers);
        }

        // 行単位で出力する
        if($db->hasResult()) {
			$db->resultSet($result);
            while($item = $db->fetchResult()) {
                fputcsv($fh, Set::flatten($item));
            }
        }

        // ファイルクローズ
        fclose($fh);
        
        return true;
    }
}
