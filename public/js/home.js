
    // ширина і висота камери. ширина як константа
    // висота обчислюється на основі співвідношення сторін потоку вхідних даних.
    if (window.innerWidth > 1200) {
        var width = 640;
    } else {
        var width = 320;
    }
    var height = 0;

    // індикатор відеопотоку
    var streaming = false;

    // змінні для HTML елементів
    var video = null;
    var canvas = null;
    var photo = null;
    var img = null;
    var photobutton = null;

    function startCamera() {
        video = document.getElementById('video');
        img = document.getElementById('photo-button');
        canvas = document.getElementById('canvas');
        photo = document.getElementById('photo');
        photobutton = document.getElementById('photo-button');

        navigator.getMedia = ( navigator.getUserMedia ||
        navigator.webkitGetUserMedia ||
        navigator.mozGetUserMedia ||
        navigator.msGetUserMedia);

        navigator.getMedia(
            {
                video: true,
                audio: false
            },
            function(stream) {
                if (navigator.mozGetUserMedia) {
                    video.mozSrcObject = stream;
                } else {
                    var vendorURL = window.URL || window.webkitURL;
                    video.src = vendorURL.createObjectURL(stream);
                }
                video.play();
            },
            function(err) {
                console.log("An error occured! " + err);
            }
        );

        video.addEventListener('canplay', function(ev){
            if (!streaming) {
                height = video.videoHeight / (video.videoWidth/width);

                // Firefox currently has a bug where the height can't be read from
                // the video, so we will make assumptions if this happens.

                if (isNaN(height)) {
                    height = width / (4/3);
                }

                video.setAttribute('width', width);
                video.setAttribute('height', height);
                canvas.setAttribute('width', width);
                canvas.setAttribute('height', height);
                streaming = true;
            }
        }, false);

        photobutton.addEventListener('click', function(ev){
            //takepicture();
            ev.preventDefault();
        }, false);

        //clearphoto();
    }

    // Fill the photo with an indication that none has been
    // captured.

    function clearphoto() {
        var context = canvas.getContext('2d');
        context.fillStyle = "#AAA";
        context.fillRect(0, 0, canvas.width, canvas.height);

        var data = canvas.toDataURL('image/png');
        photo.setAttribute('src', data);
    }

    // Capture a photo by fetching the current contents of the video
    // and drawing it into a canvas, then converting that to a PNG
    // format data URL. By drawing it on an offscreen canvas and then
    // drawing that to the screen, we can change its size and/or apply
    // other changes before drawing it.

    function takepicture() {
        var context = canvas.getContext('2d');
        if (width && height) {

            var pic = new Image();
            pic.src = document.getElementById('photo-button').src;

            canvas.width = width;
            canvas.height = height;
            console.log(pic);
            context.drawImage(video, 0, 0, width, height);
            var w = pic.width;
            var h = pic.height;
            context.drawImage(pic, 0, 0, 500, 500);


            var data = canvas.toDataURL('image/png');
            document.getElementById('send').value = data;
            photo.setAttribute('src', data);
        } else {
            clearphoto();
        }
    }




// ПЕРЕМІЩЕННЯ ОБЄКТІВ МИШКОЮ

    function fixEvent(e) {
    // получить объект событие для IE
    e = e || window.event

    // добавить pageX/pageY для IE
    if ( e.pageX == null && e.clientX != null ) {
        var html = document.documentElement
        var body = document.body
        e.pageX = e.clientX + (html && html.scrollLeft || body && body.scrollLeft || 0) - (html.clientLeft || 0)
        e.pageY = e.clientY + (html && html.scrollTop || body && body.scrollTop || 0) - (html.clientTop || 0)
    }

    // добавить which для IE
    if (!e.which && e.button) {
        e.which = e.button & 1 ? 1 : ( e.button & 2 ? 3 : ( e.button & 4 ? 2 : 0 ) )
    }

    return e
}

function getPosition(e){
    var left = 0
    var top  = 0

    while (e.offsetParent){
        left += e.offsetLeft
        top  += e.offsetTop
        e    = e.offsetParent
    }

    left += e.offsetLeft
    top  += e.offsetTop

    return {x:left, y:top}
}


    var dragMaster = (function() {

    var dragObject
    var mouseOffset

    // получить сдвиг target относительно курсора мыши
    function getMouseOffset(target, e) {
        var docPos  = getPosition(target)
        return {x:e.pageX - docPos.x, y:e.pageY - docPos.y}
    }

    function mouseUp(){
        dragObject = null

        // очистить обработчики, т.к перенос закончен
        document.onmousemove = null
        document.onmouseup = null
        document.ondragstart = null
        document.body.onselectstart = null
    }

    function mouseMove(e){
        e = fixEvent(e)

        with(dragObject.style) {
            position = 'absolute'
            top = e.pageY - mouseOffset.y + 'px'
            left = e.pageX - mouseOffset.x + 'px'
        }
        return false
    }

    function mouseDown(e) {
        e = fixEvent(e)
        if (e.which!=1) return

        dragObject  = this

        // получить сдвиг элемента относительно курсора мыши
        mouseOffset = getMouseOffset(this, e)

        // эти обработчики отслеживают процесс и окончание переноса
        document.onmousemove = mouseMove
        document.onmouseup = mouseUp

        // отменить перенос и выделение текста при клике на тексте
        document.ondragstart = function() { return false }
        document.body.onselectstart = function() { return false }

        return false
    }

    return {
        makeDraggable: function(element){
            element.onmousedown = mouseDown
        }
    }

}())




// dragMaster.makeDraggable();
console.log(dragMaster);


// todo видалити обробники подій в js з nput name="frame" 
// todo зробити можливість змінювати розміри обєктів (для цілої групи зробити +-)


    // once loading is complete.
    window.addEventListener('load', function() {
        startCamera();
        var dragObjects = document.getElementById('objects').getElementsByTagName('img')
        for (var i = 0; i < dragObjects.length; i++) {
            dragMaster.makeDraggable(dragObjects[i]);    
        }
    }, false);

