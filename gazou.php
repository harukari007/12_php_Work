<?php
session_start();
include('functions.php');
check_session_id();

/**
 * 画像をサーバーに保存する関数
 * 
 * @param array $file アップロードされたファイル情報
 * @return string|bool 画像の保存パス、または保存失敗時にfalse
 */
function save_image($file)
{
    $upload_dir = 'uploads/'; // 画像を保存するディレクトリ
    $upload_file = $upload_dir . basename($file['name']); // 保存パスを設定

    // ファイルを指定したディレクトリに移動
    if (move_uploaded_file($file['tmp_name'], $upload_file)) {
        return $upload_file; // 保存成功時に保存パスを返す
    } else {
        return false; // 保存失敗時にfalseを返す
    }
}

// 画像がアップロードされた場合の処理
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['image'])) {
    $image_path = save_image($_FILES['image']);
    if ($image_path) {
        // 画像保存成功
        echo "画像が正常に保存されました: " . $image_path;
    } else {
        // 画像保存失敗
        echo "画像の保存に失敗しました。";
    }
} else {
    echo "画像がアップロードされていません。";
}
