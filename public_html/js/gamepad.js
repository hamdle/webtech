// Gamepad
//
// Connect gamepad controller
//
//

var Gamepad = (function () {
    var $gamepad;
    function init() {
        // window.addEventListener("gamepadconnected", function(e) {
        //     console.log(e);
        //     $gamepad = e.gamepad;
        //     console.log("Gamepad connected, id: " + $gamepad.id);
        // });
        window.addEventListener("gamepadconnected", (e) => {
            console.log(
                "Gamepad connected at index %d: %s. %d buttons, %d axes.",
                e.gamepad.index,
                e.gamepad.id,
                e.gamepad.buttons.length,
                e.gamepad.axes.length,
            );
        });

        window.addEventListener("gamepaddisconnected", function(e) {
            console.log("Gamepad disconnected, id " + $gamepad.id);
            $gamepad = null;
        });
    }

    function start() {
        if ($gamepad) {
            requestAnimationFrame(frame);
        }
    }

    function frame(time) {
        console.log(time);
        $gamepad.buttons.forEach(function(button, index) {
            console.log("Button " + index + " pressed: " + button.pressed);
        });
        requestAnimationFrame(frame);
    }

    return {
        init: init,
        start: start
    };
})();