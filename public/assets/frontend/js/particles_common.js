
let arr = ['footer_canvas', 'home_canvas', 'aboutus_canvas', 'survey_canvas'];

// Check the window width
let screen_width = document.body.clientWidth;
let x_val = 0;
if(screen_width>= 768){
    x_val = 70;
}else if(screen_width <= 768 && screen_width >= 576){
    x_val = 50;
}else{
    x_val = 25;
}

arr.forEach(function (elem) {
    if ($(`#${elem}`).length) {
        var canvas = document.getElementById(`${elem}`),
            ctx = canvas.getContext('2d');

        canvas.width = window.innerWidth;
        // canvas.height = window.innerHeight;
        canvas.height = 350;

        var stars = [], // Array that contains the stars
            FPS = 60, // Frames per second
            x = x_val, // Number of stars
            mouse = {
                x: 0,
                y: 0
            }; // mouse location

        // Push stars to array

        for (var i = 0; i < x; i++) {
            stars.push({
                x: Math.random() * canvas.width,
                y: Math.random() * canvas.height,
                radius: Math.random() * 2 + 1,
                vx: Math.floor(Math.random() * 50) - 25,
                vy: Math.floor(Math.random() * 50) - 25
            });
        }


        canvas.addEventListener('mousemove', function (e) {
            mouse.x = e.clientX;
            mouse.y = e.clientY;
        });

        // Draw the scene

        function draw() {
            ctx.clearRect(0, 0, canvas.width, canvas.height);

            ctx.globalCompositeOperation = "#B6D0E3";

            for (var i = 0, x = stars.length; i < x; i++) {
                var s = stars[i];

                ctx.fillStyle = "#B6D0E3";
                ctx.beginPath();
                ctx.arc(s.x, s.y, s.radius, 0, 2 * Math.PI);
                ctx.fill();
                ctx.fillStyle = '#B6D0E3';
                ctx.stroke();
            }

            ctx.beginPath();
            for (var i = 0, x = stars.length; i < x; i++) {
                var starI = stars[i];
                ctx.moveTo(starI.x, starI.y);
                if (distance(mouse, starI) < 150) ctx.lineTo(mouse.x, mouse.y);
                for (var j = 0, x = stars.length; j < x; j++) {
                    var starII = stars[j];
                    if (distance(starI, starII) < 150) {
                        //ctx.globalAlpha = (1 / 150 * distance(starI, starII).toFixed(1));
                        ctx.lineTo(starII.x, starII.y);
                    }
                }
            }
            ctx.lineWidth = 1;
            ctx.strokeStyle = '#B6D0E3';
            ctx.stroke();
        }

        function distance(point1, point2) {
            var xs = 0;
            var ys = 0;

            xs = point2.x - point1.x;
            xs = xs * xs;

            ys = point2.y - point1.y;
            ys = ys * ys;

            return Math.sqrt(xs + ys);
        }

        // Update star locations

        function update() {
            for (var i = 0, x = stars.length; i < x; i++) {
                var s = stars[i];

                s.x += s.vx / FPS;
                s.y += s.vy / FPS;

                if (s.x < 0 || s.x > canvas.width) s.vx = -s.vx;
                if (s.y < 0 || s.y > canvas.height) s.vy = -s.vy;
            }
        }



        // Update and draw

        function tick() {
            draw();
            update();
            requestAnimationFrame(tick);
        }

        tick();
    }


})