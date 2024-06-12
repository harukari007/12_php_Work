$.ajax({
    type: "POST",
    url: "search.php",
    data: { query: kachi_teian.value, swflg: flg },
    dataType: "json",
    cache: false,
    success: function (data) {
        console.log(data);
        document.querySelector(".loader").style.display = "none";
        if (data.error) {
            gsearch_list0.textContent = "[Error] " + data.error;
        } else {
            let str = "";
            let ar = data.response.split("。");
            str += title;
            for (let i in ar) {
                str += ar[i] ?? "";
            }
            itypedBlock(id, str);
        }
    }
});
