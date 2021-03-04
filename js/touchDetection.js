function is_touch_device() {
    return !!('ontouchstart' in window || navigator.maxTouchPoints);       // works on IE10/11 and Surface
};