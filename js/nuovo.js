


var TxtType = function(el, toRotate, period) { // costruttore
    this.toRotate = toRotate;
    this.el = el;
    this.loopNum = 0;
    this.period = parseInt(period, 10) || 2000;
    this.txt = '';
    this.tick();
    this.isDeleting = false;
};

TxtType.prototype.tick = function() {
    var i = this.loopNum % this.toRotate.length;
    var fullTxt = this.toRotate[i];
    if (i == 4) exit();

    if (this.isDeleting) {
        this.txt = fullTxt.substring(0, this.txt.length - 1);
    } else {
        this.txt = fullTxt.substring(0, this.txt.length + 1);
    }

    // se clicco la scritti ricarica la pagina
    this.el.innerHTML = '<a onClick="location.href=location.href" class="wrap">' + this.txt + '</a>';

    var that = this;
    var delta = 120 - Math.random() * 100;

    if (this.isDeleting) {
        delta /= 5;
    }

    if (!this.isDeleting && this.txt === fullTxt) {
        delta = this.period;
        this.isDeleting = true;
    } else if (this.isDeleting && this.txt === '') {
        this.isDeleting = false;
        this.loopNum++;
        delta = 500;
    }

    setTimeout(function() {
        that.tick();
    }, delta);
};



$(document).ready(function() {
    $("#iPhoneBtn").on('click', function() {
        var image_x = document.getElementById('mani');
        image_x.parentNode.removeChild(image_x);
        var elements = document.getElementsByClassName('typewrite');
        for (var i = 0; i < elements.length; i++) {
            var toRotate = elements[i].getAttribute('data-type');
            var period = elements[i].getAttribute('data-period');
            if (toRotate) {
                new TxtType(elements[i], JSON.parse(toRotate), period);
            }
        }
        $("#iPhoneBtn").attr("disabled", "disabled").off('click');
    });

   // $("#scrollante").attr("disabled", "disabled").off('click');
   
});

function myFunction() {
   $("#scrollante").removeClass("mb-5");
   $("#scrollante").addClass("nonee");
}

setTimeout(function(){
  myFunction();
}, 3000)
