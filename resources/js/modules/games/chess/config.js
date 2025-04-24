export default {
    coordinates: true,
    autoCastle: true,
    disableContextMenu: true,
    addPieceZIndex: true,
    highlight: {
        lastMove: false,     // disables last move highlighting
        check: true          // keep check highlight if desired
    },
    drawable: {
        enabled: false       // disables green drawing/highlighting of squares
    },
    movable: {
        showDests: false     // 💥 disables the green dots (legal moves)
    }
}
