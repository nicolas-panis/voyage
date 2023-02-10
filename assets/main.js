let btnMobile = document.getElementById('button-nav');
let crossNav = document.getElementById('cross-nav');

function show(){
    let sidebar = document.getElementById('sidebar');
    if(sidebar.style.display === "none"){
        sidebar.style.display = "block";
    }
}
btnMobile.onclick = show;

function hidde(){
    let sidebar = document.getElementById('sidebar');
    if(sidebar.style.display === "block"){
        sidebar.style.display = "none";
    }
}
crossNav.onclick = hidde;

