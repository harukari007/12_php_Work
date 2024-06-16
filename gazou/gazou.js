// script.js
document.getElementById('uploadForm').addEventListener('submit', function (event) {
    event.preventDefault();
    const fileInput = document.getElementById('fileInput');
    const formData = new FormData();
    formData.append('fileInput', fileInput.files[0]);

    fetch('upload.php', {
        method: 'POST',
        body: formData
    })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                const imageUrl = data.imageUrl;
                analyzeCalories(imageUrl);
            } else {
                alert('アップロードに失敗しました。');
            }
        })
        .catch(error => {
            console.error('エラー:', error);
        });
});

function analyzeCalories(imageUrl) {
    fetch('https://api.openai.com/v1/engines/davinci-codex/completions', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'Authorization': `Bearer sk-proj-xlFeblZIHZqpp24OtWsbT3BlbkFJ7o7HVMN3W26yskDP0wxk`
        },
        body: JSON.stringify({
            
            prompt: `この画像のカロリーを解析してください: ${imageUrl}`,
            max_tokens: 50
        })
    })
        .then(response => response.json())
        .then(data => {
            const calories = data.choices[0].text.trim();
            displayResult(imageUrl, calories);
        })
        .catch(error => {
            console.error('エラー:', error);
        });
}

function displayResult(imageUrl, calories) {
    const resultDiv = document.getElementById('result');
    resultDiv.innerHTML = `
        <img src="${imageUrl}" alt="食べ物の写真" style="max-width: 300px;">
        <p>推定カロリー: ${calories} cal</p>
    `;
}
