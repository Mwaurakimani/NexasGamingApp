import {usePage} from "@inertiajs/vue3";
import axios from "axios";
import {ref} from "vue";

export const boardAPI = ref(null);
export const mode = ref('checkmate'); // default mode
const moveInterval = ref(null);

const scenarios = {
    checkmate: [
        {from: 'f2', to: 'f3'},   // Weak move
        {from: 'e7', to: 'e5'},   // Standard
        {from: 'g2', to: 'g4'},   // Another mistake
        {from: 'd8', to: 'h4'},   // ✅ Checkmate by queen!
    ],
    stalemate: [
        {from: 'e2', to: 'e3'}, // White frees king
        {from: 'a7', to: 'a5'}, // Black pawn
        {from: 'd1', to: 'h5'}, // Queen aggressive
        {from: 'h7', to: 'h5'}, // Black pawn push
        {from: 'h2', to: 'h4'}, // White h4 push
        {from: 'a8', to: 'a6'}, // Black rook to a6
        {from: 'h5', to: 'h4'}, // Black captures pawn
        {from: 'h1', to: 'h3'}, // White rook joins
        {from: 'h4', to: 'h3'}, // Black captures again
        {from: 'g2', to: 'h3'}, // White recaptures
        {from: 'a6', to: 'h6'}, // Black rook swings
        {from: 'h3', to: 'h4'}, // White pawn threatens
        {from: 'h6', to: 'h5'}, // Black rook back
        {from: 'h4', to: 'h5'}, // White pawn takes rook
        {from: 'g7', to: 'g5'}, // Black pawn
        {from: 'h5', to: 'g5'}, // White captures
        {from: 'f7', to: 'f6'}, // Black last move
        {from: 'g5', to: 'g6'}, // White pushes
        {from: 'e8', to: 'f7'}, // Black king moves
        {from: 'g6', to: 'g7'}, // White pawn advances
        {from: 'f7', to: 'g8'}, // King squeezed
        {from: 'g7', to: 'g8', capture: {role: 'king', color: 'black'}}, // White pawn captures King? (Optional if needed)
    ],
    draw: [
        {from: 'g1', to: 'f3'},
        {from: 'g8', to: 'f6'},
        {from: 'f3', to: 'g1'},
        {from: 'f6', to: 'g8'},
        {from: 'g1', to: 'f3'},
        {from: 'g8', to: 'f6'},
        {from: 'f3', to: 'g1'},
        {from: 'f6', to: 'g8'},
    ],
};

export function simulateMovesForMode(modeType) {
    let moves = scenarios[modeType];
    let moveIndex = 0;

    moveInterval.value = setInterval(() => {
        if (moveIndex >= moves.length) {
            clearInterval(moveInterval.value);
            console.log('✅ All moves simulated.');
            return;
        }

        const move = moves[moveIndex];
        console.log('♟️ Simulating move:', move);

        if (boardAPI.value) {
            boardAPI.value.move(move);
        }

        moveIndex++;
    }, 3000);
}

export const Config = {
    coordinates: true,
    autoCastle: true,
    disableContextMenu: true,
    addPieceZIndex: true,
    highlight: {
        lastMove: false,
        check: true,
    },
    drawable: {
        enabled: false,
    },
    movable: {
        showDests: false,
    },
    events: {
        boardCreated(api) {
            boardAPI.value = api;
            simulateMovesForMode(mode.value);
        },
        move(from, to, capture) {
            const props = usePage().props;

            const action = JSON.stringify({
                from,
                to,
                capture,
            });

            axios.post(route('moveChessPiece', [props.match.id]), {
                action,
            }).then(response => {
                console.log('✅ Move sent:', response.data);
            }).catch(error => {
                console.error('❌ Move sending error:', error);
            });
        },
    }
};


export const checkmate = () => {
    alert('♔ Checkmate!');
    clearInterval(moveInterval.value);
}
export const stalemate = () => {
    alert('♔ Stalemate!');
    clearInterval(moveInterval.value);
}
export const draw = () => {
    alert('♔ Draw!');
    clearInterval(moveInterval.value);
}

