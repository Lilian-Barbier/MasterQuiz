function AddReponseForm() {

    numeroQuestion++;

    //Création d'un élement TextBox
    var text = document.createElement("input");
    text.type="text";
    text.className="form-control col-sm-8";
    text.placeholder = "Réponse " + numeroQuestion;
    text.id = "InputReponse" + numeroQuestion;
    text.name = "InputReponse" + numeroQuestion;
    
    //Création d'un élement RadioButton
    var radio = document.createElement("input");
    radio.type = "radio";
    radio.name="radioReponse";
    radio.value=numeroQuestion;

    var label = document.createElement("label");
    label.className = "col-sm-4";
    label.innerHTML = "Bonne Réponse";   
    label.appendChild(radio);
    
    var div = document.createElement("div");
    div.className = "row";
    div.appendChild(text);
    div.appendChild(label);

    document.getElementById("reponses").appendChild(div);

    document.getElementById("nbReponse").value = numeroQuestion;
    

}

window.onload = function() {
    document.getElementById("AddReponse").onclick = function(){AddReponseForm()};
    numeroQuestion = document.getElementById("nbReponse").value;
}
