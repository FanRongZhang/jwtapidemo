#题目1
##src文件夹里面为restful demo
-采用YII2
-采用swagger ui进行api的显示
-运行src下面的yii migrate进行数据迁移
-运行cd web && php -S 0.0.0.0:80
-访问http://localhost/apiui/index.html

#题目2


function transOtherLangToEng(string $otherLangString){
    $otherLangString = iconv('UTF-8', 'ASCII//TRANSLIT//IGNORE', $otherLangString);
	return str_replace('\'','',$otherLangString);
}
