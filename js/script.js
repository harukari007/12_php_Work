let interval;

function generateResponse() {
    // ユーザーが入力したテキストボックスの要素を取得
    const input = document.getElementById("text");

    // 出力用のテキストエリアの要素を取得
    const out = document.getElementById("output");

    // 新しいXMLHttpRequestオブジェクトを作成
    const request = new XMLHttpRequest();

    // readyStateが変更されたときに呼び出される関数を定義
    request.onreadystatechange = function () {
        // リクエストが完了し、サーバーのステータスが200（成功）である場合
        if (request.readyState == 4 && request.status == 200) {
            input.value = "";
            out.value = "";
            // サーバーからのレスポンスをアラート表示
            // alert(request.responseText);
            // サーバーからのレスポンスを変数に格納
            const text = request.responseText;
            // 文字のインデックスを初期化
            let i = 0;
            // setIntervalを使用して、一定間隔で文字を1つずつ追加
            interval = setInterval(function () {
                // 現在のインデックスがテキストの長さより小さい場合
                if (i < text.length) {
                    // テキストエリアの内容に次の文字を追加
                    out.value = out.value + text.charAt(i);

                    // テキストエリアをスクロール
                    out.scrollTop = out.scrollHeight;
                    
                    // インデックスをインクリメント
                    i++;
                } else {
                    // インデックスがテキストの長さに達したらインターバルをクリア
                    clearInterval(interval);
                }
            }, 20);// 20ミリ秒ごとに実行
        }
    };
    // GETリクエストを初期化
    // "generateResponse.php"はサーバー側のスクリプトで、クエリパラメータとしてユーザー入力を送信
    // ユーザー入力をエンコードしてGETリクエストを初期化
    const url = "easychat.php?prompt=" + encodeURIComponent(input.value);
    request.open("GET", url, true);
    request.send();
}

// ストップボタンを押すと停止する
function stopGenerate() {
    clearInterval(interval);
}