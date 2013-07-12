<form id="editor" autocomplete="off">
    <section id="post-title">
        <input type="text" id="title" value="" placeholder="Your post title" autocomplete="off" />
    </section>
    <section class="editor">
        <div class="editorwrap">
            <section class="entry-markdown">
                <header class="floatingheader">
                    Markdown 
                </header>
                <section class="entry-markdown-content">
                    <textarea id="entry-markdown" placeholder="Write something witty"></textarea>
                </section>
            </section>
            <section class="entry-preview active">
                <header class="floatingheader">
                  Preview <span class="entry-word-count">0 words</span>
                </header>
                <section class="entry-preview-content">
                    <div id="rendered-markdown" class="rendered-markdown"></div>
                </section>
            </section>
        </div>
    </section>
    <section id="post-tags">
        <input type="button" id="publish" class="btn" value="Publish" />
    </section>
</form>

<script src="js/codemirror.js" type="text/javascript"></script>
<script src="js/codemirror/xml.js" type="text/javascript"></script>
<script src="js/codemirror/markdown.js" type="text/javascript"></script>
<script src="js/showdown.min.js" type="text/javascript"></script>
<script src="js/extensions/twitter.js" type="text/javascript"></script>
<script src="js/extensions/github.js" type="text/javascript"></script>

<script>
function editorHeight() {
    $('.editor .editorwrap').height($(window).height() - $('#post-tags').height() - $('#post-title').height()).css({ top: $('#post-title').height() + 'px'});
}
$(function() {
    editorHeight();
});
$(window).resize(editorHeight);

// Startup markdown convertor
var converter = new Showdown.converter({ extensions: ['twitter', 'github'] });

// Render markdown with CodeMirror
var editor = CodeMirror.fromTextArea(document.getElementById('entry-markdown'), {
  tabMode: 'indent',
  mode: "markdown",
  lineWrapping: !0
});

editor.on("change",updatePreview);

function updatePreview() {
  $('#rendered-markdown').html(converter.makeHtml(editor.getValue()));
  countWords();
}

function countWords() {
    var e = document.getElementsByClassName("entry-word-count")[0],
        t = $('.CodeMirror-code').text();
    t.length && (e.innerHTML = t.match(/\S+/g).length + " words")
}

// Auto scroll preview when scrolling on markdown code area
$(function () {
    function t(t) {
        var n = $(t.target),
            r = $(".entry-preview-content"),
            i = $(".CodeMirror-sizer"),
            o = $(".rendered-markdown"),
            a = i.height() - n.height(),
            l = o.height() - r.height(),
            s = l / a,
            c = n.scrollTop() * s;
        r.scrollTop(c)
    }
    
    $(".CodeMirror-scroll").on("scroll", t), $(".CodeMirror-scroll").scroll(function () {
        $(".CodeMirror-scroll").scrollTop() > 10 ? $(".entry-markdown").addClass("scrolling") : $(".entry-markdown").removeClass("scrolling")
    }), $(".entry-preview-content").scroll(function () {
        $(".entry-preview-content").scrollTop() > 10 ? $(".entry-preview").addClass("scrolling") : $(".entry-preview").removeClass("scrolling")
    })
});
      
</script>
