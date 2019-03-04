window.onload = function() {
    switchSpan();
}

function switchSpan(){
    var el = document.querySelector('span.switch');
    var i = 0;
    var spanWords = ['weird', 'funny', 'random'];

    var interval = setInterval(function() {
      let iter = i++ % 3;
      el.textContent = spanWords[iter];
      if (iter > 2) {
        clearInterval(interval);
      }
    }, 3000);
}
