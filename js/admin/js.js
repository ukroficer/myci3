$(document).ready(function() {

     $("#selecttoo")[0] && $.ajax({
            url: "/admin/posts/get_tags",
            type: "GET",
            dataType: "json",
            success: function(a) {
                data = a.tagList, tagArray = [], $.each(data, function(a, b) {
                    tagArray.push(b)
                }), $("#selecttoo").select2({
                    tags: tagArray,
                    width: 510,
                    tokenSeparators: ["," , " "]
                })
            }
        })

        
});