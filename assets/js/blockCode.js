document.addEventListener("keydown", function(event) {
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

document.addEventListener("visibilitychange", function() {
    if (document.hidden) {
        alert("Detectamos que você mudou de aba! Ação não permitida.");
    }
});

setInterval(() => {
    console.clear();
}, 1000);

setInterval(function () {
    let widthDiff = window.outerWidth - window.innerWidth;
    let heightDiff = window.outerHeight - window.innerHeight;

    if (widthDiff > 100 || heightDiff > 100) {
        document.body.innerHTML = "<h1 style='color: red; text-align: center;'>Acesso não autorizado!</h1>";
        document.body.style.pointerEvents = "none"; 
        alert("DevTools detectado! Página bloqueada.");
    }
}, 2000);

function detectDevTools() {
    setInterval(function () {
        const before = new Date();
        debugger;
        const after = new Date();
        
        if (after - before > 100) {
            document.body.innerHTML = "<h1 style='color: red; text-align: center;'>Acesso não autorizado!</h1>";
            document.body.style.pointerEvents = "none"; 
            alert("DevTools detectado! Página bloqueada.");
        }
    }, 2000);
}

detectDevTools();
