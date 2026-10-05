document.addEventListener("alpine:init", () => {
    Alpine.data("floorPlan", () => ({
        // Entangled with the Livewire component's $editingLayout property,
        // so this stays in sync automatically when "Edit Layout" is toggled
        // server-side — no need to pass a snapshot value in from Blade.
        editingLayout: false,

        dragging: null,
        dragType: null,
        startX: 0,
        startY: 0,
        origX: 0,
        origY: 0,

        resizing: null,
        resizeType: null,
        resizeStartX: 0,
        resizeStartY: 0,
        origW: 0,
        origH: 0,

        rotating: null,
        rotateType: null,
        rotateCenterX: 0,
        rotateCenterY: 0,
        rotateCanvasRect: null,

        init() {
            this.editingLayout = this.$wire.entangle("editingLayout");
        },

        startDrag(e, type, id, x, y) {
            if (!this.editingLayout) return;
            this.dragging = id;
            this.dragType = type;
            const p = e.touches ? e.touches[0] : e;
            this.startX = p.clientX;
            this.startY = p.clientY;
            this.origX = x;
            this.origY = y;
        },

        // Every item has its own pointermove/pointerup listener on window,
        // so each call must ignore itself unless it's the item actually in motion.
        collides(el, nx, ny) {
            const w = el.offsetWidth;
            const h = el.offsetHeight;
            return Array.from(
                el.parentElement.querySelectorAll(
                    '[data-floor-item]:not([data-item-type="label"])',
                ),
            ).some((node) => {
                if (node === el) return false;
                const rx = parseInt(node.style.left);
                const ry = parseInt(node.style.top);
                const rw = node.offsetWidth;
                const rh = node.offsetHeight;
                return (
                    nx < rx + rw && nx + w > rx && ny < ry + rh && ny + h > ry
                );
            });
        },

        onDrag(e, el, type, id) {
            if (this.dragging !== id || this.dragType !== type) return;
            const p = e.touches ? e.touches[0] : e;
            const nx = Math.max(0, this.origX + (p.clientX - this.startX));
            const ny = Math.max(0, this.origY + (p.clientY - this.startY));

            // Try both axes; if that collides, try each axis alone so you can still
            // slide along a table/barrier you're bumping into instead of getting stuck.
            if (!this.collides(el, nx, ny)) {
                el.style.left = nx + "px";
                el.style.top = ny + "px";
            } else if (!this.collides(el, nx, parseInt(el.style.top))) {
                el.style.left = nx + "px";
            } else if (!this.collides(el, parseInt(el.style.left), ny)) {
                el.style.top = ny + "px";
            }
        },

        endDrag(el, type, id) {
            if (this.dragging !== id || this.dragType !== type) return;
            this.dragging = null;
            this.dragType = null;
            const x = parseInt(el.style.left);
            const y = parseInt(el.style.top);
            if (type === "table") {
                this.$wire.updateTablePosition(id, x, y);
            } else {
                this.$wire.updateElementPosition(id, x, y);
            }
        },

        startResize(e, type, id, w, h) {
            if (!this.editingLayout) return;
            e.stopPropagation();
            this.resizing = id;
            this.resizeType = type;
            const p = e.touches ? e.touches[0] : e;
            this.resizeStartX = p.clientX;
            this.resizeStartY = p.clientY;
            this.origW = w;
            this.origH = h;
        },

        onResize(e, el, type, id) {
            if (this.resizing !== id || this.resizeType !== type) return;
            const p = e.touches ? e.touches[0] : e;
            const nw = Math.max(
                48,
                this.origW + (p.clientX - this.resizeStartX),
            );
            const nh = Math.max(
                32,
                this.origH + (p.clientY - this.resizeStartY),
            );
            el.style.width = nw + "px";
            el.style.height = nh + "px";
        },

        endResize(el, type, id) {
            if (this.resizing !== id || this.resizeType !== type) return;
            this.resizing = null;
            this.resizeType = null;
            const w = parseInt(el.style.width);
            const h = parseInt(el.style.height);
            if (type === "table") {
                this.$wire.updateTableSize(id, w, h);
            } else {
                this.$wire.updateElementSize(id, w, h);
            }
        },

        // Rotation acts on the inner shape element (the visual button/box), not the
        // outer wrapper — the wrapper stays axis-aligned so drag/resize/collision math
        // never has to deal with rotated rectangles, only the drawing rotates.
        startRotate(e, type, id, wrapperEl) {
            if (!this.editingLayout) return;
            e.stopPropagation();
            this.rotating = id;
            this.rotateType = type;
            this.rotateCenterX =
                wrapperEl.offsetLeft + wrapperEl.offsetWidth / 2;
            this.rotateCenterY =
                wrapperEl.offsetTop + wrapperEl.offsetHeight / 2;
            this.rotateCanvasRect =
                wrapperEl.offsetParent.getBoundingClientRect();
        },

        onRotate(e, shapeEl, type, id) {
            if (this.rotating !== id || this.rotateType !== type) return;
            const p = e.touches ? e.touches[0] : e;
            const x = p.clientX - this.rotateCanvasRect.left;
            const y = p.clientY - this.rotateCanvasRect.top;
            const dx = x - this.rotateCenterX;
            const dy = y - this.rotateCenterY;
            // atan2 measures from the positive x-axis; +90 shifts 0deg to "pointing up",
            // which is where the rotate handle sits when rotation is 0.
            let deg = Math.round(Math.atan2(dy, dx) * (180 / Math.PI) + 90);
            deg = ((deg % 360) + 360) % 360;
            shapeEl.style.transform = `rotate(${deg}deg)`;
            shapeEl.dataset.rotation = deg;
        },

        endRotate(shapeEl, type, id) {
            if (this.rotating !== id || this.rotateType !== type) return;
            this.rotating = null;
            this.rotateType = null;
            const deg = parseInt(shapeEl.dataset.rotation || "0", 10);
            if (type === "table") {
                this.$wire.updateTableRotation(id, deg);
            } else {
                this.$wire.updateElementRotation(id, deg);
            }
        },
    }));
});
