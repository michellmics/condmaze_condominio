document.addEventListener("keydown", function(event) {
    // Bloquear teclas que abrem as DevTools e o menu de contexto
    if (event.key === "F12" || 
        (event.ctrlKey && event.shiftKey && event.key === "I") || 
        (event.ctrlKey && event.shiftKey && event.key === "J") || 
        (event.ctrlKey && event.key === "U") || 
        (event.ctrlKey && (event.key === "S" || event.key === "P"))) {
        event.preventDefault();
    }
});

document.addEventListener("contextmenu", function(event) {
    event.preventDefault();
});

document.addEventListener("dragstart", function(event) {
    event.preventDefault();
});

// Monitorar a visibilidade da página
document.addEventListener("visibilitychange", function() {
    if (document.hidden) {
        alert("Detectamos que você mudou de aba! Ação não permitida.");
    }
});

setInterval(() => {
    console.clear();
}, 1000);

// Verificar a diferença entre outerWidth e innerWidth
let checkDevTools = setInterval(function () {
    let widthDiff = window.outerWidth - window.innerWidth;
    let heightDiff = window.outerHeight - window.innerHeight;

    // Somente ativar o bloqueio se a diferença for significativa
    if (widthDiff > 150 || heightDiff > 150) {
        document.body.innerHTML = "<h1 style='color: red; text-align: center;'>Acesso não autorizado!</h1>";
        document.body.style.pointerEvents = "none"; 
        alert("DevTools detectado! Página bloqueada.");
    }
}, 2000);

// Detecção mais precisa de DevTools com debugger
function detectDevTools() {
    let before = new Date();
    setInterval(function () {
        debugger;  // Usar o debugger para detectar se as DevTools estão abertas
        let after = new Date();
        
        // Somente se a pausa no debugger for maior que um intervalo esperado
        if (after - before > 100) {
            document.body.innerHTML = "<h1 style='color: red; text-align: center;'>Acesso não autorizado!</h1>";
            document.body.style.pointerEvents = "none"; 
            alert("DevTools detectado! Página bloqueada.");
        }
    }, 2000);
}

detectDevTools();
