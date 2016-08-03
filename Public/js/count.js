// 计数器js文件
var newsIds = {};
$(".news_count").each(function(i){
    newsIds[i] = $(this).attr("news-id");
});

//调试
//console.log(newsIds);

url = "/index.php?c=index&a=getCount";

$.post(url, newsIds, function(result){
	// console.log(result.data);
    if(result.status  == 1) {
        var counts = result.data;
        // $.each(counts, function(news_id,count){
        //     $(".node-"+news_id).html(count);
        // });
        for (var news_id in counts) {
        	$(".node-" + news_id).html(counts[news_id]);
        }
    }
}, "JSON");