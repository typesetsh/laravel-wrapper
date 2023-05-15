<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>PDF preview</title>
        <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet">
        <link href="https://cdn.jsdelivr.net/npm/ace-builds@1.21.0/css/ace.min.css" rel="stylesheet">
        <script src="https://cdn.jsdelivr.net/npm/ace-builds@1.21.0/src-min-noconflict/ace.min.js"></script>
        <script src="https://code.jquery.com/jquery-3.7.0.min.js" crossorigin="anonymous"></script>
        <style>
            html, body {
                background-color: #fff;
                color: #636b6f;
                font-family: 'Nunito', sans-serif;
                font-weight: 200;
                margin: 0;
            }
            main {
                position: fixed;
                width: 100%;
                height: 100%;
            }
            .rows {
                display: flex;
                flex-direction: column;
                width: 100%;
                height: 100%;
            }
            .cols {
                display: flex;
                flex-direction: row;
                width: 100%;
                height: 100%;
            }

            section.preview.tabs {
                width: 100%;
                height: 100%;
            }
            section.preview.tabs .tab {
                width: 100%;
                height: 100%;
                display: none;
            }
            section.preview.tabs .tab.active {
                display: block;
            }
            #editor {
                width: 100%;
                height: 100%;
                border: 0;
            }
            iframe {
                width: 100%;
                height: 100%;
                border: 0;
            }
            section.warnings {
                min-height: 20vh;
                max-height: 25vh;
                border-top: 5px solid #464646;
                background: black;;
                padding: 0;
                overflow: auto;
            }
            section.warnings ul {
                font-family: monospace;
                font-size: 11px;
                list-style: none;
                color: #77888e;
                padding: 0;
                margin: 0;
            }
            section.warnings ul li {
                border-bottom: 1px solid #373f42;
                background: #282828;;
                padding: 5px 10px;
            }
            section.toolbar {
                height: 60px;
                border-bottom: 2px solid #464646;
                background: #282828;
                align-content: center;
                align-items: center;
                padding: 10px;
            }
            section.toolbar .logo {
                height: 30px;
            }

            nav.tabs {
                margin-left: 20px;
                display: flex;
                column-gap: 0px;
                align-content: center;
                align-items: center;
                height: auto;
                border-radius: 4px;
                overflow: hidden;
            }
            nav.tabs > a {
                display: block;
                padding: 5px 15px;
                background: #1e1e1e;
                color: #c4c4c4;
                cursor: pointer;
                height: 20px;
                font-size: 10pt;
                font-weight: bold;
                line-height: 16pt;
                border-right: 1px solid #282828;
            }
            nav.tabs > a:last-child {
                border:none;
            }
            nav.tabs > a.active {
                color:red;
            }

        </style>
    </head>
    <body>
        <main class="rows">
            <section class="toolbar cols">
                <a href="https://docs.typeset.sh/setup/css-and-paged-media" class="logo" target="_blank">
                    <img src="https://stat.typeset.sh/images/logo-square.png" alt="typeset.sh" class="logo">
                </a>
                <nav class="tabs">
                    <a class="tab pdf" onclick="tab('pdf')">PDF</a>
                    <a class="tab html" onclick="tab('html')">HTML</a>
                    <a class="tab code" onclick="tab('code')">CODE</a>
                    <a class="tab help" onclick="tab('help')">?</a>
                </nav>
            </section>
            <section class="preview tabs">
                <div class="pdf tab">
                    <iframe id="pdf"></iframe>
                </div>
                <div class="html tab">
                    <iframe id="html"></iframe>
                </div>
                <div class="code tab">
                    <div id="editor">{{ $html_code }}</div>
                </div>
                <div class="help tab">
                    <iframe src="https://docs.typeset.sh/setup/css-and-paged-media"></iframe>
                </div>
           </section>
           <section class="warnings">
                <ul>
                    @foreach( $log as $message)
                        <li>{{ $message }}</li>
                    @endforeach
                </ul>
           </section>
       </main>
        <script type="text/javascript">
            var editor = ace.edit("editor");
                editor.setTheme("ace/theme/monokai");
                editor.session.setMode("ace/mode/html");

            tab('pdf');

            function tab(tab) {
                $('.tabs > .tab').removeClass('active').filter('.'+tab).addClass('active')
            }

            function displayContent(id, type, content) {
                document.getElementById(id).src = "data:"+type+";base64," + content;
            }

            window.addEventListener('load', function() {
                displayContent('pdf', 'application/pdf', '{!! base64_encode($pdf) !!}');
                displayContent('html', 'text/html', '{!! base64_encode($html) !!}');

                console.log(document.getElementById('html'));
            });
        </script>
    </body>
</html>
