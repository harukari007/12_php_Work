<?php
// セッションがまだ開始されていない場合、セッションを開始する
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// データベース接続関数がすでに定義されていない場合に定義する
if (!function_exists('connect_to_db')) {
    /**
     * データベースに接続する関数
     * 
     * @return PDO データベース接続オブジェクト
     */
    function connect_to_db()
    {
        // データベース接続情報
        $dbn = 'mysql:dbname=gs_lab10_01;charset=utf8;port=3306;host=localhost';
        $user = 'root';
        $pwd = '';

        try {
            // PDOを使ってデータベースに接続
            return new PDO($dbn, $user, $pwd);
        } catch (PDOException $e) {
            // 接続エラー時にエラーメッセージを表示して終了
            exit('DB Error:' . $e->getMessage());
        }
    }
}

// セッションIDをチェックする関数がすでに定義されていない場合に定義する
if (!function_exists('check_session_id')) {
    /**
     * セッションIDをチェックし、無効な場合はログインページにリダイレクト
     */
    function check_session_id()
    {
        // セッションIDが設定されていないか、現在のセッションIDと一致しない場合
        if (!isset($_SESSION['session_id']) || $_SESSION['session_id'] != session_id()) {
            // ログインページにリダイレクト
            header('Location: eatchat_login.php');
            exit();
        } else {
            // セッションIDを再生成してセッションIDを更新
            session_regenerate_id(true);
            $_SESSION['session_id'] = session_id();
        }
    }
}
