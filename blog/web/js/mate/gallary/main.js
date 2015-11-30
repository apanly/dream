! function ()
{
	"use strict";
	//
	// ===== pointer library =====
	//
	var screen = {};
	(function() {
		this.elem = document.getElementById("screen"),
		this.width = 0;
		this.height = 0;
		this.resize = function () {
			this.width  = +this.elem.offsetWidth;
			this.height = +this.elem.offsetHeight;
		}
		this.elem.onselectstart = function() { return false; }
		this.elem.ondragstart   = function() { return false; }
		window.addEventListener('resize', this.resize.bind(this), false);
		this.resize();
		this.pointer = {
			x: 0,
			y: 0,
			dx: 0,
			dy: 0,
			touchMode: false,
			center: function (s) {
				this.dx *= s;
				this.dy *= s;
				endX = endY = 0;
			}
		}
		var started = false, startX = 0, startY = 0, endX = 0, endY = 0;
		this.addEvent = function (e, fn) {
			for (var i = 0, events = e.split(','); i < events.length; i++) {
				this.elem.addEventListener(events[i], fn.bind(this.pointer), false );
			}
		}
		this.addEvent("mousemove,touchmove", function (e) {
			e.preventDefault();
			this.touchMode = e.targetTouches;
			var pointer = this.touchMode ? this.touchMode[0] : e;
			this.x = pointer.clientX;
			this.y = pointer.clientY;
			if (started) {
				this.dx = endX - (this.x - startX);
				this.dy = endY - (this.y - startY);
			}
		});
		this.addEvent("mousedown,touchstart", function (e) {
			e.preventDefault();
			this.touchMode = e.targetTouches;
			var pointer = this.touchMode ? this.touchMode[0] : e;
			startX = this.x = pointer.clientX;
			startY = this.y = pointer.clientY;  
			started = true;
			setTimeout(function () {
				if (!started && Math.abs(startX - this.x) < 11 && Math.abs(startY - this.y) < 11) {
					if (this.tap) this.tap(e);
				}
			}.bind(this), 200);
		});
		this.addEvent("mouseup,touchend,touchcancel", function (e) {
			e.preventDefault();
			endX = this.dx;
			endY = this.dy;
			started = false;
		});
	}).apply(screen);
	var pointer = screen.pointer;
	var transform = (typeof document.body.style.webkitTransform != "undefined") ? "-webkit-transform" : "transform";
	//
	// ===== tweens engine =====
	//
	var tweens = {};
	(function() {
		var tweens = [];
		var proto = {
			normalPI: function () {
				if (Math.abs(this.target - this.value) > Math.PI) {
					if (this.target < this.value)  this.value -= 2 * Math.PI;
					else this.value += 2 * Math.PI;
				}
			},
			setTarget: function (target, speedMod) {
				this.speedMod = (speedMod) ? speedMod : 1;
				this.target   = target;
				if (this.isAngle) {
					this.target = this.target % (2 * Math.PI);
					this.normalPI();
				}
				if (this.running && this.oldTarget === target) return;
				this.oldTarget = target;
				this.running   = true;
				this.prog      = 0;
				this.from      = this.value;
				this.dist      = -(this.target - this.from) * 0.5;
			},
			ease: function () {
				if (!this.running) return;
				var s = this.speedMod * this.steps;
				if (this.prog++ < s) {
					this.value = this.dist * (Math.cos(Math.PI * (this.prog / s)) - 1) + this.from;
					if (this.isAngle) this.normalPI();
				} else {
					this.running = false;
					this.value = this.target;
				}
			}
		}
		this.add = function (steps, initValue, initValueTarget, isAngle) {
			var tween = Object.create(proto);
			tween.target   = initValueTarget || 0;
			tween.value    = initValue  || 0;
			tween.steps    = steps;
			tween.isAngle  = isAngle || false;
			tween.speedMod = 1;
			tween.setTarget(tween.target);
			tweens.push(tween);
			return tween;
		}
		this.iterate = function () {
			for (var i = 0, len = tweens.length; i < len; i++) {
				tweens[i].ease();
			}
		}
	}).apply(tweens);
	//
	// ===== css3D engine =====
	//
	var cube = document.getElementById("cube");
	var faces = document.querySelectorAll(".face");
	// ---- read computed matrix ----
	var getComputedMatrix = function (elem) {
		var computedStyle = getComputedStyle(elem, null);
		var val = computedStyle.transform || computedStyle.webkitTransform;
		return val.split(/\s*[(),]\s*/).slice(1,-1);
	}
	// ---- initial transformation ----
	for (var i = 0, len = faces.length; i < len; i++) {
		var face = faces[i];
		face.style[transform] = face.getAttribute("data-transform");
	}
	// ---- target photo ----
	pointer.tap = function (e) {
		if (e.target.className.indexOf("face") >= 0) {
			var t = e.target.alt == "" ? e.target : document.getElementById(e.target.alt);
			camera.setTarget(t);
		}
	}
	// ---- set camera -----
	var camera = {
		globalRX: 0,
		globalRY: 0,
		z:  tweens.add(100, 0, 0),
		rx: tweens.add(100, 0, 0, true),
		ry: tweens.add(100, 0, 0, true),
		targeted: null,
		setTarget: function (elem) {
			// read transformation matrix
			var matrix = getComputedMatrix(elem);
			// determine target angles
			var rotateY = Math.asin(-matrix[2]);
			var rotateX = Math.atan2(+matrix[6], +matrix[10]);
			if (rotateY) rotateY -= Math.PI;
			if (rotateX) rotateX -= Math.PI;
			// set target
			if (this.targeted) {
				this.targeted.style.outline = "rgba(0,0,0,1) solid 10px";
			}
			if (this.targeted != elem) {
				this.z.setTarget(600);
				if (elem.id == "4") {
					document.getElementById("7").style.visibility = "hidden";
				}
				if (elem.id == "7") {
					this.z.setTarget(-200);
					document.getElementById("7").style.visibility = "visible";
				}
				elem.style.outline = "rgba(255,255,255,1) solid 10px";
				this.targeted = elem;
			} else {
				this.z.setTarget(0);
				if (elem.id == "7") {
					camera.setTarget(document.getElementById("1"));
					return;
				}
				this.targeted = null;
			}
			// set target angles
			this.rx.setTarget(rotateX);
			this.ry.setTarget(rotateY);
		},
		move: function () {
			tweens.iterate();
			if (pointer.touchMode) {
				// interaction on touch mobiles
				var x = -pointer.dy * 0.001;
				var y = pointer.dx * 0.001;
				pointer.center(0.98);			
			} else {
				// interaction with mouse
				var x = -(pointer.y - screen.height * 0.5) * 0.001;
				var y = +(pointer.x - screen.width  * 0.5) * 0.001;			
			}
			// ease global angles
			this.globalRX += ((x - this.globalRX) * 0.1);
			this.globalRY += ((y - this.globalRY) * 0.1);
			// cube transformation
			cube.style[transform] = "translateZ("+ (this.z.value) + "px) rotateX(" + (this.rx.value + this.globalRX) + "rad) rotateY(" + (this.ry.value + this.globalRY) + "rad)";
		}
	}
	// main loop
	var run = function () {
		requestAnimationFrame(run); 
		camera.move();
	}
	run();
}();