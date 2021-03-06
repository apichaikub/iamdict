<!DOCTYPE HTML>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title>Untitled Document</title>
</head>

<body>

<!-- edit this; the PDF file must be on the same domain as this page -->
<iframe id="input" src="your-file3.pdf"></iframe>

<!-- embed the pdftotext service as an iframe -->
<iframe id="processor" src="http://hubgit.github.com/2011/11/pdftotext/"></iframe>

<!-- a container for the output -->
<div id="output"></div>

<script>
var input = document.getElementById("input");
var processor = document.getElementById("processor");
var output = document.getElementById("output");

// listen for messages from the processor
window.addEventListener("message", function(event){
  if (event.source != processor.contentWindow) return;

  switch (event.data){
    // "ready" = the processor is ready, so fetch the PDF file
    case "ready":
      var xhr = new XMLHttpRequest;
      xhr.open('GET', input.getAttribute("src"), true);
      xhr.responseType = "arraybuffer";
      xhr.onload = function(event) {
        processor.contentWindow.postMessage(this.response, "*");
      };
      xhr.send();
    break;

    // anything else = the processor has returned the text of the PDF
    default:
      output.textContent = event.data.replace(/\s+/g, " ");
    break;
  }
}, true);
</script>

</body>
</html>
