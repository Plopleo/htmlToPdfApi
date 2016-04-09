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

To merge pdfs you must have 'gs' on your system and give the path of this command in parameters.yml
```sh
parameters:
    # some parameters
    path_to_gs_command: /usr/local/bin/gs
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

Landscape and portrait are both accepted, you have to use classes 'page' and add 'landscape' class for landscape pages
```sh
<html>
    <body>
        <div class="page landscape">
            First page - landscape
        </div>
        <div class="page landscape">
            Second page - landscape
        </div>
        <div class="page">
            Third page - portrait
        </div>
    </body>
</html>
```

You can also go to the home to try this generator

![home](web/home.png?raw=true)


[KnpSnappyBundle]: <https://github.com/KnpLabs/KnpSnappyBundle>
[wkhtmltopdf]: <http://wkhtmltopdf.org/downloads.html>
