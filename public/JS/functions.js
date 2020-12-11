// if Student bei Rolle ist ausgewählt Matrikelnummer kann benutzt werden
function showMatrikel(){
    let student = document.getElementById("rollen").value;
    if(student == "student")
        document.getElementById("matrikelnummer").removeAttribute("disabled");
    else
        document.getElementById("matrikelnummer").setAttribute("disabled","");
}
/*
// Überprüft ob Rolle ausgewählt wurde wenn nicht => Submit Button disabled
function CheckRolle(){
    let check = document.getElementById("rollen");
    let button = document.getElementById("addPerson");

    console.log("hallo");
    if (check.value == "") {
        document.getElementById("addPerson").setAttribute("disabled", "");
        button.style.opacity = 0.5;
    }
    else{
        document.getElementById("addPerson").removeAttribute("disabled");
        button.style.opacity = 1;
    }
}
*/
/* Überprüft ob es eine CSV Datei ist wenn nicht akzeptiert */
function checkType(Name){
    var fileName = document.getElementById(Name).value;
    let extension = fileName.substring(fileName.lastIndexOf('.') + 1);

    if(extension != "csv"){
        document.getElementById(Name).value = "";
        alert("Keine CSV Datei");
    }
}

function myFunction(elem, elem2) {
   // CheckRolle();
    //console.log(elem2);
    //console.log(String(arguments[0]));

    var x = elem;
    var divs = document.querySelectorAll('body');
    if (window.getComputedStyle(x).visibility === "hidden") {
        for (var index = 0 ; index < divs.length; index++) {
            // divs[index].style.transition = "0.2s";
            divs[index].style.visibility = "hidden";
        }
        x.style.visibility = "visible";
    } else {
        for (var index = 0 ; index < divs.length; index++) {
            divs[index].style.visibility = "visible";
        }
        x.style.visibility = "hidden";
    }
}
