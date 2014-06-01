<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="Content-type" content="text/html; charset=utf-8" />
	<title>{$title}</title>
</head>
<body style="padding:0; margin:0; background:#fdfdfd">
	
<table width="100%" border="0" cellspacing="8" cellpadding="8" bgcolor="#fdfdfd">
	<tr>
		<td align="center" valign="top" >
			<table width="581" cellspacing="0" cellpadding="0">
              {*<tr>
					<td style="font-family: Arial; font-size:10px; line-height:12px; text-align:center; color:#999;">
						You're receiving this newsletter because you bought widgets from us.<br />

						Having trouble reading this email? <a href="#" style="color:#888888; text-decoration:underline;">View it in your browser</a>. Not interested anymore? <a href="#" style="color:#888888; text-decoration:underline;">Unsubscribe Instantly</a>.<br /><br />
					</td>
				</tr>*}     
				<tr>
					<td style="font-size:0; line-height:0;height: 80px;" height="80"><a href="{serverUrl}"><img src="{serverUrl}/public/default/images/mail/logo.png" border="0" alt="" /></a></td>
				</tr>
                <tr>
                    <td><div style="width:581; height:1px; background: #DDD; margin:5px 0"></div> </td>
                </tr>
				{*<tr>
					<td style="color:#878787; font-size:11px; font-weight:bold; font-family:Arial; " height="30" align="left">{'j F Y'|date|pl_date:1}</td>
				</tr>*}
				<tr>
            		<td style="font-family: Arial; font-size:13px; line-height:17px; text-align:left; color:#747474; ">
                        <br />
            			<div style="font-family: 'Trebuchet MS'; font-size:15px; line-height:20px; color:#000; font-weight:bold; text-align:left;">{$title}</div>
				             {include file=$content}
					</td>
				</tr>
				<tr>
					<td>
						<div style="width:581; height:1px; background: #DDD; margin:5px 0"></div>   
						<table width="100%" border="0" cellspacing="0" cellpadding="0">
							<tr>
								<td style="font-family: Arial; font-size:10px; line-height:12px; text-align:center; color:#999;"><br />Wiadomość wygenerowana automatycznie. Jeśli masz uwagi, napisz od nas: <a href="mailto:{$settings->siteEmail}" style="color:#888888; text-decoration:underline;">{$settings->siteEmail}</a>.
									<br />Zespół administracyjny serwisu : <a href="{serverUrl}" style="color:#888888; text-decoration:underline;">{serverUrl}</a>
									<br /><br />
                                </td>
							</tr>
						</table>
					</td>
				</tr>
			</table>
		</td>
	</tr>
</table>
	
</body>
</html>
