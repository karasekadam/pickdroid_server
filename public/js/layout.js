console.log("som tu");
// funkce vyhledávacího tlačíka
function search_site() {
    name = document.getElementById("search").value
    window.location.replace(window.location.origin + "/?search=" + name); //
}

$(document).ready(function() {
    $("#menu-toggle").click(function() {
        $("#menu").slideToggle();
    });


    $(".doToggle").click(function() {
        value = $(this).attr("id");
        $(".sub_"+value).slideToggle();
    });

    $("#logout_btn").click(function() {
        $("#logout").submit();
    });

    let search = document.getElementById("search");
    let search_mob = document.getElementById("search_mob");
    window.search = search; // Put the element in window so we can access it easily later
    search.autocomplete = "off"; // Disable browser autocomplete

    // ajax dotaz k searchboxu na keyup
    $('#search').on('keyup', search_func(search));
    $('#search_mob').on('keyup', search_func(search_mob)); // proč to tady je??? zakomentované search pořád funguje

    function search_func(elem) {
        return function(e) {
            $value=$(this).val();
            $.ajax({
                type : 'get',
                url : "search_match",
                //url : window.location.origin + 'search_match',
                data:{'search':$value},
                success:function(data){
                    console.log("file: " + window.location);
                    console.log("file: " + window.location.origin);
                    console.log("file: " + this.url);
                    let selector = document.getElementById("selector");
                    // Check if input is empty
                    if (elem.value.trim() !== "") {
                        elem.classList.add("dropdown"); // Add dropdown class (for the CSS border-radius)
                        // If the selector div element does not exist, create it
                        if (selector == null) {
                            selector = document.createElement("div");
                            selector.id = "selector";
                            elem.parentNode.appendChild(selector);
                            // Position it below the input element
                            selector.style.left = elem.getBoundingClientRect().left + "px";
                            selector.style.top = elem.getBoundingClientRect().bottom + "px";
                            selector.style.width = elem.getBoundingClientRect().width + "px";
                        }
                        // Clear everything before new search
                        selector.innerHTML = "";
                        // Variable if result is empty
                        let empty = true;
                        for (let item in data) {
                            // vytvoří link pro každý výsledek, který dostal od serveru
                            let opt = document.createElement("a");
                            //opt.setAttribute("href", "http://www.dangrb.dreamhosters.com/?id=" + data[item].id + "'");
                            opt.setAttribute("href", window.location.origin + "/?id=" + data[item].id + "'");
                            str = data[item].team1 + " - " + data[item].team2;
                            opt.innerHTML = str;
                            selector.appendChild(opt);
                            empty = false;
                        }
                        // If result is empty, display a disabled button with text
                        if (empty == true) {
                            let opt = document.createElement("div");
                            opt.disabled = true;
                            opt.innerHTML = "No results";
                            selector.appendChild(opt);
                        }
                    }
                    // Remove selector element if input is empty
                    else {
                        if (selector !== null) {
                            selector.parentNode.removeChild(selector);
                            elem.classList.remove("dropdown");
                        }
                    }
                }
            });
        };
    }
})

// funkce zajišťující filter
function content_filter(hours) {
    // vytvoří ajax dotaz
    let xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function() {
        // funkce obstarávající odpověď dotazu
        if (this.readyState == 4 && this.status == 200) {
            let myArr = JSON.parse(this.responseText);
            let output = ""
            for (let i = 0; i < myArr.length; i++) {
                let date = myArr[i].date.split("-")
                let match_time = new Date(parseInt(date[0]), parseInt(date[1]) - 1, parseInt(date[2]), parseInt((myArr[i].time)) ? (myArr[i].time) : 0);
                let now = new Date();
                let until = new Date(now.getTime() + hours*3600000);
                if (hours !== "0" && match_time > until) {
                    continue;
                }
                let format = date[2] + "." + date[1]
                output +=
                    '<tr>' +
                    '<td class="date d-none d-md-table-cell align-middle pl-4"><img src="img/logo/' + myArr[i].team1 + '.png" class="web_logo">' + myArr[i].team1 +'<br>\n' +
                    '<img src="img/logo/' + myArr[i].team2 +'.png" class="web_logo">' + myArr[i].team2 + '<br>' +
                    '<span class="match_date pl-1" style="font-size: 85%">' + format + '</span><span style="font-size: 85%">, 11:11</span>' +
                    '<img src="img/logo/' + myArr[i].league + '.png" style="width: 15px; height: 15px"></td>' +
                    '<td class="match d-md-none pt-1 pb-1"><img src="img/logo.png" class="mob_logo">' + myArr[i].team1 + '<br><img src="img/logo.png" class="mob_logo">' + myArr[i].team2 + '<br><span class="match_date">' + format + '</span>, 11:11</td>' +
                    '<td class="rate text-center align-md-middle"><div class="rate_pad font-weight-light"><b>' + myArr[i].prob1 +'<br>1.11</b></div></td>' +
                    '<td class="rate text-center align-md-middle"><div class="rate_pad font-weight-light"><b>' + myArr[i].probtie +'<br>1.11</b></div></td>' +
                    '<td class="rate text-center align-md-middle"><div class="rate_pad font-weight-light"><b>' + myArr[i].prob2 +'<br>1.11</b></div></td>' +
                    '</tr>'
                    /*
                    '<tr> <td class="date d-none d-md-table-cell align-middle pl-4"><span class="match_date">' + format + '</span><br>11:11</td>' +
                    '<td class="match d-none d-md-table-cell align-middle pt-1 pb-1"><img src="img/logo/' + myArr[i].team1 + '.png" class="web_logo" alt="logo týmu">' + myArr[i].team1 +' - <img src="img/logo/' + myArr[i].team2 + '.png" class="web_logo" alt="logo týmu">' + myArr[i].team2 +'</td>' +
                    '<td class="match d-md-none pt-1 pb-1"><img src="img/logo/' + myArr[i].team1 + '.png" class="mob_logo" alt="logo týmu">' + myArr[i].team1 +'<br><img src="img/logo/' + myArr[i].team2 + '.png" class="mob_logo" alt="logo týmu">' + myArr[i].team2 +'<br><span class="match_date">' + format +'</span>, 11:11</td>' +
                    '<td class="league d-none d-md-table-cell align-middle"><img src="img/logo/' + myArr[i].league + '.png" class="web_logo ml-3" alt="logo ligy"></td>' +
                    '<td class="rate text-center align-md-middle"><div class="rate_pad"><b>' + myArr[i].prob1 +'<br>1.11</b></div></td>' +
                    '<td class="rate text-center align-md-middle"><div class="rate_pad"><b>' + myArr[i].probtie +'<br>1.11</b></div></td>' +
                    '<td class="rate text-center align-md-middle"><div class="rate_pad"><b>' + myArr[i].prob2 +'<br>1.11</b></div></td></tr>'
                    */
                }
            if (output === "") {
                output = "There are no matches within these hours <br> Wanna go back to all? <button style='background-color: #ffdf1b; border-radius: 10px;' onclick=\"content_filter('0')\">all</button>";
            }
            document.getElementsByTagName("tbody")[0].innerHTML = output;
        }
    };
    let href = window.location.href.split("/");
    let last = href[href.length - 1];
    xhttp.open("GET", href[0] + "/search_match_filter" + last, true);
    xhttp.send();
}
