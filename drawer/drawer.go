package drawer

// Drawer 通用的Draw功能: Parse和Render
// 输入markdown字符串, 输出渲染好的html页面(body部分)
// 和markdown对应的标题(第一行的h1的内容)
func Drawer(md string) (title, htmlres string) {
	title, htmlres = Parse(md)
	htmlres = Render(htmlres)
	return
}
