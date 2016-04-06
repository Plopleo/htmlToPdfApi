# HtmlToPdfApi

Send html => receive pdf

Based on [KnpSnappyBundle] bundle
### Installation
You need [wkhtmltopdf] installed before.

Once you have clone this repo, make sure that parameters 'knp_snappy' in config.yml match with your configuration:

```sh
knp_snappy:
    pdf:
        enabled:    true
        binary:     /usr/local/bin/wkhtmltopdf #"\"C:\\Program Files\\wkhtmltopdf\\bin\\wkhtmltopdf.exe\"" for Windows users
        options:    []
    image:
        enabled:    true
        binary:     /usr/local/bin/wkhtmltoimage #"\"C:\\Program Files\\wkhtmltopdf\\bin\\wkhtmltoimage.exe\"" for Windows users
        options:    []

```

### Use it

Post html data to the htmltopdf endpoint.

```sh
// Data should be like that:
// ['html_content'] => '<html><body>Hey !</body></html>'

http://my-api.com/htmltopdf
```

You can add footer or header by using div with id 'footer' or 'header'
```sh
<html>
    <body>
        <div id="header">My header</div>
        <div id="footer">My footer</div>
    </body>
</html>

```

[KnpSnappyBundle]: <https://github.com/KnpLabs/KnpSnappyBundle>
[wkhtmltopdf]: <http://wkhtmltopdf.org/downloads.html>
