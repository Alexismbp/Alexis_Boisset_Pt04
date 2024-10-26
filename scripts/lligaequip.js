// Alexis Boisset
// Equipos por liga
const equipsPerLiga = {
    "LaLiga": [
        "FC Barcelona", "Real Madrid", "Atlético de Madrid", "Sevilla FC", "Valencia CF", "Villarreal CF",
        "Athletic Club", "Girona FC", "Real Sociedad", "Real Betis", "Rayo Vallecano", "Celta de Vigo",
        "CA Osasuna", "RCD Mallorca", "UD Almería", "Getafe CF", "UD Las Palmas", "Deportivo Alavés", "Granada CF"
    ],
    "Premier League": [
        "Manchester United", "Manchester City", "Chelsea", "Liverpool", "Arsenal", "Tottenham",
        "Leicester City", "West Ham United", "Everton", "Wolverhampton", "Newcastle United",
        "Southampton", "Aston Villa", "Crystal Palace", "Brighton", "Burnley", "Brentford", "Sheffield United"
    ],
    "Ligue 1": [
        "Paris Saint-Germain", "Olympique Lyonnais", "Olympique de Marseille", "AS Monaco", "Lille OSC",
        "Stade Rennais", "OGC Nice", "RC Strasbourg", "Montpellier HSC", "Stade de Reims"
    ]
};


// Función que actualiza los equipos según la liga seleccionada
function actualitzarEquips(vista, equipEscollit, lliga) {
    
    const ligaSelect = document.getElementById("lliga");
    const equipLocal = document.getElementById("equip_local");
    const equipVisitant = document.getElementById("equip_visitant");
    const equipSelect = document.getElementById("equip");

   
    const ligaSeleccionada = ligaSelect.value;

    if (vista == "registrar") {

        // Limpiar las opciones del select de equipos
        equipSelect.innerHTML = '<option value="">-- Selecciona el teu equip favorit --</option>';

        // Agregar nuevos equipos según la liga seleccionada
        if (ligaSeleccionada && equipsPerLiga[ligaSeleccionada]) {
            equipsPerLiga[ligaSeleccionada].forEach(function (equip) {
                const option = document.createElement("option");
                option.value = equip;
                option.selected = true;
                option.text = equip;

                if (equipEscollit === equip) {
                    option.selected = true;
                } else {
                    option.selected = false;
                }

                equipSelect.appendChild(option);
            })
        }

    } else if (vista == "crear") {
        // Limpiar las opciones del select de equipos
        equipLocal.innerHTML = '<option value="">-- Selecciona el teu equip favorit --</option>';
        equipVisitant.innerHTML = '<option value="">-- Selecciona el teu equip favorit --</option>';

        // Agregar nuevos equipos según la liga seleccionada
        if (ligaSeleccionada && equipsPerLiga[ligaSeleccionada]) {
            equipsPerLiga[ligaSeleccionada].forEach(function (equip) {
                const optionLocal = document.createElement("option");
                const optionVisitant = document.createElement("option");
                optionLocal.value = equip;
                optionVisitant.value = equip;
                optionLocal.text = equip;
                optionVisitant.text = equip;
                equipLocal.appendChild(optionLocal);
                equipVisitant.appendChild(optionVisitant);
            });
        }
    }
}


