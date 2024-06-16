<script>

let gcount = 0;

function send() {
    document.querySelector(".loader").style.display = "block";
    const kachi_teian = document.querySelector("#kachi_teian");
    const gsearch_list0 = document.querySelector("#gsearch_list0");
    const gsearch_list3 = document.querySelector("#gsearch_list3");
    gsearch_list0.textContent = kachi_teian.value;
    gsearch_list3.textContent = "";
    gmodalSearch();
    ajaxPattern(gsearch_list3, "▼", 1);
}

$("#kachi_gpt_btn").on("click", send);

function ajaxPattern(id, title, flg) {
    const apiKey = 'YOUR_OPENAI_API_KEY';  // OpenAIのAPIキーをここに設定
    const prompt = document.querySelector("#kachi_teian").value;

    const data = {
        prompt: `あなたは小説の専門家。${prompt}のタイトルに合う小説のタイトル、ジャンル、対象年齢層、ストーリー、登場人物、設定、結末を創造して箇条書きにしてください。

        ＜小説＞:
        """
        タイトル:

        ジャンル:

        対象年齢層:

        ストーリー：

        登場人物:

        設定:

        結末：

        """
        :::`,
        temperature: 0.5,
        max_tokens: 1000,
        top_p: 0.5,
        frequency_penalty: 0.0,
        presence_penalty: 0.0,
        stop: [":::"]
    };

    $.ajax({
        type: "POST",
        url: "https://api.openai.com/v1/engines/davinci-codex/completions",
        headers: {
            "Authorization": `Bearer ${apiKey}`,
            "Content-Type": "application/json"
        },
        data: JSON.stringify(data),
        dataType: "json",
        success: function (response) {
            console.log(response);
            document.querySelector(".loader").style.display = "none";
            if (response.choices && response.choices.length > 0) {
                let str = "";
                let ar = response.choices[0].text.split("。");
                str += title;
                for (let i in ar) {
                    str += ar[i] ?? "";
                }
                itypedBlock(id, str);
            } else {
                gsearch_list0.textContent = "[Error] 予期せぬエラーが発生しました。";
            }
        },
        error: function (xhr, status, error) {
            console.log("[Error] " + error);
            gsearch_list0.textContent = "[Error] サーバーへのリクエストが失敗しました。";
        }
    });
}
</script>
