$.ajaxSetup({
    headers: {
        "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
    },
});

//xoá
function removeRow(id, url) {
    // alert("Xóa " + id + " " + url);
    if (confirm("Bạn có muốn xóa?")) {
        $.ajax({
            type: "DELETE",
            datatype: "JSON",
            data: { id, "_token": $('#csrf-token')[0].content },
            url: url,
            success: function (result) {
                console.log(result["error"])
                if (result.error === false) {
                    alert(result.message);
                    location.reload();
                } else {
                    alert("Xóa không thành công!");
                }
            },
        });
    }
}

function changeColor(id_member, id_skill) {
    console.log(id_member + "/" + id_skill);
}
