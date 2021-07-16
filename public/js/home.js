$(document).ready(function() {
    document.getElementById("wrap").addEventListener("scroll", function(){
        let translate = "translateY(-1px)";
        this.querySelector("thead").style.transform = translate;
    });

    let date = document.getElementsByClassName("match_date");
    for (let x = 0; x < date.length; x++) {
        let spl = date[x].innerText.split("-");
        let result = spl[2] + "." + spl[1];
        date[x].innerText = result;
    }
});
