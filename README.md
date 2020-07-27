# 資料分頁 練習實作

將實體json檔資料搭配Bootstrap 表格於前端頁面顯示，

並透過jquery+ Bootstrap 分頁樣式製作分頁按鈕

流程:
1. 建構網站基本樣式(搭配Bootstrap)
2. 使用fetch撈取json資料，透過slice篩選要顯示的內容
3. 使用location.href撈取網址頁面參數
4. 建構單頁顯示參數
5. 建構分頁按鈕顯示參數
6. 將資料套入指定位置

啟動方式
1. 安裝XAMPP:https://www.apachefriends.org/index.html
2. 下載檔案，將資料夾(JSON_data)放於XAMPP安裝目錄下(預設C:\xampp\htdocs\)
3. 將XAMPP中Apache以及MySQL啟動(start)
4. 進入檔案位址:http://localhost/data_page/
