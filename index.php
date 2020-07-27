<!doctype html>
<html lang="en">
  <head>
    <title>資料串接分頁</title>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/3.7.2/animate.min.css">
    <link rel="stylesheet" href="index.css">

  </head>
  <body>


    <div class="container">
        <div class="title">
            <h1>資料串接分頁展示</h1>
            <a href="data.json" target="_blank">JSON API資料來源：T-Bike 臺南市公共自行車租賃站資訊</a>
        </div>
        
        <table class="table table-striped">
            <thead>
                <tr class="table-info">
                    <th style="width: 20%;">站名</th>
                    <th style="width: 15%;">行政區</th>
                    <th style="width: 55%;">地址</th>
                    <th>格位數</th>
                </tr>
            </thead>
            <tbody id="tablebody">

            </tbody>
        </table>

        <nav aria-label="..." class="selectpage">
            <ul class="pagination" id="pagination">
                <!-- <li class="page-item ">
                    <a class="page-link" href="./?page=1" tabindex="-1" aria-disabled="true">最前頁</a>
                </li>
                <li class="page-item ">
                    <a class="page-link" href="#" tabindex="-1" >上一頁</a>
                </li>
                <li class="page-item"><a class="page-link" href="#">1</a></li>
                <li class="page-item active" aria-current="page">
                    <a class="page-link" href="#">2</a>
                </li>
                <li class="page-item"><a class="page-link" href="#">3</a></li>
                <li class="page-item">
                    <a class="page-link" href="#">下一頁</a>
                </li>
                <li class="page-item">
                    <a class="page-link" href="#">最後頁</a>
                </li> -->
            </ul>
        </nav>

    </div>
      
    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>

    <script>

        $(function(){

            //取得資料
            fetch('data.json', {  
                    method: 'GET',
                })
            .then((res) => {                      
                return res.json()
            })
            .then((obj) => {

                //先針對網址取得當前頁數
                var getUrlString = location.href; //取得網址，並存入變數
                var url = new URL(getUrlString); //字串轉成URL
                var page = parseInt(url.searchParams.get('page'))//得到page值
                if(page==null || page<1){       //判斷為空或小於1時
                    page=1;
                }
                
                var numPerPage = 8;                 //每頁幾筆
                var first = (page - 1)*numPerPage;  //每頁第一筆
                var end = page*numPerPage           //每頁最後一筆
                var data = obj.slice(first,end)     //每頁要顯示的資料
                var newdata = data.map((item, index) =>{
                    return '<tr><td>'+item.StationName+'</th><td>'+item.District+'</td><td>'+item.Address+'</td><td>'+item.Capacity+'</td></tr>'
                })
                $("#tablebody").html(newdata);
                
                //取得總筆數
                var total = obj.length; //73筆
                
                //總頁數
                var totalPages = Math.ceil(total/numPerPage);
                if(page>totalPages){page = totalPages}//新增判斷不可大於總頁數


                //================下方分頁按鈕=============================
                
                var maxPageCount = 6;  //下方數字鈕一次顯示?筆
                var buffCount = 3;     //判斷第幾頁後開始往後延伸    

                var startPage='';     //下方數字鈕第一筆             
                var endPage = '';     //最後一個數字鈕

                //根據當前頁面判斷下方數字鈕第一個和最後一個=?
                if(page>=1 && page <= ((totalPages-maxPageCount)+1)){
                    startPage = page;
                    endPage = startPage+maxPageCount
                }else{
                    startPage = (totalPages-maxPageCount)+1
                    endPage = totalPages
                }

                var firstButton = '';    //放置分頁按鈕(最前&上一頁)資料
                var endButton = '';      //放置分頁按鈕(最後&下一頁)資料
                //判斷當前頁數作顯示
                if(page>1){ 
                    firstButton =   '<li class="page-item ">'+
                                        '<a class="page-link" href="./?page=1" tabindex="-1" >最前頁</a>'+
                                    '</li>'+
                                    '<li class="page-item ">'+
                                        '<a class="page-link" href="./?page='+(parseInt(page)-1)+'" tabindex="-1" >上一頁</a>'+
                                    '</li>';
                }else{
                    firstButton =   '<li class="page-item disabled">'+
                                        '<a class="page-link" href="#" tabindex="-1" >最前頁</a>'+
                                    '</li>'+
                                    '<li class="page-item disabled">'+
                                        '<a class="page-link" href="#" tabindex="-1" >上一頁</a>'+
                                    '</li>';
                }
                if(page==totalPages){
                    endButton =   '<li class="page-item disabled">'+
                                        '<a class="page-link" href="#" tabindex="-1" >下一頁</a>'+
                                    '</li>'+
                                    '<li class="page-item disabled">'+
                                        '<a class="page-link" href="#" tabindex="-1" >最後頁</a>'+
                                    '</li>';
                }else{
                    endButton =   '<li class="page-item">'+
                                        '<a class="page-link" href="./?page='+(parseInt(page)+1)+'" tabindex="-1" >下一頁</a>'+
                                    '</li>'+
                                    '<li class="page-item">'+
                                        '<a class="page-link" href="./?page='+totalPages+'" tabindex="-1" >最後頁</a>'+
                                    '</li>';
                }

                //放置數字分頁按鈕
                var numButton = '';

                let numcontent = '';
                for(let i = startPage ; i <= endPage ; i++){
                    if(page == i){
                        numcontent =    '<li class="page-item active" aria-current="page">'+
                                            '<a class="page-link" href="./?page='+i+'">'+i+'</a>'+
                                        '</li>'
                    }else{
                        numcontent =    '<li class="page-item " aria-current="page">'+
                                            '<a class="page-link" href="./?page='+i+'">'+i+'</a>'+
                                        '</li>'
                    }
                    numButton = numButton + numcontent;
                }

                $("#pagination").html(firstButton+numButton+endButton)

            })        

        });


    </script>


  </body>
</html>