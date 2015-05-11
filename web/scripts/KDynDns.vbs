' Update vars
token=""
fqdn=""

Dim o
Set o = CreateObject("MSXML2.XMLHTTP")
strPostData = "token=" & token & "&fqdn=" & fqdn
With o
	.Open "PUT", "http://anunitu.gorgu.net:8080/api/v1/refresh.json", False
    .setRequestHeader "Content-Type", "application/x-www-form-urlencoded"
    .send strPostData
End With