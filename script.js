// check radio when typing into other box
function focusOther() {
    document.getElementById("other").checked = true;
}

// make call to get tip from php
function getResult(e) {
  var data = $('form').serializeArray();

  data.push({name:"submit", value:""});

  $('.container').load('calc.php .container > *', data, function() {
    var textField = $('input[name=' + e.target.name + ']')[0];
    var pos = e.target.value.length;
    textField.focus();
    textField.setSelectionRange(pos,pos);
    bindHandlers();
   });

  e.preventDefault();
}

function getResultAfterKeyUp() {
  var timeOut = undefined;
  return function(e) {
    if (typeof timeOut === "number") {
      window.clearTimeout(timeOut);
      timeOut = undefined;
    }
    timeOut = window.setTimeout(getResult, 500, e);
  };
}

// bind event handlers to form elements
function bindHandlers() {
  // set submit handler of the form
  $('form').submit(function(e) { getResult(e); });
  // submit form when user stops typing for 500 ms
  var keyUpHandler = getResultAfterKeyUp();
  $("input[type='text']").keyup(function(e) { keyUpHandler(e); });
}

// bind event handlers on load
$(document).ready(function () {
  bindHandlers();
});
